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
 * 比较优惠活动的函数，用于排序（把可用的排在前面）
 * @param   array   $a      优惠活动a
 * @param   array   $b      优惠活动b
 * @return  int     相等返回0，小于返回-1，大于返回1
 */
function cmp_favourable($a, $b) {
    if ($a['available'] == $b['available']) {
        if ($a['sort_order'] == $b['sort_order']) {
            return 0;
        } else {
            return $a['sort_order'] < $b['sort_order'] ? -1 : 1;
        }
    } else {
        return $a['available'] ? -1 : 1;
    }
}

/**
 * 取得某用户等级当前时间可以享受的优惠活动
 * @param   int     $user_rank      用户等级id，0表示非会员
 * @return  array
 */
function em_favourable_list($user_rank) {
	RC_Loader::load_app_func('global', 'goods');
	$db_favourable_activity = RC_Loader::load_app_model('favourable_activity_model','favourable');
	$db_goods = RC_Loader::load_app_model('goods_model','goods');
    /* 购物车中已有的优惠活动及数量 */
    $used_list = cart_favourable();

    /* 当前用户可享受的优惠活动 */
    $favourable_list = array();
    $user_rank = ',' . $user_rank . ',';
    $now = RC_Time::gmtime();
	
    $where = array(
    	"CONCAT(',', user_rank, ',') LIKE '%" . $user_rank . "%'",
    	'start_time' => array('elt' => $now),
    	'end_time' => array('egt' => $now),
    	'act_type' => FAT_GOODS
    );
    
	$data = $db_favourable_activity->where($where)->order('sort_order asc')->select();
    foreach ($data as $favourable) {
        $favourable['formated_start_time'] = RC_Time::local_date(ecjia::config('time_format'), $favourable['start_time']);
        $favourable['formated_end_time']   = RC_Time::local_date(ecjia::config('time_format'), $favourable['end_time']);
        $favourable['formated_min_amount'] = price_format($favourable['min_amount'], false);
        $favourable['formated_max_amount'] = price_format($favourable['max_amount'], false);
        $favourable['gift']       = unserialize($favourable['gift']);

        foreach ($favourable['gift'] as $key => $value) {
            $favourable['gift'][$key]['formated_price'] = price_format($value['price'], false);

            $is_sale = $db_goods->where('is_on_sale = 1 AND goods_id = '.$value['id'].'')->count();            
            if(!$is_sale) {
                unset($favourable['gift'][$key]);
            }
        }
		
        $favourable['act_range_desc'] = act_range_desc($favourable);
        $favourable['act_type_desc'] = sprintf(RC_Lang::get('cart::shopping_flow.fat_ext.'.$favourable['act_type']), $favourable['act_type_ext']);

        /* 是否能享受 */
        $favourable['available'] = favourable_available($favourable);
        if ($favourable['available']) {
            /* 是否尚未享受 */
            $favourable['available'] = !favourable_used($favourable, $used_list);
        }

        $favourable_list[] = $favourable;
    }

    return $favourable_list;
}

/**
 * 根据购物车判断是否可以享受某优惠活动
 * @param   array   $favourable     优惠活动信息
 * @return  bool
 */
function favourable_available($favourable)
{
    /* 会员等级是否符合 */
    $user_rank = $_SESSION['user_rank'];
    if (strpos(',' . $favourable['user_rank'] . ',', ',' . $user_rank . ',') === false) {
        return false;
    }

    /* 优惠范围内的商品总额 */
    $amount = cart_favourable_amount($favourable);
    /* 金额上限为0表示没有上限 */
    return $amount >= $favourable['min_amount'] &&
        ($amount <= $favourable['max_amount'] || $favourable['max_amount'] == 0);
}

/**
 * 取得优惠范围描述
 * @param   array   $favourable     优惠活动
 * @return  string
 */
function act_range_desc($favourable)
{
	$db_brand = RC_Loader::load_app_model('brand_model','goods');
	$db_category = RC_Loader::load_app_model('category_model','goods');
	$db_goods = RC_Loader::load_app_model('goods_model','goods');

    if ($favourable['act_range'] == FAR_BRAND) {
    	$brandArr = array();
    	if (!empty($favourable['act_range_ext'])) {
    		$brandName = $db_brand->field('brand_name')->in(array('brand_id'=>$favourable['act_range_ext']))->select();
    		foreach ($brandName as $row) {
    			$brandArr[] = $row['brand_name'];
    		}
    		return join(',', $brandArr);
    	}
    	return '';
    } elseif ($favourable['act_range'] == FAR_CATEGORY) {
    	$catArr = array();
    	if (!empty($favourable['act_range_ext'])) {
	    	$cat_name = $db_category->field('cat_name')->in(array('cat_id'=>$favourable['act_range_ext']))->select();
	    	foreach ($cat_name as $row) {
	    		$catArr[] = $row['cat_name'];
	    	}
	    	return join(',', $catArr);
    	}
    	return '';
    } elseif ($favourable['act_range'] == FAR_GOODS) {
    	if (!empty($favourable['act_range_ext'])) {
	        $goods_name = $db_goods->field('goods_name')->in(array('goods_id'=>$favourable['act_range_ext']))->select();
	    	foreach ($goods_name as $row) {
	    		$goodsArr[] = $row['goods_name'];
	    	}
	    	return join(',', $goodsArr);
    	}
    	return '';
    } else {
        return '';
    }
}

/**
 * 取得购物车中已有的优惠活动及数量
 * @return  array
 */
function cart_favourable() {
	$db_cart = RC_Loader::load_app_model('cart_model','cart');
    $list = array();

    $data = $db_cart->field('is_gift, COUNT(*) AS num')->where('session_id = "' . SESS_ID . '" AND rec_type = ' . CART_GENERAL_GOODS . ' AND is_gift > 0')->group('is_gift asc')->select();
    
    if(!empty($data))
    {
	    foreach ($data as $row)
	    {
	        $list[$row['is_gift']] = $row['num'];
	    }
    }
    return $list;
}

/**
 * 购物车中是否已经有某优惠
 * @param   array   $favourable     优惠活动
 * @param   array   $cart_favourable购物车中已有的优惠活动及数量
 */
function favourable_used($favourable, $cart_favourable) {
    if ($favourable['act_type'] == FAT_GOODS)
    {
        return isset($cart_favourable[$favourable['act_id']]) &&
            $cart_favourable[$favourable['act_id']] >= $favourable['act_type_ext'] &&
            $favourable['act_type_ext'] > 0;
    }
    else
    {
        return isset($cart_favourable[$favourable['act_id']]);
    }
}

/**
 * 添加优惠活动（赠品）到购物车
 * @param   int     $act_id     优惠活动id
 * @param   int     $id         赠品id
 * @param   float   $price      赠品价格
 */
function add_gift_to_cart($act_id, $id, $price) {
	$db_goods = RC_Loader::load_app_model('goods_model','goods');
	$db_cart = RC_Loader::load_app_model('cart_model','cart');

	$row = $db_goods->field('goods_id, goods_sn, goods_name, market_price, is_real, extension_code')->find('goods_id = '.$id.'');
	$data = array(
		'user_id' => $_SESSION['user_id'],
		'session_id' => SESS_ID,
		'goods_id' => $row['goods_id'],
		'goods_sn' => $row['goods_sn'],
		'goods_name' => $row['goods_name'],
		'market_price' => $row['market_price'],
		'goods_price' => $price,
		'goods_number' => 1,
		'is_real' => $row['is_real'],
		'extension_code' => $row['extension_code'],
		'parent_id' => 0,
		'is_gift' => $act_id,
		'rec_type' => CART_GENERAL_GOODS,
	);

	$db_cart->insert($data);
}

/**
 * 添加优惠活动（非赠品）到购物车
 * @param   int     $act_id     优惠活动id
 * @param   string  $act_name   优惠活动name
 * @param   float   $amount     优惠金额
 */
function add_favourable_to_cart($act_id, $act_name, $amount) {
	$db_cart = RC_Loader::load_app_model('cart_model','cart');

	$data = array(
		'user_id' => $_SESSION['user_id'],
		'session_id' => SESS_ID,
		'goods_id' => 0,
		'goods_sn' => '',
		'goods_name' => $act_name,
		'market_price' => 0,
		'goods_price' => (-1) * $amount,
		'goods_number' => 1,
		'is_real' => 0,
		'extension_code' => '',
		'parent_id' => 0,
		'is_gift' => $act_id,
		'rec_type' => CART_GENERAL_GOODS
	);
	$db_cart->insert($data);	
}

/**
 * 取得购物车中某优惠活动范围内的总金额
 * @param   array   $favourable     优惠活动
 * @return  float
 */
function cart_favourable_amount($favourable) {
	$db_cartview = RC_Loader::load_app_model('cart_good_member_viewmodel','cart');
    /* 查询优惠范围内商品总额的sql */
	$db_cartview->view =array(
    	'goods' => array(
    		'type'  =>Component_Model_View::TYPE_LEFT_JOIN,
    		'alias' => 'g',
    		'on'   	=> 'c.goods_id = g.goods_id'
    	)
    );
    $where = array(
    	'c.rec_type' => CART_GENERAL_GOODS,
    	'c.is_gift' => 0,
    	'c.goods_id' => array('gt' => 0),
    );
    if ($_SESSION['user_id']) {
    	$where = array_merge($where,array('c.user_id' => $_SESSION['user_id']));
    } else {
    	$where = array_merge(array('c.session_id' => SESS_ID));
    }
	$sum = 'c.goods_price * c.goods_number';
	RC_Loader::load_app_func('global', 'goods');
	RC_Loader::load_app_func('admin_category', 'goods');
	
    /* 根据优惠范围修正sql */
    if ($favourable['act_range'] == FAR_ALL) {
        // sql do not change
    } elseif ($favourable['act_range'] == FAR_CATEGORY) {
        /* 取得优惠范围分类的所有下级分类 */
        $id_list = array();
        $cat_list = explode(',', $favourable['act_range_ext']);
        foreach ($cat_list as $id) {
            $id_list = array_merge($id_list, array_keys(cat_list(intval($id), 0, false)));
        }
        $where = array_merge($where,array('g.cat_id'.db_create_in($id_list)));
	} elseif ($favourable['act_range'] == FAR_BRAND) {
        $id_list = explode(',', $favourable['act_range_ext']);
        $where = array_merge($where,array('g.brand_id'.db_create_in($id_list)));
		$query = $db_cartview->where($where)->in(array('g.brand_id' => $id_list))->sum($sum);
    } else {
        $id_list = explode(',', $favourable['act_range_ext']);
        $where = array_merge($where,array('g.goods_id'.db_create_in($id_list)));
	}
    $id_list = explode(',', $favourable['act_range_ext']);
    
    /* 优惠范围内的商品总额 */
	$row = $db_cartview->where($where)->sum($sum);
  	return $row;
}

// end