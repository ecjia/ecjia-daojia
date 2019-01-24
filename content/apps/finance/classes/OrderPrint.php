<?php

namespace Ecjia\App\Finance;

use RC_Api;
use RC_DB;
use RC_Time;
use RC_Lang;
use ecjia_region;
use ecjia_error;

class OrderPrint
{
    
    protected $order_id;
    
    protected $store_id;
    
    
    public function __construct($order_id, $store_id)
    {
        $this->order_id = $order_id;
        $this->store_id = $store_id;
    }
    
    
    /**
     * 打印
     * @param boolean $auto_print 是否自动打印
     * @return ecjia_error|boolean
     */
    public function doPrint($auto_print = false)
    {
        //1.获取订单信息
        $order    = $this->getOrderInfo($this->order_id);
        if (is_ecjia_error($order)) {
            return $order;
        }
        
        //2.获取店铺信息
        $store    = RC_Api::api('store', 'store_info', array('store_id' => $this->store_id));
        if (is_ecjia_error($store)) {
            return $store;
        }
        
        //3.获取支付流水信息
        $payment_record = $this->getPayRecord($order);
        
        
        //4.定义小票打印类型
        $type = 'print_surplus_orders';
        
        return $this->printSurplusOrders($type, $order, $store, $payment_record, $auto_print);
    }
    
    /**
     * 打印充值订单小票
     */
    public function printSurplusOrders($type, $order, $store, $payment_record, $auto_print = false)
    { 
        $address = '';
        if (!empty($store['province'])) {
            $address .= ecjia_region::getRegionName($store['province']);
        }
        if (!empty($store['city'])) {
            $address .= ecjia_region::getRegionName($store['city']);
        }
        if (!empty($store['district'])) {
            $address .= ecjia_region::getRegionName($store['district']);
        }
        if (!empty($store['street'])) {
            $address .= ecjia_region::getRegionName($store['street']);
        }
        if (!empty($address)) {
            $address .= ' ';
        }
        $address .= $store['address'];

		//获取用户信息
    	$user_info = \RC_Api::api('user', 'user_info', array('user_id' => $order['user_id']));
    	if (is_ecjia_error($user_info)) {
    		return $user_info;
    	}
    	
        $data = array(
        	'ticket_type'		  => '充值小票', 															//小票类型
        	
        	'order_sn' 	       	  => $order['order_sn'], 												//订单编号
        	'order_trade_no'      => $payment_record['order_trade_no'], 								//交易号（支付订单号）
        	'trade_type'	      => '会员充值',															//交易类型
        	'recharge_time'	      => RC_Time::local_date('Y-m-d H:i:s', $order['paid_time']),			//日期和时间
        	
        	'discount_amount'  	  => ecjia_price_format(0, false),										//优惠金额
        	'order_amount'     	  => ecjia_price_format(($order['amount'] - $order['pay_fee']), false), //充值金额
        	'user_pay_points'     => $user_info['pay_points'], 											//账户积分
        	'user_money'  	      => ecjia_price_format($user_info['user_money'], false), 				//账户余额
      		
        	'user_name'		   	  => $user_info['user_name'],											//会员账号
        	'payment'          	  => $payment_record['pay_name'], 										//支付渠道
        	'pay_account'         => $payment_record['payer_login'], 									//支付账号（对应payment_record表payer_login字段）
        	'trade_no'     	      => $payment_record['trade_no'], 										//支付流水号

        	'merchant_address'	  => $address,				//商家地址
            'qrcode'              => $order['order_sn'],	//二维码
        );
        
        $data['order_type']      = 'surplus';
        $data['merchant_name']   = $store['merchants_name'];
        $data['merchant_mobile'] = $store['shop_kf_mobile'];
        
        $result = RC_Api::api('printer', 'send_event_print', [
            'store_id'      => $store['store_id'],
            'event'         => $type,
            'value'         => $data,
            'auto_print'    => $auto_print,
        ]);
        
        return $result;
    }
    
    
    /**
     * 获取订单信息
     * @return array
     */
    public function getOrderInfo($order_id)
    {
        $order = RC_Api::api('finance', 'user_account_order_info', array('order_id' => $order_id));
        if (is_ecjia_error($order)) {
        	return $order;
        }
        if (empty($order)) {
            return new ecjia_error('not_found_order', '没有找到该充值订单');
        }
        return $order;
    }
    
    /**
     * 获取支付记录
     */
    protected function getPayRecord($order)
    {
        $record   = RC_DB::table('payment_record')->where('order_sn', $order['order_sn'])->where('trade_type', 'surplus')->first();
        return $record;
    }
    
    
}