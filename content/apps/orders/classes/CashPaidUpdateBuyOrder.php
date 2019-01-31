<?php

namespace Ecjia\App\Orders;

use RC_DB;
use RC_Api;
use RC_Loader;
use RC_Logger;
use RC_Time;
use Ecjia\App\Payment\PaymentPlugin;

/**
 * 订单现金支付成功，普通订单相关数据更新
 */
class CashPaidUpdateBuyOrder
{
	
	/**
	 * 设置已付款
	 * @param int $order_id
	 */
	public static function cash_order_paid($order_id, $note ='')
	{
        $order = RC_Api::api('orders', 'order_info', array('order_id' => $order_id));
        if (is_ecjia_error($order)) {
        	return $order;
        }
        if (empty($order)) {
        	return new \ecjia_error('order_not_exist', '订单信息不存在！');
        }
        self::_update_order_paid($order, $note);
	}
	
	/**
	 * 更新订单为已付款
	 */
	private static function _update_order_paid($order, $note) {
		/* 标记订单为已确认、已付款，更新付款时间和已支付金额，如果是货到付款，同时修改订单为“收货确认” */
		if ($order['order_status'] != OS_CONFIRMED) {
			$arr['order_status']	= OS_CONFIRMED;
			$arr['confirm_time']	= RC_Time::gmtime();
		}
		$arr['pay_status']		= PS_PAYED;
		$arr['pay_time']		= RC_Time::gmtime();
		$arr['money_paid']		= $order['money_paid'] + $order['order_amount'];
		$arr['order_amount']	= 0;
		
		$payment_method	= new PaymentPlugin();
		$payment = $payment_method->getPluginDataById($order['pay_id']);
		
		if ($payment['is_cod']) {
			$arr['shipping_status']		= SS_RECEIVED;
			$order['shipping_status']	= SS_RECEIVED;
		}
		RC_DB::table('order_info')->where('order_id', $order['order_id'])->update($arr);
		
		self::_order_action($order['order_sn'], OS_CONFIRMED, $order['shipping_status'], PS_PAYED, $note);
	}
	
	
	/**
	 * 记录订单操作记录
	 *
	 * @access public
	 * @param string $order_sn
	 *        	订单编号
	 * @param integer $order_status
	 *        	订单状态
	 * @param integer $shipping_status
	 *        	配送状态
	 * @param integer $pay_status
	 *        	付款状态
	 * @param string $note
	 *        	备注
	 * @param string $username
	 *        	用户名，用户自己的操作则为 buyer
	 * @return void
	 */
	private static function _order_action($order_sn, $order_status, $shipping_status, $pay_status, $note = '', $username = null, $place = 0) {
		if (is_null ( $username )) {
			$username = empty($_SESSION ['admin_name']) ? '系统' : $_SESSION ['admin_name'];
		}
	
		$row = RC_DB::table('order_info')->where('order_sn', $order_sn)->first();
	
		$data = array (
				'order_id'           => $row ['order_id'],
				'action_user'        => $username,
				'order_status'       => $order_status,
				'shipping_status'    => $shipping_status,
				'pay_status'         => $pay_status,
				'action_place'       => $place,
				'action_note'        => $note,
				'log_time'           => RC_Time::gmtime()
		);
		RC_DB::table('order_action')->insert($data);
	}
}