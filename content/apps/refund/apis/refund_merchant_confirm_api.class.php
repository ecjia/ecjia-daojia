<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 商家确认收货
 * @author zrl
 *
 */
class refund_merchant_confirm_api extends Component_Event_Api {
    /**
     * @param  array $options['refund_id']	退款申请id
     * @return array
     */
	public function call(&$options) {
		if (!is_array($options)) {
			return new ecjia_error('invalid_parameter', __('调用api文件，returnway_shop，参数无效', 'refund'));
		}
		return $this->merchant_confirm($options);
	}
	
	
	/**
	 * 商家确认收货
	 * @param   array $options	条件参数
	 * @return  bool   
	 */
	
	private function merchant_confirm($options) {
		
		RC_Loader::load_app_class('OrderStatusLog', 'orders', false);
		RC_Loader::load_app_class('RefundStatusLog', 'refund', false);
		
		$refund_id 		= $options['refund_id'];
		$action_note 	= $options['action_note'];
		
		$refund_info = RC_DB::table('refund_order')->where('refund_id', $refund_id)->first();
		if (empty($refund_info)) {
			return new ecjia_error('not_exists_info', __('不存在的信息！', 'refund'));
		}
		
		$return_status = Ecjia\App\Refund\RefundStatus::SHIP_CONFIRM_RECV;
		$refund_status = Ecjia\App\Refund\RefundStatus::PAY_UNTRANSFER;
		
		$payment_record_id = RC_DB::table('payment_record')->where('order_sn', $refund_info['order_sn'])->pluck('id');
		
		//实际支付费用
		$order_money_paid = $refund_info['surplus'] + $refund_info['money_paid'];
		//退款总金额
		$shipping_status = RC_DB::table('order_info')->where('order_id', $refund_info['order_id'])->pluck('shipping_status');
		if ($shipping_status > SS_UNSHIPPED) {
			$back_money_total  = $refund_info['money_paid'] + $refund_info['surplus'] - $refund_info['pay_fee'] - $refund_info['shipping_fee'] - $refund_info['insure_fee'];
			$back_shipping_fee = $refund_info['shipping_fee'];
			$back_insure_fee   = $refund_info['insure_fee'];
		} else {
			$back_money_total  = $refund_info['money_paid'] + $refund_info['surplus'] - $refund_info['pay_fee'];
			$back_shipping_fee = 0;
			$back_insure_fee   = 0;
		}
		/*退现金或余额时，退款金额判断；用户端输入的金额；实际存打款表*/
		if ($options['refund_way'] == 'cash' || $options['refund_way'] == 'balance') {
			if ($options['refund_money'] > 0) {
				if ($options['refund_money'] < $back_money_total) {
					$back_money_total = $options['refund_money'];
				}
			}
		}
		
		/*判断当前退款申请,有没refund_payrecord数据（因为进行中的和未审核的可继续退款）*/
		$refund_payrecord_info = RC_DB::table('refund_payrecord')->where('refund_id', $refund_id)->where('store_id', $refund_info['store_id'])->where('order_id', $refund_info['order_id'])->first();
		
		if (empty($refund_payrecord_info)) {
			$data = array(
					'store_id'				=>	empty($options['store_id']) ? 0 : $options['store_id'],
					'order_id'				=>	$refund_info['order_id'],
					'order_sn'				=>	$refund_info['order_sn'],
					'refund_id'				=>	$refund_info['refund_id'],
					'refund_sn'				=>	$refund_info['refund_sn'],
					'refund_type'			=>	$refund_info['refund_type'],
					'goods_amount'			=>	$refund_info['goods_amount'],
					'back_pay_code'			=>	$refund_info['pay_code'],
					'back_pay_name'			=>	$refund_info['pay_name'],
					'back_pay_fee'			=>	$refund_info['pay_fee'],
					'back_shipping_fee'		=>	$refund_info['shipping_fee'],
					'back_insure_fee'		=>	$refund_info['insure_fee'],
					'back_pack_id'			=>	$refund_info['pack_id'],
					'back_pack_fee'			=>	$refund_info['pack_fee'],
					'back_card_id'			=>	$refund_info['card_id'],
					'back_card_fee'			=>	$refund_info['card_fee'],
					'back_bonus_id'			=>	$refund_info['bonus_id'],
					'back_bonus'			=>	$refund_info['bonus'],
					'back_surplus'			=>  $refund_info['surplus'],
					'back_integral'			=>  $refund_info['integral'],
					'back_integral_money'	=> 	$refund_info['integral_money'],
					'back_inv_tax'			=> 	$refund_info['inv_tax'],
					'order_money_paid'		=> 	$order_money_paid,
					'back_money_total'		=> 	$back_money_total,
					'payment_record_id'		=> 	empty($payment_record_id) ? 0 : $payment_record_id,
					'add_time'				=> 	RC_Time::gmtime()
			);
			
			$refund_payrecord_id = RC_DB::table('refund_payrecord')->insertGetId($data);
			
			RC_DB::table('refund_order')->where('refund_id', $refund_id)->update(array('return_status' => $return_status,'refund_status' => $refund_status));
			
			//商家审核操作记录
			$data = array(
					'refund_id' 		=> 	$refund_id,
					'action_user_type'	=>	'merchant',
					'action_user_id'	=>  empty($options['staff_id']) ? 0 : $options['staff_id'],
					'action_user_name'	=>	empty($options['staff_name']) ? '' : $options['staff_name'],
					'status'		    =>  1,
					'return_status'		=>  $return_status,
					'refund_status'		=>  $refund_status,
					'action_note'		=>  $action_note,
					'log_time'			=>  RC_Time::gmtime(),
			);
			RC_DB::table('refund_order_action')->insertGetId($data);
			//售后订单状态变动日志表
			RefundStatusLog::return_confirm_receive(array('refund_id' => $refund_id, 'status' => $return_status));
			
			//普通订单状态变动日志表
			$order_id = RC_DB::table('refund_order')->where('refund_id', $refund_id)->pluck('order_id');
			OrderStatusLog::return_confirm_receive(array('order_id' => $order_id, 'status' => $return_status));
			
			$refund_sn = $refund_info['refund_sn'];
			
			//记录商家操作日志
// 			\Ecjia\App\Refund\Helper::assign_adminlog_content();
// 			RC_Api::api('merchant', 'admin_log', array('text'=> $options['staff_name'].'操作售后订单'.$refund_sn.'为确认收货'.'【来源掌柜】', 'action'=>'check', 'object'=>'refund_order'));
			
			$refund_payrecord_info = RC_DB::table('refund_payrecord')->where('id', $refund_payrecord_id)->first();
			
			return $refund_payrecord_info;
		} else {
			return $refund_payrecord_info;
		}
		
	}
}

// end