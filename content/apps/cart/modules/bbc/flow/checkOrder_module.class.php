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
 * 到家商城购物流检查订单
 * @author zrl
 */
class bbc_flow_checkOrder_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

    	$this->authSession();
    	$user_id = $_SESSION['user_id'];
    	if ($user_id <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}

    	$address_id = $this->requestData('address_id', 0);
		$rec_id		= $this->requestData('rec_id');
		$location 	= $this->requestData('location', array());
		
		if (empty($rec_id)) {
		    return new ecjia_error( 'invalid_parameter', __('请求接口bbc_flow_checkOrder参数无效', 'cart'));
		}
		$cart_id = array();
		if (!empty($rec_id)) {
			$cart_id = explode(',', $rec_id);
		}
		RC_Loader::load_app_class('cart', 'cart', false);

		/* 取得购物类型 */
		$rec_type = RC_DB::table('cart')->whereIn('rec_id', $cart_id)->lists('rec_type');
		$rec_type = array_unique($rec_type);
		if (count($rec_type) > 1) {
			return new ecjia_error( 'error_rec_type', __('购物车类型不一致！', 'cart'));
		} else {
			$rec_type = $rec_type['0'];
			if ($rec_type == 1) {
				$flow_type = CART_GROUP_BUY_GOODS;
			} else {
				$flow_type = CART_GENERAL_GOODS;
			}
		}
		/* 团购标志 */
		if ($flow_type == CART_GROUP_BUY_GOODS) {
			$is_group_buy = 1;
			$order_activity_type = 'group_buy';
		} elseif ($flow_type == CART_EXCHANGE_GOODS) {
			/* 积分兑换商品 */
			$is_exchange_goods = 1;
		} else {
			//正常购物流程  清空其他购物流程情况
			$_SESSION['flow_order']['extension_code'] = '';
			$order_activity_type = 'default';
		}
		
		$count = $this->cart_count($user_id, $flow_type, $cart_id);
		
		if ($count == 0) {
			return new ecjia_error('not_found_cart_goods', __('购物车中还没有商品', 'cart'));
		}
		
		//多店购物车获取
		$store_ids = $this->get_store_ids($user_id, $flow_type, $cart_id);
		 
		$cart_multi = (new \Ecjia\App\Cart\CartFlow\MultiCart());
		
		foreach ($store_ids as $val) {
			//单店购物车
			$cart_single = (new \Ecjia\App\Cart\CartFlow\Cart($user_id, $val, $flow_type, $cart_id));
			
			//多店购物车
			$cart_multi->addCart($cart_single);
		}
		
		$format_cart_list = $cart_multi->getGoodsCollection();
		
		/* 对是否允许修改购物车赋值 */
		if ($flow_type != CART_GENERAL_GOODS || ecjia::config('one_step_buy') == '1') {
		    $allow_edit_cart = 0 ;
		} else {
		    $allow_edit_cart = 1 ;
		}

		/* 获取用户收货地址*/
		if ($address_id > 0) {
			$consignee = RC_DB::table('user_address')->where('address_id', $address_id)->where('user_id', $_SESSION['user_id'])->first();
			$_SESSION['address_id'] = $address_id;
		} else {
			if (isset($_SESSION['address_id'])) {
				$consignee = RC_DB::table('user_address')->where('address_id', $_SESSION['address_id'])->where('user_id', $_SESSION['user_id'])->first();
			} else {
				$consignee = cart::get_consignee($_SESSION['user_id']);
			}
		}
		
		/* 取得订单信息*/
		$order = cart::flow_order_info();
		
		//多店铺商品列表划分,含配送方式
		$cart_goods_list = Ecjia\App\Cart\CartFlow\CartGoodsFormate::store_cart_goods($format_cart_list, $consignee); // 取得商品列表，计算合计
		
		//支付方式列表
		$cod_fee = 0;
		$payment_list = RC_Api::api('payment', 'available_payments', array('cod_fee' => $cod_fee));
		
		if ($flow_type == CART_GROUP_BUY_GOODS) {
			//团购不支持货到付款支付，过滤
			$collection = collect($payment_list);
			$payment_list = $collection->filter(function ($value, $key) {
				return $value['pay_code'] != 'pay_cod';
			})->all();
		}
		
		$user_info = RC_Api::api('user', 'user_info', array('user_id' => $_SESSION['user_id']));
		
		if (is_ecjia_error($user_info)) {
			return $user_info;
		}
		
		/* 保存 session */
		$_SESSION['flow_order'] = $order;
		$out = array();
		$out['store_goods_list']= $cart_goods_list;//商品
		$out['consignee']		= $consignee;//收货地址
		$out['payment_list']	= $payment_list;//支付信息

		/* 如果使用积分，取得用户可用积分及本订单最多可以使用的积分 */
		if ((ecjia_config::has('use_integral') || ecjia::config('use_integral') == '1') && $_SESSION['user_id'] > 0 && $user_info['pay_points'] > 0 && ($flow_type != CART_GROUP_BUY_GOODS && $flow_type != CART_EXCHANGE_GOODS)) {
			// 能使用积分
			$allow_use_integral = 1;
			$order_max_integral = cart::flow_available_points($cart_id);
			$user_pay_points 	= $user_info['pay_points'] > 0 ? $user_info['pay_points'] : 0;
			$order_max_integral = min($order_max_integral, $user_pay_points);
		} else {
			$allow_use_integral = 0;
			$order_max_integral = 0;
		}
		$out['allow_use_integral'] = $allow_use_integral;//积分 是否使用积分
		$out['order_max_integral'] = $order_max_integral;//订单最大可使用积分
		
		/* 如果使用红包，取得用户可以使用的红包及用户选择的红包 */
		if ((ecjia_config::has('use_bonus') || ecjia::config('use_bonus') == '1') && ($flow_type != CART_GROUP_BUY_GOODS && $flow_type != CART_EXCHANGE_GOODS)){
			// 取得用户可用红包
			$pra = array(
					'user_id' 			=> $_SESSION['user_id'],
					'store_id' 			=> $store_ids,
					'min_goods_amount'	=> $format_cart_list['total']['unformatted_goods_price']
			);
			$user_bonus = Ecjia\App\Bonus\UserAvaliableBonus::GetUserBonus($pra);
			$bonus_list = $this->get_format_bonus($user_bonus);
			// 能使用红包
			$allow_use_bonus = 1;
		} else {
			$allow_use_bonus = 0;
		}
		$out['allow_use_bonus']		= $allow_use_bonus;//是否使用红包
		$out['bonus']				= !empty($bonus_list) ? $bonus_list : array();//红包
		
		//能否开发票
		$out['allow_can_invoice']	= ecjia::config('can_invoice');
		/* 如果能开发票，取得发票内容列表 */
		$invoice_info = $this->invoice_info($flow_type);
		$out['inv_content_list'] 	= $invoice_info['inv_content_list'];
		$out['inv_type_list'] 		= $invoice_info['inv_type_list'];
		
		$out['your_integral']		= $user_info['pay_points'] > 0 ? $user_info['pay_points'] : 0;//用户可用积分
		
		//团购结算不可使用优惠活动
		if ($flow_type != CART_GROUP_BUY_GOODS) {
			$out['discount']			= number_format($format_cart_list['total']['discount'], 2, '.', '');//用户享受折扣数
			$out['discount_formated']	= $format_cart_list['total']['formatted_discount'];
		} else {
			$out['discount']			= 0;//用户享受折扣数
			$out['discount_formated']	= '';
		}
		
		$out['goods_amount']		= $format_cart_list['total']['unformatted_goods_price'];
		$out['format_goods_amount']	= ecjia_price_format($format_cart_list['total']['unformatted_goods_price'], false);
		
		//收货人信息处理
		$out_consignee = $this->get_format_consignee($out['consignee']);
		$out['consignee'] = $out_consignee;
		
		return $out;
	}
	
	/**
	 * 发票内容信息获取
	 */
	private function invoice_info($flow_type)
	{
		$inv_content_list = [];
		$inv_type_list =[];
		if ((ecjia_config::has('can_invoice') && ecjia::config('can_invoice') == '1') && ecjia_config::has('invoice_content') && $flow_type != CART_EXCHANGE_GOODS)
		{
			$inv_content_list = explode("\n", str_replace("\r", '', ecjia::config('invoice_content')));
			$inv_type_list = $this->get_inv_type_list();//发票类型及税率
		}
		$inv_content_list   = empty($inv_content_list) ? [] : $inv_content_list;//发票内容项
		if (!empty($inv_content_list)) {
			$temp = array();
			foreach ($inv_content_list as $key => $value) {
				$temp[] = array('id'=>$key, 'value'=>$value);
			}
			$inv_content_list = $temp;
		}
		if (!empty($inv_type_list)) {
			$temp = array();
			$i = 1;
			foreach ($inv_type_list as $key => $value) {
				$temp[] = array(
						'id'           => $i,
						'value'        => $value['label'],
						'label_value'  => $value['label_type'],
						'rate'         => $value['rate']);
				$i++;
			}
			$inv_type_list = $temp;
		}
	
		return ['inv_type_list' => $inv_type_list, 'inv_content_list' => $inv_content_list];
	}
	
	/**
	 * 订单可用红包数据处理
	 */
	private function get_format_bonus($user_bonus)
	{
		$bonus_list = array();
		if (!empty($user_bonus)) {
			foreach ($user_bonus AS $key => $val) {
				$bonus_list[] = array(
						'type_id'               => intval($val['type_id']),
						'type_name'             => trim($val['type_name']),
						'bonus_money'           => $val['type_money'],
						'bonus_id'              => intval($val['bonus_id']),
						'bonus_money_formated'  => ecjia_price_format($val['type_money'], false),
						'store_id'              => intval($val['store_id']),
						'store_name'            => $val['merchants_name'],
				);
			}
		}
	
		return $bonus_list;
	}
	
	/**
	 * 发票类型及税率
	 */
	private function get_inv_type_list()
	{
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
	
		return $inv_type_list;
	}
	
	/**
	 * 收货人信息处理
	 */
	private function get_format_consignee($consignee = array())
	{
		if (!empty($consignee)) {
			$consignee['id'] = $consignee['address_id'];
			unset($consignee['address_id']);
			unset($consignee['user_id']);
			unset($consignee['address_id']);
			$ids = array($consignee['province'], $consignee['city'], $consignee['district'], $consignee['street']);
			$ids = array_filter($ids);
	
			$data = array();
			if (!empty($ids)) {
				$data = ecjia_region::getRegions($ids);
			}
	
			$a_out = array();
			if (!empty($data)) {
				foreach ($data as $key => $val) {
					$a_out[$val['region_id']] = $val['region_name'];
				}
			}
			$country = ecjia_region::getCountryName($consignee['country']);
			$consignee['country_name']  = $country;
			$consignee['province_name'] = isset($a_out[$consignee['province']]) ? $a_out[$consignee['province']] : '';
			$consignee['city_name']     = isset($a_out[$consignee['city']])  ? $a_out[$consignee['city']]   : '';
			$consignee['district_name'] = isset($a_out[$consignee['district']]) ? $a_out[$consignee['district']] : '';
			$consignee['street_name']   = isset($a_out[$consignee['street']])   ? $a_out[$consignee['street']] : '';
		}
		return $consignee;
	}
	
	/**
	 * 购物车商品
	 */
	private function cart_count($user_id, $flow_type, $cart_id)
	{
		$db = RC_DB::table('cart as c')
		->leftJoin('store_franchisee as s', RC_DB::raw('s.store_id'), '=', RC_DB::raw('c.store_id'));
	
		$count = $db->where(RC_DB::raw('c.user_id'), $user_id)->where(RC_DB::raw('c.rec_type'), $flow_type)->whereIn(RC_DB::raw('c.rec_id'), $cart_id)->where(RC_DB::raw('s.shop_close'), '=', '0')->count(RC_DB::raw('c.rec_id'));
		return $count;
	}
	
	/**
	 * 购物车店铺ids
	 */
	private function get_store_ids($user_id, $flow_type, $cart_id)
	{
		$store_ids = RC_DB::table('cart')->where('user_id', $user_id)->where('rec_type', $flow_type)->whereIn('rec_id', $cart_id)->lists('store_id');
		$store_ids = array_unique($store_ids);
		return $store_ids;
	}
	
}

// end