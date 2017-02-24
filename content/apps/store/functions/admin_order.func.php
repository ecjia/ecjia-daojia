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
* ECJIA 购物流程函数库
*/

/**
* 处理序列化的支付、配送的配置参数
* 返回一个以name为索引的数组
*
* @access  public
* @param   string	   $cfg
* @return  void
*/

function unserialize_config($cfg) {
	if (is_string($cfg) && ($arr = unserialize($cfg)) !== false) {
		$config = array();
		foreach ($arr AS $key => $val) {
			$config[$val['name']] = $val['value'];
		}
		return $config;
	} else {
		return false;
	}
}

/**
* 计算运费
* @param   string  $shipping_code	  配送方式代码
* @param   mix	 $shipping_config	配送方式配置信息
* @param   float   $goods_weight	   商品重量
* @param   float   $goods_amount	   商品金额
* @param   float   $goods_number	   商品数量
* @return  float   运费
*/
//TODO:方法后期可废弃，已移入shipping_method类中
function shipping_fee($shipping_code, $shipping_config, $goods_weight, $goods_amount, $goods_number='') {
	if (!is_array($shipping_config)) {
		$shipping_config = unserialize($shipping_config);
	}

	if (RC_Loader::load_app_module($shipping_code,"shipping")) {
		$obj = new $shipping_code($shipping_config);
		return $obj->calculate($goods_weight, $goods_amount, $goods_number);
	} else {
		return 0;
	}
}

/**
* 获取指定配送的保价费用
*
* @access  public
* @param   string	  $shipping_code  配送方式的code
* @param   float	   $goods_amount   保价金额
* @param   mix		 $insure		 保价比例
* @return  float
*/
function shipping_insure_fee($shipping_code, $goods_amount, $insure) {
	if (strpos($insure, '%') === false) {
		/* 如果保价费用不是百分比则直接返回该数值 */
		return floatval($insure);
	} else {
		if (RC_Loader::load_app_module($shipping_code,"shipping")){
			$shipping = new $shipping_code;
			$insure   = floatval($insure) / 100;
			if (method_exists($shipping, 'calculate_insure')) {
				return $shipping->calculate_insure($goods_amount, $insure);
			} else {
				return ceil($goods_amount * $insure);
			}
		} else {
			return false;
		}
	}
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
function pay_fee($payment_id, $order_amount, $cod_fee=null) {
	$payment_method = RC_Loader::load_app_class('payment_method','payment');
	$pay_fee = 0;
	$payment = $payment_method->payment_info($payment_id);
	$rate	 = ($payment['is_cod'] && !is_null($cod_fee)) ? $cod_fee : $payment['pay_fee'];

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
* 取得订单信息
* @param   int	 $order_id   订单id（如果order_id > 0 就按id查，否则按sn查）
* @param   string  $order_sn   订单号
* @return  array   订单信息（金额都有相应格式化的字段，前缀是formated_）
*/
function order_info($order_id, $order_sn = '') {
	RC_Loader::load_app_func('global', 'goods');
	$db = RC_Loader::load_app_model('order_info_model','orders');
	/* 计算订单各种费用之和的语句 */
	$total_fee = " (goods_amount - discount + tax + shipping_fee + insure_fee + pay_fee + pack_fee + card_fee) AS total_fee ";
	$order_id  = intval($order_id);
	if ($order_id > 0) {
		$order = $db->field('*,'.$total_fee)->find(array('order_id' => $order_id, 'extension_code' => '', 'extension_id' => 0, 'is_delete' => 0));
	} else {
		$order = $db->field('*,'.$total_fee)->find(array('order_sn' => $order_sn, 'extension_code' => '', 'extension_id' => 0, 'is_delete' => 0));
	}

	/* 格式化金额字段 */
	if ($order) {
		$order['formated_goods_amount']		= price_format($order['goods_amount'], false);
		$order['formated_discount']			= price_format($order['discount'], false);
		$order['formated_tax']				= price_format($order['tax'], false);
		$order['formated_shipping_fee']		= price_format($order['shipping_fee'], false);
		$order['formated_insure_fee']		= price_format($order['insure_fee'], false);
		$order['formated_pay_fee']			= price_format($order['pay_fee'], false);
		$order['formated_pack_fee']			= price_format($order['pack_fee'], false);
		$order['formated_card_fee']			= price_format($order['card_fee'], false);
		$order['formated_total_fee']		= price_format($order['total_fee'], false);
		$order['formated_money_paid']		= price_format($order['money_paid'], false);
		$order['formated_bonus']			= price_format($order['bonus'], false);
		$order['formated_integral_money']	= price_format($order['integral_money'], false);
		$order['formated_surplus']			= price_format($order['surplus'], false);
		$order['formated_order_amount']		= price_format(abs($order['order_amount']), false);
		$order['formated_add_time']			= RC_Time::local_date(ecjia::config('time_format'), $order['add_time']);
	}
	return $order;
}

/**
* 判断订单是否已完成
* @param   array   $order  订单信息
* @return  bool
*/
function order_finished($order) {
	return $order['order_status']  == OS_CONFIRMED &&
	($order['shipping_status'] == SS_SHIPPED || $order['shipping_status'] == SS_RECEIVED) &&
	($order['pay_status'] == PS_PAYED || $order['pay_status'] == PS_PAYING);
}

/**
* 取得订单商品
* @param   int	 $order_id   订单id
* @return  array   订单商品数组
*/
function order_goods($order_id) {
	$db = RC_Loader::load_app_model('order_goods_model','orders');
	$data = $db->field('rec_id, goods_id, goods_name, goods_sn,product_id, market_price, goods_number,goods_price, goods_attr, is_real, parent_id, is_gift,goods_price * goods_number|subtotal, extension_code')->where(array('order_id' => $order_id))->select();

	if(!empty($data)) {
		foreach ($data as $row) {
			if ($row['extension_code'] == 'package_buy') {
				$row['package_goods_list'] = get_package_goods($row['goods_id']);
			}
			$goods_list[] = $row;
		}
	}
	return $goods_list;
}

/**
* 取得订单总金额
* @param   int	 $order_id   订单id
* @param   bool	$include_gift   是否包括赠品
* @return  float   订单总金额
*/
function order_amount($order_id, $include_gift = true) {
	$db = RC_Loader::load_app_model('order_goods_model','orders');
	if (!$include_gift) {
		$data = $db->where(array('order_id' => $order_id , 'is_gift' => 0))->sum('goods_price * goods_number');
	}
	$data = $db->where(array('order_id' => $order_id))->sum('goods_price * goods_number');
	return floatval($data);
}

/**
* 取得某订单商品总重量和总金额（对应 cart_weight_price）
* @param   int	 $order_id   订单id
* @return  array   ('weight' => **, 'amount' => **, 'formated_weight' => **)
*/
function order_weight_price($order_id) {
	$dbview = RC_Loader::load_app_model('order_order_goods_viewmodel', 'orders');
	$dbview->view = array(
		'goods' => array(
			'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
			'alias'	=> 'g',
			'field'	=> 'SUM(g.goods_weight * o.goods_number)|weight,SUM(o.goods_price * o.goods_number)|amount,SUM(o.goods_number)|number',
			'on'	=> 'o.goods_id = g.goods_id ',
		)
	);
	$row = $dbview->find(array('o.order_id' => $order_id));
	$row['weight'] = floatval($row['weight']);
	$row['amount'] = floatval($row['amount']);
	$row['number'] = intval($row['number']);

	/* 格式化重量 */
	$row['formated_weight'] = formated_weight($row['weight']);
	return $row;
}

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
function order_fee($order, $goods, $consignee) {
	RC_Loader::load_app_func('global', 'goods');
	RC_Loader::load_app_func('cart', 'cart');
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

    /* 商品总价 */
    foreach ($goods AS $val) {
        /* 统计实体商品的个数 */
        if ($val['is_real']) {
            $total['real_goods_count']++;
        }

        $total['goods_price']  += $val['goods_price']  * $val['goods_number'];
        $total['market_price'] += $val['market_price'] * $val['goods_number'];
    }

    $total['saving']    = $total['market_price'] - $total['goods_price'];
    $total['save_rate'] = $total['market_price'] ? round($total['saving'] * 100 / $total['market_price']) . '%' : 0;

    $total['goods_price_formated']  = price_format($total['goods_price'], false);
    $total['market_price_formated'] = price_format($total['market_price'], false);
    $total['saving_formated']       = price_format($total['saving'], false);

    /* 折扣 */
    if ($order['extension_code'] != 'group_buy') {
    	RC_Loader::load_app_func('cart','cart');
        $discount = compute_discount();
        $total['discount'] = $discount['discount'];
        if ($total['discount'] > $total['goods_price']) {
            $total['discount'] = $total['goods_price'];
        }
    }
    $total['discount_formated'] = price_format($total['discount'], false);

    /* 税额 */
    if (!empty($order['need_inv']) && $order['inv_type'] != '') {
        /* 查税率 */
        $rate = 0;
        $invoice_type=ecjia::config('invoice_type');
        foreach ($invoice_type['type'] as $key => $type) {
            if ($type == $order['inv_type']) {
            	$rate_str = $invoice_type['rate'];
                $rate = floatval($rate_str[$key]) / 100;
                break;
            }
        }
        if ($rate > 0) {
            $total['tax'] = $rate * $total['goods_price'];
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

	RC_Loader::load_app_func('admin_bonus', 'bonus');
   	/* 红包 */
	if (!empty($order['bonus_id'])) {
		$bonus          = bonus_info($order['bonus_id']);
		$total['bonus'] = $bonus['type_money'];
	}
	$total['bonus_formated'] = price_format($total['bonus'], false);
    /* 线下红包 */
    if (!empty($order['bonus_kill'])) {

        $bonus                        = bonus_info(0,$order['bonus_kill']);
        $total['bonus_kill']          = $order['bonus_kill'];
        $total['bonus_kill_formated'] = price_format($total['bonus_kill'], false);
    }

    /* 配送费用 */
    $shipping_cod_fee = NULL;
    if ($order['shipping_id'] > 0 && $total['real_goods_count'] > 0) {
        $region['country']  = $consignee['country'];
        $region['province'] = $consignee['province'];
        $region['city']     = $consignee['city'];
        $region['district'] = $consignee['district'];

        $shipping_method    = RC_Loader::load_app_class('shipping_method', 'shipping');
        $shipping_info 		= $shipping_method->shipping_area_info($order['shipping_id'], $region);

        if (!empty($shipping_info)) {

            if ($order['extension_code'] == 'group_buy') {
                $weight_price = cart_weight_price(CART_GROUP_BUY_GOODS);
            } else {
                $weight_price = cart_weight_price();
            }

            // 查看购物车中是否全为免运费商品，若是则把运费赋为零
            if ($_SESSION['user_id']) {
            	$shipping_count = $db->where(array('user_id' => $_SESSION['user_id'] , 'extension_code' => array('neq' => 'package_buy') , 'is_shipping' => 0))->count();
            } else {
            	$shipping_count = $db->where(array('session_id' => SESS_ID , 'extension_code' => array('neq' => 'package_buy') , 'is_shipping' => 0))->count();
            }

            $total['shipping_fee'] = ($shipping_count == 0 AND $weight_price['free_shipping'] == 1) ? 0 :  $shipping_method->shipping_fee($shipping_info['shipping_code'],$shipping_info['configure'], $weight_price['weight'], $total['goods_price'], $weight_price['number']);

            if (!empty($order['need_insure']) && $shipping_info['insure'] > 0) {
                $total['shipping_insure'] = shipping_insure_fee($shipping_info['shipping_code'],$total['goods_price'], $shipping_info['insure']);
            } else {
                $total['shipping_insure'] = 0;
            }

            if ($shipping_info['support_cod']) {
                $shipping_cod_fee = $shipping_info['pay_fee'];
            }
        }
    }

    $total['shipping_fee_formated']    = price_format($total['shipping_fee'], false);
    $total['shipping_insure_formated'] = price_format($total['shipping_insure'], false);

    // 购物车中的商品能享受红包支付的总额
    $bonus_amount = compute_discount_amount();
    // 红包和积分最多能支付的金额为商品总额
    $max_amount = $total['goods_price'] == 0 ? $total['goods_price'] : $total['goods_price'] - $bonus_amount;

    /* 计算订单总额 */
    if ($order['extension_code'] == 'group_buy' && $group_buy['deposit'] > 0) {
        $total['amount'] = $total['goods_price'];
    } else {
        $total['amount'] = $total['goods_price'] - $total['discount'] + $total['tax'] + $total['pack_fee'] + $total['card_fee'] + $total['shipping_fee'] + $total['shipping_insure'] + $total['cod_fee'];
        // 减去红包金额
        $use_bonus        = min($total['bonus'], $max_amount); // 实际减去的红包金额
        if(isset($total['bonus_kill'])) {
            $use_bonus_kill   = min($total['bonus_kill'], $max_amount);
            $total['amount'] -=  $price = number_format($total['bonus_kill'], 2, '.', ''); // 还需要支付的订单金额
        }

        $total['bonus']   			= $use_bonus;
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

/**
* 修改订单
* @param   int	 $order_id   订单id
* @param   array   $order	  key => value
* @return  bool
*/
function update_order($order_id, $order) {
	$db = RC_Loader::load_app_model('order_info_model','orders');
	return $db->where('order_id = '.$order_id.'')->update($order);
}

/**
* 得到新订单号
* @return  string
*/
function get_order_sn() {
	/* 选择一个随机的方案 */
	mt_srand((double) microtime() * 1000000);
	return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
}

/**
* 取得用户信息
* @param   int	 $user_id	用户id
* @return  array   用户信息
*/
function user_info($user_id) {
	$db_users = RC_Loader::load_app_model("users_model","user");
	$user = $db_users->find(array('user_id' => $user_id));

	unset($user['question']);
	unset($user['answer']);

	/* 格式化帐户余额 */
	if ($user) {
		$user['formated_user_money']	= price_format($user['user_money'], false);
		$user['formated_frozen_money']	= price_format($user['frozen_money'], false);
	}
	return $user;
}

/**
* 修改用户
* @param   int	 $user_id   订单id
* @param   array   $user	  key => value
* @return  bool
*/
function update_user($user_id, $user) {
	$db_users = RC_Loader::load_app_model("users_model","user");
	return $db_users->where(array('user_id' => $user_id))->update($user);
}

/**
* 取得用户地址列表
* @param   int	 $user_id	用户id
* @return  array
*/
function address_list($user_id) {
	$db_users = RC_Loader::load_app_model("user_address_model","user");
	return $db_users->where(array('user_id' => $user_id))->select();
}

/**
* 取得用户地址信息
* @param   int	 $address_id	 地址id
* @return  array
*/
function address_info($address_id) {
	$db_users = RC_Loader::load_app_model("user_address_model","user");
	return $db_users->find(array('address_id' => $address_id));
}


/**
* 计算积分的价值（能抵多少钱）
* @param   int	 $integral   积分
* @return  float   积分价值
*/
function value_of_integral($integral) {
	$scale = floatval(ecjia::config('integral_scale'));
	return $scale > 0 ? round(($integral / 100) * $scale, 2) : 0;
}

/**
* 计算指定的金额需要多少积分
*
* @access  public
* @param   integer $value  金额
* @return  void
*/
function integral_of_value($value) {
	$scale = floatval(ecjia::config('integral_scale'));
	return $scale > 0 ? round($value / $scale * 100) : 0;
}

/**
* 订单退款
* @param   array   $order		  订单
* @param   int	 $refund_type	退款方式 1 到帐户余额 2 到退款申请（先到余额，再申请提款） 3 不处理
* @param   string  $refund_note	退款说明
* @param   float   $refund_amount  退款金额（如果为0，取订单已付款金额）
* @return  bool
*/
function order_refund($order, $refund_type, $refund_note, $refund_amount = 0) {
	$db = RC_Loader::load_app_model('user_account_model','user');
	/* 检查参数 */
	$user_id = $order['user_id'];
	if ($user_id == 0 && $refund_type == 1) {
		return ecjia_admin::$controller->showmessage(__('匿名用户不能返回退款到帐户余额！') , ecjia_admin::MSGTYPE_JSON | ecjia_admin::MSGSTAT_ERROR);
	}

	$amount = $refund_amount > 0 ? $refund_amount : $order['money_paid'];
	if ($amount <= 0) {
		return true;
	}

	if (!in_array($refund_type, array(1, 2, 3))) {
		return ecjia_admin::$controller->showmessage(__('操作有误！请重新操作！') , ecjia_admin::MSGTYPE_JSON | ecjia_admin::MSGSTAT_ERROR);
	}

	/* 备注信息 */
	if ($refund_note) {
		$change_desc = $refund_note;
	} else {
		$change_desc = sprintf(RC_Lang::get('store::store.order_refund'), $order['order_sn']);
	}

	/* 处理退款 */
	if (1 == $refund_type) {
		$options = array(
				'user_id'		=> $user_id,
				'user_money'	=> $amount,
				'change_desc'	=> $change_desc
		);
		RC_Api::api('user', 'account_change_log',$options);
		return true;
	} elseif (2 == $refund_type) {
		/* 如果非匿名，退回余额 */
		if ($user_id > 0) {
			$options = array(
					'user_id'		=> $user_id,
					'user_money'	=> $amount,
					'change_desc'	=> $change_desc
			);
			RC_Api::api('user', 'account_change_log',$options);
		}

		/* user_account 表增加提款申请记录 */
		$account = array(
			'user_id'		=> $user_id,
			'amount'		=> (-1) * $amount,
			'add_time'		=> RC_Time::gmtime(),
			'user_note'		=> $refund_note,
			'process_type'	=> SURPLUS_RETURN,
			'admin_user'	=> $_SESSION['admin_name'],
			'admin_note'	=> sprintf(RC_Lang::get('store::store.order_refund'), $order['order_sn']),
			'is_paid'		=> 0
		);
		$db->insert($account);
		return true;
	} else {
		return true;
	}
}



/**
* 查询购物车（订单id为0）或订单中是否有实体商品
* @param   int	 $order_id   订单id
* @param   int	 $flow_type  购物流程类型
* @return  bool
*/
function exist_real_goods($order_id = 0, $flow_type = CART_GENERAL_GOODS) {
	$db_cart	= RC_Loader::load_app_model('cart_model', 'cart');
	$db_order	= RC_Loader::load_app_model('order_goods_model','orders');
	if ($order_id <= 0) {
// 		$query	= $db_cart->where(array('session_id' => SESS_ID , 'is_real' => 1 , 'rec_type' => $flow_type))->count();
		if ($_SESSION['user_id']) {
			$query 	= $db_cart->where(array('user_id' => $_SESSION['user_id'] , 'is_real' => 1 , 'rec_type' => $flow_type))->count();
		} else {
			$query 	= $db_cart->where(array('session_id' => SESS_ID , 'is_real' => 1 , 'rec_type' => $flow_type))->count();
		}
	} else {
		$query	= $db_order->where(array('order_id' => $order_id , 'is_real' => 1))->count();
	}
	return $query > 0;
}

/**
* 查询配送区域属于哪个办事处管辖
* @param   array   $regions	配送区域（1、2、3、4级按顺序）
* @return  int	 办事处id，可能为0
*/
function get_agency_by_regions($regions) {
	$db = RC_Loader::load_app_model('region_model','shipping');
	if (!is_array($regions) || empty($regions)) {
		return 0;
	}

	$arr = array();
	$data = $db->field('region_id, agency_id')->where(array('region_id' => array('gt' => 0) , 'agency_id' => array('gt' => 0)))->in(array('region_id' =>$regions))->select();

	if(!empty($data)) {
		foreach ($data as $row) {
			$arr[$row['region_id']] = $row['agency_id'];
		}
	}
	if (empty($arr)) {
		return 0;
	}

	$agency_id = 0;
	for ($i = count($regions) - 1; $i >= 0; $i--) {
		if (isset($arr[$regions[$i]])) {
			return $arr[$regions[$i]];
		}
	}
}

/**
* 改变订单中商品库存
* @param   int	 $order_id   订单号
* @param   bool	$is_dec	 是否减少库存
* @param   bool	$storage	 减库存的时机，1，下订单时；0，发货时；
*/
function change_order_goods_storage($order_id, $is_dec = true, $storage = 0) {
	$db			= RC_Loader::load_app_model('order_goods_model','orders');
	$db_package	= RC_Loader::load_app_model('package_goods_model','goods');
	$db_goods	= RC_Loader::load_app_model('goods_model','goods');
	/* 查询订单商品信息  */
	switch ($storage) {
		case 0 :
		$data = $db->field('goods_id, SUM(send_number) as num, MAX(extension_code) as extension_code, product_id')->where(array('order_id' => $order_id , 'is_real' => 1))->order(array('goods_id' => 'asc', 'product_id' => 'asc'))->select();
		break;

		case 1 :
		$data = $db->field('goods_id, SUM(goods_number) as num, MAX(extension_code) as extension_code, product_id')->where(array('order_id' => $order_id , 'is_real' => 1))->order(array('goods_id' => 'asc', 'product_id' => 'asc'))->select();
		break;
	}

	if (!empty($data)) {
		foreach ($data as $row) {
			if ($row['extension_code'] != "package_buy") {
				if ($is_dec) {
					change_goods_storage($row['goods_id'], $row['product_id'], - $row['num']);
				} else {
					change_goods_storage($row['goods_id'], $row['product_id'], $row['num']);
				}
			} else {
				$data = $db_package->field('goods_id, goods_number')->where('package_id = "' . $row['goods_id'] . '"')->select();
				if (!empty($data)) {
					foreach ($data as $row_goods) {
						$is_goods = $db_goods->field('is_real')->find('goods_id = "'. $row_goods['goods_id'] .'"');

						if ($is_dec) {
							change_goods_storage($row_goods['goods_id'], $row['product_id'], - ($row['num'] * $row_goods['goods_number']));
						} elseif ($is_goods['is_real']) {
							change_goods_storage($row_goods['goods_id'], $row['product_id'], ($row['num'] * $row_goods['goods_number']));
						}
					}
				}
			}
		}
	}
}

/**
* 商品库存增与减 货品库存增与减
*
* @param   int	$good_id		 商品ID
* @param   int	$product_id	  货品ID
* @param   int	$number		  增减数量，默认0；
*
* @return  bool			   true，成功；false，失败；
*/
function change_goods_storage($goods_id, $product_id, $number = 0) {
	$db_goods		= RC_Loader::load_app_model('goods_model','goods');
	$db_products	= RC_Loader::load_app_model('products_model','goods');
	if ($number == 0) {
		return true; // 值为0即不做、增减操作，返回true
	}
	if (empty($goods_id) || empty($number)) {
		return false;
	}
	/* 处理货品库存 */
	$products_query = true;
	if (!empty($product_id)) {
		$products_query = $db_products->inc('product_number','goods_id='.$goods_id.' and product_id='.$product_id,$number);
	}

	/* 处理商品库存 */
	$query = $db_goods->inc('goods_number','goods_id='.$goods_id,$number);
	if ($query && $products_query) {
		return true;
	} else {
		return false;
	}
}



/**
* 生成查询订单总金额的字段
* @param   string  $alias  order表的别名（包括.例如 o.）
* @return  string
*/
function order_amount_field($alias = '') {
	return "   {$alias}goods_amount + {$alias}tax + {$alias}shipping_fee" .
	" + {$alias}insure_fee + {$alias}pay_fee + {$alias}pack_fee" .
	" + {$alias}card_fee ";
}

/**
* 生成计算应付款金额的字段
* @param   string  $alias  order表的别名（包括.例如 o.）
* @return  string
*/
function order_due_field($alias = '') {
	return order_amount_field($alias) .
	" - {$alias}money_paid - {$alias}surplus - {$alias}integral_money" .
	" - {$alias}bonus - {$alias}discount ";
}


/**
* 取得某订单应该赠送的积分数
* @param   array   $order  订单
* @return  int	 积分数
*/
function integral_to_give($order) {
	$dbview = RC_Loader::load_app_model('order_order_goods_viewmodel','orders');
    /* 判断是否团购 */
// 	TODO:团购暂时注释给的固定参数
	$order['extension_code'] = '';
    if ($order['extension_code'] == 'group_buy') {
		RC_Loader::load_app_func('admin_goods', 'goods');
        $group_buy = group_buy_info(intval($order['extension_id']));
        return array('custom_points' => $group_buy['gift_integral'], 'rank_points' => $order['goods_amount']);
    } else {
    	$dbview->view = array(
    		'goods' => array(
    			'type'  => Component_Model_View::TYPE_LEFT_JOIN,
    			'alias' => 'g',
   				'field' => 'SUM(o.goods_number * IF(g.give_integral > -1, g.give_integral, o.goods_price)) AS custom_points, SUM(o.goods_number * IF(g.rank_integral > -1, g.rank_integral, o.goods_price)) AS rank_points',
    			'on'    => 'o.goods_id = g.goods_id ',
    		)
    	);
    	return $dbview->find(array('o.order_id' => $order[order_id] , 'o.goods_id' => array('gt' => 0 ) , 'o.parent_id' => 0 , 'o.is_gift' => 0 , 'o.extension_code' => array('neq' => 'package_buy')));
    }
}

/**
* 发红包：发货时发红包
* @param   int	 $order_id   订单号
* @return  bool
*/
function send_order_bonus($order_id) {
	RC_Loader::load_app_func('global', 'goods');
	$db		=  RC_Loader::load_app_model('user_bonus_model', 'bonus');
	$dbview	=  RC_Loader::load_app_model('order_info_viewmodel', 'orders');
	/* 取得订单应该发放的红包 */
	$bonus_list = order_bonus($order_id);

	/* 如果有红包，统计并发送 */
	if ($bonus_list) {
		/* 用户信息 */
		$dbview->view = array(
			'users' => array(
				'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'	=> 'u',
				'field'	=> 'u.user_id, u.user_name, u.email',
				'on'	=> 'o.user_id = u.user_id ',
			)
		);
		$user = $dbview->find(array('o.order_id' => $order_id));

		/* 统计 */
		$count = 0;
		$money = '';
		foreach ($bonus_list AS $bonus) {
			$count += $bonus['number'];
			$money .= price_format($bonus['type_money']) . ' [' . $bonus['number'] . '], ';

			/* 修改用户红包 */
			$data = array(
				'bonus_type_id' => $bonus['type_id'],
				'user_id'	    => $user['user_id']
				);

			for ($i = 0; $i < $bonus['number']; $i++) {
				if(!$db->insert($data)) {
					return $db->errorMsg();
				}
			}
		}

		/* 如果有红包，发送邮件 */
		if ($count > 0) {
			$tpl_name = 'send_bonus';
			$tpl   = RC_Api::api('mail', 'mail_template', $tpl_name);
			ecjia_admin::$controller->assign('user_name'	, $user['user_name']);
			ecjia_admin::$controller->assign('count'		, $count);
			ecjia_admin::$controller->assign('money'		, $money);
			ecjia_admin::$controller->assign('shop_name'	, ecjia::config('shop_name'));
			ecjia_admin::$controller->assign('send_date'	, RC_Time::local_date(ecjia::config('date_format')));

			$content = ecjia_admin::$controller->fetch_string($tpl['template_content']);
			RC_Mail::send_mail($user['user_name'], $user['email'] , $tpl['template_subject'], $content, $tpl['is_html']);
		}
	}

	return true;
}

/**
* 返回订单发放的红包
* @param   int	 $order_id   订单id
*/
function return_order_bonus($order_id) {
	$db	=  RC_Loader::load_app_model('user_bonus_model','bonus');
	/* 取得订单应该发放的红包 */
	$bonus_list = order_bonus($order_id);

	/* 删除 */
	if ($bonus_list) {
		/* 取得订单信息 */
		$order = order_info($order_id);
		$user_id = $order['user_id'];
		foreach ($bonus_list AS $bonus) {
			$db->where(array('bonus_type_id' => $bonus[type_id] , 'user_id' => $user_id , 'order_id' => 0))->limit($bonus['number'])->delete();
		}
	}
}

/**
* 取得订单应该发放的红包
* @param   int	 $order_id   订单id
* @return  array
*/
function order_bonus($order_id) {
	$db_bonus_type	= RC_Loader::load_app_model('bonus_type_model','bonus');
	$db_order_info	= RC_Loader::load_app_model('order_info_model','orders');
	$dbview			= RC_Loader::load_app_model('order_order_goods_viewmodel','orders');

	/* 查询按商品发的红包 */
	$day	= getdate();
	$today	= RC_Time::local_mktime(23, 59, 59, $day['mon'], $day['mday'], $day['year']);

	$dbview->view = array(
		'goods' => array(
			'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
			'alias'	=> 'g',
			'field'	=> 'b.type_id, b.type_money, SUM(o.goods_number) AS number',
			'on'	=> 'o.goods_id = g.goods_id',
		),
		'bonus_type' => array(
			'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
			'alias'	=> 'b',
			'on'	=> 'g.bonus_type_id = b.type_id ',
		)
	);

	$list = $dbview->where(array('o.order_id' => $order_id , 'o.is_gift' => 0 , 'b.send_type' => SEND_BY_GOODS , 'b.send_start_date' => array('elt' => $today) , 'b.send_end_date' => array('egt' => $today)))->group('b.type_id')->select();
	/* 查询定单中非赠品总金额 */
	$amount = order_amount($order_id, false);

	/* 查询订单日期 */
	$order_time = $db_order_info->where(array('order_id' => $order_id))->get_field('add_time');
	/* 查询按订单发的红包 */
	$data = $db_bonus_type->field('type_id, type_money, IFNULL(FLOOR('.$amount.' / min_amount), 1)|number')->where(array('send_type' => SEND_BY_ORDER , 'send_start_date' => array('elt' => $order_time) ,  'send_end_date' => array('egt' => $order_time)))->select();
	$list = array_merge($list, $data);
	return $list;
}


/**
* 得到新发货单号
* @return  string
*/
function get_delivery_sn() {
	/* 选择一个随机的方案 */
	mt_srand((double) microtime() * 1000000);
	return date('YmdHi') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
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
function order_action($order_sn, $order_status, $shipping_status, $pay_status, $note = '', $username = null, $place = 0) {
	$db_action = RC_Loader::load_app_model ( 'order_action_model', 'orders' );
	$db_info   = RC_Loader::load_app_model ( 'order_info_model', 'orders' );
	if (is_null ( $username )) {
		$username = $_SESSION ['admin_name'];
	}

	$row = $db_info->field('order_id')->find(array('order_sn' => $order_sn));
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
	$db_action->insert($data);
}

/**
* 获得指定的商品属性
* @access	  public
* @param	   array	   $arr		规格、属性ID数组
* @param	   type		$type	   设置返回结果类型：pice，显示价格，默认；no，不显示价格
* @return	  string
*/
function get_goods_attr_info($arr, $type = 'pice') {
	$dbview = RC_Loader::load_app_model('goods_attr_viewmodel','goods');
    $attr   = '';
    if (!empty($arr)) {
        $fmt = "%s:%s[%s] \n";

       $dbview->view =array(
			'attribute' => array(
			     'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				 'alias' 	=> 'a',
				 'field' 	=> 'a.attr_name, ga.attr_value, ga.attr_price',
				 'on' 		=> 'a.attr_id = ga.attr_id'
			)
		);
        $data = $dbview->in(array('ga.goods_attr_id'=> $arr))->select();

        if(!empty($data)) {
	        foreach ($data as $row) {
	            $attr_price = round(floatval($row['attr_price']), 2);
	            $attr .= sprintf($fmt, $row['attr_name'], $row['attr_value'], $attr_price);
	        }
        }
        $attr = str_replace('[0]', '', $attr);
    }
    return $attr;
}

/**
* 取得收货人信息
* @param   int	 $user_id	用户编号
* @return  array
*/
function get_consignee($user_id) {
	$dbview = RC_Loader::load_app_model('user_address_user_viewmodel','user');

	if (isset($_SESSION['flow_consignee'])) {
		/* 如果存在session，则直接返回session中的收货人信息 */
		return $_SESSION['flow_consignee'];
	} else {
		/* 如果不存在，则取得用户的默认收货人信息 */
		$arr = array();
		if ($user_id > 0) {
			/* 取默认地址 */
			$arr = $dbview->join('users')->find(array('u.user_id' => $user_id));
		}
		return $arr;
	}
}

/**
* 检查收货人信息是否完整
* @param   array   $consignee  收货人信息
* @param   int	 $flow_type  购物流程类型
* @return  bool	true 完整 false 不完整
*/
function check_consignee_info($consignee, $flow_type) {
	$db = RC_Loader::load_app_model('region_model','shipping');
    if (exist_real_goods(0, $flow_type)) {
        /* 如果存在实体商品 */
        $res = !empty($consignee['consignee']) &&
            !empty($consignee['country']) &&
            !empty($consignee['email']) &&
            !empty($consignee['tel']);

        if ($res) {
            if (empty($consignee['province'])) {
                /* 没有设置省份，检查当前国家下面有没有设置省份 */
                $pro = $db->get_regions(1, $consignee['country']);
                $res = empty($pro);
            } elseif (empty($consignee['city'])) {
                /* 没有设置城市，检查当前省下面有没有城市 */
                $city = $db->get_regions(2, $consignee['province']);
                $res = empty($city);
            } elseif (empty($consignee['district'])) {
                $dist = $db->get_regions(3, $consignee['city']);
                $res = empty($dist);
            }
        }
        return $res;
    } else {
        /* 如果不存在实体商品 */
        return !empty($consignee['consignee']) &&
            !empty($consignee['email']) &&
            !empty($consignee['tel']);
    }
}

/**
* 获得上一次用户采用的支付和配送方式
*
* @access  public
* @return  void
*/
function last_shipping_and_payment() {
	$db_order = RC_Loader::load_app_model('order_info_model','orders');
	$row = $db_order->field('shipping_id, pay_id')->order('order_id DESC')->find(array('user_id' => $_SESSION['user_id']));
    if (empty($row)) {
        /* 如果获得是一个空数组，则返回默认值 */
        $row = array('shipping_id' => 0, 'pay_id' => 0);
    }
    return $row;
}

/**
* 检查礼包内商品的库存
* @return  boolen
*/
function judge_package_stock($package_id, $package_num = 1) {
	$db_package_goods 	= RC_Loader::load_app_model('package_goods_model','goods');
	$db_products_view 	= RC_Loader::load_app_model('products_viewmodel','goods');
	$db_goods_view 		= RC_Loader::load_app_model('goods_auto_viewmodel','goods');

	$row = $db_package_goods->field('goods_id, product_id, goods_number')->where(array('package_id' => $package_id))->select();
    if (empty($row)) {
        return true;
    }

    /* 分离货品与商品 */
    $goods = array('product_ids' => '', 'goods_ids' => '');
    foreach ($row as $value) {
        if ($value['product_id'] > 0) {
            $goods['product_ids'] .= ',' . $value['product_id'];
            continue;
        }
        $goods['goods_ids'] .= ',' . $value['goods_id'];
    }

    /* 检查货品库存 */
    if ($goods['product_ids'] != '') {
    	$row = $db_products_view->join('package_goods')->where(array('pg.package_id' => $package_id , 'pg.goods_number' * $package_num => array('gt' => 'p.product_number')))->in(array('p.product_id' => trim($goods['product_ids'], ',')))->select();
        if (!empty($row)) {
            return true;
        }
    }

    /* 检查商品库存 */
    if ($goods['goods_ids'] != '') {
    	$db_goods_view->view = array(
    		'package_goods' => array(
    			'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
    			'alias'	=> 'pg',
    			'field' => 'g.goods_id',
    			'on' 	=> 'pg.goods_id = g.goods_id'
    		)
    	);
    	$row = $db_goods_view->where(array('pg.goods_number' * $package_num => array('gt' => 'g.goods_number')  , 'pg.package_id' => $package_id))->in(array('pg.goods_id' => trim($goods['goods_ids'] , ',')))->select();
        if (!empty($row)) {
            return true;
        }
    }
    return false;
}

/**
 * 获取指订单的详情
 *
 * @access public
 * @param int $order_id
 *            订单ID
 * @param int $user_id
 *            用户ID
 *
 * @return arr $order 订单所有信息的数组
 */
function get_order_detail ($order_id, $user_id = 0)
{
    $db         = RC_Loader::load_app_model('shipping_model', 'shipping');
    $dbview     = RC_Loader::load_app_model('package_goods_viewmodel', 'goods');
    $pay_method = RC_Loader::load_app_class('payment_method', 'payment');

    $order_id = intval($order_id);
    if ($order_id <= 0) {
        return new ecjia_error(8, 'fail');
        return false;
    }
    $order = order_info($order_id);

    // 检查订单是否属于该用户
    if ($user_id > 0 && $user_id != $order['user_id']) {
        return new ecjia_error(8, 'fail');
        return false;
    }

    /* 对发货号处理 */
    if (! empty($order['invoice_no'])) {
        $shipping_code = $db->field('shipping_code')->find('shipping_id = ' . $order[shipping_id] . '');
        $shipping_code = $shipping_code['shipping_code'];
    }

    /* 只有未确认才允许用户修改订单地址 */
    if ($order['order_status'] == OS_UNCONFIRMED) {
        $order['allow_update_address'] = 1; // 允许修改收货地址
    } else {
        $order['allow_update_address'] = 0;
    }

    /* 获取订单中实体商品数量 */
    $order['exist_real_goods'] = exist_real_goods($order_id);

    // 获取需要支付的log_id
    $order['log_id'] = $pay_method->get_paylog_id($order['order_id'], $pay_type = PAY_ORDER);

    $order['user_name'] = $_SESSION['user_name'];
    /* 无配送时的处理 */
    $order['shipping_id'] == - 1 and $order['shipping_name'] = RC_Lang::get('store::store.shipping_not_need');

    /* 其他信息初始化 */
    $order['how_oos_name'] = $order['how_oos'];
    $order['how_surplus_name'] = $order['how_surplus'];

    /* 虚拟商品付款后处理 */
    if ($order['pay_status'] != PS_UNPAYED) {
        /* 取得已发货的虚拟商品信息 */
        $virtual_goods = get_virtual_goods($order_id, true);
        $virtual_card = array();
        foreach ($virtual_goods as $code => $goods_list) {
            /* 只处理虚拟卡 */
            if ($code == 'virtual_card') {
                foreach ($goods_list as $goods) {
                    $info = virtual_card_result($order['order_sn'], $goods);
                    if ($info) {
                        $virtual_card[] = array(
                            'goods_id' => $goods['goods_id'],
                            'goods_name' => $goods['goods_name'],
                            'info' => $info
                        );
                    }
                }
            }
            /* 处理超值礼包里面的虚拟卡 */
            if ($code == 'package_buy') {
                foreach ($goods_list as $goods) {
                    $dbview->view = array(
                        'goods' => array(
                            'type'  => Component_Model_View::TYPE_LEFT_JOIN,
                            'alias' => 'g',
                            'field' => 'g.goods_id',
                            'on'    => 'pg.goods_id = g.goods_id'
                        )
                    );

                    $vcard_arr = $dbview->where('pg.package_id = ' . $goods['goods_id'] . ' AND extension_code = "virtual_card" ')->select();
                    if (! empty($vcard_arr)) {
                        foreach ($vcard_arr as $val) {
                            $info = virtual_card_result($order['order_sn'], $val);
                            if ($info) {
                                $virtual_card[] = array(
                                    'goods_id'      => $goods['goods_id'],
                                    'goods_name'    => $goods['goods_name'],
                                    'info'          => $info
                                );
                            }
                        }
                    }
                }
            }
        }
        $var_card = deleteRepeat($virtual_card);
        ecjia_front::$controller->assign('virtual_card', $var_card);
    }

    /* 确认时间 支付时间 发货时间 */
    if ($order['confirm_time'] > 0 && ($order['order_status'] == OS_CONFIRMED || $order['order_status'] == OS_SPLITED || $order['order_status'] == OS_SPLITING_PART)) {
        $order['confirm_time'] = sprintf(RC_Lang::get('store::store.confirm_time'), RC_Time::local_date(ecjia::config('time_format'), $order['confirm_time']));
    } else {
        $order['confirm_time'] = '';
    }
    if ($order['pay_time'] > 0 && $order['pay_status'] != PS_UNPAYED) {
        $order['pay_time'] = sprintf(RC_Lang::get('store::store.pay_time'), RC_Time::local_date(ecjia::config('time_format'), $order['pay_time']));
    } else {
        $order['pay_time'] = '';
    }
    if ($order['shipping_time'] > 0 && in_array($order['shipping_status'], array(
        SS_SHIPPED,
        SS_RECEIVED
    ))) {
        $order['shipping_time'] = sprintf(RC_Lang::get('store::store.shipping_time'), RC_Time::local_date(ecjia::config('time_format'), $order['shipping_time']));
    } else {
        $order['shipping_time'] = '';
    }

    return $order;
}

/**
 * 返回虚拟卡信息
 *
 * @access public
 * @param
 *
 * @return void
 */
function virtual_card_result($order_sn, $goods) {
	$db = RC_Loader::load_app_model ( 'virtual_card_model', 'goods' );

	$res = $db->field ('card_sn, card_password, end_date, crc32')->where(array('goods_id' => $goods [goods_id], 'order_sn' => $order_sn))->select ();
	$cards = array ();
	if (! empty ( $res )) {
		$auth_key = ecjia_config::instance()->read_config('auth_key');
		foreach ( $res as $row ) {
			/* 卡号和密码解密 */
			if ($row ['crc32'] == 0 || $row ['crc32'] == crc32 ( $auth_key )) {
				$row ['card_sn']        = RC_Crypt::decrypt ( $row ['card_sn'] );
				$row ['card_password']  = RC_Crypt::decrypt ( $row ['card_password'] );
			}  else {
				$row ['card_sn']        = '***';
				$row ['card_password']  = '***';
			}

			$cards [] = array (
					'card_sn'          => $row ['card_sn'],
					'card_password'    => $row ['card_password'],
					'end_date'         => date ( ecjia::config('date_format'), $row ['end_date'] )
			);
		}
	}
	return $cards;
}

/**
 * 去除虚拟卡中重复数据
 */
function deleteRepeat ($array)
{
	$_card_sn_record = array();
	foreach ($array as $_k => $_v) {
		foreach ($_v['info'] as $__k => $__v) {
			if (in_array($__v['card_sn'], $_card_sn_record)) {
				unset($array[$_k]['info'][$__k]);
			} else {
				array_push($_card_sn_record, $__v['card_sn']);
			}
		}
	}
	return $array;
}

//TODO:从api中移入的func
/**
 * 取得订单商品
 * @param   int     $order_id   订单id
 * @return  array   订单商品数组
 */
function EM_order_goods($order_id , $page=1 , $pagesize = 10)
{
	$dbview = RC_Loader::load_app_model('order_goods_goods_viewmodel', 'orders');
	$res = $dbview->join('goods')->where(array('o.order_id' => $order_id))->limit(($page-1)*$pagesize,$pagesize)->select();
	if (!empty($res)) {
		foreach ($res as $row) {
			if ($row['extension_code'] == 'package_buy') {
				$row['package_goods_list'] = get_package_goods($row['goods_id']);
			}
			$goods_list[] = $row;
		}
	}
	return $goods_list;
}


/**
 * 生成查询订单的sql
 * @param   string  $type   类型
 * @param   string  $alias  order表的别名（包括.例如 o.）
 * @return  string
 */
function EM_order_query_sql($type = 'finished', $alias = '') {
	RC_Loader::load_app_func('global', 'goods');
	$payment_method = RC_Loader::load_app_class('payment_method', 'payment');
	/* 已完成订单 */
	if ($type == 'finished') {
		return " AND {$alias}order_status " . db_create_in(array(OS_CONFIRMED, OS_SPLITED)) .
		" AND {$alias}shipping_status " . db_create_in(array(SS_SHIPPED, SS_RECEIVED)) .
		" AND {$alias}pay_status " . db_create_in(array(PS_PAYED, PS_PAYING)) . " ";
	} elseif ($type == 'await_ship') {
		/* 待发货订单 */
		return " AND   {$alias}order_status " .
		db_create_in(array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART)) .
		" AND   {$alias}shipping_status " .
		db_create_in(array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING)) .
		" AND ( {$alias}pay_status " . db_create_in(array(PS_PAYED, PS_PAYING)) . " OR {$alias}pay_id " . db_create_in($payment_method->payment_id_list(true)) . ") ";
	} elseif ($type == 'await_pay') {
		/* 待付款订单 */
		return " AND   {$alias}order_status " . db_create_in(array(OS_CONFIRMED, OS_SPLITED, OS_UNCONFIRMED)) .
			" AND   {$alias}pay_status = '" . PS_UNPAYED . "'" .
			" AND ( {$alias}shipping_status " . db_create_in(array(SS_SHIPPED, SS_RECEIVED)) . " OR {$alias}pay_id " . db_create_in($payment_method->payment_id_list(false)) . ") ";
	} elseif ($type == 'unconfirmed') {
		/* 未确认订单 */
		return " AND {$alias}order_status = '" . OS_UNCONFIRMED . "' ";
	} elseif ($type == 'unprocessed') {
			/* 未处理订单：用户可操作 */
		return " AND {$alias}order_status " . db_create_in(array(OS_UNCONFIRMED, OS_CONFIRMED)) .
		" AND {$alias}shipping_status = '" . SS_UNSHIPPED . "'" .
		" AND {$alias}pay_status = '" . PS_UNPAYED . "' ";
	} elseif ($type == 'unpay_unship') {
	/* 未付款未发货订单：管理员可操作 */
		return " AND {$alias}order_status " . db_create_in(array(OS_UNCONFIRMED, OS_CONFIRMED)) .
		" AND {$alias}shipping_status " . db_create_in(array(SS_UNSHIPPED, SS_PREPARING)) .
			" AND {$alias}pay_status = '" . PS_UNPAYED . "' ";
	} elseif ($type == 'shipped') {
		/* 已发货订单：不论是否付款 */
		return " AND {$alias}shipping_status " . db_create_in(array(SS_SHIPPED)) . " ";
	} else {
		die('函数 order_query_sql 参数错误');
	}
}

// end