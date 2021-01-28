<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//

use Ecjia\System\Notifications\OrderShipped;
use Ecjia\App\Orders\Notifications\OrderPickupSuccess;

defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 验单
 * @author will
 *
 */
class admin_orders_check_module extends api_admin implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
        $this->authadminSession();
        if ($_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, __('Invalid session', 'orders'));
        }
        $device = $this->device;
        //$device = array('code'=> '8001', 'udid' => 'd6cbff706f0d6b8468d2d998386ee1bc233cdf7c', 'client' => 'android', 'sn' => ''); 
        $codes  = config('app-cashier::cashier_device_code');
        if (!in_array($device['code'], $codes)) {
            $result = $this->admin_priv('order_view');
            if (is_ecjia_error($result)) {
                return $result;
            }
        }

        $verification_code = $this->requestData('verify_code');
        $invoice_no        = $this->requestData('invoice_no', '');
        $action_note       = $this->requestData('action_note', '');

        $id = $this->requestData('order_id', 0);
        if (empty($verification_code)) {
            return new ecjia_error('invalid_parameter', sprintf(__('请求接口%s参数无效', 'orders'), __CLASS__));
        }
        $db_term_meta = RC_Loader::load_model('term_meta_model');
        $meta_where   = array(
            'object_type'  => 'ecjia.order',
            'object_group' => 'order',
            'meta_key'     => 'receipt_verification',
            'meta_value'   => $verification_code,
        );
        $order_count  = $db_term_meta->where($meta_where)->count();
        if ($order_count > 1) {
            return new ecjia_error('repeat_error', __('验证码重复，请与管理员联系！', 'orders'));
        }

        $order_id = $db_term_meta->where($meta_where)->get_field('object_id');
        if (empty($order_id)) {
            return new ecjia_error('verification_code_error', __('验证码错误！', 'orders'));
        }

        if ($id == 0) {
            return array('order_id' => $order_id);
        }
        if ($id != $order_id) {
            return new ecjia_error('verification_code_error', __('验证码错误！', 'orders'));
        }
        /* 查询订单信息 */
        $order_info = RC_Api::api('orders', 'order_info', array('order_id' => $order_id, 'order_sn' => ''));
        if ($_SESSION['store_id'] != $order_info['store_id']) {
            return new ecjia_error('order_error', __('验证码所对应的订单不属于当前店铺！', 'orders'));
        }
        /* 判断发货情况*/
        if ($order_info['shipping_status'] > SS_UNSHIPPED) {
            return new ecjia_error('order_shipped', __('该订单已发货！无法进行此操作', 'orders'));
        }
        
        RC_Loader::load_app_func('admin_order', 'orders');
        RC_Loader::load_app_func('global', 'orders');
         
        $action_note = __('收银台验单', 'orders');
        /*配货*/
        $result = $this->prepare($order_info, $action_note);
         
        /*分单，生成发货单*/
        $result = $this->split($order_info, $action_note);
        if (is_ecjia_error($result)) {
        	RC_Logger::getLogger('error')->info(sprintf(__('订单分单【订单id|%s】：' . $result->get_error_message(), 'orders'), $order_info['order_id']));
        	return $result;
        }
         
        /*发货*/
        $delivery_id  = RC_DB::table('delivery_order')->where('order_id', $order_id)->value('delivery_id');
        $result       = $this->delivery_ship($order_id, $delivery_id);
        if (is_ecjia_error($result)) {
        	RC_Logger::getLogger('error')->info(sprintf(__('订单发货【订单id|%s】：' . $result->get_error_message(), 'orders'), $order_info['order_id']));
        	return $result;
        }
         
        /*确认收货*/
        $result = $this->receive($order_info, $action_note);
        
        if ($result) {
        	/*收银员订单操作记录*/
        	$device_info    = RC_DB::table('mobile_device')->where('id', $_SESSION['device_id'])->first();
        	$device_type    = Ecjia\App\Cashier\CashierDevice::get_device_type($device['code']);
        	$cashier_record = array(
        			'store_id'         => $_SESSION['store_id'],
        			'staff_id'         => $_SESSION['staff_id'],
        			'order_id'         => $order_id,
        			'order_sn'         => $order_info['order_sn'],
        			'order_type'       => 'buy',
        			'mobile_device_id' => $_SESSION['device_id'],
        			'device_sn'        => $device_info['device_udid'],
        			'device_type'      => $device_type,
        			'action'           => 'check_order', //验单
        			'create_at'        => RC_Time::gmtime(),
        	);
        	RC_DB::table('cashier_record')->insert($cashier_record);
        	 
        	//员工日志
        	if ($_SESSION['store_id'] > 0) {
        		RC_Api::api('merchant', 'admin_log', array('text' => sprintf(__('验单，订单号：%s【来源掌柜】', 'orders'), $order_info['order_sn']), 'action' => 'edit', 'object' => 'order'));
        	}
        	return array();
        }
         
        return new ecjia_error('check_order_fail', __('验单失败！', 'orders'));
        
    }

    /**
     * 配货
     */
    private function prepare($order, $action_note = '')
    {
    	/* 配货 */
    	/* 标记订单为已确认，配货中 */
    	if ($order['order_status'] != OS_CONFIRMED) {
    		$arr['order_status'] = OS_CONFIRMED;
    		$arr['confirm_time'] = RC_Time::gmtime();
    	}
    	$arr['shipping_status'] = SS_PREPARING;
    	update_order($order['order_id'], $arr);
    	/* 记录log */
    	order_action($order['order_sn'], OS_CONFIRMED, SS_PREPARING, $order['pay_status'], $action_note);
    	return true;
    }
    

    /**
     * 分单，生成发货单
     */
    private function split($order, $action_note = '')
    {
    	$send_number = 1;
    	/*默认全部发货*/
    	$delivery['order_sn'] = $order['order_sn'];
    	$delivery['user_id']  = intval($order['user_id']);
    
    	$delivery['country']  = trim($order['country']);
    	$delivery['province'] = trim($order['province']);
    	$delivery['city']     = trim($order['city']);
    	$delivery['district'] = trim($order['district']);
    	$delivery['street']   = trim($order['street']);
    
    	$delivery['agency_id']     = intval($order['agency_id']);
    	$delivery['insure_fee']    = floatval($order['insure_fee']);
    	$delivery['shipping_fee']  = floatval($order['shipping_fee']);
    	$delivery['shipping_id']   = intval($order['shipping_id']);
    	$delivery['shipping_name'] = trim($order['shipping_id']);
    	$delivery['consignee']     = trim($order['consignee']);
    	$delivery['address']       = trim($order['address']);
    	$delivery['mobile']        = trim($order['mobile']);
    
    	/* 订单是否已全部分单检查 */
    	if ($order['order_status'] == OS_SPLITED) {
    		/* 操作失败 */
    		return new ecjia_error('order_status_error', sprintf(__('您的订单%s，%s正在%s，%s', 'orders'), $order['order_sn'], __('已分单', 'orders'), __('发货中', 'orders'), ecjia::config('shop_name')));
    	}
    
    	/* 取得订单商品 */
    	$_goods     = get_order_goods(array('order_id' => $order['order_id'], 'order_sn' => $delivery['order_sn']));
    	$goods_list = $_goods['goods_list'];
    
    	/* 检查此单发货数量填写是否正确 合并计算相同商品和货品 */
    	if (!empty($send_number) && !empty($goods_list)) {
    		$send_number      = array();
    		$goods_no_package = array();
    		foreach ($goods_list as $key => $value) {
    
    			//TODO:默认全部发货，后期改善分批
    			$send_number[$value['rec_id']] = $value['goods_number'];
    
    			/* 去除 此单发货数量 等于 0 的商品 */
    			if (!isset($value['package_goods_list']) || !is_array($value['package_goods_list'])) {
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
    			} else {
    				/* 组合超值礼包信息 */
    				$goods_list[$key]['package_goods_list'] = package_goods($value['package_goods_list'], $value['goods_number'], $value['order_id'], $value['extension_code'], $value['goods_id']);
    
    				/* 超值礼包 */
    				foreach ($value['package_goods_list'] as $pg_key => $pg_value) {
    					// 如果是货品则键值为商品ID与货品ID的组合
    					$_key = empty($pg_value['product_id']) ? $pg_value['goods_id'] : ($pg_value['goods_id'] . '_' . $pg_value['product_id']);
    
    					//统计此单商品总发货数 合并计算相同ID产品的发货数
    					if (empty($goods_no_package[$_key])) {
    						$goods_no_package[$_key] = $send_number[$value['rec_id']][$pg_value['g_p']];
    					} else {
    						//否则已经存在此键值
    						$goods_no_package[$_key] += $send_number[$value['rec_id']][$pg_value['g_p']];
    					}
    
    					//去除
    					if ($send_number[$value['rec_id']][$pg_value['g_p']] <= 0) {
    						unset($send_number[$value['rec_id']][$pg_value['g_p']], $goods_list[$key]['package_goods_list'][$pg_key]);
    					}
    				}
    
    				if (count($goods_list[$key]['package_goods_list']) <= 0) {
    					unset($send_number[$value['rec_id']], $goods_list[$key]);
    					continue;
    				}
    			}
    
    			/* 发货数量与总量不符 */
    			if (!isset($value['package_goods_list']) || !is_array($value['package_goods_list'])) {
    				$sended = order_delivery_num($order['order_id'], $value['goods_id'], $value['product_id']);
    				if (($value['goods_number'] - $sended - $send_number[$value['rec_id']]) < 0) {
    					/* 操作失败 */
    					return new ecjia_error('send_number_error', __('此单发货数量不能超出订单商品数量', 'orders'));
    				}
    			} else {
    				/* 超值礼包 */
    				foreach ($goods_list[$key]['package_goods_list'] as $pg_key => $pg_value) {
    					if (($pg_value['order_send_number'] - $pg_value['sended'] - $send_number[$value['rec_id']][$pg_value['g_p']]) < 0) {
    						/* 操作失败 */
    						return new ecjia_error('send_number_error', __('此单发货数量不能超出订单商品数量', 'orders'));
    					}
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
    		// 商品（超值礼包）
    		if ($value['extension_code'] == 'package_buy') {
    			foreach ($value['package_goods_list'] as $pg_key => $pg_value) {
    				if ($pg_value['goods_number'] < $goods_no_package[$pg_value['g_p']] &&
    				((ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_SHIP) ||
    						(ecjia::config('use_storage') == '0' && $pg_value['is_real'] == 0))) {
    					/* 操作失败 */
    					$links[] = array('text' => __('订单信息', 'orders'), 'href' => RC_Uri::url('orders/merchant/info', array('order_id' => $order['order_id'])));
    					return new ecjia_error('goods_shipped', sprintf(__('商品 %s 已缺货', 'orders'), $pg_value['goods_name']));
    				}
    
    				/* 商品（超值礼包） 虚拟商品列表 package_virtual_goods*/
    				if ($pg_value['is_real'] == 0) {
    					$package_virtual_goods[] = array(
    							'goods_id'   => $pg_value['goods_id'],
    							'goods_name' => $pg_value['goods_name'],
    							'num'        => $send_number[$value['rec_id']][$pg_value['g_p']]
    					);
    				}
    			}
    		} elseif ($value['extension_code'] == 'virtual_card' || $value['is_real'] == 0) {
    			// 商品（虚货）
    			$num = RC_DB::table('virtual_card')->where('goods_id', $value['goods_id'])->where('is_saled', 0)->count();
    
    			if (($num < $goods_no_package[$value['goods_id']]) && !(ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE)) {
    				/* 操作失败 */
    				return new ecjia_error('goods_stock_lack', sprintf(__('虚拟卡已缺货', 'orders'), $value['goods_name']));
    			}
    
    			/* 虚拟商品列表 virtual_card*/
    			if ($value['extension_code'] == 'virtual_card') {
    				$virtual_goods[$value['extension_code']][] = array('goods_id' => $value['goods_id'], 'goods_name' => $value['goods_name'], 'num' => $send_number[$value['rec_id']]);
    			}
    		} else {
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
    				return new ecjia_error('goods_stock_lack', sprintf(__('商品 %s 已缺货', 'orders'), $value['goods_name']));
    			}
    		}
    	}
    
    	/* 生成发货单 */
    	/* 获取发货单号和流水号 */
    	$delivery['delivery_sn'] = ecjia_order_delivery_sn();
    	$delivery_sn             = $delivery['delivery_sn'];
    	/* 获取当前操作员 */
    	$delivery['action_user'] = $_SESSION['staff_name'];
    	/* 获取发货单生成时间 */
    	$delivery['update_time'] = RC_Time::gmtime();
    	$delivery_time           = $delivery['update_time'];
    
    	$delivery['add_time'] = RC_DB::table('order_info')->where('order_sn', $delivery['order_sn'])->value('add_time');
    
    	/* 设置默认值 */
    	$delivery['status']   = 2; // 正常
    	$delivery['order_id'] = $order['order_id'];
    
    	/*地区经纬度赋值*/
    	$delivery['longitude'] = $order['longitude'];
    	$delivery['latitude']  = $order['latitude'];
    	/* 期望送货时间*/
    	$delivery['best_time'] = $order['expect_shipping_time'];
    
//     	if (empty($delivery['longitude']) || empty($delivery['latitude'])) {
//     		$province_name     = ecjia_region::getRegionName($delivery['province']);
//     		$city_name         = ecjia_region::getRegionName($delivery['city']);
//     		$district_name     = ecjia_region::getRegionName($delivery['district']);
//     		$street_name       = ecjia_region::getRegionName($delivery['street']);
//     		$consignee_address = '';
//     		if (!empty($province_name)) {
//     			$consignee_address .= $province_name;
//     		}
//     		if (!empty($city_name)) {
//     			$consignee_address .= $city_name;
//     		}
//     		if (!empty($district_name)) {
//     			$consignee_address .= $district_name;
//     		}
//     		if (!empty($street_name)) {
//     			$consignee_address .= $street_name;
//     		}
//     		$consignee_address .= $delivery['address'];
//     		$consignee_address = urlencode($consignee_address);
    
//     		//腾讯地图api 地址解析（地址转坐标）
//     		$keys = ecjia::config('map_qq_key');
//     		$shop_point = RC_Http::remote_get("https://apis.map.qq.com/ws/geocoder/v1/?address=".$consignee_address."&key=".$keys);
//     		$shop_point = json_decode($shop_point['body'], true);
//     		if (isset($shop_point['result']) && !empty($shop_point['result']['location'])) {
//     			$delivery['longitude']	= $shop_point['result']['location']['lng'];
//     			$delivery['latitude']	= $shop_point['result']['location']['lat'];
//     		}
//     	}
    
    	/* 过滤字段项 */
    	$filter_fileds = array(
    			'order_sn', 'add_time', 'user_id', 'how_oos', 'shipping_id', 'shipping_fee',
    			'consignee', 'address', 'longitude', 'latitude', 'country', 'province', 'city', 'district', 'street', 'sign_building',
    			'email', 'zipcode', 'tel', 'mobile', 'best_time', 'postscript', 'insure_fee',
    			'agency_id', 'delivery_sn', 'action_user', 'update_time', 'status', 'order_id', 'shipping_name'
    	);
    	$_delivery     = array();
    	foreach ($filter_fileds as $value) {
    		$_delivery[$value] = $delivery[$value];
    	}
    
    	$_delivery['store_id'] = $_SESSION['store_id'];
    
    	/* 发货单入库 */
    	$delivery_id = RC_DB::table('delivery_order')->insertGetId($_delivery);
    
    	if ($delivery_id) {
    		$data = array(
    				'order_status' => __('配货中', 'orders'),
    				'order_id'     => $order['order_id'],
    				'message'      => sprintf(__('订单号为 %s 的商品正在备货中，请您耐心等待', 'orders'), $order['order_sn']),
    				'add_time'     => RC_Time::gmtime()
    		);
    		RC_DB::table('order_status_log')->insert($data);
    	}
    
    	if ($delivery_id) {
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
    							'goods_attr'  => addslashes($value['goods_attr'])
    					);
    
    					/* 如果是货品 */
    					if (!empty($value['product_id'])) {
    						$delivery_goods['product_id'] = $value['product_id'];
    					}
    					$query = RC_DB::table('delivery_goods')->insert($delivery_goods);
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
    								'is_real'        => $pg_value['is_real']
    						);
    						$query = RC_DB::table('delivery_goods')->insertGetId($delivery_pg_goods);
    					}
    				}
    			}
    		}
    	} else {
    		/* 操作失败 */
    		return new ecjia_error('handle_fail', __('操作失败', 'orders'));
    	}
    
    	unset($filter_fileds, $delivery, $_delivery);
    
    	/* 订单信息更新处理 */
    	if (true) {
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
    
    		/* 更新订单的虚拟卡 商品（虚货） */
    		$_virtual_goods = isset($virtual_goods['virtual_card']) ? $virtual_goods['virtual_card'] : '';
    		update_order_virtual_goods($order['order_id'], $_sended, $_virtual_goods);
    		/* 更新订单的非虚拟商品信息 即：商品（实货）（货品）、商品（超值礼包）*/
    		update_order_goods($order['order_id'], $_sended, $_goods['goods_list']);
    		/* 标记订单为已确认 “发货中” */
    		/* 更新发货时间 */
    		$order_finish    = get_order_finish($order['order_id']);
    		$shipping_status = SS_SHIPPED_ING;
    		if ($order['order_status'] != OS_CONFIRMED && $order['order_status'] != OS_SPLITED && $order['order_status'] != OS_SPLITING_PART) {
    			$arr['order_status'] = OS_CONFIRMED;
    			$arr['confirm_time'] = GMTIME_UTC;
    		}
    
    		$arr['order_status']    = $order_finish ? OS_SPLITED : OS_SPLITING_PART; // 全部分单、部分分单
    		$arr['shipping_status'] = $shipping_status;
    		update_order($order['order_id'], $arr);
    	}
    
    	/* 记录log */
    	order_action($order['order_sn'], $arr['order_status'], $shipping_status, $order['pay_status'], $action_note);
    	return true;
    }
    

    private function delivery_ship($order_id, $delivery_id)
    {
    	RC_Loader::load_app_func('function', 'orders');
    
    	$db_delivery_order = RC_Loader::load_app_model('delivery_order_model', 'orders');
    	$db_goods          = RC_Loader::load_app_model('goods_model', 'goods');
    
    	/* 取得参数 */
    	$delivery               = array();
    	$order_id               = intval($order_id);            // 订单id
    	$delivery['invoice_no'] = '';
        $action_note            = __('收银台验单', 'orders');
    	/* 根据发货单id查询发货单信息 */
    	if (!empty($delivery_id)) {
    		$delivery_order = delivery_order_info($delivery_id);
    	} else {
    		return new ecjia_error('delivery_order_error', __('无法找到对应发货单！', 'orders'));
    	}
    	if (empty($delivery_order)) {
    		return new ecjia_error('delivery_order_error', __('无法找到对应发货单！', 'orders'));
    	}
    
    	/* 查询订单信息 */
    	$order = RC_Api::api('orders', 'order_info', array('order_id' => $order_id, 'order_sn' => ''));
    
    	/* 检查此单发货商品库存缺货情况 */
    	$virtual_goods         = array();
    	$dbdelivery            = RC_DB::table('delivery_goods as dg')
    	->leftJoin('goods as g', RC_DB::raw('dg.goods_id'), '=', RC_DB::raw('g.goods_id'))
    	->leftJoin('products as p', RC_DB::raw('dg.product_id'), '=', RC_DB::raw('p.product_id'));
    	$delivery_stock_result = $dbdelivery->where(RC_DB::raw('dg.delivery_id'), $delivery_id)->groupBy(RC_DB::raw('dg.product_id'))
    	->select(RC_DB::raw('dg.goods_id'), RC_DB::raw('dg.is_real'), RC_DB::raw('dg.product_id'),
    			RC_DB::raw('SUM(dg.send_number) AS sums'), RC_DB::raw("IF(dg.product_id > 0, p.product_number, g.goods_number) AS storage"),
    			RC_DB::raw('g.goods_name'), RC_DB::raw('dg.send_number'))
    			->get();
    
    	/* 如果商品存在规格就查询规格，如果不存在规格按商品库存查询 */
    	if (!empty($delivery_stock_result)) {
    		foreach ($delivery_stock_result as $value) {
    			if (($value['sums'] > $value['storage'] || $value['storage'] <= 0) &&
    			((ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_SHIP) ||
    					(ecjia::config('use_storage') == '0' && $value['is_real'] == 0))) {
    				/* 操作失败 */
    				return new ecjia_error('goods_stock_lack', sprintf(__('商品 %s 已缺货', 'orders'), $value['goods_name']));
    			}
    
    			/* 虚拟商品列表 virtual_card */
    			if ($value['is_real'] == 0) {
    				$virtual_goods[] = array(
    						'goods_id'   => $value['goods_id'],
    						'goods_name' => $value['goods_name'],
    						'num'        => $value['send_number']
    				);
    			}
    		}
    	} else {
    		$delivery_stock_result = RC_DB::table('delivery_goods as dg')
    		->leftJoin('goods as g', RC_DB::raw('dg.goods_id'), '=', RC_DB::raw('g.goods_id'))
    		->select(RC_DB::raw('dg.goods_id'), RC_DB::raw('dg.is_real'), RC_DB::raw('SUM(dg.send_number) AS sums'), RC_DB::raw('g.goods_number'), RC_DB::raw('g.goods_name'), RC_DB::raw('dg.send_number'))
    		->where(RC_DB::raw('dg.delivery_id'), $delivery_id)
    		->groupBy(RC_DB::raw('dg.goods_id'))
    		->get();
    
    		foreach ($delivery_stock_result as $value) {
    			if (($value['sums'] > $value['goods_number'] || $value['goods_number'] <= 0) &&
    			((ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_SHIP) ||
    					(ecjia::config('use_storage') == '0' && $value['is_real'] == 0))) {
    				/* 操作失败 */
    				return new ecjia_error('goods_stock_lack', sprintf(__('商品 %s 已缺货', 'orders'), $value['goods_name']));
    			}
    
    			/* 虚拟商品列表 virtual_card*/
    			if ($value['is_real'] == 0) {
    				$virtual_goods[] = array(
    						'goods_id'   => $value['goods_id'],
    						'goods_name' => $value['goods_name'],
    						'num'        => $value['send_number']
    				);
    			}
    		}
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
    					$this->db_products->where(array('product_id' => $value['product_id']))->update($data);
    				} else {
    					$data = array(
    							'goods_number' => $value['storage'] - $value['sums'],
    					);
    					$db_goods->where(array('goods_id' => $value['goods_id']))->update($data);
    
    					//发货警告库存发送短信
    					order_stork::sms_goods_stock_warning($value['goods_id']);
    				}
    			}
    		}
    	}
    
    	/* 修改发货单信息 */
    	$invoice_no              = str_replace(',', '<br>', $delivery['invoice_no']);
    	$invoice_no              = trim($invoice_no, '<br>');
    	$_delivery['invoice_no'] = $invoice_no;
    	$_delivery['status']     = 0;    /* 0，为已发货 */
    	$result                  = $db_delivery_order->where(array('delivery_id' => $delivery_id))->update($_delivery);
    
    	/*操作成功*/
    	if ($result) {
    		$data = array(
    				'order_status' => __('已发货', 'orders'),
    				'message'      => sprintf(__('订单号为 %s 的商品已发货，请您耐心等待', 'orders'), $order['order_sn']),
    				'order_id'     => $order_id,
    				'add_time'     => RC_Time::gmtime(),
    		);
    		RC_DB::table('order_status_log')->insert($data);
    	} else {
    		return new ecjia_error('handle_fail', __('操作失败', 'orders'));
    	}
    
    	/* 标记订单为已确认 “已发货” */
    	/* 更新发货时间 */
    	$order_finish           = get_all_delivery_finish($order_id);
    	$shipping_status        = ($order_finish == 1) ? SS_SHIPPED : SS_SHIPPED_PART;
    	$arr['shipping_status'] = $shipping_status;
    	$arr['shipping_time']   = RC_Time::gmtime(); // 发货时间
    	$arr['invoice_no']      = trim($order['invoice_no'] . '<br>' . $invoice_no, '<br>');
    	update_order($order_id, $arr);
    
    	/* 发货单发货记录log */
    	order_action($order['order_sn'], OS_CONFIRMED, $shipping_status, $order['pay_status'], $action_note, null, 1);
    
    	/* 如果当前订单已经全部发货 */
    	if ($order_finish) {
    		/* 如果订单用户不为空，计算积分，并发给用户；发红包 */
    		if ($order['user_id'] > 0) {
    			/* 取得用户信息 */
    			$user = user_info($order['user_id']);
    			/* 计算并发放积分 */
    			$integral      = integral_to_give($order);
    			$integral_name = ecjia::config('integral_name');
    			if (empty($integral_name)) {
    				$integral_name = __('积分', 'orders');
    			}
    			$options = array(
    					'user_id'     => $order['user_id'],
    					'rank_points' => intval($integral['rank_points']),
    					'pay_points'  => intval($integral['custom_points']),
    					'change_desc' => sprintf(__('订单' . $order['order_sn'] . '赠送的%s', 'orders'), $integral_name),
    					'from_type'   => 'order_give_integral',
    					'from_value'  => $order['order_sn'],
    			);
    
    			RC_Api::api('user', 'account_change_log', $options);
    			/* 发放红包 */
    			send_order_bonus($order_id);
    		}
    
    		/* 发送邮件 */
    		$cfg = ecjia::config('send_ship_email');
    		if ($cfg == '1') {
    			$order['invoice_no'] = $invoice_no;
    			$tpl_name            = 'deliver_notice';
    			$tpl                 = RC_Api::api('mail', 'mail_template', $tpl_name);
    
    			$this->assign('order', $order);
    			$this->assign('send_time', RC_Time::local_date(ecjia::config('time_format')));
    			$this->assign('shop_name', ecjia::config('shop_name'));
    			$this->assign('send_date', RC_Time::local_date(ecjia::config('date_format')));
    			$this->assign('confirm_url', SITE_URL . 'receive.php?id=' . $order['order_id'] . '&con=' . rawurlencode($order['consignee']));
    			$this->assign('send_msg_url', SITE_URL . RC_Uri::url('user/admin/message_list', 'order_id=' . $order['order_id']));
    
    			$content = $this->fetch_string($tpl['template_content']);
    
    			if (!RC_Mail::send_mail($order['consignee'], $order['email'], $tpl['template_subject'], $content, $tpl['is_html'])) {
    				return new ecjia_error('发送邮件失败', __('操作失败', 'orders'));
    			}
    		}
    
    		/* 商家发货 如果需要，发短信 */
    		$userinfo = RC_DB::table('users')->where('user_id', $order['user_id'])->select('user_name', 'mobile_phone')->first();
    		if (!empty($userinfo['mobile_phone'])) {
    			//发送短信
    			$user_name = $userinfo['user_name'];
    			$options   = array(
    					'mobile' => $userinfo['mobile_phone'],
    					'event'  => 'sms_order_pickup_success',
    					'value'  => array(
    							'user_name' => $user_name,
    							'order_sn'  => $order['order_sn']
    					),
    			);
    			RC_Api::api('sms', 'send_event_sms', $options);
    			//消息通知
    			$orm_user_db = RC_Model::model('orders/orm_users_model');
    			$user_ob     = $orm_user_db->find($order['user_id']);
    
    			$order_pickupscuuess_data = array(
    					'title' => __('订单提货成功', 'orders'),
    					'body'  => sprintf(__('尊敬的%s，您的订单%s已提货成功，期待您下次光顾！', 'orders'), $user_name, $order['order_sn']),
    					'data'  => array(
    							'user_id'   => $order['user_id'],
    							'user_name' => $userinfo['user_name'],
    							'order_id'  => $order['order_id'],
    							'order_sn'  => $order['order_sn'],
    					),
    			);
    
    			$push_orderpickup_success_data = new OrderPickupSuccess($order_pickupscuuess_data);
    			RC_Notification::send($user_ob, $push_orderpickup_success_data);
    		}
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
    			'body'  => __('您的订单已发货，订单号为：' . $order['order_sn'], 'orders'),
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
    					'invoice_no'             => $invoice_no,
    			),
    	);
    
    	$push_order_shipped = new OrderShipped($order_data);
    	RC_Notification::send($user_ob, $push_order_shipped);
    
    	return true;
    }
    
    /**
     * 确认收货
     */
    private function receive($order, $action_note = '')
    {
    	/* 收货确认 */
    	/* 标记订单为“收货确认”，如果是货到付款，同时修改订单为已付款 */
    	$arr            = array('shipping_status' => SS_RECEIVED);
    	$payment = RC_DB::table('payment')->where('pay_id', $order['pay_id'])->first();
    	if ($payment['is_cod']) {
    		$arr['pay_status']   = PS_PAYED;
    		$order['pay_status'] = PS_PAYED;
    	}
    	$update = update_order($order['order_id'], $arr);
    	if ($update) {
    		$data = array(
    				'order_status' => __('已提货', 'orders'),
    				'order_id'     => $order['order_id'],
    				'message'      => __('您的商品已被提货，感谢您下次光顾！', 'orders'),
    				'add_time'     => RC_Time::gmtime()
    		);
    
    		RC_DB::table('order_status_log')->insert($data);
    
    		RC_Api::api('commission', 'add_bill_queue', array('order_type' => 'buy', 'order_id' => $order['order_id']));
    		RC_Api::api('goods', 'update_goods_sales', array('order_id' => $order['order_id']));
    	}
    	/* 记录log */
    	order_action($order['order_sn'], $order['order_status'], SS_RECEIVED, $order['pay_status'], $action_note);
    	return true;
    }
}


// end