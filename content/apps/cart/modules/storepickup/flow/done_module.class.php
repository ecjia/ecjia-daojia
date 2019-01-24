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
 * 门店提货购物流检查订单
 * @author zrl
 */
class storepickup_flow_done_module extends api_front implements api_interface
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
    	
        $this->authSession();
    	if ($_SESSION['user_id'] <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}
    	
        RC_Loader::load_app_func('cart','cart');
        RC_Loader::load_app_func('cashdesk','cart');
        RC_Loader::load_app_func('admin_order','orders');
        
        $device = $this->device;
        //获取所需购买购物车id  will.chen
        $rec_id = $this->requestData('rec_id', 0);
        $rec_id = empty($rec_id) ? $_SESSION['cart_id'] : $rec_id;
		$cart_id = empty($rec_id) ? '' : explode(',', $rec_id);
		
        /* 取得购物类型 */
		$flow_type = CART_GENERAL_GOODS;
        
        /* 检查购物车中是否有商品 */
		$db_cart = RC_Loader::load_app_model('cart_model', 'cart');
		
		$cart_where = array('parent_id' => 0 , 'is_gift' => 0 , 'rec_type' => $flow_type);
		if (!empty($cart_id)) {
			$cart_where = array_merge($cart_where, array('rec_id' => $cart_id));
		}
		$cart_where = array_merge($cart_where, array('user_id' => $_SESSION['user_id']));
		$count = $db_cart->where($cart_where)->count();
        
        if ($count == 0) {
        	return new ecjia_error('no_goods_in_cart', '购物车中没有商品');
        }
        /* 检查商品库存 */
        /* 如果使用库存，且下订单时减库存，则减少库存 */
        if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE) {
			$cart_goods_stock = get_cart_goods($cart_id, $flow_type);
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
        
        $how_oos 				= $this->requestData('how_oos', 0);
        $card_message 			= $this->requestData('card_message', '');
        $inv_type		 		= $this->requestData('inv_type', '');
        $inv_payee			 	= $this->requestData('inv_payee', '');
        $inv_content 			= $this->requestData('inv_content', '');
        $postscript			 	= $this->requestData('postscript', '');
        $how_oosLang 			= RC_Lang::lang("oos/$how_oos");
        
        /* 订单中的商品 */
        $cart_goods = cart_goods($flow_type, $cart_id);
        if (empty($cart_goods)) {
            return new ecjia_error('no_goods_in_cart', '购物车中没有商品');
        }
        
        if (!empty($cart_goods)) {
        	foreach ($cart_goods as $k => $v) {
        		$store_group[] = $v['store_id'];
        	}
        	$store_group = array_unique($store_group);
        }
        
        if (count($store_group) > 1) {
        	return new ecjia_error('pls_single_shop_for_settlement', '请单个店铺进行结算!');
        } else {
        	$store_id = $store_group['0'];
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
        if ($store_id > 0){
        	$info = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
        	$region_info = array(
        			'country'			=> ecjia::config('shop_country'),
        			'province'			=> empty($info['province']) ? '' : $info['province'],
        			'city'				=> empty($info['city'])     ? '' : $info['city'],
        			'district'		    => empty($info['district']) ? '' : $info['district'],

	       			'address'			=> empty($info['address'])   ? '' : $info['address'],
        			'longitude'			=> empty($info['longitude']) ? '' : $info['longitude'],
        			'latitude'			=> empty($info['latitude'])  ? '' : $info['latitude'],
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
        
        //发票抬头处理
		$need_inv = $this->requestData('need_inv', 0);
		if (!empty($need_inv)) {
			$inv_title_type = trim($this->requestData('inv_title_type', ''));
			if (!empty($inv_title_type)) {
				if ($inv_title_type == 'personal') {
					$inv_payee_last = trim($this->requestData('inv_payee', '个人'));
				} elseif($inv_title_type == 'enterprise') {
					//发票纳税人识别码
					$inv_tax_no = trim($this->requestData('inv_tax_no', ''));
					$inv_payee = trim($this->requestData('inv_payee', ''));
					if (empty($inv_tax_no) || empty($inv_payee)) {
						return new ecjia_error('invoice_error', '发票抬头和识别码都不能为空！');
					}
					//如果有传发票识别码，发票识别码存储在inv_payee（发票抬头）字段中；格式为发票抬头 + ,发票纳税人识别码；如：（企业,789654321456987124）。
					$inv_payee_last = $inv_payee.','.$inv_tax_no;
				}
			}
		}

        $order = array(
        	'shipping_id' 		=> $this->requestData('shipping_id', 0),
        	'pay_id' 			=> $this->requestData('pay_id'),
        	'pack_id' 			=> $this->requestData('pack', 0),
        	'card_id' 			=> $this->requestData('card', 0),
        	'card_message' 		=> trim($card_message),
        	'surplus' 			=> $this->requestData('surplus', '0.00'),
        	'integral' 			=> $this->requestData('integral', 0),
        	'bonus_id' 			=> $this->requestData('bonus', 0),
        	'need_inv' 			=> $this->requestData('need_inv', 0),
        	'inv_type' 			=> $inv_type,
        	'inv_payee'    		=> $inv_payee_last,
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
            'store_id'          => $store_id,
            'expect_shipping_time' => $this->requestData('expect_pickup_time', '')
        );
        
        /* 扩展信息 */
        $order['extension_code']	= 'storepickup';
        $order['extension_id']		= 0;
        
        /* 检查积分余额是否合法 */
        $user_id = $_SESSION['user_id'];
        if ($user_id > 0) {
            $user_info = user_info($user_id);
            
            // 查询用户有多少积分
            $flow_points = flow_available_points($cart_id, $flow_type); // 该订单允许使用的积分
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
					RC_DB::table('user_bonus')->where('bonus_id', $bonus['bonus_id'])->update(array('user_id' => $user_id));
     			}
                $order['bonus_id'] = $bonus['bonus_id'];
                $order['bonus_sn'] = $bonus_sn;
            }
        }
        $order['bonus_id'] = empty($order['bonus_id']) ? 0 : intval($order['bonus_id']);
        
        /* 检查商品总额是否达到最低限购金额 */
        if ($flow_type == CART_GENERAL_GOODS && cart_amount(true, CART_GENERAL_GOODS, $cart_id) < ecjia::config('min_goods_amount')) {
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
        $total = cashdesk_order_fee($order, $cart_goods, $consignee, $cart_id);
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
        if ($order['shipping_id'] > 0) {
            $shipping = ecjia_shipping::pluginData($order['shipping_id']);
            $order['shipping_name'] = addslashes($shipping['shipping_name']);
        } else {
            //自提
            $shipping = ecjia_shipping::pluginData('ship_cac');
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
        } else {
            //默认指定微信小程序支付
            $payinfo = with(new Ecjia\App\Payment\PaymentPlugin)->getPluginDataByCode('pay_wxpay_weapp');
            if (empty($payinfo)) {
                return new ecjia_error('no_pay_wxpay_weapp', '请先安装微信小程序支付方式');
            }
            $order['pay_id'] = $payinfo['pay_id'];
            $order['pay_name'] = addslashes($payinfo['pay_name']);
            
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
//      订单来源
        $order['referer'] = ! empty($device['client']) ? $device['client'] : 'mobile';
        
        $parent_id = 0;
        $order['parent_id'] = $parent_id;
        
        /* 插入订单表 */
        $order['order_sn'] = ecjia_order_buy_sn(); // 获取新订单号
        $db_order_info	= RC_Loader::load_app_model('order_info_model','orders');
        
        $new_order_id	= $db_order_info->insert($order);
        $order['order_id'] = $new_order_id;
        
        //插入财务发票表
        if (!empty($inv_payee_last)) {
        	$inv_payee = explode(',', $inv_payee_last);
        	$f_inv_payee = $inv_payee['0'];
        } else {
        	$f_inv_payee = '';
        }
        
        if (!empty($inv_title_type)) {
        	if ($inv_title_type == 'personal') {
        		$inv_title_type_new = 'PERSONAL';
        	} elseif ($inv_title_type == 'enterprise') {
        		$inv_title_type_new = 'CORPORATION';
        	}
        	$finance_invoice_info = RC_DB::table('finance_invoice')->where('title_type', $inv_title_type_new)->where('user_id', $_SESSION['user_id'])->where('tax_register_no', $inv_tax_no)->first();
        	if (empty($finance_invoice_info)) {
        		/*插入财务发票表*/
        		$inv_data = array(
        				'user_id' 			=> $_SESSION['user_id'],
        				'title_name' 		=> $f_inv_payee,
        				'title_type' 		=> $inv_title_type_new,
        				'user_mobile' 		=> $order['mobile'],
        				'tax_register_no'	=> empty($inv_tax_no) ? '' : $inv_tax_no,
        				'user_address'		=> $order['address'],
        				'add_time'			=> RC_Time::gmtime(),
        				'is_default'		=> 1,
        				'status'		    => 0,
        		);
        		RC_DB::table('finance_invoice')->insert($inv_data);
        	}
        }
        
        /* 插入订单商品 */
		$db_order_goods = RC_Loader::load_app_model('order_goods_model','orders');
        $db_goods_activity = RC_Loader::load_app_model('goods_activity_model','goods');
        
        $shop_type = RC_Config::load_config('site', 'SHOP_TYPE');
        $field = 'goods_id, goods_name, goods_sn, product_id, goods_number, market_price, goods_price, goods_attr, is_real, extension_code, parent_id, is_gift, goods_attr_id';
       
        $cart_w = array('rec_type' => $flow_type);
        if (!empty($cart_id)) {
        	$cart_w = array_merge($cart_w, array('rec_id' => $cart_id));
        }
    	$cart_w = array_merge($cart_w, array('user_id' =>$_SESSION['user_id']));
		$data_row = $db_cart->field($field)->where($cart_w)->select();
        
        if (!empty($data_row)) {
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
        		);
        		
        		$db_order_goods->insert($arr);
        	}
        }
        
        /* 如果使用库存，且下订单时减库存，则减少库存 */
        if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE) {
        	$result = cart::change_order_goods_storage($order['order_id'], true, SDT_PLACE);
        	if (is_ecjia_error($result)) {
        		/* 库存不足删除已生成的订单（并发处理） will.chen*/
        		RC_DB::table('order_info')->where('order_id', $order['order_id'])->delete();
        		$db_order_goods->where('order_id', $order['order_id'])->delete();
        		return $result;
        	}
        }
        
        /* 修改拍卖活动状态 */
        if ($order['extension_code'] == 'auction') {
			$db_goods_activity->where(array('act_id' => $order['extension_id']))->update(array('is_finished' => 2));
        }
        
        /* 处理积分、红包 */
		if ($order['user_id'] > 0 && $order['integral'] > 0) {
        	$options = array(
        			'user_id'		=> $order['user_id'],
        			'pay_points'	=> $order['integral'] * (- 1),
        			'change_desc'	=> sprintf(RC_Lang::get('cart::shopping_flow.pay_order'), $order['order_sn']),
        			'from_type'		=> 'order_use_integral',
        			'from_value'	=> $order['order_sn']
        	);
        	$result = RC_Api::api('user', 'account_change_log', $options);
        	if (is_ecjia_error($result)) {
        		return new ecjia_error('fail_error', '处理失败');
        	}
        }
        if ($order['bonus_id'] > 0 && $temp_amout > 0) {
            use_bonus($order['bonus_id'], $new_order_id);
        }
        
        /* 如果订单金额为0 处理虚拟卡 */
        if ($order['order_amount'] <= 0) {
        	$cart_w = array('is_real' => 0, 'extension_code' => 'virtual_card', 'rec_type' => $flow_type);
        	if (!empty($cart_id)) {
        		$cart_w = array_merge($cart_w, array('rec_id' => $cart_id));
        	}
			$cart_w = array_merge($cart_w, array('user_id' => $_SESSION['user_id']));
        	$res = $db_cart->field('goods_id, goods_name, goods_number AS num')->where($cart_w)->select();
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
        
        /*记录订单状态日志*/
        RC_Loader::load_app_class('OrderStatusLog', 'orders', false);
        OrderStatusLog::generate_order(array('order_id' => $new_order_id, 'order_sn' => $order['order_sn']));
        
        OrderStatusLog::remind_pay(array('order_id' => $new_order_id));
        
        /* 清空购物车 */
		clear_cart($flow_type, $cart_id);
		
        /* 插入支付日志 */
        $order['log_id'] = $payment_method->insert_pay_log($new_order_id, $order['order_amount'], PAY_ORDER);
        
        $payment_info = $payment_method->payment_info_by_id($order['pay_id']);
   
        if (! empty($order['shipping_name'])) {
            $order['shipping_name'] = trim(stripcslashes($order['shipping_name']));
        }
        
        
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
        return $out;
	}

}


// end