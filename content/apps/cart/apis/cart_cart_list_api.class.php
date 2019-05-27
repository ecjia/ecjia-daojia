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
 * @author will.chen
 */
 
class cart_cart_list_api extends Component_Event_Api {
    /**
     * @param
     *
     * @return array
     */
	public function call(&$options) {
	    RC_Loader::load_app_func('cart', 'cart');
	    recalculate_price();
		return $this->get_cart_goods($options['cart_id'], $options['flow_type'], $options['store_group']);
	}

	/**
	 * 获得购物车中的商品
	 *
	 * @access  public
	 * @return  array
	 */
	private function get_cart_goods($cart_id = array(), $flow_type = CART_GENERAL_GOODS, $store_group = array()) {
		$dbview_cart = RC_DB::table('cart as c')
					   ->leftJoin('goods as g', RC_DB::raw('c.goods_id'), '=', RC_DB::raw('g.goods_id'))
					   ->leftJoin('store_franchisee as s', RC_DB::raw('s.store_id'), '=', RC_DB::raw('c.store_id'));

		/* 初始化 */
		$goods_list = array();
		$total = array(
			'goods_price'  => 0, // 本店售价合计（有格式）
			'market_price' => 0, // 市场售价合计（有格式）
			'saving'       => 0, // 节省金额（有格式）
			'save_rate'    => 0, // 节省百分比
			'goods_amount' => 0, // 本店售价合计（无格式）
	        'goods_number' => 0, // 商品总件数
		);
		$dbview_cart->where(RC_DB::raw('c.rec_type'), '=', $flow_type);
		$dbview_cart->where(RC_DB::raw('s.shop_close'), '=', '0');

		/* 符合店铺条件*/
		if (!empty($store_group)) {
			$dbview_cart->whereIn(RC_DB::raw('c.store_id'), $store_group);
		}

		/* 选择购买 */
		if (!empty($cart_id)) {
			$dbview_cart->whereIn(RC_DB::raw('c.rec_id'), $cart_id);
		}
		if ($_SESSION['user_id']) {
			$dbview_cart->where(RC_DB::raw('c.user_id'), $_SESSION['user_id']);
		} else {
		    $dbview_cart->where(RC_DB::raw('c.session_id'), RC_Session::getId());
		}
		
		/* 循环、统计 */
		$data = $dbview_cart
			->select(RC_DB::raw("c.*,IF(c.parent_id, c.parent_id, c.goods_id) AS pid, g.goods_thumb, g.goods_img, g.original_img, g.goods_number as g_goods_number, g.is_on_sale, g.is_delete, s.merchants_name as store_name, manage_mode"))
			->orderBy('add_time', 'desc')->orderBy('rec_id', 'desc')
			->get();
		/* 用于统计购物车中实体商品和虚拟商品的个数 */
		$virtual_goods_count = 0;
		$real_goods_count    = 0;

		if (!empty($data)) {
			foreach ($data as $row) {
			    $row['is_disabled'] = 0;
			    $row['disabled_label'] = '';
			    //判断库存
			    if ($row['g_goods_number'] < $row['goods_number'] || $row['g_goods_number'] < 1) {
			        $row['is_disabled'] = 1;
			        $row['disabled_label'] = __('库存不足', 'cart');
			    }
			    //判断上架状态
			    if ($row['is_on_sale'] == 0 || $row['is_delete'] == '1') {
			        $row['is_disabled'] = 1;
			        $row['disabled_label'] = __('商品已下架', 'cart');
			    }
			    //不可用状态，取消选中
			    if ($row['is_disabled'] == 1) {
			        $row['is_checked'] = 0;
			        
			        RC_Loader::load_app_class('cart', 'cart', false);
			        cart::flow_check_cart_goods(array('id' => $row['rec_id'], 'is_checked' => 0));
			    }
			    
			    //增加购物车选中状态判断  by hyy
			    if ($row['is_checked'] == 1) {
			        $total['goods_price']  += $row['goods_price'] * $row['goods_number'];
			        $total['market_price'] += $row['market_price'] * $row['goods_number'];
			    }
			    
			    $total['goods_number'] += $row['goods_number'];
				$row['subtotal']     	= $row['goods_price'] * $row['goods_number'];
				$row['formatted_subtotal']     	= ecjia_price_format($row['goods_price'] * $row['goods_number'], false);
				/* 返回未格式化价格*/
				$row['goods_price']		= $row['goods_price'];
				$row['market_price']	= $row['market_price'];

				$row['formatted_goods_price']  	= ecjia_price_format($row['goods_price'], false);
				$row['formatted_market_price'] 	= ecjia_price_format($row['market_price'], false);

				/* 统计实体商品和虚拟商品的个数 */
				if ($row['is_real']) {
					$real_goods_count++;
				} else {
					$virtual_goods_count++;
				}

				/* 查询规格 */
				if (trim($row['goods_attr']) != '') {
					$row['goods_attr'] = addslashes(str_replace('\n', '', $row['goods_attr']));
					if (!is_array($row['goods_attr_id'])) {
					    $where_attr['goods_attr_id'] = explode(',', $row['goods_attr_id']);
					}
// 					$attr_list = $db_goods_attr->select('attr_value')->whereIn('goods_attr_id', $where_attr['goods_attr_id'])->get();
// 					foreach ($attr_list AS $attr) {
// 						$row['goods_name'] .= ' [' . $attr['attr_value'] . '] ';
// 					}
				}
				
				//货品图片兼容处理
				if($row['product_id'] > 0) {
					 $product_info = RC_DB::table('products')
				        ->where('goods_id', $row['goods_id'])
				        ->where('product_id', $row['product_id'])
				        ->first();

				  	 if (!empty($product_info['product_thumb'])) {
				  	 	$row['goods_thumb'] = $product_info['product_thumb'];
				  	 }
				  	 if (!empty($product_info['product_img'])) {
				  	 	$row['goods_img'] = $product_info['product_img'];
				  	 }
				  	 if (!empty($product_info['product_original_img'])) {
				  	 	$row['original_img'] = $product_info['product_original_img'];
				  	 }
				} else {
					$product_info = [];
				}
				
				//库存 181023 add
				$row['attr_number'] = 1;//有货
				if (ecjia::config('use_storage') == 1) {
				    if($row['product_id']) {
				        //product_id变动TODO
				        if ($product_info && $row['goods_number'] > $product_info['product_number']) {
				            $row['attr_number'] = 0;
				        }
				    } else {
				        if($row['goods_number'] > $row['g_goods_number']) {
				            $row['attr_number'] = 0;
				        }
				    }
				}
				//库存 181023 end

// 				if ($row['extension_code'] == 'package_buy') {
// 					$row['package_goods_list'] = get_package_goods($row['goods_id']);
// 				}
				$row['is_checked']	= $row['is_checked'];
				$row['goods_name']  = rc_stripslashes($row['goods_name']);
 				$goods_list[] = $row;
			}
		}
		$total['goods_amount'] = $total['goods_price'];
		$total['saving']       = ecjia_price_format($total['market_price'] - $total['goods_price'], false);
		if ($total['market_price'] > 0) {
			$total['save_rate'] = $total['market_price'] ? round(($total['market_price'] - $total['goods_price']) * 100 / $total['market_price']).'%' : 0;
		}
		$total['unformatted_goods_price']  	= sprintf("%.2f", $total['goods_price']);
		$total['goods_price']  				= ecjia_price_format($total['goods_price'], false);
		$total['unformatted_market_price'] 	= sprintf("%.2f", $total['market_price']);
		$total['market_price'] 				= ecjia_price_format($total['market_price'], false);
		$total['real_goods_count']    		= $real_goods_count;
		$total['virtual_goods_count'] 		= $virtual_goods_count;

		return array('goods_list' => $goods_list, 'total' => $total);
	}
}

// end