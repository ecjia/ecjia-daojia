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
 * 买单订单详情
 * @author zrl
 */
class admin_cashier_quickpay_order_detail_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    
    	$this->authadminSession();
        if ($_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
    	
    	RC_Loader::load_app_class('quickpay_activity', 'quickpay', false);
		$order_id = $this->requestData('order_id', 0);
		if (empty($order_id)) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('orders::order.invalid_parameter'));
		}
		
		$options = array('order_id' => $order_id, 'store_id' => $_SESSION['store_id']);
		
		/* 订单详情 */
		$order = RC_Api::api('quickpay', 'quickpay_order_info', $options);
		
		if(is_ecjia_error($order)) {
			return $order;
		}
		if (empty($order)) {
			return new ecjia_error('no_exsist', '订单信息不存在');
		}
		// 检查订单是否属于当前店铺
		if ($_SESSION['store_id'] != $order['store_id']) {
			return new ecjia_error('orders_error', '该订单不属于当前店铺订单！');
		}
		
		/*优惠活动信息*/
		$quickpay_activity_info = RC_DB::table('quickpay_activity')->where('id', $order['activity_id'])->first();
		$order['total_discount'] 		= $order['discount'] + $order['integral_money'] + $order['bonus'];
		$order['formated_total_discount'] = price_format($order['total_discount']);
		$order['formated_order_amount'] = price_format($order['order_amount']);
		
		/*订单状态处理*/
		$status = quickpay_activity::get_label_order_status($order['order_status'], $order['pay_status'], $order['verification_status']);
		$order['order_status_str'] = $status['order_status_str'];
		$order['label_order_status'] = $status['label_order_status'];
		
		
		
		$store_name = RC_DB::table('store_franchisee')->where('store_id', $order['store_id'])->pluck('merchants_name');
		$shop_logo = RC_DB::table('merchants_config')->where('store_id', $order['store_id'])->where('code', 'shop_logo')->pluck('value');
		
		$arr = array();
		$arr = array(
				'store_id' 					=> intval($order['store_id']),
				'store_name' 				=> $store_name,
				'store_logo'				=> !empty($shop_logo) ? RC_Upload::upload_url($shop_logo) : '',
				'order_id' 					=> intval($order['order_id']),
				'order_sn' 					=> trim($order['order_sn']),
				'order_status'				=> $order['order_status'],
				'order_status_str'			=> $order['order_status_str'],
				'label_order_status'		=> $order['label_order_status'],
				'total_discount'			=> $order['total_discount'],
				'formated_total_discount'	=> price_format($order['total_discount'], false),
				'order_amount'				=> $order['order_amount'] + $order['surplus'],
				'formated_order_amount'		=> price_format(($order['order_amount'] + $order['surplus']), false),
				'formated_add_time'			=> $order['formated_add_time'],
				'pay_code'					=> empty($order['pay_code']) ? '' : $order['pay_code'],
				'pay_name'					=> empty($order['pay_name']) ? '' : $order['pay_name'],
				'cashier_name'				=> $this->get_cashier_name($order)
		);
		
		$payment_record_info 	= $this->paymentRecordInfo($order['order_sn'], 'quickpay');
		
		$quickpay_print_data = array(
				'order_sn' 						=> $order['order_sn'],
				'trade_no'						=> empty($payment_record_info['trade_no']) ? '' : $payment_record_info['trade_no'],
				'order_trade_no'				=> empty($payment_record_info['order_trade_no']) ? '' : $payment_record_info['order_trade_no'],
				'trade_type'					=> 'quickpay',
				'pay_time'						=> empty($order['pay_time']) ? '' : RC_Time::local_date(ecjia::config('time_format'), $order['pay_time']),
				'goods_list'					=> [],
				'total_goods_number' 			=> 0,
				'total_goods_amount'			=> $order['goods_amount'],
				'formatted_total_goods_amount'	=> price_format($order['goods_amount'], false),
				'total_discount'				=> $order['total_discount'],
				'formatted_total_discount'		=> price_format($order['total_discount'], false),
				'money_paid'					=> $order['order_amount'] + $order['surplus'],
				'formatted_money_paid'			=> price_format(($order['order_amount'] + $order['surplus']), false),
				'integral'						=> intval($order['integral']),
				'integral_money'				=> $order['integral_money'],
				'formatted_integral_money'		=> price_format($order['integral_money'], false),
				'pay_name'						=> !empty($order['pay_name']) ? $order['pay_name'] : '',
				'payment_account'				=> '',
				'user_info'						=> [],
				'refund_sn'						=> '',
				'refund_total_amount'			=> 0,
				'formatted_refund_total_amount' => '',
				'cashier_name'					=> $this->get_cashier_name($order)
		);
		
		return  array('order_data' => $arr, 'print_data' => $quickpay_print_data);
	}
	
	/**
	 * 获取订单收款操作收银员
	 */
	private function get_cashier_name($order = array())
	{
		$cashier_name = '';
		if (!empty($order)) {
			$staff_id = RC_DB::table('cashier_record')
									->where('order_id', $order['order_id'])
									->where('store_id', $order['store_id'])
									->where('action', 'receipt')->pluck('staff_id');
			if ($staff_id) {
				$cashier_name = RC_DB::table('staff_user')->where('user_id', $staff_id)->pluck('name');
			}
		}	
		
		return $cashier_name;
	}
	
	/**
	 * 支付交易记录信息
	 * @param string $order_sn
	 * @param string $trade_type
	 * @return array
	 */
	private function paymentRecordInfo($order_sn = '', $trade_type = '')
	{
		$payment_revord_info = [];
		if (!empty($order_sn) && !empty($trade_type)) {
			$payment_revord_info = RC_DB::table('payment_record')->where('order_sn', $order_sn)->where('trade_type', $trade_type)->first();
		}
		return $payment_revord_info;
	}
	
}

// end