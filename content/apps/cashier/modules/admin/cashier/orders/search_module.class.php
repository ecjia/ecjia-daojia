<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 收银台订单搜索（已支付的）
 * @author zrl
 * 
 */
class admin_cashier_orders_search_module  extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
        if ($_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
        $device		  = $this->device;
        $type 	= $this->requestData('type', '');
        $value 	= $this->requestData('value', '');
        $type_arr = array('order_sn', 'trade_no');
        
        $codes = RC_Loader::load_app_config('cashier_device_code', 'cashier');
      
        if (!in_array($device['code'], $codes)) {
        	return new ecjia_error('not_cashdesk_requst', __('非收银台请求！', 'cashier'));
        }
        
        if (empty($type) || empty($value) || !in_array($type, $type_arr)) {
        	return new ecjia_error('invalid_parameter', __('参数错误', 'cashier'));
        }
       
        //按订单号搜索
        if ($type == 'order_sn') {
        	$db = RC_DB::table('order_info');
        	$db->where('store_id', $_SESSION['store_id'])->where('pay_status', PS_PAYED)->where('is_delete', 0);
        	$field = 'order_id, order_sn, add_time, money_paid, (goods_amount + shipping_fee + insure_fee + pay_fee + pack_fee + card_fee + tax - integral_money - bonus - discount) as total_amount';
        	$result = $db->where('order_sn', $value)->select(RC_DB::raw($field))->first();
        } elseif ($type == 'trade_no') {
        //按交易流水号搜索
        	$db = RC_DB::table('order_info as oi')->leftJoin('payment_record as pr', RC_DB::raw('oi.order_sn'), '=', RC_DB::raw('pr.order_sn'));
        	$db->where(RC_DB::raw('oi.is_delete'), 0)->where(RC_DB::raw('oi.store_id'), $_SESSION['store_id'])->where(RC_DB::raw('pr.trade_type'), 'buy')->where(RC_DB::raw('oi.pay_status'), PS_PAYED);
        	$field = 'oi.order_id, oi.order_sn, oi.add_time, oi.money_paid, (oi.goods_amount + oi.shipping_fee + oi.insure_fee + oi.pay_fee + oi.pack_fee + oi.card_fee + oi.tax - oi.integral_money - oi.bonus - oi.discount) as total_amount';
        	$result = $db->where(RC_DB::raw('pr.trade_no'), $value)->orWhere(RC_DB::raw('pr.order_trade_no'), $value)->select(RC_DB::raw($field))->first();
        }
        
        $arr = [];
        if (!empty($result)) {
        	$arr = array(
        			'order_id' 						=> intval($result['order_id']),
        			'order_sn'						=> trim($result['order_sn']),
        			'formatted_add_time'			=> !empty($result['add_time']) ? RC_Time::local_date(ecjia::config('date_format'), $result['add_time']) : '',
        			'order_amount'					=> sprintf("%.2f", $result['total_amount']),
        			'formatted_order_amount'		=> price_format($result['total_amount'], false),
        			'money_paid_amount'				=> sprintf("%.2f", $result['money_paid']),
        			'formatted_money_paid_amount'	=> price_format($result['money_paid'], false)
        	);
        } else {
        	return new ecjia_error('order_info_error', __('订单信息不存在！', 'cashier'));
        }
		return $arr;
	}
}

// end