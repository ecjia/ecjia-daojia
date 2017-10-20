<?php
defined('IN_ECJIA') or exit('No permission resources.');

class done_module extends api_admin implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {	
		
		/**
         * bonus 0 //红包
         * how_oos 0 //缺货处理
         * integral 0 //积分
         * payment 3 //支付方式
         * postscript //订单留言
         * shipping 3 //配送方式
         * surplus 0 //余额
         * inv_type 4 //发票类型
         * inv_payee 发票抬头
         * inv_content 发票内容
         */
    	
    	$this->authadminSession();
    	
        if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
    	define('SESS_ID', RC_Session::session()->getSessionKey());
    	
    	if ($_SESSION['temp_user_id'] > 0) {
    		$_SESSION['user_id'] = $_SESSION['temp_user_id'];
    	}
    	
        RC_Loader::load_app_func('cart','cart');
        RC_Loader::load_app_func('admin_order','orders');
        
        //获取所需购买购物车id  will.chen
        $rec_id = $this->requestData('rec_id', 0);
        $rec_id = empty($rec_id) ? $_SESSION['cart_id'] : $rec_id;
		$cart_id = empty($rec_id) ? '' : explode(',', $rec_id);
		
        /* 取得购物类型 */
        $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;
        
        /* 检查购物车中是否有商品 */
		$db_cart = RC_Loader::load_app_model('cart_model', 'cart');
		
		$cart_where = array('parent_id' => 0 , 'is_gift' => 0 , 'rec_type' => $flow_type);
		if (!empty($cart_id)) {
			$cart_where = array_merge($cart_where, array('rec_id' => $cart_id));
		}
		if ($_SESSION['user_id']) {
			$cart_where = array_merge($cart_where, array('user_id' => $_SESSION['user_id']));
			$count = $db_cart->where($cart_where)->count();
		} else {
			$cart_where = array_merge($cart_where, array('session_id' => SESS_ID));
			$count = $db_cart->where($cart_where)->count();
		}
        
        if ($count == 0) {
        	return new ecjia_error('no_goods_in_cart', '购物车中没有商品');
        }
        /* 检查商品库存 */
        /* 如果使用库存，且下订单时减库存，则减少库存 */
        if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE) {
			$cart_goods_stock = get_cart_goods($cart_id);
            $_cart_goods_stock = array();
            foreach ($cart_goods_stock['goods_list'] as $value) {
                $_cart_goods_stock[$value['rec_id']] = $value['goods_number'];
            }
            $result = flow_cart_stock($_cart_goods_stock);
            if (is_ecjia_error($result)) {            	
            	return new ecjia_error('Inventory shortage', '库存不足');
            }
            unset($cart_goods_stock, $_cart_goods_stock);
        }        
        
        /* 判断是否是会员 */
        $consignee = array();
        if ($_SESSION['user_id']) {
        	$db_user_model = RC_Loader::load_app_model('users_model','user');
        	$user_info = $db_user_model->field('user_name, mobile_phone, email')
							        	->where(array('user_id'=>$_SESSION['user_id']))
							        	->find();
        	$consignee = array(
        			'consignee'		=> $user_info['user_name'],
        			'mobile'		=> $user_info['mobile_phone'],
        			'tel'			=> $user_info['mobile_phone'],
        			'email'			=> $user_info['email'],
        	);
        } else {//匿名用户
        	$consignee = array(
        			'consignee'	=> '匿名用户',
        			'mobile'	=> '',
        			'tel'		=> '',
        			'email'		=> '',
        	);
        }
        
        
        /* 获取商家或平台的地址 作为收货地址 */
        if ($_SESSION['store_id'] > 0){
            RC_Loader::load_app_func('merchant_store','store');
            $info = get_store_full_info($_SESSION['store_id']);
        	$region_info = array(
        			'province'			=> $info['province_id'],
        			'city'				=> $info['city_id'],
	       			'address'			=> $info['address_id'],
        	);
        	$consignee = array_merge($consignee, $region_info);
        } else {
        	$region_info = array(
        			'country'			=> ecjia::config('shop_country'),
        			'province'			=> ecjia::config('shop_province'),
        			'city'				=> ecjia::config('shop_city'),
        			'address'			=> ecjia::config('shop_address'),
        	);
        	$consignee = array_merge($consignee, $region_info);
        }
        
        $how_oos 				= $this->requestData('how_oos', 0);
        $card_message 			= $this->requestData('card_message', '');
        $inv_type		 		= $this->requestData('inv_type', '');
        $inv_payee			 	= $this->requestData('inv_payee', '');
        $inv_content 			= $this->requestData('inv_content', '');
        $postscript			 	= $this->requestData('postscript', '');
        $how_oosLang 			= RC_Lang::lang("oos/$how_oos");
        
        $order = array(
        	'shipping_id' 		=> $this->requestData('shipping_id', 0),
        	'pay_id' 			=> $this->requestData('pay_id'),
        	'pack_id' 			=> $this->requestData('pack', 0),
        	'card_id' 			=> $this->requestData('card', 0),
        	'card_message' 		=> trim($card_message),
        	'surplus' 			=> $this->requestData('surplus', '0.00'),
        	'integral' 			=> $this->requestData('integral', 0),
        	'bonus_id' 			=> $this->requestData('bonus_id', 0),
        	'need_inv' 			=> $this->requestData('need_inv', 0),
        	'inv_type' 			=> $inv_type,
        	'inv_payee' 		=> trim($inv_payee),
        	'inv_content' 		=> $inv_content,
        	'postscript' 		=> trim($postscript),
        	'how_oos' 			=> isset($how_oosLang) ? addslashes($how_oosLang) : '',
        	'need_insure' 		=> $this->requestData('need_insure', 0),
            'user_id'			=> $_SESSION['user_id'],
            'add_time'			=> RC_Time::gmtime(),
            'order_status'		=> OS_UNCONFIRMED,
            'shipping_status' 	=> SS_UNSHIPPED,
            'pay_status'		=> PS_UNPAYED,
            'agency_id'			=> 0,
            'store_id'          => $_SESSION['store_id']
        );
        
        /* 扩展信息 */
        if (isset($_SESSION['flow_type']) && intval($_SESSION['flow_type']) != CART_GENERAL_GOODS) {
            $order['extension_code']	= $_SESSION['extension_code'];
            $order['extension_id']		= $_SESSION['extension_id'];
        } else {
            $order['extension_code']	= '';
            $order['extension_id']		= 0;
        }
        
        /* 检查积分余额是否合法 */
        $user_id = $_SESSION['user_id'];
        if ($user_id > 0) {
            $user_info = user_info($user_id);
            
            // 查询用户有多少积分
            $flow_points = flow_available_points($cart_id); // 该订单允许使用的积分
            $user_points = $user_info['pay_points']; // 用户的积分总数
            
            $order['integral'] = min($order['integral'], $user_points, $flow_points);
            if ($order['integral'] < 0) {
                $order['integral'] = 0;
            }
        } else {
            $order['surplus']	= 0;
            $order['integral']	= 0;
        }
        RC_Loader::load_app_func('admin_bonus','bonus');
        /* 检查红包是否存在 */
        $bonus_sn = $this->requestData('bonus_sn');
        if ($order['bonus_id'] > 0) {
            $bonus = bonus_info($order['bonus_id']);
            if (empty($bonus) || $bonus['user_id'] != $user_id || $bonus['order_id'] > 0 || $bonus['min_goods_amount'] > cart_amount(true, $flow_type, $cart_id)) {
                $order['bonus_id'] = 0;
                $order['bonus'] = 0;
            }
        } elseif (!empty($bonus_sn)) {
            $bonus = bonus_info(0, $bonus_sn);
            $now = RC_Time::gmtime();
            if (empty($bonus) || $bonus['user_id'] > 0 || $bonus['order_id'] > 0 || $bonus['min_goods_amount'] > cart_amount(true, $flow_type, $cart_id) || $now > $bonus['use_end_date']) {} else {
                if ($user_id > 0) {
					$db_user_bonus = RC_Loader::load_app_model('user_bonus_model', 'bonus');
					$db_user_bonus->where(array('bonus_id' => $bonus['bonus_id']))->update(array('user_id' => $user_id));
     			}
                $order['bonus_id'] = $bonus['bonus_id'];
                $order['bonus_sn'] = $bonus_sn;
            }
        }
        
        /* 订单中的商品 */
        $cart_goods = cart_goods($flow_type, $cart_id);
        if (empty($cart_goods)) {
            //EM_Api::outPut(10002);
        	return new ecjia_error('no_goods_in_cart', '购物车中没有商品');
        }
        
        /* 检查商品总额是否达到最低限购金额 */
        if ($flow_type == CART_GENERAL_GOODS && cart_amount(true, CART_GENERAL_GOODS, $cart_id) < ecjia::config('min_goods_amount')) {
            //EM_Api::outPut(10003);
        	return new ecjia_error('insufficient_balance', '您的余额不足以支付整个订单，请选择其他支付方式。');
        }
        
        /* 收货人信息 */
        foreach ($consignee as $key => $value) {
            $order[$key] = addslashes($value);
        }
        
        /* 判断是不是实体商品 */
        foreach ($cart_goods as $val) {
            /* 统计实体商品的个数 */
            if ($val['is_real']) {
                $is_real_good = 1;
            }
        }

        /* 订单中的总额 *///$order['bonus_id']
        $total = cashdesk_order_fee($order, $cart_goods, $consignee);
        RC_Logger::getlogger('info')->info(array('total',$total));
        $order['bonus']			= $total['bonus'];
        $order['goods_amount']	= $total['goods_price'];
        $order['discount']		= $total['discount'];
        $order['surplus']		= $total['surplus'];
        $order['tax']			= $total['tax'];
        
        // 购物车中的商品能享受红包支付的总额
        $discount_amout = compute_discount_amount($cart_id);
        // 红包和积分最多能支付的金额为商品总额
        $temp_amout = $order['goods_amount'] - $discount_amout;
        if ($temp_amout <= 0) {
            $order['bonus_id'] = 0;
            $order['bonus'] = 0;
        }
        
        /* 配送方式 */
        $shipping_method = RC_Loader::load_app_class('shipping_method', 'shipping');
        if ($order['shipping_id'] > 0) {
            $shipping = $shipping_method->shipping_info($order['shipping_id']);
            $order['shipping_name'] = addslashes($shipping['shipping_name']);
        } else {
            //自提
            $shipping = $shipping_method->shipping_info('ship_cac');
            $order['shipping_id'] = $shipping['shipping_id'];
            $order['shipping_name'] = addslashes($shipping['shipping_name']);
        }
        $order['shipping_fee']	= $total['shipping_fee'];
        $order['insure_fee']	= $total['shipping_insure'];
        
        $payment_method = RC_Loader::load_app_class('payment_method','payment');
        /* 支付方式 */
        if ($order['pay_id'] > 0) {
            $payment = $payment_method->payment_info_by_id($order['pay_id']);
            $order['pay_name'] = addslashes($payment['pay_name']);
        	//如果是货到付款，状态设置为已确认。
 			if($payment['pay_code'] == 'pay_cod') { $order['order_status'] = 1; }
        }
        $order['pay_fee'] = $total['pay_fee'];
        $order['cod_fee'] = $total['cod_fee'];

        $order['pack_fee'] = $total['pack_fee'];
        $order['card_fee'] = $total['card_fee'];
        
        $order['order_amount'] = number_format($total['amount'], 2, '.', '');
        
        /* 如果订单金额为0（使用余额或积分或红包支付），修改订单状态为已确认、已付款 */
        if ($order['order_amount'] <= 0) {
            $order['order_status']	= OS_CONFIRMED;
            $order['confirm_time']	= RC_Time::gmtime();
            $order['pay_status']	= PS_PAYED;
            $order['pay_time']		= RC_Time::gmtime();
            $order['order_amount']	= 0;
        }
        
        $order['integral_money'] = $total['integral_money'];
        $order['integral'] = $total['integral'];
        
        if ($order['extension_code'] == 'exchange_goods') {
            $order['integral_money'] = 0;
            $order['integral'] = $total['exchange_integral'];
        }
        
        $order['from_ad'] = ! empty($_SESSION['from_ad']) ? $_SESSION['from_ad'] : '0';
//      TODO:订单来源收银台暂时写死
        $order['referer'] = 'ecjia-cashdesk';
        
        /* 记录扩展信息 */
        if ($flow_type != CART_GENERAL_GOODS) {
            $order['extension_code']	= $_SESSION['extension_code'];
            $order['extension_id']		= $_SESSION['extension_id'];
        }
        
        $parent_id = 0;
        $order['parent_id'] = $parent_id;
        
        /* 插入订单表 */
        $order['order_sn'] = get_order_sn(); // 获取新订单号
        $db_order_info	= RC_Loader::load_app_model('order_info_model','orders');
        $new_order_id	= $db_order_info->insert($order);
//         RC_Logger::getlogger('info')->info('order-info');
//         RC_Logger::getlogger('info')->info(array($new_order_id,$order));
        
        $order['order_id'] = $new_order_id;
        
        /* 插入订单商品 */
		$db_order_goods = RC_Loader::load_app_model('order_goods_model','orders');
        $db_goods_activity = RC_Loader::load_app_model('goods_activity_model','goods');
        
        $shop_type = RC_Config::load_config('site', 'SHOP_TYPE');
        $field = 'goods_id, goods_name, goods_sn, product_id, goods_number, market_price, goods_price, goods_attr, is_real, extension_code, parent_id, is_gift, goods_attr_id';
        $field = $shop_type == 'b2b2c' ? $field.', ru_id' : $field;
        $cart_w = array('rec_type' => $flow_type);
        if (!empty($cart_id)) {
        	$cart_w = array_merge($cart_w, array('rec_id' => $cart_id));
        }
        if ($_SESSION['user_id']) {
        	$cart_w = array_merge($cart_w, array('user_id' =>$_SESSION['user_id']));
			$data_row = $db_cart->field($field)->where($cart_w)->select();
        } else {
        	$cart_w = array_merge($cart_w, array('session_id' =>SESS_ID));
        	$data_row = $db_cart->field($field)->where($cart_w)->select();
        }
        
        if (!empty($data_row)) {
//         	$area_id = $consignee['province'];
//         	//多店铺开启库存管理以及地区后才会去判断
//         	if ( $area_id > 0 && $shop_type == 'b2b2c') {
//         		$warehouse_db = RC_Loader::load_app_model('warehouse_model', 'warehouse');
//         		$warehouse = $warehouse_db->where(array('regionId' => $area_id))->find();
//         		$warehouse_id = $warehouse['parent_id'];
//         	} else {
//         		$warehouse_id = 0;
//         	}
        	foreach ($data_row as $row) {
        		$arr = array(
        				'order_id'		=> $new_order_id,
        				'goods_id'		=> $row['goods_id'],
        				'goods_name'	=> $row['goods_name'],
        				'goods_sn'		=> $row['goods_sn'],
        				'product_id'	=> $row['product_id'],
        				'goods_number'	=> $row['goods_number'],
        				'market_price'	=> $row['market_price'],
        				'goods_price'	=> $row['goods_price'],
        				'goods_attr'	=> $row['goods_attr'],
        				'is_real'		=> $row['is_real'],
        				'extension_code' => $row['extension_code'],
        				'parent_id'		=> $row['parent_id'],
        				'is_gift'		=> $row['is_gift'],
        				'goods_attr_id' => $row['goods_attr_id'],
//         				'area_id'		=> 0,
//         				'warehouse_id'	=> 0,
        		);
        		//TODO
        		if ($shop_type == 'b2b2c') {
        			$arr['ru_id']	= $row['ru_id'];
        		}
        		
        		$db_order_goods->insert($arr);
        	}
        }
        /* 修改拍卖活动状态 */
        if ($order['extension_code'] == 'auction') {
			$db_goods_activity->where(array('act_id' => $order['extension_id']))->update(array('is_finished' => 2));
        }
        
        /* 处理积分、红包 */
		if ($order['user_id'] > 0 && $order['integral'] > 0) {
        	$options = array(
        			'user_id'=>$order['user_id'],
        			'pay_points'=> $order['integral'] * (- 1),
        			'change_desc'=>sprintf(RC_Lang::get('cart::shopping_flow.pay_order'), $order['order_sn'])
        	);
        	$result = RC_Api::api('user', 'account_change_log', $options);
        	if (is_ecjia_error($result)) {
        		return new ecjia_error('fail_error', '处理失败');
        	}
        }
        if ($order['bonus_id'] > 0 && $temp_amout > 0) {
            use_bonus($order['bonus_id'], $new_order_id);
        }
        
        /* 如果使用库存，且下订单时减库存，则减少库存 */
        if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE) {
            change_order_goods_storage($order['order_id'], true, SDT_PLACE);
        }
        
        /* 如果订单金额为0 处理虚拟卡 */
        if ($order['order_amount'] <= 0) {
        	$cart_w = array('is_real' => 0, 'extension_code' => 'virtual_card', 'rec_type' => $flow_type);
        	if (!empty($cart_id)) {
        		$cart_w = array_merge($cart_w, array('rec_id' => $cart_id));
        	}
			if ($_SESSION['user_id']) {
				$cart_w = array_merge($cart_w, array('user_id' => $_SESSION['user_id']));
            	$res = $db_cart->field('goods_id, goods_name, goods_number AS num')->where($cart_w)->select();
            } else {
            	$cart_w = array_merge($cart_w, array('session_id' => SESS_ID));
            	$res = $db_cart->field('goods_id, goods_name, goods_number AS num')->where($cart_w)->select();
            }
            $virtual_goods = array();
            foreach ($res as $row) {
                $virtual_goods['virtual_card'][] = array(
                    'goods_id' => $row['goods_id'],
                    'goods_name' => $row['goods_name'],
                    'num' => $row['num']
                );
            }
            
            if ($virtual_goods and $flow_type != CART_GROUP_BUY_GOODS) {
                /* 虚拟卡发货 */
                if (virtual_goods_ship($virtual_goods, $msg, $order['order_sn'], true)) {
                    /* 如果没有实体商品，修改发货状态，送积分和红包 */
                    $count = $db_order_goods->where(array('order_id' => $order['order_id'] , 'is_real' => 1))->count();
               		if ($count <= 0) {
                    /* 修改订单状态 */
                        update_order($order['order_id'], array(
                            'shipping_status' => SS_SHIPPED,
                            'shipping_time' => RC_Time::gmtime()
                        ));
                        
                        /* 如果订单用户不为空，计算积分，并发给用户；发红包 */
                        if ($order['user_id'] > 0) {
                            /* 取得用户信息 */
                            $user = user_info($order['user_id']);
                            /* 计算并发放积分 */
                            $integral = integral_to_give($order);
                            $options = array(
                            		'user_id' =>$order['user_id'],
                            		'rank_points' => intval($integral['rank_points']),
                            		'pay_points' => intval($integral['custom_points']),
                            		'change_desc' =>sprintf(RC_Lang::lang('order_gift_integral'), $order['order_sn'])
                            );
                            $result = RC_Api::api('user', 'account_change_log',$options);
                            if (is_ecjia_error($result)) {
                            	return new ecjia_error('fail_error', '处理失败');
                            }
                            /* 发放红包 */
                            send_order_bonus($order['order_id']);
                        }
                    }
                }
            }
        }
        
        /* 清空购物车 */
		clear_cart($flow_type, $cart_id);

        /* 插入支付日志 */
        $order['log_id'] = $payment_method->insert_pay_log($new_order_id, $order['order_amount'], PAY_ORDER);
        
        $payment_info = $payment_method->payment_info_by_id($order['pay_id']);
   
        if (! empty($order['shipping_name'])) {
            $order['shipping_name'] = trim(stripcslashes($order['shipping_name']));
        }
        
        /* 订单信息 */
        unset($_SESSION['flow_consignee']); // 清除session中保存的收货人信息
        unset($_SESSION['flow_order']);
        unset($_SESSION['direct_shopping']);
        //unset($_SESSION['user_id']);
        unset($_SESSION['temp_user_id']);
        unset($_SESSION['user_rank']);
        unset($_SESSION['discount']);
        
        $subject = $cart_goods[0]['goods_name'] . '等' . count($cart_goods) . '种商品';
        $out = array(
            'order_sn' => $order['order_sn'],
            'order_id' => $order['order_id'],
            'order_info' => array(
                'pay_code' => $payment_info['pay_code'],
                'order_amount' => $order['order_amount'],
                'order_id' => $order['order_id'],
                'subject' => $subject,
                'desc' => $subject,
                'order_sn' => $order['order_sn']
            )
        );
        
        //订单分子订单 start
//         $order_id = $order['order_id'];
//         $adviser_log = array(
//         		'adviser_id' => $_SESSION['adviser_id'],
//         		'order_id'	 => $order_id,
//         		'device_id'	 => $_SESSION['device_id'],
//         		'type'   	 => 1,//收款
//         		'add_time'	 => RC_Time::gmtime(),
//         );
//         $adviser_log_id = RC_Model::model('achievement/adviser_log_model')->insert($adviser_log);
        
//         $row = get_main_order_info($order_id);
//         $order_info = get_main_order_info($order_id, 1);
        
//         $ru_id = explode(",", $order_info['all_ruId']['ru_id']);

//         if(count($ru_id) > 1){
//         	get_insert_order_goods_single($order_info, $row, $order_id);
//         }
		/*收银员订单操作记录*/
        $order_id = $order['order_id'];
        $device_info = RC_DB::table('mobile_device')->where('id', $_SESSION['device_id'])->first();
        $cashier_record = array(
        		'store_id' 			=> $_SESSION['store_id'],
        		'staff_id'			=> $_SESSION['staff_id'],
        		'order_id'	 		=> $order_id,
        		'order_type' 		=> 'ecjia-cashdesk',
        		'mobile_device_id'	=> $_SESSION['device_id'],
        		'device_sn'			=> $device_info['device_udid'],
        		'device_type'		=> 'ecjia-cashdesk',
        		'action'   	 		=> 'billing', //开单
        		'create_at'	 		=> RC_Time::gmtime(),
        );
        RC_DB::table('cashier_record')->insert($cashier_record);
        
        return $out;
	}

}

/**
 * 获得订单中的费用信息
 *
 * @access  public
 * @param   array   $order
 * @param   array   $goods
 * @param   array   $consignee
 * @param   bool    $is_gb_deposit  是否团购保证金（如果是，应付款金额只计算商品总额和支付费用，可以获得的积分取 $gift_integral）
 * @return  array
 */
function cashdesk_order_fee($order, $goods, $consignee) {
    RC_Loader::load_app_func('global','goods');
    RC_Loader::load_app_func('cart','cart');
    $db 	= RC_Loader::load_app_model('cart_model', 'cart');
    $dbview = RC_Loader::load_app_model('cart_exchange_viewmodel', 'cart');
    /* 初始化订单的扩展code */
    if (!isset($order['extension_code'])) {
        $order['extension_code'] = '';
    }

    //     TODO: 团购等促销活动注释后暂时给的固定参数
    $order['extension_code'] = '';
    $group_buy ='';
    //     TODO: 团购功能暂时注释
    //     if ($order['extension_code'] == 'group_buy') {
    //         $group_buy = group_buy_info($order['extension_id']);
    //     }

    $total  = array('real_goods_count' => 0,
        'gift_amount'      => 0,
        'goods_price'      => 0,
        'market_price'     => 0,
        'discount'         => 0,
        'pack_fee'         => 0,
        'card_fee'         => 0,
        'shipping_fee'     => 0,
        'shipping_insure'  => 0,
        'integral_money'   => 0,
        'bonus'            => 0,
        'surplus'          => 0,
        'cod_fee'          => 0,
        'pay_fee'          => 0,
        'tax'              => 0
    );
    $weight = 0;
    $shop_type = RC_Config::load_config('site', 'SHOP_TYPE');
    /* 商品总价 */
    foreach ($goods AS $key => $val) {
        /* 统计实体商品的个数 */
        if ($val['is_real']) {
            $total['real_goods_count']++;
        }

        if ($val['extension_code'] == 'bulk') {
            //散装称重计算
            $total['goods_price'] += $val['goods_price'] * $val['goods_number'] / 1000;
            $total['goods_price'] = formated_price_bulk($total['goods_price']);
            $total['market_price'] += $val['market_price'] * $val['goods_number'] / 1000;
            $total['market_price'] = formated_price_bulk($total['market_price']);
        } else {
            $total['goods_price']  += $val['goods_price'] * $val['goods_number'];
            $total['market_price'] += $val['market_price'] * $val['goods_number'];
        }

        $area_id = $consignee['province'];
        //多店铺开启库存管理以及地区后才会去判断
        if ( $area_id > 0 && $shop_type == 'b2b2c') {
            $warehouse_db = RC_Loader::load_app_model('warehouse_model', 'warehouse');
            $warehouse = $warehouse_db->where(array('regionId' => $area_id))->find();
            $warehouse_id = $warehouse['parent_id'];
            $goods[$key]['warehouse_id'] = $warehouse_id;
            $goods[$key]['area_id'] = $area_id;
        } else {
            $goods[$key]['warehouse_id'] = 0;
            $goods[$key]['area_id'] 	 = 0;
        }
    }

    $total['saving']    = $total['market_price'] - $total['goods_price'];
    $total['save_rate'] = $total['market_price'] ? round($total['saving'] * 100 / $total['market_price']) . '%' : 0;

    $total['goods_price_formated']  = price_format($total['goods_price'], false);
    $total['market_price_formated'] = price_format($total['market_price'], false);
    $total['saving_formated']       = price_format($total['saving'], false);

    /* 折扣 */
    if ($order['extension_code'] != 'group_buy') {
        RC_Loader::load_app_func('cart','cart');
        $discount = compute_discount();
        $total['discount'] = $discount['discount'];
        if ($total['discount'] > $total['goods_price']) {
            $total['discount'] = $total['goods_price'];
        }
    }
    $total['discount_formated'] = price_format($total['discount'], false);

    /* 税额 */
    if (!empty($order['need_inv']) && $order['inv_type'] != '') {
        /* 查税率 */
        $rate = 0;
        $invoice_type=ecjia::config('invoice_type');
        foreach ($invoice_type['type'] as $key => $type) {
            if ($type == $order['inv_type']) {
                $rate_str = $invoice_type['rate'];
                $rate = floatval($rate_str[$key]) / 100;
                break;
            }
        }
        if ($rate > 0) {
            $total['tax'] = $rate * $total['goods_price'];
        }
    }
    $total['tax_formated'] = price_format($total['tax'], false);
    //	TODO：暂时注释
    /* 包装费用 */
    //     if (!empty($order['pack_id'])) {
    //         $total['pack_fee']      = pack_fee($order['pack_id'], $total['goods_price']);
    //     }
    //     $total['pack_fee_formated'] = price_format($total['pack_fee'], false);

    //	TODO：暂时注释
    //    /* 贺卡费用 */
    //    if (!empty($order['card_id'])) {
    //        $total['card_fee']      = card_fee($order['card_id'], $total['goods_price']);
    //    }
    $total['card_fee_formated'] = price_format($total['card_fee'], false);

    RC_Loader::load_app_func('admin_bonus','bonus');
    /* 红包 */
    if (!empty($order['bonus_id'])) {
        $bonus          = bonus_info($order['bonus_id']);
        $total['bonus'] = $bonus['type_money'];
    }
    $total['bonus_formated'] = price_format($total['bonus'], false);

    /* 线下红包 */
    if (!empty($order['bonus_kill'])) {
        $bonus  = bonus_info(0, $order['bonus_kill']);
        $total['bonus_kill'] = $order['bonus_kill'];
        $total['bonus_kill_formated'] = price_format($total['bonus_kill'], false);
    }

    $total['shipping_fee']		= 0;
    $total['shipping_insure']	= 0;
    $total['shipping_fee_formated']    = price_format($total['shipping_fee'], false);
    $total['shipping_insure_formated'] = price_format($total['shipping_insure'], false);

    // 活动优惠总金额
    $discount_amount = compute_discount_amount();
    // 红包和积分最多能支付的金额为商品总额
    //$max_amount 还需支付商品金额=商品金额-红包-优惠-积分
    $max_amount = $total['goods_price'] == 0 ? $total['goods_price'] : $total['goods_price'] - $discount_amount;


    /* 计算订单总额 */
    if ($order['extension_code'] == 'group_buy' && $group_buy['deposit'] > 0) {
        $total['amount'] = $total['goods_price'];
    } else {
        $total['amount'] = $total['goods_price'] - $total['discount'] + $total['tax'] + $total['pack_fee'] + $total['card_fee'] + $total['shipping_fee'] + $total['shipping_insure'] + $total['cod_fee'];
        // 减去红包金额
        $use_bonus	= min($total['bonus'], $max_amount); // 实际减去的红包金额
        if(isset($total['bonus_kill'])) {
            $use_bonus_kill   = min($total['bonus_kill'], $max_amount);
            $total['amount'] -=  $price = number_format($total['bonus_kill'], 2, '.', ''); // 还需要支付的订单金额
        }

        $total['bonus']   			= ($total['bonus'] > 0) ? $use_bonus : 0;
        $total['bonus_formated'] 	= price_format($total['bonus'], false);

        $total['amount'] -= $use_bonus; // 还需要支付的订单金额
        $max_amount      -= $use_bonus; // 积分最多还能支付的金额
    }

    /* 余额 */
    $order['surplus'] = $order['surplus'] > 0 ? $order['surplus'] : 0;
    if ($total['amount'] > 0) {
        if (isset($order['surplus']) && $order['surplus'] > $total['amount']) {
            $order['surplus'] = $total['amount'];
            $total['amount']  = 0;
        } else {
            $total['amount'] -= floatval($order['surplus']);
        }
    } else {
        $order['surplus'] = 0;
        $total['amount']  = 0;
    }
    $total['surplus'] 			= $order['surplus'];
    $total['surplus_formated'] 	= price_format($order['surplus'], false);

    /* 积分 */
    $order['integral'] = $order['integral'] > 0 ? $order['integral'] : 0;
    if ($total['amount'] > 0 && $max_amount > 0 && $order['integral'] > 0) {
        $integral_money = value_of_integral($order['integral']);
        // 使用积分支付
        $use_integral            = min($total['amount'], $max_amount, $integral_money); // 实际使用积分支付的金额
        $total['amount']        -= $use_integral;
        $total['integral_money'] = $use_integral;
        $order['integral']       = integral_of_value($use_integral);
    } else {
        $total['integral_money'] = 0;
        $order['integral']       = 0;
    }
    $total['integral'] 			 = $order['integral'];
    $total['integral_formated']  = price_format($total['integral_money'], false);

    /* 保存订单信息 */
    $_SESSION['flow_order'] = $order;
    $se_flow_type = isset($_SESSION['flow_type']) ? $_SESSION['flow_type'] : '';

    /* 支付费用 */
    if (!empty($order['pay_id']) && ($total['real_goods_count'] > 0 || $se_flow_type != CART_EXCHANGE_GOODS)) {
        $total['pay_fee']      	= pay_fee($order['pay_id'], $total['amount'], $shipping_cod_fee);
    }
    $total['pay_fee_formated'] 	= price_format($total['pay_fee'], false);
    $total['amount']           += $total['pay_fee']; // 订单总额累加上支付费用
    $total['amount_formated']  	= price_format($total['amount'], false);

    /* 取得可以得到的积分和红包 */
    if ($order['extension_code'] == 'group_buy') {
        $total['will_get_integral'] = $group_buy['gift_integral'];
    } elseif ($order['extension_code'] == 'exchange_goods') {
        $total['will_get_integral'] = 0;
    } else {
        $total['will_get_integral'] = get_give_integral($goods);
    }

    $total['will_get_bonus']        = $order['extension_code'] == 'exchange_goods' ? 0 : price_format(get_total_bonus(), false);
    $total['formated_goods_price']  = price_format($total['goods_price'], false);
    $total['formated_market_price'] = price_format($total['market_price'], false);
    $total['formated_saving']       = price_format($total['saving'], false);

    if ($order['extension_code'] == 'exchange_goods') {
        if ($_SESSION['user_id']) {
            $exchange_integral = $dbview->join('exchange_goods')->where(array('c.user_id' => $_SESSION['user_id'] , 'c.rec_type' => CART_EXCHANGE_GOODS , 'c.is_gift' => 0 ,'c.goods_id' => array('gt' => 0)))->group('eg.goods_id')->sum('eg.exchange_integral');
        } else {
            $exchange_integral = $dbview->join('exchange_goods')->where(array('c.session_id' => SESS_ID , 'c.rec_type' => CART_EXCHANGE_GOODS , 'c.is_gift' => 0 ,'c.goods_id' => array('gt' => 0)))->group('eg.goods_id')->sum('eg.exchange_integral');
        }
        $total['exchange_integral'] = $exchange_integral;
    }

    return $total;
}




// //获取主订单信息
// function get_main_order_info($order_id = 0, $type = 0){
// 	$orderinfo_db = RC_Loader::load_app_model('order_info_model','orders');
// 	$row = $orderinfo_db->find(array('order_id' => $order_id));

// 	if($type == 1){
// 		$row['all_ruId'] = get_main_order_goods_info($order_id, 1); //订单中所有商品所属商家ID,0代表自营商品，其它商家商品
// 		$ru_id = explode(",", $row['all_ruId']['ru_id']);
// 		if(count($ru_id) > 1){
// 			$row['order_goods'] = get_main_order_goods_info($order_id);
// 			$row['newInfo'] = get_new_ru_goods_info($row['all_ruId'], $row['order_goods']);
// 			$row['newOrder'] = get_new_order_info($row['newInfo']);
// 			$row['orderBonus'] = get_new_order_info($row['newInfo'],1, $row['bonus_id']); //处理商家分单红包
// 			$row['orderFavourable'] = get_new_order_info($row['newInfo'],2); //处理商家分单优惠活动
// 		}
// 	}

// 	return $row;
// }

// //获取订单信息--或者--订单中所有商品所属商家ID,0代表自营商品，其它商家商品
// function get_main_order_goods_info($order_id = 0, $type = 0) {
// 	$ordergoods_viewdb = RC_Loader::load_app_model('order_order_goods_viewmodel','orders');
// 	$res = $ordergoods_viewdb->join(array('goods'))->field('o.*, g.goods_weight as goodsWeight')->where(array('order_id' => $order_id))->select();
// 	$arr = array();
// 	if($type == 1){
// 		$arr['ru_id'] = '';
// 	}
// 	foreach($res as $key=>$row){
// 		if($type == 0){
// 			$arr[] = $row;
// 		}else{
// 			$arr['ru_id'] .= $row['ru_id'] . ',';
// 		}
// 	}

// 	if($type == 1){
// 		$arr['ru_id'] = explode(',', substr($arr['ru_id'], 0, -1));
// 		$arr['ru_id'] = array_unique($arr['ru_id']);
// 		$arr['ru_id'] = implode(',', $arr['ru_id']);
// 	}

// 	return $arr;
// }

// //主次订单拆分新数组
// function get_new_ru_goods_info($all_ruId = '', $order_goods = array()){
// 	$all_ruId = $all_ruId['ru_id'];
// 	$arr = array();

// 	if(!empty($all_ruId)){
// 		$all_ruId = explode(',', $all_ruId);
// 		$all_ruId = array_values($all_ruId);
// 	}

// 	if($all_ruId){
// 		for($i=0; $i<count($order_goods); $i++){
// 			for($j=0; $j<count($all_ruId); $j++){
// 				if($order_goods[$i]['ru_id'] == $all_ruId[$j]){
// 					$arr[$all_ruId[$j]][$i] = $order_goods[$i];
// 				}
// 			}
// 		}
// 	}

// 	return $arr;
// }

// //运算分单后台每个订单商品总金额以及划分红包类型使用所属商家
// function get_new_order_info($newInfo, $type = 0, $bonus_id = 0){
// 	RC_Loader::load_app_func('order', 'orders');
// 	$arr = array();

// 	if ($type == 0) {
// 		foreach($newInfo as $key=>$row){
// 			$arr[$key]['goods_amount'] = 0;
// 			$arr[$key]['shopping_fee'] = 0;
// 			$arr[$key]['goods_id'] = 0;

// 			$arr[$key]['ru_list'] = get_cart_goods_combined_freight($row, 2); //计算商家运费

// 			$row = array_values($row);
// 			for ($j=0; $j<count($row); $j++) {
// 				$arr[$key]['goods_id'] = $row[$j]['goods_id'];
// 				// 				TODO:
// 				//ecmoban模板堂 --zhuo start 商品金额促销
// 				$goods_amount = $row[$j]['goods_price'] * $row[$j]['goods_number'];
// 				if ($goods_amount > 0) {
// 					$goods_con = get_con_goods_amount($goods_amount, $row[$j]['goods_id'], 0, 0, $row[$j]['parent_id']);

// 					$goods_con['amount'] = explode(',', $goods_con['amount']);
// 					$amount = min($goods_con['amount']);

// 					$arr[$key]['goods_amount'] += $amount;
// 				} else {
// 					$arr[$key]['goods_amount'] += $row[$j]['goods_price'] * $row[$j]['goods_number']; //原始
// 				}

// 				$arr[$key]['shopping_fee'] = $arr[$key]['ru_list']['shipping_fee'];
// 				//ecmoban模板堂 --zhuo end 商品金额促销
// 			}
// 		}
// 	} elseif($type == 1) { //红包
// 		foreach($newInfo as $key=>$row){

// 			$arr[$key]['user_id'] = $key;
// 			$bonus = get_bonus_merchants($bonus_id, $key); //红包信息
// 			$arr[$key]['bonus'] = $bonus;
// 		}
// 	} elseif($type == 2) { //优惠活动
// 		foreach($newInfo as $key=>$row){
// 			$arr[$key]['user_id'] = $key;
// 			$arr[$key]['compute_discount'] = compute_discount($type, $row);
// 		}
// 	}

// 	return $arr;
// }

// //查询订单中所使用的红包等归属信息，所属商家(ID : bt.user_id)
// function get_bonus_merchants($bonus_id = 0, $user_id = 0){
// 	$bt_viewdb = RC_Loader::load_app_model('bonus_type_viewmodel', 'bonus');
// 	$row = $bt_viewdb->field('bt.user_id')->where(array('ub.bonus_id' => $bonus_id, 'bt.user_id' => $user_id))->find();
// 	return $row;
// }

// //分单插入数据
// function get_insert_order_goods_single($orderInfo, $row, $order_id){
// 	$newOrder = $orderInfo['newOrder'];
// 	$orderBonus = $orderInfo['orderBonus'];
// 	$newInfo = $orderInfo['newInfo'];
// 	$orderFavourable = $orderInfo['orderFavourable'];
// 	$surplus = $row['surplus'];//余额
// 	$integral_money = $row['integral_money'];//积分
// 	$use_bonus = 0;

// 	$bonus_id = $row['bonus_id'];//红包ID
// 	$bonus = $row['bonus'];//红包金额

// 	$usebonus_type = get_bonus_all_goods($bonus_id); //全场通用红包 val:1
// 	$payment_method = RC_Loader::load_app_class('payment_method','payment');
// 	$db_order_goods = RC_Loader::load_app_model('order_goods_model','orders');
// 	$arr = array();
// 	$db_term_meta = RC_Loader::load_model('term_meta_model');
// 	$meta_data_where = array(
// 			'object_type'	=> 'ecjia.order',
// 			'object_group'	=> 'order',
// 			'object_id'		=> $order_id,
// 			'meta_key'		=> 'receipt_verification',
// 	);
// 	$receipt_code = $db_term_meta->where($meta_data_where)->get_field('meta_value');
	
// 	foreach ($newInfo as $key => $info) {

// 		$arr[$key] = $info;

// 		// 插入订单表 start

// 		$error_no = 0;
// 		do
// 		{
// 			$row['order_sn'] = get_order_sn(); //获取新订单号
// 			$row['main_order_id'] = $order_id; //获取主订单ID
// 			$row['goods_amount'] = $newOrder[$key]['goods_amount']; //商品总金额

// 			$row['discount'] = $orderFavourable[$key]['compute_discount']['discount']; //折扣金额
// 			$row['shipping_fee'] = $newOrder[$key]['shopping_fee']; //运费金额
// 			$row['order_amount'] = $newOrder[$key]['goods_amount'] - $row['discount'] + $row['shipping_fee']; //订单应付金额

// 			// 减去红包 start
// 			if ($usebonus_type == 1) {
// 				if($bonus > 0){
// 					if ($row['order_amount'] >= $bonus) {
// 						$row['order_amount'] = $row['order_amount'] - $bonus;
// 						$row['bonus'] = $bonus;
// 						$bonus = 0;
// 					} else {
// 						$bonus = $bonus - $row['order_amount'];
// 						$row['bonus'] = $row['order_amount'];
// 						$row['order_amount'] = 0;
// 					}

// 					$row['bonus_id'] = $bonus_id;
// 				} else {
// 					$row['bonus'] = 0;
// 					$row['bonus_id'] = 0;
// 				}

// 			} else {
// 				if (isset($orderBonus[$key]['bonus']['type_money'])) {
// 					$use_bonus = min($orderBonus[$key]['bonus']['type_money'], $row['order_amount']); // 实际减去的红包金额
// 					$row['order_amount'] -= $use_bonus;
// 					$row['bonus'] = $orderBonus[$key]['bonus']['type_money'];
// 					$row['bonus_id'] = $row['bonus_id'];
// 				} else {
// 					$row['bonus'] = 0;
// 					$row['bonus_id'] = 0;
// 				}
// 			}
// 			// 减去红包 end

// 			//余额 start
// 			if ($surplus > 0) {
// 				if ($surplus >= $row['order_amount']) {
// 					$surplus = $surplus - $row['order_amount'];
// 					$row['surplus'] = $row['order_amount']; //订单金额等于当前使用余额
// 					$row['order_amount'] = 0;
// 				} else {
// 					$row['order_amount'] = $row['order_amount'] - $surplus;
// 					$row['surplus'] = $surplus;
// 					$surplus = 0;
// 				}
// 			} else {
// 				$row['surplus'] = 0;
// 			}
// 			//余额 end

// 			//积分 start
// 			if ($integral_money > 0) {
// 				if ($integral_money >= $row['order_amount']) {
// 					$integral_money = $integral_money - $row['order_amount'];
// 					$row['integral_money'] = $row['order_amount']; //订单金额等于当前使用余额
// 					$row['integral'] = $row['order_amount'];
// 					$row['order_amount'] = 0;
// 				} else {
// 					$row['order_amount'] = $row['order_amount'] - $integral_money;
// 					$row['integral_money'] = $integral_money;
// 					$row['integral'] = $integral_money;
// 					$integral_money = 0;
// 				}
// 			} else {
// 				$row['integral_money'] = 0;
// 				$row['integral'] = 0;
// 			}
// 			//积分 end

// 			$row['order_amount'] = number_format( $row['order_amount'] ,  2 ,  '.',  ''); //格式化价格为一个数字

// 			/* 如果订单金额为0（使用余额或积分或红包支付），修改订单状态为已确认、已付款 */
// 			if ($row['order_amount'] <= 0) {
// 				$row['order_status'] = OS_CONFIRMED;
// 				$row['confirm_time'] = RC_Time::gmtime();
// 				$row['pay_status']   = PS_PAYED;
// 				$row['pay_time']     = RC_Time::gmtime();
// 			} else {
// 				$row['order_status'] = 0;
// 				$row['confirm_time'] = 0;
// 				$row['pay_status']   = 0;
// 				$row['pay_time']     = 0;
// 			}

// 			unset($row['order_id']);

// 			$db_order_info = RC_Loader::load_app_model('order_info_model','orders');
// 			$new_orderId = $db_order_info->insert($row);
			
// 		}
// 		while ($error_no == 1062); //如果是订单号重复则重新提交数据

// 		$arr[$key] = array_values($arr[$key]);
// 		for ($j=0; $j<count($arr[$key]); $j++) {
				
// 			$arr[$key][$j]['order_id'] = $new_orderId;
// 			unset($arr[$key][$j]['rec_id']);
// 			$db_order_goods->insert($arr[$key][$j]);
// 		}

// 		/* 插入支付日志 */
// 		$row['log_id'] = $payment_method->insert_pay_log($new_orderId, $row['order_amount'], PAY_ORDER);
// 		if (!empty($receipt_code)) {
// 			$meta_data = array(
// 					'object_type'	=> 'ecjia.order',
// 					'object_group'	=> 'order',
// 					'object_id'		=> $new_orderId,
// 					'meta_key'		=> 'receipt_verification',
// 					'meta_value'	=> $receipt_code
// 			);
// 			$db_term_meta->insert($meta_data);
// 		}
// 	}
// }

// //查询订单是否全场通用
// function get_bonus_all_goods($bonus_id) {
// 	$type = 0;
// 	return $type;
// }


// //促销--商品最终金额
// function get_con_goods_amount($goods_amount = 0, $goods_id = 0, $type = 0, $shipping_fee = 0, $parent_id = 0){
// 	if ($parent_id == 0) {
// 		if($type == 0){
// 			$table = 'goods_consumption';
// 		}elseif($type == 1){
// 			$table = 'goods_conshipping';

// 			if(empty($shipping_fee)){
// 				$shipping_fee = 0;
// 			}
// 		}

// 		$res = get_goods_con_list($goods_id, $table, $type);

// 		if($res){
// 			$arr = array();
// 			$arr['amount'] = '';
// 			foreach($res as $key=>$row){

// 				if($type == 0){
// 					if($goods_amount >= $row['cfull']){
// 						$arr[$key]['cfull'] = $row['cfull'];
// 						$arr[$key]['creduce'] = $row['creduce'];
// 						$arr[$key]['goods_amount'] = $goods_amount - $row['creduce'];

// 						if($arr[$key]['goods_amount'] > 0){
// 							$arr['amount'] .= $arr[$key]['goods_amount'] . ',';
// 						}
// 					}
// 				}elseif($type == 1){
// 					if($goods_amount >= $row['sfull']){
// 						$arr[$key]['sfull'] = $row['sfull'];
// 						$arr[$key]['sreduce'] = $row['sreduce'];
// 						if($shipping_fee > 0){ //运费要大于0时才参加商品促销活动
// 							$arr[$key]['shipping_fee'] = $shipping_fee - $row['sreduce'];
// 							$arr['amount'] .= $arr[$key]['shipping_fee'] . ',';
// 						}else{
// 							$arr['amount'] = '0' . ',';
// 						}
// 					}
// 				}
// 			}

// 			if($type == 0){
// 				if(!empty($arr['amount'])){
// 					$arr['amount'] = substr($arr['amount'], 0, -1);
// 				}else{
// 					$arr['amount'] = $goods_amount;
// 				}
// 			}elseif($type == 1){
// 				if(!empty($arr['amount'])){
// 					$arr['amount'] = substr($arr['amount'], 0, -1);
// 				}else{
// 					$arr['amount'] = $shipping_fee;
// 				}
// 			}
// 		}else{
// 			if($type == 0){
// 				$arr['amount'] = $goods_amount;
// 			}elseif($type == 1){
// 				$arr['amount'] = $shipping_fee;
// 			}
// 		}

// 		//消费满最大金额免运费
// 		if ($type == 1) {
// 			$db_goods = RC_Loader::load_app_model('goods_model', 'goods');
// 			$largest_amount = $db_goods->where(array('goods_id' => $goods_id))->get_field('largest_amount');

// 			if($largest_amount > 0 && $goods_amount > $largest_amount){
// 				$arr['amount'] = 0;
// 			}
// 		}
// 	} else {
// 		if ($type == 0) {
// 			$arr['amount'] = $goods_amount;
// 		}elseif($type == 1){
// 			$arr['amount'] = $shipping_fee;
// 		}
// 	}

// 	return $arr;
// }

// //查询商品满减促销信息
// function get_goods_con_list($goods_id = 0, $table, $type = 0){
// 	$db = RC_Loader::load_app_model($table.'_model', 'goods');
// 	$res = $db->where(array('goods_id' => $goods_id))->select();
// 	$arr = array();
// 	foreach($res as $key=>$row){
// 		$arr[$key]['id'] = $row['id'];
// 		if($type == 0){
// 			$arr[$key]['cfull'] = $row['cfull'];
// 			$arr[$key]['creduce'] = $row['creduce'];
// 		}elseif($type == 1){
// 			$arr[$key]['sfull'] = $row['sfull'];
// 			$arr[$key]['sreduce'] = $row['sreduce'];
// 		}
// 	}

// 	if($type == 0){
// 		$arr = get_array_sort($arr, 'cfull');
// 	}elseif($type == 1){
// 		$arr = get_array_sort($arr, 'sfull');
// 	}

// 	return $arr;
// }

// function get_array_sort($arr,$keys,$type='asc'){

// 	$new_array = array();
// 	if(is_array($arr) && !empty($arr)){
// 		$keysvalue = $new_array = array();
// 		foreach ($arr as $k=>$v){
// 			$keysvalue[$k] = $v[$keys];
// 		}
// 		if($type == 'asc'){
// 			asort($keysvalue);
// 		}else{
// 			arsort($keysvalue);
// 		}
// 		reset($keysvalue);
// 		foreach ($keysvalue as $k=>$v){
// 			$new_array[$k] = $arr[$k];
// 		}
// 	}

// 	return $new_array;
// }

// end