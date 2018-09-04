<?php

namespace Ecjia\App\Quickpay;

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
        
        //3.获取支付流水号
        $order_trade_no = $this->getPayRecord($order);
        
        //4.定义小票打印类型
        $type = 'print_quickpay_orders';
        
        
        return $this->printQuickpayOrders($type, $order, $store, $order_trade_no, $auto_print);
    }
    
    /**
     * 打印普通订单小票
     */
    public function printQuickpayOrders($type, $order, $store, $order_trade_no, $auto_print = false)
    {
        if ($order['activity_type'] == 'discount') {
            $order['activity_name'] = '价格折扣';
        } elseif ($order['activity_type'] == 'everyreduced') {
            $order['activity_name'] = '每满多少减多少,最高减多少';
        } elseif ($order['activity_type'] == 'reduced') {
            $order['activity_name'] = '满多少减多少';
        } elseif ($order['activity_type'] == 'normal') {
            $order['activity_name'] = '无优惠';
        }
        
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

        $discount_amount = number_format(($order['discount'] + $order['integral_money'] + $order['bonus']), 2);
        $order_amount = number_format(($order['order_amount'] + $order['surplus']), 2);

        $data = array(
            'order_sn'            => $order['order_sn'], //订单编号
            'order_trade_no'      => $order_trade_no, //流水编号
            'user_account'        => $order['user_name'], //会员账号
            'purchase_time'       => RC_Time::local_date('Y-m-d H:i:s', $order['add_time']), //下单时间
            'merchant_address'    => $address,
            'favourable_activity' => $order['activity_name'],
        		
        	'discount_amount'     => $discount_amount, //优惠金额
            'receivables'         => $order_amount, //应收金额
            'payment'             => $order['pay_name'], //支付方式
            'order_amount'        => $order_amount, //实收金额
            
            'qrcode'              => $order['order_sn'],
        );
        
        $data['order_type']      = 'quickpay';
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
        $order = RC_DB::table('quickpay_orders')->where('order_id', $order_id)->first();
        if (!$order) {
            return new ecjia_error('not_found_order', '没有找到该买单订单');
        }
        return $order;
    }
    
    /**
     * 获取支付记录
     */
    protected function getPayRecord($order)
    {
        $record   = RC_DB::table('payment_record')->where('order_sn', $order['order_sn'])->where('trade_type', 'quickpay')->first();
        return $record['trade_no'] ?: $record['order_trade_no'];
    }
    
    
}