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

class goods {
    /**
     * 取得推荐类型列表
     *
     * @return array 推荐类型列表
     */
    public static function intro_list() {
        $arr = array(
            'is_best'		=> RC_Lang::get('goods::goods.is_best'),
            'is_new'		=> RC_Lang::get('goods::goods.is_new'),
            'is_hot'		=> RC_Lang::get('goods::goods.is_hot'),
            'is_promote'	=> RC_Lang::get('goods::goods.is_promote'),
            'all_type'		=> RC_Lang::get('goods::goods.all_type')
        );
        
        return $arr;
    }
    
    /**
     * 取得重量单位列表
     *
     * @return array 重量单位列表
     */
    public static function unit_list() {
        $arr = array(
            '1' =>		RC_Lang::get('goods::goods.unit_kg'),
            '0.001' =>	RC_Lang::get('goods::goods.unit_g')
        );
        
        return $arr;
    }
    
    /**
     * 获得商品列表
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
    public static function goods_list($is_delete, $real_goods = 1, $conditions = '') {
        /* 过滤条件 */
        $param_str 	= '-' . $is_delete . '-' . $real_goods;
        $day 		= getdate();
        $today 		= RC_Time::local_mktime(23, 59, 59, $day ['mon'], $day ['mday'], $day ['year']);
    
        $filter ['cat_id'] 			= empty ($_REQUEST ['cat_id']) 			? 0 	: intval($_REQUEST ['cat_id']);
        $filter ['intro_type'] 		= empty ($_REQUEST ['intro_type']) 		? '' 	: trim($_REQUEST ['intro_type']);
        $filter ['is_promote'] 		= empty ($_REQUEST ['is_promote']) 		? 0 	: intval($_REQUEST ['is_promote']);
        $filter ['stock_warning'] 	= empty ($_REQUEST ['stock_warning']) 	? 0 	: intval($_REQUEST ['stock_warning']);
        $filter ['brand_id'] 		= empty ($_REQUEST ['brand_id']) 		? 0 	: intval($_REQUEST ['brand_id']);
        $filter ['keywords'] 		= empty ($_REQUEST ['keywords']) 		? '' 	: trim($_REQUEST ['keywords']);
        $filter ['merchant_keywords'] = empty ($_REQUEST ['merchant_keywords']) ? '' : trim($_REQUEST ['merchant_keywords']);
        
        $filter ['suppliers_id'] 	= isset ($_REQUEST ['suppliers_id']) 	? (empty ($_REQUEST ['suppliers_id']) ? '' : trim($_REQUEST ['suppliers_id'])) : '';
        $filter ['type'] 			= !empty($_REQUEST ['type']) 			? $_REQUEST ['type'] : '';
    
        $filter ['sort_by'] 		= empty ($_REQUEST ['sort_by']) 		? 'goods_id' 	: trim($_REQUEST ['sort_by']);
        $filter ['sort_order'] 		= empty ($_REQUEST ['sort_order']) 		? 'DESC' 		: trim($_REQUEST ['sort_order']);
        $filter ['extension_code'] 	= empty ($_REQUEST ['extension_code']) 	? '' 			: trim($_REQUEST ['extension_code']);
        $filter ['is_delete'] 		= $is_delete;
        $filter ['real_goods'] 		= $real_goods;
        
        $filter ['review_status']	= empty ($_REQUEST ['review_status'])	? 0 	: intval($_REQUEST ['review_status']);
        $filter ['store_id']		= empty ($_REQUEST ['store_id'])		? 0 	: intval($_REQUEST ['store_id']);
        
        $where = $filter ['cat_id'] > 0 ? " AND " . get_children($filter ['cat_id']) : '';
    
        /* 推荐类型 */
        switch ($filter ['intro_type']) {
        	case 'is_best' :
        	    $where .= " AND is_best=1";
        	    break;
        	case 'is_hot' :
        	    $where .= ' AND is_hot=1';
        	    break;
        	case 'is_new' :
        	    $where .= ' AND is_new=1';
        	    break;
        	case 'is_promote' :
        	    $where .= " AND is_promote = 1 AND promote_price > 0 AND promote_start_date <= '$today' AND promote_end_date >= '$today'";
        	    break;
        	case 'all_type' :
        	    $where .= " AND (is_best=1 OR is_hot=1 OR is_new=1 OR (is_promote = 1 AND promote_price > 0 AND promote_start_date <= '" . $today . "' AND promote_end_date >= '" . $today . "'))";
        }
    
        /* 库存警告 */
        if ($filter ['stock_warning']) {
            $where .= ' AND goods_number <= warn_number ';
        }
    
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
        
        /* 商家关键字 */
        if (!empty ($filter ['merchant_keywords'])) {
        	$where .= " AND (s.merchants_name LIKE '%" . mysql_like_quote($filter ['merchant_keywords']) . "%')";
        }
        
        /* 审核状态 */
        if (!empty($filter['review_status'])) {
        	$where .= " AND g.review_status=".$filter['review_status'];
        }
        
        /* 店铺id*/
        if (!empty($filter['store_id'])) {
        	$where .= " AND g.store_id=".$filter['store_id'];
        }
    
        if ($real_goods > -1) {
            $where .= " AND is_real='$real_goods'";
        }
        
        $db_goods = RC_DB::table('goods as g')
       		->leftJoin('store_franchisee as s', RC_DB::raw('g.store_id'), '=', RC_DB::raw('s.store_id'));
        
        //筛选全部 已上架 未上架 商家
        $filter_count = $db_goods
       		->select(RC_DB::raw('count(*) as count_goods_num'), 
       			RC_DB::raw('SUM(IF(is_on_sale = 1, 1, 0)) as count_on_sale'), 
       			RC_DB::raw('SUM(IF(is_on_sale = 0, 1, 0)) as count_not_sale'),
       			RC_DB::raw('SUM(IF(is_on_sale = 0, 1, 0)) as count_not_sale'),
       			RC_DB::raw('SUM(IF(s.manage_mode = "self", 1, 0)) as self'))
       		->whereRaw('is_delete = ' . $is_delete . '' . $where)
        	->first();

        /* 是否上架 */
        if ($filter ['type'] == 1 || $filter ['type'] == 2) {
        	$is_on_sale = $filter ['type'];
            $filter ['type'] == 2 && $is_on_sale = 0;
            $where .= " AND (is_on_sale='" . $is_on_sale . "')";
        } elseif ($filter['type'] == 'self') {
        	$where .= " AND s.manage_mode = 'self'";
        }
        
        /* 供货商 */
        if (!empty ($filter ['suppliers_id'])) {
            $where .= " AND (suppliers_id = '" . $filter ['suppliers_id'] . "')";
        }
        $where .= $conditions;

        $db_goods = RC_DB::table('goods as g')
        	->leftJoin('store_franchisee as s', RC_DB::raw('g.store_id'), '=', RC_DB::raw('s.store_id'));
        /* 记录总数 */
        $count = $db_goods->whereRaw('is_delete = ' . $is_delete . '' . $where)->count('goods_id');
        $page = new ecjia_page ($count, 10, 5);
        $filter ['record_count'] 	= $count;
        $filter ['count_goods_num'] = $filter_count['count_goods_num'] > 0 ? $filter_count['count_goods_num'] : 0;
        $filter ['count_on_sale'] 	= $filter_count['count_on_sale'] > 0 ? $filter_count['count_on_sale'] : 0;
        $filter ['count_not_sale'] 	= $filter_count['count_not_sale'] > 0 ? $filter_count['count_not_sale'] : 0;
        $filter ['self'] 			= $filter_count['self'] > 0 ? $filter_count['self'] : 0;
        
        $sql = $db_goods
        	->selectRaw('g.goods_id, g.goods_name, g.goods_type, g.goods_sn, g.shop_price, g.goods_thumb, g.is_on_sale, g.is_best, g.is_new, g.is_hot, g.sort_order, g.goods_number, g.integral, (g.promote_price > 0 AND g.promote_start_date <= ' . $today . ' AND g.promote_end_date >= ' . $today . ') as is_promote, g.review_status, s.merchants_name')
        	->orderBy($filter ['sort_by'], $filter['sort_order'])
        	->take(10)
        	->skip($page->start_id-1)
        	->get();
        	
        $filter ['keyword'] = stripslashes($filter ['keyword']);
        $filter ['count'] 	= $count;
        $disk = RC_Filesystem::disk();
        if (!empty($sql)) {
        	foreach ($sql as $k => $v) {
        		if (!empty($v['goods_thumb']) && $disk->exists(RC_Upload::upload_path($v['goods_thumb']))) {
        			$sql[$k]['goods_thumb'] = RC_Upload::upload_url($v['goods_thumb']);
        		} else {
        			$sql[$k]['goods_thumb'] = RC_Uri::admin_url('statics/images/nopic.png');
        		}
        	}
        }
        $row = $sql;
        return array(
            'goods'		=> $row,
            'filter'	=> $filter,
            'page'		=> $page->show(2),
            'desc'		=> $page->page_desc()
        );
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
    public static function merchant_goods_list($is_delete, $real_goods = 1, $conditions = '') {
    	//     	$db = RC_Loader::load_app_model('goods_viewmodel', 'goods');
    
    	/* 过滤条件 */
    	$param_str 	= '-' . $is_delete . '-' . $real_goods;
    	$day 		= getdate();
    	$today 		= RC_Time::local_mktime(23, 59, 59, $day ['mon'], $day ['mday'], $day ['year']);
    
    	$filter ['cat_id'] 			= empty ($_REQUEST ['cat_id']) 			? 0 	: intval($_REQUEST ['cat_id']);
    	$filter ['intro_type'] 		= empty ($_REQUEST ['intro_type']) 		? '' 	: trim($_REQUEST ['intro_type']);
    	$filter ['is_promote'] 		= empty ($_REQUEST ['is_promote']) 		? 0 	: intval($_REQUEST ['is_promote']);
    	$filter ['stock_warning'] 	= empty ($_REQUEST ['stock_warning']) 	? 0 	: intval($_REQUEST ['stock_warning']);
    	$filter ['brand_id'] 		= empty ($_REQUEST ['brand_id']) 		? 0 	: intval($_REQUEST ['brand_id']);
    	$filter ['keywords'] 		= empty ($_REQUEST ['keywords']) 		? '' 	: trim($_REQUEST ['keywords']);
    	$filter ['merchant_keywords'] = empty ($_REQUEST ['merchant_keywords']) ? '' : trim($_REQUEST ['merchant_keywords']);
    
    	$filter ['suppliers_id'] 	= isset ($_REQUEST ['suppliers_id']) 	? (empty ($_REQUEST ['suppliers_id']) ? '' : trim($_REQUEST ['suppliers_id'])) : '';
    	$filter ['type'] 			= !empty($_REQUEST ['type']) 			? $_REQUEST ['type'] : '';
    
    	$filter ['sort_by'] 		= empty ($_REQUEST ['sort_by']) 		? 'store_sort_order' 	: trim($_REQUEST ['sort_by']);
    	$filter ['sort_order'] 		= empty ($_REQUEST ['sort_order']) 		? 'asc' 				: trim($_REQUEST ['sort_order']);
    	$filter ['extension_code'] 	= empty ($_REQUEST ['extension_code']) 	? '' 					: trim($_REQUEST ['extension_code']);
    	$filter ['is_delete'] 		= $is_delete;
    	$filter ['real_goods'] 		= $real_goods;
    
    	$filter ['review_status'] 			= empty ($_REQUEST ['review_status']) 			?  0 	: intval($_REQUEST ['review_status']);
    
    	$where = $filter ['cat_id'] > 0 ? " AND " . merchant_get_children($filter ['cat_id']) : '';
    
    	/* 推荐类型 */
    	switch ($filter ['intro_type']) {
    		case 'is_best' :
    			$where .= " AND store_best=1";
    			break;
    		case 'is_hot' :
    			$where .= ' AND store_hot=1';
    			break;
    		case 'is_new' :
    			$where .= ' AND store_new=1';
    			break;
    		case 'is_promote' :
    			$where .= " AND is_promote = 1 AND promote_price > 0 AND promote_start_date <= '$today' AND promote_end_date >= '$today'";
    			break;
    		case 'all_type' :
    			$where .= " AND ((store_best=1 AND store_hot=1 AND store_new=1) OR (is_promote = 1 AND promote_price > 0 AND promote_start_date <= '" . $today . "' AND promote_end_date >= '" . $today . "'))";
    	}
    
    	/* 库存警告 */
    	if ($filter ['stock_warning']) {
    		$where .= ' AND goods_number <= warn_number ';
    	}
    
    	/* 品牌 */
    	//         if ($filter ['brand_id']) {
    	//             $where .= " AND brand_id=".$filter['brand_id'];
    	//         }
    
    	/* 扩展 */
    	if ($filter ['extension_code']) {
    		$where .= " AND extension_code='".$filter['extension_code']."'";
    	}
    
    	/* 关键字 */
    	if (!empty ($filter ['keywords'])) {
    		$where .= " AND (goods_sn LIKE '%" . mysql_like_quote($filter ['keywords']) . "%' OR goods_name LIKE '%" . mysql_like_quote($filter ['keywords']) . "%')";
    	}
    
    	/* 审核状态 */
    	if (!empty($filter['review_status'])) {
    		$where .= " AND review_status='".$filter['review_status']."'";
    	}
    
    	if ($real_goods > -1) {
    		$where .= " AND is_real='$real_goods'";
    	}
    
    	$db_goods = RC_DB::table('goods as g')
    		->leftJoin('store_franchisee as s', RC_DB::raw('g.store_id'), '=', RC_DB::raw('s.store_id'))
    		->where(RC_DB::raw('g.store_id'), $_SESSION['store_id']);
    
    	//筛选全部 已上架 未上架 商家
    	$filter_count = $db_goods
    	->select(RC_DB::raw('count(*) as count_goods_num'),
    			RC_DB::raw('SUM(IF(is_on_sale = 1, 1, 0)) as count_on_sale'),
    			RC_DB::raw('SUM(IF(is_on_sale = 0, 1, 0)) as count_not_sale'),
    			RC_DB::raw('SUM(IF(is_on_sale = 0, 1, 0)) as count_not_sale'),
    			RC_DB::raw('SUM(IF(g.store_id > 0, 1, 0)) as merchant'))
    			->whereRaw('is_delete = ' . $is_delete . '' . $where)
    			->first();
    
    	/* 是否上架 */
    	if ($filter ['type'] == 1 || $filter ['type'] == 2) {
    		$is_on_sale = $filter ['type'];
    		$filter ['type'] == 2 && $is_on_sale = 0;
    		$where .= " AND (is_on_sale='" . $is_on_sale . "')";
    	} elseif ($filter['type'] == 'merchant') {
    		$where .= " AND g.store_id > 0";
    	}
    
    	/* 供货商 */
    	if (!empty ($filter ['suppliers_id'])) {
    		$where .= " AND (suppliers_id = '" . $filter ['suppliers_id'] . "')";
    	}
    	$where .= $conditions;
    
    	$db_goods = RC_DB::table('goods as g')
    	->leftJoin('store_franchisee as s', RC_DB::raw('g.store_id'), '=', RC_DB::raw('s.store_id'))
    	->where(RC_DB::raw('g.store_id'), $_SESSION['store_id']);
    
    	/* 记录总数 */
    	$count = $db_goods->whereRaw('is_delete = ' . $is_delete . '' . $where)->count('goods_id');
    	$page = new ecjia_merchant_page ($count, 10, 3);
    	$filter ['record_count'] 	= $count;
    	$filter ['count_goods_num'] = $filter_count['count_goods_num'] > 0 ? $filter_count['count_goods_num'] : 0;
    	$filter ['count_on_sale'] 	= $filter_count['count_on_sale'] > 0 ? $filter_count['count_on_sale'] : 0;
    	$filter ['count_not_sale'] 	= $filter_count['count_not_sale'] > 0 ? $filter_count['count_not_sale'] : 0;
    	$filter ['merchant'] 		= $filter_count['merchant'] > 0 ? $filter_count['merchant'] : 0;
    
    	$sql = $db_goods
	    	->selectRaw('g.goods_id, g.goods_name, g.goods_type, g.goods_sn, g.shop_price, g.goods_thumb, g.is_on_sale, g.store_best, g.store_new, g.store_hot, g.store_sort_order, g.goods_number, g.integral, (g.promote_price > 0 AND g.promote_start_date <= ' . $today . ' AND g.promote_end_date >= ' . $today . ') as is_promote, g.review_status, s.merchants_name')
	    	->orderBy($filter ['sort_by'], $filter['sort_order'])
	    	->orderBy('goods_id', 'desc')
	    	->take(10)
	    	->skip($page->start_id-1)
	    	->get();
    
    	$filter ['keyword'] = stripslashes($filter ['keyword']);
    	$filter ['count'] 	= $count;
    	$disk = RC_Filesystem::disk();
    	if (!empty($sql)) {
    		foreach ($sql as $k => $v) {
    			if (!empty($v['goods_thumb']) && $disk->exists(RC_Upload::upload_path($v['goods_thumb']))) {
    				$sql[$k]['goods_thumb'] = RC_Upload::upload_url($v['goods_thumb']);
    			} else {
    				$sql[$k]['goods_thumb'] = RC_Uri::admin_url('statics/images/nopic.png');
    			}
    		}
    	}
    	$row = $sql;
    
    	return array(
    		'goods'		=> $row,
    		'filter'	=> $filter,
    		'page'		=> $page->show(2),
    		'desc'		=> $page->page_desc()
    	);
    }
}

// end