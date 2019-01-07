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
 * 购物流类
 * @author will.chen
 */
class cart {
	/**
	 * 更新购物车中的商品数量
	 *
	 * @access  public
	 * @param   array   $arr
	 * @return  void
	 */
	public static function flow_update_cart($arr) {
		$db_cart	  = RC_Model::model('cart/cart_model');
		$dbview		  = RC_Model::model('goods/goods_cart_viewmodel');

		$db_cart_view = RC_Model::model('cart/cart_cart_viewmodel');
		$db_products  = RC_Model::model('goods/products_model');

		RC_Loader::load_app_func('admin_order', 'orders');
		RC_Loader::load_app_func('global', 'goods');
		/* 处理 */
		
		foreach ($arr AS $key => $val) {
			$val = intval(make_semiangle($val));
			if ($val <= 0 || !is_numeric($key)) {
				continue;
			}
			
			//要更新的购物车商品对应店铺有没锁定
			$goods_id = Ecjia\App\Cart\StoreStatus::GetGoodsId($key);
			if (!empty($goods_id)) {
				$store_id 		= Ecjia\App\Cart\StoreStatus::GetStoreId($goods_id);
				$store_status 	= Ecjia\App\Cart\StoreStatus::GetStoreStatus($store_id);
				if ($store_status == Ecjia\App\Cart\StoreStatus::LOCKED) {
					return new ecjia_error('store_locked', '对不起，该商品所属的店铺已锁定！');
				}
			}
			
			//查询：
			$cart_w = array('rec_id' => $key, 'user_id' => $_SESSION['user_id']);
// 			if (defined('SESS_ID')) {
// 				$cart_w['session_id'] = SESS_ID;
// 			}
			$goods = $db_cart->field(array('goods_id', 'goods_attr_id', 'product_id', 'extension_code'))->find($cart_w);

			$row   = $dbview->join('cart')->find(array('c.rec_id' => $key));
			//查询：系统启用了库存，检查输入的商品数量是否有效
			if (intval(ecjia::config('use_storage')) > 0 && $goods['extension_code'] != 'package_buy') {
				if ($row['goods_number'] < $val) {
					return new ecjia_error('low_stocks', __('库存不足'));
				}
				/* 是货品 */
				$goods['product_id'] = trim($goods['product_id']);
				if (!empty($goods['product_id'])) {
					$product_number = $db_products->where(array('goods_id' => $goods['goods_id'] , 'product_id' => $goods['product_id']))->get_field('product_number');
					if ($product_number < $val) {
						return new ecjia_error('low_stocks', __('库存不足'));
					}
				}
			}  elseif (intval(ecjia::config('use_storage')) > 0 && $goods['extension_code'] == 'package_buy') {
				if (self::judge_package_stock($goods['goods_id'], $val)) {
					return new ecjia_error('low_stocks', __('库存不足'));
				}
			}

			/* 查询：检查该项是否为基本件 以及是否存在配件 */
			/* 此处配件是指添加商品时附加的并且是设置了优惠价格的配件 此类配件都有parent_id goods_number为1 */
			$offer_w = array(
					'a.rec_id'	=> $key,
					'a.user_id'	=> $_SESSION['user_id'],
					'a.extension_code' => array('neq' => 'package_buy'),
					'b.user_id' => $_SESSION['user_id'],
			);

// 			if (defined('SESS_ID')) {
// 				$offer_w['session_id'] = SESS_ID;
// 			}

			$offers_accessories_res = $db_cart_view->join('cart')->where($offer_w)->select();


			//订货数量大于0
			if ($val > 0) {
				/* 判断是否为超出数量的优惠价格的配件 删除*/
				$row_num = 1;
				if (!empty($offers_accessories_res)) {
					foreach ($offers_accessories_res as $offers_accessories_row) {
						if ($row_num > $val) {
							$db_cart->where(array('user_id' => $_SESSION['user_id'] , 'rec_id' => $offers_accessories_row['rec_id']))->delete();
						}
						$row_num ++;
					}
				}

				/* 处理超值礼包 */
				if ($goods['extension_code'] == 'package_buy') {
					//更新购物车中的商品数量
					$db_cart->where(array('rec_id' => $key , 'user_id' => $_SESSION['user_id'] ))->update(array('goods_number' => $val));

				}  else {
					/* 处理普通商品或非优惠的配件 */
					$attr_id    = empty($goods['goods_attr_id']) ? array() : explode(',', $goods['goods_attr_id']);
					
					//$goods_price = self::get_final_price($goods['goods_id'], $val, true, $attr_id);
					RC_Loader::load_app_class('goods_info', 'goods', false);
					$goods_price = goods_info::get_final_price($goods['goods_id'], $val, true, $attr_id);

					$db_cart->where(array('rec_id' => $key , 'user_id' => $_SESSION['user_id'] ))->update(array('goods_number' => $val , 'goods_price' => $goods_price));

				}
			} else {
				//订货数量等于0
				/* 如果是基本件并且有优惠价格的配件则删除优惠价格的配件 */
				if (!empty($offers_accessories_res)) {
					foreach ($offers_accessories_res as $offers_accessories_row) {
						$db_cart->where(array('user_id' => $_SESSION['user_id'] , 'rec_id' => $offers_accessories_row['rec_id']))->delete();
					}
				}

				$db_cart->where(array('rec_id' => $key , 'user_id' => $_SESSION['user_id']))->delete();
			}
		}

		/* 删除所有赠品 */
		$db_cart->where(array('user_id' => $_SESSION['user_id'] , 'is_gift' => array('neq' => 0)))->delete();
		return true;
	}

	/**
	 * 选中取消选中购物车中的商品
	 *
	 * @access  public
	 * @param   array $options
	 * @return  void
	 */
	public static function flow_check_cart_goods($options) {
	    //$options['id'] 整数 或 数组
	    $db_cart = RC_Model::model('cart/cart_model');
	    $dbview  = RC_Model::model('cart/cart_group_goods_goods_viewmodel');

	    if (!is_array($options['id'])) {
	        $options['id'] = explode(',', $options['id']);
	    }

	    /* 取得商品id */
	    $row = $db_cart->find(array('rec_id' => $options['id']));
	    if ($row) {

		    $db_cart->where(array('rec_id' => $options['id']))->update(array('is_checked' => $options['is_checked']));
			//如果是超值礼包
// 			if ($row['extension_code'] == 'package_buy') {

// 			} elseif ($row['parent_id'] == 0 && $row['is_gift'] == 0) {
// 				//如果是普通商品，同时删除所有赠品及其配件
// 			} else {
// 				//如果不是普通商品，只删除该商品即可
// 			}

		}
        return true;
// 		self::flow_clear_cart_alone();
	}

	/**
	 * 删除购物车中的商品
	 *
	 * @access  public
	 * @param   integer $id
	 * @return  void
	 */
	public static function flow_drop_cart_goods($id) {
		$db_cart = RC_Model::model('cart/cart_model');
		$dbview  = RC_Model::model('cart/cart_group_goods_goods_viewmodel');

		/* 取得商品id */
		$row = $db_cart->find(array('rec_id' => $id));
		if ($row) {
			//如果是超值礼包
			if ($row['extension_code'] == 'package_buy') {
				$where = array('user_id' => $_SESSION['user_id'] , 'rec_id' => $id);
// 				if (defined('SESS_ID')) {
// 					$where['session_id'] = SESS_ID;
// 				}

				$db_cart->where($where)->delete();

			} elseif ($row['parent_id'] == 0 && $row['is_gift'] == 0) {
				//如果是普通商品，同时删除所有赠品及其配件
				/* 检查购物车中该普通商品的不可单独销售的配件并删除 */
				$data = $dbview->join(array('group_goods','goods'))->field('c.rec_id')->where(array('gg.parent_id' => $row['goods_id'] , 'c.parent_id' => $row['goods_id'] , 'c.extension_code' => array('neq' => 'package_buy') , 'g.is_alone_sale' => 0))->select();

				$_del_str = $id . ',';
				if (!empty($data)) {
					foreach ($data as $id_alone_sale_goods) {
						$_del_str .= $id_alone_sale_goods['rec_id'] . ',';
					}
				}

				$_del_str = trim($_del_str, ',');
				$where = array('user_id' => $_SESSION['user_id']);
				$where[] = "(rec_id IN ($_del_str) OR parent_id = ".$row['goods_id']." OR is_gift <> 0)";

// 				if (defined('SESS_ID')) {
// 					$where['session_id'] = SESS_ID;
// 				}
				$db_cart->where($where)->delete();
			} else {
				//如果不是普通商品，只删除该商品即可
				$where = array('user_id' => $_SESSION['user_id'] , 'rec_id' => $id);

// 				if (defined('SESS_ID')) {
// 					$where['session_id'] = SESS_ID;
// 				}

				$db_cart->where($where)->delete();
			}
		}
		self::flow_clear_cart_alone();
	}

	/**
	 * 删除购物车中不能单独销售的商品
	 *
	 * @access  public
	 * @return  void
	 */
	public static function flow_clear_cart_alone() {
		/* 查询：购物车中所有不可以单独销售的配件 */
		$db_cart = RC_Model::model('cart/cart_model');
		$dbview  = RC_Model::model('cart/cart_group_goods_goods_viewmodel');

		$where = array(
			'c.user_id'			=> $_SESSION['user_id'],
			'c.extension_code'	=> array('neq' => 'package_buy'),
			'gg.parent_id'		=> array('gt' => 0) ,
			'g.is_alone_sale'	=> 0
		);

// 		if (defined('SESS_ID')) {
// 			$where['session_id'] = SESS_ID;
// 		}

		$data = $dbview->join(array('group_goods','goods'))->where($where)->select();

		$rec_id = array();
		if (!empty($data)) {
			foreach ($data as $row) {
				$rec_id[$row['rec_id']][] = $row['parent_id'];
			}
		}

		if (empty($rec_id)) {
			return;
		}

		/* 查询：购物车中所有商品 */
		$cart_w = array('user_id' => $_SESSION['user_id'] , 'extension_code' => array('neq' => 'package_buy'));
// 		if (defined('SESS_ID')) {
// 			$cart_w['session_id'] = SESS_ID;
// 		}
		$res = $db_cart->field('DISTINCT goods_id')->where($cart_w)->select();

		$cart_good = array();
		if (!empty($res)) {
			foreach ($res as $row) {
				$cart_good[] = $row['goods_id'];
			}
		}

		if (empty($cart_good)) {
			return;
		}

		/* 如果购物车中不可以单独销售配件的基本件不存在则删除该配件 */
		$del_rec_id = '';
		foreach ($rec_id as $key => $value) {
			foreach ($value as $v) {
				if (in_array($v, $cart_good)) {
					continue 2;
				}
			}
			$del_rec_id = $key . ',';
		}
		$del_rec_id = trim($del_rec_id, ',');

		if ($del_rec_id == '') {
			return;
		}

		/* 删除 */
		$del_w = array('user_id' => $_SESSION['user_id']);
// 		if (defined('SESS_ID')) {
// 			$del_w['session_id'] = SESS_ID;
// 		}
		$db_cart->where($del_w)->in(array('rec_id' => $del_rec_id))->delete();
	}

	/**
	 * 取得收货人信息
	 * @param   int	 $user_id	用户编号
	 * @return  array
	 */
	public static function get_consignee($user_id) {
		if (isset($_SESSION['flow_consignee'])) {
			/* 如果存在session，则直接返回session中的收货人信息 */
			return $_SESSION['flow_consignee'];
		} else {
			/* 如果不存在，则取得用户的默认收货人信息 */
			$arr = array();
			if ($user_id > 0) {
				/* 取默认地址 */
				$arr = Ecjia\App\User\UserAddress::UserDefaultAddressInfo($user_id);
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
	public static function check_consignee_info($consignee, $flow_type) {
		if (self::exist_real_goods(0, $flow_type)) {
			/* 如果存在实体商品 */
			$res = !empty($consignee['consignee']) &&
			!empty($consignee['country']);
			if ($res) {
				if (empty($consignee['province'])) {
					/* 没有设置省份，检查当前国家下面有没有设置省份 */
					$pro = ecjia_region::getSubarea($consignee['country']);
					$res = empty($pro);
				} elseif (empty($consignee['city'])) {
					/* 没有设置城市，检查当前省下面有没有城市 */
					$city = ecjia_region::getSubarea($consignee['province']);
					$res = empty($city);
				} elseif (empty($consignee['district'])) {
					// $dist = ecjia_region::getSubarea($consignee['city']);
					// $res = empty($dist);
					$res = true;
				}
			}
			return $res;
		} else {
			/* 如果不存在实体商品 */
			return !empty($consignee['consignee']) &&
			!empty($consignee['tel']);
		}
	}

	/**
	 * 查询购物车（订单id为0）或订单中是否有实体商品
	 * @param   int	 $order_id   订单id
	 * @param   int	 $flow_type  购物流程类型
	 * @return  bool
	 */
	public static function exist_real_goods($order_id = 0, $flow_type = CART_GENERAL_GOODS) {
		if ($order_id <= 0) {
			$where = array('user_id' => $_SESSION['user_id'] , 'is_real' => 1 , 'rec_type' => $flow_type);
// 			if (defined('SESS_ID')) {
// 				$where['session_id'] = SESS_ID;
// 			}
			$count = RC_Model::model('cart/cart_model')->where($where)->count();
		} else {
			$count = RC_Model::model('orders/order_goods_model')->where(array('order_id' => $order_id , 'is_real' => 1))->count();
		}
		return $count > 0;
	}

	/**
	 * 检查订单中商品库存
	 *
	 * @access  public
	 * @param   array   $arr
	 *
	 * @return  void
	 */
	public static function flow_cart_stock($arr) {
		foreach ($arr AS $key => $val) {
			$val = intval(make_semiangle($val));
			if ($val <= 0 || !is_numeric($key)) {
				continue;
			}
			$cart_where = array('rec_id' => $key , 'user_id' => $_SESSION['user_id']);
// 			if (defined($name)) {
// 				$cart_where['session_id'] = SESS_ID;
// 			}
			$goods = RC_Model::model('cart/cart_model')->field('goods_id, goods_attr_id, extension_code, product_id')->find($cart_where);

			$row   = RC_Model::model('goods/goods_cart_viewmodel')->field('c.product_id')->join('cart')->find(array('c.rec_id' => $key));
			//系统启用了库存，检查输入的商品数量是否有效
			if (intval(ecjia::config('use_storage')) > 0 && $goods['extension_code'] != 'package_buy') {
				if ($row['goods_number'] < $val) {
					return new ecjia_error('low_stocks', __('库存不足'));
				}
				/* 是货品 */
				$row['product_id'] = trim($row['product_id']);
				if (!empty($row['product_id'])) {
					$product_number = RC_Model::model('goods/products_model')->where(array('goods_id' => $goods['goods_id'] , 'product_id' => $goods['product_id']))->get_field('product_number');
					if ($product_number < $val) {
						return new ecjia_error('low_stocks', __('库存不足'));
					}
				}
			} elseif (intval(ecjia::config('use_storage')) > 0 && $goods['extension_code'] == 'package_buy') {
				if (self::judge_package_stock($goods['goods_id'], $val)) {
					return new ecjia_error('low_stocks', __('库存不足'));
				}
			}
		}
	}

	/**
	 * 获得用户的可用积分
	 *
	 * @access  private
	 * @return  integral
	 */
	public static function flow_available_points($cart_id = array(), $rec_type = CART_GENERAL_GOODS) {
		$cart_where = array('c.user_id' => $_SESSION['user_id'], 'c.is_gift' => 0 , 'g.integral' => array('gt' => 0) , 'c.rec_type' => $rec_type);
		if (!empty($cart_id)) {
			$cart_where = array_merge($cart_where, array('rec_id' => $cart_id));
		}

// 		if (defined('SESS_ID')) {
// 			$cart_where['c.session_id'] = SESS_ID;
// 		}

// 		$data = $db_view->join('goods')->where($cart_where)->sum('g.integral * c.goods_number');

		$total_goods_integral_money = RC_Model::model('cart/cart_goods_viewmodel')->join('goods')->where($cart_where)->sum('g.integral * c.goods_number');
		//购物车商品总价
		$total_goods_price = RC_Model::model('cart/cart_goods_viewmodel')->join('goods')->where($cart_where)->sum('c.goods_price * c.goods_number');
		//取价格最小值，防止积分抵扣超过商品价格(并未计算优惠)
		$val_min = min($total_goods_integral_money, $total_goods_price);
		if ($val_min < 1 && $val_min > 0) {
			$val = $val_min;
		} else {
			$val = intval($val_min);
		}
		return self::integral_of_value($val);
	}
	
	/**
	 * 计算指定的金额需要多少积分
	 *
	 * @access  public
	 * @param   integer $value  金额
	 * @return  void
	 */
	public static function integral_of_value($value) {
		$scale = floatval(ecjia::config('integral_scale'));
		return $scale > 0 ? round($value / $scale * 100) : 0;
	}

	/**
	 * 计算积分的价值（能抵多少钱）
	 * @param   int	 $integral   积分
	 * @return  float   积分价值
	 */
	public static function value_of_integral($integral) {
		$scale = floatval(ecjia::config('integral_scale'));
		return $scale > 0 ? round($integral / 100 * $scale, 2) : 0;
	}

	/**
	 * 取得购物车总金额
	 * @params  boolean $include_gift   是否包括赠品
	 * @param   int     $type           类型：默认普通商品
	 * @return  float   购物车总金额
	 */
	public static function cart_amount($include_gift = true, $type = CART_GENERAL_GOODS, $cart_id = array()) {
		$where = array('rec_type' => $type, 'user_id' => $_SESSION['user_id']);
// 		if (defined('SESS_ID')) {
// 			$where['session_id'] = SESS_ID;
// 		}

		if (!empty($cart_id)) {
			$where['rec_id'] = $cart_id;
		}

		if (!$include_gift) {
			$where['is_gift']	= 0;
			$where['goods_id']	= array('gt' => 0);
		}

		$data = RC_Model::model('cart/cart_model')->where($where)->sum('goods_price * goods_number');
		return $data;
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
	public static function order_fee($order, $goods, $consignee, $cart_id = array()) {

		$db = RC_Model::model('cart/cart_model');
		$db_view = RC_Model::model('cart/cart_exchange_viewmodel');
		/* 初始化订单的扩展code */
		if (!isset($order['extension_code'])) {
			$order['extension_code'] = '';
		}

//     	TODO: 团购等促销活动注释后暂时给的固定参数
//		$order['extension_code'] = '';
//		$group_buy = '';
//     	TODO: 团购功能暂时注释
     if ($order['extension_code'] == 'group_buy') {
         RC_Loader::load_app_func('admin_goods', 'goods');
         $group_buy = group_buy_info($order['extension_id']);
     }

		$total  = array(
			'real_goods_count' => 0,
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
		$weight		= 0;
		$store_id	= 0;
		/* 商品总价 */
		foreach ($goods AS $key => $val) {
			$store_id = $val['store_id'];
			/* 统计实体商品的个数 */
			if ($val['is_real']) {
				$total['real_goods_count']++;
			}

			$total['goods_price']  += $val['goods_price'] * $val['goods_number'];
			$total['market_price'] += $val['market_price'] * $val['goods_number'];
		}

		$total['saving']    = $total['market_price'] - $total['goods_price'];
		$total['save_rate'] = $total['market_price'] ? round($total['saving'] * 100 / $total['market_price']) . '%' : 0;

		$total['goods_price_formated']  = price_format($total['goods_price'], false);
		$total['market_price_formated'] = price_format($total['market_price'], false);
		$total['saving_formated']       = price_format($total['saving'], false);

		/* 折扣 */
		if ($order['extension_code'] != 'group_buy') {
			$discount = self::compute_discount($cart_id);
			$total['discount'] = round($discount['discount'], 2);
			if ($total['discount'] > $total['goods_price']) {
				$total['discount'] = $total['goods_price'];
			}
		}
		$total['discount_formated'] = price_format($total['discount'], false);

		/* 税额 */
		if (!empty($order['need_inv']) && $order['inv_type'] != '') {
			$total['tax'] = self::get_tax_fee($order['inv_type'], $total['goods_price']);
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

		/* 红包 */
		if (!empty($order['bonus_id'])) {
			$bonus          = RC_Api::api('bonus', 'bonus_info', array('bonus_id' => $order['bonus_id']));
			$total['bonus'] = $bonus['type_money'];
		}
		//TODO::红包错误
		$total['bonus_formated'] = price_format($total['bonus'], false);
		/* 线下红包 */
		if (!empty($order['bonus_kill'])) {

			$bonus  = RC_Api::api('bonus', 'bonus_info', array('bonus_id' => 0, 'bonus_sn' => $order['bonus_kill'], 'store_id' => $store_id));
			$total['bonus_kill'] = $order['bonus_kill'];
			$total['bonus_kill_formated'] = price_format($total['bonus_kill'], false);
		}

		/* 配送费用 */
		$shipping_cod_fee = NULL;
		if ($order['shipping_id'] > 0 && $total['real_goods_count'] > 0) {
			$region['country']  = $consignee['country'];
			$region['province'] = $consignee['province'];
			$region['city']     = $consignee['city'];
			$region['district'] = isset($consignee['district']) ? $consignee['district'] : '';
			$region['street']   = isset($consignee['street']) ? $consignee['street'] : '';
			$region_list 		= array($region['country'], $region['province'], $region['city'], $region['district'], $region['street']);

// 			$shipping_method	= RC_Loader::load_app_class('shipping_method', 'shipping');
// 			$shipping_info 		= $shipping_method->shipping_area_info($order['shipping_id'], $region_list, $store_id);
			$shipping_info = ecjia_shipping::shippingArea($order['shipping_id'], $region_list, $store_id);
			
			if (!empty($shipping_info)) {
				if ($order['extension_code'] == 'group_buy') {
					$weight_price = self::cart_weight_price(CART_GROUP_BUY_GOODS);
				} else {
					$weight_price = self::cart_weight_price(CART_GENERAL_GOODS, $cart_id);
				}
				if (!empty($cart_id)) {
					$shipping_count_where = array('rec_id' => $cart_id);
				}
				$shipping_count_where[] = " (`extension_code` IS NULL or `extension_code` != 'package_buy') ";
				// 查看购物车中是否全为免运费商品，若是则把运费赋为零
				if ($_SESSION['user_id']) {
				    $shipping_count_where['user_id'] = $_SESSION['user_id'];
				} else {
				    $shipping_count_where['session_id'] = SESS_ID;
				}
				$shipping_count_where['is_shipping'] = array('neq' => 1);
				$shipping_count       = $db->where($shipping_count_where)->count();

				if (($shipping_info['shipping_code'] == 'ship_o2o_express') || ($shipping_info['shipping_code'] == 'ship_ecjia_express')) {
				
					/* ===== 计算收件人距离 START ===== */
					// 收件人地址，带坐标 $consignee
					// 获取到店家的地址，带坐标
					$store_info = RC_DB::table('store_franchisee')->where('store_id', $store_id)->where('shop_close', '0')->first();
					// 计算店家距离收件人距离 $distance
					if (!empty($store_info['longitude']) && !empty($store_info['latitude'])) {
						//腾讯地图api距离计算
						$key = ecjia::config('map_qq_key');
						$url = "https://apis.map.qq.com/ws/distance/v1/?mode=driving&from=".$store_info['latitude'].",".$store_info['longitude']."&to=".$consignee['latitude'].",".$consignee['longitude']."&key=".$key;
						$distance_json = file_get_contents($url);
						$distance_info = json_decode($distance_json, true);
						$distance = isset($distance_info['result']['elements'][0]['distance']) ? $distance_info['result']['elements'][0]['distance'] : 0;
					}
					/* ===== 计算收件人距离 END ===== */
					$total['shipping_fee'] = ($shipping_count == 0 AND $weight_price['free_shipping'] == 1) ? 0 : ecjia_shipping::fee($shipping_info['shipping_area_id'], $distance, $total['goods_price'], $weight_price['number']);
				} else {
					$total['shipping_fee'] = ($shipping_count == 0 AND $weight_price['free_shipping'] == 1) ? 0 : ecjia_shipping::fee($shipping_info['shipping_area_id'], $weight_price['weight'], $total['goods_price'], $weight_price['number']);
				}

				if (!empty($order['need_insure']) && $shipping_info['insure'] > 0) {
// 					$total['shipping_insure'] = $shipping_method->shipping_insure_fee($shipping_info['shipping_code'], $total['goods_price'], $shipping_info['insure']);
					$total['shipping_insure'] = ecjia_shipping::insureFee($shipping_info['shipping_code'], $total['goods_price'], $shipping_info['insure']);
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
		$discount_amount = self::compute_discount_amount($cart_id);//TODO::方法错误
		// 红包和积分最多能支付的金额为商品总额
		$max_amount = $total['goods_price'] == 0 ? 0 : $total['goods_price'] - $discount_amount;
		$max_amount = $max_amount < 0 ? 0 : $max_amount;//防止出现负值

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
			$integral_money = self::value_of_integral($order['integral']);
			/*amount小于积分价值时*/
			$scale = floatval(ecjia::config('integral_scale'));
			if ($integral_money > $total['amount']) {
				$integral_money = $total['amount']*100*$scale;
			}
			
			// 使用积分支付
			$use_integral            = min($total['amount'], $max_amount, $integral_money); // 实际使用积分支付的金额
			$total['amount']        -= $use_integral;
			$total['integral_money'] = $use_integral;
			$order['integral']       = self::integral_of_value($use_integral);
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
			$total['pay_fee']      	= self::pay_fee($order['pay_id'], $total['amount'], $shipping_cod_fee);
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
			$total['will_get_integral'] = self::get_give_integral($cart_id);
		}
// 		TODO::客户可获得赠送的红包总额，
// 		$total['will_get_bonus']        = $order['extension_code'] == 'exchange_goods' ? 0 : price_format(get_total_bonus(), false);
		$total['formated_goods_price']  = price_format($total['goods_price'], false);
		$total['formated_market_price'] = price_format($total['market_price'], false);
		$total['formated_saving']       = price_format($total['saving'], false);

// 		if ($order['extension_code'] == 'exchange_goods') {
// 			if ($_SESSION['user_id']) {
// 				$exchange_integral = $dbview->join('exchange_goods')->where(array('c.user_id' => $_SESSION['user_id'] , 'c.rec_type' => CART_EXCHANGE_GOODS , 'c.is_gift' => 0 ,'c.goods_id' => array('gt' => 0)))->group('eg.goods_id')->sum('eg.exchange_integral');
// 			} else {
// 				$exchange_integral = $dbview->join('exchange_goods')->where(array('c.session_id' => SESS_ID , 'c.rec_type' => CART_EXCHANGE_GOODS , 'c.is_gift' => 0 ,'c.goods_id' => array('gt' => 0)))->group('eg.goods_id')->sum('eg.exchange_integral');
// 			}
// 			$total['exchange_integral'] = $exchange_integral;
// 		}
		return $total;
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
	    
	    $invoice_type = ecjia::config('invoice_type');
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
	 * 获得订单需要支付的支付费用
	 *
	 * @access  public
	 * @param   integer $payment_id
	 * @param   float   $order_amount
	 * @param   mix	 $cod_fee
	 * @return  float
	 */
	public static function pay_fee($payment_id, $order_amount, $cod_fee=null) {
		$payment_method = RC_Loader::load_app_class('payment_method','payment');
		$pay_fee = 0;
		$payment = $payment_method->payment_info($payment_id);
		$rate	= ($payment['is_cod'] && !is_null($cod_fee)) ? $cod_fee : $payment['pay_fee'];

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
	 * 取得购物车该赠送的积分数
	 * @return  int	 积分数
	 */
	public static function get_give_integral($cart_id = array()) {
		$db_cartview = RC_Model::model('cart/cart_good_member_viewmodel');
		$db_cartview->view = array(
			'goods' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'g',
				'field' => "c.rec_id, c.goods_id, c.goods_attr_id, g.promote_price, g.promote_start_date, c.goods_number,g.promote_end_date, IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS member_price",
				'on'    => 'g.goods_id = c.goods_id'
			),
		);
		$where = array(
			'c.user_id'		=> $_SESSION['user_id'] ,
			'c.goods_id'	=> array('gt' => 0) ,
			'c.parent_id'	=> 0 ,
			'c.rec_type'	=> 0 ,
			'c.is_gift'		=> 0
		);
		if (!empty($cart_id)) {
			$where['rec_id'] = $cart_id;
		}
// 		if (defined('SESS_ID')) {
// 			$where['c.session_id'] = SESS_ID;
// 		}
		$integral = $db_cartview->where($where)->sum('c.goods_number * IF(g.give_integral > -1, g.give_integral, c.goods_price)');

		return intval($integral);
	}

	/**
	 * 获得购物车中商品的总重量、总价格、总数量
	 *
	 * @access  public
	 * @param   int	 $type   类型：默认普通商品
	 * @return  array
	 */
	public static function cart_weight_price($type = CART_GENERAL_GOODS, $cart_id = array()) {
		$db = RC_Model::model('cart/cart_model');
		$dbview = RC_Model::model('orders/package_goods_viewmodel');
		$db_cartview = RC_Model::model('cart/cart_good_member_viewmodel');

		$package_row['weight'] 			= 0;
		$package_row['amount'] 			= 0;
		$package_row['number'] 			= 0;
		$packages_row['free_shipping'] 	= 1;
		$where = array('extension_code' => 'package_buy' , 'user_id' => $_SESSION['user_id'] );
		if (!empty($cart_id)) {
			$where['rec_id'] = $cart_id;
		}

		/* 计算超值礼包内商品的相关配送参数 */
		$row = $db->field('goods_id, goods_number, goods_price')->where($where)->select();

		if ($row) {
			$packages_row['free_shipping'] = 0;
			$free_shipping_count = 0;
			foreach ($row as $val) {
				// 如果商品全为免运费商品，设置一个标识变量
				$dbview->view = array(
					'goods' => array(
						'type'  => Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'g',
						'on'    => 'g.goods_id = pg.goods_id ',
					)
				);

				$shipping_count = $dbview->where(array('g.is_shipping' => 0 , 'pg.package_id' => $val['goods_id']))->count();
				if ($shipping_count > 0) {
					// 循环计算每个超值礼包商品的重量和数量，注意一个礼包中可能包换若干个同一商品
					$dbview->view = array(
						'goods' => array(
							'type'  => Component_Model_View::TYPE_LEFT_JOIN,
							'alias' => 'g',
							'field' => 'SUM(g.goods_weight * pg.goods_number) as weight,SUM(pg.goods_number) as number',
							'on'    => 'g.goods_id = pg.goods_id',
						)
					);
					$goods_row = $dbview->find(array('g.is_shipping' => 0 , 'pg.package_id' => $val['goods_id']));

					$package_row['weight'] += floatval($goods_row['weight']) * $val['goods_number'];
					$package_row['amount'] += floatval($val['goods_price']) * $val['goods_number'];
					$package_row['number'] += intval($goods_row['number']) * $val['goods_number'];
				} else {
					$free_shipping_count++;
				}
			}
			$packages_row['free_shipping'] = $free_shipping_count == count($row) ? 1 : 0;
		}

		/* 获得购物车中非超值礼包商品的总重量 */
		$db_cartview->view =array(
			'goods' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'g',
				'field' => 'SUM(g.goods_weight * c.goods_number) as weight, SUM(c.goods_price * c.goods_number) as amount, SUM(c.goods_number) as number',
				'on'    => 'g.goods_id = c.goods_id'
			)
		);
		$where = array(
			'c.user_id'		=> $_SESSION['user_id'] ,
			'rec_type'		=> $type ,
			'g.is_shipping' => 0 ,
		);
		$where[] =  " (c.extension_code IS NULL or c.extension_code != 'package_buy') ";
		if (!empty($cart_id)) {
			$where['rec_id'] = $cart_id;
		}
// 		if (defined('SESS_ID')) {
// 			$where['session_id'] = SESS_ID;
// 		}
		$row = $db_cartview->find($where);

		$packages_row['weight'] = floatval($row['weight']) + $package_row['weight'];
		$packages_row['amount'] = floatval($row['amount']) + $package_row['amount'];
		$packages_row['number'] = intval($row['number']) + $package_row['number'];
		/* 格式化重量 */
		$packages_row['formated_weight'] = self::formated_weight($packages_row['weight']);
		return $packages_row;
	}

	/**
	 * 格式化重量：小于1千克用克表示，否则用千克表示
	 *
	 * @param float $weight
	 *        	重量
	 * @return string 格式化后的重量
	 */
	public static function formated_weight($weight) {
		$weight = round(floatval($weight), 3);
		if ($weight > 0) {
			if ($weight < 1) {
				/* 小于1千克，用克表示 */
				return intval($weight * 1000) . RC_Lang::get('cart::shopping_flow.gram');
			} else {
				/* 大于1千克，用千克表示 */
				return $weight . RC_Lang::get('cart::shopping_flow.kilogram');
			}
		} else {
			return 0;
		}
	}

	/**
	 * 计算折扣：根据购物车和优惠活动
	 * @return  float   折扣
	 */
	public static function compute_discount($cart_id = array()) {
		//$db = RC_Model::model('favourable/favourable_activity_model');
		$db_cartview = RC_Model::model('cart/cart_good_member_viewmodel');
		$db	  = RC_DB::table('favourable_activity');
		/* 查询优惠活动 */
		$now = RC_Time::gmtime();
		$user_rank = ',' . $_SESSION['user_rank'] . ',';

		//$favourable_list = $db->where("start_time <= '$now' AND end_time >= '$now' AND CONCAT(',', user_rank, ',') LIKE '%" . $user_rank . "%'")->in(array('act_type'=>array(FAT_DISCOUNT, FAT_PRICE)))->select();
		$favourable_list = $db->where('start_time', '<=', $now)->where('end_time', '>=', $now)->whereRaw('CONCAT(",", user_rank, ",") LIKE "%' . $user_rank . '%"')->whereIn('act_type', array(FAT_DISCOUNT, FAT_PRICE))->get();
		if (!$favourable_list) {
			return 0;
		}

		/* 查询购物车商品 */
		$db_cartview->view = array(
			'goods' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'g',
				'field' => "c.goods_id, c.goods_price * c.goods_number AS subtotal, g.cat_id, g.brand_id, g.store_id",
				'on'   	=> 'c.goods_id = g.goods_id'
			)
		);

		$where = array(
			'c.user_id'		=> $_SESSION['user_id'],
			'c.parent_id'	=> 0,
			'c.is_gift'		=> 0,
			'rec_type' 		=> CART_GENERAL_GOODS,
	        'c.is_checked'  => 1, // 增加选中状态条件
		);

		if (!empty($cart_id)) {
			$where['rec_id'] = $cart_id;
		}

// 		if (defined('SESS_ID')) {
// 			$where['c.session_id'] = SESS_ID;
// 		}

		$goods_list = $db_cartview->where($where)->select();

		if (!$goods_list) {
			return 0;
		}
		
		/* 初始化折扣 */
		$discount = 0;
		$favourable_name = array();
		RC_Loader::load_app_class('goods_category', 'goods', false);
		/* 循环计算每个优惠活动的折扣 */
		if (!empty($favourable_list)) {
			$discount_temp = [];
			foreach ($favourable_list as $favourable) {
			    /* 初始化折扣 */
			    $discount = 0;
				$total_amount = 0;
				//优惠活动类型-全部商品
				if ($favourable['act_range'] == FAR_ALL) {
					foreach ($goods_list as $goods) {
// 						if ($favourable['user_id'] == $goods['user_id']) {
					    //判断店铺和平台活动
						if ($favourable['store_id'] == $goods['store_id'] || $favourable['store_id'] == 0) {
							$total_amount += $goods['subtotal'];
						}
					}
				//优惠活动类型-分类
				} elseif ($favourable['act_range'] == FAR_CATEGORY) {
					/* 找出分类id的子分类id */
// 				    TODO：分类未判断商家分类
					$id_list = array();
					$raw_id_list = explode(',', $favourable['act_range_ext']);
					foreach ($raw_id_list as $id) {
						RC_Loader::load_app_class('goods_category', 'goods', false);
						$id_list = array_merge($id_list, array_keys(goods_category::cat_list($id, 0, false)));
					}
					$ids = join(',', array_unique($id_list));

					foreach ($goods_list as $goods) {
					    if ($favourable['store_id'] == $goods['store_id'] || $favourable['store_id'] == 0) {
							if (strpos(',' . $ids . ',', ',' . $goods['cat_id'] . ',') !== false) {
								$total_amount += $goods['subtotal'];
							}
						}
					}
				//优惠活动类型-品牌
				} elseif ($favourable['act_range'] == FAR_BRAND) {
					foreach ($goods_list as $goods) {
					    if ($favourable['store_id'] == $goods['store_id'] || $favourable['store_id'] == 0) {
							if (strpos(',' . $favourable['act_range_ext'] . ',', ',' . $goods['brand_id'] . ',') !== false) {
								$total_amount += $goods['subtotal'];
							}
						}
					}
				//优惠活动类型-指定商品
				} elseif ($favourable['act_range'] == FAR_GOODS) {
					foreach ($goods_list as $goods) {
					    if ($favourable['store_id'] == $goods['store_id'] || $favourable['store_id'] == 0) {
							if (strpos(',' . $favourable['act_range_ext'] . ',', ',' . $goods['goods_id'] . ',') !== false) {
								$total_amount += $goods['subtotal'];
							}
						}
					}
				} else {
					continue;
				}

				/* 如果金额满足条件，累计折扣 */
				(float) $favourable['min_amount'];
				(float) $favourable['max_amount'];
				(float) $favourable['act_type_ext'];
				if ($total_amount > 0 && $total_amount >= $favourable['min_amount'] &&
				($total_amount <= $favourable['max_amount'] || $favourable['max_amount'] == 0)) {
					if ($favourable['act_type'] == FAT_DISCOUNT) {
						$discount += $total_amount * (1 - $favourable['act_type_ext'] / 100);
                        $discount_temp[] = $discount;
						$favourable_name[] = $favourable['act_name'];
					} elseif ($favourable['act_type'] == FAT_PRICE) {
						$discount += $favourable['act_type_ext'];
                        $discount_temp[] = $favourable['act_type_ext'];
						$favourable_name[] = $favourable['act_name'];
					}
				}
			}
			$discount = !empty($discount_temp) ? max($discount_temp) : 0.00;
			//优惠金额不能超过订单本身
			if ($total_amount && $discount > $total_amount) {
			    $discount = $total_amount;
			}
		}
        
		return array('discount' => $discount, 'name' => $favourable_name);
	}
	
	/**
	 * 计算折扣：根据购物车和优惠活动-单个商店
	 * @return  float   折扣
	 */
	public static function compute_discount_store($store_id = 0) {
	    //$db = RC_Model::model('favourable/favourable_activity_model');
	    $db_cartview = RC_Model::model('cart/cart_good_member_viewmodel');
	    $db	  = RC_DB::table('favourable_activity');
	    /* 查询优惠活动 */
	    $now = RC_Time::gmtime();
	    $user_rank = ',' . $_SESSION['user_rank'] . ',';
	
	    //$favourable_list = $db->where("start_time <= '$now' AND end_time >= '$now' AND CONCAT(',', user_rank, ',') LIKE '%" . $user_rank . "%' AND (store_id = 0 or store_id = $store_id)")->in(array('act_type'=>array(FAT_DISCOUNT, FAT_PRICE)))->select();
	    $favourable_list = $db->where('start_time', '<=', $now)->where('end_time', '>=', $now)->whereRaw('CONCAT(",", user_rank, ",") LIKE "%' . $user_rank . '%"')->whereIn('act_type', array(FAT_DISCOUNT, FAT_PRICE))->get();
	    if (!$favourable_list) {
	        return array('discount' => 0, 'name' => '');
	    }
	
	    /* 查询购物车商品 */
	    $db_cartview->view = array(
	        'goods' => array(
	            'type'  => Component_Model_View::TYPE_LEFT_JOIN,
	            'alias' => 'g',
	            'field' => "c.goods_id, c.goods_price * c.goods_number AS subtotal, g.cat_id, g.brand_id, g.store_id",
	            'on'   	=> 'c.goods_id = g.goods_id'
	        )
	    );
	
	    $where = array(
	        'c.user_id'		=> $_SESSION['user_id'],
	        'c.parent_id'	=> 0,
	        'c.is_gift'		=> 0,
	        'rec_type' 		=> CART_GENERAL_GOODS,
	        'c.is_checked'  => 1, // 增加选中状态条件
	        'c.store_id'    => $store_id,
	    );
	
// 	    if (!empty($cart_id)) {
// 	        $where['rec_id'] = $cart_id;
// 	    }
	
	    // 		if (defined('SESS_ID')) {
	    // 			$where['c.session_id'] = SESS_ID;
	    // 		}
	
	    $goods_list = $db_cartview->where($where)->select();
	
	    if (!$goods_list) {
	        return array('discount' => 0, 'name' => '');
	    }
	
	    /* 初始化折扣 */
	    $discount = 0;
	    $favourable_name = array();
	    RC_Loader::load_app_class('goods_category', 'goods', false);
	    /* 循环计算每个优惠活动的折扣 */
	    if (!empty($favourable_list)) {
	        foreach ($favourable_list as $favourable) {
	            /* 初始化折扣 */
	            $discount = 0;
	            $total_amount = 0;
	            //优惠活动类型-全部商品
	            if ($favourable['act_range'] == FAR_ALL) {
	                foreach ($goods_list as $goods) {
	                    // 						if ($favourable['user_id'] == $goods['user_id']) {
	                    //判断店铺和平台活动
	                    if ($favourable['store_id'] == $goods['store_id'] || $favourable['store_id'] == 0) {
	                        $total_amount += $goods['subtotal'];
	                    }
	                }
	                //优惠活动类型-分类
	            } elseif ($favourable['act_range'] == FAR_CATEGORY) {
	                /* 找出分类id的子分类id */
	                // 				    TODO：分类未判断商家分类
	                $id_list = array();
	                $raw_id_list = explode(',', $favourable['act_range_ext']);
	                foreach ($raw_id_list as $id) {
	                    $id_list = array_merge($id_list, array_keys(goods_category::cat_list($id, 0, false)));
	                }
	                $ids = join(',', array_unique($id_list));
	
	                foreach ($goods_list as $goods) {
	                    if ($favourable['store_id'] == $goods['store_id'] || $favourable['store_id'] == 0) {
	                        if (strpos(',' . $ids . ',', ',' . $goods['cat_id'] . ',') !== false) {
	                            $total_amount += $goods['subtotal'];
	                        }
	                    }
	                }
	                //优惠活动类型-品牌
	            } elseif ($favourable['act_range'] == FAR_BRAND) {
	                foreach ($goods_list as $goods) {
	                    if ($favourable['store_id'] == $goods['store_id'] || $favourable['store_id'] == 0) {
	                        if (strpos(',' . $favourable['act_range_ext'] . ',', ',' . $goods['brand_id'] . ',') !== false) {
	                            $total_amount += $goods['subtotal'];
	                        }
	                    }
	                }
	                //优惠活动类型-指定商品
	            } elseif ($favourable['act_range'] == FAR_GOODS) {
	                foreach ($goods_list as $goods) {
	                    if ($favourable['store_id'] == $goods['store_id'] || $favourable['store_id'] == 0) {
	                        if (strpos(',' . $favourable['act_range_ext'] . ',', ',' . $goods['goods_id'] . ',') !== false) {
	                            $total_amount += $goods['subtotal'];
	                        }
	                    }
	                }
	            } else {
	                continue;
	            }
	
	            /* 如果金额满足条件，累计折扣 */
	            (float) $favourable['min_amount'];
	            (float) $favourable['max_amount'];
	            (float) $favourable['act_type_ext'];
	            if ($total_amount > 0 && $total_amount >= $favourable['min_amount'] &&
	                ($total_amount <= $favourable['max_amount'] || $favourable['max_amount'] == 0)) {
	                    if ($favourable['act_type'] == FAT_DISCOUNT) {
	                        $discount += $total_amount * (1 - $favourable['act_type_ext'] / 100);
	                        $discount_temp[] = $discount;
	                        $favourable_name[] = $favourable['act_name'];
	                    } elseif ($favourable['act_type'] == FAT_PRICE) {
	                        $discount += $favourable['act_type_ext'];
	                        $discount_temp[] = $favourable['act_type_ext'];
	                        $favourable_name[] = $favourable['act_name'];
	                    }
	                    //优惠金额不能超过订单本身
	                    if ($discount > $total_amount) {
	                        $discount = $total_amount;
	                    }
	                }
	        }
	    }
	    $discount = max($discount_temp);
	    return array('discount' => $discount, 'name' => $favourable_name);
	}

	/**
	 * 计算购物车中的商品能享受红包支付的总额
	 * @return  float   享受红包支付的总额
	 */
	public static function compute_discount_amount($cart_id = array()) {
		//$db = RC_Model::model('favourable/favourable_activity_model');
		$db_cartview = RC_Model::model('cart/cart_good_member_viewmodel');
		$db	  = RC_DB::table('favourable_activity');
		/* 查询优惠活动 */
		$now = RC_Time::gmtime();
		$user_rank = ',' . $_SESSION['user_rank'] . ',';

		//$favourable_list = $db->where('start_time <= '.$now.' AND end_time >= '.$now.' AND CONCAT(",", user_rank, ",") LIKE "%' . $user_rank . '%" ')->in(array('act_type' => array(FAT_DISCOUNT, FAT_PRICE)))->select();
		$favourable_list = $db->where('start_time', '<=', $now)->where('end_time', '>=', $now)->whereRaw('CONCAT(",", user_rank, ",") LIKE "%' . $user_rank . '%"')->whereIn('act_type', array(FAT_DISCOUNT, FAT_PRICE))->get();
		if (!$favourable_list) {
			return 0;
		}

		/* 查询购物车商品 */
		$db_cartview->view = array(
			'goods' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'g',
// 				'field' => "c.goods_id, c.goods_price * c.goods_number AS subtotal, g.cat_id, g.brand_id, g.user_id",
				'field' => "c.goods_id, c.goods_price * c.goods_number AS subtotal, g.cat_id, g.brand_id, g.store_id",
				'on'    => 'c.goods_id = g.goods_id'
			)
		);
		$cart_where = array('c.parent_id' => 0 , 'c.is_gift' => 0 , 'rec_type' => CART_GENERAL_GOODS);
		if (!empty($cart_id)) {
			$cart_where = array_merge($cart_where, array('c.rec_id' => $cart_id));
		}
		if ($_SESSION['user_id']) {
			$cart_where = array_merge($cart_where, array('c.user_id' => $_SESSION['user_id']));

		} else {
			$cart_where = array_merge($cart_where, array('c.session_id' => SESS_ID));
		}
		$goods_list = $db_cartview->where($cart_where)->select();

		if (!$goods_list) {
			return 0;
		}

		/* 初始化折扣 */
		$discount = 0;
		$favourable_name = array();

		/* 循环计算每个优惠活动的折扣 */

		foreach ($favourable_list as $favourable) {
			$total_amount = 0;
			if ($favourable['act_range'] == FAR_ALL) {
				foreach ($goods_list as $goods) {
// 					if ($favourable['user_id'] == $goods['user_id']) {
					if ($favourable['store_id'] == $goods['store_id'] || $favourable['store_id'] == 0) {
						$total_amount += $goods['subtotal'];
					}
				}
			} elseif ($favourable['act_range'] == FAR_CATEGORY) {
				/* 找出分类id的子分类id */
				$id_list = array();
				$raw_id_list = explode(',', $favourable['act_range_ext']);
				foreach ($raw_id_list as $id) {
					RC_Loader::load_app_class('goods_category', 'goods', false);
					$id_list = array_merge($id_list, array_keys(goods_category::cat_list($id, 0, false)));
				}
				$ids = join(',', array_unique($id_list));

				foreach ($goods_list as $goods) {
// 					if ($favourable['user_id'] == $goods['user_id']) {
				    if ($favourable['store_id'] == $goods['store_id'] || $favourable['store_id'] == 0) {
						if (strpos(',' . $ids . ',', ',' . $goods['cat_id'] . ',') !== false) {
							$total_amount += $goods['subtotal'];
						}
					}
				}
			} elseif ($favourable['act_range'] == FAR_BRAND) {
				foreach ($goods_list as $goods) {
// 					if ($favourable['user_id'] == $goods['user_id']) {
				    if ($favourable['store_id'] == $goods['store_id'] || $favourable['store_id'] == 0) {
						if (strpos(',' . $favourable['act_range_ext'] . ',', ',' . $goods['brand_id'] . ',') !== false) {
							$total_amount += $goods['subtotal'];
						}
					}
				}
			} elseif ($favourable['act_range'] == FAR_GOODS) {
				foreach ($goods_list as $goods) {
// 					if ($favourable['user_id'] == $goods['user_id']) {
				    if ($favourable['store_id'] == $goods['store_id'] || $favourable['store_id'] == 0) {
// 						if (strpos(',' . $favourable['act_range_ext'] . ',', ',' . $goods['goods_id'] . ',') !== false) {
						if (strpos(',' . $favourable['act_range_ext'] . ',', ',' . $goods['goods_id'] . ',') !== false) {
							$total_amount += $goods['subtotal'];
						}
					}
				}
			} else {
				continue;
			}

			if ($total_amount > 0 && $total_amount >= $favourable['min_amount'] && ($total_amount <= $favourable['max_amount'] || $favourable['max_amount'] == 0)) {
				if ($favourable['act_type'] == FAT_DISCOUNT) {
					$discount += $total_amount * (1 - $favourable['act_type_ext'] / 100);
				} elseif ($favourable['act_type'] == FAT_PRICE) {
					$discount += $favourable['act_type_ext'];
				}
			}
		}
		return $discount;
	}


	/**
	 * 检查礼包内商品的库存
	 * @return  boolen
	 */
	public static function judge_package_stock($package_id, $package_num = 1) {
		$db_package_goods = RC_Model::model('goods/package_goods_model');
		$db_products_view = RC_Model::model('goods/products_viewmodel');
		$db_goods_view = RC_Model::model('goods/goods_auto_viewmodel');

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
	 * 清空购物车
	 * @param   int	 $type   类型：默认普通商品
	 */
	public static function clear_cart($type = CART_GENERAL_GOODS, $cart_id = array()) {
		$db_cart = RC_Model::model('cart/cart_model');

		$cart_w = array(
				'user_id'	=> $_SESSION['user_id'],
				'rec_type'	=> $type,
		);
		if (!empty($cart_id)) {
			$cart_w['rec_id'] = $cart_id;
		}

// 		if (defined('SESS_ID')) {
// 			$cart_w['session_id'] = SESS_ID;
// 		}

		$db_cart->where($cart_w)->delete();
	}

	/**
	 * 取得商品最终使用价格
	 *
	 * @param string $goods_id
	 *        	商品编号
	 * @param string $goods_num
	 *        	购买数量
	 * @param boolean $is_spec_price
	 *        	是否加入规格价格
	 * @param mix $spec
	 *        	规格ID的数组或者逗号分隔的字符串
	 *
	 * @return 商品最终购买价格
	 */
	public static function get_final_price($goods_id, $goods_num = '1', $is_spec_price = false, $spec = array()) {
		$dbview = RC_Model::model ( 'goods/sys_goods_member_viewmodel');

		$final_price = '0'; // 商品最终购买价格
		$volume_price = '0'; // 商品优惠价格
		$promote_price = '0'; // 商品促销价格
		$user_price = '0'; // 商品会员价格

		// 取得商品优惠价格列表
		$price_list = self::get_volume_price_list ( $goods_id, '1' );

		if (! empty ( $price_list )) {
			foreach ( $price_list as $value ) {
				if ($goods_num >= $value ['number']) {
					$volume_price = $value ['price'];
				}
			}
		}
// 		$field = " g.goods_name, g.goods_sn, g.is_on_sale, g.is_real, g.user_id as ru_id, g.model_inventory, g.model_attr, ".
// 				" g.model_price, g.model_attr, ".
// 				"g.market_price, IF(g.model_price < 1, g.shop_price, IF(g.model_price < 2, wg.warehouse_price, wag.region_price)) AS org_price, ".
// 				"IF(g.model_price < 1, g.promote_price, IF(g.model_price < 2, wg.warehouse_promote_price, wag.region_promote_price)) as promote_price, ".
// 				" g.promote_start_date, g.promote_end_date, g.goods_weight, g.integral, g.extension_code, g.goods_number, g.is_alone_sale, g.is_shipping, ".
// 				"IFNULL(mp.user_price, IF(g.model_price < 1, g.shop_price, IF(g.model_price < 2, wg.warehouse_price, wag.region_price)) * '$_SESSION[discount]') AS shop_price ";
		/* 取得商品信息 */
		$dbview->view = array(
			'member_price' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'mp',
				'on'   	=> "mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]'"
			)
		);
		// 取得商品促销价格列表
		$goods = $dbview->join (array('member_price'))->find (array('g.goods_id' => $goods_id, 'g.is_delete' => 0));
		/* 计算商品的促销价格 */
		if ($goods ['promote_price'] > 0) {
			$promote_price = self::bargain_price ( $goods['promote_price'], $goods['promote_start_date'], $goods['promote_end_date'] );
		} else {
			$promote_price = 0;
		}

		// 取得商品会员价格列表
		$user_price = $goods ['shop_price'];

		// 比较商品的促销价格，会员价格，优惠价格
		if (empty ( $volume_price ) && empty ( $promote_price )) {
			// 如果优惠价格，促销价格都为空则取会员价格
			$final_price = $user_price;
		} elseif (! empty ( $volume_price ) && empty ( $promote_price )) {
			// 如果优惠价格为空时不参加这个比较。
			$final_price = min ( $volume_price, $user_price );
		} elseif (empty ( $volume_price ) && ! empty ( $promote_price )) {
			// 如果促销价格为空时不参加这个比较。
			$final_price = min ( $promote_price, $user_price );
		} elseif (! empty ( $volume_price ) && ! empty ( $promote_price )) {
			// 取促销价格，会员价格，优惠价格最小值
			$final_price = min ( $volume_price, $promote_price, $user_price );
		} else {
			$final_price = $user_price;
		}
		/* 手机专享*/
		$mobilebuy_db = RC_Model::model('goods/goods_activity_model');
		$mobilebuy_ext_info = array();
		$mobilebuy = $mobilebuy_db->find(array(
			'goods_id'	 => $goods_id,
			'start_time' => array('elt' => RC_Time::gmtime()),
			'end_time'	 => array('egt' => RC_Time::gmtime()),
			'act_type'	 => GAT_MOBILE_BUY,
		));
		if (!empty($mobilebuy)) {
			$mobilebuy_ext_info = unserialize($mobilebuy['ext_info']);
		}
		$final_price =  ($final_price > $mobilebuy_ext_info['price'] && !empty($mobilebuy_ext_info['price'])) ? $mobilebuy_ext_info['price'] : $final_price;

		// 如果需要加入规格价格
		if ($is_spec_price) {
			if (! empty ( $spec )) {
				$spec_price = self::spec_price ( $spec , $goods_id);
				$final_price += $spec_price;
			}
		}

		// 返回商品最终购买价格
		return $final_price;
	}

	/**
	 * 取得商品优惠价格列表
	 *
	 * @param string $goods_id
	 *        	商品编号
	 * @param string $price_type
	 *        	价格类别(0为全店优惠比率，1为商品优惠价格，2为分类优惠比率)
	 *
	 * @return 优惠价格列表
	 */
	public static function get_volume_price_list($goods_id, $price_type = '1') {
		$db = RC_Model::model('goods/volume_price_model');
		$volume_price = array ();
		$temp_index = '0';

		$res = $db->field ('`volume_number` , `volume_price`')->where(array('goods_id' => $goods_id, 'price_type' => $price_type))->order ('`volume_number` asc')->select();
		if (! empty ( $res )) {
			foreach ( $res as $k => $v ) {
				$volume_price [$temp_index] = array ();
				$volume_price [$temp_index] ['number'] = $v ['volume_number'];
				$volume_price [$temp_index] ['price'] = $v ['volume_price'];
				$volume_price [$temp_index] ['format_price'] = price_format ( $v ['volume_price'] );
				$temp_index ++;
			}
		}
		return $volume_price;
	}

	/**
	 * 判断某个商品是否正在特价促销期
	 *
	 * @access public
	 * @param float $price
	 *        	促销价格
	 * @param string $start
	 *        	促销开始日期
	 * @param string $end
	 *        	促销结束日期
	 * @return float 如果还在促销期则返回促销价，否则返回0
	 */
	private static function bargain_price($price, $start, $end) {
		if ($price == 0) {
			return 0;
		} else {
			$time = RC_Time::gmtime ();
			if ($time >= $start && $time <= $end) {
				return $price;
			} else {
				return 0;
			}
		}
	}

	/**
	 * 获得指定的规格的价格
	 *
	 * @access public
	 * @param mix $spec
	 *        	规格ID的数组或者逗号分隔的字符串
	 * @return void
	 */
	public static function spec_price($spec) {
		$db = RC_Model::model('goods/goods_attr_model');
		if (! empty ( $spec )) {
			if (is_array ( $spec )) {
				foreach ( $spec as $key => $val ) {
					$spec [$key] = addslashes ( $val );
				}
			} else {
				$spec = addslashes ( $spec );
			}

			$price = $db->in(array('goods_attr_id' => $spec))->sum('`attr_price`|attr_price');
		} else {
			$price = 0;
		}

		return $price;
	}

	/**
	 * 改变订单中商品库存
	 * @param   int	 $order_id   订单号
	 * @param   bool	$is_dec	 是否减少库存
	 * @param   bool	$storage	 减库存的时机，1，下订单时；0，发货时；
	 */
	public static function change_order_goods_storage($order_id, $is_dec = true, $storage = 0) {
		$db			= RC_Model::model('orders/order_goods_model');
		$db_package	= RC_Model::model('goods/package_goods_model');
		$db_goods	= RC_Model::model('goods/goods_model');
		/* 查询订单商品信息  */
		switch ($storage) {
			case 0 :
				$data = $db->field('goods_id, SUM(send_number) as num, MAX(extension_code) as extension_code, product_id')->where(array('order_id' => $order_id , 'is_real' => 1))->group(array('goods_id' , 'product_id'))->select();
				break;

			case 1 :
				$data = $db->field('goods_id, SUM(goods_number) as num, MAX(extension_code) as extension_code, product_id')->where(array('order_id' => $order_id , 'is_real' => 1))->group(array('goods_id', 'product_id'))->select();
				break;
		}

		if (!empty($data)) {
			foreach ($data as $row) {
				if ($row['extension_code'] != "package_buy") {
					if ($is_dec) {
						$result = self::change_goods_storage($row['goods_id'], $row['product_id'], - $row['num']);
					} else {
						$result = self::change_goods_storage($row['goods_id'], $row['product_id'], $row['num']);
					}
				} else {
					$data = $db_package->field('goods_id, goods_number')->where('package_id = "' . $row['goods_id'] . '"')->select();
					if (!empty($data)) {
						foreach ($data as $row_goods) {
							$is_goods = $db_goods->field('is_real')->find('goods_id = "'. $row_goods['goods_id'] .'"');

							if ($is_dec) {
								$result = self::change_goods_storage($row_goods['goods_id'], $row['product_id'], - ($row['num'] * $row_goods['goods_number']));
							} elseif ($is_goods['is_real']) {
								$result = self::change_goods_storage($row_goods['goods_id'], $row['product_id'], ($row['num'] * $row_goods['goods_number']));
							}
						}
					}
				}
			}
		}
		return $result;
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
	public static function change_goods_storage($goods_id, $product_id, $number = 0) {
		$db_goods		= RC_Model::model('goods/goods_model');
		$db_products	= RC_Model::model('goods/products_model');
		if ($number == 0) {
			return true; // 值为0即不做、增减操作，返回true
		}
		if (empty($goods_id) || empty($number)) {
			return false;
		}
		/* 处理货品库存 */
		$products_query = true;
		if (!empty($product_id)) {
			/* by will.chen start*/
			$product_number = $db_products->where(array('goods_id' => $goods_id, 'product_id' => $product_id))->get_field('product_number');
			if ($product_number < abs($number)) {
				return new ecjia_error('low_stocks', __('库存不足'));
			}
			/* end*/
			$products_query = $db_products->inc('product_number', 'goods_id='.$goods_id.' and product_id='.$product_id, $number);
		}

		/* by will.chen start*/
		$goods_number = $db_goods->where(array('goods_id' => $goods_id))->get_field('goods_number');
		if ($goods_number < abs($number) ) {
			return new ecjia_error('low_stocks', __('库存不足'));
		}
		/* end*/
		/* 处理商品库存 */
		$query = $db_goods->inc('goods_number', 'goods_id='.$goods_id, $number);
		
		if ($query && $products_query) {
			$goods_info  = RC_DB::table('goods')->where('goods_id', $goods_id)->select('goods_name', 'goods_number', 'warn_number', 'store_id')->first();
			$mobile      = RC_DB::table('staff_user')->where('store_id', $goods_info['store_id'])->where('parent_id', 0)->pluck('mobile');
			$store_name  = RC_DB::table('store_franchisee')->where('store_id', $goods_info['store_id'])->pluck('merchants_name');
			
			//发货警告库存发送短信
			$send_time = RC_Cache::app_cache_get('sms_goods_stock_warning_sendtime', 'orders');
			$now_time  = RC_Time::gmtime();
				
			if($now_time > $send_time + 86400) {
				if (!empty($mobile) && $goods_info['goods_number'] <= $goods_info['warn_number']) {
					$options = array(
						'mobile' => $mobile,
						'event'     => 'sms_goods_stock_warning',
						'value'  =>array(
								'store_name'   => $store_name,
								'goods_name'   => $goods_info['goods_name'],
								'goods_number' => $goods_info['goods_number']
						),
					);
					$response = RC_Api::api('sms', 'send_event_sms', $options);
					if (!is_ecjia_error($response)) {
						RC_Cache::app_cache_set('sms_goods_stock_warning_sendtime', $now_time, 'orders', 10080);
					}
				}
			}
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 获得订单信息
	 *
	 * @access  private
	 * @return  array
	 */
	public static function flow_order_info() {
		$order = isset($_SESSION['flow_order']) ? $_SESSION['flow_order'] : array();

		/* 初始化配送和支付方式 */
		if (!isset($order['shipping_id']) || !isset($order['pay_id'])) {
			/* 如果还没有设置配送和支付 */
			if ($_SESSION['user_id'] > 0) {
				/* 用户已经登录了，则获得上次使用的配送和支付 */
				$arr = self::last_shipping_and_payment();

				if (!isset($order['shipping_id'])) {
					$order['shipping_id'] = $arr['shipping_id'];
				}
				if (!isset($order['pay_id'])) {
					$order['pay_id'] = $arr['pay_id'];
				}
			} else {
				if (!isset($order['shipping_id'])) {
					$order['shipping_id'] = 0;
				}
				if (!isset($order['pay_id'])) {
					$order['pay_id'] = 0;
				}
			}
		}

		if (!isset($order['pack_id'])) {
			$order['pack_id'] = 0;  // 初始化包装
		}
		if (!isset($order['card_id'])) {
			$order['card_id'] = 0;  // 初始化贺卡
		}
		if (!isset($order['bonus'])) {
			$order['bonus'] = 0;    // 初始化红包
		}
		if (!isset($order['integral'])) {
			$order['integral'] = 0; // 初始化积分
		}
		if (!isset($order['surplus'])) {
			$order['surplus'] = 0;  // 初始化余额
		}

		/* 扩展信息 */
		if (isset($_SESSION['flow_type']) && intval($_SESSION['flow_type']) != CART_GENERAL_GOODS) {
			$order['extension_code'] 	= $_SESSION['extension_code'];
			$order['extension_id'] 		= $_SESSION['extension_id'];
		}
		return $order;
	}

	/**
	 * 获得上一次用户采用的支付和配送方式
	 *
	 * @access  public
	 * @return  void
	 */
	public static function last_shipping_and_payment() {
		$db_order = RC_Model::model('orders/order_info_model');
		$row = $db_order->field('shipping_id, pay_id')->order(array('order_id' => 'DESC'))->find(array('user_id' => $_SESSION['user_id']));
		if (empty($row)) {
			/* 如果获得是一个空数组，则返回默认值 */
			$row = array('shipping_id' => 0, 'pay_id' => 0);
		}
		return $row;
	}
	
	/**
	 * 获取上门自提时间
	 * @param Y integer $store_id 
	 * @param N integer $shipping_cac_id 
	 */
	public static function get_ship_cac_date_by_store($store_id = 0, $shipping_cac_id = 0, $show_all_time = 0) {
	    $expect_pickup_date = [];
	    
	    //根据店铺id，店铺有没设置运费模板，查找店铺设置的运费模板关联的快递
	    if(empty($shipping_cac_id)) {
	        $shipping_cac_id = RC_DB::table('shipping')->where('shipping_code', 'ship_cac')->pluck('shipping_id');
	    }
	    
	    if (!empty($shipping_cac_id)) {
	        $shipping_area_list = RC_DB::table('shipping_area')->where('shipping_id', $shipping_cac_id)->where('store_id', $store_id)->groupBy('shipping_id')->get();
	        
	        if (!empty($shipping_area_list)) {
	            $shipping_cfg = ecjia_shipping::unserializeConfig($shipping_area_list['0']['configure']);
	            if (!empty($shipping_cfg['pickup_time'])) {
	                /* 获取最后可取货的时间（当前时间）*/
	                $time = RC_Time::local_date('H:i', RC_Time::gmtime());
	                if (empty($shipping_cfg['pickup_time'])) {
	                    return $expect_pickup_date;
	                }
	                $pickup_date = 0;
	                /*取货日期*/
	                if (empty($shipping_cfg['pickup_days'])) {
	                    $shipping_cfg['pickup_days'] = 7;
	                }
	                while ($shipping_cfg['pickup_days']) {
	                    $pickup = [];
	                    
	                    foreach ($shipping_cfg['pickup_time'] as $k => $v) {
	                        if($show_all_time) {
	                            $pickup['date'] = RC_Time::local_date('Y-m-d', RC_Time::local_strtotime('+'.$pickup_date.' day'));
	                            $pickup['time'][] = array(
	                                'start_time' 	=> $v['start'],
	                                'end_time'		=> $v['end'],
	                                'is_disabled'   => ($v['end'] < $time && $pickup_date == 0) ? 1 : 0,
	                            );
	                        } else {
	                            if ($v['end'] > $time || $pickup_date > 0) {
	                                $pickup['date'] = RC_Time::local_date('Y-m-d', RC_Time::local_strtotime('+'.$pickup_date.' day'));
	                                $pickup['time'][] = array(
	                                    'start_time' 	=> $v['start'],
	                                    'end_time'		=> $v['end'],
	                                );
	                            }
	                        }
	                    }
	                    if (!empty($pickup['date']) && !empty($pickup['time'])) {
	                        $expect_pickup_date[] = $pickup;
	                    }
	                    $pickup_date ++;
	                    
	                    if (count($expect_pickup_date) >= $shipping_cfg['pickup_days']) {
	                        break;
	                    }
	                }
	            }
	        }
	    }
	    
	    return $expect_pickup_date;
	}
	
}

// end