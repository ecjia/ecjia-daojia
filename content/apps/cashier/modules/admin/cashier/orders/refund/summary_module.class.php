<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 收银台退款统计（退款已完成的）
 * @author zrl
 * 
 */
class admin_cashier_orders_refund_summary_module  extends api_admin implements api_interface {
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
        	$end_date	= $start_date;
        }
        
        if (empty($start_date) || empty($end_date)) {
        	return new ecjia_error('invalid_parameter', sprintf(__('请求接口%s参数无效', 'cashier'), __CLASS__));
        }
       
        $field = 'count(ro.refund_id) as count,
			SUM(ro.surplus + ro.money_paid) AS total_fee';
        
		$db = RC_DB::table('refund_order as ro')
				->leftJoin('cashier_record as cr', RC_DB::raw('cr.order_id'), '=', RC_DB::raw('ro.refund_id'));
		
		
		//统计条件，收银通不区分设备，收银台和POS区分设备
		$device_type  = Ecjia\App\Cashier\CashierDevice::get_device_type($device['code']);
		if ($device['code'] == Ecjia\App\Cashier\CashierDevice::CASHIERCODE) {
			$db->where(RC_DB::raw('cr.device_type'), $device_type);
		} else {
			$db->where(RC_DB::raw('cr.mobile_device_id'), $_SESSION['device_id']);
		}
		
		if (!empty($start_date) && !empty($end_date)) {
			$start_time = RC_Time::local_strtotime($start_date);
			$end_time   = RC_Time::local_strtotime($end_date) + 86399;
			$db->where(RC_DB::raw('ro.add_time'), '>=', $start_time)->where(RC_DB::raw('ro.add_time'), '<=', $end_time);
		}
		
		//当前店铺，当前设备上退款成功的
		$result  = $db->where(RC_DB::raw('ro.store_id'), $_SESSION['store_id'])
										 ->where(RC_DB::raw('cr.order_type'), 'refund')
										 ->where(RC_DB::raw('cr.action'), 'refund')
										 ->where(RC_DB::raw('ro.refund_time'), '!=', 0)
										 ->where(RC_DB::raw('ro.refund_status'), \Ecjia\App\Refund\Enums\RefundPayEnum::PAY_TRANSFERED)
										 ->where(RC_DB::raw('ro.status'), \Ecjia\App\Refund\Enums\RefundOrderEnum::ORDER_AGREE)
										 ->where(RC_DB::raw('ro.referer'), 'ecjia-cashdesk')
										 ->select(RC_DB::raw($field))->first();

		$arr = array(
					'total_count' => empty($result['count']) ? 0 : $result['count'],
					'total_amount'=> empty($result['total_fee']) ? '0.00' : $result['total_fee'],
					'formated_total_amount' => price_format($result['total_fee'])
				);
		
		return $arr;
	}
}

// end