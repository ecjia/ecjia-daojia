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
 * 检查购物车商品库存
 */
class cart_goods_stock {
	
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
	
			$db_cart = RC_DB::table('cart');
			$db_cart->where('user_id', $_SESSION['user_id']);
			$goods = $db_cart->select(RC_DB::raw('goods_id,goods_attr_id,extension_code, product_id'))->where('rec_id', $key)->first();
			
			$row	 = 	RC_DB::table('goods')->leftJoin('cart', 'goods.goods_id', '=', 'cart.goods_id')->where('cart.rec_id', $key)->first();
			
			//系统启用了库存，检查输入的商品数量是否有效
			if (intval(ecjia::config('use_storage')) > 0 && $goods['extension_code'] != 'package_buy') {
				if ($row['is_on_sale'] == 0 || $row['is_delete'] == 1) {
					return new ecjia_error('put_on_sale', sprintf(__('商品[%s]下架', 'cart'), $row['goods_name']));
				}
				//非散装商品判断库存
				if ($row['extension_code'] !='bulk') {
					if ($row['goods_number'] < $val) {
						return new ecjia_error('low_stocks', __('库存不足', 'cart'));
					}
					/* 是货品 */
					$row['product_id'] = trim($row['product_id']);
					if (!empty($row['product_id'])) {
						$product_number = RC_DB::table('products')->where('goods_id', $goods['goods_id'])->where('product_id', $goods['product_id'])->pluck('product_number');
						if ($product_number < $val) {
							return new ecjia_error('low_stocks', __('库存不足', 'cart'));
						}
					}
				}	
			} elseif (intval(ecjia::config('use_storage')) > 0 && $goods['extension_code'] == 'package_buy') {
				if (judge_package_stock($goods['goods_id'], $val)) {
					return new ecjia_error('low_stocks', __('库存不足', 'cart'));
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
	public static function flow_available_points($cart_id = array(), $rec_type = null, $user_id = 0) {
        if (is_null($rec_type)) {
            $rec_type = \Ecjia\App\Cart\Enums\CartEnum::CART_GENERAL_GOODS;
        }
		
		$db_view = RC_DB::table('cart as c')->leftJoin('goods as g', RC_DB::raw('c.goods_id'), '=', RC_DB::raw('g.goods_id'));
		$db_view->where(RC_DB::raw('c.user_id'), $user_id)->where(RC_DB::raw('c.is_gift'), 0)->where(RC_DB::raw('g.integral'), '>', 0)->where(RC_DB::raw('c.rec_type'), $rec_type);
		if (!empty($cart_id) && is_array($cart_id)) {
			$db_view->whereIn(RC_DB::raw('c.rec_id'), $cart_id);
		}
		$data = $db_view->pluck(RC_DB::raw('sum(g.integral * c.goods_number)'));
		$val = intval($data);
		RC_Loader::load_app_func('admin_order','orders');
		return integral_of_value($val);
	}
	
	
	/**
	 * 改变订单中商品库存
	 * @param   int	 $order_id   订单号
	 * @param   bool	$is_dec	 是否减少库存
	 * @param   bool	$storage	 减库存的时机，1，下订单时；0，发货时；
	 */
	public static function change_order_goods_storage($order_id, $is_dec = true, $storage = 0) {
		/* 查询订单商品信息  */
		switch ($storage) {
			case 0:
				$data = RC_DB::table('order_goods')->select('goods_id', RC_DB::raw('SUM(send_number) as num'), RC_DB::raw('MAX(extension_code) as extension_code'), 'product_id')->where('order_id', $order_id)->where('is_real', 1)->groupby('goods_id')->groupby('product_id')->get();
				break;
			case 1:
				$data = RC_DB::table('order_goods')->select(RC_DB::raw('goods_id'), RC_DB::raw('SUM(goods_number) as num'), RC_DB::raw('MAX(extension_code) as extension_code'), RC_DB::raw('SUM(goods_buy_weight) as total_buy_weight'), RC_DB::raw('product_id'))->where('order_id', $order_id)->where('is_real', 1)->groupby('goods_id')->groupby('product_id')->get();
				break;
		}
		
		if (!empty($data)) {
			foreach ($data as $row) {
				if ($row['extension_code'] != "package_buy") {
					if ($row['extension_code'] == 'bulk') {
						if ($is_dec) {
							$result = self::change_bulkgoods_storage($row['goods_id'], -$row['total_buy_weight']);
						} else {
							$result = self::change_bulkgoods_storage($row['goods_id'], $row['total_buy_weight']);
						}
					} else {
						if ($is_dec) {
							$result = self::change_goods_storage($row['goods_id'], $row['product_id'], -$row['num']);
						} else {
							$result = self::change_goods_storage($row['goods_id'], $row['product_id'], $row['num']);
						}
					}
				} else {
					$data = RC_DB::table('package_goods')->select('goods_id', 'goods_number')->where('package_id', $row['goods_id'])->get();
					if (!empty($data)) {
						foreach ($data as $row_goods) {
							$is_goods = RC_DB::table('goods')->select('is_real')->where('goods_id', $row_goods['goods_id'])->first();
							if ($is_dec) {
								$result = change_goods_storage($row_goods['goods_id'], $row['product_id'], -($row['num'] * $row_goods['goods_number']));
							} elseif ($is_goods['is_real']) {
								$result = change_goods_storage($row_goods['goods_id'], $row['product_id'], $row['num'] * $row_goods['goods_number']);
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
		if ($number == 0) {
			return true;
			// 值为0即不做、增减操作，返回true
		}
		if (empty($goods_id) || empty($number)) {
			return false;
		}
		/* 处理货品库存 */
		$products_query = true;
		if (!empty($product_id)) {
			/* by will.chen start*/
			$product_number = RC_DB::table('products')->where('goods_id', $goods_id)->where('product_id', $product_id)->pluck('product_number');
			if ($product_number < abs($number)) {
				return new ecjia_error('low_stocks', __('库存不足，请重新选择！', 'cart'));
			}
			/* end*/
			$products_query = RC_DB::table('products')->where('goods_id', $goods_id)->where('product_id', $product_id)->increment('product_number', $number);
		}
		/* by will.chen start*/
		$goods_number = RC_DB::table('goods')->where('goods_id', $goods_id)->pluck('goods_number');
		if ($goods_number < abs($number)) {
			return new ecjia_error('low_stocks', __('库存不足，请重新选择！', 'cart'));
		}
		/* end*/
		/* 处理商品库存 */
		$query = RC_DB::table('goods')->where('goods_id', $goods_id)->increment('goods_number', $number);
		if ($query && $products_query) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 散装商品库存重量增与减 
	 *
	 * @param   int	$good_id		 商品ID
	 * @param   int	$weight		  增减重量，默认0；
	 *
	 * @return  bool			   true，成功；false，失败；
	 */
	public static function change_bulkgoods_storage($goods_id, $weight = 0) {
		if (abs($weight) == 0.000) {
			return true;
			// 值为0即不做、增减操作，返回true
		}
		if (empty($goods_id) || empty($weight)) {
			return false;
		}
	
		$goods_weight_stock = RC_DB::table('goods')->where('goods_id', $goods_id)->pluck('weight_stock');
		//减库存重量，库存不足减时不做处理，返回true
		if ($weight < 0) {
			if ($goods_weight_stock < abs($weight)) {
				return true;
			}
		}
		
		/* 处理商品库存 */
		$query = RC_DB::table('goods')->where('goods_id', $goods_id)->increment('weight_stock', $weight);
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
}	


// end