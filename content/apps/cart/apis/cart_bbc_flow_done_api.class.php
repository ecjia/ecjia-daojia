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
 * @author zrl 到家商城购物流订单结算提交
 */
class cart_bbc_flow_done_api extends Component_Event_Api {

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
		if (!cart::check_consignee_info($consignee, $flow_type)) {
			/* 如果不完整则转向到收货人信息填写界面 */
			return new ecjia_error('pls_fill_in_consinee_info', __('请完善收货人信息！', 'cart'));
		}

		/* 检查购物车中是否有商品 */
		$get_cart_goods = RC_Api::api('cart', 'cart_list', array('cart_id' => $options['cart_id'], 'flow_type' => $options['flow_type'], 'store_group' => ''));
		
		if (is_ecjia_error($get_cart_goods)) {
		    return $get_cart_goods;
		}
		if (count($get_cart_goods['goods_list']) == 0) {
			return new ecjia_error('not_found_cart_goods', __('购物车中没有您选择的商品', 'cart'));
		}

		$cart_goods = $get_cart_goods['goods_list'];
		
		/* 判断是不是实体商品*/
		foreach ($cart_goods as $val) {
			/* 统计实体商品的个数 */
			if ($val['is_real']) {
				$is_real_good = 1;
			}
		}
		if ($is_real_good) {
			//配送方式不可为空判断
			if (empty($order['shipping_id'])) {
				return new ecjia_error('pls_choose_ship_way', __('请选择配送方式！', 'cart'));
			} else {
				if (is_array($order['shipping_id'])) {
					foreach ($order['shipping_id'] as $ship_val) {
						if (empty($ship_val)) {
							return new ecjia_error('pls_choose_ship_way', __('请选择配送方式！', 'cart'));
						}
					}
				}
			}
		}
		/* 检查收货人信息是否完整 */
		if (!cart::check_consignee_info($consignee, $options['flow_type'])) {
			/* 如果不完整则转向到收货人信息填写界面 */
			return new ecjia_error('pls_fill_in_consinee_info', __('请完善收货人信息！', 'cart'));
		}

		/* 如果使用库存,检查商品库存是否足够 */
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
		if (isset($flow_type) && intval($flow_type) != CART_GENERAL_GOODS) {
			if ($flow_type == '1') {
				$order['extension_code'] = 'group_buy';
				if (!empty($cart_goods)) {
					$goods_id = $cart_goods['0']['goods_id'];
				}
				$extension_id = RC_DB::table('goods_activity')->where('store_id', $cart_goods['0']['store_id'])->where('goods_id', $goods_id)->where('act_type', GAT_GROUP_BUY)->orderBy('act_id', 'desc')->pluck('act_id');
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

			$order['integral'] = min($order['integral'], $user_points, $flow_points); //使用积分数不可超过订单可用积分数
			if ($order['integral'] < 0) {
				$order['integral'] = 0;
			}
		} else {
			$order['surplus']  = 0;
			$order['integral'] = 0;
		}

		/* 收货人信息 */
		foreach ($consignee as $key => $value) {
			$order[$key] = addslashes($value);
			if($key == 'address_info'){
				$order['address'] = $order['address'].$order[$key];
			}
		}

		//购物车处理，获取各店铺优惠活动
		$format_cart_list = cart_bbc::formated_bbc_cart_list($get_cart_goods, $_SESSION['user_rank'], $_SESSION['user_id']);
		
		//多店铺商品列表划分,含配送方式
		$cart_goods_list = cart_bbc::store_cart_goods_discount($format_cart_list, $consignee); // 取得商品列表，计算合计
		
		/* 检查红包是否存在 */
		if ($order['bonus_id'] > 0) {
			RC_Loader::load_app_class('bonus', 'bonus', false);
			$bonus = bonus::bonus_info($order['bonus_id']);
			if (empty($bonus) || $bonus['user_id'] != $user_id || $bonus['order_id'] > 0 || $bonus['min_goods_amount'] > cart::cart_amount(true, $options['flow_type'])) {
				$order['bonus_id'] = 0;
			}
			//根据红包所属的店铺，判断店铺购物车金额是否满足使用红包
			if ($order['bonus_id'] > 0) {
				foreach ($cart_goods_list as $v) {
					if ($bonus['store_id'] == $v['store_id']) {
						$temp_amout = $v['goods_amount'] - $v['total']['discount'];
						if ($temp_amout <= 0) {
							$order['bonus_id'] = 0;
							$temp_amout = 0;
						}
						$order['temp_amout'] = $temp_amout;
					}
				}
			}
		}
		
		/* 订单中的总额 */
		$total = cart_bbc::order_fee_multiple_store($order, $cart_goods, $consignee, $options['cart_id'], $cart_goods_list, $options['store_ids'], $format_cart_list);
		
		$order['bonus']			= $total['bonus']; 
		$order['goods_amount']	= $total['goods_price'];
		$order['discount']		= empty($total['discount']) ? 0.00 : $total['discount'];
		$order['surplus']		= $total['surplus'];
		$order['tax']			= $total['tax'];

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
				$store_manage_modes = RC_DB::table('store_franchisee')->whereIn('store_id', $format_cart_list['cart_store_ids'])->lists('manage_mode');
				/* 货到付款判断是否是自营*/
				if (in_array('join', $store_manage_modes)) {
					return new ecjia_error('pay_not_support', __('货到付款不支持非自营商家！', 'cart'));
				}
			}
		}

		$order['pay_fee']	= $total['pay_fee'];
		$order['cod_fee']	= $total['cod_fee'];

		$order['pack_fee']	= $total['pack_fee'];
		$order['card_fee']	= $total['card_fee'];

		$order['order_amount'] = number_format($total['amount'], 2, '.', '');

		/* 如果订单金额为0（使用余额或积分或红包支付），修改订单状态为已确认、已付款 */
		if ($order['order_amount'] <= 0) {
			$order['order_status']	= OS_CONFIRMED;
			$order['confirm_time']	= RC_Time::gmtime();
			$order['pay_status']	= PS_PAYED;
			$order['pay_time']		= RC_Time::gmtime();
			$order['order_amount']	= 0;
		}

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
		
		//生成订单
		$is_separate_order = $options['is_separate_order'];
		if(!$is_separate_order) {
			$create_order = cart_bbc::generate_order($cart_goods_list, $order);
		} else {
			//分单
			$create_order = cart_bbc::generate_separate_order($cart_goods_list, $order, $flow_points);
		}
		
		if (is_ecjia_error($create_order)) {
			return $create_order;
		}

		$payment_info = $payment_method->payment_info_by_id($order['pay_id']);

		/* 订单信息 */
		unset($_SESSION['flow_consignee']); // 清除session中保存的收货人信息
		unset($_SESSION['flow_order']);
		
		/* 清空购物车 */
		if (!is_ecjia_error($create_order)) {
			cart::clear_cart($flow_type, $cart_id_array);
		}
		
		$order_info = array(
			'order_sn'   	=> $create_order['order_sn'],
			'order_id'   	=> $create_order['order_id'],
			'extension_code'=> $create_order['extension_code'],
			'extension_id'  => $create_order['extension_id'],
			'order_info' => array(
				'pay_code'               => $payment_info['pay_code'],
				'order_amount'           => $create_order['order_amount'],
		        'formatted_order_amount' => ecjia_price_format($create_order['order_amount'], false),
				'order_id'               => $create_order['order_id'],
				'order_sn'               => $create_order['order_sn']
			)
		);
		
		return $order_info;
	}
}

// end