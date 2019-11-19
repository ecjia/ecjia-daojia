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
use Ecjia\System\Notifications\OrderPlaced;
use Ecjia\App\Orders\Notifications\OrderPickup;
defined('IN_ECJIA') or exit('No permission resources.');


/**
 * @author will.chen
 */
class cart_flow_done_api extends Component_Event_Api {

    /**
     * @param
     *
     * @return array
     */
	public function call(&$options) {

		RC_Loader::load_app_class('cart', 'cart', false);

		$order = $options['order'];

		$cart_id_array = $options['cart_id'];
		$flow_type = $options['flow_type'];
		
		/* 获取用户收货地址*/
		if ($options['address_id'] == 0) {
			$consignee = cart::get_consignee($_SESSION['user_id']);
		} else {
			$consignee = RC_DB::table('user_address')
			->where('address_id', $options['address_id'])
			->where('user_id', $_SESSION['user_id'])
			->first();
		}
		$mobile_location_range = ecjia::config('mobile_location_range');
		//if (isset($consignee['latitude']) && isset($consignee['longitude']) && $mobile_location_range > 0) {
		//	$geohash = RC_Loader::load_app_class('geohash', 'store');
		//	$geohash_code = $geohash->encode($consignee['latitude'] , $consignee['longitude']);
		//	$store_id_group = RC_Api::api('store', 'neighbors_store_id', array('geohash' => $geohash_code, 'city_id' => ''));
		//} elseif (isset($consignee['city']) && $consignee['city'] > 0) {
		//	$store_id_group = RC_Api::api('store', 'neighbors_store_id', array('city_id' => $consignee['city']));
		//} else {
		//	return new ecjia_error('pls_fill_in_consinee_info', '请完善收货人信息！');
		//}
		
		if ($mobile_location_range > 0) {
			if (isset($consignee['latitude']) && isset($consignee['longitude'])) {
				$geohash = RC_Loader::load_app_class('geohash', 'store');
				$geohash_code = $geohash->encode($consignee['latitude'] , $consignee['longitude']);
				$store_id_group = RC_Api::api('store', 'neighbors_store_id', array('geohash' => $geohash_code, 'city_id' => ''));
			} elseif (empty($consignee['latitude']) && empty($consignee['longitude']) && !empty($consignee['city'])) {
				$store_id_group = RC_Api::api('store', 'neighbors_store_id', array('city_id' => $consignee['city']));
			} else {
				if (empty($consignee['city'])) {
					return new ecjia_error('pls_fill_in_consinee_info', __('请完善收货人信息！', 'cart'));
				}
			} 
		} else {
			if (!empty($consignee['city'])) {
				$store_id_group = RC_Api::api('store', 'neighbors_store_id', array('city_id' => $consignee['city']));
			} else {
				return new ecjia_error('pls_fill_in_consinee_info', __('请完善收货人信息！', 'cart'));
			}
		}
		
		if (empty($store_id_group)) {
			$store_id_group = array();
		}

		/* 检查购物车中是否有商品 */
		$get_cart_goods = RC_Api::api('cart', 'cart_list', array('cart_id' => $options['cart_id'], 'flow_type' => $options['flow_type'], 'store_group' => $store_id_group));

		if (is_ecjia_error($get_cart_goods)) {
		    return $get_cart_goods;
		}
		if (count($get_cart_goods['goods_list']) <= 0) {
			return new ecjia_error('not_found_cart_goods', __('购物车中没有您选择的商品', 'cart'));
		}

		$cart_goods = $get_cart_goods['goods_list'];
		
		/* 判断是不是实体商品  及店铺数量如有多家店铺返回错误*/
		$store_group = array();
		foreach ($cart_goods as $val) {
			$store_group[] = $val['store_id'];
			/* 统计实体商品的个数 */
			if ($val['is_real']) {
				$is_real_good = 1;
			}
		}
		$store_group = array_unique($store_group);
		if (count($store_group) > 1) {
			return new ecjia_error('pls_single_shop_for_settlement', __('请单个店铺进行结算!', 'cart'));
		}
		$order['store_id'] = $store_group[0];
		
		//检查店铺是否已打烊，已打烊店铺订单不可提交（防止打烊前添加的商品打烊后再结算问题）
		RC_Loader::load_app_func('merchant', 'merchant');
		$store_shop_close = RC_DB::table('store_franchisee')->where('store_id', $order['store_id'])->value('shop_close');
		$shop_trade_time = RC_DB::table('merchants_config')->where('store_id', $order['store_id'])->where('code', 'shop_trade_time')->value('value');
		$shop_closed = get_shop_close($store_shop_close, $shop_trade_time);
		if ($shop_closed == '1') {
			return new ecjia_error('shop_snoring', '当前店铺已打烊!');
		}

		/* 检查收货人信息是否完整 */
		if (!cart::check_consignee_info($consignee, $options['flow_type'])) {
			/* 如果不完整则转向到收货人信息填写界面 */
			return new ecjia_error('pls_fill_in_consinee_info', __('请完善收货人信息！', 'cart'));
		}

		/* 检查商品库存 */
		/* 如果使用库存，且下订单时减库存，则减少库存 */
		if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE) {
			$cart_goods_stock = $get_cart_goods['goods_list'];
			$_cart_goods_stock = array();
			if (!empty($cart_goods_stock['goods_list'])) {
				foreach ($cart_goods_stock['goods_list'] as $value) {
					$_cart_goods_stock[$value['rec_id']] = $value['goods_number'];
				}
				$result = cart::flow_cart_stock($_cart_goods_stock);
				if (is_ecjia_error($result)) {
					return $result;
				}
				unset($cart_goods_stock, $_cart_goods_stock);
			}
		}

		/* 扩展信息 */
		if (isset($flow_type) && intval($flow_type) != \Ecjia\App\Cart\Enums\CartEnum::CART_GENERAL_GOODS) {
			if ($flow_type == '1') {
				$order['extension_code'] = 'group_buy';
				if (!empty($cart_goods)) {
					$goods_id = $cart_goods['0']['goods_id'];
				}
				$extension_id = RC_DB::table('goods_activity')->where('store_id', $cart_goods['0']['store_id'])->where('goods_id', $goods_id)->where('act_type', GAT_GROUP_BUY)->orderBy('act_id', 'desc')->value('act_id');
				$order['extension_id'] = empty($extension_id) ? 0 : intval($extension_id);
				
			} else {
				$order['extension_code'] = '';
				$order['extension_id']   = 0;
			}
		} else {
			$order['extension_code'] = '';
			$order['extension_id']   = 0;
		}
		

		/* 检查积分余额是否合法 */
		$user_id = $_SESSION['user_id'];
		if ($user_id > 0) {
			$user_info = RC_Api::api('user', 'user_info', array('user_id' => $user_id));
			// 查询用户有多少积分
			$flow_points = cart::flow_available_points($options['cart_id']); // 该订单允许使用的积分
			$user_points = $user_info['pay_points']; // 用户的积分总数

			$order['integral'] = min($order['integral'], $user_points, $flow_points);
			if ($order['integral'] < 0) {
				$order['integral'] = 0;
			}
		} else {
			$order['surplus']  = 0;
			$order['integral'] = 0;
		}

		/* 检查红包是否存在 */
		if ($order['bonus_id'] > 0) {
			$bonus = RC_Api::api('bonus', 'bonus_info', array('bonus_id' => $order['bonus_id']));
			if (empty($bonus) || ($bonus['store_id'] != 0 && $bonus['store_id'] != $order['store_id']) || $bonus['user_id'] != $user_id || $bonus['order_id'] > 0 || $bonus['min_goods_amount'] > cart::cart_amount(true, $options['flow_type'])) {
				$order['bonus_id'] = 0;
			}
		} elseif (isset($options['bonus_sn'])) {
			$bonus_sn = trim($options['bonus_sn']);
			$bonus = RC_Api::api('bonus', 'bonus_info', array('bonus_id' => 0, 'bonus_sn' => $bonus_sn));
			$now = RC_Time::gmtime();
			if (empty($bonus) || $bonus['store_id'] != $order['store_id'] || $bonus['user_id'] > 0 || $bonus['order_id'] > 0 || $bonus['min_goods_amount'] > cart::cart_amount(true, $options['flow_type']) || $now > $bonus['use_end_date']) {} else {
				if ($user_id > 0) {
					$db_user_bonus = RC_DB::table('user_bonus');
					$db_user_bonus->where('bonus_id', $bonus['bonus_id'])->update(array('user_id' => $user_id));
				}
				$order['bonus_id'] = $bonus['bonus_id'];
				$order['bonus_sn'] = $bonus_sn;
			}
		}

		/* 检查商品总额是否达到最低限购金额 */
		//获取店铺最小购物金额设置
		$min_goods_amount = RC_DB::table('merchants_config')->where('store_id', $order['store_id'])->where('code', 'min_goods_amount')->value('value');
		$cart_amount = cart::cart_amount(true, \Ecjia\App\Cart\Enums\CartEnum::CART_GENERAL_GOODS, $options['cart_id']);
		$be_short_amount = $cart_amount - $min_goods_amount;
		$be_short_amount = price_format($be_short_amount);
		
		if ($options['flow_type'] == \Ecjia\App\Cart\Enums\CartEnum::CART_GENERAL_GOODS && $cart_amount < $min_goods_amount) {
			return new ecjia_error('bug_error', __('您的商品金额未达到最低限购金额，还差', 'cart').'【'.$be_short_amount.'】');
		}

		/* 收货人信息 */
		foreach ($consignee as $key => $value) {
			$order[$key] = addslashes($value);
			if($key == 'address_info'){
				$order['address'] = $order['address'].$order[$key];
			}
		}
	
		if (isset($is_real_good)) {
			$order['shipping_id'] = intval($order['shipping_id']);
			if (!ecjia_shipping::isEnabled($order['shipping_id'])) {
				return new ecjia_error('shipping_error', __('请选择一个配送方式！', 'cart'));
			}
		}

		/* 订单中的总额 */
		$total = cart::order_fee($order, $cart_goods, $consignee, $options['cart_id']);
		$order['bonus']			= $total['bonus']; 
		$order['goods_amount']	= $total['goods_price'];
		$order['discount']		= empty($total['discount']) ? 0.00 : $total['discount'];
		$order['surplus']		= $total['surplus'];
		$order['tax']			= $total['tax'];

		// 购物车中的商品能享受红包支付的总额
		$discount_amout = cart::compute_discount_amount($options['cart_id']);
		// 红包和积分最多能支付的金额为商品总额
		$temp_amout = $order['goods_amount'] - $discount_amout;
		if ($temp_amout <= 0) {
			$order['bonus_id'] = 0;
		}

		/* 配送方式 */
		$shipping_code = '';
		if ($order['shipping_id'] > 0) {
			$shipping = ecjia_shipping::pluginData($order['shipping_id']);
			$order['shipping_name'] = addslashes($shipping['shipping_name']);
			$shipping_code = $shipping['shipping_code'];
		}
		$order['shipping_fee'] = $total['shipping_fee'];
		$order['insure_fee'] = $total['shipping_insure'];

		$payment_method = RC_Loader::load_app_class('payment_method','payment');
		/* 支付方式 */
		$is_pay_cod = false;
		if ($order['pay_id'] > 0) {
			$payment = $payment_method->payment_info_by_id($order['pay_id']);
			$order['pay_name'] = addslashes($payment['pay_name']);
			//如果是货到付款，状态设置为已确认。
			if($payment['pay_code'] == 'pay_cod') {
				$is_pay_cod = true;
				$order['order_status'] = 1;
				$store_info = RC_DB::table('store_franchisee')->where('store_id', $store_group[0])->first();
				/* 货到付款判断是否是自营*/
				if ($store_info['manage_mode'] != 'self') {
					return new ecjia_error('pay_not_support', __('货到付款不支持非自营商家！', 'cart'));
				}
			}

		}
		$order['pay_fee']	= $total['pay_fee'];
		$order['cod_fee']	= $total['cod_fee'];

		$order['pack_fee']	= $total['pack_fee'];
		$order['card_fee']	= $total['card_fee'];

		$order['order_amount'] = number_format($total['amount'], 2, '.', '');

		$order['integral_money']	= $total['integral_money'];
		$order['integral']			= $total['integral'];

		if ($order['extension_code'] == 'exchange_goods') {
			$order['integral_money'] = 0;
			$order['integral']		 = $total['exchange_integral'];
		}

		$order['from_ad'] = ! empty($_SESSION['from_ad']) ? $_SESSION['from_ad'] : '0';
		$order['referer'] = ! empty($options['device']['client']) ? $options['device']['client'] : 'mobile';

		$parent_id = 0;
		$order['parent_id'] = $parent_id;
		/*发票识别码和抬头类型*/
		$inv_tax_no = $order['inv_tax_no'];
		$inv_title_type = $order['inv_title_type'];

		$order['order_sn'] = ecjia_order_buy_sn();

		/*过滤没有的字段*/
		unset($order['need_inv']);
		unset($order['need_insure']);
		unset($order['address_id']);
		unset($order['address_name']);
		unset($order['audit']);
		unset($order['longitude']);
		unset($order['latitude']);
		unset($order['address_info']);
		unset($order['cod_fee']);
		unset($order['inv_tax_no']);
		unset($order['inv_title_type']);
		/* 插入订单表 */
		$new_order_id = RC_DB::table('order_info')->insertGetId($order);
		$order['order_id'] = $new_order_id;
		
		if (!empty($order['inv_payee'])) {
			$inv_payee = explode(',', $order['inv_payee']);
			$order['inv_payee'] = $inv_payee['0'];
		} else {
			$order['inv_payee'] = '';
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
					'title_name' 		=> $order['inv_payee'],
					'title_type' 		=> $inv_title_type_new,
					'user_mobile' 		=> $order['mobile'],
					'tax_register_no'	=> $inv_tax_no,
					'user_address'		=> $order['address'],
					'add_time'			=> RC_Time::gmtime(),
					'is_default'		=> 1,
					'status'		    => 0,
				);
				RC_DB::table('finance_invoice')->insert($inv_data);
			}
		}
		
		/* 插入订单商品 */
		$db_order_goods = RC_DB::table('order_goods');
		$db_goods_activity = RC_DB::table('goods_activity');

		$field = 'goods_id, goods_name, goods_sn, product_id, goods_number, market_price,goods_price, goods_attr, is_real, extension_code, parent_id, is_gift, goods_attr_id, store_id';

		$data_row = RC_DB::table('cart')
			->select(RC_DB::raw($field))
			->where('user_id', $_SESSION['user_id'])
			->where('rec_type', $options['flow_type'])
			->whereIn('rec_id', $options['cart_id'])
			->get();
		
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
				RC_DB::table('order_goods')->where('order_id', $order['order_id'])->delete();
				return $result;
			}
		}

		/* 修改拍卖活动状态 */
		if ($order['extension_code'] == 'auction') {
			$db_goods_activity->where('act_id', $order['extension_id'])->update(array('is_finished' => 2));
		}

		/* 处理积分、红包 */
		if ($order['user_id'] > 0 && $order['integral'] > 0) {
			$integral_name = ecjia::config('integral_name');
			if (empty($integral_name)) {
				$integral_name = __('积分', 'cart');
			}
			$params = array(
				'user_id'		=> $order['user_id'],
				'pay_points'	=> $order['integral'] * (- 1),
				'change_desc'	=> sprintf(__('支付订单 %s', 'cart'), $order['order_sn']),
				'from_type'		=> 'order_use_integral',
				'from_value'	=> $order['order_sn']
			);
			$result = RC_Api::api('user', 'account_change_log', $params);
			if (is_ecjia_error($result)) {
				return new ecjia_error('integral_error', $integral_name.__('使用失败！', 'cart'));
			}
		}

		if ($order['bonus_id'] > 0 && $temp_amout > 0) {
			RC_Api::api('bonus', 'use_bonus', array('bonus_id' => $order['bonus_id'], 'order_id' => $new_order_id, 'order_sn' => $order['order_sn']));
		}

		/* 给商家发邮件 */
		/* 增加是否给客服发送邮件选项 */
		$service_email = ecjia::config('service_email');
		if (ecjia::config('send_service_email') && !empty($service_email)) {
			try {
				if (!is_null(ecjia_front::$controller)) {
					$tpl_name = 'remind_of_new_order';
					$tpl   = RC_Api::api('mail', 'mail_template', $tpl_name);
					
					ecjia_front::$controller->assign('order', $order);
					ecjia_front::$controller->assign('goods_list', $cart_goods);
					ecjia_front::$controller->assign('shop_name', ecjia::config('shop_name'));
					ecjia_front::$controller->assign('send_date', date(ecjia::config('time_format')));
					
					$content = ecjia_front::$controller->fetch_string($tpl['template_content']);
					
					RC_Mail::send_mail(ecjia::config('shop_name'), ecjia::config('service_email'), $tpl['template_subject'], $content, $tpl['is_html']);
				}
			} catch (PDOException $e) {
				RC_Logger::getLogger('info')->error($e);
			}
		}

		/*如果订单金额为0，并且配送方式为上门取货时发送提货码*/
		if (($order['order_amount'] + $order['surplus']) == '0.00' && (!empty($shipping_code) && ($shipping_code == 'ship_cac'))) {
			/*短信给用户发送收货验证码*/
			$userinfo = RC_DB::table('users')->where('user_id', $order['user_id'])->select('user_name', 'mobile_phone')->first();
			$mobile = $userinfo['mobile_phone'];
			if (!empty($mobile)) {
				$db_term_meta = RC_DB::table('term_meta');
				$max_code = $db_term_meta->where('object_type', 'ecjia.order')->where('object_group', 'order')->where('meta_key', 'receipt_verification')->max('meta_value');
				$max_code = $max_code ? ceil($max_code/10000) : 1000000;
				$code = $max_code . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);

				$orm_user_db = RC_Model::model('orders/orm_users_model');
				$user_ob = $orm_user_db->find($order['user_id']);
				
				try {
					//发送短信
					$options = array(
							'mobile' => $mobile,
							'event'	 => 'sms_order_pickup',
							'value'  =>array(
									'order_sn'  	=> $order['order_sn'],
									'user_name' 	=> $order['consignee'],
									'code'  		=> $code,
									'service_phone' => ecjia::config('service_phone'),
							),
					);
					RC_Api::api('sms', 'send_event_sms', $options);
					//消息通知
					$order_pickup_data = array(
							'title'	=> __('订单收货验证码', 'cart'),
							'body'	=> sprintf(__('尊敬的%s，您在我们网站已成功下单。订单号：%s，收货验证码为：%s。请保管好您的验证码，以便收货验证', 'cart'), $userinfo['user_name'], $order['order_sn'], $code),
							'data'	=> array(
									'user_id'				=> $order['user_id'],
									'user_name'				=> $userinfo['user_name'],
									'order_id'				=> $new_order_id,
									'order_sn'				=> $order['order_sn'],
									'code'					=> $code,
							),
					);
					 
					$push_orderpickup_data = new OrderPickup($order_pickup_data);
					RC_Notification::send($user_ob, $push_orderpickup_data);
					
				} catch (PDOException $e) {
					RC_Logger::getLogger('info')->error($e);
				}
				$meta_data = array(
						'object_type'	=> 'ecjia.order',
						'object_group'	=> 'order',
						'object_id'		=> $new_order_id,
						'meta_key'		=> 'receipt_verification',
						'meta_value'	=> $code,
				);
				$db_term_meta->insert($meta_data);
			}
		}
		
		/* 如果订单金额为0 处理虚拟卡 */
		if ($order['order_amount'] <= 0) {
			$rec_type = $options['flow_type'];
			$user_id  = $_SESSION['user_id'];
			if ($user_id) {
			    $res = RC_DB::table('cart')
			    	->select(RC_DB::raw('goods_id, goods_name, goods_number AS num'))
			  		->where('is_real', 0)
			        ->where('extension_code', 'virtual_card')
			     	->where('is_real', $rec_type)
			  		->where('user_id', $user_id)
			 		->get();
			} else {
				$session_id = SESS_ID;
				$res = RC_DB::table('cart')
					->select(RC_DB::raw('goods_id, goods_name, goods_number AS num'))
       				->where('is_real', 0)
                  	->where('extension_code', 'virtual_card')
                  	->where('is_real', $rec_type)
                 	->where('session_id', $session_id)
                  	->get();
			}

			$virtual_goods = array();
			foreach ($res as $row) {
				$virtual_goods['virtual_card'][] = array(
					'goods_id' 		=> $row['goods_id'],
					'goods_name' 	=> $row['goods_name'],
					'num' 			=> $row['num']
				);
			}

			if ($virtual_goods and $options['flow_type'] != \Ecjia\App\Cart\Enums\CartEnum::CART_GROUP_BUY_GOODS) {
				/* 如果没有实体商品，修改发货状态，送积分和红包 */
				$count = $db_order_goods
					->where('order_id', $order['order_id'])
					->where('is_real', '=', 1)
					->count();
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
						$params = array(
								'user_id' =>$order['user_id'],
								'rank_points' => intval($integral['rank_points']),
								'pay_points' => intval($integral['custom_points']),
								'change_desc' =>sprintf(__('订单 %s 赠送的积分', 'cart'), $order['order_sn'])
						);
						$result = RC_Api::api('user', 'account_change_log', $params);
						if (is_ecjia_error($result)) {
                        	return $result;
						}
						/* 发放红包 */
						send_order_bonus($order['order_id']);
					}
				}
			}
			$result = ecjia_app::validate_application('sms');
		}

		/* 清空购物车 */
		cart::clear_cart($flow_type, $cart_id_array, $_SESSION['user_id']);

		/* 插入支付日志 */
		$order['log_id'] = $payment_method->insert_pay_log($new_order_id, $order['order_amount'], PAY_ORDER);

		$payment_info = $payment_method->payment_info_by_id($order['pay_id']);

		if (!empty($order['shipping_name'])) {
			$order['shipping_name'] = trim(stripcslashes($order['shipping_name']));
		}

		/* 订单信息 */
		unset($_SESSION['flow_consignee']); // 清除session中保存的收货人信息
		unset($_SESSION['flow_order']);
		unset($_SESSION['direct_shopping']);
		$subject = $cart_goods[0]['goods_name'] . '等' . count($cart_goods) . '种商品';
		$order_info = array(
			'order_sn'   	=> $order['order_sn'],
			'order_id'   	=> $order['order_id'],
			'extension_code'=> $order['extension_code'],
			'extension_id'  => $order['extension_id'],
			'order_info' => array(
				'pay_code'               => $payment_info['pay_code'],
				'order_amount'           => $order['order_amount'],
		        'formatted_order_amount' => price_format($order['order_amount']),
				'order_id'               => $order['order_id'],
				'subject'                => $subject,
				'desc'                   => $subject,
				'order_sn'               => $order['order_sn']
			)
		);
		
		RC_DB::table('order_status_log')->insert(array(
			'order_status'	=> __('订单提交成功', 'cart'),
			'order_id'		=> $order['order_id'],
			'message'		=> __('下单成功，订单号：', 'cart').$order['order_sn'],
			'add_time'		=> RC_Time::gmtime(),
		));

		if (!$payment_info['is_cod'] && $order['order_amount'] > 0) {
			RC_DB::table('order_status_log')->insert(array(
				'order_status'	=> __('待付款', 'cart'),
				'order_id'		=> $order['order_id'],
				'message'		=> __('请尽快支付该订单，超时将会自动取消订单', 'cart'),
				'add_time'		=> RC_Time::gmtime(),
			));
		}
		
		if($payment_info['is_cod'] && $order['order_status'] == '1') {
			RC_Loader::load_app_class('OrderStatusLog', 'orders', false);
			OrderStatusLog::orderpaid_autoconfirm(array('order_id' => $new_order_id));
		}
		
		/* 货到付款，默认打印订单 */
		if($is_pay_cod) {
			try {
				$res = with(new Ecjia\App\Orders\OrderPrint($order['order_id'], $order['store_id']))->doPrint(true);
				if (is_ecjia_error($res)) {
					RC_Logger::getLogger('error')->error($res->get_error_message());
				}
			} catch (PDOException $e) {
				RC_Logger::getLogger('info')->error($e);
			}
		}
		
		/* 客户下单通知（默认通知店长）*/
		$staff_user = RC_DB::table('staff_user')->where('store_id', $order['store_id'])->where('parent_id', 0)->first();
		if (!empty($staff_user)) {
		    /* 如果需要，发短信 */
		    if (!empty($staff_user['mobile'])) {
		        try {
		            //发送短信
		            $options = array(
		                'mobile' => $staff_user['mobile'],
		                'event'	 => 'sms_order_placed',
		                'value'  =>array(
		                    'order_sn'		=> $order['order_sn'],
		                    'consignee' 	=> $order['consignee'],
		                    'telephone'  	=> $order['mobile'],
		                    'order_amount'  => $order['order_amount'],
		                    'service_phone' => ecjia::config('service_phone'),
		                ),
		            );
		            RC_Api::api('sms', 'send_event_sms', $options);
		        } catch (PDOException $e) {
		            RC_Logger::getLogger('info')->error($e);
		        }
		    }
            /* 通知记录*/
			$orm_staff_user_db = RC_Model::model('express/orm_staff_user_model');
			$staff_user_ob = $orm_staff_user_db->find($staff_user['user_id']);
			try {
				$order_data = array(
						'title'	=> __('客户下单', 'cart'),
						'body'	=> __('您有一笔新订单，订单号为：', 'cart').$order['order_sn'],
						'data'	=> array(
								'order_id'		         => $order['order_id'],
								'order_sn'		         => $order['order_sn'],
								'order_amount'	         => $order['order_amount'],
								'formatted_order_amount' => price_format($order['order_amount']),
								'consignee'		         => $order['consignee'],
								'mobile'		         => $order['mobile'],
								'address'		         => $order['address'],
								'order_time'	         => RC_Time::local_date(ecjia::config('time_format'), $order['add_time']),
						),
				);
					
				$push_order_placed = new OrderPlaced($order_data);
				RC_Notification::send($staff_user_ob, $push_order_placed);
			} catch (PDOException $e) {
				RC_Logger::getLogger('info')->error($e);
			}
		
			try {
				//新的推送消息方法
				$options = array(
					'user_id'   => $staff_user['user_id'],
					'user_type' => 'merchant',
					'event'     => 'order_placed',
					'value' => array(
						'order_sn'     => $order['order_sn'],
						'consignee'    => $order['consignee'],
						'telephone'    => $order['mobile'],
						'order_amount' => $order['order_amount'],
						'service_phone'=> ecjia::config('service_phone'),
					),
					'field' => array(
						'open_type' => 'admin_message',
					)
				);
				RC_Api::api('push', 'push_event_send', $options);
			} catch (PDOException $e) {
				RC_Logger::getLogger('info')->error($e);
			}
		}
		
		return $order_info;
	}
}

// end