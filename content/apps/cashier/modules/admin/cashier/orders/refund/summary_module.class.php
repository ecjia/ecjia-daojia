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
        $format_time	= RC_Time::local_date(ecjia::config('date_format'), $time);
        
        $codes = RC_Loader::load_app_config('cashier_device_code', 'cashier');
      
        if (!in_array($device['code'], $codes)) {
        	return new ecjia_error('not_cashdesk_requst', __('非收银台请求！', 'cashier'));
        }
        
        if (empty($start_date) && empty($end_date)) {
        	$start_date = $format_time;
        	$end_time	= RC_Time::local_strtotime($start_date) + 86399;
        	$end_date	= RC_Time::local_date(ecjia::config('date_format'), $end_time);
        }
        
        if (empty($start_date) || empty($end_date)) {
        	return new ecjia_error('invalid_parameter', __('参数错误', 'cashier'));
        }
       
        $field = 'count(refund_id) as count,
			SUM(surplus + money_paid) AS total_fee';
        
		$db = RC_DB::table('refund_order');
		
		
		if (!empty($start_date) && !empty($end_date)) {
			$start_time = RC_Time::local_strtotime($start_date);
			$end_time   = RC_Time::local_strtotime($end_date) + 86399;
			$db->where('refund_time', '>=', $start_time)->where('refund_time', '<=', $end_time);
		}
		
		//退款成功的
		$result  = $db->where('store_id', $_SESSION['store_id'])
										 ->where('refund_time', '!=', '0')
										 ->where('refund_status', \Ecjia\App\Refund\Enums\RefundPayEnum::PAY_TRANSFERED)
										 ->where('status', \Ecjia\App\Refund\Enums\RefundOrderEnum::ORDER_AGREE)
										 ->where('referer', 'ecjia-cashdesk')
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