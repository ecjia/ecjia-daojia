<?php

namespace Ecjia\App\Refund;

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
        $type = 'print_refund_orders';
        
        return $this->printRefundOrders($type, $order, $store, $payment_record, $auto_print);
    }
    
    /**
     * 打印退款订单小票
     */
    public function printRefundOrders($type, $order, $store, $payment_record, $auto_print = false)
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

		//获取退款订单打款信息
    	$refund_payrecord = RC_DB::table('refund_payrecord')->where('refund_id', $order['refund_id'])->first();
    	
    	$receivables = $order['goods_amount']
    					+ $order['shipping_fee'] 
    					+ $order['insure_fee']
    					+ $order['pay_fee']
    					+ $order['pack_fee'] 
    					+ $order['card_fee'] 
    					+ $order['inv_tax'] - $order['integral_money'] - $order['bonus'] - $order['discount'];
    	
    	$order_amount = $order['money_paid'] + $order['surplus'];
    	
        $data = array(
        	'ticket_type'		  => '退款小票', 															//小票类型
        	
        	'order_sn' 	       	  => $order['order_sn'], 												//订单编号
        	'refund_sn'      	  => $order['refund_sn'], 												//退款单号
        	'trade_type'	      => '撤销消费',															//交易类型
        	'refund_time'	      => RC_Time::local_date('Y-m-d H:i:s', $order['refund_time']),			//日期和时间
        	'cashier'			  => $refund_payrecord['action_user_name'],								//收银员
        	
        	'bonus'  	  		  => ecjia_price_format($order['bonus'], false),						//红包抵扣
        	'integral_money'  	  => ecjia_price_format($order['integral_money'], false),				//积分抵扣
        	'discount_amount'  	  => ecjia_price_format($order['discount'], false),						//优惠金额
        	'receivables'     	  => ecjia_price_format($receivables, false), 							//应收金额
        	'order_amount'     	  => ecjia_price_format($order_amount, false), 							//实收金额
        	'refund_amount'  	  => ecjia_price_format($refund_payrecord['back_money_total'], false),  //退款金额
      		
        	'payment'          	  => $payment_record['pay_name'], 										//支付渠道
        	'trade_no'     	      => $payment_record['trade_no'], 										//支付流水号

        	'merchant_address'	  => $address,				//商家地址
            'qrcode'              => $order['order_sn'],	//二维码
        );
        
        $data['order_type']      = 'refund';
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
        $refund_order = RC_DB::table('refund_order')->where('order_id', $order_id)->where('status', '!=', \Ecjia\App\Refund\RefundStatus::ORDER_CANCELED)->first();
        
        if (empty($refund_order)) {
            return new ecjia_error('not_found_order', '没有找到该退款订单');
        }
        return $refund_order;
    }
    
    /**
     * 获取支付记录
     */
    protected function getPayRecord($order)
    {
        $record   = RC_DB::table('payment_record')->where('order_sn', $order['order_sn'])->where('trade_type', 'buy')->first();
        return $record;
    }
    
    
}