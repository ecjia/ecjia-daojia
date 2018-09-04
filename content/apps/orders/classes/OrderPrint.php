<?php

namespace Ecjia\App\Orders;

use RC_Api;
use RC_DB;
use RC_Time;
use RC_Lang;
use RC_Loader;
use ecjia_region;
use ecjia_error;
use ecjia_shipping;

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
        $order    = RC_Api::api('orders', 'order_info', array('order_id' => $this->order_id, 'store_id' => $this->store_id));
        if (is_ecjia_error($order)) {
            return $order;
        }
        
        //2.获取店铺信息
        $store    = RC_Api::api('store', 'store_info', array('store_id' => $this->store_id));
        if (is_ecjia_error($store)) {
            return $store;
        }
        
        //3.获取用户信息
        $user = RC_Api::api('user', 'user_info', array('user_id' => $order['user_id']));
        if (is_ecjia_error($user) || empty($user['user_name'])) {
            $order['user_name'] = '匿名用户';
        } else {
            $order['user_name'] = $user['user_name'];
        }
        
        //4.获取配送方式，判断订单类型
        $type          = 'print_buy_orders';
        
        if (intval($order['shipping_id']) == 0) {
        	$type = 'print_store_orders';
        } else {
        	$shipping_data = ecjia_shipping::getPluginDataById($order['shipping_id']);
        	if (in_array($shipping_data['shipping_code'], ['ship_o2o_express', 'ship_ecjia_express'])) {
        		$type = 'print_takeaway_orders';
        	} elseif ($shipping_data['shipping_code'] == 'ship_cac') {
        		$type = 'print_store_orders';
        	}
        }
        //5.获取订单中的商品列表
        $goods_list = $this->getGoodsList();
        
        //6.获取支付流水号
        $order_trade_no = $this->getPayRecord($order);
        
        //7.获取该订单获得积分
        $integral_give = $this->getIntegralGive($order);
        
        if ($type == 'print_buy_orders') {
            return $this->printBuyOrders($type, $order, $store, $user, $goods_list, $order_trade_no, $integral_give, $auto_print);
        } elseif ($type == 'print_takeaway_orders') {
            return $this->printTakeawayOrders($type, $order, $store, $user, $goods_list, $order_trade_no, $integral_give, $auto_print);
        } elseif ($type == 'print_store_orders') {
        	return $this->printStoreOrders($type, $order, $store, $goods_list, $order_trade_no, $auto_print);
        }
    }
    
    /**
     * 打印普通订单小票
     */
    public function printBuyOrders($type, $order, $store, $user, $goods_list, $order_trade_no, $integral_give, $auto_print = false)
    {
        $data = array(
            'order_sn'            => $order['order_sn'], //订单编号
            'order_trade_no'      => $order_trade_no, //流水编号
            'user_name'           => $order['user_name'], //会员账号
            'purchase_time'       => RC_Time::local_date('Y-m-d H:i:s', $order['add_time']), //下单时间
        
            'goods_lists'         => $goods_list,
            'goods_subtotal'      => $order['goods_amount'], //商品总计
        
            'integral_money'      => $order['integral_money'],
            'integral_give'       => $integral_give, //获得积分
            'integral_balance'    => $user['pay_points'], //积分余额
            'favourable_discount' => $order['discount'], //满减满折
            'bonus_discount'      => $order['bonus'], //红包折扣
        
            'shipping_fee'        => $order['shipping_fee'],
            'receivables'         => $order['total_fee'], //应收金额
            'order_amount'        => $order['total_fee'], //实收金额
            'payment'             => $order['pay_name'],
        
            'order_remarks'       => $order['postscript'],
            'qrcode'              => $order['order_sn'],
        );
        
        $data['order_type']      = 'buy';
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
     * 打印外卖订单小票
     */
    public function printTakeawayOrders($type, $order, $store, $user, $goods_list, $order_trade_no, $integral_give, $auto_print = false)
    {
        $address = '';
        if (!empty($order['province'])) {
            $address .= ecjia_region::getRegionName($order['province']);
        }
        if (!empty($order['city'])) {
            $address .= ecjia_region::getRegionName($order['city']);
        }
        if (!empty($order['district'])) {
            $address .= ecjia_region::getRegionName($order['district']);
        }
        if (!empty($order['street'])) {
            $address .= ecjia_region::getRegionName($order['street']);
        }
        if (!empty($address)) {
            $address .= ' ';
        }
        $address .= $order['address'];
        
        $data = array(
            'order_sn'             => $order['order_sn'], //订单编号
            'order_trade_no'       => $order_trade_no, //流水编号
            'payment'              => $order['pay_name'], //支付方式
            'pay_status'           => RC_Lang::get('orders::order.ps.' . $order['pay_status']), //支付状态
            'purchase_time'        => RC_Time::local_date('Y-m-d H:i:s', $order['add_time']), //下单时间
            
            'expect_shipping_time' => $order['expect_shipping_time'], //期望送达时间
            
            'integral_money'       => $order['integral_money'], //积分抵扣
        
            'integral_balance'     => $user['pay_points'], //积分余额
            'integral_give'        => $integral_give, //获得积分
            'shipping_fee'         => $order['shipping_fee'],
        
            'receivables'          => $order['total_fee'], //应收金额
            'favourable_discount'  => $order['discount'], //满减满折
            'bonus_discount'       => $order['bonus'], //红包折扣
        
            'order_amount'         => $order['total_fee'], //实收金额
            'order_remarks'        => $order['postscript'],
            'consignee_address'    => $address,
            'consignee_name'       => $order['consignee'],
            'consignee_mobile'     => $order['mobile'],
            'goods_lists'          => $goods_list,
            'goods_subtotal'       => $order['goods_amount'], //商品总计
            'qrcode'               => $order['order_sn'],
        );
        
        $data['order_type']      = 'buy';
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
     * 打印到店购物小票
     */
    public function printStoreOrders($type, $order, $store, $goods_list, $order_trade_no, $auto_print = false)
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
    
        $money = $order['surplus'] + $order['money_paid'] + $order['integral_money'];
    	$data = array(
    		'order_sn'        	=> $order['order_sn'], //订单编号
    		'order_trade_no'   	=> $order_trade_no, //流水编号
    		'purchase_time'    	=> RC_Time::local_date('Y-m-d H:i:s', $order['add_time']), //下单时间
    		'merchant_address'  => $address,
    			
    		'goods_lists'       => $goods_list,
            'goods_subtotal'    => $order['goods_amount'], //商品总计
    		'discount_amount'	=> $order['discount'], //优惠金额
    		'receivables'     	=> $money, //应收金额
    		'payment'        	=> $order['pay_name'], //支付方式
    		'order_amount'    	=> $money, //实收金额
    		'qrcode'            => $order['order_sn'],
    	);
    
    	$data['order_type']      = 'buy';
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
     * 获取商品列表
     * @return array
     */
    public function getGoodsList()
    {
        $goods_list = array();
        
        $data = RC_DB::table('order_goods as o')
                    ->leftJoin('products as p', RC_DB::raw('p.product_id'), '=', RC_DB::raw('o.product_id'))
                    ->leftJoin('goods as g', RC_DB::raw('o.goods_id'), '=', RC_DB::raw('g.goods_id'))
                    ->select(RC_DB::raw('o.*'), RC_DB::raw("IF(o.product_id > 0, p.product_number, g.goods_number) AS storage"), RC_DB::raw('o.goods_attr'), RC_DB::raw('g.suppliers_id'), RC_DB::raw('p.product_sn'), RC_DB::raw('g.goods_img'), RC_DB::raw('g.goods_sn as goods_sn'))
                            ->where(RC_DB::raw('o.order_id'), $this->order_id)
                            ->get();
        
        if (!empty($data)) {
            foreach ($data as $key => $row) {
                $row['formated_subtotal']    = price_format($row['goods_price'] * $row['goods_number']);
                $row['formated_goods_price'] = price_format($row['goods_price']);
                if (!empty($row['goods_attr'])) {
                    $row['goods_attr'] = trim($row['goods_attr']);
                    $row['goods_name'] .= '【'.$row['goods_attr'].'】';
                }
                $goods_list[]                = array(
                    'goods_name'   => $row['goods_name'],
                    'goods_number' => $row['goods_number'],
                    'goods_amount' => $row['goods_price'],
                );
            }
        }
        
        return $goods_list;
    }
    
    /**
     * 获取支付记录
     */
    protected function getPayRecord($order)
    {
        $record   = RC_DB::table('payment_record')->where('order_sn', $order['order_sn'])->where('trade_type', 'buy')->first();
        return $record['trade_no'] ?: $record['order_trade_no'];
    }
    
    /**
     * 获取该订单所得积分
     */
    protected function getIntegralGive($order)
    {
    	RC_Loader::load_app_func('admin_order', 'orders');
    	$integral      = integral_to_give($order);
    	$integral_give = !empty($integral['custom_points']) ? $integral['custom_points'] : 0;
    	
    	return $integral_give;
    }
    
}