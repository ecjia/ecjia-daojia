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
 * 获得购物车中的商品
 * @access  public
 * @return  array
 */
function EM_get_cart_goods() {
	/* 初始化 */
    $goods_list = array();
    $total = array(
        'goods_price'  => 0, // 本店售价合计（有格式）
        'market_price' => 0, // 市场售价合计（有格式）
        'saving'       => 0, // 节省金额（有格式）
        'save_rate'    => 0, // 节省百分比
        'goods_amount' => 0, // 本店售价合计（无格式）
    );

    /* 循环、统计 */
	RC_Loader::load_app_func('global', 'goods');
	if ($_SESSION['user_id']) {
        $data = RC_DB::table('cart')
            ->select(RC_DB::raw('*, IF(parent_id, parent_id, goods_id) AS pid'))
            ->where('user_id', $_SESSION['user_id'])
            ->where('rec_type', CART_GENERAL_GOODS)
            ->orderBy('pid', 'asc')
            ->orderBy('parent_id', 'asc')
            ->get();
	} else {
        $data = RC_DB::table('cart')
            ->select(RC_DB::raw('*, IF(parent_id, parent_id, goods_id) AS pid'))
            ->where('session_id', SESS_ID)
            ->where('rec_type', CART_GENERAL_GOODS)
            ->orderBy('pid', 'asc')
            ->orderBy('parent_id', 'asc')
            ->get();
	}

	/* 用于统计购物车中实体商品和虚拟商品的个数 */
    $virtual_goods_count = 0;
    $real_goods_count    = 0;

	foreach ($data as $row) {
        $total['goods_price']  += $row['goods_price'] * $row['goods_number'];
        $total['market_price'] += $row['market_price'] * $row['goods_number'];
        
        $total['saving']       += $row['market_price'] > $row['goods_price'] ? ($row['market_price'] - $row['goods_price']) : 0;
        
        
        $row['subtotal']              = $row['goods_price'] * $row['goods_number'];
        $row['formated_subtotal']     = price_format($row['goods_price'] * $row['goods_number'], false);
        $row['goods_price']           = $total['goods_price'] > 0 ? price_format($row['goods_price'], false) : __('免费');
        $row['market_price']          = price_format($row['market_price'], false);

        /* 统计实体商品和虚拟商品的个数 */
        if ($row['is_real']) {
            $real_goods_count++;
        } else {
            $virtual_goods_count++;
        }

		/* 查询规格 */
        if (trim($row['goods_attr']) != '' && $row['group_id'] == '') {//兼容官网套餐问题增加条件group_id
            $attr_list = RC_DB::table('goods_attr')->select('attr_value')->whereIn('goods_attr_id', $row['goods_attr_id'])->get();
            foreach ($attr_list AS $attr) {
                $row['goods_name'] .= ' [' . $attr['attr_value'] . '] ';
            }
        }
        /* 增加是否在购物车里显示商品图 */
        if ((ecjia::config('show_goods_in_cart') == "2" || ecjia::config('show_goods_in_cart') == "3") && $row['extension_code'] != 'package_buy') {
            $goods_img = RC_DB::table('goods')->select(RC_DB::raw('goods_thumb, goods_img, original_img'))->where('goods_id', $row['goods_id'])->first();
            
			$row['goods_thumb'] = get_image_path($row['goods_id'], $goods_img['goods_thumb'], true);
            $row['goods_img'] = get_image_path($row['goods_id'], $goods_img['goods_img'], true);
            $row['original_img'] = get_image_path($row['goods_id'], $goods_img['original_img'], true);
        }
        if ($row['extension_code'] == 'package_buy') {
            $row['package_goods_list'] = get_package_goods($row['goods_id']);
        }
        $goods_list[] = $row;
    }
    $total['goods_amount'] = $total['goods_price'];
    $total['saving']       = price_format($total['saving'], false);
    if ($total['market_price'] > 0) {
        $total['save_rate'] = $total['market_price'] ? round(($total['market_price'] - $total['goods_price']) * 100 / $total['market_price']).'%' : 0;
    }
    $total['goods_price']         = price_format($total['goods_price'], false);
    $total['market_price']        = price_format($total['market_price'], false);
    $total['real_goods_count']    = $real_goods_count;
    $total['virtual_goods_count'] = $virtual_goods_count;

    return array('goods_list' => $goods_list, 'total' => $total);
}

/**
 * 更新购物车中的商品数量
 * @access  public
 * @param   array   $arr
 * @return  void
 */
function flow_update_cart($arr) {
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
        	if ($store_status == '2') {
        		return new ecjia_error('store_locked', '对不起，该商品所属的店铺已锁定！');
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
                ->where('session_id', SESS_ID)
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
                return new ecjia_error('low_stocks', __('库存不足'));
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
            			return new ecjia_error('low_stocks', __('库存不足'));
            		}
            	}
            }
        }  elseif (intval(ecjia::config('use_storage')) > 0 && $goods['extension_code'] == 'package_buy') {
        	if (judge_package_stock($goods['goods_id'], $val)) {
                return new ecjia_error('low_stocks', __('库存不足'));
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
                ->where(RC_DB::raw('a.session_id'), SESS_ID)
                ->where(RC_DB::raw('b.session_id'), SESS_ID)
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
                                ->where('session_id', SESS_ID)
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
                        ->where('session_id', SESS_ID)
                        ->where('rec_id', $key)
                        ->update(array('goods_number' => $val));
    	}
            }  else {
            	/* 处理普通商品或非优惠的配件 */
                $attr_id = empty($goods['goods_attr_id']) ? array() : explode(',', $goods['goods_attr_id']);
                $goods_price = get_final_price($goods['goods_id'], $val, true, $attr_id);
                
                //更新购物车中的商品数量
				if ($_SESSION['user_id']) {
                    RC_DB::table('cart')
                        ->where('user_id', $_SESSION['user_id'])
                        ->where('rec_id', $key)
                        ->update(array('goods_number' => $val , 'goods_price' => $goods_price));
				} else {
                    RC_DB::table('cart')
                        ->where('session_id', SESS_ID)
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
                            ->where('session_id', SESS_ID)
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
                    ->where('session_id', SESS_ID)
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
            ->where('session_id', SESS_ID)
            ->where('is_gift', '!=', 0)
            ->delete();
	}
}


/**
 * 删除购物车中的商品
 * @access  public
 * @param   integer $id
 * @return  void
 */
function flow_drop_cart_goods($id) {
    /* 取得商品id */
    $row = RC_DB::table('cart')->where('rec_id', $id)->first();
    if ($row) {
        //如果是超值礼包
        if ($row['extension_code'] == 'package_buy') {
			if ($_SESSION['user_id']) {
                RC_DB::table('cart')
                    ->where('user_id', $_SESSION['user_id'])
                    ->where('rec_id', $id)
                    ->delete();
			} else {
                RC_DB::table('cart')
                    ->where('session_id', SESS_ID)
                    ->where('rec_id', $id)
                    ->delete();
			}
        } elseif ($row['parent_id'] == 0 && $row['is_gift'] == 0) {
        	//如果是普通商品，同时删除所有赠品及其配件
            /* 检查购物车中该普通商品的不可单独销售的配件并删除 */
            $data = RC_DB::table('cart as c')
                ->leftJoin('group_goods as gg', RC_DB::raw('c.goods_id'), '=', RC_DB::raw('gg.goods_id'))
                ->leftJoin('goods as g', RC_DB::raw('c.goods_id'), '=', RC_DB::raw('g.goods_id'))
                ->select(RC_DB::raw('c.rec_id'))
                ->where(RC_DB::raw('gg.parent_id'), $row['goods_id'])
                ->where(RC_DB::raw('c.parent_id'), $row['goods_id'])
                ->where(RC_DB::raw('g.is_alone_sale'), 0)
                ->get();
            
            $_del_str = $id . ',';
            if (!empty($data)) {
                foreach ($data as $id_alone_sale_goods) {
                    $_del_str .= $id_alone_sale_goods['rec_id'] . ',';
                }
            }
            
            $_del_str = trim($_del_str, ',');
            $goods_id = $row['goods_id'];
			if ($_SESSION['user_id']) {
                RC_DB::table('cart')
                    ->where('user_id', $_SESSION['user_id'])
                    ->where(function($query) use($_del_str, $goods_id) {
                        $query->whereIn('rec_id', $_del_str)->orWhere('parent_id', $goods_id)->orWhere('is_gift', '!=', 0);
                    })
                    ->delete();
			} else {
                RC_DB::table('cart')
                    ->where('session_id', SESS_ID)
                    ->where(function($query) use($_del_str, $goods_id) {
                        $query->whereIn('rec_id', $_del_str)->orWhere('parent_id', $goods_id)->orWhere('is_gift', '!=', 0);
                    })
                    ->delete();
			}
        } else {
        	//如果不是普通商品，只删除该商品即可
			if ($_SESSION['user_id']) {
                RC_DB::table('cart')->where('user_id', $_SESSION['user_id'])->where('rec_id', $id)->delete();
			} else {
                RC_DB::table('cart')->where('session_id', SESS_ID)->where('rec_id', $id)->delete();
			}
        }
    }
    flow_clear_cart_alone();
}

/**
 * 删除购物车中不能单独销售的商品
 * @access  public
 * @return  void
 */
function flow_clear_cart_alone() {
    /* 查询：购物车中所有不可以单独销售的配件 */
	$db_cart  = RC_Loader::load_app_model('cart_model', 'cart');
    $dbview  = RC_Loader::load_app_model('cart_group_goods_goods_viewmodel', 'cart');
    if ($_SESSION['user_id']) {
    	$data = $dbview->join(array('group_goods','goods'))->where(array('c.user_id' => $_SESSION['user_id'] , 'c.extension_code' => array('neq' => 'package_buy') , 'gg.parent_id' => array('gt' => 0) , 'g.is_alone_sale' => 0))->select();
    } else {
    	$data = $dbview->join(array('group_goods','goods'))->where(array('c.session_id' => SESS_ID , 'c.extension_code' => array('neq' => 'package_buy') , 'gg.parent_id' => array('gt' => 0) , 'g.is_alone_sale' => 0))->select();
    }
    
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
	if ($_SESSION['user_id']) {
        $res = RC_DB::table('cart')->select(RC_DB::raw('DISTINCT goods_id'))->where('user_id', $_SESSION['user_id'])->get();
	} else {
        $res = RC_DB::table('cart')->select(RC_DB::raw('DISTINCT goods_id'))->where('session_id', SESS_ID)->get();
	}
    
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
    if ($_SESSION['user_id']) {
        RC_DB::table('cart')->where('user_id', $_SESSION['user_id'])->whereIn('rec_id', $del_rec_id)->delete();
    } else {
        RC_DB::table('cart')->where('session_id', SESS_ID)->whereIn('rec_id', $del_rec_id)->delete();
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
function addto_cart($goods_id, $num = 1, $spec = array(), $parent = 0, $warehouse_id = 0, $area_id = 0, $price = 0, $weight = 0, $flow_type = CART_GENERAL_GOODS) {
	$dbview 		= RC_Loader::load_app_model('sys_goods_member_viewmodel', 'goods');
	$db_cart 		= RC_Loader::load_app_model('cart_model', 'cart');
	$db_products 	= RC_Loader::load_app_model('products_model', 'goods');
	$db_group 		= RC_Loader::load_app_model('group_goods_model', 'goods');
    $_parent_id 	= $parent;
	RC_Loader::load_app_func('admin_order', 'orders');
	RC_Loader::load_app_func('admin_goods', 'goods');
	RC_Loader::load_app_func('global', 'goods');
	
	$field = "g.goods_id, g.market_price, g.goods_name, g.goods_sn, g.is_on_sale, g.is_real, g.store_id as store_id, g.model_inventory, g.model_attr, ".
			"g.is_xiangou, g.xiangou_start_date, g.xiangou_end_date, g.xiangou_num, ".
// 			"wg.w_id, wg.warehouse_price, wg.warehouse_promote_price, wg.region_number as wg_number, wag.region_price, wag.region_promote_price, wag.region_number as wag_number, ".
// 			"IF(g.model_price < 1, g.shop_price, IF(g.model_price < 2, wg.warehouse_price, wag.region_price)) AS org_price,  ".
			"g.model_price, g.market_price, ".
			"g.promote_price as promote_price, ".
			" g.promote_start_date, g.promote_end_date, g.goods_weight, g.integral, g.extension_code, g.goods_number, g.is_alone_sale, g.is_shipping, ".
			"IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price ";
    /* 取得商品信息 */
   	$dbview->view = array(
//    		'warehouse_goods' => array(
//    			'type'  => Component_Model_View::TYPE_LEFT_JOIN,
//    			'alias' => 'wg',
//    			'on'   	=> "g.goods_id = wg.goods_id and wg.region_id = '$warehouse_id'"
//    		),
//    		'warehouse_area_goods' => array(
//    			'type'  => Component_Model_View::TYPE_LEFT_JOIN,
//    			'alias' => 'wag',
//    			'on'   	=> "g.goods_id = wag.goods_id and wag.region_id = '$area_id'"
//    		),
   		'member_price' => array(
   			'type'     => Component_Model_View::TYPE_LEFT_JOIN,
   			'alias'    => 'mp',
   			'on'   	   => "mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]'"
   		)   					
	); 
   	
   	$where = array(
   		'g.goods_id' => $goods_id,
   		'g.is_delete' => 0,
   	);
   	if (ecjia::config('review_goods') == 1) {
   		$where['g.review_status'] = array('gt' => 2);
   	}
    $goods = $dbview->field($field)->join(array(/* 'warehouse_goods', 'warehouse_area_goods', */ 'member_price'))->find($where);
    if (empty($goods)) {
    	return new ecjia_error('no_goods', __('对不起，指定的商品不存在！'));
    }
    /* 是否正在销售 */
    if ($goods['is_on_sale'] == 0) {
    	return new ecjia_error('addcart_error', __('购买失败'));
    }
    /* 如果是作为配件添加到购物车的，需要先检查购物车里面是否已经有基本件 */
    if ($parent > 0) {
    	if ($_SESSION['user_id']) {
    		$count = $db_cart->where(array('goods_id' => $parent , 'user_id' => $_SESSION['user_id'] , 'extension_code' => array('neq' => 'package_buy')))->count();
    	} else {
    		$count = $db_cart->where(array('goods_id' => $parent , 'session_id' => SESS_ID , 'extension_code' => array('neq' => 'package_buy')))->count();
    	}
    	
        if ($count == 0) {
			return new ecjia_error('addcart_error', __('对不起，您希望将该商品做为配件购买，可是购物车中还没有该商品的基本件。'));
        }
    }

    /* 不是配件时检查是否允许单独销售 */
    if (empty($parent) && $goods['is_alone_sale'] == 0) {
		return new ecjia_error('addcart_error', __('购买失败'));
    }
    /* 如果商品有规格则取规格商品信息 配件除外 */
    $prod = $db_products->find(array('goods_id' => $goods_id));
    
    if (is_spec($spec) && !empty($prod)) {
        $product_info = get_products_info($goods_id, $spec);
    }
    if (empty($product_info)) {
        $product_info = array('product_number' => '', 'product_id' => 0 , 'goods_attr'=>'');
    }

//     if ($goods['model_inventory'] == 1) {
//     	$goods['goods_number'] = $goods['wg_number'];
//     } elseif($goods['model_inventory'] == 2) {
//     	$goods['goods_number'] = $goods['wag_number'];
//     }
    
    /* 检查：库存 */
    if (ecjia::config('use_storage') == 1) {
		//检查：商品购买数量是否大于总库存
		if ($num > $goods['goods_number']) {
			return new ecjia_error('low_stocks', __('库存不足'));
		}
		//商品存在规格 是货品 检查该货品库存
    	if (is_spec($spec) && !empty($prod)) {
    		if (!empty($spec)) {
				/* 取规格的货品库存 */
    			if ($num > $product_info['product_number']) {
    				return new ecjia_error('low_stocks', __('库存不足'));
    			}
    		}
    	}
    }
  
    /* 计算商品的促销价格 */
//     $warehouse_area['warehouse_id'] = $warehouse_id;
//     $warehouse_area['area_id']      = $area_id;
    
    $spec_price             = spec_price($spec, $goods_id);
    $goods_price            = get_final_price($goods_id, $num, true, $spec);
//     $goods['market_price'] += $spec_price;
    $goods_attr             = get_goods_attr_info($spec, 'pice');
    $goods_attr_id          = join(',', $spec);
    
    /*收银台商品购物车类型*/
    $rec_type = !empty($flow_type) ? intval($flow_type) : CART_GENERAL_GOODS;
	
    /* 初始化要插入购物车的基本件数据 */
    $parent = array(
        'user_id'       => $_SESSION['user_id'],
        'session_id'    => SESS_ID,
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
//     	'model_attr'  	=> $goods['model_attr'], 	//属性方式
//         'warehouse_id'  => $warehouse_id,  			//仓库
        //'area_id'  		=> $area_id, 				// 仓库地区
        'add_time'      => RC_Time::gmtime()
    );
    

    /* 如果该配件在添加为基本件的配件时，所设置的“配件价格”比原价低，即此配件在价格上提供了优惠， */
    /* 则按照该配件的优惠价格卖，但是每一个基本件只能购买一个优惠价格的“该配件”，多买的“该配件”不享受此优惠 */
    $basic_list = array();
    $data = $db_group->field('parent_id, goods_price')->where('goods_id = '.$goods_id.' AND goods_price < "'.$goods_price.'" AND parent_id = '.$_parent_id.'')->order('goods_price asc')->select();

    if (!empty($data)) {
	    foreach ($data as $row) {
	        $basic_list[$row['parent_id']] = $row['goods_price'];
	    }
    }
    /* 取得购物车中该商品每个基本件的数量 */
    $basic_count_list = array();
    if ($basic_list) {
    	if ($_SESSION['user_id']) {
    		$data = $db_cart->field('goods_id, SUM(goods_number)|count')->where(array('user_id'=>$_SESSION['user_id'],'parent_id' => '0' , extension_code =>array('neq'=>"package_buy")))->in(array('goods_id'=>array_keys($basic_list)))->order('goods_id asc')->select();
    	} else {
    		$data = $db_cart->field('goods_id, SUM(goods_number)|count')->where(array('session_id'=>SESS_ID,'parent_id' => '0' , extension_code =>array('neq'=>"package_buy")))->in(array('goods_id'=>array_keys($basic_list)))->order('goods_id asc')->select();
    	}
    	if(!empty($data)) {
	        foreach ($data as $row) {
	            $basic_count_list[$row['goods_id']] = $row['count'];
	        }
        }
    }
    /* 取得购物车中该商品每个基本件已有该商品配件数量，计算出每个基本件还能有几个该商品配件 */
    /* 一个基本件对应一个该商品配件 */
    if ($basic_count_list) {
    	if ($_SESSION['user_id']) {
    		$data = $db_cart->field('parent_id, SUM(goods_number)|count')->where(array('user_id' => $_SESSION['user_id'],'goods_id'=>$goods_id,extension_code =>array('neq'=>"package_buy")))->in(array('parent_id'=>array_keys($basic_count_list)))->order('parent_id asc')->select();
    	} else {
    		$data = $db_cart->field('parent_id, SUM(goods_number)|count')->where(array('session_id' => SESS_ID,'goods_id'=>$goods_id,extension_code =>array('neq'=>"package_buy")))->in(array('parent_id'=>array_keys($basic_count_list)))->order('parent_id asc')->select();
    	}
    	
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
        $db_cart->insert($parent);
        /* 改变数量 */
        $num -= $parent['goods_number'];
    }

    /* 如果数量不为0，作为基本件插入 */
    if ($num > 0) {
        /* 检查该商品是否已经存在在购物车中 */
    	if ($_SESSION['user_id']) {
    		$row = $db_cart->field('rec_id, goods_number')->find('user_id = "' .$_SESSION['user_id']. '" AND goods_id = '.$goods_id.' AND parent_id = 0 AND goods_attr = "' .get_goods_attr_info($spec).'" AND extension_code <> "package_buy" AND rec_type = "'.$rec_type.'" ');
    	} else {
    		$row = $db_cart->field('rec_id, goods_number')->find('session_id = "' .SESS_ID. '" AND goods_id = '.$goods_id.' AND parent_id = 0 AND goods_attr = "' .get_goods_attr_info($spec).'" AND extension_code <> "package_buy" AND rec_type = "'.$rec_type.'" ');
    	}
    	
    	/* 限购判断*/
    	if ($goods['is_xiangou'] > 0) {
    		$order_info_viewdb = RC_Loader::load_app_model('order_info_viewmodel', 'orders');
    		$order_info_viewdb->view = array(
    			'order_goods' => array(
    				'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
    				'alias' => 'g',
    				'on'	=> 'oi.order_id = g.order_id '
    			)
    		);
    		$xiangou = array(
    			'oi.add_time >=' . $goods['xiangou_start_date'] . ' and oi.add_time <=' .$goods['xiangou_end_date'],
    			'g.goods_id'	=> $goods['goods_id'],
    			'oi.user_id'	=> $_SESSION['user_id'],
    		);
    		$xiangou_info = $order_info_viewdb->join(array('order_goods'))->field(array('sum(goods_number) as number'))->where($xiangou)->find();
    		
    		if ($xiangou_info['number'] + $row['goods_number'] >= $goods['xiangou_num']) {
    			return new ecjia_error('xiangou_error', __('该商品已限购'));
    		}
    	}
    	
        if($row) {
        	//如果购物车已经有此物品，则更新
            $num += $row['goods_number'];
            if(is_spec($spec) && !empty($prod) ) {
             	$goods_storage=$product_info['product_number'];
            } else {
                $goods_storage=$goods['goods_number'];
            }
            if (ecjia::config('use_storage') == 0 || $num <= $goods_storage) {
                $goods_price = get_final_price($goods_id, $num, true, $spec);
                $data =  array(
                		'goods_number' => $num,
                		'goods_price'  => $goods_price,
                		'area_id'	   => $area_id,
                );
                if ($_SESSION['user_id']) {
                	$db_cart->where('user_id = "' .$_SESSION['user_id']. '" AND goods_id = '.$goods_id.' AND parent_id = 0 AND goods_attr = "' .get_goods_attr_info($spec).'" AND extension_code <> "package_buy" AND rec_type = "'.$rec_type.'" ')->update($data);
                } else {
                	$db_cart->where('session_id = "' .SESS_ID. '" AND goods_id = '.$goods_id.' AND parent_id = 0 AND goods_attr = "' .get_goods_attr_info($spec).'" AND extension_code <> "package_buy" AND rec_type = "'.$rec_type.'" ')->update($data);
                }
            } else {
				return new ecjia_error('low_stocks', __('库存不足'));
            }
            $cart_id = $row['rec_id'];
        } else {
        	//购物车没有此物品，则插入
            $goods_price = get_final_price($goods_id, $num, true, $spec );
            $parent['goods_price']  = max($goods_price, 0);
            $parent['goods_number'] = $num;
            $parent['parent_id']    = 0;
			$cart_id = $db_cart->insert($parent);
        }
    }

    /* 把赠品删除 */
    if ($_SESSION['user_id']) {
    	$db_cart->where(array('user_id' => $_SESSION['user_id'] , 'is_gift' => array('neq' => 0)))->delete();
    } else {
    	$db_cart->where(array('session_id' => SESS_ID , 'is_gift' => array('neq' => 0)))->delete();
    }
    return $cart_id; 
}

/**
 * 获得用户的可用积分
 *
 * @access  private
 * @return  integral
 */
function flow_available_points($cart_id = array(), $rec_type = CART_GENERAL_GOODS) {
	$db_view = RC_Loader::load_app_model('cart_goods_viewmodel', 'cart');
	$cart_where = array('c.user_id' => $_SESSION['user_id'], 'c.is_gift' => 0 , 'g.integral' => array('gt' => '0') , 'c.rec_type' => $rec_type);
	if (!empty($cart_id)) {
		$cart_where = array_merge($cart_where, array('rec_id' => $cart_id));
	}
	if ($_SESSION['user_id']) {
		$cart_where = array_merge($cart_where, array('c.user_id' => $_SESSION['user_id']));
		$data = $db_view->join('goods')->where($cart_where)->sum('g.integral * c.goods_number');
	} else {
		$cart_where = array_merge($cart_where, array('c.session_id' => SESS_ID));
		$data = $db_view->join('goods')->where($cart_where)->sum('g.integral * c.goods_number');
	}
	$val = intval($data);
	RC_Loader::load_app_func('admin_order','orders');
	return integral_of_value($val);
}

/**
 * 检查订单中商品库存
 *
 * @access  public
 * @param   array   $arr
 *
 * @return  void
 */
function flow_cart_stock($arr) {
	foreach ($arr AS $key => $val) {
		$val = intval(make_semiangle($val));
		if ($val <= 0 || !is_numeric($key)) {
			continue;
		}

		$db_cart = RC_Loader::load_app_model('cart_model', 'cart');
		$db_products = RC_Loader::load_app_model('products_model', 'goods');
		$dbview = RC_Loader::load_app_model('goods_cart_viewmodel', 'goods');
		if ($_SESSION['user_id']) {
			$goods = $db_cart->field('goods_id,goods_attr_id,extension_code, product_id')->find(array('rec_id' => $key , 'user_id' => $_SESSION['user_id']));
		} else {
			$goods = $db_cart->field('goods_id,goods_attr_id,extension_code, product_id')->find(array('rec_id' => $key , 'session_id' => SESS_ID));
		}

		$row   = $dbview->field('c.product_id, g.is_on_sale, g.is_delete')->join('cart')->find(array('c.rec_id' => $key));
		//系统启用了库存，检查输入的商品数量是否有效
		if (intval(ecjia::config('use_storage')) > 0 && $goods['extension_code'] != 'package_buy') {
			if ($row['is_on_sale'] == 0 || $row['is_delete'] == 1) {
				return new ecjia_error('put_on_sale', '商品['.$row['goods_name'].']下架');
			}
			
			if ($row['goods_number'] < $val) {
				return new ecjia_error('low_stocks', __('库存不足'));
			}
			/* 是货品 */
			$row['product_id'] = trim($row['product_id']);
			if (!empty($row['product_id'])) {
				$product_number = $db_products->where(array('goods_id' => $goods['goods_id'] , 'product_id' => $goods['product_id']))->get_field('product_number');
				if ($product_number < $val) {
					return new ecjia_error('low_stocks', __('库存不足'));
				}
			}
		} elseif (intval(ecjia::config('use_storage')) > 0 && $goods['extension_code'] == 'package_buy') {
			if (judge_package_stock($goods['goods_id'], $val)) {
				return new ecjia_error('low_stocks', __('库存不足'));
			}
		}
	}
}

/**
 * 重新计算购物车中的商品价格：目的是当用户登录时享受会员价格，当用户退出登录时不享受会员价格
 * 如果商品有促销，价格不变
 * @access public
 * @return void
 * @update 180719 选择性更新内容
 */
function recalculate_price($device = array()) {
	$db_cart = RC_Loader::load_app_model('cart_model', 'cart');
	$dbview = RC_Loader::load_app_model('cart_good_member_viewmodel', 'cart');
	$codes = array('8001', '8011');
	if (!empty($device)) {
		if (in_array($device['code'], $codes)) {
			$rec_type = CART_CASHDESK_GOODS;
		}
	} else {
		$rec_type = CART_GENERAL_GOODS;
	}
	
	$discount = $_SESSION['discount'];
	$user_rank = $_SESSION['user_rank'];
	
	$db = RC_DB::table('cart as c')
			->leftJoin('goods as g', RC_DB::raw('c.goods_id'), '=', RC_DB::raw('g.goods_id'))
			->leftJoin('member_price as mp', function($join) use ($user_rank) {
				$join->where(RC_DB::raw('mp.goods_id'), '=', RC_DB::raw('g.goods_id'))
				->where(RC_DB::raw('mp.user_rank'), '=', $user_rank);
			})
			->select(RC_DB::raw("c.rec_id, c.goods_id, c.goods_attr_id, g.promote_price, g.promote_start_date, c.goods_number,g.promote_end_date, IFNULL(mp.user_price, g.shop_price * $discount) AS member_price"));
			
	/* 取得有可能改变价格的商品：除配件和赠品之外的商品 */
	// @update 180719 选择性更新内容mark_changed=1
	if ($_SESSION['user_id']) {
// 		$res = $dbview->join(array(
// 			'goods',
// 			'member_price'
// 		))
// 		->where('c.mark_changed =1 AND c.user_id = "' . $_SESSION['user_id'] . '" AND c.parent_id = 0 AND c.is_gift = 0 AND c.goods_id > 0 AND c.rec_type = "' . $rec_type . '" ')
// 		->select();
		
		
		$res = $db
			->where(RC_DB::raw('c.mark_changed'), 1)
			->where(RC_DB::raw('c.user_id'), $_SESSION['user_id'])
			->where(RC_DB::raw('c.parent_id'), 0)
			->where(RC_DB::raw('c.is_gift'), 0)
			->where(RC_DB::raw('c.goods_id'), '>', 0)
			->where(RC_DB::raw('c.rec_type'), $rec_type)
			->get();
		
	} else {
// 		$res = $dbview->join(array(
// 			'goods',
// 			'member_price'
// 		))
// 		->where('c.mark_changed =1 AND c.session_id = "' . SESS_ID . '" AND c.parent_id = 0 AND c.is_gift = 0 AND c.goods_id > 0 AND c.rec_type = "' . $rec_type . '" ')
// 		->select();
		
		$res = $db
			->where(RC_DB::raw('c.mark_changed'), 1)
			->where(RC_DB::raw('c.session_id'), SESS_ID)
			->where(RC_DB::raw('c.parent_id'), 0)
			->where(RC_DB::raw('c.is_gift'), 0)
			->where(RC_DB::raw('c.goods_id'), '>', 0)
			->where(RC_DB::raw('c.rec_type'), $rec_type)
			->get();
	}
	
	
	if (! empty($res)) {
		RC_Loader::load_app_func('global', 'goods');
		foreach ($res as $row) {
	        $attr_id = empty($row['goods_attr_id']) ? array() : explode(',', $row['goods_attr_id']);
	        $goods_price = get_final_price($row['goods_id'], $row['goods_number'], true, $attr_id);
	        $data = array(
	            'goods_price' => $goods_price > 0 ? $goods_price : 0.00,
	            'mark_changed' => 0
	        );
	        if ($_SESSION['user_id']) {
	            $db_cart->where('goods_id = ' . $row['goods_id'] . ' AND user_id = "' . $_SESSION['user_id'] . '" AND rec_id = "' . $row['rec_id'] . '"')->update($data);
	        } else {
	            $db_cart->where('goods_id = ' . $row['goods_id'] . ' AND session_id = "' . SESS_ID . '" AND rec_id = "' . $row['rec_id'] . '"')->update($data);
	        }
		}
	}
	/* 删除赠品，重新选择 */

	if ($_SESSION['user_id']) {
		$db_cart->where('user_id = "' . $_SESSION['user_id'] . '" AND is_gift > 0')->delete();
	} else {
		$db_cart->where('session_id = "' . SESS_ID . '" AND is_gift > 0')->delete();
	}
}

/**
 * 获得购物车中商品的总重量、总价格、总数量
 * @access  public
 * @param   int	 $type   类型：默认普通商品
 * @return  array
 */
function cart_weight_price($type = CART_GENERAL_GOODS, $cart_id = array()) {
	$db 			= RC_Loader::load_app_model('cart_model', 'cart');
	$dbview 		= RC_Loader::load_app_model('package_goods_viewmodel','orders');
	$db_cartview 	= RC_Loader::load_app_model('cart_good_member_viewmodel', 'cart');

	$package_row['weight'] 			= 0;
	$package_row['amount'] 			= 0;
	$package_row['number'] 			= 0;
	$packages_row['free_shipping'] 	= 1;
	if (!empty($cart_id)) {
		$where = array('rec_id' => $cart_id);
	}
	
	/* 计算超值礼包内商品的相关配送参数 */
	if ($_SESSION['user_id']) {
		$row = $db->field('goods_id, goods_number, goods_price')->where(array_merge($where, array('extension_code' => 'package_buy' , 'user_id' => $_SESSION['user_id'] )))->select();
	} else {
		$row = $db->field('goods_id, goods_number, goods_price')->where(array_merge($where, array('extension_code' => 'package_buy' , 'session_id' => SESS_ID )))->select();
	}

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
						'field' => 'SUM(g.goods_weight * pg.goods_number)|weight,SUM(pg.goods_number)|number',
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
			'field' => 'SUM(g.goods_weight * c.goods_number)|weight,SUM(c.goods_price * c.goods_number)|amount,SUM(c.goods_number)|number',
			'on'    => 'g.goods_id = c.goods_id'
		)
	);
	if ($_SESSION['user_id']) {
		$row = $db_cartview->find(array_merge($where, array('c.user_id' => $_SESSION['user_id'] , 'rec_type' => $type , 'g.is_shipping' => 0 , 'c.extension_code' => array('neq' => package_buy))));
	} else {
		$row = $db_cartview->find(array_merge($where, array('c.session_id' => SESS_ID , 'rec_type' => $type , 'g.is_shipping' => 0 , 'c.extension_code' => array('neq' => package_buy))));
	}

	$packages_row['weight'] = floatval($row['weight']) + $package_row['weight'];
	$packages_row['amount'] = floatval($row['amount']) + $package_row['amount'];
	$packages_row['number'] = intval($row['number']) + $package_row['number'];
	/* 格式化重量 */
	$packages_row['formated_weight'] = formated_weight($packages_row['weight']);
	return $packages_row;
}

/**
 * 取得购物车商品
 * @param   int     $type   类型：默认普通商品
 * @return  array   购物车商品数组
 */
function cart_goods($type = CART_GENERAL_GOODS, $cart_id = array()) {

// 	$db = RC_Loader::load_app_model('cart_model', 'cart');
	$db = RC_Loader::load_app_model('cart_goods_viewmodel', 'cart');
	
	$cart_where = array('rec_type' => $type, 'is_delete' => 0);
	if (!empty($cart_id)) {
		$cart_where = array_merge($cart_where,  array('rec_id' => $cart_id));
	}
	if (!empty($_SESSION['store_id'])) {
		$cart_where = array_merge($cart_where, array('c.store_id' => $_SESSION['store_id']));
	}
	$field = 'g.store_id, goods_img, g.goods_number|g_goods_number , original_img, goods_thumb, c.rec_id, c.user_id, c.goods_id, c.goods_name, c.goods_sn, c.product_id, c.goods_number, c.market_price, c.goods_price, c.goods_attr, c.is_real, c.extension_code, c.parent_id, c.is_gift, c.is_shipping, c.goods_price * c.goods_number|subtotal, goods_weight as goodsWeight, c.goods_attr_id';
	if ($_SESSION['user_id']) {
		$cart_where = array_merge($cart_where, array('c.user_id' => $_SESSION['user_id']));
		$arr        = $db->field($field)->where($cart_where)->select();
	} else {
		$cart_where = array_merge($cart_where, array('session_id' => SESS_ID));
		$arr        = $db->field($field)->where($cart_where)->select();
	}

	$db_goods_attr = RC_Loader::load_app_model('goods_attr_model', 'goods');
	$db_goods = RC_Loader::load_app_model('goods_model', 'goods');
	$order_info_viewdb = RC_Loader::load_app_model('order_info_viewmodel', 'orders');
	$order_info_viewdb->view = array(
		'order_goods' => array(
			'type'	  => Component_Model_View::TYPE_LEFT_JOIN,
			'alias'   => 'g',
			'on'	  => 'oi.order_id = g.order_id '
		)
	);
	/* 格式化价格及礼包商品 */
	foreach ($arr as $key => $value) {
		$goods = $db_goods->field(array('is_xiangou', 'xiangou_start_date', 'xiangou_end_date', 'xiangou_num'))->find(array('goods_id' => $value['goods_id']));
		/* 限购判断*/
		if ($goods['is_xiangou'] > 0) {
			$xiangou = array(
				'oi.add_time >=' . $goods['xiangou_start_date'] . ' and oi.add_time <=' .$goods['xiangou_end_date'],
				'g.goods_id'	=> $value['goods_id'],
				'oi.user_id'	=> $_SESSION['user_id'],
			);
			$xiangou_info = $order_info_viewdb->join(array('order_goods'))->field(array('sum(goods_number) as number'))->where($xiangou)->find();
		
			if ($xiangou_info['number'] + $value['goods_number'] > $goods['xiangou_num']) {
				return new ecjia_error('xiangou_error', __('该商品已限购'));
			}
		}
		
		$arr[$key]['formated_market_price'] = price_format($value['market_price'], false);
		$arr[$key]['formated_goods_price']  = $value['goods_price'] > 0 ? price_format($value['goods_price'], false) : __('免费');
		$arr[$key]['formated_subtotal']     = price_format($value['subtotal'], false);
		
		/* 查询规格 */
// 		if (trim($value['goods_attr']) != '' && $value['group_id'] == '') {//兼容官网套餐问题增加条件group_id
// 			$value['goods_attr_id'] = empty($value['goods_attr_id']) ? '' : explode(',', $value['goods_attr_id']);
// 			$attr_list = $db_goods_attr->field('attr_value')->in(array('goods_attr_id' => $value['goods_attr_id']))->select();
// 			foreach ($attr_list AS $attr) {
// 				$arr[$key]['goods_name'] .= ' [' . $attr['attr_value'] . '] ';
// 			}
// 		}
		
// 		$arr[$key]['goods_attr'] = array();
// 		if (!empty($value['goods_attr'])) {
// 			$goods_attr = explode("\n", $value['goods_attr']);
// 			$goods_attr = array_filter($goods_attr);
			
// 			foreach ($goods_attr as  $v) {
// 				$a = explode(':',$v);
// 				if (!empty($a[0]) && !empty($a[1])) {
// 					$arr[$key]['goods_attr'][] = array('name'=>$a[0], 'value'=>$a[1]);
// 				}
// 			}
// 		}
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
		$arr[$key]['attr'] =  $value['goods_attr'];
		$arr[$key]['goods_attr'] =  $goods_attr_gourp;
		
		//库存 181023 add
		$arr[$key]['attr_number'] = 1;//有货
		if (ecjia::config('use_storage') == 1) {
		    if($value['product_id']) {
		        $arr[$key]['product_id'] = $value['product_id'];
		        $product_number = RC_DB::table('products')
		            ->where('goods_id', $value['goods_id'])
    		        ->where('product_id', $value['product_id'])
    		        ->pluck('product_number');
		        if ($value['goods_number'] > $product_number) {
		            $arr[$key]['attr_number'] = 0;
		        }
		    } else {
		        if($value['goods_number'] > $value['g_goods_number']) {
		            $arr[$key]['attr_number'] = 0;
		        }
		    }
		}
		//库存 181023 end
		
		RC_Loader::load_app_func('global', 'goods');
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
		$arr[$key]['store_name'] = RC_DB::table('store_franchisee')->where('store_id', $value['store_id'])->pluck('merchants_name');
	}
	return $arr;
}

//获取购物选择商品最终金额
function get_cart_check_goods($cart_goods, $rec_id = '', $type = 0){
    
    $arr['subtotal_discount'] = 0;
    $arr['subtotal_amount'] = 0;
    $arr['subtotal_number'] = 0;
    $arr['save_amount'] = 0;
    
    if(!empty($rec_id)){
        if($cart_goods){
            foreach($cart_goods as $row){
                $arr['subtotal_amount'] += $row['subtotal'];
                $arr['subtotal_number'] += $row['goods_number'];
                $arr['save_amount'] += $row['dis_amount'];
            }
        }
    }
    
    $arr['subtotal_amount'] = $arr['subtotal_amount'] - $arr['save_amount'];
    return $arr;
}
/**
 * 取得购物车总金额
 * @params  boolean $include_gift   是否包括赠品
 * @param   int     $type           类型：默认普通商品
 * @return  float   购物车总金额
 */
function cart_amount($include_gift = true, $type = CART_GENERAL_GOODS, $cart_id = array()) {
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

/**
 * 清空购物车
 * @param   int	 $type   类型：默认普通商品
 */
function clear_cart($type = CART_GENERAL_GOODS, $cart_id = array()) {
	$db_cart = RC_Loader::load_app_model('cart_model', 'cart');
	$cart_w = array('rec_type' => $type);
	if (!empty($cart_id)) {
		$cart_w = array_merge($cart_w, array('rec_id' => $cart_id));
	}
	if ($_SESSION['user_id']) {
		$cart_w = array_merge($cart_w, array('user_id' => $_SESSION['user_id']));
		$db_cart->where($cart_w)->delete();
	} else {
		$cart_w = array_merge($cart_w, array('session_id' => SESS_ID));
		$db_cart->where($cart_w)->delete();
	}
}

/**
 * 获得购物车中的商品
 * @access  public
 * @return  array
 */
function get_cart_goods($cart_id = array(), $flow_type = CART_GENERAL_GOODS) {
	RC_Loader::load_app_func('global', 'goods');
	$db_cart 		= RC_Loader::load_app_model('cart_model', 'cart');
	$db_goods_attr 	= RC_Loader::load_app_model('goods_attr_model','goods');
	$db_goods 		= RC_Loader::load_app_model('goods_model','goods');

	/* 初始化 */
	$goods_list = array();
	$total = array(
		'goods_price'  => 0, // 本店售价合计（有格式）
		'market_price' => 0, // 市场售价合计（有格式）
		'saving'       => 0, // 节省金额（有格式）
		'save_rate'    => 0, // 节省百分比
		'goods_amount' => 0, // 本店售价合计（无格式）
	    'goods_number' => 0, // 商品总数
	);

	/* 循环、统计 */
	$cart_where = array('rec_type' => $flow_type);
	if (!empty($cart_id)) {
		$cart_where = array_merge($cart_where, array('rec_id' => $cart_id));
	}
	if ($_SESSION['user_id']) {
		$cart_where = array_merge($cart_where, array('user_id' => $_SESSION['user_id']));
	} else {
		$cart_where = array_merge($cart_where, array('session_id' => SESS_ID));
	}
	$data = $db_cart->field('*,IF(parent_id, parent_id, goods_id)|pid')->where($cart_where)->order(array('pid'=>'asc', 'parent_id'=>'asc'))->select();
	
	/* 用于统计购物车中实体商品和虚拟商品的个数 */
	$virtual_goods_count = 0;
	$real_goods_count    = 0;

	if (!empty($data)) {
		foreach ($data as $row) {
			$total['goods_price']  += $row['goods_price'] * $row['goods_number'];
			$total['market_price'] += $row['market_price'] * $row['goods_number'];
			$row['subtotal']     	= price_format($row['goods_price'] * $row['goods_number'], false);
			$row['goods_price']  	= price_format($row['goods_price'], false);
			$row['market_price'] 	= price_format($row['market_price'], false);

			/* 统计实体商品和虚拟商品的个数 */
			if ($row['is_real']) {
				$real_goods_count++;
			} else {
				$virtual_goods_count++;
			}
			$total['goods_number'] += $row['goods_number'];

			/* 查询规格 */
			if (trim($row['goods_attr']) != '') {
				$row['goods_attr'] = addslashes($row['goods_attr']);
				$attr_list = $db_goods_attr->field('attr_value')->in(array('goods_attr_id' =>$row['goods_attr_id']))->select();
				foreach ($attr_list AS $attr) {
					$row['goods_name'] .= ' [' . $attr[attr_value] . '] ';
				}
			}
			/* 增加是否在购物车里显示商品图 */
			if ((ecjia::config('show_goods_in_cart') == "2" || ecjia::config('show_goods_in_cart') == "3") &&
			$row['extension_code'] != 'package_buy') {

				$goods_thumb 		= $db_goods->field('goods_thumb')->find(array('goods_id' => '{'.$row['goods_id'].'}'));
				$row['goods_thumb'] = get_image_path($row['goods_id'], $goods_thumb, true);
			}
			if ($row['extension_code'] == 'package_buy') {
				$row['package_goods_list'] = get_package_goods($row['goods_id']);
			}
			$goods_list[] = $row;
		}
	}
	$total['goods_amount'] = $total['goods_price'];
	$total['saving']       = price_format($total['market_price'] - $total['goods_price'], false);
	if ($total['market_price'] > 0) {
		$total['save_rate'] = $total['market_price'] ? round(($total['market_price'] - $total['goods_price']) *
				100 / $total['market_price']).'%' : 0;
	}
	$total['goods_price']  			= price_format($total['goods_price'], false);
	$total['market_price'] 			= price_format($total['market_price'], false);
	$total['real_goods_count']    	= $real_goods_count;
	$total['virtual_goods_count'] 	= $virtual_goods_count;

	return array('goods_list' => $goods_list, 'total' => $total);
}

/**
 * 获得订单信息
 * @access  private
 * @return  array
 */
function flow_order_info() {
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
	if (isset($_SESSION['flow_type']) && intval($_SESSION['flow_type']) != CART_GENERAL_GOODS) {
		$order['extension_code'] 	= $_SESSION['extension_code'];
		$order['extension_id'] 		= $_SESSION['extension_id'];
	}
	return $order;
}

/**
 * 计算折扣：根据购物车和优惠活动
 * @return  float   折扣
 */
function compute_discount($type = 0, $newInfo = array(), $cart_id = array(), $user_type = 0) {
	//$db 			= RC_Loader::load_app_model('favourable_activity_model', 'favourable');
	$db_cartview 	= RC_Loader::load_app_model('cart_good_member_viewmodel', 'cart');
	$db				= RC_DB::table('favourable_activity');
	/* 查询优惠活动 */
	$now = RC_Time::gmtime();
	$user_rank = ',' . $_SESSION['user_rank'] . ',';

	//$favourable_list = $db->where("start_time <= '$now' AND end_time >= '$now' AND CONCAT(',', user_rank, ',') LIKE '%" . $user_rank . "%'")->in(array('act_type'=>array(FAT_DISCOUNT, FAT_PRICE)))->select();
	$favourable_list = $db->where('start_time', '<=', $now)->where('end_time', '>=', $now)->whereRaw("CONCAT(',', user_rank, ',') LIKE '%" . $user_rank . "%'")->whereIn('act_type', array(FAT_DISCOUNT, FAT_PRICE))->get();
	if (!$favourable_list) {
		return 0;
	}

	if ($type == 0) {
		/* 查询购物车商品 */
		$db_cartview->view = array(
			'goods' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'g',
				'field' => " c.goods_id, c.goods_price * c.goods_number AS subtotal, g.cat_id, g.brand_id",
				'on'   	=> 'c.goods_id = g.goods_id'
			)
		);
		$where = empty($cart_id) ? '' : array('rec_id' => $cart_id);
		if ($_SESSION['user_id']) {
			$goods_list = $db_cartview->where(array_merge($where, array('c.user_id' => $_SESSION['user_id'] , 'c.parent_id' => 0 , 'c.is_gift' => 0 , 'rec_type' => CART_GENERAL_GOODS)))->select();
		} else {
			$goods_list = $db_cartview->where(array_merge($where, array('c.session_id' => SESS_ID , 'c.parent_id' => 0 , 'c.is_gift' => 0 , 'rec_type' => CART_GENERAL_GOODS)))->select();
		}
	} elseif ($type == 2) {
		$db_goods = RC_Loader::load_app_model('goods_model', 'goods');
		$goods_list = array();
		foreach ($newInfo as $key => $row) {
			$order_goods = $db_goods->field('cat_id, brand_id')->where(array('goods_id' => $row['goods_id']))->find();
			$goods_list[$key]['goods_id'] = $row['goods_id'];
			$goods_list[$key]['cat_id'] = $order_goods['cat_id'];
			$goods_list[$key]['brand_id'] = $order_goods['brand_id'];
			$goods_list[$key]['ru_id'] = $row['ru_id'];
			$goods_list[$key]['subtotal'] = $row['goods_price'] * $row['goods_number'];
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

				$favourable_name[] = $favourable['act_name'];
			} elseif ($favourable['act_type'] == FAT_PRICE) {
				$discount += $favourable['act_type_ext'];
				$favourable_name[] = $favourable['act_name'];
			}
		}
	}
	return array('discount' => $discount, 'name' => $favourable_name);
}

/**
 * 计算购物车中的商品能享受红包支付的总额
 * @return  float   享受红包支付的总额
 */
function compute_discount_amount($cart_id = array()) {
	//$db 			= RC_Loader::load_app_model('favourable_activity_model', 'favourable');
	$db_cartview 	= RC_Loader::load_app_model('cart_good_member_viewmodel', 'cart');
	$db				= RC_DB::table('favourable_activity');
	/* 查询优惠活动 */
	$now = RC_Time::gmtime();
	$user_rank = ',' . $_SESSION['user_rank'] . ',';

	//$favourable_list = $db->where('start_time <= '.$now.' AND end_time >= '.$now.' AND CONCAT(",", user_rank, ",") LIKE "%' . $user_rank . '%" ')->in(array('act_type' => array(FAT_DISCOUNT, FAT_PRICE)))->select();
	$favourable_list   = $db->where('start_time', '<=', $now)->where('end_time', '>=', $now)->whereRaw('CONCAT(",", user_rank, ",") LIKE "%' . $user_rank . '%"')->whereIn('act_type', array(FAT_DISCOUNT, FAT_PRICE))->get();
	if (!$favourable_list) {
		return 0;
	}

	/* 查询购物车商品 */
	$db_cartview->view = array(
		'goods' => array(
			'type'  => Component_Model_View::TYPE_LEFT_JOIN,
			'alias' => 'g',
			'field' => " c.goods_id, c.goods_price * c.goods_number AS subtotal, g.cat_id, g.brand_id",
			'on'    => 'c.goods_id = g.goods_id'
		)
	);
	$cart_where = array('c.parent_id' => 0 , 'c.is_gift' => 0 , 'rec_type' => CART_GENERAL_GOODS);
	if (!empty($cart_id)) {
		$cart_where = array_merge($cart_where, array('c.rec_id' => $cart_id));
	}
	if ($_SESSION['user_id']) {
		$cart_where = array_merge($cart_where, array('c.user_id' => $_SESSION['user_id']));
		$goods_list = $db_cartview->where($cart_where)->select();
	} else {
		$cart_where = array_merge($cart_where, array('c.session_id' => SESS_ID));
		$goods_list = $db_cartview->where($cart_where)->select();
	}

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
function get_give_integral() {

	$db_cartview = RC_Loader::load_app_model('cart_good_member_viewmodel', 'cart');

	$db_cartview->view = array(
		'goods' => array(
			'type'  => Component_Model_View::TYPE_LEFT_JOIN,
			'alias' => 'g',
			'field' => "c.rec_id, c.goods_id, c.goods_attr_id, g.promote_price, g.promote_start_date, c.goods_number,g.promote_end_date, IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS member_price",
			'on'    => 'g.goods_id = c.goods_id'
		),
	);
	$field = array();
	if ($_SESSION['user_id']) {
		return  intval($db_cartview->where(array('c.user_id' => $_SESSION['user_id'] , 'c.goods_id' => array('gt' => 0) ,'c.parent_id' => 0 ,'c.rec_type' => 0 , 'c.is_gift' => 0))->sum('c.goods_number * IF(g.give_integral > -1, g.give_integral, c.goods_price)'));
	} else {
		return  intval($db_cartview->where(array('c.session_id' => SESS_ID , 'c.goods_id' => array('gt' => 0) ,'c.parent_id' => 0 ,'c.rec_type' => 0 , 'c.is_gift' => 0))->sum('c.goods_number * IF(g.give_integral > -1, g.give_integral, c.goods_price)'));
	}
}

function addto_cart_groupbuy($act_id, $number = 1, $spec = array(), $parent = 0, $warehouse_id = 0, $area_id = 0)
{
	$db_cart = RC_Loader::load_app_model('cart_model', 'cart');
	/* 查询：取得团购活动信息 */
	RC_Loader::load_app_func('admin_goods', 'goods');
	RC_Loader::load_app_func('admin_order', 'orders');
	$group_buy = group_buy_info($act_id, $number);
	if (empty($group_buy)) {
		return new ecjia_error('gb_error', __('对不起，该团购活动不存在！'));
		
	}
	
	/* 查询：检查团购活动是否是进行中 */
	if ($group_buy['status'] != GBS_UNDER_WAY) {
		return new ecjia_error('gb_error_status', __('对不起，该团购活动已经结束或尚未开始，现在不能参加！'));
	}
	
	/* 查询：取得团购商品信息 */
	$goods = get_goods_info($group_buy['goods_id'], $warehouse_id, $area_id);
	if (empty($goods)) {
		return new ecjia_error('goods_error', __('对不起，团购商品不存在！'));
	}
	
	/* 查询：判断数量是否足够 */
	if (($group_buy['restrict_amount'] > 0 && $number > ($group_buy['restrict_amount'] - $group_buy['valid_goods'])) || $number > $goods['goods_number']) {
		return new ecjia_error('gb_error_goods_lacking', __('对不起，商品库存不足，请您修改数量！'));
	}

	if (!empty($spec)) {
		$product_info = get_products_info($goods['goods_id'], $spec, $warehouse_id, $area_id);
	}
	
	empty($product_info) ? $product_info = array('product_number' => 0, 'product_id' => 0) : '';
	
	/* 查询：判断指定规格的货品数量是否足够 */
	if (!empty($spec) && $number > $product_info['product_number']) {
		return new ecjia_error('gb_error_goods_lacking', __('对不起，商品库存不足，请您修改数量！'));
	}
	$goods_attr = get_goods_attr_info($spec, 'pice', $warehouse_id, $area_id);
	$goods_attr_id          = join(',', $spec);
	/* 更新：清空购物车中所有团购商品 */
	
	clear_cart(CART_GROUP_BUY_GOODS);

	
	/* 更新：加入购物车 */
	$goods_price = $group_buy['deposit'] > 0 ? $group_buy['deposit'] : $group_buy['cur_price'];
	$cart = array(
		'user_id'        => $_SESSION['user_id'],
// 		'session_id'     => SESS_ID,
		'goods_id'       => $group_buy['goods_id'],
		'product_id'     => $product_info['product_id'],
		'goods_sn'       => addslashes($goods['goods_sn']),
		'goods_name'     => addslashes($goods['goods_name']),
		'market_price'   => $goods['market_price'],
		'goods_price'    => $goods_price,
		'goods_number'   => $number,
		'goods_attr'     => addslashes($goods_attr),
// 		'goods_attr_id'  => $specs,
		'goods_attr_id'  => $goods_attr_id,
// 		'store_id'			 => $goods['store_id'],
		'seller_id'		 => $goods['seller_id'],
		'warehouse_id'   => $warehouse_id,
		'area_id'  		 => $area_id,
		'is_real'        => $goods['is_real'],
		'extension_code' => addslashes($goods['extension_code']),
		'parent_id'      => 0,
		'rec_type'       => CART_GROUP_BUY_GOODS,
		'is_gift'        => 0
	);
	$db_cart->insert($cart);
	
	/* 更新：记录购物流程类型：团购 */
	$_SESSION['flow_type'] = CART_GROUP_BUY_GOODS;
	$_SESSION['extension_code'] = 'group_buy';
	$_SESSION['extension_id'] = $act_id;
}

//购物车格式 api返回
function formated_cart_list($cart_result, $store_id_group = array()) {
    if (is_ecjia_error($cart_result)) {
        return $cart_result;
    }
    //unset($_SESSION['flow_type']);
    $cart_goods = array('cart_list' => array(), 'total' => $cart_result['total']);
    
    if (!empty($cart_result['goods_list'])) {
        foreach ($cart_result['goods_list'] as $row) {
            if (!isset($cart_goods['cart_list'][$row['store_id']])) {
                $cart_goods['cart_list'][$row['store_id']] = array(
                    'local'         => in_array($row['store_id'], $store_id_group) ? 1 : 0,
                    'seller_id'		=> intval($row['store_id']),
                    'seller_name'	=> $row['store_name'],
                    'manage_mode'   => $row['manage_mode'],
                    'is_disabled'   => 0,
                    'disabled_label'=> "",
                );
            }
            $goods_attrs = null;
            /* 查询规格 */
            if (trim($row['goods_attr']) != '') {
                $goods_attr = explode("\n", $row['goods_attr']);
                $goods_attr = array_filter($goods_attr);
                foreach ($goods_attr as $v) {
                    $a = explode(':', $v);
                    if (!empty($a[0]) && !empty($a[1])) {
                        $goods_attrs[] = array('name' => $a[0], 'value' => $a[1]);
                    }
                }
            }
    
            //goods_list
            $cart_goods['cart_list'][$row['store_id']]['goods_list'][] = array(
                'rec_id'	            => intval($row['rec_id']),
                'goods_id'	            => intval($row['goods_id']),
                'goods_sn'	            => $row['goods_sn'],
                'goods_name'	        => rc_stripslashes($row['goods_name']),
                'goods_price'	        => $row['goods_price'],
                'market_price'	        => $row['market_price'],
                'formated_goods_price'	=> $row['formatted_goods_price'],
                'formated_market_price' => $row['formatted_market_price'],
                'goods_number'	        => intval($row['goods_number']),
                'subtotal'		        => $row['subtotal'],
                'attr'			        => $row['goods_attr'],
                'goods_attr_id'         => $row['goods_attr_id'],
                'goods_attr'	        => $goods_attrs,
                'is_checked'	        => $row['is_checked'],
                'is_disabled'           => $row['is_disabled'],
                'disabled_label'        => $row['disabled_label'],
                'img' => array(
					'thumb'	=> RC_Upload::upload_url($row['goods_img']),
                    'url'	=> RC_Upload::upload_url($row['original_img']),
                    'small'	=> RC_Upload::upload_url($row['goods_img']),
                )
            );
            
        }
    }
    $cart_goods['cart_list'] = array_merge($cart_goods['cart_list']);
    
    foreach ($cart_goods['cart_list'] as &$seller) {
        //优惠活动
        $favourable             = RC_Api::api('favourable', 'favourable_list', array('store_id' => array(0, $seller['seller_id']), 'type' => 'on_going', 'sort_by' => 'store_id', 'sort_order' => 'ASC'));
        $promotions             = formated_favourable($favourable, $seller['goods_list']);
        $seller['promotions']   = $promotions;
        $min_goods_amount = RC_DB::table('merchants_config')->where('store_id', $seller['seller_id'])->where('code', 'min_goods_amount')->pluck('value');
        $seller['store_min_goods_amount']   = sprintf("%.2f", $min_goods_amount);
        RC_Loader::load_app_class('cart', 'cart', false);
        //优惠价格
        $discount                   = cart::compute_discount_store($seller['seller_id']);
        $discount['discount']       = number_format($discount['discount'], 2, '.', '');
        
        /* 用于统计购物车中实体商品和虚拟商品的个数 */
        $virtual_goods_count = 0;
        $real_goods_count    = 0;
        
        //店铺小计
        $total = array(
            'goods_price'  => 0, // 本店售价合计（有格式）
            'market_price' => 0, // 市场售价合计（有格式）
            'saving'       => 0, // 节省金额（有格式）
            'save_rate'    => 0, // 节省百分比
            'goods_amount' => 0, // 本店售价合计（无格式）
            'goods_number' => 0, // 商品总件数
            'discount'     => 0
        );
        foreach ($seller['goods_list'] as $goods) {
            if ($goods['is_checked'] == 1) {
                $total['goods_price']  += $goods['goods_price'] * $goods['goods_number'];
                $total['market_price'] += $goods['market_price'] * $goods['goods_number'];
            }
            $total['goods_number'] += $goods['goods_number'];
        }
        //判断优惠超过商品总价时
        if ($discount['discount'] > $total['goods_price']) {
            $discount['discount'] = $total['goods_price'];
        }
        $total['goods_price'] -= $discount['discount'];
        $total['goods_amount'] = $total['goods_price'];
        $total['saving']       = price_format($total['market_price'] - $total['goods_price'], false);
        if ($total['market_price'] > 0) {
            $total['save_rate'] = $total['market_price'] ? round(($total['market_price'] - $total['goods_price']) *
                100 / $total['market_price']).'%' : 0;
        }
        
        if ($total['goods_amount'] < $min_goods_amount) {
        	$meet_min_amount = 0;
        	$total['short_amount'] = sprintf("%.2f", ($min_goods_amount - $total['goods_amount']));
        	$total['label_short_amount'] = price_format($total['short_amount']); 
        } else {
        	$meet_min_amount = 1;
        	$total['short_amount'] = 0.00;
        	$total['label_short_amount'] = price_format($total['short_amount']);
        }
        
        $total['meet_min_amount'] = $meet_min_amount;
        
        $total['unformatted_goods_price']     = $total['goods_price'];
        $total['goods_price']  			      = price_format($total['goods_price'], false);
        $total['unformatted_market_price']    = $total['market_price'];
        $total['market_price'] 			= price_format($total['market_price'], false);
        $total['real_goods_count']    	= $real_goods_count;
        $total['virtual_goods_count'] 	= $virtual_goods_count;
        
        $total['discount']			= $discount['discount'];//用户享受折扣数
        $total['discount_formated']	= price_format($total['discount']);
        
        $seller['total'] = $total;
    }
    
    return $cart_goods;
}

function formated_favourable($favourable_result, $goods_list) {
    if (is_ecjia_error($favourable_result) || empty($favourable_result)) {
        return $favourable_result;
    }
    foreach ($favourable_result as $val) {
        if ($val['act_range'] == '0') {
            $favourable_list[] = array(
                'id'    => $val['act_id'],
                'title' => $val['act_name'],
                'type'  => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
                'type_label' => $val['act_type'] == '1' ? __('满减') : __('满折'),
            );
        } else {
            $act_range_ext = explode(',', $val['act_range_ext']);
            foreach ($goods_list as $goods) {
                switch ($val['act_range']) {
                    case 1 :
                        if (in_array($goods['cat_id'], $act_range_ext)) {
                            $favourable_list[] = array(
                                'id'    => $val['act_id'],
                                'title' => $val['act_name'],
                                'type'  => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
                                'type_label' => $val['act_type'] == '1' ? __('满减') : __('满折'),
                            );
                        }
                        break;
                    case 2 :
                        if (in_array($goods['brand_id'], $act_range_ext)) {
                            $favourable_list[] = array(
                                'id'    => $val['act_id'],
                                'title' => $val['act_name'],
                                'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
                                'type_label' => $val['act_type'] == '1' ? __('满减') : __('满折'),
                            );
                        }
                        break;
                    case 3 :
                        if (in_array($goods['goods_id'], $act_range_ext)) {
                            $favourable_list[] = array(
                                'id'    => $val['act_id'],
                                'title' => $val['act_name'],
                                'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
                                'type_label' => $val['act_type'] == '1' ? __('满减') : __('满折'),
                            );
                        }
                        break;
                    default:
                        break;
                }
            }
        }
    }
    //去重
    $favourable_list_new = array();
   	if (!empty($favourable_list)) {
   		foreach ($favourable_list as $k => $v) {
   			$favourable_list_new[$v['id']] = $v;
   		}
   	}
   	
   	$favourable_list_new = array_merge($favourable_list_new);

    return $favourable_list_new;
}


//dsc start

/**
 * 取得购物车商品
 * @param   int     $type   类型：默认普通商品
 * @return  array   购物车商品数组
 */
function cart_goods_dsc($type = CART_GENERAL_GOODS, $cart_value = '', $ru_type = 0, $warehouse_id = 0, $area_id = 0, $area_city = 0, $consignee = array(), $store_id = 0)
{
    $rec_txt = array('普通', '团购','拍卖','夺宝奇兵','积分商城','预售','秒杀');
    
//     $where = 1;
//     if($store_id){
//         $where .= " AND c.store_id = '$store_id' ";
//     }
    
//     $goods_where = " AND g.is_delete = 0 ";
//     if($type == CART_PRESALE_GOODS){
//         $goods_where .= " AND g.is_on_sale = 0 ";
//     }
    
//     //ecmoban模板堂 --zhuo start
//     if(!empty($_SESSION['user_id'])){
//         $c_sess = " AND c.user_id = '" . $_SESSION['user_id'] . "' ";
//     }else{
//         $c_sess = " AND c.session_id = '" . SESS_ID . "' ";
//     }
    
//     $where_area = '';
//     if ($GLOBALS['_CFG']['area_pricetype'] == 1) {
//         $where_area = " AND c.area_city = '$area_city'";
//     }
    
//     $goodsIn = '';
//     if(!empty($cart_value)){
//         $goodsIn = " AND c.rec_id in($cart_value)";
//     }
//     //ecmoban模板堂 --zhuo end
    
//     //查询非超值礼包商品
//     $sql = "SELECT c.warehouse_id, c.area_id, c.area_city, c.rec_id, c.user_id, c.goods_id, c.ru_id, g.cat_id, c.goods_name, g.goods_thumb, c.goods_sn, c.goods_number, g.default_shipping, g.goods_weight as goodsweight, " .//储值卡指定分类 liu
//         "c.market_price, c.goods_price, c.goods_attr, c.is_real, c.extension_code, c.parent_id, c.is_gift, c.rec_type, " .
//         "c.goods_price * c.goods_number AS subtotal, c.goods_attr_id, c.goods_number, c.stages_qishu, " .//查出分期期数 bylu;
//         "c.parent_id, c.group_id, pa.deposit, g.is_shipping, g.freight, g.tid, g.shipping_fee, g.brand_id, g.cloud_id, g.cloud_goodsname " .
//         "FROM " . $GLOBALS['ecs']->table('cart') . " AS c ".
//         "LEFT JOIN ".$GLOBALS['ecs']->table('goods'). " AS g ON c.goods_id = g.goods_id " .$goods_where.
//         "LEFT JOIN ".$GLOBALS['ecs']->table('presale_activity'). " AS pa ON pa.goods_id = g.goods_id AND pa.review_status = 3 ".
//         "WHERE $where " . $c_sess .
//         "AND rec_type = '$type'" . $goodsIn ." GROUP BY c.rec_id order by c.rec_id DESC";
    
//     $arr = $GLOBALS['db']->getAll($sql);
    
//     if($GLOBALS['_CFG']['add_shop_price'] == 1){
//         $add_tocart = 1;
//     }else{
//         $add_tocart = 0;
//     }
    
//     /* 格式化价格及礼包商品 */
//     foreach ($arr as $key => $value)
//     {
//         /* 判断购物车商品价格是否与目前售价一致，如果不同则返回购物车价格失效 */
//         $currency_format = !empty($GLOBALS['_CFG']['currency_format']) ? explode('%', $GLOBALS['_CFG']['currency_format']) : '';
//         $attr_id = !empty($value['goods_attr_id']) ? explode(',', $value['goods_attr_id']) : '';
        
//         if(count($currency_format) > 1){
//             $goods_price = trim(get_final_price($value['goods_id'], $value['goods_number'], true, $attr_id, $value['warehouse_id'], $value['area_id'], $value['area_city'], 0, 0, $add_tocart), $currency_format[0]);
//             $cart_price = trim($value['goods_price'], $currency_format[0]);
//         }else{
//             $goods_price = get_final_price($value['goods_id'], $value['goods_number'], true, $attr_id, $value['warehouse_id'], $value['area_id'], $value['area_city'], 0, 0, $add_tocart);
//             $cart_price = $value['goods_price'];
//         }
        
//         $goods_price = floatval($goods_price);
//         $cart_price = floatval($cart_price);
        
//         if($goods_price != $cart_price && empty($value['is_gift']) && empty($value['group_id'])){
//             $value['price_is_invalid'] = 1;//价格已过期
//         }else{
//             $value['price_is_invalid'] = 0;//价格未过期
//         }
//         if ($value['price_is_invalid'] && $value['rec_type'] == 0 && empty($value['is_gift']) && $value['extension_code'] != 'package_buy') {
//             if (isset($_SESSION['flow_type']) && $_SESSION['flow_type'] == 0 && $goods_price > 0) {
//                 get_update_cart_price($goods_price, $value['rec_id']);
//                 $value['goods_price'] = $goods_price;
//             }
//         }
        
//         $arr[$key]['formated_goods_price']  = price_format($value['goods_price'], false);
//         $arr[$key]['formated_subtotal']     = price_format($arr[$key]['subtotal'], false);
        
//         if ($value['extension_code'] == 'package_buy')
//         {
//             $value['amount'] = 0;
//             $arr[$key]['dis_amount'] = 0;
//             $arr[$key]['discount_amount'] = price_format($arr[$key]['dis_amount'], false);
            
//             $arr[$key]['package_goods_list'] = get_package_goods($value['goods_id']);
            
//             $activity = get_goods_activity_info($value['goods_id'], array('act_id', 'activity_thumb'));
//             if ($activity) {
//                 $value['goods_thumb'] = $activity['activity_thumb'];
//             }
//             $arr[$key]['goods_thumb'] = get_image_path($value['goods_id'], $value['goods_thumb'], true);
            
//             $package = get_package_goods_info($arr[$key]['package_goods_list']);
//             $arr[$key]['goods_weight'] = $package['goods_weight'];
//             $arr[$key]['goodsweight'] = $package['goods_weight'];
//             $arr[$key]['goods_number'] = $value['goods_number'];
//             $arr[$key]['attr_number'] = !judge_package_stock($value['goods_id'], $value['goods_number']);
//         }else{
//             //贡云商品参数
//             $arr[$key]['cloud_goodsname'] = $value['cloud_goodsname'];
//             $arr[$key]['cloud_id'] = $value['cloud_id'];
            
//             //ecmoban模板堂 --zhuo start 商品金额促销
//             $goods_con = get_con_goods_amount($value['subtotal'], $value['goods_id'], 0, 0, $value['parent_id']);
//             $goods_con['amount'] = explode(',', $goods_con['amount']);
//             $value['amount'] = min($goods_con['amount']);
            
//             $arr[$key]['dis_amount'] = $value['subtotal'] - $value['amount'];
//             $arr[$key]['discount_amount'] = price_format($arr[$key]['dis_amount'], false);
//             //ecmoban模板堂 --zhuo end 商品金额促销
            
//             //$arr[$key]['subtotal'] = $value['amount'];
//             $arr[$key]['goods_thumb'] = get_image_path($value['goods_id'], $value['goods_thumb'], true);
//             $arr[$key]['formated_market_price'] = price_format($value['market_price'], false);
            
//             $arr[$key]['formated_presale_deposit']  = price_format($value['deposit'], false);
            
//             //ecmoban模板堂 --zhuo
//             $arr[$key]['region_name'] = $GLOBALS['db']->getOne("select region_name from " .$GLOBALS['ecs']->table('region_warehouse'). " where region_id = '" .$value['warehouse_id']. "'");
//             $arr[$key]['rec_txt'] = $rec_txt[$value['rec_type']];
            
//             if ($value['rec_type'] == 1) {
//                 $sql = "SELECT act_id,act_name FROM " . $GLOBALS['ecs']->table('goods_activity') . " WHERE review_status = 3 AND act_type = '" . GAT_GROUP_BUY . "' AND goods_id = '" . $value['goods_id'] . "'";
//                 $group_buy = $GLOBALS['db']->getRow($sql);
                
//                 $arr[$key]['url'] = build_uri('group_buy', array('gbid' => $group_buy['act_id']));
//                 $arr[$key]['act_name'] = $group_buy['act_name'];
//             } elseif ($value['rec_type'] == 5) {
//                 $sql = "SELECT act_id,act_name FROM " . $GLOBALS['ecs']->table('presale_activity') . " WHERE goods_id = '" . $value['goods_id'] . "' AND review_status = 3 LIMIT 1";
//                 $presale = $GLOBALS['db']->getRow($sql);
                
//                 $arr[$key]['act_name'] = $presale['act_name'];
//                 $arr[$key]['url'] = build_uri('presale', array('act' => 'view', 'presaleid' => $presale['act_id']), $presale['act_name']);
//             }elseif($value['rec_type'] == 4){
//                 $arr[$key]['url'] = build_uri('exchange_goods', array('gid'=>$value['goods_id']), $value['goods_name']);
//             } else {
//                 $arr[$key]['url'] = build_uri('goods', array('gid' => $value['goods_id']), $value['goods_name']);
//             }
            
//             //预售商品，不受库存限制
//             if($value['extension_code'] == 'presale' || $value['rec_type'] > 1 ){
//                 $arr[$key]['attr_number'] = 1;
//             }else{
//                 //ecmoban模板堂 --zhuo start
//                 if($ru_type == 1 && $warehouse_id > 0 && $store_id == 0){
                    
//                     $leftJoin = " left join " .$GLOBALS['ecs']->table('warehouse_goods'). " as wg on g.goods_id = wg.goods_id and wg.region_id = '$warehouse_id' ";
//                     $leftJoin .= " left join " .$GLOBALS['ecs']->table('warehouse_area_goods'). " as wag on g.goods_id = wag.goods_id and wag.region_id = '$area_id' ";
                    
//                     $sql = "SELECT g.cloud_id, IF(g.model_price < 1, g.goods_number, IF(g.model_price < 2, wg.region_number, wag.region_number)) AS goods_number, g.user_id, g.model_attr FROM " .
//                         $GLOBALS['ecs']->table('goods') ." AS g " . $leftJoin .
//                         " WHERE g.goods_id = '" .$value['goods_id']. "' LIMIT 1";
//                         $goodsInfo = $GLOBALS['db']->getRow($sql);
                        
//                         $products = get_warehouse_id_attr_number($value['goods_id'], $value['goods_attr_id'], $goodsInfo['user_id'], $warehouse_id, $area_id, $area_city);
//                         $attr_number = $products['product_number'];
                        
//                         if($goodsInfo['model_attr'] == 1){
//                             $table_products = "products_warehouse";
//                             $type_files = " and warehouse_id = '$warehouse_id'";
//                         }elseif($goodsInfo['model_attr'] == 2){
//                             $table_products = "products_area";
//                             $type_files = " and area_id = '$area_id'";
//                             if ($GLOBALS['_CFG']['area_pricetype'] == 1) {
//                                 $type_files .= " AND city_id = '$area_city'";
//                             }
//                         }else{
//                             $table_products = "products";
//                             $type_files = "";
//                         }
                        
//                         $sql = "SELECT * FROM " .$GLOBALS['ecs']->table($table_products). " WHERE goods_id = '" .$value['goods_id']. "'" .$type_files. " LIMIT 0, 1";
//                         $prod = $GLOBALS['db']->getRow($sql);
                        
//                         if(empty($prod)){ //当商品没有属性库存时
//                             $attr_number = ($GLOBALS['_CFG']['use_storage'] == 1) ? $goodsInfo['goods_number'] : 1;
//                         }
                        
//                         //贡云商品 验证库存
//                         if ($goodsInfo['cloud_id'] > 0) {}
//                         $attr_number = !empty($attr_number) ? $attr_number : 0;
//                         $arr[$key]['attr_number'] = $attr_number;
//                 }else{
//                     $arr[$key]['attr_number'] = $value['goods_number'];
//                 }
                
//                 //ecmoban模板堂 --zhuo end
//             }
            
//             if (defined('THEME_EXTENSION')){
//                 $arr[$key]['goods_attr_text'] = get_goods_attr_info($value['goods_attr_id'], 'pice', $value['warehouse_id'], $value['area_id'], $value['area_city'], 1);
//             }
            
//             //by kong  切换门店获取商品门店库存 start 20160721
//             if($store_id > 0){
//                 $sql = "SELECT goods_number,ru_id FROM".$GLOBALS['ecs']->table("store_goods")." WHERE store_id = '$store_id' AND goods_id = '".$value['goods_id']."' ";
//                 $goodsInfo = $GLOBALS['db']->getRow($sql);
                
//                 $products = get_warehouse_id_attr_number($value['goods_id'], $value['goods_attr_id'], $goodsInfo['ru_id'], 0, 0,'',$store_id);//获取属性库存
//                 $attr_number = $products['product_number'];
//                 if($value['goods_attr_id']){ //当商品没有属性库存时
//                     $arr[$key]['attr_number'] = $attr_number;
//                 }else{
//                     $arr[$key]['attr_number'] = $goodsInfo['goods_number'];
//                 }
//             }
//             //by kong  切换门店获取商品门店库存 end 20160721
//         }
//     }

    
    if($cart_value && !is_array($cart_value)) {
        $cart_value = explode(',', $cart_value);
    }
    
    $arr = cart_goods(CART_GENERAL_GOODS, $cart_value);
    
    $goods_amount = get_cart_check_goods($arr, $cart_value);
//     _dump($arr);
    if($ru_type == 1){
        $arr = get_cart_goods_ru_list($arr, $ru_type);
        $arr = get_cart_ru_goods_list($arr, $cart_value, $consignee, $store_id);
    }
    
    return array('goods_list' => $arr, 'subtotal' => $goods_amount);
}

//划分商家或平台运费 start
function get_cart_goods_ru_list($goods, $type = 0) { //商家划分
    $ru_id_list = get_cart_goods_ru_id($goods);
    $ru_id_list = array_values(array_unique($ru_id_list));
    
    $arr = array();
    foreach ($ru_id_list as $wkey => $ru) {
        foreach ($goods as $gkey => $row) {
            if ($ru == $row['store_id']) {
                $arr[$ru][$gkey] = $row;
            }
        }
    }
    
    if ($type == 1) { //购物车显示
        return $arr;
    } else {
        $new_arr = array();
        foreach ($arr as $key => $row) {
//             $new_arr[$key] = get_cart_goods_warehouse_list($row);
        }
        
        return $new_arr;
    }
}
function get_cart_goods_ru_id($goods) {
    
    $arr = array();
    if (count($goods) > 0) {
        foreach ($goods as $key => $row) {
            $arr[$key] = $row['store_id'];
        }
    }
    
    return $arr;
}
/**
 * 区分商家商品
 */
function get_cart_ru_goods_list($goods_list, $cart_value = '', $consignee = [], $store_id = 0){
    
    if(!empty($_SESSION['user_id'])){
        $sess = $_SESSION['user_id'];
    }else{
        $sess = SESS_ID;
    }
    //配送方式选择
    $point_id = isset($_SESSION['flow_consignee']['point_id']) ? intval($_SESSION['flow_consignee']['point_id']) : 0;
    $consignee_district_id = isset($_SESSION['flow_consignee']['district']) ? intval($_SESSION['flow_consignee']['district']) : 0;
    $arr = array();
    foreach($goods_list as $key => $row){
        $shipping_type = isset($_SESSION['merchants_shipping'][$key]['shipping_type']) ? intval($_SESSION['merchants_shipping'][$key]['shipping_type']) : 0;
//         $ru_name = get_shop_name($key, 1);
        $arr[$key]['store_id'] = $key;
        $arr[$key]['shipping_type'] =  $shipping_type;
        $arr[$key]['url'] = build_uri('merchants_store', array('urid' => $key), $ru_name);
        $arr[$key]['goods_amount'] = 0;
        
        foreach($row as $gkey=>$grow){
            $arr[$key]['store_name'] = $grow['store_name'];
            $arr[$key]['goods_amount'] += $grow['goods_price'] * $grow['goods_number'];
        }
        
        if($cart_value){
//             TODO::店铺配送方式 hyytodo，众包商家自营需计算距离
//             $ru_shippng = get_ru_shippng_info($row, $cart_value, $key, $consignee);

            $region = array($consignee['country'], $consignee['province'], $consignee['city'], $consignee['district'], $consignee['street']);
            $ru_shippng = ecjia_shipping::availableUserShippings($region, $key);
            //             _dump($ru_shippng);
            
            //$arr[$key]['shipping'] = $ru_shippng['shipping_list'];
            $arr[$key]['shipping'] = $ru_shippng;
            $arr[$key]['is_freight'] = 1;//$ru_shippng['is_freight'];
            $arr[$key]['shipping_rec'] = $ru_shippng['shipping_rec'];
            
            $arr[$key]['shipping_count'] = !empty($arr[$key]['shipping']) ? count($arr[$key]['shipping']) : 0;
            if(!empty($arr[$key]['shipping']))
            {
                $arr[$key]['shipping'] = array_values($arr[$key]['shipping']);
                $arr[$key]['tmp_shipping_id'] = isset($arr[$key]['shipping'][0]['shipping_id']) ? $arr[$key]['shipping'][0]['shipping_id'] : 0; //默认选中第一个配送方式
                foreach($arr[$key]['shipping'] as $kk=>$vv)
                {
                    $vv['default'] = isset($vv['default']) ? $vv['default'] : 0;
                    if($vv['default'] == 1)
                    {
                        $arr[$key]['tmp_shipping_id'] = $vv['shipping_id'];
                        continue;
                    }
                }
            }
        }
//         if(defined('THEME_EXTENSION')){
            /*  @author-bylu 判断当前商家是否允许"在线客服" start  */
//             $shop_information = get_shop_name($key); //通过ru_id获取到店铺信息;
//             $arr[$key]['is_IM'] = isset($shop_information['is_IM']) ? $shop_information['is_IM'] : ''; //平台是否允许商家使用"在线客服";
            //判断当前商家是平台,还是入驻商家 bylu
            if ($key == 0) {
                //判断平台是否开启了IM在线客服
//                 if ($GLOBALS['db']->getOne("SELECT kf_im_switch FROM " . $GLOBALS['ecs']->table('seller_shopinfo') . "WHERE ru_id = 0", true)) {
//                     $arr[$key]['is_dsc'] = true;
//                 } else {
//                     $arr[$key]['is_dsc'] = false;
//                 }
            } else {
                $arr[$key]['is_dsc'] = false;
            }
            /*  @author-bylu  end  */
            //自营有自提点--key=ru_id
//             $sql="select * from ".$GLOBALS['ecs']->table('seller_shopinfo')." where ru_id='" .$key. "'";
//             $basic_info = $GLOBALS['db']->getRow($sql);
            $arr[$key]['kf_type'] = $basic_info['kf_type'];
            
            /*处理客服旺旺数组 by kong*/
            if($basic_info['kf_ww']){
                $kf_ww=array_filter(preg_split('/\s+/', $basic_info['kf_ww']));
                $kf_ww=explode("|",$kf_ww[0]);
                if(!empty($kf_ww[1])){
                    $arr[$key]['kf_ww'] = $kf_ww[1];
                }else{
                    $arr[$key]['kf_ww'] ="";
                }
                
            }else{
                $arr[$key]['kf_ww'] ="";
            }
            /*处理客服QQ数组 by kong*/
            if($basic_info['kf_qq']){
                $kf_qq=array_filter(preg_split('/\s+/', $basic_info['kf_qq']));
                $kf_qq=explode("|",$kf_qq[0]);
                if(!empty($kf_qq[1])){
                    $arr[$key]['kf_qq'] = $kf_qq[1];
                }else{
                    $arr[$key]['kf_qq'] = "";
                }
                
            }else{
                $arr[$key]['kf_qq'] = "";
            }
//         }
        
        if($key == 0 && $consignee_district_id > 0){
//             $self_point = get_self_point($consignee_district_id, $point_id, 1);
            
            if(!empty($self_point)){
                $arr[$key]['self_point'] = $self_point[0];
            }
        }
        /*获取门店信息 by kong 20160726 start*/
        if($store_id > 0){
//             $sql = "SELECT o.id,o.stores_name,o.stores_address,o.stores_opening_hours,o.stores_tel,o.stores_traffic_line,p.region_name as province ,"
//                 . "c.region_name as city ,d.region_name as district,o.stores_img FROM ".$GLOBALS['ecs']->table("offline_store")." AS o "
//                     . "LEFT JOIN ".$GLOBALS['ecs']->table("region")." AS p ON p.region_id = o.province "
//                         . "LEFT JOIN ".$GLOBALS['ecs']->table('region')." AS c ON c.region_id = o.city "
//                             . "LEFT JOIN ".$GLOBALS['ecs']->table('region')." AS d ON d.region_id = o.district "
//                                 . "WHERE o.id = '$store_id'  LIMIT 1";
//                                 $arr[$key]['offline_store'] = $GLOBALS['db']->getRow($sql);
                                
        }
        
        if ($row) {
            
            $shipping_rec = isset($ru_shippng['shipping_rec']) && !empty($ru_shippng['shipping_rec']) ? $ru_shippng['shipping_rec'] : [];
            
            foreach ($row as $k => $v) {
                
                if($shipping_rec && in_array($v['rec_id'], $shipping_rec)){
                    
                    $row[$k]['rec_shipping'] = 0; //不支持配送
                }else{
                    $row[$k]['rec_shipping'] = 1; //支持配送
                }
            }
        }
        
        /*获取门店信息 by kong 20160726 end*/
        $arr[$key]['goods_list'] = $row;
    }
    
    $goods_list = array_values($arr);
    return $goods_list;
}

// 重组商家购物车数组  按照优惠活动对购物车商品进行分类 -qin
function cart_by_favourable($merchant_goods) {
    
    $id_list = array();
    $list_array = array();
    foreach ($merchant_goods as $key => $row) { // 第一层 遍历商家
        $user_cart_goods = isset($row['goods_list']) && !empty($row['goods_list']) ? $row['goods_list'] : array();
        //TODO::先注释活动 hyytodo
        // 商家发布的优惠活动
//         $favourable_list = favourable_list($_SESSION['user_rank'], $row['store_id']);
        // 对优惠活动进行归类
//         $sort_favourable = sort_favourable($favourable_list);
        
        if ($user_cart_goods) {
            foreach ($user_cart_goods as $key1 => $row1) { // 第二层 遍历购物车中商家的商品
                $row1['original_price'] = $row1['goods_price'] * $row1['goods_number'];
                // 活动-全部商品
                if (isset($sort_favourable['by_all']) && $row1['extension_code'] != 'package_buy' && substr($row1['extension_code'], 0, 7) != 'seckill') {
                    foreach ($sort_favourable['by_all'] as $key2 => $row2) {
                        $mer_ids = true;
                        if($GLOBALS['_CFG']['region_store_enabled']){
                            //卖场促销 liu
                            $mer_ids = get_favourable_merchants($row2['userFav_type'], $row2['userFav_type_ext'], $row2['rs_id'], 1, $row1['ru_id']);
                        }
                        if ($row2['userFav_type'] == 1 || $mer_ids) {
                            if ($row1['is_gift'] == 0) {// 活动商品
                                if (isset($row1) && $row1) {
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['act_id'] = $row2['act_id'];
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['act_name'] = $row2['act_name'];
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type'] = $row2['act_type'];
                                    // 活动类型
                                    switch ($row2['act_type']) {
                                        case 0:
                                            $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_txt'] = $GLOBALS['_LANG']['With_a_gift'];
                                            $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_ext_format'] = intval($row2['act_type_ext']); // 可领取总件数
                                            break;
                                        case 1:
                                            $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_txt'] = $GLOBALS['_LANG']['Full_reduction'];
                                            $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_ext_format'] = number_format($row2['act_type_ext'], 2); // 满减金额
                                            break;
                                        case 2:
                                            $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_txt'] = $GLOBALS['_LANG']['discount'];
                                            $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_ext_format'] = floatval($row2['act_type_ext'] / 10); // 折扣百分比
                                            break;
                                            
                                        default:
                                            break;
                                    }
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['min_amount'] = $row2['min_amount'];
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_ext'] = intval($row2['act_type_ext']); // 可领取总件数
                                    @$merchant_goods[$key]['new_list'][$row2['act_id']]['cart_fav_amount'] += $row1['subtotal'];
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['available'] = favourable_available($row2, array(), $row1['ru_id']); // 购物车满足活动最低金额
                                    // 购物车中已选活动赠品数量
                                    $cart_favourable = cart_favourable($row1['ru_id']);
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['cart_favourable_gift_num'] = empty($cart_favourable[$row2['act_id']]) ? 0 : intval($cart_favourable[$row2['act_id']]);
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['favourable_used'] = favourable_used($row2, $cart_favourable);
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['left_gift_num'] = intval($row2['act_type_ext']) - (empty($cart_favourable[$row2['act_id']]) ? 0 : intval($cart_favourable[$row2['act_id']]));
                                    
                                    /* 检查购物车中是否已有该优惠 */
                                    
                                    // 活动赠品
                                    if ($row2['gift']) {
                                        $merchant_goods[$key]['new_list'][$row2['act_id']]['act_gift_list'] = $row2['gift'];
                                    }
                                    
                                    // new_list->活动id->act_goods_list
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['act_goods_list'][$row1['rec_id']] = $row1;
                                    unset($row1);
                                    
                                    if (defined('THEME_EXTENSION')) {
                                        $merchant_goods[$key]['new_list'][$row2['act_id']]['act_goods_list_num'] = count($merchant_goods[$key]['new_list'][$row2['act_id']]['act_goods_list']);
                                    }
                                }
                            } else { // 赠品
                                $merchant_goods[$key]['new_list'][$row2['act_id']]['act_cart_gift'][$row1['rec_id']] = $row1;
                            }
                        } else {
                            if($GLOBALS['_CFG']['region_store_enabled']){
                                // new_list->活动id->act_goods_list | 活动id的数组位置为0，表示次数组下面为没有参加活动的商品
                                $merchant_goods[$key]['new_list'][0]['act_goods_list'][$row1['rec_id']] = $row1;
                                if (defined('THEME_EXTENSION')) {
                                    $merchant_goods[$key]['new_list'][0]['act_goods_list_num'] = count($merchant_goods[$key]['new_list'][0]['act_goods_list']);
                                }
                            }
                        }
                        break; // 如果有多个优惠活动包含全部商品，只取一个
                    }
                    continue; // 如果活动包含全部商品，跳出循环体
                }
                
                // 活动-分类
                if (isset($sort_favourable['by_category']) && $row1['extension_code'] != 'package_buy' && substr($row1['extension_code'], 0, 7) != 'seckill') {
                    //优惠活动关联分类集合
                    $get_act_range_ext = get_act_range_ext($_SESSION['user_rank'], $row['ru_id'], 1); // 1表示优惠范围 按分类
                    
                    $str_cat = '';
                    foreach ($get_act_range_ext as $id) {
                        /**
                         * 当前分类下的所有子分类
                         * 返回一维数组
                         */
                        $cat_keys = get_array_keys_cat(intval($id));
                        
                        if ($cat_keys) {
                            $str_cat .= implode(",", $cat_keys);
                        }
                    }
                    
                    if ($str_cat) {
                        $list_array = explode(",", $str_cat);
                    }
                    
                    $list_array = !empty($list_array) ? array_merge($get_act_range_ext, $list_array) : $get_act_range_ext;
                    $id_list = arr_foreach($list_array);
                    $id_list = array_unique($id_list);
                    $cat_id = $row1['cat_id']; //购物车商品所属分类ID
                    // 优惠活动ID
                    $favourable_id_list = get_favourable_id($sort_favourable['by_category']);
                    // 判断商品或赠品 是否属于本优惠活动
                    if ((in_array($cat_id, $id_list) && $row1['is_gift'] == 0) || in_array($row1['is_gift'], $favourable_id_list)) {
                        foreach ($sort_favourable['by_category'] as $key2 => $row2) {
                            if (isset($row1) && $row1) {
                                //优惠活动关联分类集合
                                $fav_act_range_ext = !empty($row2['act_range_ext']) ? explode(',', $row2['act_range_ext']) : array();
                                foreach ($fav_act_range_ext as $id) {
                                    /**
                                     * 当前分类下的所有子分类
                                     * 返回一维数组
                                     */
                                    $cat_keys = get_array_keys_cat(intval($id));
                                    $fav_act_range_ext = array_merge($fav_act_range_ext, $cat_keys);
                                }
                                
                                if ($row1['is_gift'] == 0 && in_array($cat_id, $fav_act_range_ext)) { // 活动商品
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['act_id'] = $row2['act_id'];
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['act_name'] = $row2['act_name'];
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type'] = $row2['act_type'];
                                    // 活动类型
                                    switch ($row2['act_type']) {
                                        case 0:
                                            $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_txt'] = $GLOBALS['_LANG']['With_a_gift'];
                                            $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_ext_format'] = intval($row2['act_type_ext']); // 可领取总件数
                                            break;
                                        case 1:
                                            $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_txt'] = $GLOBALS['_LANG']['Full_reduction'];
                                            $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_ext_format'] = number_format($row2['act_type_ext'], 2); // 满减金额
                                            break;
                                        case 2:
                                            $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_txt'] = $GLOBALS['_LANG']['discount'];
                                            $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_ext_format'] = floatval($row2['act_type_ext'] / 10); // 折扣百分比
                                            break;
                                            
                                        default:
                                            break;
                                    }
                                    
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['min_amount'] = $row2['min_amount'];
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_ext'] = intval($row2['act_type_ext']); // 可领取总件数
                                    @$merchant_goods[$key]['new_list'][$row2['act_id']]['cart_fav_amount'] += $row1['subtotal'];
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['available'] = favourable_available($row2, array(), $row1['ru_id']); // 购物车满足活动最低金额
                                    // 购物车中已选活动赠品数量
                                    $cart_favourable = cart_favourable($row1['ru_id']);
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['cart_favourable_gift_num'] = empty($cart_favourable[$row2['act_id']]) ? 0 : intval($cart_favourable[$row2['act_id']]);
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['favourable_used'] = favourable_used($row2, $cart_favourable);
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['left_gift_num'] = intval($row2['act_type_ext']) - (empty($cart_favourable[$row2['act_id']]) ? 0 : intval($cart_favourable[$row2['act_id']]));
                                    
                                    /* 检查购物车中是否已有该优惠 */
                                    
                                    // 活动赠品
                                    if ($row2['gift']) {
                                        $merchant_goods[$key]['new_list'][$row2['act_id']]['act_gift_list'] = $row2['gift'];
                                    }
                                    
                                    // new_list->活动id->act_goods_list
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['act_goods_list'][$row1['rec_id']] = $row1;
                                    
                                    if (defined('THEME_EXTENSION')) {
                                        $merchant_goods[$key]['new_list'][$row2['act_id']]['act_goods_list_num'] = count($merchant_goods[$key]['new_list'][$row2['act_id']]['act_goods_list']);
                                    }
                                    
                                    unset($row1);
                                }
                                
                                if (isset($row1) && $row1 && $row1['is_gift'] == $row2['act_id']) { // 赠品
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['act_cart_gift'][$row1['rec_id']] = $row1;
                                }
                            }
                        }
                        continue;
                    }
                }
                
                // 活动-品牌
                if (isset($sort_favourable['by_brand']) && $row1['extension_code'] != 'package_buy' && substr($row1['extension_code'], 0, 7) != 'seckill') {
                    // 优惠活动 品牌集合
                    $get_act_range_ext = get_act_range_ext($_SESSION['user_rank'], $row['ru_id'], 2); // 2表示优惠范围 按品牌
                    $brand_id = $row1['brand_id'];
                    
                    // 优惠活动ID集合
                    $favourable_id_list = get_favourable_id($sort_favourable['by_brand']);
                    
                    // 是品牌活动的商品或者赠品
                    if ((in_array(trim($brand_id), $get_act_range_ext) && $row1['is_gift'] == 0) || in_array($row1['is_gift'], $favourable_id_list)) {
                        foreach ($sort_favourable['by_brand'] as $key2 => $row2) {
                            $act_range_ext_str = ',' . $row2['act_range_ext'] . ',';
                            $brand_id_str = ',' . $brand_id . ',';
                            
                            if (isset($row1) && $row1) {
                                if ($row1['is_gift'] == 0 && strstr($act_range_ext_str, trim($brand_id_str))) { // 活动商品
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['act_id'] = $row2['act_id'];
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['act_name'] = $row2['act_name'];
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type'] = $row2['act_type'];
                                    // 活动类型
                                    switch ($row2['act_type']) {
                                        case 0:
                                            $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_txt'] = $GLOBALS['_LANG']['With_a_gift'];
                                            $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_ext_format'] = intval($row2['act_type_ext']); // 可领取总件数
                                            break;
                                        case 1:
                                            $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_txt'] = $GLOBALS['_LANG']['Full_reduction'];
                                            $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_ext_format'] = number_format($row2['act_type_ext'], 2); // 满减金额
                                            break;
                                        case 2:
                                            $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_txt'] = $GLOBALS['_LANG']['discount'];
                                            $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_ext_format'] = floatval($row2['act_type_ext'] / 10); // 折扣百分比
                                            break;
                                            
                                        default:
                                            break;
                                    }
                                    
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['min_amount'] = $row2['min_amount'];
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_ext'] = intval($row2['act_type_ext']); // 可领取总件数
                                    @$merchant_goods[$key]['new_list'][$row2['act_id']]['cart_fav_amount'] += $row1['subtotal'];
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['available'] = favourable_available($row2); // 购物车满足活动最低金额
                                    // 购物车中已选活动赠品数量
                                    $cart_favourable = cart_favourable($row1['ru_id']);
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['cart_favourable_gift_num'] = empty($cart_favourable[$row2['act_id']]) ? 0 : intval($cart_favourable[$row2['act_id']]);
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['favourable_used'] = favourable_used($row2, $cart_favourable);
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['left_gift_num'] = intval($row2['act_type_ext']) - (empty($cart_favourable[$row2['act_id']]) ? 0 : intval($cart_favourable[$row2['act_id']]));
                                    
                                    /* 检查购物车中是否已有该优惠 */
                                    
                                    // 活动赠品
                                    if ($row2['gift']) {
                                        $merchant_goods[$key]['new_list'][$row2['act_id']]['act_gift_list'] = $row2['gift'];
                                    }
                                    
                                    // new_list->活动id->act_goods_list
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['act_goods_list'][$row1['rec_id']] = $row1;
                                    
                                    if (defined('THEME_EXTENSION')) {
                                        $merchant_goods[$key]['new_list'][$row2['act_id']]['act_goods_list_num'] = count($merchant_goods[$key]['new_list'][$row2['act_id']]['act_goods_list']);
                                    }
                                    
                                    unset($row1);
                                }
                                
                                if (isset($row1) && $row1 && $row1['is_gift'] == $row2['act_id']) { // 赠品
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['act_cart_gift'][$row1['rec_id']] = $row1;
                                }
                            }
                        }
                        continue;
                    }
                }
                
                // 活动-部分商品
                if (isset($sort_favourable['by_goods']) && $row1['extension_code'] != 'package_buy' && substr($row1['extension_code'], 0, 7) != 'seckill') {
                    $get_act_range_ext = get_act_range_ext($_SESSION['user_rank'], $row['ru_id'], 3); // 3表示优惠范围 按商品
                    // 优惠活动ID集合
                    $favourable_id_list = get_favourable_id($sort_favourable['by_goods']);
                    
                    // 判断购物商品是否参加了活动  或者  该商品是赠品
                    if (in_array($row1['goods_id'], $get_act_range_ext) || in_array($row1['is_gift'], $favourable_id_list)) {
                        foreach ($sort_favourable['by_goods'] as $key2 => $row2) { // 第三层 遍历活动
                            $act_range_ext_str = ',' . $row2['act_range_ext'] . ','; // 优惠活动中的优惠商品
                            $goods_id_str = ',' . $row1['goods_id'] . ',';
                            // 如果是活动商品
                            if (isset($row1) && $row1) {
                                if (strstr($act_range_ext_str, $goods_id_str) && ($row1['is_gift'] == 0)) {
                                    
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['act_id'] = $row2['act_id'];
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['act_name'] = $row2['act_name'];
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type'] = $row2['act_type'];
                                    // 活动类型
                                    switch ($row2['act_type']) {
                                        case 0:
                                            $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_txt'] = $GLOBALS['_LANG']['With_a_gift'];
                                            $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_ext_format'] = intval($row2['act_type_ext']); // 可领取总件数
                                            break;
                                        case 1:
                                            $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_txt'] = $GLOBALS['_LANG']['Full_reduction'];
                                            $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_ext_format'] = number_format($row2['act_type_ext'], 2); // 满减金额
                                            break;
                                        case 2:
                                            $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_txt'] = $GLOBALS['_LANG']['discount'];
                                            $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_ext_format'] = floatval($row2['act_type_ext'] / 10); // 折扣百分比
                                            break;
                                            
                                        default:
                                            break;
                                    }
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['min_amount'] = $row2['min_amount'];
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['act_type_ext'] = intval($row2['act_type_ext']); // 可领取总件数
                                    @$merchant_goods[$key]['new_list'][$row2['act_id']]['cart_fav_amount'] += $row1['subtotal'];
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['available'] = favourable_available($row2); // 购物车满足活动最低金额
                                    // 购物车中已选活动赠品数量
                                    $cart_favourable = cart_favourable($row1['ru_id']);
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['cart_favourable_gift_num'] = empty($cart_favourable[$row2['act_id']]) ? 0 : intval($cart_favourable[$row2['act_id']]);
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['favourable_used'] = favourable_used($row2, $cart_favourable);
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['left_gift_num'] = intval($row2['act_type_ext']) - (empty($cart_favourable[$row2['act_id']]) ? 0 : intval($cart_favourable[$row2['act_id']]));
                                    
                                    /* 检查购物车中是否已有该优惠 */
                                    
                                    // 活动赠品
                                    if ($row2['gift']) {
                                        $merchant_goods[$key]['new_list'][$row2['act_id']]['act_gift_list'] = $row2['gift'];
                                    }
                                    
                                    // new_list->活动id->act_goods_list
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['act_goods_list'][$row1['rec_id']] = $row1;
                                    
                                    if (defined('THEME_EXTENSION')) {
                                        $merchant_goods[$key]['new_list'][$row2['act_id']]['act_goods_list_num'] = count($merchant_goods[$key]['new_list'][$row2['act_id']]['act_goods_list']);
                                    }
                                    break;
                                    
                                    unset($row1);
                                }
                                
                                // 如果是赠品
                                if (isset($row1) && $row1 && $row1['is_gift'] == $row2['act_id']) {
                                    $merchant_goods[$key]['new_list'][$row2['act_id']]['act_cart_gift'][$row1['rec_id']] = $row1;
                                }
                            }
                        }
                    } else {
                        // new_list->活动id->act_goods_list | 活动id的数组位置为0，表示次数组下面为没有参加活动的商品
                        $merchant_goods[$key]['new_list'][0]['act_goods_list'][$row1['rec_id']] = $row1;
                        if (defined('THEME_EXTENSION')) {
                            $merchant_goods[$key]['new_list'][0]['act_goods_list_num'] = count($merchant_goods[$key]['new_list'][0]['act_goods_list']);
                        }
                    }
                } else {
                    // new_list->活动id->act_goods_list | 活动id的数组位置为0，表示次数组下面为没有参加活动的商品
                    $merchant_goods[$key]['new_list'][0]['act_goods_list'][$row1['rec_id']] = $row1;
                    if (defined('THEME_EXTENSION')) {
                        $merchant_goods[$key]['new_list'][0]['act_goods_list_num'] = count($merchant_goods[$key]['new_list'][0]['act_goods_list']);
                    }
                }
            }
        }
    }
    
    return $merchant_goods;
}

/**
 * 取得某用户等级当前时间可以享受的优惠活动
 * @param   int     $user_rank      用户等级id，0表示非会员
 * @param int $user_id 商家id
 * @param int $fav_id 优惠活动ID
 * @return  array
 *
 * 显示赠品商品 $ru_id 传参
 */
function favourable_list($user_rank, $user_id = -1, $fav_id = 0, $act_sel_id = array(), $ru_id = -1) {
    $where = '';
    if ($user_id >= 0) {
        //$where .= " AND user_id = '$user_id'";
        $where .= " AND IF(userFav_type = 0, user_id = '$user_id', 1 = 1) ";
    }
    if ($fav_id > 0) {
        $where .= " AND act_id = '$fav_id' ";
    }
    /* 购物车中已有的优惠活动及数量 */
    $used_list = cart_favourable($ru_id);
    
    /* 当前用户可享受的优惠活动 */
    $favourable_list = array();
    $user_rank = ',' . $user_rank . ',';
    $now = gmtime();
    $sql = "SELECT * " .
        "FROM " . $GLOBALS['ecs']->table('favourable_activity') .
        " WHERE CONCAT(',', user_rank, ',') LIKE '%" . $user_rank . "%'" .
        " AND review_status = 3 AND start_time <= '$now' AND end_time >= '$now' " . $where .
        " ORDER BY sort_order";
    
    $res = $GLOBALS['db']->query($sql);
    while ($favourable = $GLOBALS['db']->fetchRow($res)) {
        $favourable['start_time'] = local_date($GLOBALS['_CFG']['time_format'], $favourable['start_time']);
        $favourable['end_time'] = local_date($GLOBALS['_CFG']['time_format'], $favourable['end_time']);
        $favourable['formated_min_amount'] = price_format($favourable['min_amount'], false);
        $favourable['formated_max_amount'] = price_format($favourable['max_amount'], false);
        $favourable['gift'] = unserialize($favourable['gift']);
        
        foreach ($favourable['gift'] as $key => $value) {
            $favourable['gift'][$key]['formated_price'] = price_format($value['price'], false);
            // 赠品缩略图
            $favourable['gift'][$key]['thumb_img'] = $GLOBALS['db']->getOne("SELECT goods_thumb FROM " . $GLOBALS['ecs']->table('goods') . " WHERE goods_id = '$value[id]'");
            $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('goods') . " WHERE is_on_sale = 1 AND goods_id = " . $value['id'];
            $is_sale = $GLOBALS['db']->getOne($sql);
            if (!$is_sale) {
                unset($favourable['gift'][$key]);
            }
        }
        
        $favourable['act_range_desc'] = act_range_desc($favourable);
        $favourable['act_type_desc'] = sprintf($GLOBALS['_LANG']['fat_ext'][$favourable['act_type']], $favourable['act_type_ext']);
        
        /* 是否能享受 */
        $favourable['available'] = favourable_available($favourable, $act_sel_id);
        if ($favourable['available']) {
            /* 是否尚未享受 */
            $favourable['available'] = !favourable_used($favourable, $used_list);
        }
        
        $favourable['act_range_ext'] = return_act_range_ext($favourable['act_range_ext'], $favourable['userFav_type'], $favourable['act_range']);
        
        $favourable_list[] = $favourable;
    }
    
    return $favourable_list;
}

// 对优惠商品进行归类
function sort_favourable($favourable_list)
{
    $arr = array();
    foreach ($favourable_list as $key => $value)
    {
        switch ($value['act_range'])
        {
            case FAR_ALL:
                $arr['by_all'][$key] = $value;
                break;
            case FAR_CATEGORY:
                $arr['by_category'][$key] = $value;
                break;
            case FAR_BRAND:
                $arr['by_brand'][$key] = $value;
                break;
            case FAR_GOODS:
                $arr['by_goods'][$key] = $value;
                break;
            default:
                break;
        }
    }
    return $arr;
}

/**
 * 重新组合购物流程商品数组
 */
function get_new_group_cart_goods($cart_goods_list_new){
    $car_goods = array();
    foreach($cart_goods_list_new as $key=>$goods){
        foreach($goods['goods_list'] as $k => $list){
            $car_goods[] = $list;
        }
    }
    
    return $car_goods;
}

/**
 * $type 0 获取数组差集数值
 * $type 1 获取数组交集数值
 */
function get_sc_str_replace($str1, $str2, $type = 0){
    
    $str1 = !empty($str1) ? explode(',', $str1) : array();
    $str2 = !empty($str2) ? explode(',', $str2) : array();
    
    $str = '';
    if ($str1 && $str2) {
        if ($type) {
            $str = array_diff($str1, $str2);
        } else {
            $str = array_intersect($str1, $str2);
        }
        
        $str = implode(",", $str);
    }
    
    return $str;
}

/**
 * 检测
 * 购物流程商品配送方式
 */
function get_flowdone_goods_list($cart_goods_list, $tmp_shipping_id_arr){
    
    if ($cart_goods_list && $tmp_shipping_id_arr) {
        foreach ($cart_goods_list as $key => $val) {
            foreach ($tmp_shipping_id_arr as $k => $v) {
                if ($v[1] > 0 && $val['ru_id'] == $v[0]) {
                    $cart_goods_list[$key]['tmp_shipping_id'] = $v[1];
                }
            }
        }
    }
    
    return $cart_goods_list;
}

// end