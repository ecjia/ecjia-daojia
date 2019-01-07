<?php

namespace Ecjia\App\Refund;

use RC_DB;
use RC_Time;
use ecjia;
use RC_Lang;
use RC_Api;
use RC_Loader;
use RC_Logger;
use OrderStatusLog;
use order_ship;
use RefundStatusLog;


/**
 * 订单退款完成；更新各项数据
 */
class HandleRefundedUpdateData
{    
	
	/**
	 * 退款完成，更新各项数据；最终返回打印数据
	 * @param array $refund_result['order_info'] 订单信息       必传
	 * @param array $refund_result['refund_payrecord_info'] 订单退款，打款信息   必传
	 * @param array $refund_result['refund_order_info'] 退款申请单信息    必传
	 * @param string $refund_result['back_type'] 退款类型
	 * @param string $refund_result['refund_way'] 退款方式   必传
	 * @param int $refund_result['is_cashdesk'] 是否是收银台申请退款
	 * @return array
	 */
	public static function updateRefundedData($refund_result) 
	{
		/**
		 * 退款成功后，后续操作
		 * 1、退积分 (RC_Api)
		 * 2、更新打款表 UpdateRefundPayrecord()
		 * 3、更新订单日志状态 & 操作记录表 UpdateOrderStatus()
		 * 4、更新售后订单状态日志 & 操作记录表 UpdateRefundOrderStatus()
		 * 5、更新结算记录 UpdateBillOrder()
		 * 6、更新商家会员 UpdateMerchantUser()
		 * 7、退款短信通知 SendRefundSmsNotice()
		 * 8、返回退款打印数据 RefundPrintData()
		 */
		
		RC_Loader::load_app_class('order_refund', 'refund', false);
		RC_Loader::load_app_class('OrderStatusLog', 'orders', false);
		RC_Loader::load_app_class('RefundStatusLog', 'refund', false);
		
		$order_info 			= $refund_result['order_info'];
		$refund_payrecord_info 	= $refund_result['refund_payrecord_info'];
		$refund_order_info		= $refund_result['refund_order_info'];
		
		//退款退积分
		$bak_integral = RC_Api::api('finance', 'refund_back_pay_points', array('refund_id' => $refund_order_info['refund_id']));
		if (is_ecjia_error($bak_integral)) {
			return $bak_integral;
		}
		
		//更新打款表，原路退回退还支付手续费
		self::UpdateRefundPayrecord($refund_result);
		
		//更新订单日志状态 & 操作记录表
		self::UpdateRefundOrderStatus($refund_result);
		
		//更新结算记录
		$update_bill = self::UpdateBillOrder($refund_order_info['refund_id']);
		if (is_ecjia_error($update_bill)) {
			return $update_bill;
		}
		
		//更新商家会员
		$update_merchant_user = self::UpdateMerchantUser($refund_order_info);
		if (is_ecjia_error($update_merchant_user)) {
			return $update_merchant_user;
		}
		
		//退款短信通知
		if ($order_info['user_id'] > 0) {
			self::SendRefundSmsNotice($order_info['user_id'], $refund_result);
		}
		
		//返回退款打印数据
		$refund_print_data = self::RefundPrintData($refund_order_info['refund_id'], $order_info, $refund_payrecord_info['id'], $refund_result['refund_way']);
		
		return $refund_print_data;
	}
	
	/**
	 * 更新打款表
	 * @param array $refund_result['order_info'] 订单信息       
	 * @param array $refund_result['refund_payrecord_info'] 订单退款，打款信息   必传
	 * @param array $refund_result['refund_order_info'] 退款申请单信息    
	 * @param string $refund_result['back_type'] 退款类型
	 * @param string $refund_result['refund_way'] 退款方式   必传
	 * @param int $refund_result['is_cashdesk'] 是否是收银台申请退款
	 */
	public static function UpdateRefundPayrecord($refund_result)
	{
		if ($refund_result['is_cashdesk']) {
			if ($refund_result['refund_way'] == 'cash') {
				$action_back_content = '收银台申请退款，现金退款成功';
			} elseif ($refund_result['refund_way'] == 'original')  {
				$action_back_content = '收银台申请退款，原路退回成功';
				$final_refund_amount = $refund_result['refund_payrecord_info']['back_money_total'] + $refund_result['refund_payrecord_info']['back_pay_fee'];
			} else {
				$action_back_content = '';
			}
		} else {
			if ($refund_result['refund_way'] == 'cash') {
				$action_back_content = '申请退款，现金退款成功';
			} elseif ($refund_result['refund_way'] == 'original')  {
				$action_back_content = '申请退款，原路退回成功';
				$final_refund_amount = $refund_result['refund_payrecord_info']['back_money_total'] + $refund_result['refund_payrecord_info']['back_pay_fee'];
			} else {
				$action_back_content = '';
			}
		}
		
		//更新打款表
		$data = array(
				'action_back_type' 		=> $refund_result['back_type'],
				'action_back_time' 		=> RC_Time::gmtime(),
				'action_back_content' 	=> $action_back_content,
				'action_user_type' 		=> 'merchant',
				'action_user_id' 		=> empty($refund_result['staff_id']) ? 0 : $refund_result['staff_id'],
				'action_user_name' 		=> empty($refund_result['staff_name']) ? 0 : $refund_result['staff_name'],
		);
		//原路退回，支付手续费退还
		if ($refund_result['refund_way'] == 'original') {
			$data['back_money_total'] = $final_refund_amount;
		}
		RC_DB::table('refund_payrecord')->where('id', $refund_result['refund_payrecord_info']['id'])->update($data);
	}
	
	
	/**
	 * 更新售后订单状态日志 & 操作记录表
	 */
	public static function UpdateRefundOrderStatus($refund_result)
	{
		//更新售后订单表
		$data = array(
				'refund_status' => Ecjia\App\Refund\RefundStatus::PAY_TRANSFERED,
				'refund_time' => RC_Time::gmtime(),
		);
		
		RC_DB::table('refund_order')->where('refund_id', $refund_result['refund_order_info']['refund_id'])->update($data);
		
		if ($refund_result['refund_way'] == 'original') {
			$back_money_total 	= $refund_result['refund_payrecord_info']['back_money_total'] + $refund_result['refund_payrecord_info']['back_pay_fee'];
		} else {
			$back_money_total 	= $refund_result['refund_payrecord_info']['back_money_total'];
		}
		
		$back_integral 		= $refund_result['refund_order_info']['integral'];
		
		//更新售后订单操作表
		$action_note = '退款金额已退回' . $back_money_total . '元，退回积分为：' . $back_integral;
		$data = array(
				'refund_id' 			=> $refund_result['refund_order_info']['refund_id'],
				'action_user_type' 		=> 'merchant',
				'action_user_id' 		=> empty($refund_result['staff_id']) ? 0 : $refund_result['staff_id'],
				'action_user_name' 		=> empty($refund_result['staff_name']) ? '' : $refund_result['staff_name'],
				'status' 				=> Ecjia\App\Refund\RefundStatus::ORDER_AGREE,
				'refund_status' 		=> Ecjia\App\Refund\RefundStatus::PAY_TRANSFERED,
				'return_status' 		=> Ecjia\App\Refund\RefundStatus::SHIP_CONFIRM_RECV,
				'action_note' 			=> $action_note,
				'log_time' 				=> RC_Time::gmtime(),
		);
		RC_DB::table('refund_order_action')->insertGetId($data);
		
		//售后订单状态变动日志表
		RefundStatusLog::refund_payrecord(array('refund_id' => $refund_result['refund_order_info']['refund_id'], 'back_money' => $back_money_total));
	} 
	
	
	/**
	 * 更新结算记录
	 */
	public static function UpdateBillOrder($refund_id = 0)
	{
		//更新结算记录
		$res = RC_Api::api('commission', 'add_bill_queue', array('order_type' => 'refund', 'order_id' => $refund_id));
		if (is_ecjia_error($res)) {
			return $res;
		}
	}
	
	/**
	 * 更新商家会员
	 */
	public static function UpdateMerchantUser($refund_order_info = array())
	{
		//更新商家会员
		if ($refund_order_info['user_id'] > 0 && $refund_order_info['store_id'] > 0) {
			$res = RC_Api::api('customer', 'store_user_buy', array('store_id' => $refund_order_info['store_id'], 'user_id' => $refund_order_info['user_id']));
			if (is_ecjia_error($res)) {
				return $res;
			}
		}
	}
	
	/**
	 * 退款短信通知
	 */
	public static function SendRefundSmsNotice($user_id, $refund_result)
	{
		//原路退款短信通知
		if ($refund_result['refund_way'] == 'original') {
			$user_info = RC_Api::api('user', 'user_info', array('user_id' => $user_id));
			if (!empty($user_info['mobile_phone'])) {
				$back_pay_name = $refund_result['refund_payrecord_info']['back_pay_name'];
				$options = array(
						'mobile' => $user_info['mobile_phone'],
						'event'	 => 'sms_refund_original_arrived',
						'value'  =>array(
								'user_name' 	=> $user_info['user_name'],
								'back_pay_name' => $back_pay_name,
						),
				);
				RC_Api::api('sms', 'send_event_sms', $options);
			}
		}
	}
	
	/**
	 * 退款打印数据
	 */
	public static function RefundPrintData($refund_id = 0, $order_info, $refund_payrecord_id = 0, $refund_way)
	{
		$print_data = [];
		if (!empty($refund_id)) {
			$refund_info 			= RC_DB::table('refund_order')->where('refund_id', $refund_id)->first();
			$payment_record_info	= self::paymentRecordInfo($refund_info['order_sn'], 'buy');
			$refund_payrecord_info  = RC_DB::table('refund_payrecord')->where('id', $refund_payrecord_id)->first();
		
			$order_goods 			= self::getOrderGoods($refund_info['order_id']);
			$total_discount 		= $order_info['discount'] + $order_info['integral_money'] + $order_info['bonus'];
			$money_paid 			= $refund_info['money_paid'] + $refund_info['surplus'];
			$refund_total_amount	= Ecjia\App\Refund\RefundOrder::get_back_total_money($refund_info, $refund_way);
			
		
			$user_info = [];
			//有没用户
			if ($refund_info['user_id'] > 0) {
				$userinfo = RC_DB::table('users')->where('user_id',$refund_info['user_id'])->first();
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
		
			$print_data = array(
					'order_sn' 						=> $refund_info['order_sn'],
					'trade_no'						=> empty($payment_record_info['trade_no']) ? '' : trim($payment_record_info['trade_no']),
					'trade_type'					=> 'refund',
					'pay_time'						=> empty($order_info['pay_time']) ? '' : RC_Time::local_date(ecjia::config('time_format'), $order_info['pay_time']),
					'goods_list'					=> $order_goods['list'],
					'total_goods_number' 			=> $order_goods['total_goods_number'],
					'total_goods_amount'			=> $order_goods['taotal_goods_amount'],
					'formatted_total_goods_amount'	=> $order_goods['taotal_goods_amount'] > 0 ? ecjia_price_format($order_goods['taotal_goods_amount'], false) : '',
					'total_discount'				=> $total_discount,
					'formatted_total_discount'		=> $total_discount > 0 ? ecjia_price_format($total_discount, false) : '',
					'money_paid'					=> $money_paid,
					'formatted_money_paid'			=> $money_paid > 0 ? ecjia_price_format($money_paid, false) : '',
					'integral'						=> intval($refund_info['integral']),
					'integral_money'				=> $refund_info['integral_money'],
					'formatted_integral_money'		=> $refund_info['integral_money'] > 0 ? ecjia_price_format($refund_info['integral_money'], false) : '',
					'pay_name'						=> !empty($order_info['pay_name']) ? $order_info['pay_name'] : '',
					'payment_account'				=> empty($payment_record_info['payer_login']) ? '' : $payment_record_info['payer_login'],
					'user_info'						=> $user_info,
					'refund_sn'						=> $refund_info['refund_sn'],
					'refund_total_amount'			=> $refund_total_amount,
					'formatted_refund_total_amount' => $refund_total_amount > 0 ? ecjia_price_format($refund_total_amount, false) : '',
					'cashier_name'					=> empty($refund_payrecord_info['action_user_name']) ? '' : $refund_payrecord_info['action_user_name']
			);
		}
		 
		return $print_data;
	}
	
	/**
	 * 支付交易记录
	 */
	public static function paymentRecordInfo($order_sn = '', $trade_type = '') {
		$payment_record_info = [];
		if (!empty($order_sn) && !empty($trade_type)) {
			$payment_record_info = RC_DB::table('payment_record')->where('order_sn', $order_sn)->where('trade_type', $trade_type)->first();
		}
		return $payment_record_info;
	}
	
	/**
	 * 打款信息
	 */
	public static function refundPayrecord($refund_payrecord_id = 0)
	{
		$info = [];
		if (!empty($refund_payrecord_id)) {
			$info = RC_DB::table('refund_payrecord')->where('id', $refund_payrecord_id)->first();
		}
		return $info;
	}
	
	/**
	 * 订单商品
	 */
	public static function getOrderGoods($order_id)
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
	 * 退款金额
	 * @param array $refund_info
	 */
	public static function getBackTotalMoney($refund_info){
		//退款总金额
		$back_money_total = '0.00';
		$shipping_status = RC_DB::table('order_info')->where('order_id', $refund_info['order_id'])->pluck('shipping_status');
		if ($shipping_status > SS_UNSHIPPED) {
			$back_money_total  = $refund_info['money_paid'] + $refund_info['surplus'] - $refund_info['pay_fee'] - $refund_info['shipping_fee'] - $refund_info['insure_fee'];
		} else {
			$back_money_total  = $refund_info['money_paid'] + $refund_info['surplus'] - $refund_info['pay_fee'];
		}
		return $back_money_total;
	}
}