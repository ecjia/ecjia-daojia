<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 收银台添加购物流
 * @author zrl
 *
 */
class checkOrder_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
        if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
        define('SESS_ID', RC_Session::session()->getSessionKey());
        
        RC_Loader::load_app_class('cart', 'cart', false);
        
        $device = $this->device;
		RC_Loader::load_app_func('global','cart');
		RC_Loader::load_app_func('cart','cart');
		RC_Loader::load_app_func('admin_order','orders');
		RC_Loader::load_app_func('admin_bonus','bonus');
		$db_cart = RC_Loader::load_app_model('cart_model', 'cart');
		
		//从移动端接收数据
		$addgoods		= $this->requestData('addgoods');	//添加商品
		$updategoods	= $this->requestData('updategoods');	//更新商品数量
		$deletegoods	= $this->requestData('deletegoods');	//删除商品
		$user			= $this->requestData('user');		//选择用户
		
		//选择用户
		if (!empty($user)) {
			$user_id = (empty($user['user_id']) || !isset($user['user_id'])) ? 0 : $user['user_id'];
			if ($user_id > 0) {
				$_SESSION['cashdesk_temp_user_id']	= $user_id;
				$_SESSION['user_id']		= $user_id;
				//$db_cart->where(array('session_id' => SESS_ID))->update(array('user_id' => $user_id));
				//$row = RC_Model::model('user/users_model')->find(array('user_id' => $_SESSION['user_id']));
				RC_DB::table('cart')->where('session_id', SESS_ID)->update(array('user_id' => $user_id));
				$row = RC_DB::table('users')->where('user_id', $_SESSION['user_id'])->first();
				
				if ($row) {
					/* 判断是否是特殊等级，可能后台把特殊会员组更改普通会员组 */
					if ($row['user_rank'] > 0) {
						//$special_rank = RC_Model::model('user/user_rank_model')->where(array('rank_id' => $row['user_rank']))->get_field('special_rank');
						$special_rank = RC_DB::table('user_rank')->where('rank_id', $row['user_rank'])->pluck('special_rank');
						if ($special_rank == '0' || $special_rank == null) {
							$data = array(
									'user_rank' => '0'
							);
							//RC_Model::model('user/users_model')->where(array('user_id' => $_SESSION['user_id']))->update($data);
							RC_DB::table('users')->where('user_id', $_SESSION['user_id'])->update($data);
							$row['user_rank'] = 0;
						}
					}
						
					/* 取得用户等级和折扣 */
					if ($row['user_rank'] == 0) {
						// 非特殊等级，根据等级积分计算用户等级（注意：不包括特殊等级）
						//$row = RC_Model::model('user/user_rank_model')->field('rank_id, discount')->find('special_rank = "0" AND min_points <= "' . intval($row['rank_points']) . '" AND max_points > "' . intval($row['rank_points']) . '"');
						$row = RC_DB::table('user_rank')->where('special_rank', 0)->where('min_points', '<=', intval($row['rank_points']))->where('max_points', '>=', intval($row['rank_points']))->first();
						if ($row) {
							$_SESSION['user_rank']	= $row['rank_id'];
							$_SESSION['discount']	= $row['discount'] / 100.00;
						} else {
							$_SESSION['user_rank']	= 0;
							$_SESSION['discount']	= 1;
						}
					} else {
						// 特殊等级
						//$row = RC_Model::model('user/user_rank_model')->field('rank_id, discount')->find(array('rank_id' => $row['user_rank']));
						$row = RC_DB::table('user_rank')->where('rank_id', $row['user_rank'])->first();
						if ($row) {
							$_SESSION['user_rank']	= $row['rank_id'];
							$_SESSION['discount']	= $row['discount'] / 100.00;
						} else {
							$_SESSION['user_rank']	= 0;
							$_SESSION['discount']	= 1;
						}
					}
				}
			} else {
				unset($_SESSION['cashdesk_temp_user_id']);
				unset($_SESSION['user_id']);
				$_SESSION['user_rank']	= 0;
				$_SESSION['discount']	= 1;
			}
			recalculate_price($device);
		}
		
		/* 取得购物类型 */
		$flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;
	    /*收银台商品购物车类型*/
		$codes = array('8001', '8011');
	    if (!empty($device) && in_array($device['code'], $codes)) {
	    	$flow_type = CART_CASHDESK_GOODS;
	    }
		
		if (!empty($addgoods)) {
			$products_db = RC_Loader::load_app_model('products_model', 'goods');
			$goods_db = RC_Loader::load_app_model('goods_model', 'goods');
			$goods_spec = array();
			
			$products_goods = $products_db->where(array('product_sn' => $addgoods['goods_sn']))->find();
			if (!empty($products_goods)) {
				$goods_spec = explode('|', $products_goods['goods_attr']);
				$where = array('goods_id' => $products_goods['goods_id']);
				if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
					$where['store_id'] = $_SESSION['store_id'];
				}
				$goods = $goods_db->where($where)->find();
			} else {
				$where = array('goods_sn' => $addgoods['goods_sn']);
				if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
					$where['store_id'] = $_SESSION['store_id'];
				}
				$goods = $goods_db->where($where)->find();
			}
			if (empty($goods)) {
				return new ecjia_error('addgoods_error', '该商品不存在或已下架');
			}
			$result = addto_cart($goods['goods_id'], $addgoods['number'], $goods_spec, 0, 0, 0, strlen($addgoods['goods_sn']) == 7 ? $addgoods['price'] : 0, strlen($addgoods['goods_sn']) == 7 ? $addgoods['weight'] : 0, $device);
			
			if (is_ecjia_error($result)) {
				return $result;
			}
		}
		//编辑购物车商品
		if (!empty($updategoods)) {
			//$result = updatecart($updategoods);
			$result = flow_update_cart(array($updategoods['rec_id'] => $updategoods['number']));
		}
		//删除购物车商品
		if (!empty($deletegoods)) {
			$result = deletecart($deletegoods);
		}
		
		if (is_ecjia_error($result)) {
		    return $result;
		}
		
		
		/* 对商品信息赋值 */
		$cart_goods = cart_goods($flow_type); // 取得商品列表，计算合计
	
		/* 取得订单信息*/
		$order = flow_order_info();
		/* 计算折扣 */
		if ($flow_type != CART_EXCHANGE_GOODS && $flow_type != CART_GROUP_BUY_GOODS) {
			$discount = compute_discount();
			$favour_name = empty($discount['name']) ? '' : join(',', $discount['name']);
		}
		/* 计算订单的费用 */
		$total = cashdesk_order_fee($order, $cart_goods, $consignee);
	
// 		/* 取得支付列表 */
// 		$cod_fee    = 0;
// 		$payment_method = RC_Loader::load_app_class('payment_method', 'payment');
// 		// 给货到付款的手续费加<span id>，以便改变配送的时候动态显示
// 		$payment_list = $payment_method->available_payment_list(1, $cod_fee);
		if (!empty($_SESSION['user_id'])) {
			$user_info = user_info($_SESSION['user_id']);
			if (is_ecjia_error($user_info)) {
				return $user_info;
			}
		}
		
		
		$out = array();
		$out['user_info'] = array();
		if (isset($_SESSION['user_id']) && $_SESSION['user_id']) {
			$user_info = RC_Model::model('user/users_model')->find(array('user_id' => $_SESSION['user_id']));
			$out['user_info'] = array(
					'user_id'	=> intval($user_info['user_id']),
					'user_name'	=> $user_info['user_name'],
					'mobile'	=> $user_info['mobile_phone'],
					'integral'	=> intval($user_info['pay_points']),
			);
		}
		
		$out['goods_list']		= $cart_goods;		//商品
// 		$out['consignee']		= $consignee;		//收货地址
// 		$out['shipping_list']	= $shipping_list;	//快递信息
// 		$out['payment_list']	= $payment_list;
		/* 如果使用积分，取得用户可用积分及本订单最多可以使用的积分 */
		$rec_ids = array();
		/*会员价处理*/
		if (!empty($cart_goods)) {
			RC_Loader::load_app_class('goods_info', 'goods', false);
			foreach ($cart_goods as $k => $v) {
				$rec_ids[] = $v['rec_id'];
			}
		}
		
		if ((ecjia::config('use_integral', ecjia::CONFIG_CHECK) || ecjia::config('use_integral') == '1')
		&& $_SESSION['user_id'] > 0
		&& $user_info['pay_points'] > 0
		&& ($flow_type != CART_GROUP_BUY_GOODS && $flow_type != CART_EXCHANGE_GOODS))
		{
			// 能使用积分
			$allow_use_integral = 1;
			$order_max_integral = cart::flow_available_points($rec_ids, $device);
		} else {
			$allow_use_integral = 0;
			$order_max_integral = 0;
		}
		
		$out['allow_use_integral'] = $allow_use_integral;//积分 是否使用积分
		$out['order_max_integral'] = $order_max_integral;//订单最大可使用积分
		/* 如果使用红包，取得用户可以使用的红包及用户选择的红包 */
		$allow_use_bonus = 0;
		if ((ecjia::config('use_bonus', ecjia::CONFIG_CHECK) || ecjia::config('use_bonus') == '1')
				&& ($flow_type != CART_GROUP_BUY_GOODS && $flow_type != CART_EXCHANGE_GOODS)){
			// 取得用户可用红包
			$user_bonus = user_bonus($_SESSION['user_id'], $total['goods_price'], array(), $_SESSION['store_id']);
			if (!empty($user_bonus)) {
				foreach ($user_bonus AS $key => $val) {
					$user_bonus[$key]['bonus_money_formated'] = price_format($val['type_money'], false);//use_start_date  use_end_date
					$user_bonus[$key]['use_start_date_formated'] = RC_Time::local_date(ecjia::config('date_format'), $val['use_start_date']);
					$user_bonus[$key]['use_end_date_formated'] = RC_Time::local_date(ecjia::config('date_format'), $val['use_end_date']);
					$user_bonus[$key]['min_amount'] = $val['min_goods_amount'];
					$user_bonus[$key]['label_min_amount'] = '满'.$val['min_goods_amount'].'可使用';
				}
				$bonus_list = $user_bonus;
			}
			// 能使用红包
			$allow_use_bonus = 1;
		}
		$out['allow_use_bonus'] = $allow_use_bonus;//是否使用红包
		$out['bonus'] 			= $bonus_list;//红包
		$out['your_integral']	= $user_info['pay_points'];//用户可用积分
		
		$out['discount']		= number_format($discount['discount'], 2, '.', '');//用户享受折扣数
		$out['discount_formated'] = $total['discount_formated'];
				
		if (!empty($out['payment_list'])) {
			foreach ($out['payment_list'] as $key => $value) {
				unset($out['payment_list'][$key]['pay_config']);
				unset($out['payment_list'][$key]['pay_desc']);
				$out['payment_list'][$key]['pay_name'] = strip_tags($value['pay_name']);
				// cod 货到付款，alipay支付宝，bank银行转账
				if (in_array($value['pay_code'], array('post', 'balance'))) {
					unset($out['payment_list'][$key]);
				}
			}
			$out['payment_list'] = array_values($out['payment_list']);
		}
					
		if (!empty($out['goods_list'])) {
			foreach ($out['goods_list'] as $key => $value) {
				if (!empty($value['goods_attr'])) {
					$goods_attr = explode("\n", $value['goods_attr']);
					$goods_attr = array_filter($goods_attr);
					$out['goods_list'][$key]['goods_attr'] = array();
					foreach ($goods_attr as  $v) {
						$a = explode(':',$v);
						if (!empty($a[0]) && !empty($a[1])) {
							$out['goods_list'][$key]['goods_attr'][] = array('name' => $a[0], 'value' => $a[1]);
						}
					}
				}
			}
		}
		//EM_API::outPut($out);
		return $out;
	}		
}

//存在，更新(编辑)到购物车
function updatecart($updategoods){
	$db_carts = RC_Loader::load_app_model('cart_model', 'cart');
	$data	= array(
		'goods_number'	=>	$updategoods['number']
	);
	$count = $db_carts->where(array('rec_id' => $updategoods['rec_id']))->update($data);
	if($count>0){
		return true;
	}
}
//删除购物车商品(购物车可以批量删除)
function deletecart($deletegoods){
	$db_cart = RC_Loader::load_app_model('cart_model', 'cart');
	$rec_id = explode(',', $deletegoods['rec_id']);
	$db_cart->in(array('rec_id'=> $rec_id))->delete();
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
function cashdesk_order_fee($order, $goods, $consignee) {
	RC_Loader::load_app_func('common','goods');
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

		//散装价格x重量（数量/1000）
		if ($val['extension_code'] == 'bulk') {
		    $total['goods_price']  += $val['goods_price'] * $val['goods_number'] / 1000;
		    $total['goods_price'] = formated_price_bulk($total['goods_price']);
		    $total['market_price'] += $val['market_price'] * $val['goods_number'] / 1000;
		    $total['market_price'] = formated_price_bulk($total['market_price']);
		} else {
		    $total['goods_price']  += $val['goods_price'] * $val['goods_number'];
		    $total['market_price'] += $val['market_price'] * $val['goods_number'];
		}
		
		$area_id = $consignee['province'];
		//多店铺开启库存管理以及地区后才会去判断
// 		if ( $area_id > 0 && $shop_type == 'b2b2c') {
// 			$warehouse_db = RC_Loader::load_app_model('warehouse_model', 'warehouse');
// 			$warehouse = $warehouse_db->where(array('regionId' => $area_id))->find();

// 			$warehouse_id = $warehouse['parent_id'];
// 			$goods[$key]['warehouse_id'] = $warehouse_id;
// 			$goods[$key]['area_id'] = $area_id;
// 		} else {
// 			$goods[$key]['warehouse_id'] = 0;
// 			$goods[$key]['area_id'] 	 = 0;
// 		}
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

	RC_Loader::load_app_func('bonus','bonus');
	/* 红包 */
	if (!empty($order['bonus_id'])) {
		$bonus          = bonus_info($order['bonus_id']);
		$total['bonus'] = $bonus['type_money'];
	}
	$total['bonus_formated'] = price_format($total['bonus'], false);
	/* 线下红包 */
	if (!empty($order['bonus_kill'])) {

		$bonus  = bonus_info(0,$order['bonus_kill']);
		$total['bonus_kill'] = $order['bonus_kill'];
		$total['bonus_kill_formated'] = price_format($total['bonus_kill'], false);
	}

// 	TODO:暂时不考虑配送费用
// 	/* 配送费用 */
// 	$shipping_cod_fee = NULL;
// 	if ($order['shipping_id'] > 0 && $total['real_goods_count'] > 0) {
// 		$region['country']  = $consignee['country'];
// 		$region['province'] = $consignee['province'];
// 		$region['city']     = $consignee['city'];
// 		$region['district'] = $consignee['district'];

// 		$shipping_method = RC_Loader::load_app_class('shipping_method', 'shipping');
// 		$shipping_info 		= $shipping_method->shipping_area_info($order['shipping_id'], $region);

// 		if (!empty($shipping_info)) {
			 
// 			if ($order['extension_code'] == 'group_buy') {
// 				$weight_price = cart_weight_price(CART_GROUP_BUY_GOODS);
// 			} else {
// 				$weight_price = cart_weight_price();
// 			}

// 			// 查看购物车中是否全为免运费商品，若是则把运费赋为零
// 			if ($_SESSION['user_id']) {
// 				$shipping_count = $db->where(array('user_id' => $_SESSION['user_id'] , 'extension_code' => array('neq' => 'package_buy') , 'is_shipping' => 0))->count();
// 			} else {
// 				$shipping_count = $db->where(array('session_id' => SESS_ID , 'extension_code' => array('neq' => 'package_buy') , 'is_shipping' => 0))->count();
// 			}

// 			//ecmoban模板堂 --zhuo start
// 			if (ecjia::config('freight_model') == 0) {
// 				$total['shipping_fee'] = ($shipping_count == 0 AND $weight_price['free_shipping'] == 1) ? 0 :  $shipping_method->shipping_fee($shipping_info['shipping_code'],$shipping_info['configure'], $weight_price['weight'], $total['goods_price'], $weight_price['number']);
// 				//             	$total['shipping_fee'] = ($shipping_count == 0 AND $weight_price['free_shipping'] == 1) ?0 :  shipping_fee($shipping_info['shipping_code'],$shipping_info['configure'], $weight_price['weight'], $total['goods_price'], $weight_price['number']);
// 			} elseif (ecjia::config('freight_model') == 1) {
// 				$shipping_fee = get_goods_order_shipping_fee($goods, $region, $shipping_info['shipping_code']);
// 				$total['shipping_fee'] = ($shipping_count == 0 AND $weight_price['free_shipping'] == 1) ? 0 :  $shipping_fee['shipping_fee'];
// 				//             	$total['ru_list'] = $shipping_fee['ru_list']; //商家运费详细信息
// 			}

// 			//ecmoban模板堂 --zhuo end
// 			//             $total['shipping_fee'] = ($shipping_count == 0 AND $weight_price['free_shipping'] == 1) ? 0 :  $shipping_method->shipping_fee($shipping_info['shipping_code'],$shipping_info['configure'], $weight_price['weight'], $total['goods_price'], $weight_price['number']);

// 			if (!empty($order['need_insure']) && $shipping_info['insure'] > 0) {
// 				$total['shipping_insure'] = shipping_insure_fee($shipping_info['shipping_code'],$total['goods_price'], $shipping_info['insure']);
// 			} else {
// 				$total['shipping_insure'] = 0;
// 			}

// 			if ($shipping_info['support_cod']) {
// 				$shipping_cod_fee = $shipping_info['pay_fee'];
// 			}
// 		}
// 	}
	$total['shipping_fee'] = 0;
	$total['shipping_insure'] = 0;
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
