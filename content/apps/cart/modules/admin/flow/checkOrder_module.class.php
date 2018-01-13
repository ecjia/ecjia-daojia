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
		RC_Loader::load_app_func('cashdesk','cart');
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
			$result = addto_cart($goods['goods_id'], $addgoods['number'], $goods_spec, 0, 0, 0, strlen($addgoods['goods_sn']) == 7 ? $addgoods['price'] : 0, strlen($addgoods['goods_sn']) == 7 ? $addgoods['weight'] : 0, $flow_type);
			
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
			$order_max_integral = cart::flow_available_points($rec_ids, $flow_type);
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

