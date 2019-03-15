<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/10/29
 * Time: 3:38 PM
 */

defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 订单支付
 * @author royalwang
 * 16-12-09 增加支付状态
 */
class admin_payment_scancode_module extends api_admin implements api_interface
{

    /**
     * @param int $record_id 支付流水记录
     * @param string $dynamic_code 二维码或条码内容
     *
     * @param \Royalcms\Component\Http\Request $request
     */
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
        if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }

        $record_id = $this->requestData('record_id');
        $dynamic_code = $this->requestData('dynamic_code');

        if (empty($dynamic_code)) {
            return new ecjia_error('payment_scancode_content_not_empty', __('扫码支付的二维码内容不能为空', 'payment'));
        }

        $paymentRecordRepository = new Ecjia\App\Payment\Repositories\PaymentRecordRepository();

        $record_model = $paymentRecordRepository->find($record_id);
        if (empty($record_model)) {
            return new ecjia_error('payment_record_not_found', __('此笔交易记录未找到', 'payment'));
        }

        $result = (new Ecjia\App\Payment\Pay\ScanManager($record_model->order_sn))->scan($dynamic_code);
        if (is_ecjia_error($result)) {
            return $result;
        }

        if ($record_model->trade_type == 'buy') {

            $orderinfo 	= $this->buyOrderProcessHandler($record_model);

        } elseif ($record_model->trade_type == 'quickpay') {

            $orderinfo = $this->quickpayOrderProcessHandler($record_model);

        } elseif ($record_model->trade_type == 'surplus') {

            $orderinfo = $this->surplusOrderProcessHandler($record_model);

        }

        if (empty($orderinfo)) {
            return new ecjia_error('order_dose_not_exist', $record_model->order_sn . __('未找到该订单信息', 'payment'));
        }
		
		//收银台订单流程；默认订单自动发货，至完成状态
        if ($orderinfo['extension_code'] == 'cashdesk') {
        	$ordership = $this->processOrdership($orderinfo);
		}
		
		//上面各项处理已经更新了数据表的数据，为防止脏数据，重新更新数据模型的数据
		$record_model = $paymentRecordRepository->find($record_id);
		//小票打印数据
		$print_data = $this->_GetPrintData($record_model, $orderinfo, $result);
		
        return $print_data;
    }

    /**
     * 会员充值订单处理
     *
     * @param $record_model
     */
    protected function surplusOrderProcessHandler($record_model)
    {
        /* 查询订单信息 */
        $orderinfo = RC_Api::api('finance', 'user_account_order_info', array('order_sn' => $record_model->order_sn));

        return $orderinfo;
    }

    /**
     * 买单订单支付处理
     *
     * @param $record_model
     */
    protected function quickpayOrderProcessHandler($record_model)
    {
        /* 查询订单信息 */
        $orderinfo = RC_Api::api('quickpay', 'quickpay_order_info', array('order_sn' => $record_model->order_sn));

        return $orderinfo;
    }

    /**
     * 普通订单支付处理
     *
     * @param $record_model
     * @return array
     */
    protected function buyOrderProcessHandler($record_model)
    {
        /* 查询订单信息 */
        $orderinfo = RC_Api::api('orders', 'order_info', array('order_sn' => $record_model->order_sn));

        return $orderinfo;
    }


	
    /**
     * 获取小票打印数据
     */
    private function _GetPrintData($record_model, $order_info, $result)
    {
    	$printdata = [];
    	if (!empty($record_model->trade_type) && !empty($order_info)) {
    		if ($record_model->trade_type == 'buy' ) {
    			$printdata = $this->get_buy_printdata($record_model, $order_info, $result);
    		} elseif ($record_model->trade_type == 'quickpay') {
    			$printdata = $this->get_quickpay_printdata($record_model, $order_info, $result);
    		} elseif ($record_model->trade_type == 'surplus') {
    			$printdata = $this->get_surplus_printdata($record_model, $order_info, $result);
    		}
    	}
    	return $printdata;
    }
    
    /**
     * 获取消费订单打印数据
     */
    private function get_buy_printdata($record_model, $order_info = array(), $result)
    {
    	$buy_print_data = array();
    	if (!empty($order_info)) {
    		$order_goods 			= $this->get_order_goods($order_info['order_id']);
    		$total_discount 		= $order_info['discount'] + $order_info['integral_money'] + $order_info['bonus'];
    		$money_paid 			= $order_info['money_paid'] + $order_info['surplus'];
    		
    		//下单收银员
    		$cashier_name = RC_DB::table('cashier_record as cr')
    							->leftJoin('staff_user as su', RC_DB::raw('cr.staff_id'), '=', RC_DB::raw('su.user_id'))
    							->where(RC_DB::raw('cr.order_id'), $order_info['order_id'])
    							->whereIn('action', array('check_order', 'billing'))
    							->pluck('name');
    		
    		$user_info = [];
    		//有没用户
    		if ($order_info['user_id'] > 0) {
    			$userinfo = $this->get_user_info($order_info['user_id']);
    			if (!empty($userinfo)) {
    				$user_info = array(
    						'user_name' 			=> empty($userinfo['user_name']) ? '' : trim($userinfo['user_name']),
    						'mobile'				=> empty($userinfo['mobile_phone']) ? '' : trim($userinfo['mobile_phone']),
    						'user_points'			=> $userinfo['pay_points'],
    						'user_money'			=> $userinfo['user_money'],
    						'formatted_user_money'	=> $userinfo['user_money'] > 0 ? price_format($userinfo['user_money'], false) : '',
    				);
    			}
    		}
    		
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
    				'pay_name'						=> !empty($order_info['pay_name']) ? $order_info['pay_name'] : '',
    				'payment_account'				=> $result['data']['payer_login'] ? $result['data']['payer_login'] : '',
    				'user_info'						=> $user_info,
    				'refund_sn'						=> '',
    				'refund_total_amount'			=> 0,
    				'formatted_refund_total_amount' => '',
    				'cashier_name'					=> empty($cashier_name) ? '' : $cashier_name,
    				'pay_fee'						=> $order_info['pay_fee'] > 0 ? $order_info['pay_fee'] : 0,
    				'formatted_pay_fee'				=> ecjia_price_format($order_info['pay_fee'], false)
    		);
    	}
    	
    	return $buy_print_data;
    }
    
    /**
     * 获取快捷收款买单订单打印数据
     */
    private function get_quickpay_printdata($record_model, $order_info = array(), $result) 
    {
    	$quickpay_print_data = [];
    	if ($order_info) {
    		$total_discount 		= $order_info['discount'] + $order_info['integral_money'] + $order_info['bonus'];
    		$money_paid 			= $order_info['order_amount'] + $order_info['surplus'];
    		
    		//下单收银员
    		$cashier_name = RC_DB::table('cashier_record as cr')
    						->leftJoin('staff_user as su', RC_DB::raw('cr.staff_id'), '=', RC_DB::raw('su.user_id'))
    						->where(RC_DB::raw('cr.order_id'), $order_info['order_id'])
    						->where('action', 'receipt')
    						->pluck('name');
    		
    		$user_info = [];
    		//有没用户
    		if ($order_info['user_id'] > 0) {
    			$userinfo = $this->get_user_info($order_info['user_id']);
    			if (!empty($userinfo)) {
    				$user_info = array(
    						'user_name' 			=> empty($userinfo['user_name']) ? '' : trim($userinfo['user_name']),
    						'mobile'				=> empty($userinfo['mobile_phone']) ? '' : trim($userinfo['mobile_phone']),
    						'user_points'			=> $userinfo['pay_points'],
    						'user_money'			=> $userinfo['user_money'],
    						'formatted_user_money'	=> price_format($userinfo['user_money'], false),
    				);
    			}
    		}
    		
    		$quickpay_print_data = array(
    			'order_sn' 						=> $order_info['order_sn'],
    			'trade_no'						=> $record_model->trade_no ? $record_model->trade_no : '',
    			'order_trade_no'				=> $record_model->order_trade_no ? $record_model->order_trade_no : '',
    			'trade_type'					=> 'quickpay',
    			'pay_time'						=> empty($order_info['pay_time']) ? '' : RC_Time::local_date(ecjia::config('time_format'), $order_info['pay_time']),
    			'goods_list'					=> [],
    			'total_goods_number' 			=> 0,
    			'total_goods_amount'			=> $order_info['goods_amount'],
    			'formatted_total_goods_amount'	=> price_format($order_info['goods_amount'], false),
    			'total_discount'				=> $total_discount,
    			'formatted_total_discount'		=> price_format($total_discount, false),
    			'money_paid'					=> $money_paid,
    			'formatted_money_paid'			=> price_format($money_paid, false),
    			'integral'						=> intval($order_info['integral']),
    			'integral_money'				=> $order_info['integral_money'],
    			'formatted_integral_money'		=> price_format($order_info['integral_money'], false),
    			'pay_name'						=> !empty($order_info['pay_name']) ? $order_info['pay_name'] : '',
    			'payment_account'				=> $result['data']['payer_login'] ? $result['data']['payer_login'] : '',
    			'user_info'						=> $user_info,
    			'refund_sn'						=> '',
    			'refund_total_amount'			=> 0,
    			'formatted_refund_total_amount' => '',
    			'cashier_name'					=> empty($cashier_name) ? '' : $cashier_name,
    			'pay_fee'						=> 0, //买单订单目前还未做支付手续费
    			'formatted_pay_fee'				=> '',
    		);
    	}
    	
    	return $quickpay_print_data;
    }
    
    /**
     * 获取充值订单打印数据
     */
    private function get_surplus_printdata($record_model, $order_info = array(), $result)
    {
    	$surplus_print_data = [];
    	if (!empty($order_info)) {
    		$pay_name				= RC_DB::table('payment')->where('pay_code', $order_info['payment'])->pluck('pay_name');
    		
    		$user_info = [];
    		//有没用户
    		if ($order_info['user_id'] > 0) {
    			$userinfo = $this->get_user_info($order_info['user_id']);
    			if (!empty($userinfo)) {
    				$user_info = array(
    						'user_name' 			=> empty($userinfo['user_name']) ? '' : trim($userinfo['user_name']),
    						'mobile'				=> empty($userinfo['mobile_phone']) ? '' : trim($userinfo['mobile_phone']),
    						'user_points'			=> $userinfo['pay_points'],
    						'user_money'			=> $userinfo['user_money'],
    						'formatted_user_money'	=> price_format($userinfo['user_money'], false),
    				);
    			}
    		}
    		
    		//充值操作收银员
    		$cashier_name = empty($order_info['admin_user']) ? '' : $order_info['admin_user'];
    		
    		$surplus_print_data = array(
    				'order_sn' 						=> trim($order_info['order_sn']),
    				'trade_no'						=> $record_model->trade_no ? $record_model->trade_no : '',
    				'order_trade_no'				=> $record_model->order_trade_no ? $record_model->order_trade_no : '',
    				'trade_type'					=> 'surplus',
    				'pay_time'						=> empty($order_info['paid_time']) ? '' : RC_Time::local_date(ecjia::config('time_format'), $order_info['paid_time']),
    				'goods_list'					=> [],
    				'total_goods_number' 			=> 0,
    				'total_goods_amount'			=> $order_info['amount'],
    				'formatted_total_goods_amount'	=> price_format($order_info['amount'], false),
    				'total_discount'				=> 0,
    				'formatted_total_discount'		=> '',
    				'money_paid'					=> $order_info['amount'],
    				'formatted_money_paid'			=> price_format($order_info['amount'], false),
    				'integral'						=> 0,
    				'integral_money'				=> '',
    				'formatted_integral_money'		=> '',
    				'pay_name'						=> empty($pay_name) ? '' : $pay_name,
    				'payment_account'				=> $result['data']['payer_login'] ? $result['data']['payer_login'] : '',
    				'user_info'						=> $user_info,
    				'refund_sn'						=> '',
    				'refund_total_amount'			=> 0,
    				'formatted_refund_total_amount' => '',
    				'cashier_name'					=> $cashier_name,
    				'pay_fee'						=> 0, //充值订单目前还未做支付手续费
    				'formatted_pay_fee'				=> '',
    		);
    	}
    	
    	return $surplus_print_data;
    }
    
    /**
     * 订单商品
     */
    private function get_order_goods ($order_id) {
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
    					'formatted_subtotal'=> price_format($row['subtotal'], false),
    			);
    		}
    	}
    	 
    	return array('list' => $list, 'total_goods_number' => $total_goods_number, 'taotal_goods_amount' => $taotal_goods_amount);
    }
    
    /**
     * 用户信息
     */
    private function get_user_info ($user_id = 0) {
    	$user_info = RC_DB::table('users')->where('user_id', $user_id)->first();
    	return $user_info;
    }
    
    /**
     * 收银台订单自动发货
     */
    private function processOrdership($order_info = array()) {
    	if (!empty($order_info)) {
    		RC_Loader::load_app_class('OrderStatusLog', 'orders', false);
    		//配货
    		$this->prepare($order_info);
    		//分单（生成发货单）
    		$this->split($order_info);
    		//发货
    		$this->ship($order_info);
    		//确认收货
    		$this->affirm_received($order_info);
    		//更新商品销量
    		$res = RC_Api::api('goods', 'update_goods_sales', array('order_id' => $order_info['order_id']));
    		if (is_ecjia_error($res)) {
    			RC_Logger::getLogger('error')->info(__('收银台订单发货后更新商品销量失败【订单id|', 'payment').$order_info['order_id'].'】：'.$res->get_error_message());
    		}
    	}
    }
    
    /**
     * 订单配货
     */
    private function prepare($order_info) {
    	$result = RC_Api::api('orders', 'order_operate', array('order_id' => $order_info['order_id'], 'order_sn' => '', 'operation' => 'prepare', 'note' => array('action_note' => __('收银台配货', 'payment'))));
    	if (is_ecjia_error($result)) {
    		RC_Logger::getLogger('error')->info(__('收银台订单配货【订单id|', 'payment').$order_info['order_id'].'】：'.$result->get_error_message());
    	}
    }
    
    /**
     * 订单分单（生成发货单）
     */
    private function split($order_info)
    {
    	$result = RC_Api::api('orders', 'order_operate', array('order_id' => $order_info['order_id'], 'order_sn' => '', 'operation' => 'split', 'note' => array('action_note' => __('收银台生成发货单', 'payment'))));
    	if (is_ecjia_error($result)) {
    		RC_Logger::getLogger('error')->info(__('收银台订单分单【订单id|', 'payment').$order_info['order_id'].'】：'.$result->get_error_message());
    	} else {
    		/*订单状态日志记录*/
    		OrderStatusLog::generate_delivery_orderInvoice(array('order_id' => $order_info['order_id'], 'order_sn' => $order_info['order_sn']));
    	}
    }
    
    /**
     * 订单发货
     */
    private function ship($order_info)
    {    	
    	RC_Loader::load_app_class('order_ship', 'orders', false);
    		
    	$delivery_id = RC_DB::table('delivery_order')->where('order_sn', $order_info['order_sn'])->pluck('delivery_id');
    	$invoice_no  = '';
    	$result = order_ship::delivery_ship($order_info['order_id'], $delivery_id, $invoice_no, __('收银台发货', 'payment'));
    	if (is_ecjia_error($result)) {
    		RC_Logger::getLogger('error')->info(__('收银台订单发货【订单id|', 'payment').$order_info['order_id'].'】：'.$result->get_error_message());
    	} else {
    		/*订单状态日志记录*/
    		OrderStatusLog::delivery_ship_finished(array('order_id' => $order_info['order_id'], 'order_sn' => $order_info['order_sn']));
    	}
    }
    
    /**
     * 订单确认收货
     */
    private function affirm_received($order_info)
    {	
		$order_operate = RC_Loader::load_app_class('order_operate', 'orders');
		$order_info['pay_status'] = PS_PAYED;
		$order_operate->operate($order_info, 'receive', array('action_note' => __('系统操作', 'payment')));
    	
    	/*订单状态日志记录*/
    	OrderStatusLog::affirm_received(array('order_id' => $order_info['order_id']));
    	
    	/* 记录log */
    	order_action($order_info['order_sn'], OS_SPLITED, SS_RECEIVED, PS_PAYED, __('收银台确认收货', 'payment'));
    }
    
}