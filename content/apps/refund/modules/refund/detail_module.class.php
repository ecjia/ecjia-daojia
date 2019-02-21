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
 * 售后详情
 * @author zrl
 */
class refund_detail_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	
    	$user_id = $_SESSION['user_id'];
    	if ($user_id < 1 ) {
    	    return new ecjia_error(100, 'Invalid session');
    	}
    	
    	RC_Loader::load_app_class('order_refund', 'refund', false);
		$refund_sn = $this->requestData('refund_sn', '');
		if (empty($refund_sn)) {
			return new ecjia_error('invalid_parameter', __('参数无效', 'refund'));
		}
		
		$options = array('refund_sn' => $refund_sn);
		
		/* 退款详情 */
		$refund_order_info = order_refund::get_refundorder_detail($options);
		
		if (empty($refund_order_info)) {
			return new ecjia_error('not_exsist', __('售后申请信息不存在', 'refund'));
		}
		// 检查退款申请是否属于该用户
		if ($user_id > 0 && $user_id != $refund_order_info['user_id']) {
			return new ecjia_error('refund_order_error', __('未找到相应的售后申请单！', 'refund'));
		}
		
		/*商家电话*/
		$store_service_phone = RC_DB::table('merchants_config')->where('store_id', $refund_order_info['store_id'])->where('code', 'shop_kf_mobile')->pluck('value');
		//店铺收货人
		$store_info = RC_DB::table('store_franchisee')->where('store_id', $refund_order_info['store_id'])->select('merchants_name', 'responsible_person', 'city', 'district', 'street', 'address')->first();
		$store_recipients = RC_DB::table('staff_user')->where('store_id', $refund_order_info['store_id'])->where('parent_id', 0)->pluck('name');
		$store_name = $store_info['merchants_name'];
		
		//店铺地址
		$store_address = ecjia_region::getRegionName($store_info['city']).ecjia_region::getRegionName($store_info['district']).ecjia_region::getRegionName($store_info['street']).$store_info['address'];
		/*售后申请状态处理*/
		if ($refund_order_info['status'] == Ecjia\App\Refund\RefundStatus::ORDER_UNCHECK) {
			$status 		= 'uncheck';
			$label_status	= __('待审核', 'refund');
		} elseif ($refund_order_info['status'] == Ecjia\App\Refund\RefundStatus::ORDER_AGREE) {
			$status			= 'agree';
			$label_status	= __('同意', 'refund');
		} elseif ($refund_order_info['status'] == Ecjia\App\Refund\RefundStatus::ORDER_CANCELED) {
			$status			= 'canceled';
			$label_status	= __('已取消', 'refund');
		} elseif ($refund_order_info['status'] == Ecjia\App\Refund\RefundStatus::ORDER_REFUSED) {
			$status			= 'refused';
			$label_status	= __('拒绝', 'refund');
		}
		/*退款状态处理*/
		if ($refund_order_info['refund_status'] == Ecjia\App\Refund\RefundStatus::PAY_UNTRANSFER) {
			$refund_status 		= 'checked';
			$label_refund_status= __('已审核', 'refund');
		} elseif ($refund_order_info['refund_status'] == Ecjia\App\Refund\RefundStatus::PAY_TRANSFERED) {
			$refund_status 		= 'refunded';
			$label_refund_status= __('已退款', 'refund');
		} else {
			$refund_status 		= 'await_check';
			$label_refund_status= __('待审核', 'refund');
		}
		
		//用户地址
		$order_info = RC_DB::table('order_info')->where('order_id', $refund_order_info['order_id'])->select('consignee', 'mobile', 'city', 'district', 'street', 'address', 'order_status', 'pay_status', 'shipping_status')->first();
		$user_address = ecjia_region::getRegionName($order_info['city']).ecjia_region::getRegionName($order_info['district']).ecjia_region::getRegionName($order_info['street']).$order_info['address'];
		//应退总金额
		//配送费：已发货的不退，未发货的退
		if ($order_info['shipping_status'] > SS_UNSHIPPED) {
			$refund_total_amount  = $refund_order_info['money_paid'] + $refund_order_info['surplus'] - $refund_order_info['pay_fee']- $refund_order_info['shipping_fee'] - $refund_order_info['insure_fee'];
			$refund_shipping_fee  = 0;
		} else {
			$refund_total_amount  = $refund_order_info['money_paid'] + $refund_order_info['surplus'] - $refund_order_info['pay_fee'];
			$refund_shipping_fee  = $refund_order_info['shipping_fee'] > 0 ? price_format($refund_order_info['shipping_fee']) : 0 ;
		}
		//售后图片
		$return_images = order_refund::get_return_images($refund_order_info['refund_id']);
		//可用的返还方式
		if (!empty($refund_order_info['return_shipping_range'])) {
			$return_shipping_range = explode(',', $refund_order_info['return_shipping_range']);
			$home = array();
			if (in_array('home', $return_shipping_range)) {
				$dates = order_refund::get_pickup_dates();
				$times = order_refund::get_pickup_times();
				
				$home_data = array(
						'return_way_code' => 'home',
						'return_way_name' => __('上门取件', 'refund'),
						'pickup_address'  => $user_address,
						'contact_name'	  => $order_info['consignee'],
						'contact_phone'   => $order_info['mobile'],
						'expect_pickup_date' => array('dates' => $dates, 'times' => $times)
				);
				$home = $home_data;
			}
			$express = array();
			if (in_array('express', $return_shipping_range)) {
				$express_data = array(
						'return_way_code' 	=> 'express',
						'return_way_name' 	=> __('自选快递', 'refund'),
						'recipients'	  	=> $store_recipients,
						'contact_phone'	  	=> $store_service_phone,
						'recipient_address'	=> $store_address
				);
				$express = $express_data;
			}
			$shop = array();
			if (in_array('shop', $return_shipping_range)) {
				$shop_data = array(
						'return_way_code' 		=> 'shop',
						'return_way_name' 		=> __('到店退货', 'refund'),
						'store_name'	  		=> $store_name,
						'store_service_phone'	=> $store_service_phone,
						'store_address'			=> $store_address
				);
				$shop = $shop_data;
			}
			$return_way_list = array();
			$count = count($return_shipping_range);
			if ($count == 3) {
				$return_way_list = array($home, $express, $shop);
			} elseif ($count == 2) {
				if (in_array('home', $return_shipping_range) && in_array('express', $return_shipping_range)) {
					$return_way_list = array($home, $express);
				} elseif (in_array('home', $return_shipping_range) && in_array('shop', $return_shipping_range)) {
					$return_way_list = array($home, $shop);
				} elseif (in_array('express', $return_shipping_range) && in_array('shop', $return_shipping_range)) {
					$return_way_list = array($express, $shop);
				}
			} elseif ($count == 1) {
				if (in_array('home', $return_shipping_range)) {
					$return_way_list = array($home);
				} elseif (in_array('express', $return_shipping_range)) {
					$return_way_list = array($express);
				} elseif (in_array('shop', $return_shipping_range)) {
					$return_way_list = array($shop);
				}
			}
			
		} else {
			$return_way_list = array();
		}
		
		//用户所选的返还方式
		$selected_returnway_info = array();
		if (!empty($refund_order_info['return_shipping_type'])) {
			if (!empty($refund_order_info['return_shipping_value'])) {
				$return_shipping_value = unserialize($refund_order_info['return_shipping_value']);
				if ($refund_order_info['return_shipping_type'] == 'home') {
					$selected_returnway_info = array(
							'return_way_code' 	=> $return_shipping_value['return_way_code'],
							'return_way_name' 	=> $return_shipping_value['return_way_name'],
							'pickup_address'  	=> $return_shipping_value['pickup_address'],
							'expect_pickup_time'=> $return_shipping_value['expect_pickup_time'],
							'contact_name'  	=> $return_shipping_value['contact_name'],
							'contact_phone'  	=> $return_shipping_value['contact_phone'],
					);
				} elseif ($refund_order_info['return_shipping_type'] == 'express') {
						$selected_returnway_info = array(
								'return_way_code' 	=> $return_shipping_value['return_way_code'],
								'return_way_name' 	=> $return_shipping_value['return_way_name'],
								'recipient_address' => $return_shipping_value['recipient_address'],
								'recipients'		=> $return_shipping_value['recipients'],
								'contact_phone'  	=> $return_shipping_value['contact_phone'],
								'shipping_name'  	=> $return_shipping_value['shipping_name'],
								'shipping_sn'  		=> $return_shipping_value['shipping_sn'],
						);
				} elseif ($refund_order_info['return_shipping_type'] == 'shop') {
					$selected_returnway_info = array(
							'return_way_code' 	=> $return_shipping_value['return_way_code'],
							'return_way_name' 	=> $return_shipping_value['return_way_name'],
							'store_address'		=> $return_shipping_value['store_address'],
							'store_name'  		=> $return_shipping_value['store_name'],
							'contact_phone'  	=> $return_shipping_value['contact_phone'],
					);
				}
			}
		}
		 
		//退款进度日志
		$refund_logs = order_refund::get_refund_logs($refund_order_info['refund_id']);
		$logs = array();
		if (!empty($refund_logs)) {
			foreach ($refund_logs as $log) {
				$logs[] = array(
						'log_description' 		=> $log['message'],
						'formatted_action_time' => RC_Time::local_date(ecjia::config('time_format'), $log['add_time']),
						'label_status'			=> $log['status']
				);
			}
		}
		
		//售后申请退货商品
		$goods_list = array();
		$goods_data = order_refund::currorder_goods_list($refund_order_info['order_id']);
		if (!empty($goods_data)) {
			foreach ($goods_data as $res) {
				$goods_list[] = array(
						'goods_id' 				=> $res['goods_id'],
						'name'	   				=> $res['goods_name'],
						'goods_price'			=> $res['goods_price'],
						'formated_goods_price' 	=> price_format($res['goods_price']),
						'goods_attr'			=> !empty($res['goods_attr']) ? $res['goods_attr'] : '',
						'goods_number'			=> $res['goods_number'],
						'img' 			=> array(
								'small'	=> !empty($res['goods_thumb']) ? RC_Upload::upload_url($res['goods_thumb']) : '',
								'thumb'	=> !empty($res['goods_img']) ? RC_Upload::upload_url($res['goods_img']) : '',
								'url' 	=> !empty($res['original_img']) ? RC_Upload::upload_url($res['original_img']) : '',
						),
				);
			}
		}
		
		//被拒后返回原因，供重新申请使用
		$refused_reasons =array();
		if ($refund_order_info['status'] == Ecjia\App\Refund\RefundStatus::ORDER_REFUSED) {
			$refused_reasons = order_refund::get_one_group_reasons($refund_order_info['refund_reason']);
		}
		
		//配送费说明
// 		$shipping_fee_desc = array(
// 				'shipping_fee' 		=> price_format($refund_order_info['shipping_fee']),
// 				'insure_fee'	   	=> price_format($refund_order_info['insure_fee']),
// 				'total_fee'			=> price_format($refund_order_info['shipping_fee'] + $refund_order_info['insure_fee']),
// 				'desc'				=> '运费：原订单实际支付的运费金额'
// 		);
		
		$arr = array();
		$arr = array(
				'order_sn'					=> $refund_order_info['order_sn'],
				'refund_sn' 				=> $refund_sn,
				'store_service_phone' 		=> !empty($store_service_phone) ? $store_service_phone : '',
				'refund_type'				=> $refund_order_info['refund_type'],
				'label_refund_type'			=> $refund_order_info['refund_type'] == 'refund' ? __('仅退款', 'refund') : _('退货退款', 'refund'),
				'status'					=> $status,
				'label_status'				=> $label_status,
				'refund_status'				=> $refund_status,
				'label_refund_status'		=> $label_refund_status,
				'refund_goods_amount'		=> price_format($refund_order_info['goods_amount']),
				'refund_shipping_fee'		=> $refund_shipping_fee,
				'refund_inv_tax'			=> $refund_order_info['inv_tax'] > 0 ? price_format($refund_order_info['inv_tax']) : 0,
				'refund_integral'			=> intval($refund_order_info['integral']),
				'refund_total_amount'		=> price_format($refund_total_amount),
				'reason_id'					=> intval($refund_order_info['refund_reason']),
				'reason'					=> $refund_order_info['reason'],
				'refund_desc'				=> $refund_order_info['refund_content'],
				'user_address'				=> $user_address,
				//'shipping_fee_desc'			=> $shipping_fee_desc,
				'return_images'				=> $return_images,
				'return_way_list'			=> $return_way_list,
				'selected_returnway_info'	=> $selected_returnway_info,
				'refund_logs'				=> $logs,
				'goods_list'				=> $goods_list,
				'refused_reasons'			=> $refused_reasons,
				'refund_pay_fee'			=> $refund_order_info['pay_fee'],
				'pay_code'					=> $refund_order_info['pay_code'],
				'pay_name'					=> $refund_order_info['pay_name'],
				'store_id'					=> intval($refund_order_info['store_id']),
				'store_name'				=> $store_name
		);
		return  $arr;
	}
}

// end