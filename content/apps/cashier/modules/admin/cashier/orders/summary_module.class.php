<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 收银台订单统计
 * @author zrl
 * 
 */
class admin_cashier_orders_summary_module  extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
        if ($_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
        $device		  = $this->device;
        $start_date 	= $this->requestData('start_date', '');
        $end_date 		= $this->requestData('end_date', '');
        $time			= RC_Time::gmtime();
        $format_time	= RC_Time::local_date('Y-m-d', $time);
        
       	$codes = RC_Loader::load_app_config('cashier_device_code', 'cashier');
        if (!in_array($device['code'], $codes)) {
        	return new ecjia_error('not_cashdesk_requst', __('非收银台请求！', 'cashier'));
        }
        
        if (empty($start_date) && empty($end_date)) {
        	$start_date = $format_time;
        	$end_time	= RC_Time::local_strtotime($start_date) + 86399;
        	$end_date	= RC_Time::local_date('Y-m-d', $end_time);
        }
        
        if (empty($start_date) || empty($end_date)) {
        	return new ecjia_error('invalid_parameter', sprintf(__('请求接口%s参数无效', 'cashier'), __CLASS__));
        }
        
        $device_type  = Ecjia\App\Cashier\CashierDevice::get_device_type($device['code']);
        
        //开单，不包含已申请退款的
        $result_billing 	= $this->_billing($device, $device_type, $start_date, $end_date);
        
        //验单，不包含已申请退款的
        $result_checkorder 	= $this->_checkorder($device, $device_type, $start_date, $end_date);
        
        //收款，订单数据来源买单表quickpay_orders；且ordertype为cashdesk-receipt的
        $result_receipt		= $this->_receipt($device, $device_type, $start_date, $end_date);
       
		$stats_result = array(
				'billing'		=> array(
						'total_count' 	=> $result_billing['count'], 
						'total_amount' 	=> empty($result_billing['total_fee']) ? '0.00' : $result_billing['total_fee'], 
						'formated_total_amount' => price_format($result_billing['total_fee'], false)
				),
				'checkorder'	=> array(
						'total_count' 	=> $result_checkorder['count'], 
						'total_amount' 	=> empty($result_checkorder['total_fee']) ? '0.00' : $result_checkorder['total_fee'], 
						'formated_total_amount' => price_format($result_checkorder['total_fee'], false)
				),
				'receipt'		=> array(
						'total_count' => $result_receipt['count'],
						'total_amount'=> empty($result_receipt['total_fee']) ? '0.00' : $result_receipt['total_fee'],
						'formated_total_amount' => price_format($result_receipt['total_fee'])
				)
		);
		
		return $stats_result;
	}
	
	
	/**
	 * 开单统计（当前设备开单且已支付的）
	 */
	private function _billing($device, $device_type, $start_date, $end_date)
	{
		$field = 'count(oi.order_id) as count,
			SUM(oi.goods_amount + oi.tax + oi.shipping_fee + oi.insure_fee + oi.pay_fee + oi.pack_fee + oi.card_fee - oi.discount - oi.integral_money - oi.bonus) AS total_fee';
		
		$dbview_billing = RC_DB::table('cashier_record as cr')->leftJoin('order_info as oi', RC_DB::raw('cr.order_id'), '=', RC_DB::raw('oi.order_id'));
		
		$dbview_billing->where(RC_DB::raw('cr.store_id'), $_SESSION['store_id'])
			->where(RC_DB::raw('cr.action'), 'billing')
			->where(RC_DB::raw('cr.order_type'), 'buy')
			->where(RC_DB::raw('oi.order_status'), '!=', OS_RETURNED) //不包含已申请退款订单
			->where(RC_DB::raw('oi.pay_status'), PS_PAYED);
		
		//统计条件，收银通不区分设备，收银台和POS区分设备
		if ($device['code'] == Ecjia\App\Cashier\CashierDevice::CASHIERCODE) {
			$dbview_billing->where(RC_DB::raw('cr.device_type'), $device_type);
		} else {
			$dbview_billing->where(RC_DB::raw('cr.mobile_device_id'), $_SESSION['device_id']);
		}
		//日期筛选
		if (!empty($start_date) && !empty($end_date)) {
			$start_time = RC_Time::local_strtotime($start_date);
			$end_time   = RC_Time::local_strtotime($end_date) + 86399;
			$dbview_billing->where(RC_DB::raw('oi.add_time'), '>=', $start_time)->where(RC_DB::raw('oi.add_time'), '<=', $end_time);
		}
		
		$result_billing 	= $dbview_billing->select(RC_DB::raw($field))->first();
		
		return $result_billing;
	}
	
	
	/**
	 * 验单统计（当前设备验单且已支付的）
	 */
	private function _checkorder($device, $device_type, $start_date, $end_date)
	{
		$field = 'count(oi.order_id) as count,
			SUM(oi.goods_amount + oi.tax + oi.shipping_fee + oi.insure_fee + oi.pay_fee + oi.pack_fee + oi.card_fee - oi.discount - oi.integral_money - oi.bonus) AS total_fee';
	
		$dbview_checkorder = RC_DB::table('cashier_record as cr')->leftJoin('order_info as oi', RC_DB::raw('cr.order_id'), '=', RC_DB::raw('oi.order_id'));
	
		$dbview_checkorder->where(RC_DB::raw('cr.store_id'), $_SESSION['store_id'])
		->where(RC_DB::raw('cr.action'), 'check_order')
		->where(RC_DB::raw('cr.order_type'), 'buy')
		->where(RC_DB::raw('oi.order_status'), '!=', OS_RETURNED) //不包含已申请退款订单
		->where(RC_DB::raw('oi.pay_status'), PS_PAYED);
	
		//统计条件，收银通不区分设备，收银台和POS区分设备
		if ($device['code'] == Ecjia\App\Cashier\CashierDevice::CASHIERCODE) {
			$dbview_checkorder->where(RC_DB::raw('cr.device_type'), $device_type);
		} else {
			$dbview_checkorder->where(RC_DB::raw('cr.mobile_device_id'), $_SESSION['device_id']);
		}
		//日期筛选
		if (!empty($start_date) && !empty($end_date)) {
			$start_time = RC_Time::local_strtotime($start_date);
			$end_time   = RC_Time::local_strtotime($end_date) + 86399;
			$dbview_checkorder->where(RC_DB::raw('oi.add_time'), '>=', $start_time)->where(RC_DB::raw('oi.add_time'), '<=', $end_time);
		}
	
		$result_checkorder 	= $dbview_checkorder->select(RC_DB::raw($field))->first();
	
		return $result_checkorder;
	}
	
	/**
	 * 收款统计（当前设备买单且已支付的）
	 */
	private function _receipt($device, $device_type, $start_date, $end_date)
	{
		//收款，订单数据来源买单表quickpay_orders；且ordertype为cashdesk-receipt的
		$field_receipt = 'count(qo.order_id) as count,
			SUM(qo.goods_amount - qo.discount - qo.integral_money - qo.bonus) AS total_fee';
		
		$dbview_receipt 	= RC_DB::table('cashier_record as cr')->leftJoin('quickpay_orders as qo', RC_DB::raw('cr.order_id'), '=', RC_DB::raw('qo.order_id'));
		
		$dbview_receipt->where(RC_DB::raw('cr.store_id'), $_SESSION['store_id'])
			->where(RC_DB::raw('cr.action'), '=', 'receipt')
			->where(RC_DB::raw('qo.order_type'), '=', 'quickpay')
			->where(RC_DB::raw('qo.referer'), '=', 'ecjia-cashdesk')
			->where(RC_DB::raw('qo.pay_status'), \Ecjia\App\Quickpay\Enums\QuickpayPayEnum::PAID);
		
		//统计条件，收银通不区分设备，收银台和POS区分设备
		if ($device['code'] == Ecjia\App\Cashier\CashierDevice::CASHIERCODE) {
			$dbview_receipt->where(RC_DB::raw('cr.device_type'), $device_type);
		} else {
			$dbview_receipt->where(RC_DB::raw('cr.mobile_device_id'), $_SESSION['device_id']);
		}
		
		//日期筛选
		if (!empty($start_date) && !empty($end_date)) {
			$start_time = RC_Time::local_strtotime($start_date);
			$end_time   = RC_Time::local_strtotime($end_date) + 86399;
			$dbview_receipt->where(RC_DB::raw('qo.add_time'), '>=', $start_time)->where(RC_DB::raw('qo.add_time'), '<=', $end_time);
		}
		
		$result_receipt		= $dbview_receipt->select(RC_DB::raw($field_receipt))->first();
		
		return $result_receipt;
	}
}

// end