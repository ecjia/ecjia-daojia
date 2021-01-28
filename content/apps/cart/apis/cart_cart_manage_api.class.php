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
 
class cart_cart_manage_api extends Component_Event_Api {

    /**
     * @param
     *
     * @return array|ecjia_error
     */
    public function call(&$options) {

        if (!isset($options['store_group']) || empty($options['store_group'])) {
            return new ecjia_error('location_error', __('当前定位地址超出服务范围！', 'cart'));
        }

        if (!isset($options['goods_id']) || empty($options['goods_id'])) {
            return new ecjia_error('not_found_goods', __('请选择您所需要的商品！', 'cart'));
        }

        return $this->addto_cart($options['goods_id'], $options['goods_number'], $options['goods_spec'], $options['parent_id'], $options['store_group'], $options['product_id']);
    }

    /**
     * 添加商品到购物车
     *
     * @access  public
     * @param   integer $goods_id   商品编号
     * @param   integer $num        商品数量
     * @param   array   $spec       规格值对应的id数组
     * @param   integer $parent     基本件
     * @return  array|bool|ecjia_error
     */
    private function addto_cart($goods_id, $num = 1, $spec = array(), $parent = 0, $store_group = array(), $product_id = 0) {
        RC_Loader::load_app_class('goods_info', 'goods', false);
        
        if ($product_id > 0) {
        	$product_info = RC_DB::table('products')->where('product_id', $product_id)->first();
        	$spec = explode('|', $product_info['goods_attr']);
        } else {
        	$product_id = 0;
        }
        
        $_parent_id     = $parent;
        if (is_array($spec)) {
            sort($spec);
        }
        
        $dbview = RC_DB::table('goods as g')->leftJoin('member_price as mp', RC_DB::raw('g.goods_id'), '=', RC_DB::raw('mp.goods_id'));

        $field = 'g.goods_name, g.goods_sn, g.is_on_sale, g.is_real, g.market_price, g.shop_price AS org_price, g.promote_price, g.promote_start_date,g.promote_end_date, g.goods_weight, g.integral, g.extension_code,g.goods_number, g.is_alone_sale, g.is_shipping,IFNULL(mp.user_price, g.shop_price * '.$_SESSION['discount'].') AS shop_price, g.store_id';
        //$goods = $dbview->field($field)->join(array('member_price'))->find(array('g.goods_id' => $goods_id , 'g.is_delete' => 0));
        $goods = $dbview->select(RC_DB::raw($field))
            ->where(RC_DB::raw('g.goods_id'), $goods_id)
            ->where(RC_DB::raw('g.is_delete'), 0)->first();

        if (empty($goods)) {
            return new ecjia_error('no_goods', __('对不起，该商品不存在！', 'cart'));
        }

        /* 是否正在销售 */
        if ($goods['is_on_sale'] == 0) {
            return new ecjia_error('goods_out_of_stock', __('对不起，该商品已下架！', 'cart'));
        }

		$count = RC_DB::table('store_franchisee')->where('shop_close', '0')->where('store_id', $goods['store_id'])->count();
		if(empty($count)){
			return new ecjia_error('no_goods', __('对不起，该商品所属的店铺已经下线！', 'cart'));
		}

		$db_cart = RC_DB::table('cart');
        /* 如果是作为配件添加到购物车的，需要先检查购物车里面是否已经有基本件 */
        if ($parent > 0) {
            $db_cart->where('goods_id', $parent);
            $db_cart->where('user_id', $_SESSION['user_id']);
            $db_cart->where('extension_code', '<>', 'package_buy');
//             if (defined('SESS_ID')) {
//                 $db_cart->where('session_id', SESS_ID);
//             }
            $count = $db_cart->count();

            if ($count == 0) {
                return new ecjia_error('addcart_error', __('对不起，您希望将该商品做为配件购买，可是购物车中还没有该商品的基本件。', 'cart'));
            }
        }

        /* 不是配件时检查是否允许单独销售 */
        if (empty($parent) && $goods['is_alone_sale'] == 0) {
            return new ecjia_error('not_alone_sale', __('对不起，该商品不能单独购买！', 'cart'));
        }

        if (!in_array($goods['store_id'], $store_group)) {
        	// return new ecjia_error('goods_delivery_beyond_error', '您所添加的商品超出了配送区域！');
        }

        /* 如果商品有规格则取规格商品信息 配件除外 */
        $prod = RC_DB::table('products')->where('goods_id', $goods_id)->count();

        //商品存在规格 是货品 检查该货品库存
        if (goods_info::is_spec($spec)) {
            //$product_info = goods_info::get_products_info($goods_id, $spec);
        	$goods_attr = implode ( '|', $spec);
        	$product_info = RC_DB::table('products')->where('goods_id', $goods_id)->where('goods_attr', $goods_attr)->first();
            if (empty($product_info)) {
            	return new ecjia_error('low_stocks', __('暂无此货品！', 'cart'));
            }
            $product_id = $product_info['product_id'];
            $spec = explode('|', $product_info['goods_attr']);
            $is_spec = true;
        } else {
        	$is_spec = false;
        }
        
        if (!isset($product_info) || empty($product_info)) {
            $product_info = array('product_number' => 0, 'product_id' => 0 , 'goods_attr'=>'');
        }
        
        /* 检查：库存 */
        if (ecjia::config('use_storage') == 1) {
			if ($product_info['product_id'] > 0) {
				//商品存在规格 是货品 检查该货品库存
				if ($is_spec) {
					if (!empty($spec)) {
						/* 取规格的货品库存 */
						if ($num > $product_info['product_number']) {
							return new ecjia_error('low_stocks', __('货品库存不足', 'cart'));
						}
					}
				}
			} else {
				//检查：商品购买数量是否大于总库存
				if ($num > $goods['goods_number']) {
					return new ecjia_error('low_stocks', __('库存不足', 'cart'));
				}
			}
        }
        /* 计算商品的促销价格 */
        $goods_attr_id = 0;
        if (!empty($spec)) {
            $spec_price             = goods_info::spec_price($spec);
            $goods_price            = goods_info::get_final_price($goods_id, $num, true, $spec, $product_id);
            $goods_attr             = goods_info::get_goods_attr_info($spec, 'no');
            $goods_attr_id          = join(',', $spec);
            if (!empty($product_id)) {
            	//商品SKU价格模式：商品价格 + 属性货品价格；货品未设置自定义价格
            	if ($product_info['product_shop_price'] <= 0) {
            		$goods['market_price'] += $spec_price;
            	}
            }
        }
        $goods_attr_id = empty($goods_attr_id) ? 0 : $goods_attr_id;

        /* 初始化要插入购物车的基本件数据 */
        $parent = array(
	        'user_id'       => $_SESSION['user_id'],
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
	        'rec_type'      => \Ecjia\App\Cart\Enums\CartEnum::CART_GENERAL_GOODS,
	        'store_id'      => $goods['store_id'],
	        'add_time'      => RC_Time::gmtime(),
        );
        //货品自定义名称
        if (!empty($product_info['product_name'])) {
        	$parent['goods_name'] = addslashes($product_info['product_name']);
        }

        if (defined('SESS_ID')) {
            $parent['session_id'] = SESS_ID;
        }

        /* 如果该配件在添加为基本件的配件时，所设置的“配件价格”比原价低，即此配件在价格上提供了优惠， */
        /* 则按照该配件的优惠价格卖，但是每一个基本件只能购买一个优惠价格的“该配件”，多买的“该配件”不享受此优惠 */
        $basic_list = array();
        
        $db_group_goods = RC_DB::table('group_goods');

        if (!empty($goods_id)) {
            $db_group_goods->where('goods_id', $goods_id);
        }
        if (!empty($goods_price)) {
        	$db_group_goods->where('goods_price', '<', $goods_price);
        }
        if (!empty($_parent_id)) {
        	$db_group_goods->where('parent_id', $_parent_id);
        }
        $data = $db_group_goods
            ->select('parent_id', 'goods_price')
            ->orderBy('goods_price', 'asc')
            ->get();

        if(!empty($data)) {
            foreach ($data as $row) {
                $basic_list[$row['parent_id']] = $row['goods_price'];
            }
        }
        /* 取得购物车中该商品每个基本件的数量 */
        $basic_count_list = array();
        if ($basic_list) {
        	$db_cart_bisic = RC_DB::table('cart');
            //$basic_w = '';
            if (defined('SESS_ID')) {
                $session_id = SESS_ID;
                //$basic_w .= "and session_id='$session_id'";
                $db_cart_bisic->where('session_id', $session_id);
            }

            $data = $db_cart_bisic
                    ->where('user_id', $_SESSION['user_id'])
                    ->where('parent_id', 0)
                    //->where('extension_code', '<>', 'package_buy')
                    ->whereIn('goods_id', array_keys($basic_list))
                    ->orderBy('goods_id', 'asc')
                    ->get();

            if(!empty($data)) {
                foreach ($data as $row) {
                    $basic_count_list[$row['goods_id']] = $row['count'];
                }
            }
        }
        /* 取得购物车中该商品每个基本件已有该商品配件数量，计算出每个基本件还能有几个该商品配件 */
        /* 一个基本件对应一个该商品配件 */
        if ($basic_count_list) {
        	$db_cart_bisic_l_w = RC_DB::table('cart');
            //$basic_l_w = '';
            if (defined('SESS_ID')) {
                $session_id = SESS_ID;
                //$basic_l_w .= "and session_id='$session_id'";
                $db_cart_bisic_l_w->where('session_id', $session_id);
            }
            $data = $db_cart_bisic_l_w
                    ->select('parent_id', 'SUM(goods_number) as count')
                    ->where('user_id', $_SESSION['user_id'])
                    ->where('goods_id', $goods_id)
                    //->where('extension_code', '<>', 'package_buy')
                    ->whereIn('parent_id', array_keys($basic_count_list))
                    ->get();
            if(!empty($data)) {
                foreach ($data as $row) {
                    $basic_count_list[$row['parent_id']] -= $row['count'];
                }
            }
        }

        
        
        /* 循环插入配件 如果是配件则用其添加数量依次为购物车中所有属于其的基本件添加足够数量的该配件 */
        if  (!empty($basic_list)) {
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
        }

        /* 如果数量不为0，作为基本件插入 */
        $user_id = $_SESSION['user_id'];
        if ($num > 0) {
            /* 检查该商品是否已经存在在购物车中 */
        	$rec_type = \Ecjia\App\Cart\Enums\CartEnum::CART_GENERAL_GOODS;
        	//删除之前添加的促销数据cart表is_promote是1的（同一商品在促销的，购买未超过促销限购数的按促销价添加一条，超过的按原价添加一条）
        	$promote_cart = RC_DB::table('cart')->where('user_id', $user_id)->where('goods_id', $goods_id)->where('parent_id', 0) ->where('rec_type', $rec_type)->where('is_promote', 1);
        	if (!empty($goods_attr_id)) {
        		$promote_cart->where('goods_attr_id', $goods_attr_id);
        	}
        	$promote_cart->delete();
            // 重新赋值查询
            $db_cart_model = RC_DB::table('cart');
            $db_cart_model
                ->select('rec_id', 'goods_number')
                ->where('user_id', $_SESSION['user_id'])
                ->where('goods_id', $goods_id)
                ->where('parent_id', 0)
                //->where('extension_code', '!=', 'package_buy')
                ->where('rec_type', '=', $rec_type);
            if (!empty($goods_attr_id)) {
            	$db_cart_model->where('goods_attr_id', $goods_attr_id);
            }
            $row = $db_cart_model->first();
          
            if($row) {
                //如果购物车已经有此物品，则更新
                $num += $row['goods_number'];
                if(goods_info::is_spec($spec) && !empty($prod) ) {
                    $goods_storage = $product_info['product_number'];
                } else {
                    $goods_storage = $goods['goods_number'];
                }
                if (ecjia::config('use_storage') == 0 || $num <= $goods_storage) {
                    $goods_price = goods_info::get_final_price($goods_id, $num, true, $spec, $product_id);
                    $data =  array(
                   		'goods_number' => $num,
                    	'goods_price'  => $goods_price,
                        'is_checked'   => 1,//增加已有商品，更新选中状态
                    );
                    RC_DB::table('cart')
                    				->where('user_id', $_SESSION['user_id'])
                    				->where('goods_id', $goods_id)
                    				->where('parent_id', 0)
                    				//->where('extension_code', '<>', 'package_buy')
                    				->where('rec_type', $rec_type)
                    				->where('goods_attr_id', $goods_attr_id)
                    				->update($data);

                } else {
                    return new ecjia_error('low_stocks', __('库存不足', 'cart'));
                }
                $cart_id = $row['rec_id'];
            } else {
                //购物车没有此物品，则插入
                $goods_price = goods_info::get_final_price($goods_id, $num, true, $spec, $product_id);
                $parent['goods_price']  = empty($goods_price) ? 0.00 : max($goods_price, 0);
                $parent['goods_number'] = $num;
                $parent['parent_id']    = 0;
                $cart_id = RC_DB::table('cart')->insertGetId($parent);
            }
        }
        
        /**
         * 判断添加的商品有没在促销，在促销的话，判断促销限购数量
         * （有没超过用户限购数， 有没超过活动限购数）；
         * 更新购买记录；更新购物车价格
         */
        if ($_SESSION['user_id'] > 0) {
        	$promotion = new \Ecjia\App\Goods\GoodsActivity\GoodsPromotion($goods_id, $product_id, $_SESSION['user_id']);
        	$is_promote = $promotion->isPromote();
        	if ($is_promote) {
        		$left_num = $promotion->getLimitOverCount($num); //用户可购买的限购剩余数
        		//剩余可购买数大于0
        		if ($left_num > 0) {
        			//剩余可购买数量的新增一条作为按促销价的数据
        			$cartinfo = RC_DB::table('cart')->where('rec_id', $cart_id)->first();
        			unset($cartinfo['rec_id']);
        			//购买数量大于限购可购买数量；新增一条数据作为按促销价的数据
        			if ($num > $left_num) {
        				//多购买的数量
        				$more_num =  $num - $left_num;
        				$cartinfo['goods_number'] 	= $left_num;
        				$cartinfo['group_id'] 		= empty($cartinfo['group_id']) ? '' : $cartinfo['group_id'];
        				$cartinfo['goods_attr']		= empty($cartinfo['goods_attr']) ? '' : $cartinfo['goods_attr'];
        				$cartinfo['extension_code'] = empty($cartinfo['extension_code']) ? '' : $cartinfo['extension_code'];
        				$cartinfo['is_promote']		= 1;
        	
        				RC_DB::table('cart')->insert($cartinfo);
        	
        				//更新多余购买数量的为原价
        				$promotion->updateCartGoodsPrice($cart_id, $goods_id, $more_num, true, $spec, $product_id);
        			} elseif($num == $left_num) {
        				//如果当前数据$cartinfo为非促销数据，更新is_promote为1
        				if ($cartinfo['is_promote'] == '0') {
        					RC_DB::table('cart')->where('rec_id', $cartinfo['rec_id'])->update(['is_promote' => 1]);
        				}
        			}
        		} else {
        			//限购可购买数量等于0，更新商品价格为原价
        			$promotion->updateCartGoodsPrice($cart_id, $goods_id, $num, true, $spec, $product_id);
        		}
        	}
        }
       
        /* 把赠品删除 */
        //$delete_w = '';
        $db_delete_w = RC_DB::table('cart');
        //$delete_w = "user_id = '$user_id'"."and is_gift <> 0";
        $db_delete_w->where('user_id', $_SESSION['user_id'])->where('is_gift', '<>', 0);
        if (defined('SESS_ID')) {
            $session_id = SESS_ID;
            //$delete_w .= " and session_id='$session_id'";
            $db_delete_w->where('session_id', $session_id);
        }

        $db_delete_w->delete();
        return $cart_id;
    }
}

// end