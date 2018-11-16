<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 收银台退款商家同意
 * @author zrl
 *
 */
class refund_refund_agree_api extends Component_Event_Api {
    /**
     * @param  array $options['refund_id']	退款申请id
     * @return array
     */
	public function call(&$options) {
		if (!is_array($options)) {
			return new ecjia_error('invalid_parameter', '调用api文件,refund_agree,参数无效');
		}
		return $this->agree_refund_apply($options);
	}
	
	
	/**
	 * 商家同意售后申请单
	 * @param   array $options	条件参数
	 * @return  bool   
	 */
	
	private function agree_refund_apply($options) {
		
		RC_Loader::load_app_class('order_refund', 'refund', false);
		RC_Loader::load_app_class('OrderStatusLog', 'orders', false);
		RC_Loader::load_app_class('RefundStatusLog', 'refund', false);
		
		$refund_id = $options['refund_id'];

		//订单id
		$refund_info = RC_DB::table('refund_order')->where('refund_id', $refund_id)->first();
		$order_id = $refund_info['order_id'];
		$status = Ecjia\App\Refund\RefundStatus::AGREE;
		$return_shipping_range = Ecjia\App\Refund\ReturnShippingRange::SHOP;
		
		//更新退款申请状态
		RC_DB::table('refund_order')->where('refund_id', $refund_id)->update(array('status' => $status, 'return_shipping_range' => $return_shipping_range));
		
		$action_note = '审核通过';
		
		//商家审核操作记录
		$data = array(
				'refund_id' 		=> $refund_id,
				'action_user_type'	=>  'merchant',
				'action_user_id'	=>  empty($options['staff_id']) ? 0 : $options['staff_id'],
				'action_user_name'	=>	empty($options['staff_name']) ? '' : $options['staff_name'],
				'status'		    =>  $status,
				'return_status'		=>  1,
				'action_note'		=>  $action_note,
				'log_time'			=>  RC_Time::gmtime(),
		);
		$action_id = RC_DB::table('refund_order_action')->insertGetId($data);
		
		//售后订单状态变动日志表
		RefundStatusLog::return_order_process(array('refund_id' => $refund_id, 'status' => $status));
		
		//普通订单状态变动日志表
		OrderStatusLog::return_order_process(array('order_id' => $order_id, 'status' => $status));
		
		//普通订单操作日志表
		$order_info = RC_DB::table('order_info')->where('order_id', $order_id)->select('shipping_status', 'pay_status')->first();
		order_refund::order_action($order_id, OS_RETURNED, $order_info['shipping_status'], $order_info['pay_status'], $action_note, '商家');
		
		$refund_sn = $refund_info['refund_sn'];
		
		//记录商家操作日志
		\Ecjia\App\Refund\Helper::assign_adminlog_content();
		RC_Api::api('merchant', 'admin_log', array('text'=> $options['staff_name'].'操作售后订单'.$refund_sn.'为同意'.'【来源掌柜】', 'action'=>'check', 'object'=>'refund_order'));
		 
		return true;
	}
}

// end