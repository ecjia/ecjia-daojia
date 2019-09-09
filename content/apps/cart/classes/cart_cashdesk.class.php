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
use Ecjia\App\Cart\Enums\CartEnum;

defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 收银台购物车
 */
class cart_cashdesk {
	
	/**
	 * 取得购物车商品
	 * @param   int     $type   类型：默认普通商品
	 * @return  array   购物车商品数组 ；2018-09-05增加是否散装商品返回值 is_bulk
	 */
	public static function cashdesk_cart_goods($type = null, $cart_id = array(), $pendorder_id = 0) {

	    if (is_null($type)) {
	        $type = \Ecjia\App\Cart\Enums\CartEnum::CART_CASHDESK_GOODS;
        }

		$arr = [];
		
		$db	= RC_DB::table('cart as c')->leftJoin('goods as g', RC_DB::raw('c.goods_id'), '=', RC_DB::raw('g.goods_id'));
		$db->where(RC_DB::raw('c.rec_type'), $type);
		if (!empty($cart_id) && is_array($cart_id)) {
			$db->whereIn(RC_DB::raw('c.rec_id'), $cart_id);
		}
		if (!empty($pendorder_id)) {
			$db->where(RC_DB::raw('c.pendorder_id'), $pendorder_id);
		} else{
			$db->where(RC_DB::raw('c.pendorder_id'), 0);
		}
		if (!empty($_SESSION['store_id'])) {
			$db->where(RC_DB::raw('c.store_id'), $_SESSION['store_id']);
		}
		
		if ($_SESSION['user_id'] > 0) {
			$db->where(RC_DB::raw('c.user_id'), $_SESSION['user_id']);
		} else {
			$db->where(RC_DB::raw('c.user_id'), 0);
		}
		
		
		if ($_SESSION['device_id']) {
			$db->where(RC_DB::raw('c.session_id'), $_SESSION['device_id']);
		}
		
		$field = 'g.store_id, goods_img, original_img, goods_thumb, c.rec_id, c.goods_buy_weight, c.user_id, c.goods_id, c.goods_name, c.goods_sn, c.goods_number, c.market_price, c.goods_price, c.goods_attr, c.is_real, c.extension_code, c.parent_id, c.is_gift, c.is_shipping, (c.goods_price * c.goods_number) as subtotal, goods_weight as goodsWeight, c.goods_attr_id, c.product_id';
		$arr		  = $db->select(RC_DB::raw($field))->get();
		
		/* 格式化价格及礼包商品 */
		if (!empty($arr)) {
			foreach ($arr as $key => $value) {
				$arr[$key]['formated_market_price'] = price_format($value['market_price'], false);
				$arr[$key]['formated_goods_price']  = $value['goods_price'] > 0 ? price_format($value['goods_price'], false) : __('免费', 'cart');
				$arr[$key]['formated_subtotal']     = price_format($value['subtotal'], false);
			
				$store_group[] = $value['store_id'];
				$goods_attr_gourp = array();
				if (!empty($value['goods_attr'])) {
					$goods_attr = explode("\n", $value['goods_attr']);
					$goods_attr = array_filter($goods_attr);
					foreach ($goods_attr as  $v) {
						$a = explode(':',$v);
						if (!empty($a[0]) && !empty($a[1])) {
							$goods_attr_gourp[] = array('name' => $a[0], 'value' => $a[1]);
						}
					}
				}
				$arr[$key]['goods_attr_new'] 	= empty($value['goods_attr']) ? '' : trim($value['goods_attr']);
				$arr[$key]['attr'] 			 	=  $value['goods_attr'];
				$arr[$key]['goods_attr'] 		=  $goods_attr_gourp;
				$arr[$key]['goods_buy_weight'] 	= $value['goods_buy_weight'] > 0 ? $value['goods_buy_weight'] : '';
			
				RC_Loader::load_app_func('global', 'goods');
				//货品图片兼容处理
				if($value['product_id'] > 0) {
					$product_info = RC_DB::table('products')
					->where('goods_id', $value['goods_id'])
					->where('product_id', $value['product_id'])
					->first();
				
					if (!empty($product_info['product_thumb'])) {
						$value['goods_thumb'] = $product_info['product_thumb'];
					}
					if (!empty($product_info['product_img'])) {
						$value['goods_img'] = $product_info['product_img'];
					}
					if (!empty($product_info['product_original_img'])) {
						$value['original_img'] = $product_info['product_original_img'];
					}
				} 
				$arr[$key]['img'] = array(
						'thumb'	=> get_image_path($value['goods_id'], $value['goods_img'], true),
						'url'	=> get_image_path($value['goods_id'], $value['original_img'], true),
						'small' => get_image_path($value['goods_id'], $value['goods_thumb'], true),
				);
				unset($arr[$key]['goods_thumb']);
				unset($arr[$key]['goods_img']);
				unset($arr[$key]['original_img']);
					
				if ($value['extension_code'] == 'package_buy') {
					$arr[$key]['package_goods_list'] = get_package_goods($value['goods_id']);
				}
				if ($value['extension_code'] == 'bulk') {
					$arr[$key]['is_bulk'] = 1;
				} else {
					$arr[$key]['is_bulk'] = 0;
				}
				$arr[$key]['store_name'] = RC_DB::table('store_franchisee')->where('store_id', $value['store_id'])->pluck('merchants_name');
			}
		}

		return $arr;
	}
	
	
	/**
	 * 重新计算购物车中的商品价格：目的是当用户登录时享受会员价格，当用户退出登录时不享受会员价格
	 * 如果商品有促销，价格不变
	 * @access public
	 * @return void
	 * @update 180719 选择性更新内容
	 */
	public static function recalculate_price($device = array(), $store_id = 0, $user_id = 0) {
		$codes = config('app-cashier::cashier_device_code');
		if (!empty($device)) {
			if (in_array($device['code'], $codes)) {
				$rec_type = \Ecjia\App\Cart\Enums\CartEnum::CART_CASHDESK_GOODS;
			}
		} else {
			$rec_type = \Ecjia\App\Cart\Enums\CartEnum::CART_GENERAL_GOODS;
		}
	
		$discount = $_SESSION['discount'];
		$user_rank = $_SESSION['user_rank'];
		$field = "c.rec_id, c.extension_code, c.goods_id, c.goods_attr_id, g.promote_price, g.promote_start_date, c.goods_number,g.promote_end_date, IFNULL(mp.user_price, g.shop_price * $discount) AS member_price";
		
		$db = RC_DB::table('cart as c')
		->leftJoin('goods as g', RC_DB::raw('c.goods_id'), '=', RC_DB::raw('g.goods_id'))
		->leftJoin('member_price as mp', function($join)use($user_rank) {
			$join->where(RC_DB::raw('mp.goods_id'), '=', RC_DB::raw('g.goods_id'))
			->where(RC_DB::raw('mp.user_rank'), '=', $user_rank);
		})
		->select(RC_DB::raw($field));
		
		if (!empty($store_id)) {
			$db->where(RC_DB::raw('c.store_id'), $store_id);
		}
			
		/* 取得有可能改变价格的商品：除配件和赠品之外的商品 */
		// @update 180719 选择性更新内容mark_changed=1
		if ($user_id > 0) {
			$res = $db
			->where(RC_DB::raw('c.mark_changed'), 1)
			->where(RC_DB::raw('c.user_id'), $user_id)
			->where(RC_DB::raw('c.parent_id'), 0)
			->where(RC_DB::raw('c.is_gift'), 0)
			->where(RC_DB::raw('c.goods_id'), '>', 0)
			->where(RC_DB::raw('c.rec_type'), $rec_type)
			->get();
	
		} else {
			$res = $db
			->where(RC_DB::raw('c.mark_changed'), 1)
			->where(RC_DB::raw('c.user_id'), 0)
			->where(RC_DB::raw('c.parent_id'), 0)
			->where(RC_DB::raw('c.is_gift'), 0)
			->where(RC_DB::raw('c.goods_id'), '>', 0)
			->where(RC_DB::raw('c.rec_type'), $rec_type)
			->get();
		}
	
	
		if (! empty($res)) {
			RC_Loader::load_app_func('global', 'goods');
			foreach ($res as $row) {
				if ($row['extension_code'] != 'bulk') {
					$attr_id = empty($row['goods_attr_id']) ? array() : explode(',', $row['goods_attr_id']);
					$goods_price = get_final_price($row['goods_id'], $row['goods_number'], true, $attr_id);
					$data = array(
							'goods_price' => $goods_price,
							'mark_changed' => 0
					);
					if ($_SESSION['user_id']) {
						RC_DB::table('cart')->where('goods_id', $row['goods_id'])->where('user_id', $user_id)->where('rec_id', $row['rec_id'])->update($data);
					} else {
						RC_DB::table('cart')->where('goods_id', $row['goods_id'])->where('rec_id', $row['rec_id'])->update($data);
					}
				}
			}
		}
		/* 删除赠品，重新选择 */
		if ($user_id > 0) {
			RC_DB::table('cart')->where('store_id', $store_id)->where('user_id', $user_id)->where('is_gift', '>', 0)->delete();
		} else {
			RC_DB::table('cart')->where('store_id', $store_id)->where('user_id', 0)->where('is_gift', '>', 0)->delete();
		}
	}
	
	
	/**
	 * 添加商品到购物车
	 *
	 * @access  public
	 * @param   integer $goods_id   商品编号
	 * @param   integer $num        商品数量
	 * @param   array   $spec       规格值对应的id数组
	 * @param   integer $parent     基本件
	 * @return  boolean
	 */
	public static function addto_cart($goods_id, $num =1, $spec = array(), $parent = 0, $price = 0, $weight = 0, $flow_type = null, $pendorder_id = 0) {
        if (is_null($flow_type)) {
            $flow_type = \Ecjia\App\Cart\Enums\CartEnum::CART_GENERAL_GOODS;
        }

		$_parent_id 	= $parent;
		$num			= empty($num) ? 1 : $num;
		RC_Loader::load_app_func('admin_order', 'orders');
		RC_Loader::load_app_func('admin_goods', 'goods');
		RC_Loader::load_app_func('global', 'goods');
	
		if (empty($pendorder_id)) {
			$pendorder_id = 0;
		}
		
		$field = "g.goods_id, g.market_price, g.goods_name, g.goods_sn, g.weight_unit, g.is_on_sale, g.is_real, g.store_id as store_id, g.model_inventory, g.model_attr, ".
				"g.is_xiangou, g.xiangou_start_date, g.xiangou_end_date, g.xiangou_num, "."g.model_price, g.market_price, ".
		"g.promote_price as promote_price, ".
		" g.promote_start_date, g.promote_end_date, g.goods_weight, g.integral, g.extension_code, g.goods_number, g.is_alone_sale, g.is_shipping, ".
		"IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price ";
		
		/* 取得商品信息 */
		$user_rank = empty($_SESSION['user_rank']) ? 0 : $_SESSION['user_rank'];
		$dbview = RC_DB::table('goods as g')
						->leftJoin('member_price as mp', function ($join)use($user_rank) {
							$join->on(RC_DB::raw('mp.goods_id'), '=', RC_DB::raw('g.goods_id'))
							->where(RC_DB::raw('mp.user_rank'), '=', $user_rank);
						});
						
		$dbview->where(RC_DB::raw('g.goods_id'), $goods_id)->where(RC_DB::raw('g.is_delete'), 0);
		
		if (ecjia::config('review_goods') == 1) {
			$dbview->where(RC_DB::raw('g.review_status'), '>', 2);
		}
		
		$goods = $dbview->select(RC_DB::raw($field))->first();
		
		if (empty($goods)) {
			return new ecjia_error('no_goods', __('对不起，指定的商品不存在！', 'cart'));
		}
		/* 是否正在销售 */
		if ($goods['is_on_sale'] == 0) {
			return new ecjia_error('addcart_error', __('购买失败', 'cart'));
		}
		/* 如果是作为配件添加到购物车的，需要先检查购物车里面是否已经有基本件 */
		if ($parent > 0) {
			$dbcart = RC_DB::table('cart');
			if (!empty($_SESSION['user_id'])) {
				$dbcart->where('user_id', $_SESSION['user_id']);
			} else {
				$dbcart->where('user_id', 0);
			}
			if (!empty($_SESSION['store_id'])) {
				$dbcart->where('store_id', $_SESSION['store_id']);
			}
			$count = $dbcart->where('goods_id', $parent)->count();
			 
			if ($count == 0) {
				return new ecjia_error('addcart_error', __('对不起，您希望将该商品做为配件购买，可是购物车中还没有该商品的基本件。', 'cart'));
			}
		}
	
		/* 不是配件时检查是否允许单独销售 */
		if (empty($parent) && $goods['is_alone_sale'] == 0) {
			return new ecjia_error('addcart_error', __('购买失败', 'cart'));
		}
		/* 如果商品有规格则取规格商品信息 配件除外 */
		$prod = RC_DB::table('products')->where('goods_id', $goods_id)->count();
		if (is_spec($spec) && $prod > 0) {
			//$product_info = get_products_info($goods_id, $spec);
			$goods_attr = implode ( '|', $spec);
			$product_info = RC_DB::table('products')->where('goods_id', $goods_id)->where('goods_attr', $goods_attr)->first();
			if (empty($product_info)) {
				return new ecjia_error('low_stocks', __('暂无此货品！', 'cart'));
			}
		}
		if (empty($product_info)) {
			$product_info = array('product_number' => 0, 'product_id' => 0 , 'goods_attr'=>'');
		}
	
		/* 检查：库存 */
		if (ecjia::config('use_storage') == 1) {
			//检查：商品购买数量是否大于总库存
			if ($num > $goods['goods_number']) {
				return new ecjia_error('low_stocks', __('库存不足', 'cart'));
			}
			//商品存在规格 是货品 检查该货品库存
			if (is_spec($spec) && !empty($prod)) {
				if (!empty($spec)) {
					/* 取规格的货品库存 */
					if ($num > $product_info['product_number']) {
						return new ecjia_error('low_stocks', __('货品库存不足', 'cart'));
					}
				}
			}
		}
	
		/* 计算商品的促销价格 */
		$spec_price             = spec_price($spec, $goods_id);
		$goods_price            = get_final_price($goods_id, $num, true, $spec, $product_info['product_id']);
		$goods_attr             = get_goods_attr_info($spec, 'pice');
		$goods_attr_id          = join(',', $spec);
	
		/*收银台商品购物车类型*/
		$rec_type = !empty($flow_type) ? intval($flow_type) : \Ecjia\App\Cart\Enums\CartEnum::CART_GENERAL_GOODS;
	
		/* 初始化要插入购物车的基本件数据 */
		$parent = array(
				'user_id'       => empty($_SESSION['user_id']) ? 0 : $_SESSION['user_id'],
				'session_id'	=> $_SESSION['device_id'],  //收银台购物车，此字段存储的值为设备收银设备id
				'goods_id'      => $goods_id,
				'goods_sn'      => $product_info['product_id'] > 0 ? addslashes($product_info['product_sn']) : addslashes($goods['goods_sn']),
				'product_id'    => $product_info['product_id'],
				'goods_name'    => addslashes($goods['goods_name']),
				'market_price'  => $goods['market_price'],
				'goods_attr'    => addslashes($goods_attr),
				'goods_attr_id' => $goods_attr_id,
				'is_real'       => $goods['is_real'],
				'extension_code'=> $goods['extension_code'],
				'is_gift'       => 0,
				'is_shipping'   => $goods['is_shipping'],
				'rec_type'      => $rec_type,
				'store_id'		=> $goods['store_id'],
				'add_time'      => RC_Time::gmtime()
		);
	
		//货品自定义名称
		if (!empty($product_info['product_name'])) {
			$parent['goods_name'] = addslashes($product_info['product_name']);
		}
		
		/* 如果该配件在添加为基本件的配件时，所设置的“配件价格”比原价低，即此配件在价格上提供了优惠， */
		/* 则按照该配件的优惠价格卖，但是每一个基本件只能购买一个优惠价格的“该配件”，多买的“该配件”不享受此优惠 */
		$basic_list = array();
		$data	= RC_DB::table('group_goods')->select('parent_id', 'goods_price')->where('goods_id', $goods_id)->where('goods_price', '<', $goods_price)->where('parent_id', $_parent_id)->orderBy('goods_price', 'asc')->get();
		if (!empty($data)) {
			foreach ($data as $row) {
				$basic_list[$row['parent_id']] = $row['goods_price'];
			}
		}
		/* 取得购物车中该商品每个基本件的数量 */
		$basic_count_list = array();
		if ($basic_list) {
			$db_basic_cart = RC_DB::table('cart');
			if (!empty($_SESSION['user_id'])){
				$db_basic_cart->where('user_id', $_SESSION['user_id']);
			} else {
				$db_basic_cart->where('user_id', 0);
			}
			if (!empty($_SESSION['store_id'])) {
				$db_basic_cart->where('store_id', $_SESSION['store_id']);
			}
			if (!empty(array_keys($basic_list))){
				$db_basic_cart->whereIn('goods_id', array_keys($basic_list));
			}
			$data = $db_basic_cart->where('parent_id', 0)->select(RC_DB::raw('goods_id, SUM(goods_number) as count'))->orderBy('goods_id', 'asc')->get();
			if(!empty($data)) {
				foreach ($data as $row) {
					$basic_count_list[$row['goods_id']] = $row['count'];
				}
			}
		}
		/* 取得购物车中该商品每个基本件已有该商品配件数量，计算出每个基本件还能有几个该商品配件 */
		/* 一个基本件对应一个该商品配件 */
		if ($basic_count_list) {
			$dbcart_basic_count = RC_DB::table('cart');
			if (!empty($_SESSION['user_id'])){
				$dbcart_basic_count->where('user_id', $_SESSION['user_id']);
			} else {
				$dbcart_basic_count->where('user_id', 0);
			}
			if (!empty($_SESSION['store_id'])) {
				$dbcart_basic_count->where('store_id', $_SESSION['store_id']);
			}
			if (!empty(array_keys($basic_count_list))) {
				$dbcart_basic_count->whereIn('goods_id', array_keys($basic_count_list));
			}
			$data = $dbcart_basic_count->where('goods_id', $goods_id)->select(RC_DB::raw('parent_id, SUM(goods_number) as count'))->orderBy('parent_id', 'asc')->get();
			if(!empty($data)) {
				foreach ($data as $row) {
					$basic_count_list[$row['parent_id']] -= $row['count'];
				}
			}
		}
	
		/* 循环插入配件 如果是配件则用其添加数量依次为购物车中所有属于其的基本件添加足够数量的该配件 */
		foreach ($basic_list as $parent_id => $fitting_price) {
			/* 如果已全部插入，退出 */
			if ($num <= 0) {
				break;
			}
	
			/* 如果该基本件不再购物车中，执行下一个 */
			if (!isset($basic_count_list[$parent_id])) {
				continue;
			}
	
			/* 如果该基本件的配件数量已满，执行下一个基本件 */
			if ($basic_count_list[$parent_id] <= 0) {
				continue;
			}
	
			/* 作为该基本件的配件插入 */
			$parent['goods_price']  = max($fitting_price, 0) + $spec_price; //允许该配件优惠价格为0
			$parent['goods_number'] = min($num, $basic_count_list[$parent_id]);
			$parent['parent_id']    = $parent_id;
	
	
			/* 添加 */
			RC_DB::table('cart')->insert($parent);
			/* 改变数量 */
			$num -= $parent['goods_number'];
		}
	
		/* 如果数量不为0，作为基本件插入 */
		if ($num > 0) {
			/* 检查该商品是否已经存在在购物车中 */
			$db_cart = RC_DB::table('cart');
			$db_cart->where('goods_id', $goods_id)
					->where('parent_id', 0)
					->where('rec_type', $rec_type)
					->where('pendorder_id', $pendorder_id);
			
			if (!empty($goods_attr)) {
				$db_cart->where('goods_attr', $goods_attr);
			}
			
			if ($_SESSION['user_id'] > 0) {
				$db_cart->where('user_id', $_SESSION['user_id']);
			} else {
				$db_cart->where('user_id', 0);
			}

			if (!empty($_SESSION['store_id'])) {
				$db_cart->where('store_id', $_SESSION['store_id']);
			}
			//当前设备id
			if ($_SESSION['device_id']) {
				$db_cart->where('session_id', $_SESSION['device_id']);
			}
			$row = $db_cart->first();
			
			$product_id = 0;
			
			if($row) {
				$product_id = $row['product_id'];
				if (empty($price) && empty($weight)) {
					//非散装商品
					if(is_spec($spec) && !empty($prod) ) {
						$goods_storage = $product_info['product_number'];
					} else {
						$goods_storage = $goods['goods_number'];
					}
					//如果购物车已经有此物品，则更新
					$cart_id = $row['rec_id'];
					if ($row['pendorder_id'] > 0) { //当前数据为挂单数据
						if (!empty($pendorder_id)) { //当前操作为挂单继续添加
							if ($row['pendorder_id'] == $pendorder_id) { //当前挂单id与此数据挂单id相同，直接更新
								$num += $row['goods_number'];
								if (ecjia::config('use_storage') == 0 || $num <= $goods_storage) {
									$goods_price = get_final_price($goods_id, $num, true, $spec, $row['product_id']);
									$data =  array(
											'goods_number' => $num,
											'goods_price'  => $goods_price,
									);
									$db_cart_update = RC_DB::table('cart');
									if (!empty($_SESSION['store_id'])) {
										$db_cart_update->where('store_id', $_SESSION['store_id']);
									}
									if ($_SESSION['user_id'] > 0) {
										$db_cart_update->where('user_id', $_SESSION['user_id']);
									} else {
										$db_cart_update->where('user_id', 0);
									}
									
									if (!empty($goods_attr)) {
										$db_cart_update->where('goods_attr', $goods_attr);
									}
									//当前设备id
									if ($_SESSION['device_id']) {
										$db_cart_update->where('session_id', $_SESSION['device_id']);
									}
									$db_cart_update->where('goods_id', $goods_id)->where('parent_id', 0)->where('rec_type', $rec_type)->where('pendorder_id', $pendorder_id)->update($data);
								} else {
									return new ecjia_error('low_stocks', __('库存不足', 'cart'));
								}
							} 
						} else { //当前操作为非挂单添加
							$goods_price = get_final_price($goods_id, $num, true, $spec, $row['product_id']);
							$parent['goods_price']  = max($goods_price, 0);
							$parent['goods_number'] = $num;
							$parent['parent_id']    = 0;
							$cart_id = RC_DB::table('cart')->insertGetId($parent);
						}
					} else { //当前数据为非挂单数据
						if (!empty($pendorder_id)) { //当前操作为挂单继续添加
							$goods_price = get_final_price($goods_id, $num, true, $spec, $row['product_id']);
							$parent['goods_price']  = max($goods_price, 0);
							$parent['goods_number'] = $num;
							$parent['parent_id']    = 0;
							$cart_id = RC_DB::table('cart')->insertGetId($parent);
						} else {  //当前操作为非挂单添加
							$num += $row['goods_number'];
							
							if ($row['pendorder_id'] == $pendorder_id) { //当前挂单id与此数据挂单id相同，直接更新
								if (ecjia::config('use_storage') == 0 || $num <= $goods_storage) {
									$goods_price = get_final_price($goods_id, $num, true, $spec, $row['product_id']);
									$data =  array(
											'goods_number' => $num,
											'goods_price'  => $goods_price,
									);
									
									$db_update_cart = RC_DB::table('cart');
									
									if (!empty($_SESSION['store_id'])) {
										$db_update_cart->where('store_id', $_SESSION['store_id']);
									}
									if ($_SESSION['user_id'] > 0) {
										$db_update_cart->where('user_id', $_SESSION['user_id']);
									} else {
										$db_update_cart->where('user_id', 0);
									}

									if (!empty($goods_attr)) {
										$db_update_cart->where('goods_attr', $goods_attr);
									}
									//当前设备id
									if ($_SESSION['device_id']) {
										$db_update_cart->where('session_id', $_SESSION['device_id']);
									}
									$db_update_cart->where('goods_id', $goods_id)->where('parent_id', 0)->where('rec_type', $rec_type)->where('pendorder_id', $pendorder_id)->update($data);
								} else {
									return new ecjia_error('low_stocks', __('库存不足', 'cart'));
								}
							}
						}
					}
				} else {
					//是散装商品；散装商品不更新数量，新增记录
					$num = 1;
					$goods_price = get_final_price($goods_id, $num, true, $spec);
					$parent['goods_price']  = max($goods_price, 0);
					$parent['goods_number'] = $num;
					$parent['parent_id']    = 0;
					$parent['extension_code']  = !empty($goods['extension_code']) ? $goods['extension_code'] : '';
					//传的是总重量（克）；cart表goods_buy_weight字段存千克
					
					$weight = $weight/1000;//换算成千克
					
					if (!empty($weight) && empty($price)) {
						//根据重量获取散装商品总价
						$total_bulkgoods_price = self::get_total_bulkgoods_price(array('weight' => $weight, 'goods_price' => $parent['goods_price'], 'weight_unit' => $goods['weight_unit'], 'goods_id' => $goods_id));
						$parent['goods_price'] = self::formated_price_bulk($total_bulkgoods_price);
						$parent['goods_buy_weight'] = self::formated_weight_bulk($weight);
					} elseif (empty($weight) && !empty($price)) {
						//根据商品货号找对应的电子秤设置信息
						//$weight_final = self::get_total_bulkgoods_weight(array('goods_sn' => $goods['goods_sn'], 'store_id' => $goods['store_id'], 'price' => $price, 'goods_price' => $parent['goods_price'], 'weight_unit' => $goods['weight_unit']));
						//根据总价获取散装商品总重量
						$parent['goods_price'] = self::formated_price_bulk($price);
						//$parent['goods_buy_weight'] = self::formated_weight_bulk($weight_final);
					} else {
						$parent['goods_price'] = self::formated_price_bulk($price);
						$parent['goods_buy_weight'] = self::formated_weight_bulk($weight);
					}
					$cart_id = RC_DB::table('cart')->insertGetId($parent);
				}
			} else {
				//购物车没有此物品，则插入
				$product_id = !empty($product_info['product_id']) ? $product_info['product_id'] : 0;
				$goods_price = get_final_price($goods_id, $num, true, $spec, $product_id);
				$parent['goods_price']  = max($goods_price, 0);
				$parent['goods_number'] = $num;
				$parent['parent_id']    = 0;
				//散装商品
				if ($goods['extension_code'] == 'bulk') {
					$num = 1;
					$goods_price = get_final_price($goods_id, $num, true, $spec );
					$parent['goods_price']  = max($goods_price, 0);
					$parent['goods_number'] = $num;
					$parent['extension_code']  = !empty($goods['extension_code']) ? $goods['extension_code'] : '';
					//换算成千克
					$weight = $weight/1000;
					
					if (!empty($weight) && empty($price)) {
						$total_bulkgoods_price = self::get_total_bulkgoods_price(array('weight' => $weight, 'goods_price' => $parent['goods_price'], 'weight_unit' => $goods['weight_unit'], 'goods_id' => $goods_id));
						$parent['goods_price'] = self::formated_price_bulk($total_bulkgoods_price);
						$parent['goods_buy_weight'] = $weight;
					} elseif (empty($weight) && !empty($price)) {
						//根据商品货号找对应的电子秤设置信息
						//$weight_final = self::get_total_bulkgoods_price(array('goods_sn' => $goods['goods_sn'], 'store_id' => $goods['store_id'], 'price' => $price, 'goods_price' => $parent['goods_price'], 'weight_unit' => $goods['weight_unit']));
						//根据总价获取散装商品总重量
						$parent['goods_price'] = self::formated_price_bulk($price);
						//$parent['goods_buy_weight'] = $weight_final;
					} else {
						$parent['goods_price'] = self::formated_price_bulk($price);
						$parent['goods_buy_weight'] = self::formated_weight_bulk($weight);
					}
				}
				
				$cart_id = RC_DB::table('cart')->insertGetId($parent);
			}
			
			/**
			 * 判断添加的商品有没在促销，在促销的话，判断促销限购数量
			 * （有没超过用户限购数， 有没超过活动限购数）；
			 * 更新购买记录；更新购物车价格
			 */
			if ($goods['extension_code'] != 'bulk') {
				$promotion = new \Ecjia\App\Goods\GoodsActivity\GoodsPromotion($goods_id, $product_id, $_SESSION['user_id']);
				$is_promote = $promotion->isPromote();
				if ($is_promote) {
					//收银台添加商品有添加会员时，限购总数和用户限购数判断
					if ($_SESSION['user_id'] > 0) {
						$left_num = $promotion->getLimitOverCount($num); //用户可购买的限购剩余数
						if ($left_num >= 0) {
							//购买数量大于限购可购买数量或者限购可购买数量等于0
							if ($num > $left_num || $left_num == 0) {
								$promotion->updateCartGoodsPrice($cart_id, $goods_id, $num, true, $spec, $product_id);
							}
						}
					} else {
						//收银台添加商品未添加会员时，限购总数判断
						if ($goods['product_id'] > 0) {
							$promotionInfo = $promotion->getProductPromotion();
						} else {
							$promotionInfo = $promotion->getGoodsPromotionInfo();
						}
						if ($num > $promotionInfo->promote_limited) {
							$promotion->updateCartGoodsPrice($cart_id, $goods_id, $num, true, $spec, $product_id);
						}
					}
				}
			}
		}
	
		/* 把赠品删除 */
		if ($_SESSION['user_id']) {
			RC_DB::table('cart')->where('store_id', $_SESSION['store_id'])->where('user_id', $_SESSION['user_id'])->where('is_gift', '>', 0)->delete();
		} else {
			RC_DB::table('cart')->where('store_id', $_SESSION['store_id'])->where('user_id', 0)->where('is_gift', '>', 0)->delete();
		}
		return $cart_id;
	}
	
	
	/**
	 * 更新购物车中的商品数量
	 * @access  public
	 * @param   array   $arr
	 * @return  void
	 */
	public static function flow_update_cart($arr) {
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
					return new ecjia_error('store_locked', __('对不起，该商品所属的店铺已锁定！', 'cart'));
				}
			}
	
			//查询：
			if ($_SESSION['user_id']) {
				$goods = RC_DB::table('cart')
				->select(RC_DB::raw('goods_id, goods_attr_id, product_id, extension_code'))
				->where('rec_id', $key)
				->where('user_id', $_SESSION['user_id'])
				->first();
	
			} else {
				$goods = RC_DB::table('cart')
				->select(RC_DB::raw('goods_id, goods_attr_id, product_id, extension_code'))
				->where('rec_id', $key)
				->where('user_id', 0)
				->first();
			}
			$row = RC_DB::table('goods as g')
			->leftJoin('cart as c', RC_DB::raw('g.goods_id'), '=', RC_DB::raw('c.goods_id'))
			->where(RC_DB::raw('c.rec_id'), $key)
			->select(RC_DB::raw('g.goods_number as g_number, c.*'))
			->first();
	
			//查询：系统启用了库存，检查输入的商品数量是否有效
			if (intval(ecjia::config('use_storage')) > 0 && $goods['extension_code'] != 'package_buy') {
				if ($row['g_number'] < $val) {
					return new ecjia_error('low_stocks', __('库存不足', 'cart'));
				}
				/* 是货品 */
				if (!empty($goods['product_id'])) {
					$goods['product_id'] = trim($goods['product_id']);
					if (!empty($goods['product_id'])) {
						$product_number = RC_DB::table('products')
						->where('goods_id', $goods['goods_id'])
						->where('product_id', $goods['product_id'])
						->pluck('product_number');
						 
						if ($product_number < $val) {
							return new ecjia_error('low_stocks', __('库存不足', 'cart'));
						}
					}
				}
			}  elseif (intval(ecjia::config('use_storage')) > 0 && $goods['extension_code'] == 'package_buy') {
				if (judge_package_stock($goods['goods_id'], $val)) {
					return new ecjia_error('low_stocks', __('库存不足', 'cart'));
				}
			}
	
			/* 查询：检查该项是否为基本件 以及是否存在配件 */
			/* 此处配件是指添加商品时附加的并且是设置了优惠价格的配件 此类配件都有parent_id goods_number为1 */
			if ($_SESSION['user_id']) {
				$offers_accessories_res = RC_DB::table('cart as a')
				->leftJoin('cart as b', RC_DB::raw('b.parent_id'), '=', RC_DB::raw('a.goods_id'))
				->where(RC_DB::raw('a.rec_id'), $key)
				->where(RC_DB::raw('a.user_id'), $_SESSION['user_id'])
				->where(RC_DB::raw('b.user_id'), $_SESSION['user_id'])
				->get();
			} else {
				$offers_accessories_res = RC_DB::table('cart as a')
				->leftJoin('cart as b', RC_DB::raw('b.parent_id'), '=', RC_DB::raw('a.goods_id'))
				->where(RC_DB::raw('a.rec_id'), $key)
				->where(RC_DB::raw('a.user_id'), 0)
				->where(RC_DB::raw('b.user_id'), 0)
				->get();
			}
	
			//订货数量大于0
			if ($val > 0) {
				/* 判断是否为超出数量的优惠价格的配件 删除*/
				$row_num = 1;
				if (!empty($offers_accessories_res)) {
					foreach ($offers_accessories_res as $offers_accessories_row) {
						if ($row_num > $val) {
							if ($_SESSION['user_id']) {
								RC_DB::table('cart')
								->where('user_id', $_SESSION['user_id'])
								->where('rec_id', $offers_accessories_row['rec_id'])
								->delete();
							} else {
								RC_DB::table('cart')
								->where('rec_id', $offers_accessories_row['rec_id'])
								->delete();
							}
						}
						$row_num ++;
					}
				}
	
				/* 处理超值礼包 */
				if ($goods['extension_code'] == 'package_buy') {
					//更新购物车中的商品数量
					if ($_SESSION['user_id']) {
						RC_DB::table('cart')
						->where('user_id', $_SESSION['user_id'])
						->where('rec_id', $key)
						->update(array('goods_number' => $val));
					} else {
						RC_DB::table('cart')
						->where('rec_id', $key)
						->update(array('goods_number' => $val));
					}
				}  else {
					/* 处理普通商品或非优惠的配件 */
					$attr_id = empty($goods['goods_attr_id']) ? array() : explode(',', $goods['goods_attr_id']);
					$goods_price = get_final_price($goods['goods_id'], $val, true, $attr_id, $goods['product_id']);
	
					//更新购物车中的商品数量
					if ($_SESSION['user_id']) {
						RC_DB::table('cart')
						->where('user_id', $_SESSION['user_id'])
						->where('rec_id', $key)
						->update(array('goods_number' => $val , 'goods_price' => $goods_price));
						
						/**
						 * 判断添加的商品有没在促销，在促销的话，判断促销限购数量
						 * （有没超过用户限购数， 有没超过活动限购数）；
						 * 更新购买记录；更新购物车价格
						 */
						$promotion = new \Ecjia\App\Goods\GoodsActivity\GoodsPromotion($goods['goods_id'], $goods['product_id'], $_SESSION['user_id']);
						$is_promote = $promotion->isPromote();
						if ($is_promote) {
							//收银台添加商品有添加会员时，限购总数和用户限购数判断
							if ($_SESSION['user_id'] > 0) {
								$left_num = $promotion->getLimitOverCount($val); //用户可购买的限购剩余数
								if ($left_num >= 0) {
									//购买数量大于限购可购买数量或者限购可购买数量等于0
									if ($val > $left_num || $left_num == 0) {
										$spec = $attr_id;
										$promotion->updateCartGoodsPrice($key, $goods_id, $val, true, $spec, $goods['product_id']);
									}
								}
							} else {
								//收银台添加商品未添加会员时，限购总数判断
								if ($goods['product_id'] > 0) {
									$promotionInfo = $promotion->getProductPromotion();
								} else {
									$promotionInfo = $promotion->getGoodsPromotionInfo();
								}
								if ($val > $promotionInfo->promote_limited) {
									$promotion->updateCartGoodsPrice($key, $goods_id, $val, true, $spec, $goods['product_id']);
								}
							}
						}
					} else {
						RC_DB::table('cart')
						->where('rec_id', $key)
						->update(array('goods_number' => $val , 'goods_price' => $goods_price));
					}
				}
			} else {
				//订货数量等于0
				/* 如果是基本件并且有优惠价格的配件则删除优惠价格的配件 */
				if (!empty($offers_accessories_res)) {
					foreach ($offers_accessories_res as $offers_accessories_row) {
						if ($_SESSION['user_id']) {
							RC_DB::table('cart')
							->where('user_id', $_SESSION['user_id'])
							->where('rec_id', $offers_accessories_row['rec_id'])
							->delete();
	
						} else {
							RC_DB::table('cart')
							->where('rec_id', $offers_accessories_row['rec_id'])
							->delete();
						}
					}
				}
	
				if ($_SESSION['user_id']) {
					RC_DB::table('cart')
					->where('user_id', $_SESSION['user_id'])
					->where('rec_id', $key)
					->delete();
				} else {
					RC_DB::table('cart')
					->where('rec_id', $key)
					->delete();
				}
			}
		}
	
		/* 删除所有赠品 */
		if ($_SESSION['user_id']) {
			RC_DB::table('cart')
			->where('user_id', $_SESSION['user_id'])
			->where('is_gift', '!=', 0)
			->delete();
		} else {
			RC_DB::table('cart')
			->where('user_id', 0)
			->where('is_gift', '!=', 0)
			->delete();
		}
	}
	
	/**
	 * 计算折扣：根据购物车和优惠活动
	 * @return  float   折扣
	 */
	public static function compute_discount($type = 0, $newInfo = array(), $cart_id = array(), $user_type = 0, $rec_type = null, $store_id = 0, $pendorder_id = 0) {
        if (is_null($rec_type)) {
            $rec_type = \Ecjia\App\Cart\Enums\CartEnum::CART_CASHDESK_GOODS;
        }

		$db_cartview	= RC_DB::table('cart as c')->leftJoin('goods as g', RC_DB::raw('c.goods_id'), '=', RC_DB::raw('g.goods_id'));
		$db				= RC_DB::table('favourable_activity');
		
		/* 查询优惠活动 */
		$now = RC_Time::gmtime();
		$user_rank = ',' . $_SESSION['user_rank'] . ',';
	
		$favourable_list   = $db->where('store_id', $store_id)->where('start_time', '<=', $now)->where('end_time', '>=', $now)->whereRaw("CONCAT(',', user_rank, ',') LIKE '%" . $user_rank . "%'")->whereIn('act_type', array(FAT_DISCOUNT, FAT_PRICE))->get();
		
		if (!$favourable_list) {
			return 0;
		}
	
		if ($type == 0) {
			/* 查询购物车商品 */
			$field = "c.goods_id, c.store_id, (c.goods_price * c.goods_number) AS subtotal, g.cat_id, g.brand_id";
			if (is_array($cart_id) && !empty($cart_id)) {
				$db_cartview->whereIn(RC_DB::raw('c.rec_id'), $cart_id);
			}
			if ($_SESSION['user_id'] > 0) {
				$db_cartview->where(RC_DB::raw('c.user_id'), $_SESSION['user_id']);
			} else {
				$db_cartview->where(RC_DB::raw('c.user_id'), 0);
			}
			if ($store_id > 0) {
				$db_cartview->where(RC_DB::raw('c.store_id'), $_SESSION['store_id']);
			}
			
			if (!empty($pendorder_id)) {
				$db->where(RC_DB::raw('c.pendorder_id'), $pendorder_id);
			} else{
				$db->where(RC_DB::raw('c.pendorder_id'), 0);
			}
			
			if ($_SESSION['device_id']) {
				$db->where(RC_DB::raw('c.session_id'), $_SESSION['device_id']);
			}
			
			$db_cartview->where(RC_DB::raw('c.parent_id'), 0)->where(RC_DB::raw('c.is_gift'), 0)->where(RC_DB::raw('c.rec_type'), $rec_type);
			$goods_list = $db_cartview->select(RC_DB::raw($field))->get();
			
		} elseif ($type == 2) {
			$goods_list = array();
			foreach ($newInfo as $key => $row) {
				$order_goods = RC_DB::table('goods')->where('goods_id', $row['goods_id'])->first();
				$goods_list[$key]['goods_id'] 	= $row['goods_id'];
				$goods_list[$key]['cat_id'] 	= $order_goods['cat_id'];
				$goods_list[$key]['brand_id'] 	= $order_goods['brand_id'];
				$goods_list[$key]['store_id'] 	= $row['store_id'];
				$goods_list[$key]['subtotal'] 	= $row['goods_price'] * $row['goods_number'];
			}
		}
	
		if (!$goods_list) {
			return 0;
		}
		
		/* 初始化折扣 */
		$discount = 0;
		$favourable_name = array();
		RC_Loader::load_app_func('admin_category', 'goods');
		/* 循环计算每个优惠活动的折扣 */
		foreach ($favourable_list as $favourable) {
			$total_amount = 0;
			if ($favourable['act_range'] == FAR_ALL) {
				foreach ($goods_list as $goods) {
					if ($user_type == 1) {
						if($favourable['store_id'] == $goods['store_id']){
							$total_amount += $goods['subtotal'];
						}
					} else {
						if (isset($favourable['userFav_type']) && $favourable['userFav_type'] == 1) {
							$total_amount += $goods['subtotal'];
						} else {
							if(isset($goods['store_id']) && $favourable['store_id'] == $goods['store_id']){
								$total_amount += $goods['subtotal'];
							}
						}
					}
				}
			} elseif ($favourable['act_range'] == FAR_CATEGORY) {
				/* 找出分类id的子分类id */
				$id_list = array();
				$raw_id_list = explode(',', $favourable['act_range_ext']);
				foreach ($raw_id_list as $id) {
					$id_list = array_merge($id_list, array_keys(cat_list($id, 0, false)));
				}
				$ids = join(',', array_unique($id_list));
	
				foreach ($goods_list as $goods) {
					if (strpos(',' . $ids . ',', ',' . $goods['cat_id'] . ',') !== false) {
						if ($user_type == 1) {
							if ($favourable['store_id'] == $goods['store_id'] && $favourable['userFav_type'] == 0) {
								$total_amount += $goods['subtotal'];
							}
						} else {
							if (isset($favourable['userFav_type']) && $favourable['userFav_type'] == 1) {
								$total_amount += $goods['subtotal'];
							} else {
								if ($favourable['store_id'] == $goods['store_id']) {
									$total_amount += $goods['subtotal'];
								}
							}
						}
					}
				}
			} elseif ($favourable['act_range'] == FAR_BRAND) {
				foreach ($goods_list as $goods) {
					if (strpos(',' . $favourable['act_range_ext'] . ',', ',' . $goods['brand_id'] . ',') !== false) {
						if ($user_type == 1) {
							if ($favourable['store_id'] == $goods['store_id']) {
								$total_amount += $goods['subtotal'];
							}
						} else {
							if (isset($favourable['userFav_type']) && $favourable['userFav_type'] == 1) {
								$total_amount += $goods['subtotal'];
							} else {
								if ($favourable['store_id'] == $goods['store_id']) {
									$total_amount += $goods['subtotal'];
								}
							}
						}
							
					}
				}
			} elseif ($favourable['act_range'] == FAR_GOODS) {
				foreach ($goods_list as $goods) {
					if (strpos(',' . $favourable['act_range_ext'] . ',', ',' . $goods['goods_id'] . ',') !== false) {
						if ($user_type == 1) {
							if ($favourable['store_id'] == $goods['store_id']) {
								$total_amount += $goods['subtotal'];
							}
						} else {
							if (isset($favourable['userFav_type']) && $favourable['userFav_type'] == 1) {
								$total_amount += $goods['subtotal'];
							} else {
								if ($favourable['store_id'] == $goods['store_id']) {
									$total_amount += $goods['subtotal'];
								}
							}
						}
					}
				}
			} else {
				continue;
			}
	
			/* 如果金额满足条件，累计折扣 */
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
				$discount = !empty($discount_temp) ? max($discount_temp) : 0.00;
				//优惠金额不能超过订单本身
				if ($total_amount && $discount > $total_amount) {
					$discount = $total_amount;
				}
			}
		}
		return array('discount' => $discount, 'name' => $favourable_name);
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
	public static function cashdesk_order_fee($order, $goods, $consignee = array(), $cart_id = array(), $rec_type = null, $pendorder_id = 0, $store_id = 0) {
        if (is_null($rec_type)) {
            $rec_type = \Ecjia\App\Cart\Enums\CartEnum::CART_CASHDESK_GOODS;
        }
	
		RC_Loader::load_app_func('global','goods');
		$pendorder_id = empty($pendorder_id) ? 0 : $pendorder_id;
		
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
		foreach ($goods AS $key => $val) {
			/* 统计实体商品的个数 */
			if ($val['is_real']) {
				$total['real_goods_count']++;
			}
	
			if ($val['extension_code'] == 'bulk') {
				//散装价格格式化
				$total['goods_price'] += $val['goods_price'] * $val['goods_number'];
				$total['goods_price'] = self::formated_price_bulk($total['goods_price']);
				$total['market_price'] += $val['market_price'] * $val['goods_number'];
				$total['market_price'] = self::formated_price_bulk($total['market_price']);
			} else {
				$total['goods_price']  += $val['goods_price'] * $val['goods_number'];
				$total['market_price'] += $val['market_price'] * $val['goods_number'];
			}
		}
	
		$total['saving']    = $total['market_price'] - $total['goods_price'];
		$total['save_rate'] = $total['market_price'] ? round($total['saving'] * 100 / $total['market_price']) . '%' : 0;
	
		$total['goods_price_formated']  = price_format($total['goods_price'], false);
		$total['market_price_formated'] = price_format($total['market_price'], false);
		$total['saving_formated']       = price_format($total['saving'], false);
	
		/* 折扣 */
		
		if ($order['extension_code'] != 'group_buy') {
			$discount = self::compute_discount(0, array(), $cart_id, 0, $rec_type, $store_id, $pendorder_id);
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
	
		$shipping_cod_fee = NULL;
		
		$total['shipping_fee']		= 0;
		$total['shipping_insure']	= 0;
		$total['shipping_fee_formated']    = price_format($total['shipping_fee'], false);
		$total['shipping_insure_formated'] = price_format($total['shipping_insure'], false);
	
		// 红包和积分最多能支付的金额为商品总额
		//$max_amount 还需支付商品金额=商品金额-红包-优惠-积分
		$max_amount = $total['goods_price'] == 0 ? $total['goods_price'] : $total['goods_price'] - $total['discount'];
	
	
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
		if (!empty($order['pay_id']) && ($total['real_goods_count'] > 0 || $se_flow_type != \Ecjia\App\Cart\Enums\CartEnum::CART_EXCHANGE_GOODS)) {
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
			$total['will_get_integral'] = self::get_give_integral( $cart_id, $rec_type);
		}
	
		$total['will_get_bonus']        = $order['extension_code'] == 'exchange_goods' ? 0 : price_format(get_total_bonus(), false);
		$total['formated_goods_price']  = price_format($total['goods_price'], false);
		$total['formated_market_price'] = price_format($total['market_price'], false);
		$total['formated_saving']       = price_format($total['saving'], false);
	
		return $total;
	}
	
	
	/**
	 * 获得订单信息
	 * @return  array
	 */
	public static function flow_order_info() {
		$order = isset($_SESSION['flow_order']) ? $_SESSION['flow_order'] : array();
	
		/* 初始化配送和支付方式 */
		if (!isset($order['shipping_id']) || !isset($order['pay_id'])) {
			/* 如果还没有设置配送和支付 */
			if ($_SESSION['user_id'] > 0) {
				/* 用户已经登录了，则获得上次使用的配送和支付 */
				$arr = last_shipping_and_payment();
	
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
		if (isset($_SESSION['flow_type']) && intval($_SESSION['flow_type']) != \Ecjia\App\Cart\Enums\CartEnum::CART_GENERAL_GOODS) {
			$order['extension_code'] 	= $_SESSION['extension_code'];
			$order['extension_id'] 		= $_SESSION['extension_id'];
		}
		return $order;
	}
	
	/**
	 * 获得电子秤信息
	 * @param   array   $options
	 * @return  array
	 */
	public static function get_scales_info($options) {
		$scales_info = [];
		if (!empty($options['store_id']) && !empty($options['scale_sn'])) {
			$scales_info = RC_DB::table('cashier_scales')->where('scale_sn', $options['scale_sn'])->where('store_id', $options['store_id'])->first();
		}
		return $scales_info;
	}
	
	/**
	 * 散装商品价格格式化
	 * @param float $price
	 * @return float
	 */
	public static function formated_price_bulk($price) {
		//格式化散装商品价格
		$price = sprintf("%.2f",$price);
		return $price;
	}
	
	/**
	 * 根据总重量获取散装商品总价
	 * @param array $options
	 * @return float
	 */
	public static function get_total_bulkgoods_price($options) {
		$weight_unit = $options['weight_unit'];
		$goods_price = $options['goods_price'];
		$weight		 = $options['weight'];
		$goods_id 	 =  $options['goods_id'];
		
		//根据商品id获取商品货号关联的电子秤信息
		$goods_info = RC_DB::table('goods')->where('goods_id', $goods_id)->first();
		$scale_sn = substr(trim($goods_info['goods_sn']), 0, 2);
		$cashier_scales_info = self::get_scales_info(array('scale_sn' => $scale_sn, 'store_id' => $goods_info['store_id'])); 
		
		//电子秤单价设置的是克/元
		if ($cashier_scales_info['price_unit'] == Ecjia\App\Cart\StoreStatus::GRAMPERYUAN) {
			$final_price = $goods_price*($weight*1000);
		}else{
			//电子秤设置的单价是千克/元
			$final_price = $goods_price * $weight;
		}
		return $final_price;
	}
	
	/**
	 * 根据散装商品总价获取总重量
	 * @param array $options
	 * @return float
	 */
	public static function get_total_bulkgoods_weight($options) {
		$goods_sn 		= trim($options['goods_sn']);
		$store_id 		= $options['store_id'];
		$weight_unit 	= $options['weight_unit'];
		$goods_price 	= $options['goods_price'];
		$price		 	= $options['price'];
	
		$scale_sn = substr($goods_sn, 0, 2);
		$cashdesk_scales_info = self::get_scales_info(array('scale_sn' => $scale_sn, 'store_id' => $store_id));
		//电子秤单价设置的是克/元
		if ($cashdesk_scales_info['price_unit'] == Ecjia\App\Cart\StoreStatus::GRAMPERYUAN) {
			//商品的重量单位是千克
			if ($weight_unit == Ecjia\App\Cart\StoreStatus::KILOGRAM) {
				$goods_price = $goods_price/1000; //商品单价换算成克/元
				$weight = $price/$goods_price;
				$weight_final = $weight/1000; //最终重量统一成千克
			} else {
				$weight_final = $price/$goods_price;
			}
		} else{//电子秤设置的单价是千克/元
			//商品的重量单位是克
			if ($weight_unit == Ecjia\App\Cart\StoreStatus::GRAM) {
				$goods_price = $goods_price*1000; //商品单价换算成千克/元
				$weight_final = $price/$goods_price; //最终重量统一成千克
			} else {
				$weight_final = $price/$goods_price;
			}
		}
		return $weight_final;
	}
	
	/**
	 * 散装商品重量格式化
	 * @param float $weight
	 * @return float
	 */
	public static function formated_weight_bulk($weight) {
		//格式化散装商品重量
		$weight = sprintf("%.3f",$weight);
		return $weight;
	}
	
	/**
	 * 计算购物车中的商品能享受红包支付的总额
	 * @return  float   享受红包支付的总额
	 */
	public static function compute_discount_amount($cart_id = array(), $rec_type = null, $store_id = 0) {
        if (is_null($rec_type)) {
            $rec_type = \Ecjia\App\Cart\Enums\CartEnum::CART_GENERAL_GOODS;
        }

		$db				= RC_DB::table('favourable_activity');
		/* 查询优惠活动 */
		$now = RC_Time::gmtime();
		$user_rank = ',' . $_SESSION['user_rank'] . ',';
	
		$favourable_list   = $db->where('start_time', '<=', $now)->where('end_time', '>=', $now)->whereRaw('CONCAT(",", user_rank, ",") LIKE "%' . $user_rank . '%"')->whereIn('act_type', array(FAT_DISCOUNT, FAT_PRICE))->get();
		if (!$favourable_list) {
			return 0;
		}
	
		/* 查询购物车商品 */
		$db_cartview = RC_DB::table('cart as c')->leftJoin('goods as g', RC_DB::raw('c.goods_id'), '=', RC_DB::raw('g.goods_id'));
		$db_cartview->where(RC_DB::raw('c.parent_id'), 0)->where(RC_DB::raw('c.is_gift'), 0)->where(RC_DB::raw('c.rec_type'), $rec_type);
		
		if (is_array($cart_id) && !empty($cart_id)) {
			$db_cartview->whereIn(RC_DB::raw('c.rec_id'), $cart_id);
		}
		if (!empty($store_id)) {
			$db_cartview->where(RC_DB::raw('c.store_id'), $store_id);
		}
		if (!empty($_SESSION['user_id'])) {
			$db_cartview->where(RC_DB::raw('c.user_id'), $_SESSION['user_id']);
		} else {
			$db_cartview->where(RC_DB::raw('c.user_id'), 0);
		}
		
		$filed = "c.goods_id, c.goods_price * c.goods_number AS subtotal, g.cat_id, g.brand_id";
		
		$goods_list = $db_cartview->select(RC_DB::raw($filed))->get();
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
					if($favourable['store_id'] == $goods['store_id']){
						$total_amount += $goods['subtotal'];
					}
				}
			} elseif ($favourable['act_range'] == FAR_CATEGORY) {
				/* 找出分类id的子分类id */
				$id_list = array();
				$raw_id_list = explode(',', $favourable['act_range_ext']);
				foreach ($raw_id_list as $id) {
					$id_list = array_merge($id_list, array_keys(cat_list($id, 0, false)));
				}
				$ids = join(',', array_unique($id_list));
	
				foreach ($goods_list as $goods) {
					if (strpos(',' . $ids . ',', ',' . $goods['cat_id'] . ',') !== false) {
						if($favourable['store_id'] == $goods['store_id']){
							$total_amount += $goods['subtotal'];
						}
					}
				}
			} elseif ($favourable['act_range'] == FAR_BRAND) {
				foreach ($goods_list as $goods) {
					if (strpos(',' . $favourable['act_range_ext'] . ',', ',' . $goods['brand_id'] . ',') !== false) {
						if($favourable['store_id'] == $goods['store_id']){
							$total_amount += $goods['subtotal'];
						}
					}
				}
			} elseif ($favourable['act_range'] == FAR_GOODS) {
				foreach ($goods_list as $goods) {
					if (strpos(',' . $favourable['act_range_ext'] . ',', ',' . $goods['goods_id'] . ',') !== false) {
						if($favourable['store_id'] == $goods['store_id']){
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
	 * 取得购物车该赠送的积分数
	 * @return  int	 积分数
	 */
	public static function get_give_integral( $cart_id = array(), $rec_type = null) {
        if (is_null($rec_type)) {
            $rec_type = \Ecjia\App\Cart\Enums\CartEnum::CART_GENERAL_GOODS;
        }
		
		$field = "c.rec_id, c.goods_id, c.goods_attr_id, g.promote_price, g.promote_start_date, c.goods_number,g.promote_end_date, IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS member_price";
		
		$db_cartview = RC_DB::table('cart as c')->leftJoin('goods as g', RC_DB::raw('g.goods_id'), '=', RC_DB::raw('c.goods_id'));
		
		$db_cartview->where(RC_DB::raw('c.goods_id'), '>', 0)->where(RC_DB::raw('c.parent_id'), 0)->where(RC_DB::raw('c.is_gift'), 0);
		if ($_SESSION['user_id']) {
			$db_cartview->where(RC_DB::raw('c.user_id'), $_SESSION['user_id']);
		} else {
			$db_cartview->where(RC_DB::raw('c.user_id'), 0);
		}
		if (is_array($cart_id) && !empty($cart_id)) {
			$db_cartview->whereIn(RC_DB::raw('c.rec_id'), $cart_id);
		}
		$integral = $db_cartview->pluck(RC_DB::raw('sum(c.goods_number * IF(g.give_integral > -1, g.give_integral, c.goods_price))'));
		return intval($integral);
	}
	
	
	/**
	 * 清空购物车
	 * @param   int	 $type   类型：默认普通商品
	 */
	public static function clear_cart($type = null, $cart_id = array(), $pendorder_id= 0) {
        if (is_null($type)) {
            $type = \Ecjia\App\Cart\Enums\CartEnum::CART_GENERAL_GOODS;
        }

		$db_cart = RC_DB::table('cart');
		
		$db_cart->where('rec_type', $type);
		if (!empty($cart_id) && is_array($cart_id)) {
			$db_cart->whereIn('rec_id', $cart_id);
		}
		if (!empty($pendorder_id)) {
			$db_cart->where('pendorder_id', $pendorder_id);
		} else {
			$db_cart->where('pendorder_id', 0);
		}
		if ($_SESSION['user_id']) {
			$db_cart->where('user_id', $_SESSION['user_id']);
		} else {
			$db_cart->where('user_id', 0);
		}
		if ($_SESSION['device_id']) {
			$db_cart->where('session_id', $_SESSION['device_id']);
		}
		$db_cart->delete();
	}
	
	
	/**
	 * 取得购物车总金额
	 * @params  boolean $include_gift   是否包括赠品
	 * @param   int     $type           类型：默认普通商品
	 * @return  float   购物车总金额
	 */
	public static function cart_amount($include_gift = true, $type = null, $cart_id = array()) {
        if (is_null($type)) {
            $type = \Ecjia\App\Cart\Enums\CartEnum::CART_GENERAL_GOODS;
        }

		$db = RC_Loader::load_app_model('cart_model', 'cart');
	
		if ($_SESSION['user_id']) {
			$where['user_id'] = $_SESSION['user_id'];
		} else {
			$where['session_id'] = SESS_ID;
		}
		if (!empty($cart_id)) {
			$where['rec_id'] = $cart_id;
		}
		$where['rec_type'] = $type;
	
		if (!$include_gift) {
			$where['is_gift'] = 0;
			$where['goods_id']= array('gt'=>0);
		}
	
		$data = $db->where($where)->sum('goods_price * goods_number');
		return $data;
	}	
}	


// end