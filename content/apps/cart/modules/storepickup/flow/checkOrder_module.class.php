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
class storepickup_flow_checkOrder_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

    	$this->authSession();
    	if ($_SESSION['user_id'] <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}
//     	$_SESSION['user_id'] = 1040;

		$rec_id		= $this->requestData('rec_id');
		
		if (empty($rec_id)) {
            return new ecjia_error('invalid_parameter', sprintf(__('请求接口%s参数无效', 'cart'), __CLASS__));
		}
		$cart_id = array();
		if (!empty($rec_id)) {
			$cart_id = explode(',', $rec_id);
		}
		RC_Loader::load_app_class('cart', 'cart', false);
		RC_Loader::load_app_func('cart','cart');
		RC_Loader::load_app_func('cashdesk','cart');
		RC_Loader::load_app_func('admin_order','orders');
		RC_Loader::load_app_func('admin_bonus','bonus');

		/* 取得购物类型 */
		$flow_type = \Ecjia\App\Cart\Enums\CartEnum::CART_GENERAL_GOODS;
		/* 取得购物类型 */
		//$flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

		/* 对商品信息赋值 */
		$cart_goods = Ecjia\App\Cart\CartFunction::cart_goods($flow_type, $cart_id); // 取得商品列表，计算合计
		
		if (empty($cart_goods)) {
			return new ecjia_error('not_found_cart_goods', __('购物车中还没有商品', 'cart'));
		}
		
		/* 取得订单信息*/
		$order = flow_order_info();
		/* 计算订单的费用 */
		$total = cashdesk_order_fee($order, $cart_goods, array(), $cart_id);
	
// 		/* 取得支付列表 */
// 		$cod_fee    = 0;
// 		$payment_method = RC_Loader::load_app_class('payment_method', 'payment');
// 		// 给货到付款的手续费加<span id>，以便改变配送的时候动态显示
// 		$payment_list = $payment_method->available_payment_list(1, $cod_fee);
		if (!empty($_SESSION['user_id'])) {
			$user_info = user_info($_SESSION['user_id']);
			if (is_ecjia_error($user_info)) {
				return $user_info;
			}
		}
		
		
		$out = array();
		$out['checkorder_mode']	= 'storepickup';
		$out['user_info'] = array();
		if (isset($_SESSION['user_id']) && $_SESSION['user_id']) {
			$user_info = RC_Model::model('user/users_model')->find(array('user_id' => $_SESSION['user_id']));
			$out['user_info'] = array(
					'user_id'	=> intval($user_info['user_id']),
					'user_name'	=> $user_info['user_name'],
					'mobile'	=> $user_info['mobile_phone'],
					'integral'	=> $user_info['pay_points'] > 0 ? intval($user_info['pay_points']) : 0,
			);
		}
		
		$out['goods_list']		= $cart_goods;		//商品
// 		$out['consignee']		= $consignee;		//收货地址
// 		$out['shipping_list']	= $shipping_list;	//快递信息
// 		$out['payment_list']	= $payment_list;
		/* 如果使用积分，取得用户可用积分及本订单最多可以使用的积分 */
		/*会员价处理*/
		$store_group = array();
		$rec_ids = array();
		if (!empty($cart_goods)) {
			foreach ($cart_goods as $k => $v) {
				$rec_ids[] = $v['rec_id'];
				$store_group[] = $v['store_id'];
			}
			$store_group = array_unique($store_group);
			$store_id = $store_group['0'];
		}
		
		if (count($store_group) > 1) {
			return new ecjia_error('pls_single_shop_for_settlement', __('请单个店铺进行结算!', 'cart'));
		} else {
			$store_id = $store_group[0];
		}
		
		//店铺是否被锁定
		if (!empty($store_id)) {
			$store_status 	= Ecjia\App\Cart\StoreStatus::GetStoreStatus($store_id);
			if ($store_status == Ecjia\App\Cart\StoreStatus::LOCKED) {
				return new ecjia_error('store_locked', __('对不起，商品所属的店铺已锁定！', 'cart'));
			}
		}
		
		/*店铺信息*/
		$shop_kf_mobile = RC_DB::table('merchants_config')->where('store_id', $store_id)->where('code', 'shop_kf_mobile')->pluck('value');
		$store_info = RC_DB::table('store_franchisee')->where('store_id', $store_id)->select(RC_DB::raw('merchants_name, province, city, district, street, address, longitude, latitude'))->first();
		$store_address = ecjia_region::getRegionName($store_info['province']).ecjia_region::getRegionName($store_info['city']).ecjia_region::getRegionName($store_info['district']).ecjia_region::getRegionName($store_info['street']).$store_info['address']; 
		$out['store_info'] = array('store_name' => $store_info['merchants_name'], 'store_address' => $store_address, 'shop_kf_mobile' => $shop_kf_mobile, 'location' => array('longitude' => $store_info['longitude'], 'latitude' => $store_info['latitude']));
		$payment_list = RC_Api::api('payment', 'available_payments', array('store_id' => $store_id, 'cod_fee' => 0));
		$out['payment_list']	= $payment_list;//支付信息
		
		if ((ecjia::config('use_integral', ecjia::CONFIG_CHECK) || ecjia::config('use_integral') == '1')
		&& $_SESSION['user_id'] > 0
		&& $user_info['pay_points'] > 0
		&& ($flow_type != \Ecjia\App\Cart\Enums\CartEnum::CART_GROUP_BUY_GOODS && $flow_type != \Ecjia\App\Cart\Enums\CartEnum::CART_EXCHANGE_GOODS))
		{
			// 能使用积分
			$allow_use_integral = 1;
			$order_max_integral = cart::flow_available_points($rec_ids, $flow_type);
			$user_pay_points = $user_info['pay_points'] > 0 ? $user_info['pay_points'] : 0;
			$order_max_integral  = min($order_max_integral, $user_pay_points);
		} else {
			$allow_use_integral = 0;
			$order_max_integral = 0;
		}
		
		$out['allow_use_integral'] = $allow_use_integral;//积分 是否使用积分
		$out['order_max_integral'] = $order_max_integral;//订单最大可使用积分
		/* 如果使用红包，取得用户可以使用的红包及用户选择的红包 */
		$allow_use_bonus = 0;
		$bonus_list = array();
		if ((ecjia::config('use_bonus', ecjia::CONFIG_CHECK) || ecjia::config('use_bonus') == '1')
				&& ($flow_type != \Ecjia\App\Cart\Enums\CartEnum::CART_GROUP_BUY_GOODS && $flow_type != \Ecjia\App\Cart\Enums\CartEnum::CART_EXCHANGE_GOODS)){
			// 取得用户可用红包
			$user_bonus = user_bonus($_SESSION['user_id'], $total['goods_price'], array(), $store_id);
			if (!empty($user_bonus)) {
				foreach ($user_bonus AS $key => $val) {
					$bonus_list[] = array(
							'bonus_id' 					=> $val['bonus_id'],
							'store_id'					=> $val['store_id'],
							'bonus_name' 				=> $val['type_name'],
							'bonus_amount'				=> $val['type_money'],
							'formatted_bonus_amount' 	=>  price_format($val['type_money'], false),
							'start_date'               	=> $val['use_start_date'],
							'end_date'               	=> $val['use_end_date'],
							'formatted_start_date' 		=> RC_Time::local_date(ecjia::config('date_format'), $val['use_start_date']),
							'formatted_end_date' 		=> RC_Time::local_date(ecjia::config('date_format'), $val['use_end_date']),
							'request_amount' 			=> $val['min_goods_amount'],
							'formatted_request_amount' 	=> $val['min_goods_amount'],
							'label_min_amount' 			=> sprintf(__('满%s可使用', 'cart'), $val['min_goods_amount'])
					);
				}
			}
			// 能使用红包
			$allow_use_bonus = 1;
		}
		
		$out['allow_use_bonus'] = $allow_use_bonus;//是否使用红包
		$out['bonus'] 			= $bonus_list;//红包
		
		$out['allow_can_invoice']	= ecjia::config('can_invoice');//能否开发票
		/* 如果能开发票，取得发票内容列表 */
		if ((ecjia_config::has('can_invoice') && ecjia::config('can_invoice') == '1')
		&& ecjia_config::has('invoice_content')
		&& $flow_type != \Ecjia\App\Cart\Enums\CartEnum::CART_EXCHANGE_GOODS)
		{
			$inv_content_list = explode("\n", str_replace("\r", '', ecjia::config('invoice_content')));
				
			$inv_type_list = array();
			$invoice_type  = ecjia::config('invoice_type');
			$invoice_type = unserialize($invoice_type);
			foreach ($invoice_type['type'] as $key => $type) {
				if (!empty($type)) {
					$inv_type_list[$type] = array(
							'label'      => $type . ' [' . floatval($invoice_type['rate'][$key]) . '%]',
							'label_type' => $type,
							'rate'       => floatval($invoice_type['rate'][$key])
					);
				}
			}
		}
		$out['inv_content_list']	= empty($inv_content_list) ? array() : $inv_content_list;//发票内容项
		$out['inv_type_list']		= empty($inv_type_list) ? array() : $inv_type_list;//发票类型及税率
		/*发票内容处理*/
		if (!empty($out['inv_content_list'])) {
			$temp = array();
			foreach ($out['inv_content_list'] as $key => $value) {
				$temp[] = array('id'=>$key, 'value'=>$value);
			}
			$out['inv_content_list'] = $temp;
		}
		if (!empty($out['inv_type_list'])) {
			$temp = array();
			$i = 1;
			foreach ($out['inv_type_list'] as $key => $value) {
				$temp[] = array(
						'id'	       => $i,
						'value'	       => $value['label'],
						'label_value'  => $value['label_type'],
						'rate'	       => $value['rate']);
				$i++;
			}
			$out['inv_type_list'] = $temp;
		}
		
		$out['your_integral']	= $user_info['pay_points'] > 0 ? $user_info['pay_points'] : 0;//用户可用积分
		$out['discount']		= number_format($total['discount'], 2, '.', '');//用户享受折扣数
		$out['discount_formated'] = $total['discount_formated'];
				
		if (!empty($out['payment_list'])) {
			foreach ($out['payment_list'] as $key => $value) {
				unset($out['payment_list'][$key]['pay_config']);
				unset($out['payment_list'][$key]['pay_desc']);
				$out['payment_list'][$key]['pay_name'] = strip_tags($value['pay_name']);
				// cod 货到付款，alipay支付宝，bank银行转账
				if (in_array($value['pay_code'], array('post', 'balance'))) {
					unset($out['payment_list'][$key]);
				}
			}
			$out['payment_list'] = array_values($out['payment_list']);
		}

		/*ship_cac上门取货*/
		/*取货时间*/
		$expect_pickup_date = array();
		//$store_region_info = RC_DB::table('store_franchisee')->where('store_id', $store_id)->select('province', 'city', 'district', 'street')->first();
		//$store_region_info['country'] = ecjia::config('shop_country');
		//$region            = array($store_region_info['country'], $store_region_info['province'], $store_region_info['city'], $store_region_info['district'], $store_region_info['street']);
		//$shipping_list     = ecjia_shipping::availableUserShippings($region, $store_id);
		//根据店铺id，店铺有没设置运费模板，查找店铺设置的运费模板关联的快递
		$expect_pickup_date = cart::get_ship_cac_date_by_store($store_id);
		
		$out['expect_pickup_date'] = $expect_pickup_date;
		
		return $out;
	}
}

// end