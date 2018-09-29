<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 某个会员在当前店铺的订单列表
 * @author zrl
 *
 */
class admin_user_merchant_order_list_module extends api_admin implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {	
		$this->authadminSession();
		if ($_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		
		//$result = $this->admin_priv('order_view');
		//if (is_ecjia_error($result)) {
		//	return $result;
		//}
		
		$device = $this->device;
		$user_id		= $this->requestData('user_id', 0);
		$size = $this->requestData('pagination.count', 15);
		$page = $this->requestData('pagination.page', 1);
		
		if ($_SESSION['store_id'] > 0) {
			$store_id = $_SESSION['store_id'];
		}
		
		if (empty($user_id) || empty($store_id)) {
			return new ecjia_error('invalid_parameter', '参数错误');
		}
		
		
		
		$db_order_info 	= RC_DB::table('order_info');
		
		$record_count = $db_order_info->where('store_id', $store_id)->where('user_id', $user_id)->count('order_id');
		$page_row = new ecjia_page($record_count, $size, 6, '', $page);
		
		$user_order_list = RC_DB::table('order_info')->where('user_id', $user_id)->where('store_id', $store_id)->take($size)->skip($page->start_id-1)->get();
		$list = [];
		if (!empty($user_order_list)) {
			foreach ($user_order_list as $result) {
				$money_paid = $result['surplus'] + $result['money_paid'];
				$total_fee  = $result['goods_amount'] 
								+ $result['tax'] 
								+ $result['shipping_fee'] 
								+ $result['insure_fee'] 
								+ $result['pay_fee'] 
								+ $result['pack_fee'] 
								+ $result['card_fee'] 
								- $result['integral_money']
								- $result['bonus']
								- $result['discount']
								- $result['coupons'];
				$list[] = array(
						'order_id'				=> $result['order_id'],
						'order_sn'  			=> $result['order_sn'],
						'order_amount'			=> $result['order_amount'],
						'formated_order_amount'	=> price_format($result['order_amount'], false),
						'total_fee'				=> sprintf("%.2f" ,$total_fee),
						'formated_total_fee'	=> price_format($total_fee, false),
						'money_paid'			=> sprintf("%.2f" ,$money_paid),
						'formated_money_paid'	=> price_format($money_paid, false),
						'formated_order_time'	=> RC_Time::local_date(ecjia::config('time_format'), $result['add_time']),
						'label_orderpay_status' => $result['pay_status'] > 0 ? '已付款' : '待付款'
				);
			}
		}
		
		$pager = array(
				'total'	=> $page_row->total_records,
				'count' => $page_row->total_records,
				'more'	=> $page_row->total_pages <= $page ? 0 : 1,
		);
		return array('data' => $list, 'pager' => $pager);
	} 
}


// end