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

//收银台现金支付
class admin_payment_pay_cash_module extends api_admin implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {	
    	
    	$this->authadminSession();
    	
    	if ($_SESSION['staff_id'] <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}
		
    	$record_id 	= $this->requestData('record_id');
    	
    	if (empty($record_id)) {
    		return new ecjia_error( 'invalid_parameter', sprintf(__('请求接口%s参数无效', 'payment'), __CLASS__));
    	}
    	
    	$paymentRecordRepository = new Ecjia\App\Payment\Repositories\PaymentRecordRepository();
    	
    	$record_model = $paymentRecordRepository->find($record_id);
    	if (empty($record_model)) {
    		return new ecjia_error('payment_record_not_found', __('此笔交易记录未找到', 'payment'));
    	}
    	
    	$result = (new Ecjia\App\Payment\Pay\PayManager($record_model->order_sn))->pay();
    	if (is_ecjia_error($result)) {
    		return $result;
    	}
    	
    	//防止数据有更新
    	$record_model = $paymentRecordRepository->find($record_id);
    	
    	if ($record_model->trade_type == 'buy') {
    		/* 查询订单信息 */
    		$orderinfo = RC_Api::api('orders', 'order_info', array('order_sn' => $record_model->order_sn));
    	} elseif ($record_model->trade_type == 'quickpay') {
    		$orderinfo = RC_Api::api('quickpay', 'quickpay_order_info', array('order_sn' => $record_model->order_sn));
    	}
    	
    	if (empty($orderinfo)) {
    		return new ecjia_error('order_dose_not_exist', $record_model->order_sn . __('未找到该订单信息', 'payment'));
    	}
    	
    	//支付成功后更新数据
    	$this->updatePaidData($orderinfo, $record_model);
    	
    	//支付成功返回数据
    	$payment_data = $this->getPaymentData($record_model, $orderinfo);
    	
    	//打印数据
    	$print_data = $this->getPrintData($record_model, $orderinfo);
    	
    	return array('payment' => $payment_data, 'print_data' => $print_data);
    }
    
    
    /**
     * 支付成功后更新数据
     */
    private function updatePaidData($orderinfo, $record_model)
    {
    	/**
    	 * 1、收银台订单默认发货
    	 * 2、更新结算记录
    	 * 3、会员店铺消费过，记录为店铺会员
    	 */
    	
    	//收银台消费订单流程；默认订单自动发货，至完成状态
    	if ($orderinfo['extension_code'] == 'cashdesk' && $record_model->trade_type == 'buy') {
    		Ecjia\App\Orders\CashierPaidProcessOrder::processOrderDefaultship($orderinfo);
    		//更新结算记录
    		RC_Api::api('commission', 'add_bill_queue', array('order_type' => 'buy', 'order_id' => $orderinfo['order_id']));
    	}
    	
    	//会员店铺消费过，记录为店铺会员
    	if (!empty($orderinfo['user_id'])) {
    		if (!empty($orderinfo['store_id'])) {
    			RC_Loader::load_app_class('add_storeuser', 'user', false);
    			add_storeuser::add_store_user(array('user_id' => $orderinfo['user_id'], 'store_id' => $orderinfo['store_id']));
    		}
    	}
    }
    
    /**
     * 获取支付成功的数据
     */
    private function getPaymentData($record_model, $orderinfo)
    {
    	$payment_data = [];
    	if (!empty($orderinfo)) {
    		if ($record_model->trade_type == 'buy') {
    			$payment_data = array(
    					'order_id' 					=> $orderinfo['order_id'],
    					'money_paid'				=> $orderinfo['money_paid'] + $orderinfo['surplus'],
    					'formatted_money_paid'		=> ecjia_price_format($orderinfo['money_paid'] + $orderinfo['surplus'], false),
    					'order_amount'				=> $orderinfo['order_amount'],
    					'formatted_order_amount' 	=> ecjia_price_format($orderinfo['order_amount'], false),
    					'pay_code'					=> $record_model->pay_code,
    					'pay_name'					=> $record_model->pay_name,
    					'pay_status'				=> 'success',
    					'desc'						=> __('订单支付成功！', 'payment')
    			);
    		} elseif ($record_model->trade_type == 'quickpay') {
    			$payment_data = array(
    					'order_id' 					=> intval($orderinfo['order_id']),
    					'money_paid'				=> $orderinfo['order_amount'] + $orderinfo['surplus'],
    					'formatted_money_paid'		=> ecjia_price_format(($orderinfo['order_amount'] + $orderinfo['surplus']), false),
    					'order_amount'				=> 0.00,
    					'formatted_order_amount'	=> ecjia_price_format(0, false),
    					'pay_code'					=> $record_model->pay_code,
    					'pay_name'					=> $record_model->pay_name,
    					'pay_status'				=> 'success',
    					'desc'						=> __('订单支付成功！', 'payment')
    			);
    		} 
    	}
    	
    	return $payment_data;
    }
    
    
    /**
     * 获取打印数据
     */
    private function getPrintData($record_model, $order_info)
    {

    	$print_data = array();
    	if ($record_model->trade_type == 'buy') {
    		$print_data = $this->getBuyOrderPrintData($record_model, $order_info);
    	}elseif ($record_model->trade_type == 'quickpay'){
    		$print_data = $this->getQuickpayOrderPrintData($record_model, $order_info);
    	}
    	return $print_data;
    }
    
    /**
     * 获取消费订单打印数据
     */
    private function getBuyOrderPrintData($record_model, $order_info)
    {
    	$buy_print_data = array();
    	
    	if (!empty($order_info)) {
    		$order_goods 			= $this->getOrderGoods($order_info['order_id']);
    		$total_discount 		= $order_info['discount'] + $order_info['integral_money'] + $order_info['bonus'];
    		$money_paid 			= $order_info['money_paid'] + $order_info['surplus'];
    		 
    		//下单收银员
    		$cashier_name = RC_DB::table('cashier_record as cr')
    		->leftJoin('staff_user as su', RC_DB::raw('cr.staff_id'), '=', RC_DB::raw('su.user_id'))
    		->where(RC_DB::raw('cr.order_id'), $order_info['order_id'])
    		->where(RC_DB::raw('cr.order_type'), 'buy')
    		->whereIn('action', array('check_order', 'billing'))
    		->pluck('name');
    		 
    		$user_info = [];
    		//有没用户
    		if ($order_info['user_id'] > 0) {
    			$userinfo = $this->getUserInfo($order_info['user_id']);
    			if (!empty($userinfo)) {
    				$user_info = array(
    						'user_name' 			=> empty($userinfo['user_name']) ? '' : trim($userinfo['user_name']),
    						'mobile'				=> empty($userinfo['mobile_phone']) ? '' : trim($userinfo['mobile_phone']),
    						'user_points'			=> $userinfo['pay_points'],
    						'user_money'			=> $userinfo['user_money'],
    						'formatted_user_money'	=> $userinfo['user_money'] > 0 ? ecjia_price_format($userinfo['user_money'], false) : '',
    				);
    			}
    		}
    		 
    		$payment_account = $record_model->payer_login;
    		 
    		$buy_print_data = array(
    				'order_sn' 						=> $order_info['order_sn'],
    				'trade_no'						=> $record_model->trade_no ? $record_model->trade_no : '',
    				'order_trade_no'				=> $record_model->order_trade_no ? $record_model->order_trade_no : '',
    				'trade_type'					=> 'buy',
    				'pay_time'						=> empty($order_info['pay_time']) ? '' : RC_Time::local_date(ecjia::config('time_format'), $order_info['pay_time']),
    				'goods_list'					=> $order_goods['list'],
    				'total_goods_number' 			=> $order_goods['total_goods_number'],
    				'total_goods_amount'			=> $order_goods['taotal_goods_amount'],
    				'formatted_total_goods_amount'	=> ecjia_price_format($order_goods['taotal_goods_amount'], false),
    				'total_discount'				=> $total_discount,
    				'formatted_total_discount'		=> ecjia_price_format($total_discount, false),
    				'money_paid'					=> $money_paid,
    				'formatted_money_paid'			=> ecjia_price_format($money_paid, false),
    				'integral'						=> intval($order_info['integral']),
    				'integral_money'				=> $order_info['integral_money'],
    				'formatted_integral_money'		=> ecjia_price_format($order_info['integral_money'], false),
    				'pay_code'						=> $record_model->pay_code ? $record_model->pay_code : '',
    				'pay_name'						=> $record_model->pay_name ? $record_model->pay_name : '',
    				'payment_account'				=> empty($payment_account) ? '' : $payment_account,
    				'user_info'						=> $user_info,
    				'refund_sn'						=> '',
    				'refund_total_amount'			=> 0,
    				'formatted_refund_total_amount' => '',
    				'cashier_name'					=> empty($cashier_name) ? '' : $cashier_name,
    				'pay_fee'						=> $order_info['pay_fee'],
    				'formatted_pay_fee'				=> ecjia_price_format($order_info['pay_fee'], false),
    		);
    	}
    	
    	return $buy_print_data;
    }
    
    /**
     * 获取收款（买单）订单打印数据
     */
    private function getQuickpayOrderPrintData($record_model, $order_info)
    {
    	$quickpay_print_data = [];
    	
    	if ($order_info) {
    		$total_discount 		= $order_info['discount'] + $order_info['integral_money'] + $order_info['bonus'];
    		$money_paid 			= $order_info['order_amount'] + $order_info['surplus'];
    	
    		//下单收银员
    		$cashier_name = RC_DB::table('cashier_record as cr')
    		->leftJoin('staff_user as su', RC_DB::raw('cr.staff_id'), '=', RC_DB::raw('su.user_id'))
    		->where(RC_DB::raw('cr.order_id'), $order_info['order_id'])
    		->where(RC_DB::raw('cr.order_type'), 'quickpay')
    		->where('action', 'receipt')
    		->pluck('name');
    	
    		$user_info = [];
    		//有没用户
    		if ($order_info['user_id'] > 0) {
    			$userinfo = $this->getUserInfo($order_info['user_id']);
    			if (!empty($userinfo)) {
    				$user_info = array(
    						'user_name' 			=> empty($userinfo['user_name']) ? '' : trim($userinfo['user_name']),
    						'mobile'				=> empty($userinfo['mobile_phone']) ? '' : trim($userinfo['mobile_phone']),
    						'user_points'			=> $userinfo['pay_points'],
    						'user_money'			=> $userinfo['user_money'],
    						'formatted_user_money'	=> ecjia_price_format($userinfo['user_money'], false),
    				);
    			}
    		}
    	
    		$payment_account = $record_model->payer_login;
    	
    		$quickpay_print_data = array(
    				'order_sn' 						=> $order_info['order_sn'],
    				'trade_no'						=> $record_model->trade_no ? $record_model->trade_no : '',
    				'order_trade_no'				=> $record_model->order_trade_no ? $record_model->order_trade_no : '',
    				'trade_type'					=> 'quickpay',
    				'pay_time'						=> empty($order_info['pay_time']) ? '' : RC_Time::local_date(ecjia::config('time_format'), $order_info['pay_time']),
    				'goods_list'					=> [],
    				'total_goods_number' 			=> 0,
    				'total_goods_amount'			=> $order_info['goods_amount'],
    				'formatted_total_goods_amount'	=> ecjia_price_format($order_info['goods_amount'], false),
    				'total_discount'				=> $total_discount,
    				'formatted_total_discount'		=> ecjia_price_format($total_discount, false),
    				'money_paid'					=> $money_paid,
    				'formatted_money_paid'			=> ecjia_price_format($money_paid, false),
    				'integral'						=> intval($order_info['integral']),
    				'integral_money'				=> $order_info['integral_money'],
    				'formatted_integral_money'		=> ecjia_price_format($order_info['integral_money'], false),
    				'pay_code'						=> !empty($record_model->pay_code) ? $record_model->pay_code : '',
    				'pay_name'						=> !empty($record_model->pay_name) ? $record_model->pay_name : '',
    				'payment_account'				=> empty($payment_account) ? '' : $payment_account,
    				'user_info'						=> $user_info,
    				'refund_sn'						=> '',
    				'refund_total_amount'			=> 0,
    				'formatted_refund_total_amount' => '',
    				'cashier_name'					=> empty($cashier_name) ? '' : $cashier_name,
    				'pay_fee'						=> '',  //买单订单目前还未做支付手续费
    				'formatted_pay_fee'				=> '',
    		);
    	}
    	
    	return $quickpay_print_data;
    }
    
    /**
     * 订单商品
     */
    private function getOrderGoods($order_id)
    {
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
    					'formatted_subtotal'=> ecjia_price_format($row['subtotal'], false),
    			);
    		}
    	}
    
    	return array('list' => $list, 'total_goods_number' => $total_goods_number, 'taotal_goods_amount' => $taotal_goods_amount);
    }
    
    /**
     * 用户信息
     *
     * @param integer $user_id
     * @return array
     */
    private function getUserInfo ($user_id)
    {
    	$user_info = RC_Api::api('user', 'user_info', array('user_id' => $user_id));
    	return $user_info;
    }
}

// end