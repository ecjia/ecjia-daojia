<?php

namespace Ecjia\App\Orders;

use RC_DB;
use RC_Api;
use RC_Loader;
use RC_Logger;
use OrderStatusLog;
use order_ship;

/**
 * 收银台订单支付完成；订单默认发货处理
 */
class CashierPaidProcessOrder
{
	
	/**
	 * 收银台消费订单默认发货
	 * @param array $orderinfo
	 */
	public static function processOrderDefaultship($orderinfo)
	{
        RC_Loader::load_app_class('OrderStatusLog', 'orders', false);
        //配货
        self::_prepare($orderinfo);
        //分单（生成发货单）
        self::_split($orderinfo);
        //发货
        self::_ship($orderinfo);
        //确认收货
        self::_affirmReceived($orderinfo);
        //更新商品销量
        $res = RC_Api::api('goods', 'update_goods_sales', array('order_id' => $orderinfo['order_id']));
        if (is_ecjia_error($res)) {
            RC_Logger::getLogger('error')->info('收银台订单发货后更新商品销量失败【订单id|'.$orderinfo['order_id'].'】：'.$res->get_error_message());
        }
	}
	
	/**
	 * 订单配货
	 */
	private static function _prepare($order_info) {
		$result = RC_Api::api('orders', 'order_operate', array('order_id' => $order_info['order_id'], 'order_sn' => '', 'operation' => 'prepare', 'note' => array('action_note' => '收银台配货')));
		if (is_ecjia_error($result)) {
			RC_Logger::getLogger('error')->info('收银台订单配货【订单id|'.$order_info['order_id'].'】：'.$result->get_error_message());
		}
	}
	
	/**
	 * 订单分单（生成发货单）
	 */
    private static function _split($order_info)
	{
		$result = RC_Api::api('orders', 'order_operate', array('order_id' => $order_info['order_id'], 'order_sn' => '', 'operation' => 'split', 'note' => array('action_note' => '收银台生成发货单')));
		if (is_ecjia_error($result)) {
			RC_Logger::getLogger('error')->info('收银台订单分单【订单id|'.$order_info['order_id'].'】：'.$result->get_error_message());
		} else {
			/*订单状态日志记录*/
			OrderStatusLog::generate_delivery_orderInvoice(array('order_id' => $order_info['order_id'], 'order_sn' => $order_info['order_sn']));
		}
	}
	
	/**
	 * 订单发货
	 */
	private static function _ship($order_info)
	{
		RC_Loader::load_app_class('order_ship', 'orders', false);
	
		$delivery_id = RC_DB::table('delivery_order')->where('order_sn', $order_info['order_sn'])->pluck('delivery_id');
		$invoice_no  = '';
		$result = order_ship::delivery_ship($order_info['order_id'], $delivery_id, $invoice_no, '收银台发货');
		if (is_ecjia_error($result)) {
			RC_Logger::getLogger('error')->info('收银台订单发货【订单id|'.$order_info['order_id'].'】：'.$result->get_error_message());
		} else {
			/*订单状态日志记录*/
			OrderStatusLog::delivery_ship_finished(array('order_id' => $order_info['order_id'], 'order_sn' => $order_info['order_sn']));
		}
	}
	
	/**
	 * 订单确认收货
	 */
	private static function _affirmReceived($order_info)
	{
		$order_operate = RC_Loader::load_app_class('order_operate', 'orders');
		$order_info['pay_status'] = PS_PAYED;
		$order_operate->operate($order_info, 'receive', array('action_note' => '系统操作'));
		 
		/*订单状态日志记录*/
		OrderStatusLog::affirm_received(array('order_id' => $order_info['order_id']));
		 
		/* 记录log */
		order_action($order_info['order_sn'], OS_SPLITED, SS_RECEIVED, PS_PAYED, '收银台确认收货');
	}

	
}