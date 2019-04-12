<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-25
 * Time: 13:32
 */

namespace Ecjia\App\Cart\CreateOrders\OrderParts;


use Ecjia\App\Cart\CreateOrders\OrderPartAbstract;

class OrderPaymentPart extends OrderPartAbstract
{

    protected $part_key = 'payment';

    protected $pay_id;

    public function __construct($pay_id, array $shipping_id)
    {
        $this->pay_id = $pay_id;
        $this->shipping_id = $shipping_id;
    }

	/**
	 * 支付方式检验
	 * @return \ecjia_error
	 */
    public function check_payment()
    {
    	//选择货到付款支付方式后，不可选择上门取货配送方式
    	if ($this->pay_id > 0) {
    		$payment = with(new \Ecjia\App\Payment\PaymentPlugin)->getPluginDataById(intval($this->pay_id));
    		if ($payment['pay_code'] == 'pay_cod') {
    			if (!empty($this->shipping_id) && is_array($this->shipping_id)) {
    				foreach ($this->shipping_id as $ship) {
    					$shipping_ids[] = $ship;
    				}
    				$ship_codes = \RC_DB::table('shipping')->whereIn('shipping_id', $shipping_ids)->lists('shipping_code');
    				$ship_codes = array_unique($ship_codes);
    				if (in_array('ship_cac', $ship_codes)) {
    					return new \ecjia_error('not_surport_shipping', __('货到付款支付不支持上门取货配送！', 'cart'));
    				}
    			}
    		}
    		
    		//TODO 货到付款不支持非自营商家,待处理
//     		$is_pay_cod = false;
//     		$order['pay_name'] = addslashes($payment['pay_name']);
//     		//如果是货到付款，状态设置为已确认。
//     		if($payment['pay_code'] == 'pay_cod') {
//     			$is_pay_cod = true;
//     			$order['order_status'] = 1;
//     			$store_manage_modes = RC_DB::table('store_franchisee')->whereIn('store_id', $options['store_ids'])->lists('manage_mode');
//     			/* 货到付款判断是否是自营*/
//     			if (in_array('join', $store_manage_modes)) {
//     				return new ecjia_error('pay_not_support', __('货到付款不支持非自营商家！', 'cart'));
//     			}
//     		}
    		
    	}
    }
    
    /**
     * 订单总支付手续费
     */
    public function total_pay_fee()
    {
    	//TODO $total['amount']订单总金额 获取待定
    	
    	$shipping_cod_fee = NULL;
//     	if (!empty($order['pay_id']) && ($total['real_goods_count'] > 0 || $se_flow_type != CART_EXCHANGE_GOODS)) {
//     		$total['pay_fee'] = self::pay_fee($order['pay_id'], $total['amount'], $shipping_cod_fee);
//     	}
    }
    
    /**
     * 获得订单需要支付的支付费用
     *
     * @access  public
     * @param   integer $payment_id
     * @param   float   $order_amount
     * @param   mix	 $cod_fee
     * @return  float
     */
    public  function pay_fee($payment_id, $order_amount, $cod_fee=null) {
    	$pay_fee = 0;
    	$payment = with(new \Ecjia\App\Payment\PaymentPlugin)->getPluginDataById(intval($payment_id));
    	$rate	= ($payment['is_cod'] && !empty($cod_fee)) ? $cod_fee : $payment['pay_fee'];
    
    	if (strpos($rate, '%') !== false) {
    		/* 支付费用是一个比例 */
    		$val		= floatval($rate) / 100;
    		$pay_fee	= $val > 0 ? $order_amount * $val /(1- $val) : 0;
    	} else {
    		$pay_fee	= floatval($rate);
    	}
    	return round($pay_fee, 2);
    }
    
    

}