<?php

namespace Ecjia\App\Orders\OrderOperate;


use ecjia;
use Ecjia\System\Notifications\OrderShipped;
use ecjia_admin;
use ecjia_error;
use ecjia_front;
use ecjia_region;
use order_stork;
use RC_Api;
use RC_DB;
use RC_Http;
use RC_Loader;
use RC_Mail;
use RC_Model;
use RC_Notification;
use RC_Time;

class ConfirmedO2oAndEcjiaAutoShipping
{

    /**
     * 商家配送和众包配送订单，商家有开启接单自动发货，则接单后自动发货
     * @param $order_id
     * @return bool | ecjia_error
     */
    public static function o2o_ecjia_auto_ship($order_id)
    {
     	$order = RC_DB::table('order_info')->where('order_id', $order_id)->first();
    
     	if (!empty($order)) {
            $shipping_info = RC_DB::table('shipping')->where('shipping_id', $order['shipping_id'])->first();
            $confirm_auto_ship = \Ecjia\App\Cart\StoreStatus::StoreConfirmOrdersAutoShip($order['store_id']);
            if (in_array($shipping_info['shipping_code'], ['ship_o2o_express', 'ship_ecjia_express']) && !empty($confirm_auto_ship) && $order['extension_code'] !='group_buy') {

                /*检查订单商品是否存在或已移除到回收站*/
                $order_goods_ids = RC_DB::table('order_goods')->where('order_id', $order_id)->select(RC_DB::raw('goods_id'))->get();
                foreach ($order_goods_ids as $key => $val) {
                    $goods_info = RC_DB::table('goods')->where('goods_id', $val['goods_id'])->first();
                    $goods_name = $goods_info['goods_name'];
                    if (empty($goods_info)) {
                        return new ecjia_error('goods_deleted', __('此订单包含的商品已被删除，请核对后再发货！', 'orders'));
                    }
                    if ($goods_info['is_delete'] == 1) {
                        return new ecjia_error('goods_trashed', sprintf(__('此订单包含的商品【%s】已被移除到了回收站，请核对后再发货！', 'orders'), $goods_name));
                    }
                }

                /* 查询：取得订单商品 */
                $_goods = self::get_order_goods(array('order_id' => $order['order_id'], 'order_sn' => $order['order_sn']));

                $attr       = $_goods['attr'];
                $goods_list = $_goods['goods_list'];

                $send_number = [];
                /* 查询：商品已发货数量 此单可发货数量 */
                if ($goods_list) {
                    foreach ($goods_list as $key => $goods_value) {
                        if (!$goods_value['goods_id']) {
                            continue;
                        }
                        $send_number[$goods_value['rec_id']] = $goods_value['goods_number'] - $goods_value['send_number'];

                        /* 是否缺货 */
                        if ($goods_value['storage'] <= 0 && ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_SHIP) {
                            $send_number[$goods_value['rec_id']] = __('商品已缺货', 'orders');
                        } elseif ($send_number[$goods_value['rec_id']] <= 0) {
                            $send_number[$goods_value['rec_id']] = __('货已发完', 'orders');
                        }
                    }
                }

                array_walk($send_number, 'trim_array_walk');
                array_walk($send_number, 'intval_array_walk');


                /* 订单是否已全部分单检查 */
                if ($order['order_status'] == OS_SPLITED) {
                    /* 操作失败 */
                    $os_label = __('已分单', 'orders');
                    $ss_label = __('发货中', 'orders');
                    return new ecjia_error('order_shipping', sprintf(__('您的订单%s，%s正在%s，%s', 'orders'), $order['order_sn'], $os_label, $ss_label, ecjia::config('shop_name')));
                }


                /* 检查此单发货数量填写是否正确 合并计算相同商品和货品 */
                if (!empty($send_number) && !empty($goods_list)) {
                    $goods_no_package = array();
                    foreach ($goods_list as $key => $value) {
                        /* 去除 此单发货数量 等于 0 的商品 */
                        if (!isset($value['package_goods_list']) || !is_array($value['package_goods_list']) || empty($value['package_goods_list'])) {
                            // 如果是货品则键值为商品ID与货品ID的组合
                            $_key = empty($value['product_id']) ? $value['goods_id'] : ($value['goods_id'] . '_' . $value['product_id']);

                            // 统计此单商品总发货数 合并计算相同ID商品或货品的发货数
                            if (empty($goods_no_package[$_key])) {
                                $goods_no_package[$_key] = $send_number[$value['rec_id']];
                            } else {
                                $goods_no_package[$_key] += $send_number[$value['rec_id']];
                            }

                            //去除
                            if ($send_number[$value['rec_id']] <= 0) {
                                unset($send_number[$value['rec_id']], $goods_list[$key]);
                                continue;
                            }
                        }

                        /* 发货数量与总量不符 */
                        if (!isset($value['package_goods_list']) || !is_array($value['package_goods_list']) || empty($value['package_goods_list'])) {
                            $sended = self::order_delivery_num($order_id, $value['goods_id'], $value['product_id']);
                            if (($value['goods_number'] - $sended - $send_number[$value['rec_id']]) < 0) {
                                /* 操作失败 */
                                return new ecjia_error('send_number_error', __('此单发货数量不能超出订单商品数量', 'orders'));
                            }
                        }
                    }
                }

                /* 对上一步处理结果进行判断 兼容 上一步判断为假情况的处理 */
                if (empty($send_number) || empty($goods_list)) {
                    /* 操作失败 */
                    return new ecjia_error('send_number_error', __('发货数量或商品不能为空', 'orders'));
                }

                /* 检查此单发货商品库存缺货情况 */
                /* $goods_list已经过处理 超值礼包中商品库存已取得 */
                $virtual_goods         = array();
                $package_virtual_goods = array();
                foreach ($goods_list as $key => $value) {
                    // 商品（实货）、（货品）
                    //如果是货品则键值为商品ID与货品ID的组合
                    $_key = empty($value['product_id']) ? $value['goods_id'] : ($value['goods_id'] . '_' . $value['product_id']);

                    /* （实货） */
                    if (empty($value['product_id'])) {
                        $num = RC_DB::table('goods')->where('goods_id', $value['goods_id'])->value('goods_number');
                    } else {
                        /* （货品） */
                        $num = RC_DB::table('products')->where('goods_id', $value['goods_id'])->where('product_id', $value['product_id'])->value('product_number');
                    }

                    if (($num < $goods_no_package[$_key]) && ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_SHIP) {
                        /* 操作失败 */
                       return new ecjia_error('goods_out_of_stock', sprintf(__('商品 %s 已缺货', 'orders'), $value['goods_name']));
                    }
                }

                //生成发货单
                $delivery_id = self::insert_delivery_order($order);

                //发货单商品录入
                if (!empty($delivery_id)) {
                    $res = self::insert_delivery_goods($delivery_id, $goods_list, $send_number);
                }

                unset($filter_fileds, $delivery, $_delivery, $order_finish);

                //订单信息更新处理
                $order_status_res = self::update_order_status_and_order_goods($order, $send_number, $_goods, $goods_list);

                //商品库存处理
                $stock_res = self::process_stock($delivery_id);

                /* 修改发货单信息 */
                $invoice_no = self::get_invoice_no($order);
                $delivery_order_update = [
                    'invoice_no' => $invoice_no,
                    'status'    => 0
                ];

                RC_DB::table('delivery_order')->where('delivery_id', $delivery_id)->update($delivery_order_update);

                $data = array(
                    'order_status' => __('已发货', 'orders'),
                    'message'      => sprintf(__('订单号为 %s 的商品已发货，请您耐心等待', 'orders'), $order['order_sn']),
                    'order_id'     => $order_id,
                    'add_time'     => RC_Time::gmtime(),
                );
                RC_DB::table('order_status_log')->insert($data);

                /* 标记订单为已确认 “已发货” */
                /* 更新发货时间 */
                $order_finish           = self::get_all_delivery_finish($order_id);

                $shipping_status        = ($order_finish == 1) ? SS_SHIPPED : SS_SHIPPED_PART;
                $arr['shipping_status'] = $shipping_status;
                $arr['shipping_time']   = RC_Time::gmtime(); // 发货时间
                $arr['invoice_no']      = $invoice_no;

                //更新发货单表invoice_no
                RC_DB::table('delivery_order')->where('delivery_id', $delivery_id)->update(['invoice_no' => $arr['invoice_no']]);

                update_order($order_id, $arr);
                /* 记录日志 */
                //ecjia_merchant::admin_log(sprintf(__('发货，订单号是%s', 'orders'), $order['order_sn']), 'setup', 'order');
                /* 发货单发货记录log */
                self::order_action($order['order_sn'], OS_CONFIRMED, $shipping_status, $order['pay_status'], '接单自动发货', $_SESSION['staff_name'], 1);

                //发货单信息
                $delivery_order = RC_DB::table('delivery_order')->where('delivery_id', $delivery_id)->first();

                //生成配送单
                $express_id = self::generate_express_order($delivery_order, $shipping_info);

                /*配送单生成后，自动派单。只有订单配送方式是众包配送和商家配送时才去自动派单*/
                $assign_res = self::auto_assign_express_order($express_id, $shipping_info, $order);

                /* 如果是o2o速递则在 ecjia_express_track_record表内更新一条记录*/
                $track_res = self::insert_express_track_record($shipping_info, $delivery_order);

                /* 如果当前订单已经全部发货 */
                $finish_res = self::after_order_finish_process($order_id, $order_finish);
            }
        }

        return true;
    }
    
    
    
    /**
     * 取得订单商品
     * @param   array $order 订单数组
     * @return array
     */
    private static function get_order_goods($order)
    {
    	$goods_list = array();
    	$goods_attr = array();
    	$data       = RC_DB::table('order_goods as o')->leftJoin('products as p', RC_DB::raw('p.product_id'), '=', RC_DB::raw('o.product_id'))
    	->leftJoin('goods as g', RC_DB::raw('o.goods_id'), '=', RC_DB::raw('g.goods_id'))
    	->leftJoin('brand as b', RC_DB::raw('g.brand_id'), '=', RC_DB::raw('b.brand_id'))
    	->select(RC_DB::raw('o.*'), RC_DB::raw('g.suppliers_id AS suppliers_id'), RC_DB::raw("IF(o.product_id > 0, p.product_number, g.goods_number) AS storage"), RC_DB::raw('o.goods_attr'), RC_DB::raw("IFNULL(b.brand_name, '') AS brand_name"), RC_DB::raw('p.product_sn'))
    	->where(RC_DB::raw('o.order_id'), $order['order_id'])->get();
    	$goods_list = array();
    	if (!empty($data)) {
    		foreach ($data as $key => $row) {
    			$row['formated_subtotal']    = price_format($row['goods_price'] * $row['goods_number']);
    			$row['formated_goods_price'] = price_format($row['goods_price']);
    			$goods_attr[]                = explode(' ', trim($row['goods_attr']));
    			//将商品属性拆分为一个数组
    			if ($row['extension_code'] == 'package_buy') {
    				$row['storage']            = '';
    				$row['brand_name']         = '';
    				$row['package_goods_list'] = [];
    			}
    			//处理货品id
    			$row['product_id'] = empty($row['product_id']) ? 0 : $row['product_id'];
    			$goods_list[]      = $row;
    		}
    	}
    	$attr = array();
    	$arr  = array();
    	if (!empty($goods_attr)) {
    		foreach ($goods_attr as $index => $array_val) {
    			foreach ($array_val as $value) {
    				$arr = explode(':', $value);
    				//以 : 号将属性拆开
    				$attr[$index][] = @array('name' => $arr[0], 'value' => $arr[1]);
    			}
    		}
    	}
    	return array('goods_list' => $goods_list, 'attr' => $attr);
    }

    /**
     * 生成发货单
     * @param $order
     * @return mixed
     */
    private static function insert_delivery_order($order)
    {
        $data = array(
            'order_sn'      => $order['order_sn'],
            'add_time'      => $order['order_time'],
            'user_id'       => $order['user_id'],
            'how_oos'       => $order['how_oos'],
            'shipping_id'   => $order['shipping_id'],
            'shipping_fee'  => $order['shipping_fee'],
            'consignee'     => $order['consignee'],
            'address'       => $order['address'],
            'country'       => $order['country'],
            'province'      => $order['province'],
            'city'          => $order['city'],
            'district'      => $order['district'],
            'street'        => $order['street'],
            'sign_building' => $order['sign_building'],
            'email'         => $order['email'],
            'mobile'        => $order['mobile'],
            'best_time'     => $order['best_time'],
            'postscript'    => $order['postscript'],
            'insure_fee'    => $order['insure_fee'],
            'agency_id'     => $order['agency_id'],
            'shipping_name' => $order['shipping_name'],
        );
        array_walk($data, 'trim_array_walk');
        $delivery = $data;



        $delivery['user_id']      = intval($delivery['user_id']);
        $delivery['country']      = trim($delivery['country']);
        $delivery['province']     = trim($delivery['province']);
        $delivery['city']         = trim($delivery['city']);
        $delivery['district']     = trim($delivery['district']);
        $delivery['street']       = trim($delivery['street']);
        $delivery['agency_id']    = intval($delivery['agency_id']);
        $delivery['insure_fee']   = floatval($delivery['insure_fee']);
        $delivery['shipping_fee'] = floatval($delivery['shipping_fee']);

        /* 生成发货单 */
        /* 获取发货单号和流水号 */
        $delivery['delivery_sn'] = ecjia_order_delivery_sn();
        $delivery_sn             = $delivery['delivery_sn'];
        /* 获取当前操作员 */
        $delivery['action_user'] = !empty($_SESSION['staff_name']) ? $_SESSION['staff_name'] : '接单自动发货';
        /* 获取发货单生成时间 */
        $delivery['update_time'] = RC_Time::gmtime();
        $delivery_time           = $delivery['update_time'];

        $delivery['add_time'] = RC_Time::gmtime();

        /* 获取发货单所属供应商 */
        $delivery['suppliers_id'] = 0;
        /* 设置默认值 */
        $delivery['status']   = 2; // 正常
        $delivery['order_id'] = $order['order_id'];

        /*地区经纬度赋值*/
        $delivery['longitude'] = $order['longitude'];
        $delivery['latitude']  = $order['latitude'];
        /* 期望送货时间*/
        $delivery['best_time'] = $order['expect_shipping_time'];

        if (empty($delivery['longitude']) || empty($delivery['latitude'])) {
            $province_name = ecjia_region::getRegionName($delivery['province']);
            $city_name     = ecjia_region::getRegionName($delivery['city']);
            $district_name = ecjia_region::getRegionName($delivery['district']);
            $street_name   = ecjia_region::getRegionName($delivery['street']);

            $consignee_address = '';
            if (!empty($province_name)) {
                $consignee_address .= $province_name;
            }
            if (!empty($city_name)) {
                $consignee_address .= $city_name;
            }
            if (!empty($district_name)) {
                $consignee_address .= $district_name;
            }
            if (!empty($street_name)) {
                $consignee_address .= $street_name;
            }
            $consignee_address .= $delivery['address'];
            $consignee_address = urlencode($consignee_address);

            //腾讯地图api 地址解析（地址转坐标）
            $key        = ecjia::config('map_qq_key');
            $shop_point = RC_Http::remote_get("https://apis.map.qq.com/ws/geocoder/v1/?address=" . $consignee_address . "&key=" . $key);
            $shop_point = json_decode($shop_point['body'], true);
            if (isset($shop_point['result']) && !empty($shop_point['result']['location'])) {
                $delivery['longitude'] = $shop_point['result']['location']['lng'];
                $delivery['latitude']  = $shop_point['result']['location']['lat'];
            }
        }

        /* 过滤字段项 */
        $filter_fileds = array(
            'order_sn', 'add_time', 'user_id', 'how_oos', 'shipping_id', 'shipping_fee',
            'consignee', 'address', 'longitude', 'latitude', 'country', 'province', 'city', 'district', 'street', 'sign_building',
            'email', 'zipcode', 'tel', 'mobile', 'best_time', 'postscript', 'insure_fee',
            'agency_id', 'delivery_sn', 'action_user', 'update_time',
            'suppliers_id', 'status', 'order_id', 'shipping_name',
        );
        $_delivery     = array();
        foreach ($filter_fileds as $value) {
            $_delivery[$value] = $delivery[$value];
        }

        $_delivery['store_id'] = intval($order['store_id']);

        /* 发货单入库 */
        $delivery_id = RC_DB::table('delivery_order')->insertGetId($_delivery);

        if ($delivery_id) {
            $ss_label = __('配货中', 'orders');
            $data     = array(
                'order_status' => $ss_label,
                'order_id'     => $order['order_id'],
                'message'      => sprintf(__('订单号为 %s 的商品正在备货中，请您耐心等待', 'orders'), $order['order_sn']),
                'add_time'     => RC_Time::gmtime(),
            );
            RC_DB::table('order_status_log')->insert($data);
        }

        return $delivery_id;
    }

    /**
     * 订单单个商品或货品的已发货数量
     *
     * @param   int $order_id 订单 id
     * @param   int $goods_id 商品 id
     * @param   int $product_id 货品 id
     *
     * @return  int
     */
    private static function order_delivery_num($order_id, $goods_id, $product_id = 0)
    {
        $db_delivery_goods = RC_DB::table('delivery_goods as dg')->leftJoin('delivery_order as o', RC_DB::raw('o.delivery_id'), '=', RC_DB::raw('dg.delivery_id'));
        if ($product_id > 0) {
            $sum = $db_delivery_goods->whereRaw('o.status = 0 and o.order_id = "' . $order_id . '" and dg.extension_code <> "package_buy" and dg.goods_id = "' . $goods_id . '" and dg.product_id = "' . $product_id . '"')->sum(RC_DB::raw('dg.send_number'));
        } else {
            $sum = $db_delivery_goods->whereRaw('o.status = 0 and o.order_id = "' . $order_id . '" and dg.extension_code <> "package_buy" and dg.goods_id = "' . $goods_id . '"')->sum(RC_DB::raw('dg.send_number'));
        }
        if (empty($sum)) {
            $sum = 0;
        }
        return $sum;
    }

    /**
     * 发货单商品录入
     * @param $delivery_id
     * @param $goods_list
     * @param $send_number
     * @return bool
     */
    private static function insert_delivery_goods($delivery_id, $goods_list, $send_number)
    {

        $delivery_goods = array();
        if (!empty($goods_list)) {
            foreach ($goods_list as $value) {
                // 商品（实货）（虚货）
                if (empty($value['extension_code']) || $value['extension_code'] == 'virtual_card') {
                    $delivery_goods = array(
                        'delivery_id' => $delivery_id,
                        'goods_id'    => $value['goods_id'],
                        'product_id'  => $value['product_id'],
                        'product_sn'  => $value['product_sn'],
                        'goods_id'    => $value['goods_id'],
                        'goods_name'  => addslashes($value['goods_name']),
                        'brand_name'  => addslashes($value['brand_name']),
                        'goods_sn'    => $value['goods_sn'],
                        'send_number' => $send_number[$value['rec_id']],
                        'parent_id'   => 0,
                        'is_real'     => $value['is_real'],
                        'goods_attr'  => addslashes($value['goods_attr']),
                    );

                    /* 如果是货品 */
                    if (!empty($value['product_id'])) {
                        $delivery_goods['product_id'] = $value['product_id'];
                    }
                    RC_DB::table('delivery_goods')->insert($delivery_goods);
                } elseif ($value['extension_code'] == 'package_buy') {
                    // 商品（超值礼包）
                    foreach ($value['package_goods_list'] as $pg_key => $pg_value) {
                        $delivery_pg_goods = array(
                            'delivery_id'    => $delivery_id,
                            'goods_id'       => $pg_value['goods_id'],
                            'product_id'     => $pg_value['product_id'],
                            'product_sn'     => $pg_value['product_sn'],
                            'goods_name'     => $pg_value['goods_name'],
                            'brand_name'     => '',
                            'goods_sn'       => $pg_value['goods_sn'],
                            'send_number'    => $send_number[$value['rec_id']][$pg_value['g_p']],
                            'parent_id'      => $value['goods_id'], // 礼包ID
                            'extension_code' => $value['extension_code'], // 礼包
                            'is_real'        => $pg_value['is_real'],
                        );
                        RC_DB::table('delivery_goods')->insert($delivery_pg_goods);
                    }
                }
            }
        }

        return true;
    }


    /**
     * 更新订单状态和订单商品发货数量
     * @param $order
     * @param $send_number
     * @param $_goods
     * @param $goods_list
     * return bool
     */
    private static function update_order_status_and_order_goods($order, $send_number, $_goods, $goods_list)
    {
        /* 订单信息 */
        $_sended = &$send_number;
        foreach ($_goods['goods_list'] as $key => $value) {
            if ($value['extension_code'] != 'package_buy') {
                unset($_goods['goods_list'][$key]);
            }
        }
        foreach ($goods_list as $key => $value) {
            if ($value['extension_code'] == 'package_buy') {
                unset($goods_list[$key]);
            }
        }
        $_goods['goods_list'] = $goods_list + $_goods['goods_list'];
        unset($goods_list);

        /* 更新订单的非虚拟商品信息 即：商品（实货）（货品）、商品（超值礼包）*/
        self::update_order_goods($order['order_id'], $_sended, $_goods['goods_list']);

        /* 标记订单为已确认 “发货中” */
        /* 更新发货时间 */
        $order_finish    = self::get_order_finish($order['order_id']);
        $shipping_status = SS_SHIPPED_ING;
        if ($order['order_status'] != OS_CONFIRMED && $order['order_status'] != OS_SPLITED && $order['order_status'] != OS_SPLITING_PART) {
            $arr['order_status'] = OS_CONFIRMED;
            $arr['confirm_time'] = GMTIME_UTC;
        }

        $arr['order_status']    = $order_finish ? OS_SPLITED : OS_SPLITING_PART; // 全部分单、部分分单
        $arr['shipping_status'] = $shipping_status;
        $arr['shipping_id']     = $order['shipping_id'];
        $arr['shipping_name']   = $order['shipping_name'];

        RC_DB::table('order_info')->where('order_id', $order['order_id'])->update($arr);

        /* 记录log */
        $action_note =  __('接单自动发货', 'orders');

        self::order_action($order['order_sn'], $arr['order_status'], $shipping_status, $order['pay_status'], $action_note, $_SESSION['staff_name']);

        return true;
    }


    /**
     * 订单中的商品是否已经全部发货
     * @param   int $order_id 订单 id
     * @return  int     1，全部发货；0，未全部发货
     */
    private static function get_order_finish($order_id)
    {
        $db_order_goods = RC_DB::table('order_goods');
        $return_res     = 0;
        if (empty($order_id)) {
            return $return_res;
        }
        $sum = $db_order_goods->where('order_id', $order_id)->whereRaw('goods_number > send_number')->count('rec_id');
        if (empty($sum)) {
            $return_res = 1;
        }
        return $return_res;
    }

    /**
     * 记录订单操作记录
     *
     * @access public
     * @param string $order_sn
     *        	订单编号
     * @param integer $order_status
     *        	订单状态
     * @param integer $shipping_status
     *        	配送状态
     * @param integer $pay_status
     *        	付款状态
     * @param string $note
     *        	备注
     * @param string $username
     *        	用户名，用户自己的操作则为 buyer
     * @return void
     */
    private static function order_action($order_sn, $order_status, $shipping_status, $pay_status, $note = '', $username = null, $place = 0) {
        if (is_null ( $username )) {
            $username = $_SESSION ['staff_name'];
        }

        $order_id = RC_DB::table('order_info')->where('order_sn', $order_sn)->value('order_id');
        $data = array (
            'order_id'           => $order_id,
            'action_user'        => !empty($username) ? $username : '系统操作',
            'order_status'       => $order_status,
            'shipping_status'    => $shipping_status,
            'pay_status'         => $pay_status,
            'action_place'       => $place,
            'action_note'        => $note,
            'log_time'           => RC_Time::gmtime()
        );
        RC_DB::table('order_action')->insert($data);
    }


    private static function process_stock($delivery_id)
    {
        $delivery_stock_result = RC_DB::table('delivery_goods as dg')
            ->leftJoin('goods as g', RC_DB::raw('dg.goods_id'), '=', RC_DB::raw('g.goods_id'))
            ->leftJoin('products as p', RC_DB::raw('dg.product_id'), '=', RC_DB::raw('p.product_id'))
            ->select(RC_DB::raw('dg.goods_id'), RC_DB::raw('dg.is_real'), RC_DB::raw('dg.product_id'), RC_DB::raw('SUM(dg.send_number) AS sums'), RC_DB::raw("IF(dg.product_id > 0, p.product_number, g.goods_number) AS storage"), RC_DB::raw('g.goods_name'), RC_DB::raw('dg.send_number'))
            ->where(RC_DB::raw('dg.delivery_id'), $delivery_id)
            ->groupBy(RC_DB::raw('dg.product_id'))
            ->get();

        if (empty($delivery_stock_result)) {
            $delivery_stock_result = RC_DB::table('delivery_goods as dg')
                ->leftJoin('goods as g', RC_DB::raw('dg.goods_id'), '=', RC_DB::raw('g.goods_id'))
                ->select(RC_DB::raw('dg.goods_id'), RC_DB::raw('dg.is_real'), RC_DB::raw('SUM(dg.send_number) AS sums'), RC_DB::raw('g.goods_number'), RC_DB::raw('g.goods_name'), RC_DB::raw('dg.send_number'))
                ->where(RC_DB::raw('dg.delivery_id'), $delivery_id)
                ->groupBy(RC_DB::raw('dg.goods_id'))
                ->get();
        }
        /* 如果使用库存，且发货时减库存，则修改库存 */
        if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_SHIP) {
            RC_Loader::load_app_class('order_stork', 'orders');
            foreach ($delivery_stock_result as $value) {
                /* 商品（实货）、超级礼包（实货） */
                if ($value['is_real'] != 0) {
                    /* （货品） */
                    if (!empty($value['product_id'])) {
                        $data = array(
                            'product_number' => $value['storage'] - $value['sums'],
                        );
                        RC_DB::table('products')->where('product_id', $value['product_id'])->update($data);
                    } else {
                        $data = array(
                            'goods_number' => $value['storage'] - $value['sums'],
                        );
                        RC_DB::table('goods')->where('goods_id', $value['goods_id'])->update($data);
                        //发货警告库存发送短信
                        order_stork::sms_goods_stock_warning($value['goods_id']);
                    }
                }
            }
        }
    }


    /**
     * 判断订单的发货单是否全部发货
     * @param   int $order_id 订单 id
     * @return  int     1，全部发货；0，未全部发货；-1，部分发货；-2，完全没发货；
     */
    private static function get_all_delivery_finish($order_id)
    {
        $db_delivery_order = RC_DB::table('delivery_order');
        $return_res        = 0;
        if (empty($order_id)) {
            return $return_res;
        }

        /* 未全部分单 */
        if (!self::get_order_finish($order_id)) {
            return $return_res;
        } else {
            /* 已全部分单 */
            /* 是否全部发货 */
            $sum = $db_delivery_order->where('order_id', $order_id)->where('status', 2)->count('delivery_id');
            /* 全部发货 */
            if (empty($sum)) {
                $return_res = 1;
            } else {
                /* 未全部发货 */
                /* 订单全部发货中时：当前发货单总数 */
                $_sum = $db_delivery_order->where('order_id', $order_id)->where('status', '!=', 1)->count('delivery_id');
                if ($_sum == $sum) {
                    $return_res = -2;
                    // 完全没发货
                } else {
                    $return_res = -1;
                    // 部分发货
                }
            }
        }
        return $return_res;
    }

    /**
     * 众包和商家配送默认生成发货单号
     * @param $order
     * @return string
     */
    private static function get_invoice_no($order)
    {
        $shipping_id   = $order['shipping_id'];
        $shipping_info = RC_DB::table('shipping')->where('shipping_id', $shipping_id)->first();
        $invoice_no = '';
        if ($shipping_info['shipping_code'] == 'ship_o2o_express' || $shipping_info['shipping_code'] == 'ship_ecjia_express') {
            $rand1                        = mt_rand(100000, 999999);
            $rand2                        = mt_rand(1000000, 9999999);
            $invoice_no                   = $rand1 . $rand2;
        }

        return $invoice_no;
    }


    private static function generate_express_order($delivery_order, $shipping_info)
    {
        $express_id = 0;
        if (!empty($delivery_order)) {
            if (!empty($delivery_order['user_id'])) {
                $user_name = RC_DB::table('users')->where('user_id', $delivery_order['user_id'])->value('user_name');
                $delivery_order['user_name'] = !empty($user_name) ? $user_name : '';
            }

            $express_from = 'grab';

            $express_data = array(
                'express_sn'    => ecjia_order_express_sn(),
                'order_sn'      => $delivery_order['order_sn'],
                'order_id'      => $delivery_order['order_id'],
                'delivery_id'   => $delivery_order['delivery_id'],
                'delivery_sn'   => $delivery_order['delivery_sn'],
                'store_id'      => $delivery_order['store_id'],
                'user_id'       => $delivery_order['user_id'],
                'consignee'     => $delivery_order['consignee'],
                'address'       => $delivery_order['address'],
                'country'       => $delivery_order['country'],
                'province'      => $delivery_order['province'],
                'city'          => $delivery_order['city'],
                'district'      => $delivery_order['district'],
                'street'        => $delivery_order['street'],
                'email'         => $delivery_order['email'],
                'mobile'        => $delivery_order['mobile'],
                'best_time'     => $delivery_order['best_time'],
                'remark'        => '',
                'shipping_fee'  => $delivery_order['shipping_fee'],
                'shipping_code' => $shipping_info['shipping_code'],
                'commision'     => '',
                'add_time'      => RC_Time::gmtime(),
                'longitude'     => $delivery_order['longitude'],
                'latitude'      => $delivery_order['latitude'],
                'from'          => $express_from,
                'status'        => $express_from == 'grab' ? 0 : 1,
            );

            $store_info = RC_DB::table('store_franchisee')->where('store_id', $delivery_order['store_id'])->first();
            if (!empty($store_info['longitude']) && !empty($store_info['latitude'])) {
                //腾讯地图api距离计算
                $key                      = ecjia::config('map_qq_key');
                $url                      = "https://apis.map.qq.com/ws/distance/v1/?mode=driving&from=" . $store_info['latitude'] . "," . $store_info['longitude'] . "&to=" . $delivery_order['latitude'] . "," . $delivery_order['longitude'] . "&key=" . $key;
                //$distance_json            = file_get_contents($url);
                $distance_result = RC_Http::remote_get($url);
                $distance_info = [];
                if (is_ecjia_error($distance_result)) {
                } else {
                    if ($distance_result['response']['code'] == '200') {
                        $distance_info            = json_decode($distance_result['body'], true);
                    }
                }
                $express_data['distance'] = isset($distance_info['result']['elements'][0]['distance']) ? $distance_info['result']['elements'][0]['distance'] : 0;
            }

            $exists_express_order = RC_DB::table('express_order')->where('delivery_sn', $delivery_order['delivery_sn'])->where('store_id', $_SESSION['store_id'])->first();
            if ($exists_express_order) {
                unset($express_data['add_time']);
                $express_data['update_time'] = RC_Time::gmtime();
                RC_DB::table('express_order')->where('express_id', $exists_express_order['express_id'])->update($express_data);
                $express_id = $exists_express_order['express_id'];
            } else {
                $express_id = RC_DB::table('express_order')->insertGetId($express_data);
            }
        }

        return $express_id;
    }

    /**
     * 自动派单
     * @param $express_id
     * @param $shipping_info
     * @param $order
     * @return bool
     */
    private static function auto_assign_express_order($express_id, $shipping_info, $order)
    {
        if (!empty($express_id)) {
            if ($shipping_info['shipping_code'] == 'ship_ecjia_express') {
                $params = array(
                    'express_id' => $express_id,
                );
                $result = RC_Api::api('express', 'ecjiaauto_assign_expressOrder', $params);
            } elseif ($shipping_info['shipping_code'] == 'ship_o2o_express') {
                $params = array(
                    'express_id' => $express_id,
                    'store_id'   => $order['store_id'],
                );
                $result = RC_Api::api('express', 'o2oauto_assign_expressOrder', $params);
            }
        }

        return true;
    }

    /**
     *  如果是o2o速递则在 ecjia_express_track_record表内更新一条记录
     * @param $shipping_info
     * @param $delivery_order
     * @return bool
     */
    private static function insert_express_track_record($shipping_info, $delivery_order)
    {
        $express_track_record_data = array(
            "express_code" => $shipping_info['shipping_code'],
            "track_number" => $delivery_order['invoice_no'],
            "time"         => RC_Time::local_date(ecjia::config('time_format'), RC_Time::gmtime()),
            "context"      => __("您的订单已配备好，等待配送员取货", 'orders'),
        );
        RC_DB::table('express_track_record')->insert($express_track_record_data);

        return true;
    }


    private static function after_order_finish_process($order_id, $order_finish)
    {
        $order = RC_DB::table('order_info')->where('order_id', $order_id)->first();

        if ($order_finish) {

            /* 取得用户信息 */
            $user_info = RC_DB::table('users')->where('user_id', $order['user_id'])->first();

            /* 如果订单用户不为空，计算积分，并发给用户；发红包 */
            if ($order['user_id'] > 0) {
                /* 计算并发放积分 */
                $integral      = self::integral_to_give($order);
                $integral_name = ecjia::config('integral_name');
                if (empty($integral_name)) {
                    $integral_name = __('积分', 'orders');
                }
                $options = array(
                    'user_id'     => $order['user_id'],
                    'rank_points' => intval($integral['rank_points']),
                    'pay_points'  => intval($integral['custom_points']),
                    'change_desc' => sprintf(__('%s赠送的' . $integral_name, 'orders'), $order['order_sn']),
                    'from_type'   => 'order_give_integral',
                    'from_value'  => $order['order_sn'],
                );
                $res = RC_Api::api('user', 'account_change_log', $options);
                if (is_ecjia_error($res)) {}
                /* 发放红包 */
                self::send_order_bonus($order_id);
            }

            if (!empty($user_info['mobile_phone'])) {
                //发送短信
                $user_name = $user_info['user_name'];
                $options   = array(
                    'mobile' => $user_info['mobile_phone'],
                    'event'  => 'sms_order_shipped',
                    'value'  => array(
                        'user_name'     => $user_name,
                        'order_sn'      => $order['order_sn'],
                        'consignee'     => $order['consignee'],
                        'service_phone' => ecjia::config('service_phone'),
                    ),
                );
                RC_Api::api('sms', 'send_event_sms', $options);
            }

            $user_name = RC_DB::table('users')->where('user_id', $order['user_id'])->value('user_name');
            /*商家发货 推送消息*/
            $options = array(
                'user_id'   => $order['user_id'],
                'user_type' => 'user',
                'event'     => 'order_shipped',
                'value'     => array(
                    'user_name'     => $user_name,
                    'order_sn'      => $order['order_sn'],
                    'consignee'     => $order['consignee'],
                    'service_phone' => ecjia::config('service_phone'),
                ),
                'field'     => array(
                    'open_type' => 'admin_message',
                ),
            );
            RC_Api::api('push', 'push_event_send', $options);

            //消息通知
            $orm_user_db = RC_Model::model('orders/orm_users_model');
            $user_ob     = $orm_user_db->find($order['user_id']);

            $order_data = array(
                'title' => __('商家发货', 'orders'),
                'body'  => sprintf(__('您的订单已发货，订单号为：%s', 'orders'), $order['order_sn']),
                'data'  => array(
                    'order_id'               => $order['order_id'],
                    'order_sn'               => $order['order_sn'],
                    'order_amount'           => $order['order_amount'],
                    'formatted_order_amount' => price_format($order['order_amount']),
                    'consignee'              => $order['consignee'],
                    'mobile'                 => $order['mobile'],
                    'address'                => $order['address'],
                    'order_time'             => RC_Time::local_date(ecjia::config('time_format'), $order['add_time']),
                    'shipping_time'          => RC_Time::local_date(ecjia::config('time_format'), $order['shipping_time']),
                    'invoice_no'             => $order['invoice_no'],
                ),
            );

            $push_order_shipped = new OrderShipped($order_data);
            RC_Notification::send($user_ob, $push_order_shipped);

        }

        return true;
    }

    /**
     * 取得某订单应该赠送的积分数
     * @param   array $order 订单
     * @return  int | array    积分数
     */
    private static function integral_to_give($order)
    {
        /* 判断是否团购 */
        // TODO:团购暂时注释给的固定参数
        $order['extension_code'] = '';
        if ($order['extension_code'] == 'group_buy') {
            RC_Loader::load_app_func('admin_goods', 'goods');
            $group_buy = group_buy_info(intval($order['extension_id']));

            return array('custom_points' => $group_buy['gift_integral'], 'rank_points' => $order['goods_amount']);
        } else {
            return RC_DB::table('order_goods as o')
                ->leftJoin('goods as g', RC_DB::raw('o.goods_id'), '=', RC_DB::raw('g.goods_id'))
                ->select(RC_DB::raw('SUM(o.goods_number * IF(g.give_integral > -1, g.give_integral, o.goods_price)) AS custom_points, 
        			SUM(o.goods_number * IF(g.rank_integral > -1, g.rank_integral, o.goods_price)) AS rank_points'))
                ->where(RC_DB::raw('o.order_id'), $order['order_id'])
                ->where(RC_DB::raw('o.goods_id'), '>', 0)
                ->where(RC_DB::raw('o.parent_id'), '=', 0)
                ->where(RC_DB::raw('o.is_gift'), '=', 0)
                ->first();
        }
    }

    private static function send_order_bonus($order_id)
    {

        /* 取得订单应该发放的红包 */
        $bonus_list = self::order_bonus($order_id);
        /* 如果有红包，统计并发送 */
        if ($bonus_list) {
            /* 用户信息 */
            $user = RC_DB::table('order_info as oi')->leftJoin('users as u', RC_DB::raw('oi.user_id'), '=', RC_DB::raw('u.user_id'))->select(RC_DB::raw('u.user_id, u.user_name, u.email'))->where(RC_DB::raw('oi.order_id'), $order_id)->first();
            /* 统计 */
            $count = 0;
            $money = '';
            foreach ($bonus_list as $bonus) {
                //$count += $bonus['number'];
                //优化一个订单只能发一个红包
                if ($bonus['number']) {
                    $count           = 1;
                    $bonus['number'] = 1;
                }
                $money .= price_format($bonus['type_money']) . ' [' . $bonus['number'] . '], ';
                /* 修改用户红包 */
                $data = array('bonus_type_id' => $bonus['type_id'], 'user_id' => $user['user_id']);
                for ($i = 0; $i < $bonus['number']; $i++) {
                    $id = RC_DB::table('user_bonus')->insertGetId($data);
                }
            }
            /* 如果有红包，发送邮件 */
            if ($count > 0) {
                $tpl_name = 'send_bonus';
                $tpl      = RC_Api::api('mail', 'mail_template', $tpl_name);
                if (isset($_SESSION['store_id'])) {
                    ecjia_admin::$controller->assign('user_name', $user['user_name']);
                    ecjia_admin::$controller->assign('count', $count);
                    ecjia_admin::$controller->assign('money', $money);
                    ecjia_admin::$controller->assign('shop_name', ecjia::config('shop_name'));
                    ecjia_admin::$controller->assign('send_date', RC_Time::local_date(ecjia::config('date_format')));
                    $content = ecjia_admin::$controller->fetch_string($tpl['template_content']);
                } else {
                    ecjia_front::$controller->assign('user_name', $user['user_name']);
                    ecjia_front::$controller->assign('count', $count);
                    ecjia_front::$controller->assign('money', $money);
                    ecjia_front::$controller->assign('shop_name', ecjia::config('shop_name'));
                    ecjia_front::$controller->assign('send_date', RC_Time::local_date(ecjia::config('date_format')));
                    $content = ecjia_front::$controller->fetch_string($tpl['template_content']);
                }
                RC_Mail::send_mail($user['user_name'], $user['email'], $tpl['template_subject'], $content, $tpl['is_html']);
            }
        }
        return true;
    }


    /**
     * 取得订单应该发放的红包
     * @param   int $order_id 订单id
     * @return  array
     */
    private static function order_bonus($order_id)
    {
        /* 查询按商品发的红包 */
        $store_id = RC_DB::table('order_info')->where('order_id', $order_id)->value('store_id');
        $today    = RC_Time::gmtime();
        $list     = RC_DB::table('order_goods as o')->leftJoin('goods as g', RC_DB::raw('o.goods_id'), '=', RC_DB::raw('g.goods_id'))->leftJoin('bonus_type as b', RC_DB::raw('g.bonus_type_id'), '=', RC_DB::raw('b.type_id'))->select(RC_DB::raw('b.type_id'), RC_DB::raw('b.type_money'), RC_DB::raw('SUM(o.goods_number) AS number'))->whereRaw('o.order_id = ' . $order_id . ' and o.is_gift = 0 and b.send_type = ' . SEND_BY_GOODS . ' and b.send_start_date <= ' . $today . ' and b.send_end_date >= ' . $today . ' and (b.store_id = ' . $store_id . ' OR b.store_id = 0 )')->groupby(RC_DB::raw('b.type_id'))->get();
        /* 查询定单中非赠品总金额 */
        $amount = self::order_amount($order_id, false);
        /* 查询订单日期 */
        $order_time = RC_DB::table('order_info')->where('order_id', $order_id)->value('add_time');
        /* 查询按订单发的红包 */
        $data = RC_DB::table('bonus_type')->select('type_id', 'type_money', RC_DB::raw('IFNULL(FLOOR(' . $amount . ' / min_amount), 1) as number'))->whereRaw('send_type = ' . SEND_BY_ORDER . ' AND send_start_date <=' . $order_time . ' AND send_end_date >= ' . $order_time . ' AND (store_id = ' . $store_id . ' OR store_id = 0)')->get();
        if (!empty($data)) {
            $list = array_merge($list, $data);
        }
        return $list;
    }

    /**
     * 取得订单总金额
     * @param   int $order_id 订单id
     * @param   bool $include_gift 是否包括赠品
     * @return  float   订单总金额
     */
    private static function order_amount($order_id, $include_gift = true)
    {
        $db_order_goods = RC_DB::table('order_goods')->where('order_id', $order_id);
        if (!$include_gift) {
            $db_order_goods->where('is_gift', 0);
        }
        $data = $db_order_goods->sum(RC_DB::raw('goods_price * goods_number'));
        return floatval($data);
    }


    /**
     * 更新订单商品信息
     * @param   int $order_id 订单 id
     * @param   array $_sended Array('商品id' => '此单发货数量')
     * @param   array $goods_list
     * @return  Bool
     */
    private static function update_order_goods($order_id, $_sended, $goods_list = array())
    {
        if (!is_array($_sended) || empty($order_id)) {
            return false;
        }
        foreach ($_sended as $key => $value) {
            // 超值礼包
            if (is_array($value)) {
                if (!is_array($goods_list)) {
                    $goods_list = array();
                }
                foreach ($goods_list as $goods) {
                    if ($key != $goods['rec_id'] || (!isset($goods['package_goods_list']) || !is_array($goods['package_goods_list']) || !empty($goods['package_goods_list']))) {
                        continue;
                    }
                    $goods['package_goods_list'] = package_goods($goods['package_goods_list'], $goods['goods_number'], $goods['order_id'], $goods['extension_code'], $goods['goods_id']);
                    $pg_is_end                   = true;
                    foreach ($goods['package_goods_list'] as $pg_key => $pg_value) {
                        if ($pg_value['order_send_number'] != $pg_value['sended']) {
                            $pg_is_end = false;
                            // 此超值礼包，此商品未全部发货
                            break;
                        }
                    }
                    // 超值礼包商品全部发货后更新订单商品库存
                    if ($pg_is_end) {
                        $goods_number = RC_DB::table('order_goods')->where('order_id', $order_id)->where('goods_id', $goods['goods_id'])->value('goods_number');
                        RC_DB::table('order_goods')->where('order_id', $order_id)->where('goods_id', $goods['goods_id'])->update(array('send_number' => $goods_number));
                    }
                }
            } elseif (!is_array($value)) {
                // 商品（实货）（货品）
                /* 检查是否为商品（实货）（货品） */
                foreach ($goods_list as $goods) {
                    if ($goods['rec_id'] == $key && $goods['is_real'] == 1) {
                        RC_DB::table('order_goods')->where('order_id', $order_id)->where('rec_id', $key)->increment('send_number', $value);
                        break;
                    }
                }
            }
        }
        return true;
    }
}