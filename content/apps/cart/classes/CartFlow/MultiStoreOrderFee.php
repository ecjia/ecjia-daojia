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
namespace Ecjia\App\Cart\CartFlow;

use RC_Loader;
use RC_DB;


/**
 *多店铺订单各项总费用计算
 */
class MultiStoreOrderFee
{
   /**
     * 获取多店铺订单各项总费用
     *
     * @access  public
     * @param   array   $order       		初始订单信息
     * @param   array   $consignee   		收货人信息
     * @param   array   $cart_id			购物车ids
     * @param   array	$cart_goods_list    购物车商品
     * @param   array	$store_ids			购物车对应所有店铺ids
     * @return  array   
     */
    public static function multiple_store_order_fee($order, $consignee, $cart_id = array(), $cart_goods_list = [], $store_ids = []) 
    {
    	/* 初始化订单的扩展code */
    	if (!isset($order['extension_code'])) {
    		$order['extension_code'] = '';
    	}
    	
    	$total = array('real_goods_count' => 0, 'gift_amount' => 0, 'goods_price' => 0, 'market_price' => 0, 'discount' => 0, 'pack_fee' => 0, 'card_fee' => 0, 'shipping_fee' => 0, 'shipping_insure' => 0, 'integral_money' => 0, 'bonus' => 0, 'surplus' => 0, 'cod_fee' => 0, 'pay_fee' => 0, 'tax' => 0);
    	
    	/*实体商品的个数*/
    	$total['real_goods_count'] 	= $cart_goods_list['total']['real_goods_count'];
    	
    	/* 商品总价 */
    	$total['goods_price'] 		= $cart_goods_list['total']['unformatted_goods_price'];
    	$total['market_price'] 		= $cart_goods_list['total']['unformatted_market_price'];
    	$total['goods_price_formated'] 	= ecjia_price_format($total['goods_price'], false);
    	$total['market_price_formated'] = ecjia_price_format($total['market_price'], false);
    	
    	/* 折扣 */
    	if ($order['extension_code'] != 'group_buy') {
    		$total['discount'] = $cart_goods_list['total']['discount'];
    		if ($total['discount'] > $total['goods_price']) {
    			$total['discount'] = $total['goods_price'];
    		}
    	}
    	$total['discount_formated'] = ecjia_price_format($total['discount'], false);
    	
    	/* 税额 */
    	if (!empty($order['need_inv']) && $order['inv_type'] != '') {
    		$total['tax'] = self::get_tax_fee($order['inv_type'], $total['goods_price']);
    	}
    	
    	/* 包装费 */
    	$total['card_fee_formated'] = ecjia_price_format($total['card_fee'], false);
    	
    	/*保价费*/
    	$total['shipping_insure_formated'] = ecjia_price_format($total['shipping_insure'], false);
    	
    	/* 红包金额 */
    	if (!empty($order['bonus_id'])) {
    		$bonus = \Ecjia\App\Bonus\UserAvaliableBonus::bonusInfo($order['bonus_id']);
    		$total['bonus'] = $bonus['type_money'];
    	}
    	
    	/*配送费用*/
    	if (!empty($order['shipping_id']) && is_array($order['shipping_id']) && $total['real_goods_count'] > 0) {
    		$total['shipping_fee'] 	= self::get_total_shipping_fee($cart_goods_list, $order['shipping_id']);
    	}
    	$total['shipping_fee_formated'] = ecjia_price_format($total['shipping_fee'], false);
    	
    	/*红包和积分最多能支付的金额为剩余商品总额（既已扣除优惠金额的商品金额）*/ 
    	$max_amount = $total['goods_price'] == 0 ? $total['goods_price'] : $total['goods_price'] - $total['discount'];
    	
    	/* 计算订单总额 */
    	if ($order['extension_code'] == 'group_buy') {
    		RC_Loader::load_app_func('admin_goods', 'goods');
    		$group_buy = group_buy_info($order['extension_id']);
    	}
    	if ($order['extension_code'] == 'group_buy' && $group_buy['deposit'] > 0) {
    		$total['amount'] = $total['goods_price'];
    	} else {
    		$total['amount'] = $total['goods_price'] - $total['discount'] + $total['tax'] + $total['pack_fee'] + $total['card_fee'] + $total['shipping_fee'] + $total['shipping_insure'] + $total['cod_fee'];
    		/* 实际可使用的红包金额 */
    		$use_bonus = min($total['bonus'], $max_amount); //使用红包的金额不可超过剩余商品金额
    		$total['bonus'] = $use_bonus;
    		$total['bonus_formated'] = ecjia_price_format($total['bonus'], false);
    		/* 订单总金额重新计算 */
    		$total['amount'] -= $use_bonus;
    		/* 还需要支付的订单商品金额 */ 
    		$max_amount -= $use_bonus;
    	}
    	
    	/* 余额 */
    	$order['surplus'] = $order['surplus'] > 0 ? $order['surplus'] : 0;
    	if ($total['amount'] > 0) {
    		if (isset($order['surplus']) && $order['surplus'] > $total['amount']) {
    			$order['surplus'] = $total['amount'];
    			$total['amount'] = 0;
    		} else {
    			/* 订单总金额重新计算 */
    			$total['amount'] -= floatval($order['surplus']);
    		}
    	} else {
    		$order['surplus'] = 0;
    		$total['amount'] = 0;
    	}
    	$total['surplus'] = $order['surplus'];
    	$total['surplus_formated'] = ecjia_price_format($order['surplus'], false);
    	
    	/* 积分 */
    	$order['integral'] = $order['integral'] > 0 ? $order['integral'] : 0;
    	if ($total['amount'] > 0 && $max_amount > 0 && $order['integral'] > 0) {
    		/*输入的积分数可抵扣的金额*/
    		$integral_money = \Ecjia\App\Cart\CartFunction::value_of_integral($order['integral']);
    		
    		/*实际使用积分支付抵扣的金额*/ 
    		$use_integral = min($total['amount'], $max_amount, $integral_money); //积分抵扣金额不可超过订单总金额
    		
    		/* 订单总金额重新计算 */
    		$total['amount'] -= $use_integral;
    		$total['integral_money'] = $use_integral;
    		
    		/*实际使用的积分数*/
    		$order['integral'] = \Ecjia\App\Cart\CartFunction::integral_of_value($use_integral);
    	} else {
    		$total['integral_money'] = 0;
    		$order['integral'] = 0;
    	}
    	$total['integral'] = $order['integral'];
    	$total['integral_formated'] = ecjia_price_format($total['integral_money'], false);
    	
    	/* 保存订单信息 */
    	$_SESSION['flow_order'] = $order;
    	$se_flow_type = isset($_SESSION['flow_type']) ? $_SESSION['flow_type'] : '';
    	
    	/* 支付费用 */
    	$shipping_cod_fee = NULL;
    	if (!empty($order['pay_id']) && ($total['real_goods_count'] > 0 || $se_flow_type != CART_EXCHANGE_GOODS)) {
    		$total['pay_fee'] = self::pay_fee($order['pay_id'], $total['amount'], $shipping_cod_fee);
    	}
    	$total['pay_fee_formated'] = ecjia_price_format($total['pay_fee'], false);
    	
    	/* 订单总额累加上支付费用 */ 
    	$total['amount'] += $total['pay_fee'];
    	$total['amount_formated'] = ecjia_price_format($total['amount'], false);
    	
    	/*节省金额*/
    	$total['saving'] 		= $total['discount'];
    	$total['save_rate'] 	=  $total['discount'] > 0 ? round($total['discount'] * 100 / $total['goods_price']) . '%' : 0;
    	$total['formated_saving'] 		= ecjia_price_format($total['discount'], false);
    
    	return $total;
    }
    
    
    /**
     * 多店铺配送总费用
     */
    public static function get_total_shipping_fee($cart_goods_list, $shipping_ids) {
    	$shipping_fee = 0;
    	
    	if (!empty($cart_goods_list['cart_list']) && !empty($shipping_ids) && is_array($shipping_ids)) {
    		foreach ($cart_goods_list['cart_list'] as $val) {
    			if ($val['shipping']) {
    				foreach ($val['shipping'] as $k => $v) {
    					foreach ($shipping_ids as $ship_val) {
    						if ($ship_val) {
    							$ship = explode('-', $ship_val);
    							if ($ship['0'] == $val['store_id'] && $ship['1'] == $v['shipping_id']) {
    								if ($v['shipping_code'] == 'ship_cac') {
    									$v['shipping_fee'] = 0;
    								}
    								$shipping_fee += $v['shipping_fee'];
    							}
    						}
    					}
    				}
    			}
    		}
    	}
    	return $shipping_fee;
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
    public static function pay_fee($payment_id, $order_amount, $cod_fee=null) {
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
    
    /**
     * 税费计算
     * @param string $inv_type
     * @param float $goods_price
     * @return float
     */
    public static function get_tax_fee($inv_type, $goods_price) {
    	$rate = 0;
    	$tax_fee = 0;
    
    	$invoice_type = \ecjia::config('invoice_type');
    	if ($invoice_type) {
    		$invoice_type = unserialize($invoice_type);
    		foreach ($invoice_type['type'] as $key => $type) {
    			if ($type == $inv_type) {
    				$rate_str = $invoice_type['rate'];
    				$rate = floatval($rate_str[$key]) / 100;
    				break;
    			}
    		}
    	}
    
    	if ($rate > 0) {
    		$tax_fee = $rate * $goods_price;
    		$tax_fee = round($tax_fee, 2);
    	}
    
    	return $tax_fee;
    }
    
    
    /**
     * 获取结算时店铺商品可用积分
     * @param array $cart_goods_store
     * @return number
     */
    public static function get_integral_store($cart_goods_store) {
    	//单店可用积分
    	$store_integral = 0;
    
    	foreach ($cart_goods_store as $row) {
    		$integral = 0;
    		$goods = RC_DB::table('goods')->where('goods_id', $row['goods_id'])->first();
    		if(empty($goods['integral']) || empty($row['goods_price'])) {
    			continue;
    		}
    		//取价格最小值，防止积分抵扣超过商品价格(并未计算优惠) -flow_available_points()
    		$val_min = min($goods['integral'], $row['goods_price']);
    		$val_min = $val_min * $row['goods_number'];
    		if ($val_min < 1 && $val_min > 0) {
    			$val = $val_min;
    		} else {
    			$val = intval($val_min);
    		}
    		if($val <= 0) {
    			continue;
    		}
    		$integral = \Ecjia\App\Cart\CartFunction::integral_of_value($val);
    		$store_integral += $integral;
    	}
    
    	return $store_integral;
    
    }
    
}
