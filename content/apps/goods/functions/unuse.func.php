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

// ======================================== 未使用的方法整理 start ======================================== //

function get_user_category($options, $shopMain_category, $ru_id = 0, $admin_type = 0) {
	$db_merchants_category = RC_Model::model('seller/merchants_category_model');
	if ($ru_id > 0) {
		$shopMain_category = get_category_child_tree($shopMain_category);
		$arr = array();
		if (!empty($shopMain_category)) {
			$category = explode(',', $shopMain_category);
			foreach ($options as $key=>$row) {
				if ($row['level'] < 3) {
					for ($i=0; $i<count($category); $i++) {
						if ($key == $category[$i]) {
							$arr[$key] = $row;
						}
					}
				} else {
					$uc_id = $db_merchants_category->where(array('cat_id' => $row['cat_id'], 'user_id' => $ru_id))->get_field('uc_id');
					if ($admin_type == 0) {
						if ($uc_id > 0) {
							$arr[$key] = $row;
						}
					}
				}
			}
		}
		return $arr;
	} else {
		return $options;
	}
}

function get_category_child_tree($shopMain_category){
	$db_category = RC_Model::model('goods/category_model');

	$category = explode('-',$shopMain_category);

	for ($i=0; $i<count($category); $i++) {
		$category[$i] = explode(':', $category[$i]);

		$twoChild = explode(',', $category[$i][1]);
		for ($j=0; $j<count($twoChild); $j++) {
			$threeChild = $db_category->field('cat_id, cat_name')->where(array('parent_id'=>$twoChild[$j]))->select();
			$category[$i]['three_' . $twoChild[$j]] = get_category_three_child($threeChild);
			$category[$i]['three'] .= $category[$i][0] .','. $category[$i][1] .','. $category[$i]['three_' . $twoChild[$j]]['threeChild'] . ',';
		}
		$category[$i]['three'] = substr($category[$i]['three'], 0, -1);
	}
	$category = get_link_cat_id($category);
	$category = $category['all_cat'];
	return $category;
}

function get_category_three_child($threeChild){

	for ($i=0; $i<count($threeChild); $i++) {
		if (!empty($threeChild[$i]['cat_id'])) {
			$threeChild['threeChild'] .= $threeChild[$i]['cat_id'] . ",";
		}
	}
	$threeChild['threeChild'] = substr($threeChild['threeChild'], 0, -1);
	return $threeChild;
}

function get_link_cat_id($category) {
	for ($i=0; $i<count($category); $i++) {
		if (!empty($category[$i]['three'])) {
			$category['all_cat'] .= $category[$i]['three'] . ',';
		}
	}
	$category['all_cat'] = substr($category['all_cat'], 0, -1);
	return $category;
}

function get_class_nav($cat_id) {
	$db_category = RC_Model::model('goods/category_model');
	$res = $db_category->field('cat_id,cat_name,parent_id')->where(array('cat_id'=>$cat_id))->select();
	$arr = array();
	$arr['catId'] = '';
	if (!empty($res)) {
		foreach ($res as $key => $row) {
			$arr[$key]['cat_id'] 	= $row['cat_id'];
			$arr[$key]['cat_name'] 	= $row['cat_name'];
			$arr[$key]['parent_id'] = $row['parent_id'];

			$arr['catId'] .= $row['cat_id'] . ",";
			$arr[$key]['child'] = get_parent_child($row['cat_id']);

			if (empty($arr[$key]['child']['catId'])) {
				$arr['catId'] = $arr['catId'];
			}else{
				$arr['catId'] .= $arr[$key]['child']['catId'];
			}
		}
	}
	return $arr;
}

function get_parent_child($parent_id = 0){
	$db_category = RC_Model::model('goods/category_model');
	$res = $db_category->field('cat_id, cat_name, parent_id')->where(array('parent_id' => $parent_id))->select();
	$arr = array();
	$arr['catId'] = '';

	if (!empty($res)) {
		foreach($res as $key => $row){
			$arr[$key]['cat_id'] 	= $row['cat_id'];
			$arr[$key]['cat_name'] 	= $row['cat_name'];
			$arr[$key]['parent_id'] = $row['parent_id'];

			$arr['catId'] .= $row['cat_id'] . ",";
			$arr[$key]['child'] = get_parent_child($row['cat_id']);

			$arr['catId'] .= $arr[$key]['child']['catId'];
		}
	}
	return $arr;
}

/**
 * 查询扩展分类商品id
 *
 *@param int cat_id
 *
 *@return int extentd_count
 * by guan
 */
function get_goodsCat_num($cat_id, $goods_ids=array(), $ruCat = array()) {
	$db_goods_cat_viewmodel = RC_Model::model('goods/goods_cat_viewmodel');
	$cat_goods = $db_goods_cat_viewmodel->join('goods')->where(array_merge(array('g.is_delete'=>0, 'gc.cat_id' => $cat_id), $ruCat))->select();

	if (!empty($cat_goods)) {
		foreach($cat_goods as $key => $val) {
			if (!empty($val['goods_id'])) {
				if(in_array($val['goods_id'], $goods_ids)) {
					unset($cat_goods[$key]);
				}
			}
		}
	}
	return count($cat_goods);
}

function get_fine_store_category($options, $web_type, $array_type = 0, $ru_id){
	$cat_array = array();
	if ($web_type == 'admin' || $web_type == 'goodsInfo') {
		$db = RC_Model::model('seller/merchants_category_viewmodel');
		$store_cat = $db->join(null)->field('cat_id, user_id')->select();

		if (!empty($store_cat)) {
			foreach($store_cat as $row){
				$cat_array[$row['cat_id']]['cat_id'] = $row['cat_id'];
				$cat_array[$row['cat_id']]['user_id'] = $row['user_id'];
			}
		}
	}
	if ($web_type == 'admin') {
		if ($cat_array) {
			if ($array_type == 0) {
				$options = array_diff_key($options, $cat_array);
			} else {
				$options = array_intersect_key($options, $cat_array);
			}
		}
		return $options;
	} elseif ($web_type == 'goodsInfo' && $ru_id == 0){
		$options = array_diff_key($options, $cat_array);
		return $options;
	} else {
		return $options;
	}
}

/**
 * 获得指定分类下的子分类的数组,商家店铺分类
 *
 * @access  public
 * @param   int     $cat_id     分类的ID
 * @param   int     $selected   当前选中分类的ID
 * @param   boolean $re_type    返回的类型: 值为真时返回下拉列表,否则返回数组
 * @param   int     $level      限定返回的级数。为0时返回所有级数
 * @param   int     $is_show_all 如果为true显示所有分类，如果为false隐藏不可见分类。
 * @return  mix
 */
function goods_admin_store_cat_list($cat_info) {
	$arr = array();
	if ($cat_info) {
		foreach ($cat_info as $key => $row) {
			if ($row['level'] > 2) {
				$arr[$key] = $row;
			}
		}

		$arr = get_admin_goods_cat_list_child($arr);
		foreach ($arr as $key=>$row) {
			$arr[$key] = $row;
			if ($row['child_array']) {
				$arr[$key]['child_array'] = array_values($row['child_array']);
			}
		}
	}
	return $arr;
}

function get_admin_goods_cat_list_child($arr){
	$arr = array_values($arr);

	$newArr = array();
	for ($i=0; $i<count($arr); $i++) {
		if ($arr[$i]['level'] == 3) {
			$newArr[$i] = $arr[$i];
			$newArr[$i]['level'] = 0;
		}
	}
	$newArr = array_values($newArr);

	for ($i=0; $i<count($newArr); $i++) {
		for ($j=0; $j<count($arr); $j++) {
			if ($arr[$j]['level'] == 4) {
				if ($newArr[$i]['cat_id'] == $arr[$j]['parent_id']) {
					$newArr[$i]['child_array'][$j] = $arr[$j];
					$newArr[$i]['child_array'][$j]['level'] = 1;
				}
			}
		}
	}
	return $newArr;
}

//添加类目证件标题
function get_documentTitle_insert_update($dt_list, $cat_id, $dt_id = array()) {
	for ($i=0; $i<count($dt_list); $i++) {
		$dt_list[$i] = !empty($dt_list[$i]) ? trim($dt_list[$i]) : '';
		if (!empty($dt_id[$i])) {
			$catId = RC_DB::table('merchants_documenttitle')->where('dt_id', $dt_id[$i])->pluck('cat_id');
		} else {
			$catId = 0;
		}
		if (!empty($dt_list[$i])) {
			$parent = array(
					'cat_id' 	=> $cat_id,
					'dt_title' 	=> $dt_list[$i]
			);
			if ($catId > 0) {
				RC_DB::table('merchants_documenttitle')->where('dt_id', $dt_id[$i])->update($parent);
			} else {
				$id[] = RC_DB::table('merchants_documenttitle')->insertGetId($parent);
			}
				
		} else {
			if ($catId > 0) {
				//删除二级类目表数据
				RC_DB::table('merchants_documenttitle')->where('dt_id', $dt_id[$i])->delete();
			}
		}
	}
	$list = !empty($id) ? array_merge($dt_id, $id) : $dt_id;
	$dt_id_list = RC_DB::table('merchants_documenttitle')->where('cat_id', $cat_id)->lists('dt_id');

	$arr = array();
	if (!empty($dt_id_list)) {
		foreach ($dt_id_list as $v) {
			if (!in_array($v, $list)) {
				$arr[] = $v;
			}
		}
		if (!empty($arr)) {
			RC_DB::table('merchants_documenttitle')->whereIn('dt_id', $arr)->delete();
		}
	}
}

/**
 * 查询仓库列表
 */
function get_warehouse_goods_list($goods_id = 0) {
	$db_warehouse_goods = RC_Model::model('goods/warehouser_goods_viewmodel');
	$rs = $db_warehouse_goods->field('wg.w_id, wg.region_id, wg.region_number, wg.warehouse_price, wg.warehouse_promote_price, rw.region_name')->where(array('goods_id' =>$goods_id))->select();
	return $rs;
}

/**
 * 查询地区仓库列表
 */
function get_warehouse_area_goods_list($goods_id = 0) {
	$db_area_goods = RC_Model::model('goods/warehouse_area_goods_viewmodel');
	$db_region = RC_Model::model('goods/region_warehouose_model');

	$data = $db_region->where(array('parent_id' => 0))->select();
	foreach ($data as $key => $val){
		$arr[$val['region_id']] = $val['region_name'];
	}
	$field = 'wa.a_id, wa.region_id, wa.region_number, wa.region_price, wa.region_promote_price, rw.region_name, rw.parent_id';
	$rs = $db_area_goods->field($field)->where(array('wa.goods_id' => $goods_id))->select();
	if (!empty($rs)) {
		foreach ($rs as $key => $val){
			$rs[$key][ware_name] = $arr[$val['parent_id']];
			$rs[$key][warehouse] = $val['parent_id'];
		}
	}
	return $rs;
}

/**
 * 获得商品的属性和规格
 *
 * @access public
 * @param integer $goods_id
 * @return array
 */
function warehouse_get_goods_properties($goods_id) {
	$db_good_type = RC_Model::model('goods/goods_type_viewmodel');
	$db_good_attr = RC_Model::model('goods/goods_attr_viewmodel');
	$db_goods = RC_Model::model('goods/goods_model');
	/* 对属性进行重新排序和分组 */

	$db_good_type->view = array (
		'goods' => array (
			'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
			'alias' => 'g',
			'field' => 'attr_group',
			'on' 	=> 'gt.cat_id = g.goods_type'
		)
	);

	$grp = $db_good_type->find ( array (
			'g.goods_id' => $goods_id
	) );
	$grp = $grp ['attr_group'];
	if (! empty ( $grp )) {
		$groups = explode ( "\n", strtr ( $grp, "\r", '' ) );
	}

	/* 获得商品的规格 */
	$db_good_attr->view = array (
		'attribute' => array (
			'type'     => Component_Model_View::TYPE_LEFT_JOIN,
			'alias'    => 'a',
			'field'    => 'a.attr_id, a.attr_name, a.attr_group, a.is_linked, a.attr_type, ga.goods_attr_id, ga.attr_value, ga.attr_price',
			'on'       => 'a.attr_id = ga.attr_id'
		)
	);

	$res = $db_good_attr->where(array('ga.goods_id' => $goods_id))->order(array('a.sort_order' => 'asc','ga.attr_price' => 'asc','ga.goods_attr_id' => 'asc'))->select();
	$arr ['pro'] = array (); // 属性
	$arr ['spe'] = array (); // 规格
	$arr ['lnk'] = array (); // 关联的属性

	if (! empty ( $res )) {
		foreach ( $res as $row ) {
			$row ['attr_value'] = str_replace ( "\n", '<br />', $row ['attr_value'] );

			if ($row ['attr_type'] == 0) {
				$group = (isset ( $groups [$row ['attr_group']] )) ? $groups [$row ['attr_group']] : RC_Lang::get('goods::goods.goods_attr');

				$arr ['pro'] [$group] [$row ['attr_id']] ['name'] = $row ['attr_name'];
				$arr ['pro'] [$group] [$row ['attr_id']] ['value'] = $row ['attr_value'];
			} else {
				$arr ['spe'] [$row ['attr_id']] ['attr_type'] = $row ['attr_type'];
				$arr ['spe'] [$row ['attr_id']] ['name'] = $row ['attr_name'];
				$arr ['spe'] [$row ['attr_id']] ['values'] [] = array (
						'label' => $row ['attr_value'],
						'price' => $row ['attr_price'],
						'format_price' => price_format ( abs ( $row ['attr_price'] ), false ),
						'id' => $row ['goods_attr_id']
				);
			}

			if ($row ['is_linked'] == 1) {
				/* 如果该属性需要关联，先保存下来 */
				$arr ['lnk'] [$row ['attr_id']] ['name'] = $row ['attr_name'];
				$arr ['lnk'] [$row ['attr_id']] ['value'] = $row ['attr_value'];
			}
		}
	}
	return $arr;
}

/*------------------------------------------------------ */
/*-- TODO API和商品使用到的方法---------------------------------*/
/*------------------------------------------------------ */
/**
 * 获得分类下的商品
 *
 * @access  public
 * @param   string  $children
 * @return  array
 */
function category_get_goods($children, $brand, $min, $max, $ext, $size, $page, $sort, $order) {
	/* 获得商品列表 */
	$dbview = RC_Model::model('goods/goods_member_viewmodel');
	$display = '';
	$where = array(
			'g.is_on_sale' => 1,
			'g.is_alone_sale' => 1,
			'g.is_delete' => 0,
			"(".$children ." OR ".get_extension_goods($children).")",
	);
	if(ecjia::config('review_goods') == 1){
		$where['g.review_status'] = array('gt' => 2);
	}
	if ($brand > 0) {
		$where['g.brand_id'] = $brand;
	}
	if ($min > 0) {
		$where[] = "g.shop_price >= $min";
	}
	if ($max > 0) {
		$where[] = "g.shop_price <= $max ";
	}
	if (!empty($ext)) {
		array_push($where, $ext);
	}
	$limit = ($page - 1) * $size;
	/* 获得商品列表 */
	$data = $dbview->join('member_price')->where($where)->order(array($sort => $order))->limit(($page - 1) * $size, $size)->select();

	$arr = array();
	if (! empty($data)) {
		foreach ($data as $row) {
			if ($row['promote_price'] > 0) {
				$promote_price = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
			} else {
				$promote_price = 0;
			}
			/* 处理商品水印图片 */
			$watermark_img = '';
			if ($promote_price != 0) {
				$watermark_img = "watermark_promote_small";
			} elseif ($row['is_new'] != 0) {
				$watermark_img = "watermark_new_small";
			} elseif ($row['is_best'] != 0) {
				$watermark_img = "watermark_best_small";
			} elseif ($row['is_hot'] != 0) {
				$watermark_img = 'watermark_hot_small';
			}

			if ($watermark_img != '') {
				$arr[$row['goods_id']]['watermark_img'] = $watermark_img;
			}

			$arr[$row['goods_id']]['goods_id'] = $row['goods_id'];
			if ($display == 'grid') {
				$arr[$row['goods_id']]['goods_name'] = ecjia::config('goods_name_length') > 0 ? RC_String::sub_str($row['goods_name'], ecjia::config('goods_name_length')) : $row['goods_name'];
			} else {
				$arr[$row['goods_id']]['goods_name'] = $row['goods_name'];
			}
			$arr[$row['goods_id']]['name'] = $row['goods_name'];
			$arr[$row['goods_id']]['goods_brief'] = $row['goods_brief'];
			$arr[$row['goods_id']]['goods_style_name'] = add_style($row['goods_name'], $row['goods_name_style']);
			$arr[$row['goods_id']]['market_price'] = price_format($row['market_price']);
			$arr[$row['goods_id']]['shop_price'] = price_format($row['shop_price']);
			$arr[$row['goods_id']]['type'] = $row['goods_type'];
			$arr[$row['goods_id']]['promote_price'] = ($promote_price > 0) ? price_format($promote_price) : '';
			$arr[$row['goods_id']]['goods_thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'], true);
			$arr[$row['goods_id']]['original_img'] = get_image_path($row['goods_id'], $row['original_img'], true);
			$arr[$row['goods_id']]['goods_img'] = get_image_path($row['goods_id'], $row['goods_img']);
			$arr[$row['goods_id']]['url'] = build_uri('goods', array('gid' => $row['goods_id']), $row['goods_name']);
				
			/* 增加返回原始未格式价格  will.chen*/
			$arr[$row['goods_id']]['unformatted_shop_price'] = $row['shop_price'];
			$arr[$row['goods_id']]['unformatted_promote_price'] = $promote_price;
		}
	}
	return $arr;
}

/**
 * 获得某个分类下
 *
 * @access public
 * @param int $cat
 * @return array
 */
function get_brands($cat = 0, $app = 'brand') {
	$db = RC_Model::model ('goods/brand_viewmodel');
	$children[] = ($cat > 0) ? get_children ( $cat ) : '';
	$db->view = array (
		'goods' => array(
			'type'  => Component_Model_View::TYPE_LEFT_JOIN,
			'alias' => 'g',
			'field' => "b.brand_id, b.brand_name, b.brand_logo, b.brand_desc, COUNT(*) AS goods_num, IF(b.brand_logo > '', '1', '0') AS tag ",
			'on'   	=> 'g.brand_id = b.brand_id'
		),
	);
	$where['is_show'] = 1;
	$where['g.is_on_sale'] = 1;
	$where['g.is_alone_sale'] = 1;
	$where['g.is_delete'] = 0;
	array_merge($where,$children);
	$row = $db->join('goods')->where($where)->group('b.brand_id')->having('goods_num > 0')->order(array('tag'=>'desc','b.sort_order'=>'asc'))->limit(3)->select();

	if (! empty ( $row )) {
		foreach ( $row as $key => $val ) {
			$row [$key] ['url'] = build_uri ( $app, array (
					'cid' => $cat,
					'bid' => $val ['brand_id']
			), $val ['brand_name'] );
			$row [$key] ['brand_desc'] = htmlspecialchars ( $val ['brand_desc'], ENT_QUOTES );
		}
	}
	return $row;
}

/**
 * 获取指定 id snatch 活动的结果
 *
 * @access public
 * @param int $id
 *        	snatch_id
 *
 * @return array array(user_name, bie_price, bid_time, num)
 *         num通常为1，如果为2表示有2个用户取到最小值，但结果只返回最早出价用户。
 */
function get_snatch_result($id) {
	// 加载数据模型
	$dbview = RC_Model::model ('snatch/sys_snatch_log_viewmodel');
	$db_goods_activity = RC_Model::model ('goods/goods_activity_model');
	$db_order_info = RC_Model::model('orders/order_info_model');

	$rec = $dbview->join('users')->group('lg.bid_price')->order(array('num' => 'asc','lg.bid_price' => 'asc','lg.bid_time' => 'asc'))->find(array('lg.snatch_id' => $id));
	if ($rec) {
		$rec ['bid_time'] = RC_Time::local_date (ecjia::config('time_format'), $rec ['bid_time'] );
		$rec ['formated_bid_price'] = price_format ( $rec ['bid_price'], false );
		/* 活动信息 */
		$row = $db_goods_activity->where(array('act_id' => $id, 'act_type' => GAT_SNATCH))->get_field('ext_info');
		$info = unserialize ( $row ['ext_info'] );

		if (! empty ( $info ['max_price'] )) {
			$rec ['buy_price'] = ($rec ['bid_price'] > $info ['max_price']) ? $info ['max_price'] : $rec ['bid_price'];
		} else {
			$rec ['buy_price'] = $rec ['bid_price'];
		}

		/* 检查订单 */
		$rec ['order_count'] = $db_order_info->in(array('order_status' => array(OS_CONFIRMED,OS_UNCONFIRMED)))->where(array('extension_code' => snatch, 'extension_id' => $id))->count();
	}
	return $rec;
}

/**
 * 所有的促销活动信息
 *
 * @access public
 * @return array
 */
function get_promotion_info($goods_id = '') {
	$db_goods_activity = RC_Model::model('goods/goods_activity_model');
	$db_goods = RC_Model::model('goods/goods_model');

	$snatch = array ();
	$group = array ();
	$auction = array ();
	$package = array ();
	$favourable = array ();

	$gmtime = RC_Time::gmtime ();

	$where = "is_finished=0 AND start_time <= " . $gmtime . " AND end_time >= " . $gmtime;
	if (! empty ( $goods_id )) {
		$where .= " AND goods_id = '$goods_id'";
	}

	$res = $db_goods_activity->field('act_id, act_name, act_type, start_time, end_time')->where($where)->select();

	if (!empty($res)) {
		foreach ($res as $data) {
			switch ($data ['act_type']) {
				case GAT_SNATCH : // 夺宝奇兵
					$snatch [$data ['act_id']] ['act_name'] = $data ['act_name'];
					$snatch [$data ['act_id']] ['url'] = build_uri ('snatch', array (
							'sid' => $data ['act_id']
					) );
					$snatch [$data ['act_id']] ['time'] = sprintf(RC_Lang::get('goods::goods.promotion_time'), RC_Time::local_date ( 'Y-m-d', $data ['start_time'] ), RC_Time::local_date ( 'Y-m-d', $data ['end_time'] ) );
					$snatch [$data ['act_id']] ['sort'] = $data ['start_time'];
					$snatch [$data ['act_id']] ['type'] = 'snatch';
					break;

				case GAT_GROUP_BUY : // 团购
					$group [$data ['act_id']] ['act_name'] = $data ['act_name'];
					$group [$data ['act_id']] ['url'] = build_uri ( 'group_buy', array (
							'gbid' => $data ['act_id']
					) );
					$group [$data ['act_id']] ['time'] = sprintf ( RC_Lang::get('goods::goods.promotion_time'), RC_Time::local_date ( 'Y-m-d', $data ['start_time'] ), RC_Time::local_date ( 'Y-m-d', $data ['end_time'] ) );
					$group [$data ['act_id']] ['sort'] = $data ['start_time'];
					$group [$data ['act_id']] ['type'] = 'group_buy';
					break;

				case GAT_AUCTION : // 拍卖
					$auction [$data ['act_id']] ['act_name'] = $data ['act_name'];
					$auction [$data ['act_id']] ['url'] = build_uri ( 'auction', array (
							'auid' => $data ['act_id']
					) );
					$auction [$data ['act_id']] ['time'] = sprintf ( RC_Lang::get('goods::goods.promotion_time'), RC_Time::local_date ( 'Y-m-d', $data ['start_time'] ), RC_Time::local_date ( 'Y-m-d', $data ['end_time'] ) );
					$auction [$data ['act_id']] ['sort'] = $data ['start_time'];
					$auction [$data ['act_id']] ['type'] = 'auction';
					break;

				case GAT_PACKAGE : // 礼包
					$package [$data ['act_id']] ['act_name'] = $data ['act_name'];
					$package [$data ['act_id']] ['url'] = 'package.php#' . $data ['act_id'];
					$package [$data ['act_id']] ['time'] = sprintf ( RC_Lang::get('goods::goods.promotion_time'), RC_Time::local_date ( 'Y-m-d', $data ['start_time'] ), RC_Time::local_date ( 'Y-m-d', $data ['end_time'] ) );
					$package [$data ['act_id']] ['sort'] = $data ['start_time'];
					$package [$data ['act_id']] ['type'] = 'package';
					break;
			}
		}
	}
	$user_rank = ',' . $_SESSION ['user_rank'] . ',';
	$favourable = array ();

	$where = " start_time <= '$gmtime' AND end_time >= '$gmtime'";
	if (! empty ( $goods_id )) {

		$where .= " AND CONCAT(',', user_rank, ',') LIKE '%" . $user_rank . "%'";
	}

	if (empty ( $goods_id )) {
		if (!empty($res)) {
			foreach ( $res as $rows ) {
				$favourable [$rows ['act_id']] ['act_name'] = $rows ['act_name'];
				$favourable [$rows ['act_id']] ['url'] = 'activity.php';
				$favourable [$rows ['act_id']] ['time'] = sprintf ( RC_Lang::get('goods::goods.promotion_time'), RC_Time::local_date ( 'Y-m-d', $rows ['start_time'] ), RC_Time::local_date ( 'Y-m-d', $rows ['end_time'] ) );
				$favourable [$rows ['act_id']] ['sort'] = $rows ['start_time'];
				$favourable [$rows ['act_id']] ['type'] = 'favourable';
			}
		}
	} else {
		$row = $db_goods->field('cat_id, brand_id')->find(array('goods_id' => $goods_id));
		$category_id = $row ['cat_id'];
		$brand_id = $row ['brand_id'];

		foreach ( $res as $rows ) {
			if ($rows ['act_range'] == FAR_ALL) {
				$favourable [$rows ['act_id']] ['act_name'] = $rows ['act_name'];
				$favourable [$rows ['act_id']] ['url'] = 'activity.php';
				$favourable [$rows ['act_id']] ['time'] = sprintf ( RC_Lang::get('goods::goods.promotion_time'), RC_Time::local_date ( 'Y-m-d', $rows ['start_time'] ), RC_Time::local_date ( 'Y-m-d', $rows ['end_time'] ) );
				$favourable [$rows ['act_id']] ['sort'] = $rows ['start_time'];
				$favourable [$rows ['act_id']] ['type'] = 'favourable';
			} elseif ($rows ['act_range'] == FAR_CATEGORY) {
				/* 找出分类id的子分类id */
				$id_list = array ();
				$raw_id_list = explode ( ',', $rows ['act_range_ext'] );
				foreach ( $raw_id_list as $id ) {
					$id_list = array_merge ( $id_list, array_keys ( cat_list ( $id, 0, false ) ) );
				}
				$ids = join ( ',', array_unique ( $id_list ) );

				if (strpos ( ',' . $ids . ',', ',' . $category_id . ',' ) !== false) {
					$favourable [$rows ['act_id']] ['act_name'] = $rows ['act_name'];
					$favourable [$rows ['act_id']] ['url'] = 'activity.php';
					$favourable [$rows ['act_id']] ['time'] = sprintf ( RC_Lang::get('goods::goods.promotion_time'), RC_Time::local_date ( 'Y-m-d', $rows ['start_time'] ), RC_Time::local_date ( 'Y-m-d', $rows ['end_time'] ) );
					$favourable [$rows ['act_id']] ['sort'] = $rows ['start_time'];
					$favourable [$rows ['act_id']] ['type'] = 'favourable';
				}
			} elseif ($rows ['act_range'] == FAR_BRAND) {
				if (strpos ( ',' . $rows ['act_range_ext'] . ',', ',' . $brand_id . ',' ) !== false) {
					$favourable [$rows ['act_id']] ['act_name'] = $rows ['act_name'];
					$favourable [$rows ['act_id']] ['url'] = 'activity.php';
					$favourable [$rows ['act_id']] ['time'] = sprintf ( RC_Lang::get('goods::goods.promotion_time'), RC_Time::local_date ( 'Y-m-d', $rows ['start_time'] ), RC_Time::local_date ( 'Y-m-d', $rows ['end_time'] ) );
					$favourable [$rows ['act_id']] ['sort'] = $rows ['start_time'];
					$favourable [$rows ['act_id']] ['type'] = 'favourable';
				}
			} elseif ($rows ['act_range'] == FAR_GOODS) {
				if (strpos ( ',' . $rows ['act_range_ext'] . ',', ',' . $goods_id . ',' ) !== false) {
					$favourable [$rows ['act_id']] ['act_name'] = $rows ['act_name'];
					$favourable [$rows ['act_id']] ['url'] = 'activity.php';
					$favourable [$rows ['act_id']] ['time'] = sprintf ( RC_Lang::get('goods::goods.promotion_time'), RC_Time::local_date ( 'Y-m-d', $rows ['start_time'] ), RC_Time::local_date ( 'Y-m-d', $rows ['end_time'] ) );
					$favourable [$rows ['act_id']] ['sort'] = $rows ['start_time'];
					$favourable [$rows ['act_id']] ['type'] = 'favourable';
				}
			}
		}
	}

	$sort_time = array ();
	$arr = array_merge ( $snatch, $group, $auction, $package, $favourable );
	foreach ( $arr as $key => $value ) {
		$sort_time [] = $value ['sort'];
	}
	array_multisort ( $sort_time, SORT_NUMERIC, SORT_DESC, $arr );

	return $arr;
}

/**
 * 页面上调用的js文件
 *
 * @access public
 * @param string $files
 * @return void
 */
function smarty_insert_scripts($args) {
	static $scripts = array ();

	$arr = explode ( ',', str_replace ( ' ', '', $args ['files'] ) );

	$str = '';
	foreach ( $arr as $val ) {
		if (in_array ( $val, $scripts ) == false) {
			$scripts [] = $val;
			if ($val {0} == '.') {
				$str .= '<script type="text/javascript" src="' . $val . '"></script>';
			} else {
				$str .= '<script type="text/javascript" src="js/' . $val . '"></script>';
			}
		}
	}
	return $str;
}

/**
 * 获取指定id package 的信息
 *
 * @access public
 * @param int $id
 *        	package_id
 *
 * @return array array(package_id, package_name, goods_id,start_time, end_time, min_price, integral)
 */
function get_package_info($id) {
	$db = RC_Model::model('goods/goods_activity_model');
	$dbview = RC_Model::model('goods/sys_package_goods_viewmodel');

	$id = is_numeric ( $id ) ? intval ( $id ) : 0;
	$now = RC_Time::gmtime ();

	$package = $db->field ( 'act_id|id,  act_name|package_name, goods_id , goods_name, start_time, end_time, act_desc, ext_info' )->find ( array ('act_id' => $id,'act_type' => GAT_PACKAGE) );
	/* 将时间转成可阅读格式 */
	if ($package ['start_time'] <= $now && $package ['end_time'] >= $now) {
		$package ['is_on_sale'] = "1";
	} else {
		$package ['is_on_sale'] = "0";
	}
	$package ['start_time'] = RC_Time::local_date ( 'Y-m-d H:i', $package ['start_time'] );
	$package ['end_time'] = RC_Time::local_date ( 'Y-m-d H:i', $package ['end_time'] );
	$row = unserialize ( $package ['ext_info'] );
	unset ( $package ['ext_info'] );
	if ($row) {
		foreach ( $row as $key => $val ) {
			$package [$key] = $val;
		}
	}

	$goods_res = $dbview->join ( array ('goods','member_price') )->where ( 'pg.package_id = ' . $id . '' )->order ( array ('pg.package_id' => 'asc','pg.goods_id' => 'asc') )->select ();

	$market_price = 0;
	$real_goods_count = 0;
	$virtual_goods_count = 0;

	foreach ( $goods_res as $key => $val ) {
		$goods_res [$key] ['goods_thumb'] = get_image_path ( $val ['goods_id'], $val ['goods_thumb'], true );
		$goods_res [$key] ['market_price_format'] = price_format ( $val ['market_price'] );
		$goods_res [$key] ['rank_price_format'] = price_format ( $val ['rank_price'] );
		$market_price += $val ['market_price'] * $val ['goods_number'];
		/* 统计实体商品和虚拟商品的个数 */
		if ($val ['is_real']) {
			$real_goods_count ++;
		} else {
			$virtual_goods_count ++;
		}
	}

	if ($real_goods_count > 0) {
		$package ['is_real'] = 1;
	} else {
		$package ['is_real'] = 0;
	}

	$package ['goods_list'] = $goods_res;
	$package ['market_package'] = $market_price;
	$package ['market_package_format'] = price_format ( $market_price );
	$package ['package_price_format'] = price_format ( $package ['package_price'] );

	return $package;
}

/**
 * 取商品的货品列表
 *
 * @param mixed $goods_id
 *        	单个商品id；多个商品id数组；以逗号分隔商品id字符串
 * @param string $conditions
 *        	sql条件
 *
 * @return array
 */
function get_good_products($goods_id, $conditions = '') {
	$db_products = RC_Model::model('goods/products_model');
	$db_goods_attr = RC_Model::model('goods/goods_attr_model');
	if (empty ( $goods_id )) {
		return array ();
	}

	switch (gettype ( $goods_id )) {
		case 'integer' :
			$_goods_id = "goods_id = '" . intval ( $goods_id ) . "'";
			break;
		case 'string' :
		case 'array' :
			$_goods_id = db_create_in ( $goods_id, 'goods_id' );
			break;
	}

	/* 取货品 */
	$result_products = $db_products->where($_goods_id . $conditions )->select();

	/* 取商品属性 */
	$result_goods_attr = $db_goods_attr->field ( 'goods_attr_id, attr_value' )->where ( $_goods_id )->select ();

	$_goods_attr = array ();
	foreach ( $result_goods_attr as $value ) {
		$_goods_attr [$value ['goods_attr_id']] = $value ['attr_value'];
	}

	/* 过滤货品 */
	foreach ( $result_products as $key => $value ) {
		$goods_attr_array = explode ( '|', $value ['goods_attr'] );
		if (is_array ( $goods_attr_array )) {
			$goods_attr = array ();
			foreach ( $goods_attr_array as $_attr ) {
				$goods_attr [] = $_goods_attr [$_attr];
			}
			$goods_attr_str = implode ( '，', $goods_attr );
		}

		$result_products [$key] ['goods_attr_str'] = $goods_attr_str;
	}

	return $result_products;
}
/**
 * 取商品的下拉框Select列表
 *
 * @param int $goods_id
 *        	商品id
 *
 * @return array
 */
function get_good_products_select($goods_id) {
	$return_array = array ();
	$products = get_good_products ( $goods_id );
	if (empty ( $products )) {
		return $return_array;
	}
	foreach ( $products as $value ) {
		$return_array [$value ['product_id']] = $value ['goods_attr_str'];
	}

	return $return_array;
}

/**
 * 取商品的规格列表
 *
 * @param int $goods_id
 *        	商品id
 * @param string $conditions
 *        	sql条件
 *
 * @return array
 */
function get_specifications_list($goods_id, $conditions = '') {
	// 加载数据库
	$dbview = RC_Model::model('goods/sys_goods_attribute_viewmodel');
	$result = $dbview->join ('attribute')->where('ga.goods_id = ' . $goods_id . '' . $conditions )->select();
	$return_array = array ();
	foreach ( $result as $value ) {
		$return_array [$value ['goods_attr_id']] = $value;
	}
	return $return_array;
}

/**
 * 保存某商品的关联商品
 *
 * @param int $goods_id
 * @return void
 */
function handle_link_goods($goods_id) {
	$db = RC_Model::model('goods/link_goods_model');
	$data1 = array(
			'goods_id' => $goods_id
	);
	$data2 = array(
			'link_goods_id' => $goods_id
	);
	$db->where(array('goods_id' => 0, 'admin_id' => $_SESSION [admin_id]))->update($data1);
	$db->where(array('link_goods_id' => 0, 'admin_id' => $_SESSION [admin_id]))->update($data2);
}

/**
 * 保存某商品的配件
 *
 * @param int $goods_id
 * @return void
 */
function handle_group_goods($goods_id) {
	$db = RC_Model::model('goods/group_goods_model');
	$data = array('parent_id' => $goods_id);
	$db->where(array('parent_id' => 0, 'admin_id' => $_SESSION [admin_id]))->update($data);
}

/**
 * 保存某商品的关联文章
 *
 * @param int $goods_id
 * @return void
 */
function handle_goods_article($goods_id) {
	$db = RC_Model::model('goods/goods_article_model');
	$data = array(
			'goods_id' => $goods_id
	);
	$db->where(array('goods_id' => 0, 'admin_id' => $_SESSION [admin_id]))->update($data);
}

/**
 * 检测商品是否有货品
 *
 * @access public
 * @param
 *            s integer $goods_id 商品id
 * @param
 *            s string $conditions sql条件，AND语句开头
 * @return string number -1，错误；1，存在；0，不存在
 */
function check_goods_product_exist($goods_id, $conditions = '') {
	$db = RC_Model::model('goods/products_model');
	if (empty ($goods_id)) {
		return -1;
	}
	$result = $db->field('goods_id')->find('goods_id = ' . $goods_id . $conditions . '');
	if (empty($result)) {
		return 0;
	}
	return 1;
}

/**
 * 检查单个商品是否存在规格
 *
 * @param int $goods_id
 *            商品id
 * @return bool true，存在；false，不存在
 */
function check_goods_specifications_exist($goods_id) {
	$dbview = RC_Model::model('goods/attribute_goods_viewmodel');
	$goods_id = intval($goods_id);
	$dbview->view = array(
		'goods' => array(
			'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
			'alias'	=> 'g',
			'on' 	=> 'a.cat_id = g.goods_type'
		)
	);
	$count = $dbview->where(array('g.goods_id' => $goods_id))->count('a.attr_id');
	if ($count > 0) {
		return true; // 存在
	} else {
		return false; // 不存在
	}
}

// ======================================== 未使用的方法整理 end ======================================== //
