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
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * pc模板购物流类 拆单
 * @author 
 */
class cart_pc {
    //获取主订单信息
    public static function get_main_order_info($order_id = 0, $type = 0) {
        $row = RC_DB::table('order_info')->where('order_id', $order_id)->first();
        if ($type == 1) {
            $row['all_ruId'] = self::get_main_order_goods_info($order_id, 1); //订单中所有商品所属商家ID,0代表自营商品，其它商家商品
            $ru_id = explode(",", $row['all_ruId']['ru_id']);
            if (count($ru_id) > 1) {
                $row['order_goods'] = self::get_main_order_goods_info($order_id);
//                 _dump($row['order_goods']);
                $row['newInfo'] = self::get_new_ru_goods_info($row['all_ruId'], $row['order_goods']);
//                 _dump($row['newInfo']);
                $row['newOrder'] = self::get_new_order_info($row['newInfo']);
                $row['orderBonus'] = self::get_new_order_info($row['newInfo'], 1, $row['bonus_id']); //处理商家分单红包
                $row['orderFavourable'] = self::get_new_order_info($row['newInfo'], 2); //处理商家分单优惠活动
            }
        }
        
        return $row;
    }
    
    //获取订单信息--或者--订单中所有商品所属商家ID,0代表自营商品，其它商家商品
    public static function get_main_order_goods_info($order_id = 0, $type = 0) { //is_shipping
//         $sql = "SELECT og.*, g.goods_weight as goodsweight, g.is_shipping FROM " . $GLOBALS['ecs']->table('order_goods') . " as og, " .
//             $GLOBALS['ecs']->table('goods') . " as g" . " WHERE og.goods_id = g.goods_id AND og.order_id = '$order_id'";
//             $res = $GLOBALS['db']->getAll($sql);
            
        $res = RC_DB::table('order_goods as og')->leftJoin('goods as g', RC_DB::raw('og.goods_id'), '=', RC_DB::raw('g.goods_id'))
            ->select(RC_DB::raw('og.*, g.store_id, g.goods_weight as goodsweight, g.is_shipping'))
            ->where(RC_DB::raw('og.order_id'), $order_id)
            ->get();
            
        $arr = array();
        if ($type == 1) {
            $arr['ru_id'] = '';
        }
        foreach ($res as $key => $row) {
//             $sql = "SELECT shipping_type FROM " . $GLOBALS['ecs']->table('order_info') . " WHERE order_id = '" . $row['order_id'] . "'";
//             $row['shipping_type'] = $GLOBALS['db']->getOne($sql, true);//shipping_type 无用 （0-配送，1-自提）
            
            if ($type == 0) {
                $arr[] = $row;
            } else {
                $arr['ru_id'] .= $row['store_id'] . ',';
            }
        }
        
        if ($type == 1) {
            $arr['ru_id'] = explode(',', substr($arr['ru_id'], 0, -1));
            $arr['ru_id'] = array_unique($arr['ru_id']);
            $arr['ru_id'] = implode(',', $arr['ru_id']);
        }
        
        return $arr;
    }
    
    //主次订单拆分新数组
    public static function get_new_ru_goods_info($all_ruId = '', $order_goods = array()) {
        $all_ruId = $all_ruId['ru_id'];
        $arr = array();
        
        if (!empty($all_ruId)) {
            $all_ruId = explode(',', $all_ruId);
            $all_ruId = array_values($all_ruId);
        }
        
        if ($all_ruId) {
            for ($i = 0; $i < count($order_goods); $i++) {
                for ($j = 0; $j < count($all_ruId); $j++) {
                    if ($order_goods[$i]['store_id'] == $all_ruId[$j]) {
                        $arr[$all_ruId[$j]][$i] = $order_goods[$i];
                    }
                }
            }
        }
        
        return $arr;
    }
    
    //运算分单后台每个订单商品总金额以及划分红包类型使用所属商家
    public static function get_new_order_info($newInfo, $type = 0, $bonus_id = 0) {
        
        $arr = array();
        
        if ($type == 0) {
            foreach ($newInfo as $key => $row) {
                $arr[$key]['goods_amount'] = 0;
                $arr[$key]['shopping_fee'] = 0;
                $arr[$key]['goods_id'] = 0;
                
//                 $arr[$key]['ru_list'] = self::get_cart_goods_combined_freight($row, 2, '', $key); //计算商家运费//TODO
                
                $row = array_values($row);
                for ($j = 0; $j < count($row); $j++) {
                    $arr[$key]['goods_id'] = $row[$j]['goods_id'];
                    
                    //ecmoban模板堂 --zhuo start 商品金额促销
                    $goods_amount = $row[$j]['goods_price'] * $row[$j]['goods_number'];
//                     if ($goods_amount > 0) {
//                         $goods_con = self::get_con_goods_amount($goods_amount, $row[$j]['goods_id'], 0, 0, $row[$j]['parent_id']);//特殊优惠活动
//                         $goods_con['amount'] = explode(',', $goods_con['amount']);
//                         $amount = min($goods_con['amount']);
//                         $arr[$key]['goods_amount'] += $amount;
//                     } else {
//                         $arr[$key]['goods_amount'] += $row[$j]['goods_price'] * $row[$j]['goods_number']; //原始
//                     }
                    $arr[$key]['goods_amount'] += $goods_amount; //替换 hyy
                    
                    
                    $arr[$key]['shopping_fee'] = $arr[$key]['ru_list']['shipping_fee'];
                    //ecmoban模板堂 --zhuo end 商品金额促销
                }
            }
        } elseif ($type == 1) { //红包
            foreach ($newInfo as $key => $row) {
                
                $arr[$key]['user_id'] = $key;
                $bonus = self::get_bonus_merchants($bonus_id, $key); //红包信息
                $arr[$key]['bonus'] = $bonus;
            }
        } elseif ($type == 2) { //优惠活动
            foreach ($newInfo as $key => $row) {
                $arr[$key]['user_id'] = $key;
                if ($key > 0) {
                    RC_Loader::load_app_func('cart', 'cart');
                    $arr[$key]['compute_discount'] = compute_discount($type, $row, 1);
                } else {
                    $arr[$key]['compute_discount'] = array('discount' => 0, 'name' => array());
                }
            }
        }
        
        return $arr;
    }
    
    //查询订单中所使用的红包等归属信息，所属商家(ID : bt.user_id)
    public static function get_bonus_merchants($bonus_id = 0, $user_id = 0) {
//         $sql = "select bt.user_id, bt.type_money from " . $GLOBALS['ecs']->table('user_bonus') . " as ub" .
//             " left join " . $GLOBALS['ecs']->table('bonus_type') . " as bt on ub.bonus_type_id = bt.type_id" .
//             " where ub.bonus_id = '$bonus_id' and bt.user_id = '$user_id'";
//         return $GLOBALS['db']->getRow($sql);
        
        return RC_DB::table('user_bonus as ub')->leftJoin('bonus_type as bt', RC_DB::raw('ub.bonus_type_id'), '=', RC_DB::raw('bt.type_id'))
        ->select(RC_DB::raw('ub.user_id, bt.store_id, bt.type_money, bt.usebonus_type, bt.min_goods_amount'))
        ->where(RC_DB::raw('ub.bonus_id'), $bonus_id)
        ->where(RC_DB::raw('ub.user_id'), $user_id)
        ->first();
    }
    
    /**
     * 分单插入数据
     * @param type $orderInfo---订单信息包含订单商品
     * @param type $row -- 纯订单信息
     * @param type $order_id
     */
    public static function get_insert_order_goods_single($orderInfo, $row, $order_id, $ru_number) {
        $newOrder = $orderInfo['newOrder'];
        $orderBonus = $orderInfo['orderBonus'];
        $newInfo = $orderInfo['newInfo'];
        $orderFavourable = $orderInfo['orderFavourable'];
        $surplus = $row['surplus']; //余额
        $integral_money = $row['integral_money']; //积分
        $shipping_fee = $row['shipping_fee']; //运费
        $use_bonus = 0;
        $discount = $row['discount']; //折扣金额
        $commonuse_discount = self::get_single_order_fav($discount, $orderFavourable, 1); //全场通用折扣金额
        $discount_child = 0;
        $residue_integral = 0;
        $bonus_id = $row['bonus_id']; //红包ID
        $bonus = $row['bonus']; //红包金额
        $coupons = $row['coupons']; //优惠券金额
        
        $usebonus_type = self::get_bonus_all_goods($bonus_id); //全场通用红包 val:1
        
        $shipping_id = $row['shipping_id'];
        $shipping_name = $row['shipping_name'];
        $shipping_code = $row['shipping_code'];
        $shipping_type = $row['shipping_type'];
        
        $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;
        
        $arr = array();
        $sms_send = array();
        $i = 0;
        $payment_method = RC_Loader::load_app_class('payment_method','payment');
        foreach ($newInfo as $key => $info) {
            $i +=1;
            $arr[$key] = $info;
            
            $row['store_id'] = $key;
            $shipping = self::get_seller_shipping_order($key, $shipping_id, $shipping_name, $shipping_code, $shipping_type);
//             _dump($shipping,1);
            $row['shipping_id'] = $shipping['shipping_id'];
            $row['shipping_name'] = $shipping['shipping_name'];
//             $row['shipping_code'] = $shipping['shipping_code'];
//             $row['shipping_type'] = $shipping['shipping_type'];
            
            // 插入订单表 start
            $error_no = 0;
            do {
//                 $row['order_sn'] = get_order_child_sn($order_id, $key); //获取新订单号
                $row['order_sn'] = ecjia_order_buy_sn();
                $_SESSION['order_done_sn'] = $row['order_sn'];
                
                $row['main_order_id'] = $order_id; //获取主订单ID
                $row['goods_amount'] = $newOrder[$key]['goods_amount']; //商品总金额
                //折扣 start
                if ($commonuse_discount['has_terrace'] == 1) {
                    if ($key == 0) { //优惠活动全场通用折扣金额算入平台
                        $row['discount'] = $commonuse_discount['discount']; //全场通用折扣金额
                    } else {
                        $row['discount'] = $orderFavourable[$key]['compute_discount']['discount']; //全场通用折扣金额
                    }
                } else {
                    $row['discount'] = $orderFavourable[$key]['compute_discount']['discount'] + $commonuse_discount['discount']; //折扣金额
                    $commonuse_discount['discount'] = 0;
                }
                //折扣 end
                $cou_type = 0;
                
                //获取默认运费模式运费 by wu start
                $row['shipping_fee'] = 0;//TODO
                $sellerOrderInfo = array();
                $sellerOrderInfo['store_id'] = $key;
                $sellerOrderInfo['weight'] = 0;
                $sellerOrderInfo['amount'] = 0;
                $sellerOrderInfo['number'] = 1;
                $sellerOrderInfo['region'] = array($row['country'], $row['province'], $row['city'], $row['district'], $row['street']);
                $sellerOrderInfo['shipping_id'] = $row['shipping_id'];
                
                if (!empty($newInfo[$key])) {
                    foreach ($newInfo[$key] as $v) {
                        if (isset($v['order_id'])) {
                            $sellerOrderInfo['weight'] += floatval($v['goodsweight']*$v['goods_number']);
                            $sellerOrderInfo['amount'] += floatval($v['goods_price']*$v['goods_number']);
                            $sellerOrderInfo['number'] += intval($v['goods_number']);
                        }
                    }
                    
                    //$row['shipping_fee'] = getSellerShippingFee($sellerOrderInfo, $arr[$key]);//替换
                    if($sellerOrderInfo['shipping_id']) {
                        $shipping_area = ecjia_shipping::shippingArea(intval($sellerOrderInfo['shipping_id']), $sellerOrderInfo['region'], $sellerOrderInfo['store_id']);
                        if($shipping_area) {
                            $row['shipping_fee'] = ecjia_shipping::fee($shipping_area['shipping_area_id'], $sellerOrderInfo['weight'], $sellerOrderInfo['amount'], $sellerOrderInfo['number']);
                        }
                    }
                }
                
                //获取默认运费模式运费 by wu end
                $row['order_amount'] = $newOrder[$key]['goods_amount'] + $row['shipping_fee']; //订单应付金额
                
                /* 税额 */
                $row['tax'] = self::get_order_invoice_total($row['goods_amount'], $row['inv_content']);
                $row['order_amount'] = $row['order_amount'] + $row['tax'];
                
                //减去优惠券金额 start
                if($row['coupons'] > 0){
                    if($row['order_amount'] >= $row['coupons']){
                        $row['order_amount'] -= $row['coupons'];
                    }else{
                        $row['coupons'] = $row['order_amount'];
                        $row['order_amount'] = 0;
                    }
                }
                //减去优惠券金额 end
                
                //规避折扣之后订单金额为负数
                if ($commonuse_discount['has_terrace'] == 0) {
                    
                    if ($discount_child > 0) {
                        $row['discount'] += $discount_child;
                    }
                    if ($row['discount'] > 0) {
                        if ($row['order_amount'] > $row['discount']) {
                            $row['order_amount'] -= $row['discount'];
                        } else {
                            $discount_child = $row['discount'] - $row['order_amount']; //剩余折扣金额
                            $row['discount'] = $row['order_amount'];
                            $row['order_amount'] = 0;
                        }
                    }
                } else {
                    $row['order_amount'] -= $row['discount'];
                }
                
                // 减去红包 start
                if ($usebonus_type == 1) {
                    if ($bonus > 0) {
                        if ($row['order_amount'] >= $bonus) {
                            $row['order_amount'] = $row['order_amount'] - $bonus;
                            $row['bonus'] = $bonus;
                            $bonus = 0;
                        } else {
                            $bonus = $bonus - $row['order_amount'];
                            $row['bonus'] = $row['order_amount'];
                            $row['order_amount'] = 0;
                        }
                        
                        $row['bonus_id'] = $bonus_id;
                    } else {
                        $row['bonus'] = 0;
                        $row['bonus_id'] = 0;
                    }
                } else {
                    if (isset($orderBonus[$key]['bonus']['type_money'])) {
                        $use_bonus = min($orderBonus[$key]['bonus']['type_money'], $row['order_amount']); // 实际减去的红包金额
                        $row['order_amount'] -= $use_bonus;
                        $row['bonus'] = $orderBonus[$key]['bonus']['type_money'];
                        $row['bonus_id'] = $row['bonus_id'];
                    } else {
                        $row['bonus'] = 0;
                        $row['bonus_id'] = 0;
                    }
                }
                // 减去红包 end
                
                //余额 start
                if ($surplus > 0) {
                    if ($surplus >= $row['order_amount']) {
                        $surplus = $surplus - $row['order_amount'];
                        $row['surplus'] = $row['order_amount']; //订单金额等于当前使用余额
                        $row['order_amount'] = 0;
                    } else {
                        $row['order_amount'] = $row['order_amount'] - $surplus;
                        $row['surplus'] = $surplus;
                        $surplus = 0;
                    }
                } else {
                    $row['surplus'] = 0;
                }
                //余额 end
                //积分 start by kong
                if ($integral_money > 0) {
                    if ($i < $ru_number) {
                        $integral_ratio = self::get_integral_ratio($order_id, $info); //子订单商品可用积分比例
                        $row['integral_money'] = round($integral_money * $integral_ratio, 2);
                        $row['integral'] = $integral_money * $integral_ratio;
                        $row['order_amount'] = $row['order_amount'] - (round($integral_money * $integral_ratio, 2));
                        $residue_integral += $integral_money * $integral_ratio;
                    } else {
                        $row['integral'] = $integral_money - $residue_integral;
                        $row['integral_money'] = round($row['integral'], 2);
                        $row['order_amount'] = $row['order_amount'] - (round($row['integral'], 2));
                    }
                } else {
                    $row['integral_money'] = 0;
                    $row['integral'] = 0;
                }
                
                $row['integral'] = intval(self::integral_of_value($row['integral'])); //转换积分
                //积分 end
                
                $row['order_amount'] = number_format($row['order_amount'], 2, '.', ''); //格式化价格为一个数字
                
                /* 如果订单金额为0（使用余额或积分或红包支付），修改订单状态为已确认、已付款 */
                if ($row['order_amount'] <= 0) {
                    $row['order_status'] = OS_CONFIRMED;
                    $row['confirm_time'] = RC_Time::gmtime();
                    $row['pay_status'] = PS_PAYED;
                    $row['pay_time'] = RC_Time::gmtime();
                } else {
                    $row['order_status'] = 0;
                    $row['confirm_time'] = 0;
                    $row['pay_status'] = 0;
                    $row['pay_time'] = 0;
                }
                
                unset($row['order_id']);
                unset($row['log_id']);
                //商家---剔除自提点信息
//                 if ($row['shipping_code'] != 'cac') {
//                     $row['point_id'] = 0;
//                     $row['shipping_dateStr'] = '';
//                 }
                
//                 $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('order_info'), $row, 'INSERT');
//                 $new_orderId = $GLOBALS['db']->insert_id();
//                 _dump($row,1);
                $new_orderId = RC_DB::table('order_info')->insertGetId($row);
                
//                 $error_no = $GLOBALS['db']->errno();
                
//                 if ($error_no > 0 && $error_no != 1062) {
//                     die($GLOBALS['db']->errorMsg());
//                 }
                //修改优惠券使用order_id
//                 if($cou_type == 1){
//                     $cou_sql = "UPDATE".$GLOBALS['ecs']->table('coupons_user')."SET order_id = '$new_orderId' WHERE user_id = '".$row['user_id']."' AND order_id = '$order_id'";
//                     $GLOBALS['db']->query($cou_sql);
//                 }
                /* 如果需要，发短信 */
//                 if ($key == 0) {
//                     $sms_shop_mobile = $GLOBALS['_CFG']['sms_shop_mobile']; //手机
//                 } else {
//                     $sql = "SELECT mobile FROM " . $GLOBALS['ecs']->table('seller_shopinfo') . " WHERE ru_id = '$key'";
//                     $sms_shop_mobile = $GLOBALS['db']->getOne($sql); //手机
//                     $sql = "SELECT seller_email FROM " . $GLOBALS['ecs']->table('seller_shopinfo') . " WHERE ru_id = '$key'";
//                 }
                
                //是否开启下单自动发短信、邮件 by wu start
//                 $sql = " select * from " . $GLOBALS['ecs']->table('crons') . " where cron_code='auto_sms' and enable=1 LIMIT 1";
//                 $auto_sms = $GLOBALS['db']->getRow($sql);
                
                /* 给商家发短信 */
//                 if ($GLOBALS['_CFG']['sms_order_placed'] == '1' && $sms_shop_mobile != '') {}
            } while ($error_no == 1062); //如果是订单号重复则重新提交数据
            
            $arr[$key] = array_values($arr[$key]);
            for ($j = 0; $j < count($arr[$key]); $j++) {
                $arr[$key][$j]['order_id'] = $new_orderId;
                unset($arr[$key][$j]['rec_id']);unset($arr[$key][$j]['store_id']);
                unset($arr[$key][$j]['goodsweight']);unset($arr[$key][$j]['is_shipping']);
                $arr[$key][$j]['goods_name'] = addslashes($arr[$key][$j]['goods_name']);
                $arr[$key][$j]['goods_attr'] = addslashes($arr[$key][$j]['goods_attr']);
//                 $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('order_goods'), $arr[$key][$j], 'INSERT');
                RC_DB::table('order_goods')->insert($arr[$key][$j]);
                /* 虚拟卡 */
//                 $virtual_goods = get_virtual_goods($arr[$key][$j]['order_id']);
//                 $order_sn = $GLOBALS['db']->getOne(" SELECT order_sn FROM ".$GLOBALS['ecs']->table("order_info")." WHERE order_id = '".$arr[$key][$j]['order_id']."' ");
//                 $msg = '';
//                 if ($virtual_goods AND $flow_type != CART_GROUP_BUY_GOODS) {
//                     /* 虚拟卡发货 */
//                     if (virtual_goods_ship($virtual_goods, $msg, $order_sn, true)) {
//                         /* 如果没有实体商品，修改发货状态，送积分和红包 */
//                         $sql = "SELECT COUNT(*)" .
//                             " FROM " . $GLOBALS['ecs']->table('order_goods') .
//                             " WHERE order_id = '".$arr[$key][$j]['order_id']."' " .
//                             " AND is_real = 1";
//                         if ($GLOBALS['db']->getOne($sql) <= 0) {
//                             /* 修改订单状态 */
//                             update_order($arr[$key][$j]['order_id'], array('shipping_status' => SS_SHIPPED, 'shipping_time' => gmtime()));
//                         }
//                     }
//                 }
            }
            
            /* 插入支付日志 */
            $row['log_id'] = $payment_method->insert_pay_log($new_orderId, $row['order_amount'], PAY_ORDER);
        }
        return true;
        
//         if ($GLOBALS['_CFG']['sms_type'] >=1) {
//             $resp = $GLOBALS['ecs']->ali_yu($sms_send, 1);
//         }
    }
    
    //提交订单配送方式 --ecmoban模板堂 --zhuo
    public static function get_order_post_shipping($shipping, $shippingCode = array(), $shippingType = array(), $ru_id = 0){
        
        $shipping_list = array();
        if($shipping){
            $shipping_id = '';
            foreach($shipping as $k1=>$v1){
                
                $v1 = !empty($v1) ? intval($v1) : 0;
                $shippingCode[$k1] = !empty($shippingCode[$k1]) ? addslashes($shippingCode[$k1]) : '';
                $shippingType[$k1] = empty($shippingType[$k1]) ?  0 : intval($shippingType[$k1]);
                
//                 $shippingInfo = shipping_info($v1);
                $shippingInfo = ecjia_shipping::pluginData($v1);
                
                foreach($ru_id as $k2=>$v2){
                    if($k1 == $k2){
                        $shipping_id .= $v2. "|" .$v1 . ",";  //商家ID + 配送ID
                        $shipping_name .= $v2. "|" .$shippingInfo['shipping_name'] . ",";  //商家ID + 配送名称
                        $shipping_code .= $v2. "|" .$shippingCode[$k1] . ",";  //商家ID + 配送code
                        $shipping_type .= $v2. "|" .$shippingType[$k1] . ",";  //商家ID + （配送或自提）
                        
                    }
                }
            }
            
            $shipping_id = substr($shipping_id, 0, -1);
            $shipping_name = substr($shipping_name, 0, -1);
            $shipping_code = substr($shipping_code, 0, -1);
            $shipping_type = substr($shipping_type, 0, -1);
            $shipping_list = array(
                'shipping_id' => $shipping_id,
                'shipping_name' => $shipping_name,
                'shipping_code' => $shipping_code,
                'shipping_type' => $shipping_type
            );
        }
        return $shipping_list;
    }
    
    //查询票税金额
    public static function get_order_invoice_total($goods_price, $inv_content){
        $invoice_type  = ecjia::config('invoice_type');
        $invoice_type = unserialize($invoice_type);
        $invoice = self::get_invoice_list($invoice_type, 1, $inv_content);
        
        $tax = 0;
        if($invoice){
            $rate = floatval($invoice['rate']) / 100;
            if ($rate > 0)
            {
                $tax = $rate * $goods_price;
            }
        }
        
        return $tax;
    }
    
    //获取票税列表
    public static function get_invoice_list($invoice, $order_type = 0, $inv_content = '') {
        
        $arr = array();
        if ($invoice['type']) {
            $type = array_values($invoice['type']);
            $rate = array_values($invoice['rate']);
            
            for ($i = 0; $i < count($type); $i++) {
                if($order_type == 1){
                    if ($type[$i] == $inv_content) {
                        $arr['type'] = $type[$i];
                        $arr['rate'] = $rate[$i];
                    }
                }else{
                    $arr[$i]['type'] = $type[$i];
                    $arr[$i]['rate'] = $rate[$i];
                }
            }
        }
        
        return $arr;
    }
    /**
     * 计算指定的金额需要多少积分
     *
     * @access  public
     * @param   integer $value  金额
     * @return  void
     */
    public static function integral_of_value($integral)
    {
        $scale = floatval(ecjia::config('integral_scale'));
        return $scale > 0 ? round($integral / 100 * $scale, 2) : 0;
    }
    
    /*获取子订单积分比例 by kong*/
    public static function get_integral_ratio($order_id = 0, $info=array()){
        // 获取订单商品总共可用积分
        $count_goods_integral = self::get_integral($order_id);
        $goods_id = array();
        if(!empty($info)){
            foreach($info as $v){
                $goods_id[] = $v['goods_id'];
            }
        }
        
        /*获取分单商品总共可用积分*/
        $chlid_goods_integral = self::get_integral($order_id, $goods_id);
        $integral_ratio = $chlid_goods_integral/$count_goods_integral;
        
        return $integral_ratio;
    }
    
    /*获取指定订单，订单商品总共可用积分 by kong*/
    public static function get_integral($order_id = 0,$goods_id=array()){
        
//         $where= '' ;
//         if(!empty($goods_id)){
//             $where = "AND og.goods_id ".db_create_in($goods_id);
//         }
//         $sql="SELECT g.integral*og.goods_number as integral FROM".$GLOBALS['ecs']->table('goods')." AS g "
//             . "LEFT JOIN ".$GLOBALS['ecs']->table('order_goods')." AS og ON g.goods_id = og.goods_id WHERE og.order_id='$order_id'".$where;
//             $rel =  $GLOBALS['db']->getAll($sql);
            
            $db = RC_DB::table('goods as g')->leftJoin('order_goods as og', RC_DB::raw('g.goods_id'), '=', RC_DB::raw('og.goods_id'))
            ->select(RC_DB::raw('g.integral*og.goods_number as integral'))
            ->where(RC_DB::raw('og.order_id'), $order_id);
            if(!empty($goods_id)){
                $db->whereIn(RC_DB::raw('og.goods_id'), $goods_id);
            }
            $rel = $db->get();
            
            $count = 0;
            foreach($rel as $v){
                $count += $v['integral'];
            }
            
            return $count;
    }
    
    //查询订单是否红包全场通用
    public static function get_bonus_all_goods($bonus_id){
//         $sql = "SELECT t.usebonus_type FROM " .$GLOBALS['ecs']->table('bonus_type') ." as t, " .$GLOBALS['ecs']->table('user_bonus') ." as ub". " WHERE t.type_id = ub.bonus_type_id AND ub.bonus_id = '$bonus_id'";
//         return $GLOBALS['db']->getOne($sql);
        return RC_DB::table('user_bonus as ub')->leftJoin('bonus_type as bt', RC_DB::raw('ub.bonus_type_id'), '=', RC_DB::raw('bt.type_id'))
        ->where(RC_DB::raw('ub.bonus_id'), $bonus_id)
        ->pluck(RC_DB::raw('bt.usebonus_type'));
    }
    
    //商家配送方式分单分组
    public static function get_seller_shipping_order($ru_id = array(), $shipping_id = array(), $shipping_name = array(), $shipping_code = array(), $shipping_type = array()){
        $shipping_id = explode(',', $shipping_id);
        $shipping_name = explode(',', $shipping_name);
        $shipping_code = explode(',', $shipping_code);
        $shipping_type = explode(',', $shipping_type);
        
        $shippingId = '';
        $shippingName = '';
        $shippingCode = '';
        $shippingType = '';
        
        foreach($shipping_id as $key=>$row){
            $row = explode('|', $row);
            if($row[0] == $ru_id){
                $shippingId = $row[1];
            }
        }
        
        foreach($shipping_name as $key=>$row){
            $row = explode('|', $row);
            if($row[0] == $ru_id){
                $shippingName = $row[1];
            }
        }
        
        if($shipping_code){
            foreach($shipping_code as $key=>$row){
                $row = explode('|', $row);
                if($row[0] == $ru_id){
                    $shippingCode = $row[1];
                }
            }
        }
        
        if($shipping_type){
            foreach($shipping_type as $key=>$row){
                $row = explode('|', $row);
                if($row[0] == $ru_id){
                    $shippingType = $row[1];
                }
            }
        }
        
        $shipping = array('shipping_id' => $shippingId, 'shipping_name' => $shippingName, 'shipping_code' => $shippingCode, 'shipping_type' => $shippingType);
        return $shipping;
    }
    
    /*
    * 合计全场通用优惠活动折扣金额
    */
    
    public static function get_single_order_fav($discount_all = '', $orderFavourable = array(), $type = 0) {
        
        $discount = 0;
        $has_terrace = '';
        foreach ($orderFavourable as $key => $row) {
            $discount += $row['compute_discount']['discount'];
            $has_terrace .= $key . ",";
        }
        
        if ($has_terrace != '') {
            $has_terrace = substr($has_terrace, 0, -1);
            $has_terrace = explode(",", $has_terrace);
        }
        
        if (in_array(0, $has_terrace)) {
            $has_terrace = 1; //有平台商品
        } else {
            $has_terrace = 0; //无平台商品
        }
        
        $discount_all = number_format(($discount_all), 2, '.', '');
        $discount = number_format(($discount), 2, '.', '');
        $commonuse_discount = $discount_all - $discount;
        
        return array('discount' => $commonuse_discount, 'has_terrace' => $has_terrace);
    }
    
    /*
     * 合计运费
     * 购物车显示
     * 订单分单
     * $type
     */
    public static function get_cart_goods_combined_freight($goods, $type = 0, $region = '', $ru_id = 0, $shipping_id = 0) {
        
        $arr = array();
        $new_arr = array();
        
        if ($type == 1) { //购物提交订单页面显示
            foreach ($goods as $key => $row) {
                foreach ($row as $warehouse => $rows) {
                    foreach ($rows as $gkey => $grow) {
                        
                        $trow = get_goods_transport($grow['tid']);
                        
                        if ($grow['extension_code'] == 'package_buy' || $grow['is_shipping'] == 0) {
                            
                            //商品ID + 商家ID + 运费模板 + 商品运费类型
                            @$arr[$key][$warehouse]['goods_transport'] .= $grow['goods_id'] . "|" . $key . "|" . $grow['tid'] . "|" . $grow['freight'] . "|" . $grow['shipping_fee'] . "|" . $grow['goods_number'] . "|" . $grow['goodsweight'] . "|" . $grow['goods_price'] . "-";
                            
                            if ($grow['freight'] && $trow['freight_type'] == 0) {
                                
                                /**
                                 * 商品
                                 * 运费模板
                                 */
                                
                                $weight = 0; //商品总重量
                                $goods_price = 0; //商品总金额
                                $number = 0; //商品总数量
                            } else {
                                $weight = $grow['goodsweight'] * $grow['goods_number']; //商品总重量
                                $goods_price = $grow['goods_price'] * $grow['goods_number']; //商品总金额
                                $number = $grow['goods_number']; //商品总数量
                            }
                            
                            @$arr[$key][$warehouse]['weight'] += $weight;
                            @$arr[$key][$warehouse]['goods_price'] += $goods_price;
                            @$arr[$key][$warehouse]['number'] += $number;
                            @$arr[$key][$warehouse]['ru_id'] = $key; //商家ID
                            @$arr[$key][$warehouse]['warehouse_id'] = $warehouse; //仓库ID
                            @$arr[$key][$warehouse]['warehouse_name'] = $GLOBALS['db']->getOne("SELECT region_name FROM " . $GLOBALS['ecs']->table("region_warehouse") . " WHERE region_id = '$warehouse'"); //仓库名称
                        }
                    }
                }
            }
            
            foreach ($arr as $key => $row) {
//                 if (!empty($shipping_id)) {
                    $shipping_info = get_shipping_code($shipping_id);
                    $shipping_code = $shipping_info['shipping_code'];
//                 } else {
//                     $seller_shipping = get_seller_shipping_type($key);
//                     $shipping_code = $seller_shipping['shipping_code']; //配送代码
//                 }
                foreach ($row as $warehouse => $rows) {
                    @$arr[$key][$warehouse]['shipping'] = get_goods_freight($rows, $rows['warehouse_id'], $region, $rows['goods_number'], $shipping_code);
                }
            }
            
            $new_arr['shipping_fee'] = 0;
            foreach ($arr as $key => $row) {
                foreach ($row as $warehouse => $rows) {
                    //自营--自提时--运费清0
                    if (isset($rows['shipping_code']) && $rows['shipping_code'] == 'cac') {
                        $rows['shipping']['shipping_fee'] = 0;
                    }
                    $new_arr['shipping_fee'] += $rows['shipping']['shipping_fee'];
                }
            }
            
            $arr = array('ru_list' => $arr, 'shipping' => $new_arr);
            return $arr;
        } elseif ($type == 2) { //订单分单
            //TODO $arr = get_cart_goods_warehouse_list($goods);
            
            foreach ($arr as $warehouse => $row) {
                
                foreach ($row as $gw => $grow) {
                    if ($grow['extension_code'] == 'package_buy' || $grow['is_shipping'] == 0) {
                        
                        $trow = get_goods_transport($grow['tid']);
                        
                        //商品ID + 商家ID + 运费模板 + 商品运费类型
                        @$new_arr[$warehouse]['goods_transport'] .= $grow['goods_id'] . "|" . $grow['ru_id'] . "|" . $grow['tid'] . "|" . $grow['freight'] . "|" . $grow['shipping_fee'] . "|" . $grow['goods_number'] . "|" . $grow['goodsweight'] . "|" . $grow['goods_price'] . "-";
                        
                        if ($grow['freight'] && $trow['freight_type'] == 0) {
                            /**
                             * 商品
                             * 运费模板
                             */
                            $weight = 0; //商品总重量
                            $goods_price = 0; //商品总金额
                            $number = 0; //商品总数量
                        } else {
                            $weight = $grow['goodsweight'] * $grow['goods_number']; //商品总重量
                            $goods_price = $grow['goods_price'] * $grow['goods_number']; //商品总金额
                            $number = $grow['goods_number']; //商品总数量
                        }
                        
                        @$new_arr[$warehouse]['weight'] += $weight; //商品总重量
                        @$new_arr[$warehouse]['goods_price'] += $goods_price; //商品总金额
                        @$new_arr[$warehouse]['number'] += $number; //商品总数量
                        @$new_arr[$warehouse]['ru_id'] = $grow['ru_id']; //商家ID
//                         @$new_arr[$warehouse]['warehouse_id'] = $warehouse; //仓库ID
                        @$new_arr[$warehouse]['order_id'] = $grow['order_id']; //订单ID
//                         @$new_arr[$warehouse]['warehouse_name'] = $GLOBALS['db']->getOne("SELECT region_name FROM " . $GLOBALS['ecs']->table("region_warehouse") . " WHERE region_id = '$warehouse'"); //仓库名称
                    }
                }
            }
            $new_arr['shipping_fee'] = 0;
            foreach ($new_arr as $key => $row) {
                $sql = "SELECT country, province, city, district, district, street, shipping_id FROM " . $GLOBALS['ecs']->table('order_info') . " WHERE order_id = '" . $row['order_id'] . "'";
                $order = $GLOBALS['db']->getRow($sql);
                
                $shipping_arr = explode(",", $order['shipping_id']);
                if (is_array($shipping_arr)) {
                    foreach ($shipping_arr as $kk => $vv) {
                        $ruid_shipping = explode("|", $vv);
                        if ($ruid_shipping[0] == $ru_id) {
                            $shipping_info = get_shipping_code($ruid_shipping[1]);
                            $shipping_code = $shipping_info['shipping_code'];
                            continue;
                        }
                    }
                }
                
                @$new_arr[$key]['shipping'] = get_goods_freight($row, $row['warehouse_id'], $order, $row['number'], $shipping_code);
                //自营--自提时--运费清0
//                 if ($ru_id == 0 && $shipping_type == 1) {
//                     $new_arr[$key]['shipping']['shipping_fee'] = 0;
//                 }
                $new_arr['shipping_fee'] += $new_arr[$key]['shipping']['shipping_fee'];
            }
            $arr = $new_arr;
        }
        
        return $arr;
    }
    
    //促销--商品最终金额 - 删除
    function get_con_goods_amount($goods_amount = 0, $goods_id = 0, $type = 0, $shipping_fee = 0, $parent_id = 0) {
        
        if ($parent_id == 0) {
            if ($type == 0) {
                $table = 'goods_consumption';
            } elseif ($type == 1) {
                $table = 'goods_conshipping';
                
                if (empty($shipping_fee)) {
                    $shipping_fee = 0;
                }
            }
            
            $res = get_goods_con_list($goods_id, $table, $type);
            
            if ($res) {
                $arr = array();
                $arr['amount'] = '';
                foreach ($res as $key => $row) {
                    
                    if ($type == 0) {
                        if ($goods_amount >= $row['cfull']) {
                            $arr[$key]['cfull'] = $row['cfull'];
                            $arr[$key]['creduce'] = $row['creduce'];
                            $arr[$key]['goods_amount'] = $goods_amount - $row['creduce'];
                            
                            if ($arr[$key]['goods_amount'] > 0) {
                                $arr['amount'] .= $arr[$key]['goods_amount'] . ',';
                            }
                        }
                    } elseif ($type == 1) {
                        if ($goods_amount >= $row['sfull']) {
                            $arr[$key]['sfull'] = $row['sfull'];
                            $arr[$key]['sreduce'] = $row['sreduce'];
                            if ($shipping_fee > 0) { //运费要大于0时才参加商品促销活动
                                $arr[$key]['shipping_fee'] = $shipping_fee - $row['sreduce'];
                                $arr['amount'] .= $arr[$key]['shipping_fee'] . ',';
                            } else {
                                $arr['amount'] = '0' . ',';
                            }
                        }
                    }
                }
                
                if ($type == 0) {
                    if (!empty($arr['amount'])) {
                        $arr['amount'] = substr($arr['amount'], 0, -1);
                    } else {
                        $arr['amount'] = $goods_amount;
                    }
                } elseif ($type == 1) {
                    if (!empty($arr['amount'])) {
                        $arr['amount'] = substr($arr['amount'], 0, -1);
                    } else {
                        $arr['amount'] = $shipping_fee;
                    }
                }
            } else {
                if ($type == 0) {
                    $arr['amount'] = $goods_amount;
                } elseif ($type == 1) {
                    $arr['amount'] = $shipping_fee;
                }
            }
            
            //消费满最大金额免运费
            if ($type == 1) {
//                 $sql = "SELECT largest_amount FROM " . $GLOBALS['ecs']->table('goods') . " WHERE goods_id = '$goods_id'";
//                 $largest_amount = $GLOBALS['db']->getOne($sql, true);
                
//                 if ($largest_amount > 0 && $goods_amount > $largest_amount) {
//                     $arr['amount'] = 0;
//                 }
            }
        } else {
            if ($type == 0) {
                $arr['amount'] = $goods_amount;
            } elseif ($type == 1) {
                $arr['amount'] = $shipping_fee;
            }
        }
        
        return $arr;
    }
    
    //查询商品满减促销信息 - 删除
    function get_goods_con_list($goods_id = 0, $table, $type = 0) {
        $sql = "SELECT * FROM " . $GLOBALS['ecs']->table($table) . " WHERE goods_id = '$goods_id'";
        $res = $GLOBALS['db']->getAll($sql);
        
        $arr = array();
        foreach ($res as $key => $row) {
            $arr[$key]['id'] = $row['id'];
            if ($type == 0) {
                $arr[$key]['cfull'] = $row['cfull'];
                $arr[$key]['creduce'] = $row['creduce'];
            } elseif ($type == 1) {
                $arr[$key]['sfull'] = $row['sfull'];
                $arr[$key]['sreduce'] = $row['sreduce'];
            }
        }
        
        if ($type == 0) {
            $arr = get_array_sort($arr, 'cfull');
        } elseif ($type == 1) {
            $arr = get_array_sort($arr, 'sfull');
        }
        
        return $arr;
    }
    
    
}

// end