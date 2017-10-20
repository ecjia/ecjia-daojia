<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * //收银台收银统计
 * @author will.chen
 *
 */
class payment_module extends api_admin implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {	
		$this->authadminSession();
		if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		
		$device		  = $this->device;
		if ( $device['code'] !='8001') {
			$result = $this->admin_priv('order_stats');
			if (is_ecjia_error($result)) {
				return $result;
			}
		}
		
		//传入参数
		$start_date	= $this->requestData('start_date');
		$end_date	= $this->requestData('end_date');
// 		$start_date = $end_date = '2016-05-23';
		if (empty($start_date) || empty($end_date)) {
			return new ecjia_error('invalid_parameter', '参数错误');
		}
		$cache_key = 'cashdesk_stats_'.md5($start_date.$end_date);
		$data = RC_Cache::app_cache_get($cache_key, 'stats');
		$data = null;
		if (empty($data)) {
			$device =  $this->device;
			$response = payment_stats($start_date, $end_date, $device);
			RC_Cache::app_cache_set($cache_key, $response, 'stats', 60);
		} else {
			$response = $data;
		}
		return $response;
	}
	 
}
function payment_stats($start_date, $end_date, $device)
{
	$type = $start_date == $end_date ? 'time' : 'day';
	$start_date = RC_Time::local_strtotime($start_date. ' 00:00:00');
	$end_date	= RC_Time::local_strtotime($end_date. ' 23:59:59');

	/* 获取请求当前数据的device信息*/
	if (!is_array($device) || !isset($device['code']) || $device['code'] != '8001') {
		return new ecjia_error('caskdesk_error', '非收银台请求！');
	}
	
	/* 获取收银台的固有支付方式*/
	$cashdesk_payment	= array('pay_cash', 'pay_koolyun_alipay', 'pay_koolyun_unionpay', 'pay_koolyun_wxpay', 'pay_balance');
	$payment_where		= array('enabled' => 1, 'pay_code' => $cashdesk_payment);
	$pay_id_group		= RC_Model::model('payment/payment_model')->where($payment_where)->get_field('pay_code, pay_id, pay_name', true);
	
	/* 定义默认数据*/
	$data = array();
	
	$field = 'count(*) as count, SUM((goods_amount - discount + tax + shipping_fee + insure_fee + pay_fee + pack_fee + card_fee)) AS total_fee';
	foreach ($cashdesk_payment as $val) {
		if (isset($pay_id_group[$val])) {
// 			$order_stats = RC_Model::model('orders/cashier_record_viewmodel')->join(array('order_info', 'staff_user'))
// 														->field($field)
// 														->where(
// 															array(
// 																'oi.pay_status' => 2,
// 																'oi.pay_time >="' .$start_date. '" and oi.pay_time<="' .$end_date. '"',
// 																'mobile_device_id'		=> $_SESSION['device_id'],
// 																'staff_id'	=> $_SESSION['staff_id'],
// 																'pay_id'		=> $pay_id_group[$val]['pay_id']
// 															)
// 														)
// 		    ->find();
// 							
            $order_stats = RC_DB::table('cashier_record as cr')
    			->leftJoin('order_info as oi', RC_DB::raw('cr.order_id'), '=', RC_DB::raw('oi.order_id'))
    			->selectRaw($field)
    			->where(RC_DB::raw('oi.pay_status'), 2)
    			->whereBetween(RC_DB::raw('oi.pay_time'), array($start_date, $end_date))
    			->where(RC_DB::raw('cr.staff_id'), $_SESSION['staff_id'])
    			->where(RC_DB::raw('cr.mobile_device_id'), $_SESSION['device_id'])
    			->where('pay_id', $pay_id_group[$val]['pay_id'])
    			->first();
			$data[] = array(
					'pay_code'		=> $val,
					'pay_name'		=> $pay_id_group[$val]['pay_name'],
					'order_count'	=> $order_stats['count'],
					'order_amount'	=> empty($order_stats['total_fee']) ? '0.00' : $order_stats['total_fee'],
					'formatted_order_amount' => empty($order_stats['total_fee']) ? '0.00' : price_format($order_stats['total_fee']),
			); 												
		}
	}
	
	return $data;
}
