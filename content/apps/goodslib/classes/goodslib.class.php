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

class goodslib {
    
    /**
     * 获得商品列表
     *
     * @access public
     * @param
     *            s integer $isdelete
     * @param
     *            s integer $conditions
     * @return array
     */
    public static function goods_list($is_delete, $conditions = '', $page_size = 10) {
        /* 过滤条件 */
        $param_str 	= '-' . $is_delete;
        $day 		= getdate();
        $today 		= RC_Time::local_mktime(23, 59, 59, $day ['mon'], $day ['mday'], $day ['year']);
    
        $filter ['cat_id'] 			= empty ($_REQUEST ['cat_id']) 			? 0 	: intval($_REQUEST ['cat_id']);
        $filter ['intro_type'] 		= empty ($_REQUEST ['intro_type']) 		? '' 	: trim($_REQUEST ['intro_type']);
        $filter ['brand_id'] 		= empty ($_REQUEST ['brand_id']) 		? 0 	: intval($_REQUEST ['brand_id']);
        $filter ['keywords'] 		= empty ($_REQUEST ['keywords']) 		? '' 	: trim($_REQUEST ['keywords']);
        
        $filter ['suppliers_id'] 	= isset ($_REQUEST ['suppliers_id']) 	? (empty ($_REQUEST ['suppliers_id']) ? '' : trim($_REQUEST ['suppliers_id'])) : '';
        $filter ['type'] 			= !empty($_REQUEST ['type']) 			? $_REQUEST ['type'] : '';
    
        $filter ['sort_by'] 		= empty ($_REQUEST ['sort_by']) 		? 'sort_order' 	: trim($_REQUEST ['sort_by']);
        $filter ['sort_order'] 		= empty ($_REQUEST ['sort_order']) 		? 'ASC' 		: trim($_REQUEST ['sort_order']);
        $filter ['extension_code'] 	= empty ($_REQUEST ['extension_code']) 	? '' 			: trim($_REQUEST ['extension_code']);
        $filter ['is_delete'] 		= $is_delete;
        
        $filter ['review_status']	= empty ($_REQUEST ['review_status'])	? 0 	: intval($_REQUEST ['review_status']);
        
        $where = $filter ['cat_id'] > 0 ? " AND " . get_children($filter ['cat_id']) : '';
    
        /* 品牌 */
        if ($filter ['brand_id']) {
            $where .= " AND brand_id=".$filter['brand_id'];
        }
    
        /* 扩展 */
        if ($filter ['extension_code']) {
            $where .= " AND extension_code='".$filter['extension_code']."'";
        }
    
        /* 关键字 */
        if (!empty ($filter ['keywords'])) {
            $where .= " AND (goods_sn LIKE '%" . mysql_like_quote($filter ['keywords']) . "%' OR goods_name LIKE '%" . mysql_like_quote($filter ['keywords']) . "%')";
        }
        
        $db_goods = RC_DB::table('goods as g');
        
        //筛选全部 已上架 未上架 商家
        $filter_count = $db_goods
       		->select(RC_DB::raw('count(*) as count_goods_num'), 
       			RC_DB::raw('SUM(IF(is_on_sale = 1, 1, 0)) as count_on_sale'), 
       			RC_DB::raw('SUM(IF(is_on_sale = 0, 1, 0)) as count_not_sale'),
       			RC_DB::raw('SUM(IF(is_on_sale = 0, 1, 0)) as count_not_sale'))
       		->whereRaw('is_delete = ' . $is_delete . '' . $where)
        	->first();

        /* 是否上架 */
        if ($filter ['type'] == 1 || $filter ['type'] == 2) {
        	$is_on_sale = $filter ['type'];
            $filter ['type'] == 2 && $is_on_sale = 0;
            $where .= " AND (is_on_sale='" . $is_on_sale . "')";
        }
        
        /* 供货商 */
        if (!empty ($filter ['suppliers_id'])) {
            $where .= " AND (suppliers_id = '" . $filter ['suppliers_id'] . "')";
        }
        $where .= $conditions;

        $db_goods = RC_DB::table('goodslib as g');
        /* 记录总数 */
        $count = $db_goods->whereRaw('is_delete = ' . $is_delete . '' . $where)->count('goods_id');
        if ($_SESSION['store_id']) {
            $page = new ecjia_merchant_page ($count, $page_size, 3);
        } else {
            $page = new ecjia_page ($count, $page_size, 5);
        }
        
        $filter ['record_count'] 	= $count;
        $filter ['count_goods_num'] = $filter_count['count_goods_num'] > 0 ? $filter_count['count_goods_num'] : 0;
        $filter ['count_on_sale'] 	= $filter_count['count_on_sale'] > 0 ? $filter_count['count_on_sale'] : 0;
        $filter ['count_not_sale'] 	= $filter_count['count_not_sale'] > 0 ? $filter_count['count_not_sale'] : 0;
        
        $db_goods
            ->select(RC_DB::raw('g.goods_id, g.goods_name, g.goods_type, g.goods_sn, g.shop_price, g.market_price, g.cost_price, g.goods_weight, g.goods_thumb, g.sort_order, g.is_display'))
        	->orderBy($filter ['sort_by'], $filter['sort_order'])->orderBy('goods_id', 'desc');
        if($page_size) {
            $rows = $db_goods->take($page_size)
            ->skip($page->start_id-1)
            ->get();
        } else {
            $rows = $db_goods->get();
        }
        	
        $filter ['keyword'] = stripslashes($filter ['keyword']);
        $filter ['count'] 	= $count;
        $disk = RC_Storage::disk();
        if (!empty($rows)) {
            foreach ($rows as $k => $v) {
        		if (!empty($v['goods_thumb']) && $disk->exists(RC_Upload::upload_path($v['goods_thumb']))) {
        		    $rows[$k]['goods_thumb'] = RC_Upload::upload_url($v['goods_thumb']);
        		} else {
        		    $rows[$k]['goods_thumb'] = RC_Uri::admin_url('statics/images/nopic.png');
        		}
                $rows[$k]['product_list'] = RC_DB::table('goodslib_products')->where('goods_id', $v['goods_id'])->get();
        	}
        }
        return array(
            'goods'		=> $rows,
            'filter'	=> $filter,
            'page'		=> $page->show(2),
            'desc'		=> $page->page_desc()
        );
    }
    
    public static function get_export_goods_list($page_size = 10) {
        
        $filter ['cat_id'] 			= empty ($_REQUEST ['cat_id']) 			? 0 	: intval($_REQUEST ['cat_id']);
        $filter ['brand_id'] 		= empty ($_REQUEST ['brand_id']) 		? 0 	: intval($_REQUEST ['brand_id']);
        $filter ['keywords'] 		= empty ($_REQUEST ['keywords']) 		? '' 	: trim($_REQUEST ['keywords']);
        
        $filter ['sort_by'] 		= empty ($_REQUEST ['sort_by']) 		? 'sort_order' 	: trim($_REQUEST ['sort_by']);
        $filter ['sort_order'] 		= empty ($_REQUEST ['sort_order']) 		? 'ASC' 		: trim($_REQUEST ['sort_order']);
        $filter ['is_delete'] 		= 0;
        
        $where = $filter ['cat_id'] > 0 ? " AND " . get_children($filter ['cat_id']) : '';
        
        /* 品牌 */
        if ($filter ['brand_id']) {
            $where .= " AND brand_id=".$filter['brand_id'];
        }
        
        /* 关键字 */
        if (!empty ($filter ['keywords'])) {
            $where .= " AND (goods_sn LIKE '%" . mysql_like_quote($filter ['keywords']) . "%' OR goods_name LIKE '%" . mysql_like_quote($filter ['keywords']) . "%')";
        }
        
        /* 供货商 */
        if (!empty ($filter ['suppliers_id'])) {
            $where .= " AND (suppliers_id = '" . $filter ['suppliers_id'] . "')";
        }
        
        $db_goods = RC_DB::table('goodslib as g');
        /* 记录总数 */
        $count = $db_goods->whereRaw('is_delete = ' . $filter ['is_delete'] . '' . $where)->count('goods_id');
        $page = new ecjia_page ($count, $page_size, 5);
        
        $filter ['record_count'] 	= $count;
        
        $db_goods
            ->select(RC_DB::raw('goods_id, g.goods_sn, g.goods_name, g.shop_price, g.market_price, g.cost_price, g.goods_weight, g.weight_unit, 
            g.keywords, g.goods_brief, g.goods_desc, g.brand_id, g.cat_id, goods_type, g.specification_id, g.parameter_id
            '))
        ->orderBy($filter['sort_by'], $filter['sort_order']);
        if($page_size) {
            $rows = $db_goods->take($page_size)
            ->skip($page->start_id-1)
            ->get();
        } else {
            $rows = $db_goods->get();
        }
        
        $filter ['keyword'] = stripslashes($filter ['keyword']);
        $filter ['count'] 	= $count;
        if (!empty($rows)) {
            RC_Loader::load_app_func('global', 'goodslib');
            $cat = RC_DB::table('category')->get();
            $cat = array_change_key($cat, 'cat_id');
            $brand = RC_DB::table('brand')->get();
            $brand = array_change_key($brand, 'brand_id');
            $types = RC_DB::table('goods_type')->where('store_id', 0)->get();
            $types = array_change_key($types, 'cat_id');
            foreach ($rows as $k => $v) {
                $rows[$k]['brand_name'] = $brand[$v['brand_id']]['brand_name'];
                $rows[$k]['cat_name'] = $cat[$v['cat_id']]['cat_name'];

                $goods_attr = [];
                //specification_id优先

                if($v['specification_id']) {
                    $cat_id = $v['specification_id'];
                    $goods_attr = self::get_goodslib_attr($types, $v['goods_id'], $cat_id, 'specification');
                }

                if ($v['goods_type'] && empty($v['specification_id'])) {
                    $cat_id = $v['goods_type'];
                    $goods_attr = self::get_goodslib_attr($types, $v['goods_id'], $cat_id);
                }
                $rows[$k]['goods_attr'] = $goods_attr['goods_attr'];
                $rows[$k]['goods_attr_export'] = $goods_attr['goods_attr_export'];
                $rows[$k]['goods_product'] = $goods_attr['goods_product'];
                $rows[$k]['goods_product_export'] = $goods_attr['goods_product_export'];
                if($v['parameter_id']) {
                    $cat_id = $v['parameter_id'];
                    $cat_info = Ecjia\App\Goods\GoodsAttr::get_template_info($cat_id);
                    $rows[$k]['goods_parameter'] = $cat_info['cat_name'] . "\n" . Ecjia\App\Goods\GoodsAttr::goodslib_build_attr_text($cat_id, $v['goods_id']);
                }
            }
//            _dump($rows,1);
            $goods = [];
            foreach ($rows as $row) {
            	if ($row['goods_weight'] > 0) {
            		if (empty($row['weight_unit'])) {
            			if ($row['goods_weight'] < 1) {
            				$row['goods_weight'] = $row['weight_unit'] * 1000;
            			}
            		}
            	}
                $goods[] = array(
                    'goods_sn' => $row['goods_sn'],
                    'product_sn' => NULL,
                    'goods_name' => $row['goods_name'],
                    'shop_price' => $row['shop_price'],
                    'market_price' => $row['market_price'],
                    'cost_price' => $row['cost_price'],
                    'goods_weight' => $row['goods_weight'],
                    'keywords' => $row['keywords'],
                    'goods_brief' => $row['goods_brief'],
                    'goods_desc' => $row['goods_desc'],
                    'brand_id' => $row['brand_id'],
                    'brand_name' => $row['brand_name'],
                    'cat_id' => $row['cat_id'],
                    'cat_name' => $row['cat_name'],
                    'goods_attr' => $row['goods_attr_export'],
                    'goods_product' => NULL,
                    'goods_parameter' => $row['goods_parameter'],
                );

                if(isset($row['goods_product_export'])) {
                    foreach ($row['goods_product_export'] as $product) {
                        $goods[] = array(
                            'goods_sn' => $row['goods_sn'],
                            'product_sn' => $product['product_sn'],
                            'goods_name' => $product['product_name'],
                            'shop_price' => $product['product_shop_price'],
                            'market_price' => NULL,
                            'cost_price' => NULL,
                            'goods_weight' => NULL,
                            'keywords' => NULL,
                            'goods_brief' => NULL,
                            'goods_desc' => $product['product_desc'],
                            'brand_id' => NULL,
                            'brand_name' => NULL,
                            'cat_id' => NULL,
                            'cat_name' => NULL,
                            'goods_attr' => NULL,
                            'goods_product' => $product['goods_product'],
                        );
                    }
                }
            }
        }

        return array(
            'goods'		=> $goods,
            'filter'	=> $filter,
            'page'		=> $page->show(2),
            'desc'		=> $page->page_desc()
        );
    }

    public static function get_goodslib_attr($types, $goods_id, $cat_id, $cat_type) {
        $db_goods_attr = RC_DB::table('goodslib_attr')->where('goods_id', $goods_id);
        if($cat_type) {
            $db_goods_attr->where('cat_type', $cat_type);
        } else {
            $db_goods_attr->whereNull('cat_type');
        }
        $goods_attr = $db_goods_attr->get();

        $parent_row = [];
        if($goods_attr) {
            $goods_attr = array_change_key($goods_attr, 'goods_attr_id');
            $goods_attribute = RC_DB::table('attribute')->where('cat_id', $cat_id)->get();
            $goods_attribute = array_change_key($goods_attribute, 'attr_id');
            //goods_type
            //attribute

            $goods_attr_export = [];
            foreach ($goods_attr as $k_a => $r_a) {
                $goods_attr[$k_a]['attr_name'] = $goods_attribute[$r_a['attr_id']]['attr_name'];
                $goods_attr[$k_a]['cat_name'] = $types[$goods_attribute[$r_a['attr_id']]['cat_id']]['cat_name'];
                $parent_row['goods_attr'][] = [
                    'cat_name' => $goods_attr[$k_a]['cat_name'],
                    'attr_name' => $goods_attr[$k_a]['attr_name'],
                    'attr_value' => $r_a['attr_value'],
//                                 'color_value' => $r_a['color_value'],//暂用不到
                    'attr_price' => $r_a['attr_price'],
                ];
                $parent_row['goods_attr_export'] .= $goods_attr[$k_a]['cat_name'].';'.$goods_attr[$k_a]['attr_name'].';'.$r_a['attr_value'].';'/* .$r_a['color_value'].';' */.$r_a['attr_price']."\n";
            }

            //product
            $goods_pro = RC_DB::table('goodslib_products')->where('goods_id', $goods_id)->get();
            if($goods_pro) {
                foreach ($goods_pro as $k_p => $r_p) {
                    $product_attr = explode('|', $r_p['goods_attr']);
                    $new_goods_attr = [];
                    foreach ($product_attr as $goods_attr_id) {
                        $new_goods_attr[] = $goods_attr[$goods_attr_id]['cat_name'] .','.$goods_attr[$goods_attr_id]['attr_name'] .','.$goods_attr[$goods_attr_id]['attr_value'];
                    }
                    $goods_pro[$k_p]['goods_attr_name'] = implode('|', $new_goods_attr);
                    $parent_row['goods_product'][] = [
                        'goods_attr' => $goods_pro[$k_p]['goods_attr_name'],
                        'product_sn' => $r_p['product_sn'],
                    ];
                    $r_p['goods_product'] = $goods_pro[$k_p]['goods_attr_name']/*."\r\n"*/;
                    $parent_row['goods_product_export'][] = $r_p;
                }
            }
        }

        return $parent_row;
    }
    
    /**
     * 获得商家商品列表
     *
     * @access public
     * @param
     *            s integer $isdelete
     * @param
     *            s integer $real_goods
     * @param
     *            s integer $conditions
     * @return array
     */
    public static function merchant_goods_list($is_delete, $real_goods = 1, $conditions = '') {}
}

// end