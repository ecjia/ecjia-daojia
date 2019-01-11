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
 * 收银台退款记录
 * @author zrl
 */
class admin_cashier_orders_refund_detail_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		$this->authadminSession();
        if ($_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
		$refund_sn	= trim($this->requestData('refund_sn', ''));
    	if (empty($refund_sn)) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('orders::order.invalid_parameter'));
		}
		
		RC_Loader::load_app_class('order_refund', 'refund', false);
		/* 退款详情 */
		$options = array('refund_sn' => $refund_sn);
		$refund_order_info = order_refund::get_refundorder_detail($options);
		if (empty($refund_order_info)) {
			return new ecjia_error('not_exsist', '售后申请信息不存在');
		}
		//售后申请是否属于当前店铺
		if ($refund_order_info['store_id'] != $_SESSION['store_id']) {
			return new ecjia_error('refund_order_error', '未找到相应的售后申请单！');
		}
		
		/*退款状态处理*/
		$cashier_name = '';
		if ($refund_order_info['refund_status'] == Ecjia\App\Refund\RefundStatus::PAY_UNTRANSFER) {
			$refund_status 		= 'checked';
			$label_refund_status= '已审核';
		} elseif ($refund_order_info['refund_status'] == Ecjia\App\Refund\RefundStatus::PAY_TRANSFERED) {
			$refund_status 		= 'refunded';
			$label_refund_status= '已退款';
			$cashier_name = RC_DB::table('refund_payrecord')->where('refund_id', $refund_order_info['refund_id'])->pluck('action_user_name');
		} else {
			$refund_status 		= 'await_check';
			$label_refund_status= '待审核';
		}
		
		$goods_item = order_refund::get_order_goods_list($refund_order_info['order_id']);
		
		$refund_payrecord 		= order_refund::get_refund_payrecord($refund_order_info['refund_id']);
		$refund_total_amount	= $refund_payrecord['back_money_total'];
		$total_discount = $refund_order_info['discount'] + $refund_order_info['bonus'] + $refund_order_info['integral_money'];
		
		//获取退款单小票打印数据
		$print_data = $this->getRefundPrintData($refund_order_info);
		
		$result = array(
				'refund_sn' 					=> trim($refund_order_info['refund_sn']),
				'refund_type'					=> $refund_order_info['refund_type'],
				'label_refund_type'				=> $refund_order_info['refund_type'] == 'return' ? '退货退款' : '仅退款',
				'refund_status'					=> $refund_status,
				'label_refund_status'			=> $label_refund_status,
				'cashier_name'					=> $cashier_name,
				'refund_total_amount'			=> sprintf("%.2f", $refund_total_amount),
				'formatted_refund_total_amount'	=> price_format($refund_total_amount, false),
				'money_paid_amount'				=> $refund_order_info['money_paid'] + $refund_order_info['surplus'],
				'formatted_money_paid_amount'	=> price_format($refund_order_info['money_paid'] + $refund_order_info['surplus'], false),
				'total_discount'				=> $total_discount > 0 ? sprintf("%.2f", $total_discount) : 0,
				'formatted_total_discount'		=> price_format($total_discount, false),
				'goods_number'					=> count($goods_item),
				'goods_list'					=> $goods_item,
				'pay_code'						=> !empty($refund_order_info['pay_code']) ? $refund_order_info['pay_code'] : '',
				'pay_name'						=> !empty($refund_order_info['pay_name']) ? $refund_order_info['pay_name'] : '',
				'print_data'					=> $print_data
		);
		
		return $result;
	}
	
	
	/**
	 * 获取退款单小票打印数据
	 */
	private function getRefundPrintData ($refund_order_info = array(), $refund_total_amount = 0)
	{

		$print_data = [];
		if (!empty($refund_order_info)) {
			$payment_record_info 	= $this->payment_record_info($refund_order_info['order_sn'], 'buy');
			
			$refund_payrecord_info 	= RC_DB::table('refund_payrecord')->where('refund_id', $refund_order_info['refund_id'])->where('store_id', $refund_order_info['store_id'])->where('order_id', $refund_order_info['order_id'])->first();
			
			$order_goods 			= $this->_getOrderGoods($refund_order_info['order_id']);
			$total_discount 		= $refund_order_info['discount'] + $refund_order_info['integral_money'] + $refund_order_info['bonus'];
			$money_paid 			= $refund_order_info['money_paid'] + $refund_order_info['surplus'];
			$refund_total_amount	= Ecjia\App\Refund\RefundOrder::get_back_total_money($refund_order_info);
		
			$order_info 			= RC_DB::table('order_info')->where('order_id', $refund_order_info['order_id'])->first();
			
			$user_info = [];
			//有没用户
			if ($refund_order_info['user_id'] > 0) {
				$userinfo = RC_DB::table('users')->where('user_id', $refund_order_info['user_id'])->first();
				if (!empty($userinfo)) {
					$user_info = array(
							'user_name' 			=> empty($userinfo['user_name']) ? '' : trim($userinfo['user_name']),
							'mobile'				=> empty($userinfo['mobile_phone']) ? '' : trim($userinfo['mobile_phone']),
							'user_points'			=> $userinfo['pay_points'],
							'user_money'			=> $userinfo['user_money'],
							'formatted_user_money'	=> $userinfo['user_money'] > 0 ? price_format($userinfo['user_money'], false) : '',
					);
				}
			}
		
			$print_data = array(
					'order_sn' 						=> $refund_order_info['order_sn'],
					'trade_no'						=> empty($payment_record_info['trade_no']) ? '' : trim($payment_record_info['trade_no']),
					'order_trade_no'				=> empty($payment_record_info['order_trade_no']) ? '' : trim($payment_record_info['order_trade_no']),
					'trade_type'					=> 'refund',
					'pay_time'						=> empty($order_info['pay_time']) ? '' : RC_Time::local_date(ecjia::config('time_format'), $order_info['pay_time']),
					'goods_list'					=> $order_goods['list'],
					'total_goods_number' 			=> $order_goods['total_goods_number'],
					'total_goods_amount'			=> $order_goods['taotal_goods_amount'],
					'formatted_total_goods_amount'	=> price_format($order_goods['taotal_goods_amount'], false),
					'total_discount'				=> $total_discount,
					'formatted_total_discount'		=> price_format($total_discount, false),
					'money_paid'					=> $money_paid,
					'formatted_money_paid'			=> price_format($money_paid, false),
					'integral'						=> intval($refund_order_info['integral']),
					'integral_money'				=> $refund_order_info['integral_money'],
					'formatted_integral_money'		=> price_format($refund_order_info['integral_money'], false),
					'pay_name'						=> !empty($order_info['pay_name']) ? $order_info['pay_name'] : '',
					'payment_account'				=> '',
					'user_info'						=> $user_info,
					'refund_sn'						=> $refund_order_info['refund_sn'],
					'refund_total_amount'			=> $refund_total_amount,
					'formatted_refund_total_amount' => price_format($refund_total_amount, false),
					'cashier_name'					=> empty($refund_payrecord_info['action_user_name']) ? '' : $refund_payrecord_info['action_user_name']
			);
		}
		 
		return $print_data;
	}
	
	/**
	 * 支付记录
	 */
	private function payment_record_info($order_sn = '', $trade_type = '') {
		$payment_revord_info = [];
		if (!empty($order_sn) && !empty($trade_type)) {
			$payment_revord_info = RC_DB::table('payment_record')->where('order_sn', $order_sn)->where('trade_type', $trade_type)->first();
		}
		return $payment_revord_info;
	}
	
	/**
	 * 订单商品
	 */
	private function _getOrderGoods ($order_id) {
		$field = 'goods_id, goods_name, goods_number, (goods_number*goods_price) as subtotal';
		$order_goods = RC_DB::table('order_goods')->where('order_id', $order_id)->select(RC_DB::raw($field))->get();
		$total_goods_number = 0;
		$taotal_goods_amount = 0;
		$list = [];
		if ($order_goods) {
			foreach ($order_goods as $row) {
				$total_goods_number += $row['goods_number'];
				$taotal_goods_amount += $row['subtotal'];
				$list[] = array(
						'goods_id' 			=> $row['goods_id'],
						'goods_name'		=> $row['goods_name'],
						'goods_number'		=> $row['goods_number'],
						'subtotal'			=> $row['subtotal'],
						'formatted_subtotal'=> price_format($row['subtotal'], false),
				);
			}
		}
		 
		return array('list' => $list, 'total_goods_number' => $total_goods_number, 'taotal_goods_amount' => $taotal_goods_amount);
	}
}
// end