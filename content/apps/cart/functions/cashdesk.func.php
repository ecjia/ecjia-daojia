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
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获得订单中的费用信息
 *
 * @access  public
 * @param   array   $order
 * @param   array   $goods
 * @param   array   $consignee
 * @param   bool    $is_gb_deposit  是否团购保证金（如果是，应付款金额只计算商品总额和支付费用，可以获得的积分取 $gift_integral）
 * @return  array
 */
function cashdesk_order_fee($order, $goods, $consignee = array(), $cart_id = array()) {
	
    RC_Loader::load_app_func('global','goods');
    RC_Loader::load_app_func('cart','cart');
    $db 	= RC_Loader::load_app_model('cart_model', 'cart');
    $dbview = RC_Loader::load_app_model('cart_exchange_viewmodel', 'cart');
    /* 初始化订单的扩展code */
    if (!isset($order['extension_code'])) {
        $order['extension_code'] = '';
    }

    //     TODO: 团购等促销活动注释后暂时给的固定参数
    $order['extension_code'] = '';
    $group_buy ='';
    //     TODO: 团购功能暂时注释
    //     if ($order['extension_code'] == 'group_buy') {
    //         $group_buy = group_buy_info($order['extension_id']);
    //     }

    $total  = array('real_goods_count' => 0,
        'gift_amount'      => 0,
        'goods_price'      => 0,
        'market_price'     => 0,
        'discount'         => 0,
        'pack_fee'         => 0,
        'card_fee'         => 0,
        'shipping_fee'     => 0,
        'shipping_insure'  => 0,
        'integral_money'   => 0,
        'bonus'            => 0,
        'surplus'          => 0,
        'cod_fee'          => 0,
        'pay_fee'          => 0,
        'tax'              => 0
    );
    $weight = 0;
    $shop_type = RC_Config::load_config('site', 'SHOP_TYPE');
    /* 商品总价 */
    foreach ($goods AS $key => $val) {
        /* 统计实体商品的个数 */
        if ($val['is_real']) {
            $total['real_goods_count']++;
        }

        if ($val['extension_code'] == 'bulk') {
            //散装价格x重量（数量/1000）
            $total['goods_price'] += $val['goods_price'] * $val['goods_number'] / 1000;
            $total['goods_price'] = formated_price_bulk($total['goods_price']);
            $total['market_price'] += $val['market_price'] * $val['goods_number'] / 1000;
            $total['market_price'] = formated_price_bulk($total['market_price']);
        } else {
            $total['goods_price']  += $val['goods_price'] * $val['goods_number'];
            $total['market_price'] += $val['market_price'] * $val['goods_number'];
        }

        $area_id = $consignee['province'];
        //多店铺开启库存管理以及地区后才会去判断
        if ( $area_id > 0 && $shop_type == 'b2b2c') {
            $warehouse_db = RC_Loader::load_app_model('warehouse_model', 'warehouse');
            $warehouse = $warehouse_db->where(array('regionId' => $area_id))->find();
            $warehouse_id = $warehouse['parent_id'];
            $goods[$key]['warehouse_id'] = $warehouse_id;
            $goods[$key]['area_id'] = $area_id;
        } else {
            $goods[$key]['warehouse_id'] = 0;
            $goods[$key]['area_id'] 	 = 0;
        }
    }

    $total['saving']    = $total['market_price'] - $total['goods_price'];
    $total['save_rate'] = $total['market_price'] ? round($total['saving'] * 100 / $total['market_price']) . '%' : 0;

    $total['goods_price_formated']  = price_format($total['goods_price'], false);
    $total['market_price_formated'] = price_format($total['market_price'], false);
    $total['saving_formated']       = price_format($total['saving'], false);
    
    /* 折扣 */
    if ($order['extension_code'] != 'group_buy') {
    	RC_Loader::load_app_class('cart', 'cart', false);
    	$discount = cart::compute_discount($cart_id);
    	$total['discount'] = round($discount['discount'], 2);
    	if ($total['discount'] > $total['goods_price']) {
    		$total['discount'] = $total['goods_price'];
    	}
    }
    $total['discount_formated'] = price_format($total['discount'], false);
    /* 税额 */
    if (!empty($order['need_inv']) && $order['inv_type'] != '') {
    	/* 查税率 */
    	$rate = 0;
    	$invoice_type = ecjia::config('invoice_type');
    	if ($invoice_type) {
    		$invoice_type = unserialize($invoice_type);
    		foreach ($invoice_type['type'] as $key => $type) {
    			if ($type == $order['inv_type']) {
    				$rate_str = $invoice_type['rate'];
    				$rate = floatval($rate_str[$key]) / 100;
    				break;
    			}
    		}
    	}
    	if ($rate > 0) {
    		$total['tax'] = $rate * $total['goods_price'];
    		$total['tax'] = round($total['tax'], 2);
    	}
    }
    $total['tax_formated'] = price_format($total['tax'], false);
    //	TODO：暂时注释
    /* 包装费用 */
    //     if (!empty($order['pack_id'])) {
    //         $total['pack_fee']      = pack_fee($order['pack_id'], $total['goods_price']);
    //     }
    //     $total['pack_fee_formated'] = price_format($total['pack_fee'], false);

    //	TODO：暂时注释
    //    /* 贺卡费用 */
    //    if (!empty($order['card_id'])) {
    //        $total['card_fee']      = card_fee($order['card_id'], $total['goods_price']);
    //    }
    $total['card_fee_formated'] = price_format($total['card_fee'], false);

    RC_Loader::load_app_func('admin_bonus','bonus');
    /* 红包 */
    if (!empty($order['bonus_id'])) {
        $bonus          = bonus_info($order['bonus_id']);
        $total['bonus'] = $bonus['type_money'];
    }
    $total['bonus_formated'] = price_format($total['bonus'], false);

    /* 线下红包 */
    if (!empty($order['bonus_kill'])) {
        $bonus  = bonus_info(0, $order['bonus_kill']);
        $total['bonus_kill'] = $order['bonus_kill'];
        $total['bonus_kill_formated'] = price_format($total['bonus_kill'], false);
    }

    $total['shipping_fee']		= 0;
    $total['shipping_insure']	= 0;
    $total['shipping_fee_formated']    = price_format($total['shipping_fee'], false);
    $total['shipping_insure_formated'] = price_format($total['shipping_insure'], false);

    // 活动优惠总金额
    $discount_amount = compute_discount_amount();
    // 红包和积分最多能支付的金额为商品总额
    //$max_amount 还需支付商品金额=商品金额-红包-优惠-积分
    $max_amount = $total['goods_price'] == 0 ? $total['goods_price'] : $total['goods_price'] - $discount_amount;


    /* 计算订单总额 */
    if ($order['extension_code'] == 'group_buy' && $group_buy['deposit'] > 0) {
        $total['amount'] = $total['goods_price'];
    } else {
        $total['amount'] = $total['goods_price'] - $total['discount'] + $total['tax'] + $total['pack_fee'] + $total['card_fee'] + $total['shipping_fee'] + $total['shipping_insure'] + $total['cod_fee'];
        // 减去红包金额
        $use_bonus	= min($total['bonus'], $max_amount); // 实际减去的红包金额
        if(isset($total['bonus_kill'])) {
            $use_bonus_kill   = min($total['bonus_kill'], $max_amount);
            $total['amount'] -=  $price = number_format($total['bonus_kill'], 2, '.', ''); // 还需要支付的订单金额
        }

        $total['bonus']   			= ($total['bonus'] > 0) ? $use_bonus : 0;
        $total['bonus_formated'] 	= price_format($total['bonus'], false);

        $total['amount'] -= $use_bonus; // 还需要支付的订单金额
        $max_amount      -= $use_bonus; // 积分最多还能支付的金额
    }
    /* 余额 */
    $order['surplus'] = $order['surplus'] > 0 ? $order['surplus'] : 0;
    if ($total['amount'] > 0) {
        if (isset($order['surplus']) && $order['surplus'] > $total['amount']) {
            $order['surplus'] = $total['amount'];
            $total['amount']  = 0;
        } else {
            $total['amount'] -= floatval($order['surplus']);
        }
    } else {
        $order['surplus'] = 0;
        $total['amount']  = 0;
    }
    $total['surplus'] 			= $order['surplus'];
    $total['surplus_formated'] 	= price_format($order['surplus'], false);

    /* 积分 */
    $order['integral'] = $order['integral'] > 0 ? $order['integral'] : 0;
    if ($total['amount'] > 0 && $max_amount > 0 && $order['integral'] > 0) {
        $integral_money = value_of_integral($order['integral']);
        // 使用积分支付
        $use_integral            = min($total['amount'], $max_amount, $integral_money); // 实际使用积分支付的金额
        $total['amount']        -= $use_integral;
        $total['integral_money'] = $use_integral;
        $order['integral']       = integral_of_value($use_integral);
    } else {
        $total['integral_money'] = 0;
        $order['integral']       = 0;
    }
    $total['integral'] 			 = $order['integral'];
    $total['integral_formated']  = price_format($total['integral_money'], false);

    /* 保存订单信息 */
    $_SESSION['flow_order'] = $order;
    $se_flow_type = isset($_SESSION['flow_type']) ? $_SESSION['flow_type'] : '';

    /* 支付费用 */
    if (!empty($order['pay_id']) && ($total['real_goods_count'] > 0 || $se_flow_type != CART_EXCHANGE_GOODS)) {
        $total['pay_fee']      	= pay_fee($order['pay_id'], $total['amount'], $shipping_cod_fee);
    }
    $total['pay_fee_formated'] 	= price_format($total['pay_fee'], false);
    $total['amount']           += $total['pay_fee']; // 订单总额累加上支付费用
    $total['amount_formated']  	= price_format($total['amount'], false);

    /* 取得可以得到的积分和红包 */
    if ($order['extension_code'] == 'group_buy') {
        $total['will_get_integral'] = $group_buy['gift_integral'];
    } elseif ($order['extension_code'] == 'exchange_goods') {
        $total['will_get_integral'] = 0;
    } else {
        $total['will_get_integral'] = get_give_integral($goods);
    }

    $total['will_get_bonus']        = $order['extension_code'] == 'exchange_goods' ? 0 : price_format(get_total_bonus(), false);
    $total['formated_goods_price']  = price_format($total['goods_price'], false);
    $total['formated_market_price'] = price_format($total['market_price'], false);
    $total['formated_saving']       = price_format($total['saving'], false);

    if ($order['extension_code'] == 'exchange_goods') {
        if ($_SESSION['user_id']) {
            $exchange_integral = $dbview->join('exchange_goods')->where(array('c.user_id' => $_SESSION['user_id'] , 'c.rec_type' => CART_EXCHANGE_GOODS , 'c.is_gift' => 0 ,'c.goods_id' => array('gt' => 0)))->group('eg.goods_id')->sum('eg.exchange_integral');
        } else {
            $exchange_integral = $dbview->join('exchange_goods')->where(array('c.session_id' => SESS_ID , 'c.rec_type' => CART_EXCHANGE_GOODS , 'c.is_gift' => 0 ,'c.goods_id' => array('gt' => 0)))->group('eg.goods_id')->sum('eg.exchange_integral');
        }
        $total['exchange_integral'] = $exchange_integral;
    }

    return $total;
}