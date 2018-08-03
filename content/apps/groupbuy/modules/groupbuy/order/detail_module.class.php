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
 * 订单详情
 * @author royalwang
 */
class detail_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
        
    	$user_id = $_SESSION['user_id'];
    	if ($user_id < 1 ) {
    	    return new ecjia_error(100, 'Invalid session');
    	}

		RC_Loader::load_app_func('admin_order', 'orders');
		$order_id = $this->requestData('order_id', 0);
		if (!$order_id) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('orders::order.invalid_parameter'));
		}

		/* 订单详情 */
		$order = get_order_detail($order_id, $user_id, 'front');
		
		if (is_ecjia_error($order)) {
			return $order;
		}
		if (empty($order)) {
			return new ecjia_error('not_exist_info', "不存在的信息！");
		}
		
		/*发票抬头和发票识别码处理*/
		if (!empty($order['inv_payee'])) {
			if (strpos($order['inv_payee'],",") > 0) {
				$inv = explode(',', $order['inv_payee']);
				$order['inv_payee'] = $inv['0'];
				$order['inv_tax_no'] = $inv['1'];
				$order['inv_title_type'] = 'enterprise';
			} else {
				$order['inv_tax_no'] = '';
				$order['inv_title_type'] = 'personal';
			}
		} 
		
		//获取支付方式的pay_code
		if (!empty($order['pay_id'])) {
			$payment = with(new Ecjia\App\Payment\PaymentPlugin)->getPluginDataById($order['pay_id']);
			$order['pay_code'] = $payment['pay_code'];
		} else {
			$order['pay_code'] = '';
		}
		
		/*订单状态处理*/
		$order_status_info = get_order_status($order['order_status'], $order['shipping_status'], $order['pay_status'], $payment['is_cod']);
		$order['order_status_code'] = empty($order_status_info['status_code']) ? '' : $order_status_info['status_code'];
		$order['label_order_status'] = empty($order_status_info['label_order_status']) ? '' : $order_status_info['label_order_status'];
		
		//配送费：已发货的不退，未发货的退
		if ($order['shipping_status'] > SS_UNSHIPPED) {
			$refund_total_amount  = $order['money_paid'] + $order['surplus'] - $order['pay_fee']- $order['shipping_fee'] - $order['insure_fee'];
			$refund_shipping_fee  = 0;
		} else {
			$refund_total_amount  = $order['money_paid'] + $order['surplus'] - $order['pay_fee'];
			$refund_shipping_fee  = $order['shipping_fee'] > 0 ? price_format($order['shipping_fee']) : 0 ;
		}
		
		/*订单有没申请退款*/
		RC_Loader::load_app_class('order_refund', 'refund', false);
		$refund_info = order_refund::currorder_refund_info($order_id);
		if (!empty($refund_info)) {
			$refund_status_info = get_refund_status($refund_info);
			
			//被拒后返回原因，供重新申请使用
			$refused_reasons =array();
			if ($refund_info['status'] == Ecjia\App\Refund\RefundStatus::REFUSED) {
				$refused_reasons = order_refund::get_one_group_reasons($refund_info['refund_reason']);
			}
			
			$order['refund_info'] = array(
					'refund_type' 			=> $refund_info['refund_type'],
					'label_refund_type' 	=> $refund_info['refund_type'] == 'refund' ? '仅退款' : '退货退款',
					'refund_id'		        => $refund_info['refund_id'],
					'refund_sn'	  			=> $refund_info['refund_sn'],
					'refund_status'			=> empty($refund_status_info['refund_status_code']) ? '' : $refund_status_info['refund_status_code'],
					'label_refund_status'	=> empty($refund_status_info['label_refund_status']) ? '' : $refund_status_info['label_refund_status'],
					'refund_goods_amount'	=> price_format($refund_info['goods_amount']),	
					'refund_inv_tax'		=> price_format($refund_info['inv_tax']), 	
					'refund_integral'		=> intval($refund_info['integral']),
					'refund_total_amount '	=> price_format($refund_total_amount),
					'reason_id'				=> intval($refund_info['refund_reason']),
					'reason'				=> order_refund::get_reason(array('reason_id' => $refund_info['refund_reason'])),
					'refund_desc'			=> $refund_info['refund_content'],
					'return_images'			=> order_refund::get_return_images($refund_info['refund_id']),
					'refused_reasons'       => $refused_reasons,
			);	
		} 
		
		$refund_fee_info = array(
				'refund_goods_amount' => price_format($order['goods_amount']),
				'refund_shipping_fee' => $refund_shipping_fee,
				'refund_inv_tax'	  => $order['tax'] > 0 ? price_format($order['tax']) : 0 ,
				'refund_integral'	  => intval($order['integral']),
				'refund_total_amount' => price_format($refund_total_amount)
		);
		$order['refund_fee_info'] = $refund_fee_info;
		
		/*返回数据处理*/
		$order['order_id'] 			= intval($order['order_id']);
		if (in_array($order['extension_code'], array('storebuy', 'cashdesk'))) {
			$order['order_mode'] = 'storebuy';
			$order['label_order_mode'] = '扫码购';
		} elseif ($order['extension_code'] == 'storepickup') {
			$order['order_mode'] = 'storepickup';
			$order['label_order_mode'] = '自提';
		} elseif ($order['extension_code'] == 'group_buy') {
			$order['order_mode'] = 'groupbuy';
			$order['label_order_mode'] = '团购';
		} else {
			$order['order_mode'] = 'default';
			$order['label_order_mode'] = '配送';
		}
		$order['user_id'] 			= intval($order['user_id']);
		$order['order_status'] 		= intval($order['order_status']);
		$order['shipping_status'] 	= intval($order['shipping_status']);
		$order['pay_status'] 		= intval($order['pay_status']);
		$order['shipping_id'] 		= intval($order['shipping_id']);
		$order['pay_id'] 			= intval($order['pay_id']);
		$order['pay_code'] 			= trim($order['pay_code']);
		$order['pack_id'] 			= intval($order['pack_id']);
		$order['card_id'] 			= intval($order['card_id']);
		$order['bonus_id'] 			= intval($order['bonus_id']);
		$order['agency_id'] 		= intval($order['agency_id']);
		$order['extension_id'] 		= intval($order['extension_id']);
		$order['extension_code'] 	= empty($order['extension_code']) ? '' : $order['extension_code'];
		$order['parent_id'] 		= intval($order['parent_id']);
		$order['longitude']			= empty($order['longitude']) ? '' :trim($order['longitude']);
		$order['latitude']			= empty($order['latitude']) ? '' :trim($order['latitude']);
		$order['zipcode']			= empty($order['zipcode']) ? '' :trim($order['zipcode']);
		$order['best_time']			= empty($order['best_time']) ? '' :trim($order['best_time']);
		$order['sign_building']		= empty($order['sign_building']) ? '' :trim($order['sign_building']);
		$order['how_surplus']		= empty($order['how_surplus']) ? '' :trim($order['how_surplus']);
		$order['pack_name']		    = empty($order['pack_name']) ? '' :trim($order['pack_name']);
		$order['card_name']		    = empty($order['card_name']) ? '' :trim($order['card_name']);
		$order['to_buyer']		    = empty($order['to_buyer']) ? '' :trim($order['to_buyer']);
		$order['pay_note']		    = empty($order['pay_note']) ? '' :trim($order['pay_note']);
		$order['delete_time']		= empty($order['delete_time']) ? '' :trim($order['delete_time']);
		$order['sign_time']		    = empty($order['sign_time']) ? '' :trim($order['sign_time']);
		$order['how_surplus_name']	= empty($order['how_surplus_name']) ? '' :trim($order['how_surplus_name']);
		
		if ($order['pay_status'] == 2) {
			$order['is_paid'] = 1;
		} else{
			$order['is_paid'] = 0;
		}
		
		if ($order === false) {
			return new ecjia_error(8, 'fail');
		}
		
		/* 判断配送方式*/
		$shipping_info = ecjia_shipping::pluginData($order['shipping_id']);
		$order['shipping_code'] = $shipping_info['shipping_code'];
		if ($shipping_info['shipping_code'] == 'ship_o2o_express' || $shipping_info['shipping_code'] == 'ship_ecjia_express') {
			$express_info = RC_DB::table('express_order')->where('order_sn', $order['order_sn'])->orderBy('express_id', 'desc')->first();
			$order['express_user'] = $express_info['express_user'];
			$order['express_id'] = $express_info['express_id'];
			$order['express_mobile'] = $express_info['staff_id'] > 0 ? RC_DB::table('staff_user')->where('user_id', $express_info['staff_id'])->pluck('mobile') : '';
		}
		
		/*提货信息*/
		if ($shipping_info['shipping_code'] == 'ship_cac') {
			$pickup_info = RC_DB::table('term_meta')
							->where('object_id', $order['order_id'])
							->where('object_group', 'order')
							->where('meta_key', 'receipt_verification')
							->first(); 
			$order['pickup_code'] = $pickup_info['meta_value'];
			if ($order['shipping_status'] > SS_UNSHIPPED) {
				$order['pickup_status'] = 1;
				$order['label_pickup_status'] = '已提取';
				$order['pickup_code_expiretime'] = '';
			} else{
				$order['pickup_status'] = 0;
				$order['label_pickup_status'] = '未提取';
				$order['pickup_code_expiretime'] = '';
			}
		}
		
		//收货人地址
		$order['country'] = ecjia_region::getRegionName($order['country']);
		$order['province'] = ecjia_region::getRegionName($order['province']);
		$order['city'] = ecjia_region::getRegionName($order['city']);
		$order['district'] = ecjia_region::getRegionName($order['district']);
		$order['street'] = ecjia_region::getRegionName($order['street']);

		$goods_list = array();
		$goods_list = EM_order_goods($order_id);
		
		
		/*店铺有关信息*/
		if ($order['store_id'] > 0) {
			$seller_info = RC_DB::table('store_franchisee')->where('store_id', $order['store_id'])->first();
		}
		$order['seller_id']		= !empty($seller_info['store_id']) ? intval($seller_info['store_id']) : 0;
		$order['seller_name']	= !empty($seller_info['merchants_name']) ? $seller_info['merchants_name'] : '';
		$order['store_address']	= ecjia_region::getRegionName($seller_info['province']).ecjia_region::getRegionName($seller_info['city']).ecjia_region::getRegionName($seller_info['district']).ecjia_region::getRegionName($seller_info['street']).$seller_info['address'];
		$order['manage_mode']	= $seller_info['manage_mode'];
		$order['service_phone']	= RC_DB::table('merchants_config')->where('store_id', $order['store_id'])->where('code', 'shop_kf_mobile')->pluck('value');
		/*下单用户信息*/
		if (!empty($order['user_id'])) {
			$order_user_info = RC_DB::table('users')->where('user_id', $order['user_id'])->selectRaw('user_name, mobile_phone')->first();
			$order['order_user_info'] = array('user_name' => $order_user_info['user_name'], 'mobile_phone' => $order_user_info['mobile_phone']);
		} else {
			$order['order_user_info'] = array();
		}
		$total_goods_number = 0;
		if (!empty($goods_list)) {
			foreach ($goods_list as $k => $v) {
				$attr = array();
				if (!empty($v['goods_attr'])) {
					$goods_attr = explode("\n", $v['goods_attr']);
					$goods_attr = array_filter($goods_attr);
					foreach ($goods_attr as  $val) {
						$a = explode(':',$val);
						if (!empty($a[0]) && !empty($a[1])) {
							$attr[] = array('name'=>$a[0], 'value'=>$a[1]);
						}
					}
				}
			
				$goods_list[$k] = array(
						'rec_id'		=> $v['rec_id'],
						'goods_id'		=> $v['goods_id'],
				        'goods_sn'      => $v['goods_sn'],
						'name'			=> $v['goods_name'],
						'goods_attr_id'	=> $v['goods_attr_id'],
						'goods_attr'	=> $attr,
						'goods_number'	=> $v['goods_number'],
						'subtotal'		=> price_format($v['subtotal'], false),
						'formated_shop_price' => $v['goods_price'] > 0 ? price_format($v['goods_price'], false) : __('免费'),
						'is_commented'	=> $v['is_commented'],
						'comment_rank'  => empty($v['comment_rank']) ? 0 : intval($v['comment_rank']),
						'comment_content' => empty($v['comment_content']) ? '' : $v['comment_content'],
						'img' => array(
								'small'	=> !empty($v['goods_thumb']) ? RC_Upload::upload_url($v['goods_thumb']) : '',
								'thumb'	=> !empty($v['goods_img']) ? RC_Upload::upload_url($v['goods_img']) : '',
								'url' 	=> !empty($v['original_img']) ? RC_Upload::upload_url($v['original_img']) : '',
						)
				);
				$total_goods_number += $v['goods_number'];
			}	
		}
		
		$order['goods_list'] = $goods_list;
		
		$has_deposit = 0;
		$order_deposit = 0;
		/*团购订单保证金处理*/
		if ($order['extension_code'] == 'group_buy' && $order['extension_id'] > 0) {
			RC_Loader::load_app_func('admin_goods', 'goods');
			$group_buy = group_buy_info($order['extension_id']);
			if ($group_buy['deposit'] > 0) {
				if ($group_buy['is_finished'] == GBS_SUCCEED) {
					$has_deposit = 1;
				}
				$order_deposit = $total_goods_number*$group_buy['deposit'];
			}
		}
		$order['has_deposit'] 			= $has_deposit;
		$order['order_deposit']			= $order_deposit;
		$order['formated_order_deposit']= price_format($order_deposit, false);
		$order['formated_order_amount'] = price_format($order['order_amount'], false);

		$order_status_log = RC_Model::model('orders/order_status_log_model')->where(array('order_id' => $order_id))->order(array('log_id' => 'desc'))->select();
		$order['order_status_log'] = array();
		if (!empty($order_status_log)) {
			$labe_order_status = array(
				'place_order'	=> RC_Lang::get('orders::order.place_order'),//下单 
				'unpay'			=> RC_Lang::get('orders::order.unpay'), 
				'payed' 		=> RC_Lang::get('orders::order.payed'),
				'merchant_process' => RC_Lang::get('orders::order.merchant_process'),//等待接单
				'shipping' 		=> RC_Lang::get('orders::order.shipping'), 
				'shipped' 		=> RC_Lang::get('orders::order.shipped'),
				'express_user_pickup'	=> RC_Lang::get('orders::order.express_user_pickup'),
				'cancel'		=> RC_Lang::get('orders::order.order_cancel'),
				'confirm_receipt'	=> RC_Lang::get('orders::order.confirm_receipted'),
				'finished'		=> RC_Lang::get('orders::order.order_finished'),
				'pickup_success'=> RC_Lang::get('orders::order.order_pickup_success'),
			);
			
			foreach ($order_status_log as $val) {
				$order['order_status_log'][] = array(
					'status'		=> array_search($val['order_status'], $labe_order_status),
					'order_status'	=> $val['order_status'],
					'message'		=> $val['message'],
					'time'			=> RC_Time::local_date(ecjia::config('time_format'), $val['add_time']),
				);
			}
		}
		return array('data' => $order);
	}
}


/**
 * 订单状态处理
 *
 * @access public
 * @param int $order_id
 *            订单ID
 * @return array
 */
function get_order_status($order_status, $shipping_status, $pay_status, $is_cod) {
	$result = array(
		'status_code' 			=> '',
		'label_order_status'	=> ''	
	);
	
	if (in_array($order_status, array(OS_CONFIRMED, OS_SPLITED)) && in_array($shipping_status, array(SS_RECEIVED)) && in_array($pay_status, array(PS_PAYED, PS_PAYING)))
	{
		$label_order_status = RC_Lang::get('orders::order.cs.'.CS_FINISHED);
		$status_code = 'finished';
	}elseif (in_array($shipping_status, array(SS_SHIPPED)))
	{
		$label_order_status = RC_Lang::get('orders::order.label_await_confirm');
		$status_code = 'shipped';
	}elseif (in_array($order_status, array(OS_CONFIRMED, OS_SPLITED, OS_UNCONFIRMED)) && in_array($pay_status, array(PS_UNPAYED)) && (in_array($shipping_status, array(SS_SHIPPED, SS_RECEIVED)) || !$is_cod))
	{
		$label_order_status = RC_Lang::get('orders::order.label_await_pay');
		$status_code = 'await_pay';
	}elseif (in_array($order_status, array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART)) && in_array($shipping_status, array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING)) && (in_array($pay_status, array(PS_PAYED, PS_PAYING)) || $is_cod))
	{
		$label_order_status = RC_Lang::get('orders::order.label_await_ship');
		$status_code = 'await_ship';
	}elseif (in_array($order_status, array(OS_SPLITING_PART)) && in_array($shipping_status, array(SS_SHIPPED_PART)))
	{
		$label_order_status = RC_Lang::get('orders::order.label_shipped_part');
		$status_code = 'shipped_part';
	}elseif (in_array($order_status, array(OS_CANCELED))) {
		$label_order_status = RC_Lang::get('orders::order.label_canceled');
		$status_code = 'canceled';
	}elseif (in_array($order_status, array(OS_RETURNED))) {
		$label_order_status = RC_Lang::get('orders::order.label_refunded');
		$status_code = 'refunded';
	}

	$result['status_code'] = $status_code;
	$result['label_order_status'] = $label_order_status;
	
	return $result;
}

/**
 * 获取退款单状态
 * @param array
 */
function get_refund_status($refund_info) {
	$result = array();
	
	$status = $refund_info['status'];
	$refund_status = $refund_info['refund_status'];
	//1进行中2已退款3已取消
	if (in_array($status, array(Ecjia\App\Refund\RefundStatus::UNCHECK, Ecjia\App\Refund\RefundStatus::AGREE)) && $refund_status !=Ecjia\App\Refund\RefundStatus::TRANSFERED) {
		$refund_status_code = 'going';
		$label_refund_staus = '进行中';
	} elseif (in_array($status, array(Ecjia\App\Refund\RefundStatus::AGREE)) && in_array($refund_status, array(Ecjia\App\Refund\RefundStatus::TRANSFERED))) {
		$refund_status_code = 'refunded';
		$label_refund_staus = '已退款';
	} elseif (in_array($status, array(Ecjia\App\Refund\RefundStatus::CANCELED))) {
		$refund_status_code = 'canceled';
		$label_refund_staus = '已取消';
	}elseif ($status == Ecjia\App\Refund\RefundStatus::REFUSED) {
		$refund_status_code = 'refused';
		$label_refund_staus = '退款被拒';
	}
	$result['refund_status_code'] = $refund_status_code;
	$result['label_refund_status'] = $label_refund_staus;
	
	return $result;
}

// end