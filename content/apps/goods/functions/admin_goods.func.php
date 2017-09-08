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
 * 商品相关函数库
 */

/**
 * 商品推荐usort用自定义排序行数
 */
function goods_sort($goods_a, $goods_b) {
	if ($goods_a ['sort_order'] == $goods_b ['sort_order']) {
		return 0;
	}
	return ($goods_a ['sort_order'] < $goods_b ['sort_order']) ? - 1 : 1;
}

/**
 * 获得指定分类同级的所有分类以及该分类下的子分类
 *
 * @access public
 * @param integer $cat_id
 *        	分类编号
 * @return array
 */
function get_categories_tree($cat_id = 0) {
	$db_category = RC_Model::model('goods/category_model');

	if ($cat_id > 0) {
		$parent = $db_category->where(array('cat_id' => $cat_id))->get_field('parent_id');
		$parent_id = $parent ['parent_id'];
	} else {
		$parent_id = 0;
	}

	/**
	 * 判断当前分类中全是是否是底级分类，
	 * 如果是取出底级分类上级分类，
	 * 如果不是取当前分类及其下的子分类
	 */

	$count = $db_category->where(array('parent_id' => $parent_id,'is_show' => 1))->count();
	if ($count || $parent_id == 0) {
		/* 获取当前分类及其子分类 */
		$res = $db_category->field('cat_id, cat_name, parent_id, style, is_show')->where(array('parent_id' => $parent_id,'is_show'   => 1))->order( array ('sort_order'=> 'asc','cat_id'=> 'asc'))->select();
		foreach ( $res as $row ) {
			if ($row ['is_show']) {
				$cat_arr [$row ['cat_id']] ['id'] = $row ['cat_id'];
				$cat_arr [$row ['cat_id']] ['name'] = $row ['cat_name'];
				$cat_arr [$row ['cat_id']] ['img'] = empty($row['style']) ? '' : RC_Upload::upload_url(). '/' .$row['style'];
				$cat_arr [$row ['cat_id']] ['url'] = build_uri ( 'category', array ('cid' => $row ['cat_id']), $row ['cat_name'] );

				if (isset ( $row ['cat_id'] ) != NULL) {
					$cat_arr [$row ['cat_id']] ['cat_id'] = get_child_tree ( $row ['cat_id'] );
				}
			}
		}
	}
	if (isset ( $cat_arr )) {
		return $cat_arr;
	}
}

function get_child_tree($tree_id = 0) {
	$db_category = RC_Model::model('goods/category_model');
	$three_arr = array ();
	$count = $db_category->where(array('parent_id' => $tree_id, 'is_show' => 1))->count();
	if ($count > 0 || $tree_id == 0) {

		$res = $db_category->field('cat_id, cat_name ,parent_id, style, is_show')->where(array('parent_id' => $tree_id, 'is_show' => 1))->order(array('sort_order' => 'asc', 'cat_id' => 'asc'))->select();

		if (!empty($res)) {
			foreach ( $res as $row ) {
				if ($row ['is_show'])
					$three_arr [$row ['cat_id']] ['id'] = $row ['cat_id'];
				$three_arr [$row ['cat_id']] ['name'] = $row ['cat_name'];
				$three_arr [$row ['cat_id']] ['url'] = build_uri ( 'category', array ('cid' => $row ['cat_id'] ), $row ['cat_name'] );
				if (isset ( $row ['cat_id'] ) != NULL) {
					$three_arr [$row ['cat_id']] ['cat_id'] = get_child_tree ( $row ['cat_id'] );
				}
				$three_arr [$row['cat_id']]['img'] = empty($row['style']) ? '' : RC_Upload::upload_url(). '/' .$row['style'];
			}
		}
	}
	return $three_arr;
}

/**
 * 调用当前分类的销售排行榜
 *
 * @access public
 * @param string $cats
 *        	查询的分类
 * @return array
 */
function get_top10($cats = '') {
	$db_goods = RC_Model::model('goods/goods_model');
	$cats = get_children ( $cats );
	$where = ! empty ( $cats ) ? "AND ($cats OR " . get_extension_goods ( $cats ) . ") " : '';
	/* 排行统计的时间 */
	switch (ecjia::config ( 'top10_time' )) {
		case 1 : // 一年
		$top10_time = "AND o.order_sn >= '" . date( 'Ymd', RC_Time::gmtime () - 365 * 86400 ) . "'";
		break;
		case 2 : // 半年
		$top10_time = "AND o.order_sn >= '" . date( 'Ymd', RC_Time::gmtime () - 180 * 86400 ) . "'";
		break;
		case 3 : // 三个月
		$top10_time = "AND o.order_sn >= '" . date( 'Ymd', RC_Time::gmtime () - 90 * 86400 ) . "'";
		break;
		case 4 : // 一个月
		$top10_time = "AND o.order_sn >= '" . date( 'Ymd', RC_Time::gmtime () - 30 * 86400 ) . "'";
		break;
		default :
		$top10_time = '';
	}

	$sql = 'SELECT g.goods_id, g.goods_name, g.shop_price, g.goods_thumb, SUM(og.goods_number) as goods_number ' . 'FROM ecs_goods AS g, ' . 'ecs_order_info AS o, ' . 'ecs_order_goods AS og ' . "WHERE g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 $where $top10_time ";
	// 判断是否启用库存，库存数量是否大于0
	if (ecjia::config ( 'use_storage' ) == 1) {
		$sql .= " AND g.goods_number > 0 ";
	}
	$sql .= ' AND og.order_id = o.order_id AND og.goods_id = g.goods_id ' . "AND (o.order_status = '" . OS_CONFIRMED . "' OR o.order_status = '" . OS_SPLITED . "') " . "AND (o.pay_status = '" . PS_PAYED . "' OR o.pay_status = '" . PS_PAYING . "') " . "AND (o.shipping_status = '" . SS_SHIPPED . "' OR o.shipping_status = '" . SS_RECEIVED . "') " . 'GROUP BY g.goods_id ORDER BY goods_number DESC, g.goods_id DESC LIMIT ' . ecjia::config ( 'top_number' );
	$arr = $db_goods->query ( $sql );
	for($i = 0, $count = count ( $arr ); $i < $count; $i ++) {
		$arr [$i] ['short_name'] = ecjia::config ( 'goods_name_length' ) > 0 ? RC_String::sub_str ( $arr [$i] ['goods_name'], ecjia::config ( 'goods_name_length' ) ) : $arr [$i] ['goods_name'];
		$arr [$i] ['url'] = build_uri ( 'goods', array('gid' => $arr[$i] ['goods_id']), $arr [$i] ['goods_name'] );
		$arr [$i] ['thumb'] = get_image_path ( $arr [$i] ['goods_id'], $arr [$i] ['goods_thumb'], true );
		$arr [$i] ['price'] = price_format ( $arr [$i] ['shop_price'] );
	}

	return $arr;
}

/**
 * 调用商家当前分类的销售排行榜
 *
 * @access public
 * @param string $cats
 *        	查询的分类
 * @return array
 */
function get_merchant_top10($cats = '') {
	$db_goods = RC_Model::model('goods/goods_model');
	$cats = merchant_get_children ( $cats );
	$where = ! empty ( $cats ) ? "AND ($cats OR " . get_extension_goods ( $cats ) . ") " : '';
	/* 排行统计的时间 */
	switch (ecjia::config ( 'top10_time' )) {
		case 1 : // 一年
			$top10_time = "AND o.order_sn >= '" . date( 'Ymd', RC_Time::gmtime () - 365 * 86400 ) . "'";
			break;
		case 2 : // 半年
			$top10_time = "AND o.order_sn >= '" . date( 'Ymd', RC_Time::gmtime () - 180 * 86400 ) . "'";
			break;
		case 3 : // 三个月
			$top10_time = "AND o.order_sn >= '" . date( 'Ymd', RC_Time::gmtime () - 90 * 86400 ) . "'";
			break;
		case 4 : // 一个月
			$top10_time = "AND o.order_sn >= '" . date( 'Ymd', RC_Time::gmtime () - 30 * 86400 ) . "'";
			break;
		default :
			$top10_time = '';
	}

	$sql = 'SELECT g.goods_id, g.goods_name, g.shop_price, g.goods_thumb, SUM(og.goods_number) as goods_number ' . 'FROM ecs_goods AS g, ' . 'ecs_order_info AS o, ' . 'ecs_order_goods AS og ' . "WHERE g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 $where $top10_time ";
	// 判断是否启用库存，库存数量是否大于0
	if (ecjia::config ( 'use_storage' ) == 1) {
		$sql .= " AND g.goods_number > 0 ";
	}
	$sql .= ' AND og.order_id = o.order_id AND og.goods_id = g.goods_id ' . "AND (o.order_status = '" . OS_CONFIRMED . "' OR o.order_status = '" . OS_SPLITED . "') " . "AND (o.pay_status = '" . PS_PAYED . "' OR o.pay_status = '" . PS_PAYING . "') " . "AND (o.shipping_status = '" . SS_SHIPPED . "' OR o.shipping_status = '" . SS_RECEIVED . "') " . 'GROUP BY g.goods_id ORDER BY goods_number DESC, g.goods_id DESC LIMIT ' . ecjia::config ( 'top_number' );
	$arr = $db_goods->query ( $sql );
	for($i = 0, $count = count ( $arr ); $i < $count; $i ++) {
		$arr [$i] ['short_name'] = ecjia::config ( 'goods_name_length' ) > 0 ? RC_String::sub_str ( $arr [$i] ['goods_name'], ecjia::config ( 'goods_name_length' ) ) : $arr [$i] ['goods_name'];
		$arr [$i] ['url'] = build_uri ( 'goods', array('gid' => $arr[$i] ['goods_id']), $arr [$i] ['goods_name'] );
		$arr [$i] ['thumb'] = get_image_path ( $arr [$i] ['goods_id'], $arr [$i] ['goods_thumb'], true );
		$arr [$i] ['price'] = price_format ( $arr [$i] ['shop_price'] );
	}

	return $arr;
}

/**
 * 获得推荐商品
 *
 * @access public
 * @param string $type
 *        	推荐类型，可以是 best, new, hot
 * @return array
 */
function get_recommend_goods($type = '', $cats = '') {
	$dbview = RC_Model::model('goods/goods_auto_viewmodel');
	RC_Loader::load_app_func('global', 'goods');
	if (! in_array($type, array('best','new','hot'))) {
		return array ();
	}
	// 取不同推荐对应的商品
	static $type_goods = array ();
	if (empty ( $type_goods [$type] )) {
		// 初始化数据
		$type_goods ['best'] = array ();
		$type_goods ['new'] = array ();
		$type_goods ['hot'] = array ();
		$data = false;
		if ($data === false) {

			$dbview->view = array (
				'brand' => array (
					'type'   => Component_Model_View::TYPE_LEFT_JOIN,
					'alias'  => 'b',
					'field'  => 'g.goods_id, g.is_best, g.is_new, g.is_hot, g.is_promote, b.brand_name,g.sort_order',
					'on'     => 'b.brand_id = g.brand_id'
				)
			);

			$where = array(
				'g.is_on_sale' => 1,
				'g.is_alone_sale' => 1,
				'g.is_delete' => 0,
				'(g.is_best = 1 OR g.is_new =1 OR g.is_hot = 1)'
			);
			if (ecjia::config('review_goods')) {
				$where['g.review_status'] = array('gt' => 2);
			}
			$goods_res = $dbview->where($where)->order(array('g.sort_order' => 'asc','g.last_update' => 'desc'))->select();

			// 定义推荐,最新，热门，促销商品
			$goods_data ['best'] = array ();
			$goods_data ['new'] = array ();
			$goods_data ['hot'] = array ();
			$goods_data ['brand'] = array ();
			if (! empty ( $goods_res )) {
				foreach ( $goods_res as $data ) {
					if ($data ['is_best'] == 1) {
						$goods_data['best'][] = array (
							'goods_id' => $data ['goods_id'],
							'sort_order' => $data ['sort_order']
						);
					}
					if ($data['is_new'] == 1) {
						$goods_data ['new'] [] = array (
							'goods_id' => $data ['goods_id'],
							'sort_order' => $data ['sort_order']
						);
					}
					if ($data ['is_hot'] == 1) {
						$goods_data ['hot'] [] = array (
							'goods_id' => $data ['goods_id'],
							'sort_order' => $data ['sort_order']
						);
					}
					if ($data ['brand_name'] != '') {
						$goods_data ['brand'] [$data ['goods_id']] = $data ['brand_name'];
					}
				}
			}

		} else {
			$goods_data = $data;
		}

		$time = RC_Time::gmtime ();
		$order_type = ecjia::config ( 'recommend_order' );
		// 按推荐数量及排序取每一项推荐显示的商品 order_type可以根据后台设定进行各种条件显示
		static $type_array = array ();
		$type2lib = array (
			'best' => 'recommend_best',
			'new' => 'recommend_new',
			'hot' => 'recommend_hot'
		);
		if (empty ( $type_array )) {
			foreach ( $type2lib as $key => $data ) {
				if (! empty ( $goods_data [$key] )) {
					$num = 8;//get_library_number ( $data );
					$data_count = count ( $goods_data [$key] );
					$num = $data_count > $num ? $num : $data_count;
					if ($order_type == 0) {
						$rand_key = array_slice ( $goods_data [$key], 0, $num );
						foreach ( $rand_key as $key_data ) {
							$type_array [$key] [] = $key_data ['goods_id'];
						}
					} else {
						$rand_key = array_rand ( $goods_data [$key], $num );
						if ($num == 1) {
							$type_array [$key] [] = $goods_data [$key] [$rand_key] ['goods_id'];
						} else {
							foreach ( $rand_key as $key_data ) {
								$type_array [$key] [] = $goods_data [$key] [$key_data] ['goods_id'];
							}
						}
					}
				} else {
					$type_array [$key] = array ();
				}
			}
		}

		// 取出所有符合条件的商品数据，并将结果存入对应的推荐类型数组中
		$type_merge = array_merge ( $type_array ['new'], $type_array ['best'], $type_array ['hot'] );
		$type_merge = array_unique ( $type_merge );

		$dbview->view = array (
			'member_price' => array (
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'mp',
				'field' => "g.goods_id, g.goods_name, g.goods_name_style, g.market_price, g.shop_price AS org_price, g.promote_price,IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price,promote_start_date, promote_end_date, g.goods_brief, g.goods_thumb, g.goods_img, g.original_img, RAND() AS rnd",
				'on' 	=> 'mp.goods_id = g.goods_id AND mp.user_rank = "' . $_SESSION ['user_rank'] . '"'
			)
		);

		$result = $dbview->where("g.goods_id ".db_create_in($type_merge))->order(array('g.sort_order' => 'asc','g.last_update' => 'desc'))->select();


		if (! empty ( $result )) {
			foreach ( $result as $idx => $row ) {
				if ($row ['promote_price'] > 0) {
					$promote_price = bargain_price ( $row ['promote_price'], $row ['promote_start_date'], $row ['promote_end_date'] );
					$goods [$idx] ['promote_price'] = $promote_price > 0 ? price_format ( $promote_price ) : '';
				} else {
					$goods [$idx] ['promote_price'] = '';
				}

				$goods [$idx] ['id'] = $row ['goods_id'];
				$goods [$idx] ['name'] = $row ['goods_name'];
				$goods [$idx] ['brief'] = $row ['goods_brief'];
				$goods [$idx] ['brand_name'] = isset ( $goods_data ['brand'] [$row ['goods_id']] ) ? $goods_data ['brand'] [$row ['goods_id']] : '';
				$goods [$idx] ['goods_style_name'] = add_style ( $row ['goods_name'], $row ['goods_name_style'] );

				$goods [$idx] ['short_name'] = ecjia::config ( 'goods_name_length' ) > 0 ? RC_String::sub_str ( $row ['goods_name'], ecjia::config ( 'goods_name_length' ) ) : $row ['goods_name'];
				$goods [$idx] ['short_style_name'] = add_style ( $goods [$idx] ['short_name'], $row ['goods_name_style'] );
				$goods [$idx] ['market_price'] = price_format ( $row ['market_price'] );
				$goods [$idx] ['shop_price'] = $row ['shop_price'] > 0 ? price_format ( $row ['shop_price'] ) : __('免费');
				$goods [$idx] ['thumb'] = get_image_path ($row ['goods_id'], $row ['goods_thumb'], true);
				$goods [$idx] ['goods_img'] = get_image_path ( $row ['goods_id'], $row ['goods_img'] );
				$goods [$idx] ['original_img'] = get_image_path ( $row ['goods_id'], $row ['original_img'] );
				$goods [$idx] ['url'] = build_uri('goods', array ('gid' => $row['goods_id']), $row['goods_name']);
				if (in_array($row['goods_id'], $type_array ['best'])) {
					$type_goods ['best'] [] = $goods [$idx];
				}
				if (in_array($row['goods_id'], $type_array ['new'])) {
					$type_goods ['new'] [] = $goods [$idx];
				}
				if (in_array($row['goods_id'], $type_array ['hot'])) {
					$type_goods ['hot'] [] = $goods [$idx];
				}
			}
		}
	}
	return $type_goods [$type];
}

/**
 * 获得促销商品
 *
 * @access public
 * @return array
 */
function get_promote_goods($cats = '') {
	$dbview = RC_Model::model('goods/goods_auto_viewmodel');
	$time = RC_Time::gmtime ();
	$order_type = ecjia::config ( 'recommend_order' );

	/* 取得促销lbi的数量限制 */
	$num = get_library_number ( "recommend_promotion" );

	$order = $order_type == 0 ? array ('g.sort_order' => 'asc','g.last_update' => 'DESC') : 'rnd';
	$dbview->view = array (
		'brand' => array (
			'type' => Component_Model_View::TYPE_LEFT_JOIN,
			'alias' => 'b',
			'field' => "g.goods_id, g.goods_name, g.goods_name_style, g.market_price, g.shop_price AS org_price, g.promote_price,IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price,promote_start_date, promote_end_date, g.goods_brief, g.goods_thumb, goods_img, b.brand_name,g.is_best, g.is_new, g.is_hot, g.is_promote, RAND() AS rnd",
			'on' => 'b.brand_id = g.brand_id'
		),
		'member_price' => array (
			'type' => Component_Model_View::TYPE_LEFT_JOIN,
			'alias' => 'mp',
			'on' => 'mp.goods_id = g.goods_id AND mp.user_rank = "' . $_SESSION ['user_rank'] . '"'
		)
	);

	$result = $dbview->where(array('g.is_on_sale' => 1, 'g.is_alone_sale' => 0, 'g.is_promote' => 1, 'promote_start_date' => array('elt' => $time), 'promote_end_date' => array('egt' => $time)))->order($order)->limit($num)->select();
	$goods = array();
	if (! empty ( $result )) {
		foreach ( $result as $idx => $row ) {
			if ($row ['promote_price'] > 0) {
				$promote_price = bargain_price ( $row ['promote_price'], $row ['promote_start_date'], $row ['promote_end_date'] );
				$goods [$idx] ['promote_price'] = $promote_price > 0 ? price_format ( $promote_price ) : '';
			} else {
				$goods [$idx] ['promote_price'] = '';
			}

			$goods [$idx] ['id'] = $row ['goods_id'];
			$goods [$idx] ['name'] = $row ['goods_name'];
			$goods [$idx] ['brief'] = $row ['goods_brief'];
			$goods [$idx] ['brand_name'] = $row ['brand_name'];
			$goods [$idx] ['goods_style_name'] = add_style ( $row ['goods_name'], $row ['goods_name_style'] );
			$goods [$idx] ['short_name'] = ecjia::config ( 'goods_name_length' ) > 0 ? RC_String::sub_str ( $row ['goods_name'], ecjia::config ( 'goods_name_length' ) ) : $row ['goods_name'];
			$goods [$idx] ['short_style_name'] = add_style ( $goods [$idx] ['short_name'], $row ['goods_name_style'] );
			$goods [$idx] ['market_price'] = price_format ( $row ['market_price'] );
			$goods [$idx] ['shop_price'] = price_format ( $row ['shop_price'] );
			$goods [$idx] ['thumb'] = get_image_path ( $row ['goods_id'], $row ['goods_thumb'], true );
			$goods [$idx] ['goods_img'] = get_image_path ( $row ['goods_id'], $row ['goods_img'] );
			$goods [$idx] ['url'] = build_uri('goods', array('gid' => $row ['goods_id']), $row ['goods_name']);
		}
	}
	return $goods;
}

/**
 * 获得指定分类下的推荐商品
 *
 * @access public
 * @param string $type
 *        	推荐类型，可以是 best, new, hot, promote
 * @param string $cats
 *        	分类的ID
 * @param integer $brand
 *        	品牌的ID
 * @param integer $min
 *        	商品价格下限
 * @param integer $max
 *        	商品价格上限
 * @param string $ext
 *        	商品扩展查询
 * @return array
 */
function get_category_recommend_goods($type = '', $cats = '', $brand = 0, $min = 0, $max = 0, $ext = '') {
	$db_goods = RC_Model::model('goods/goods_model');
	$brand_where  = ($brand > 0) ? " AND g.brand_id = '$brand'" : '';
	$price_where  = ($min > 0) ? " AND g.shop_price >= $min " : '';
	$price_where .= ($max > 0) ? " AND g.shop_price <= $max " : '';

	$sql = 'SELECT g.goods_id, g.goods_name, g.goods_name_style, g.market_price, g.shop_price AS org_price, g.promote_price, ' . "IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, " . 'promote_start_date, promote_end_date, g.goods_brief, g.goods_thumb, goods_img, b.brand_name ' . 'FROM ecs_goods AS g ' . 'LEFT JOIN ecs_brand AS b ON b.brand_id = g.brand_id ' . "LEFT JOIN ecs_member_price AS mp " . "ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' " . 'WHERE g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 ' . $brand_where . $price_where . $ext;
	$num = 0;
	$type2lib = array (
		'best' 	=> 'recommend_best',
		'new' 	=> 'recommend_new',
		'hot' 	=> 'recommend_hot',
		'promote' => 'recommend_promotion'
	);
	$num = get_library_number($type2lib [$type]);
	$order_type = ecjia::config ( 'recommend_order' );

	switch ($type) {
		case 'best' :
		$sql .= ' AND is_best = 1';
		$type_where = ' AND is_best = 1';
		break;
		case 'new' :
		$sql .= ' AND is_new = 1';
		$type_where = ' AND is_new = 1';
		break;
		case 'hot' :
		$sql .= ' AND is_hot = 1';
		break;
		case 'promote' :
		$time = RC_Time::gmtime ();
		$sql .= " AND is_promote = 1 AND promote_start_date <= '$time' AND promote_end_date >= '$time'";
		break;
	}
	if (!empty($cats)) {
		$sql .= " AND (" . $cats . " OR " . get_extension_goods ( $cats ) . ")";
	}

	$sql .= ($order_type == 0) ? ' ORDER BY g.sort_order, g.last_update DESC' : ' ORDER BY RAND()';
	$sql .= " limit " . $num;
	$result = $db_goods->query ($sql);

	$idx = 0;
	$goods = array();

	if (! empty ( $result )) {
		foreach ( $result as $row ) {
			if ($row ['promote_price'] > 0) {
				$promote_price = bargain_price ( $row ['promote_price'], $row ['promote_start_date'], $row ['promote_end_date'] );
				$goods [$idx] ['promote_price'] = $promote_price > 0 ? price_format ( $promote_price ) : '';
			} else {
				$goods [$idx] ['promote_price'] = '';
			}
			$goods [$idx] ['id'] = $row ['goods_id'];
			$goods [$idx] ['name'] = $row ['goods_name'];
			$goods [$idx] ['brief'] = $row ['goods_brief'];
			$goods [$idx] ['brand_name'] = $row ['brand_name'];
			$goods [$idx] ['short_name'] = ecjia::config ( 'goods_name_length' ) > 0 ? RC_String::sub_str ( $row ['goods_name'], ecjia::config ( 'goods_name_length' ) ) : $row ['goods_name'];
			$goods [$idx] ['market_price'] = price_format ( $row ['market_price'] );
			$goods [$idx] ['shop_price'] = price_format ( $row ['shop_price'] );
			$goods [$idx] ['thumb'] = get_image_path ( $row ['goods_id'], $row ['goods_thumb'], true );
			$goods [$idx] ['goods_img'] = get_image_path ( $row ['goods_id'], $row ['goods_img'] );
			$goods [$idx] ['url'] = build_uri('goods', array('gid' => $row['goods_id']), $row['goods_name']);

			$goods [$idx] ['short_style_name'] = add_style ( $goods [$idx] ['short_name'], $row ['goods_name_style'] );
			$idx ++;
		}
	}
	return $goods;
}

/**
 * 获得商品的详细信息
 *
 * @access public
 * @param integer $goods_id
 * @return void
 */
function get_goods_info($goods_id, $warehouse_id = 0, $area_id = 0) {
	$db_goods = RC_Model::model('goods/goods_auto_viewmodel');
	RC_Loader::load_app_func('global', 'goods');
	$time = RC_Time::gmtime();

	$field = "g.*,  g.model_price, g.model_attr, ".
	    ' c.measure_unit, g.brand_id as brand_id, b.brand_logo, g.comments_number, g.sales_volume,b.brand_name AS goods_brand, m.type_money AS bonus_money, ' .
	    'IFNULL(AVG(r.comment_rank), 0) AS comment_rank, ' .
	    "IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS rank_price ";

	$db_goods->view = array (
		'category' => array(
			'type'     => Component_Model_View::TYPE_LEFT_JOIN,
			'alias'    => 'c',
			'on'       => 'g.cat_id = c.cat_id'
		),
		'brand' => array(
			'type'     => Component_Model_View::TYPE_LEFT_JOIN,
			'alias'    => 'b',
			'on'       => 'g.brand_id = b.brand_id '
		),
		'comment' => array(
			'type' => Component_Model_View::TYPE_LEFT_JOIN,
			'alias' => 'r',
			'on' => 'r.id_value = g.goods_id AND comment_type = 0 AND r.parent_id = 0 AND r.status = 1'
		),
		'bonus_type' => array(
			'type' => Component_Model_View::TYPE_LEFT_JOIN,
			'alias' => 'm',
			'on' => 'g.bonus_type_id = m.type_id AND m.send_start_date <= "' . $time . '" AND m.send_end_date >= "' . $time . '"'
		),
		'member_price'   => array(
			'type'     => Component_Model_View::TYPE_LEFT_JOIN,
			'alias'    => 'mp',
			'on'       => 'mp.goods_id = g.goods_id AND mp.user_rank = "' . $_SESSION ['user_rank'] . '"'
		)
	);

	$where = array('g.goods_id' => $goods_id/* , 'g.is_delete' => 0 */);
	
	if (!empty($_SESSION['store_id'])) {
		if (ecjia::config('review_goods')) {
			$where['g.review_status'] = array('gt' => 2);
		}
	} else {
		$where['g.review_status'] = array('gt' => 2);
	}
    $row = $db_goods->field($field)->group('g.goods_id')->find($where);

	$count = RC_DB::table('store_franchisee')->where('shop_close', '0')->where('store_id', $row['store_id'])->count();
	if(empty($count)){
		return false;
	}

	if (!empty($row)) {
	    $row['goods_id'] = $goods_id;
		/* 用户评论级别取整 */
		$row ['comment_rank'] = ceil ( $row ['comment_rank'] ) == 0 ? 5 : ceil ( $row ['comment_rank'] );
		/* 获得商品的销售价格 */
		$row ['market_price'] = $row ['market_price'];
		$row ['shop_price_formated'] = price_format ($row ['shop_price'] );

		/* 修正促销价格 */
		if ($row ['promote_price'] > 0) {
			$promote_price = bargain_price ( $row ['promote_price'], $row ['promote_start_date'], $row ['promote_end_date'] );
		} else {
			$promote_price = 0;
		}
		/* 处理商品水印图片 */
		$watermark_img = '';

		if ($promote_price != 0) {
			$watermark_img = "watermark_promote";
		} elseif ($row ['is_new'] != 0) {
			$watermark_img = "watermark_new";
		} elseif ($row ['is_best'] != 0) {
			$watermark_img = "watermark_best";
		} elseif ($row ['is_hot'] != 0) {
			$watermark_img = 'watermark_hot';
		}

		if ($watermark_img != '') {
			$row ['watermark_img'] = $watermark_img;
		}

		$row ['promote_price_org'] = $promote_price;
		$row ['promote_price'] = price_format ( $promote_price );

		/* 修正重量显示 */
		$row ['goods_weight'] = (intval ( $row ['goods_weight'] ) > 0) ? $row ['goods_weight'] . RC_Lang::get('goods::goods.kilogram') : ($row ['goods_weight'] * 1000) . RC_Lang::get('goods::goods.gram');

		/* 修正上架时间显示 */
		$row ['add_time'] = RC_Time::local_date ( ecjia::config ( 'date_format' ), $row ['add_time'] );

		/* 促销时间倒计时 */
		$time = RC_Time::gmtime ();
		if ($time >= $row ['promote_start_date'] && $time <= $row ['promote_end_date']) {
			$row ['gmt_end_time'] = $row ['promote_end_date'];
		} else {
			$row ['gmt_end_time'] = 0;
		}

		/* 是否显示商品库存数量 */
		$row ['goods_number'] = (ecjia::config ( 'use_storage' ) == 1) ? $row ['goods_number'] : '';

		/* 修正积分：转换为可使用多少积分（原来是可以使用多少钱的积分） */
		$row ['integral'] = ecjia::config ( 'integral_scale' ) ? round ( $row ['integral'] * 100 / ecjia::config ( 'integral_scale' ) ) : 0;

		/* 修正优惠券 */
		$row ['bonus_money'] = ($row ['bonus_money'] == 0) ? 0 : price_format ( $row ['bonus_money'], false );

		RC_Loader::load_app_class('goods_imageutils', 'goods', false);
		/* 修正商品图片 */
		$row ['goods_img'] = empty($row ['goods_img']) ? RC_Uri::admin_url('statics/images/nopic.png') : goods_imageutils::getAbsoluteUrl($row ['goods_img']);
		$row ['goods_thumb'] = empty($row ['goods_img']) ? RC_Uri::admin_url('statics/images/nopic.png') : goods_imageutils::getAbsoluteUrl($row ['goods_thumb']);
		$row ['original_img'] = empty($row ['goods_img']) ? RC_Uri::admin_url('statics/images/nopic.png') : goods_imageutils::getAbsoluteUrl($row ['original_img']);

		return $row;
	} else {
		return false;
	}
}

/**
 * 获得商品的属性和规格
 *
 * @access public
 * @param integer $goods_id
 * @return array
 */
function get_goods_properties($goods_id, $warehouse_id = 0, $area_id = 0) {
	$db_good_type = RC_Model::model('goods/goods_type_viewmodel');
	$db_good_attr = RC_Model::model('goods/goods_attr_viewmodel');
	/* 对属性进行重新排序和分组 */

	$db_good_type->view = array (
		'goods' => array (
			'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
			'alias' => 'g',
			'field' => 'attr_group',
			'on' 	=> 'gt.cat_id = g.goods_type'
		)
	);

	$grp = $db_good_type->find (array ('g.goods_id' => $goods_id));
	$grp = $grp['attr_group'];
	if (! empty ( $grp )) {
		$groups = explode ( "\n", strtr ( $grp, "\r", '' ) );
	}

	$field = 'a.attr_id, a.attr_name, a.attr_group, a.is_linked, a.attr_type, ga.goods_attr_id, ga.attr_value, ga.attr_price';
	/* 获得商品的规格 */
	$db_good_attr->view = array (
		'attribute' => array (
			'type'     => Component_Model_View::TYPE_LEFT_JOIN,
			'alias'    => 'a',
			'on'       => 'a.attr_id = ga.attr_id'
		)
	);

	$res = $db_good_attr->field($field)->where(array('ga.goods_id' => $goods_id))->order(array('a.sort_order' => 'asc','ga.attr_price' => 'asc','ga.goods_attr_id' => 'asc'))->select();

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
				$attr_price = $row['attr_price'];

				$arr ['spe'] [$row ['attr_id']] ['attr_type'] = $row ['attr_type'];
				$arr ['spe'] [$row ['attr_id']] ['name'] = $row ['attr_name'];
				$arr ['spe'] [$row ['attr_id']] ['value'] [] = array (
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

/**
 * 获得属性相同的商品
 *
 * @access public
 * @param array $attr
 *        	// 包含了属性名称,ID的数组
 * @return array
 */
function get_same_attribute_goods($attr) {
	$db = RC_Model::model('goods/goods_auto_viewmodel');
	$lnk = array ();
	if (!empty($attr)) {
		foreach($attr['lnk'] as $key => $val) {
			$lnk[$key]['title'] = sprintf(RC_Lang::get('goods::goods.same_attrbiute_goods'),$val['name'],$val['value']);

			/* 查找符合条件的商品 */
			$db->view = array (
				'goods_attr' => array (
					'type' => Component_Model_View::TYPE_LEFT_JOIN,
					'alias' => 'a',
					'field' => "g.goods_id, g.goods_name, g.goods_thumb, g.goods_img, g.shop_price AS org_price,IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price,g.market_price, g.promote_price, g.promote_start_date, g.promote_end_date",
					'on' => 'g.goods_id = a.goods_id'
					),
				'member_price' => array (
					'type' => Component_Model_View::TYPE_LEFT_JOIN,
					'alias' => 'mp',
					'on' => 'mp.goods_id = g.goods_id AND mp.user_rank = "' . $_SESSION ['user_rank'] . '"'
					)
				);

			$res = $db->where ( 'a.attr_id = ' . $key . ' AND g.is_on_sale = 1 AND a.attr_value = "' . $val ['value'] . '" AND g.goods_id <> ' . $_REQUEST ['id'] . '' )->limit ( ecjia::config ( 'attr_related_number' ) )->select ();

			if (! empty ( $res )) {
				foreach ( $res as $row ) {
					$lnk [$key] ['goods'] [$row ['goods_id']] ['goods_id'] = $row ['goods_id'];
					$lnk [$key] ['goods'] [$row ['goods_id']] ['goods_name'] = $row ['goods_name'];
					$lnk [$key] ['goods'] [$row ['goods_id']] ['short_name'] = ecjia::config ( 'goods_name_length' ) > 0 ? RC_String::sub_str ( $row ['goods_name'], ecjia::config ( 'goods_name_length' ) ) : $row ['goods_name'];
					$lnk [$key] ['goods'] [$row ['goods_id']] ['goods_thumb'] = (empty($row['goods_thumb'])) ? ecjia::config ('no_picture') : 'content/uploads/goods/' . substr ($row['goods_thumb'], stripos($row['goods_thumb'], '/' ));
					$lnk [$key] ['goods'] [$row ['goods_id']] ['market_price'] = price_format ( $row ['market_price'] );
					$lnk [$key] ['goods'] [$row ['goods_id']] ['shop_price'] = price_format ( $row ['shop_price'] );
					$lnk [$key] ['goods'] [$row ['goods_id']] ['promote_price'] = bargain_price ( $row ['promote_price'], $row ['promote_start_date'], $row ['promote_end_date'] );
					$lnk [$key] ['goods'] [$row ['goods_id']] ['url'] = build_uri('goods', array ('gid' => $row ['goods_id']),$row['goods_name']);
				}
			}
		}
	}
	return $lnk;
}

/**
 * 获得指定商品的相册
 *
 * @access public
 * @param integer $goods_id
 * @return array
 */
function get_goods_gallery($goods_id) {
	$db = RC_Model::model('goods/goods_gallery_model');
	$row = $db->field('img_id, img_url, thumb_url, img_desc')->where(array('goods_id' => $goods_id))/* ->limit(ecjia::config ('goods_gallery_number')) */->select();
	/* 格式化相册图片路径 */
	RC_Loader::load_app_func('global', 'goods');
	foreach ( $row as $key => $gallery_img ) {
		$row [$key] ['img_url'] = get_image_path ( $goods_id, $gallery_img ['img_url'], false, 'gallery' );
		$row [$key] ['thumb_url'] = get_image_path ( $goods_id, $gallery_img ['thumb_url'], true, 'gallery' );
	}
	return $row;
}

/**
 * 获得指定分类下的商品
 *
 * @access public
 * @param integer $cat_id
 *        	分类ID
 * @param integer $num
 *        	数量
 * @param string $from
 *        	来自web/wap的调用
 * @param string $order_rule
 *        	指定商品排序规则
 * @return array
 */
function assign_cat_goods($cat_id, $num = 0, $from = 'web', $order_rule = '') {
	$db_category = RC_Model::model ('goods/category_model');
	$dbview = RC_Model::model('goods/goods_member_viewmodel');
	$children = get_children ( $cat_id );
	$order_rule = empty($order_rule) ? array ('g.sort_order' => 'asc','g.goods_id' => 'DESC'):$order_rule;

	$dbview->view = array (
		'member_price' => array (
			'type'     => Component_Model_View::TYPE_LEFT_JOIN,
			'alias'    => 'mp',
			'field'    => "g.goods_id, g.goods_name, g.market_price, g.shop_price AS org_price,IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price,g.promote_price, promote_start_date, promote_end_date, g.goods_brief, g.goods_thumb, g.goods_img",
			'on'       => 'mp.goods_id = g.goods_id and mp.user_rank = ' . $_SESSION ['user_rank'] . ''
		)
	);

	if ($num > 0) {
		$res = $dbview->where ( 'g.is_on_sale = 1 AND g.is_alone_sale = 1  AND (' . $children . 'OR ' . get_extension_goods ( $children ) . ')' )->order ( $order_rule )->limit ( $num )->select ();
	}
	$res = $dbview->where ( 'g.is_on_sale = 1 AND g.is_alone_sale = 1  AND (' . $children . 'OR ' . get_extension_goods ( $children ) . ')' )->order ( $order_rule )->select ();

	$goods = array ();
	if (! empty ( $res )) {
		foreach ( $res as $idx => $row ) {
			if ($row ['promote_price'] > 0) {
				$promote_price = bargain_price ( $row ['promote_price'], $row ['promote_start_date'], $row ['promote_end_date'] );
				$goods [$idx] ['promote_price'] = $promote_price > 0 ? price_format ( $promote_price ) : '';
			} else {
				$goods [$idx] ['promote_price'] = '';
			}
			$goods [$idx] ['id'] = $row ['goods_id'];
			$goods [$idx] ['name'] = $row ['goods_name'];
			$goods [$idx] ['brief'] = $row ['goods_brief'];
			$goods [$idx] ['market_price'] = price_format ( $row ['market_price'] );
			$goods [$idx] ['short_name'] = ecjia::config ( 'goods_name_length' ) > 0 ? RC_String::sub_str ( $row ['goods_name'], ecjia::config ( 'goods_name_length' ) ) : $row ['goods_name'];
			$goods [$idx] ['shop_price'] = price_format ( $row ['shop_price'] );
			$goods [$idx] ['thumb'] = get_image_path ( $row ['goods_id'], $row ['goods_thumb'], true );
			$goods [$idx] ['goods_img'] = get_image_path ( $row ['goods_id'], $row ['goods_img'] );
			$goods [$idx] ['url'] = build_uri ('goods', array ('gid' => $row ['goods_id']), $row ['goods_name']);
		}
	}

	if ($from == 'web') {
		ecjia_front::$controller->assign('cat_goods_' . $cat_id, $goods);
	} elseif ($from == 'wap') {
		$cat ['goods'] = $goods;
	}

	/* 分类信息 */
	$cat ['name'] = $db_category->where(array('cat_id' => $cat_id ))->get_field( 'cat_name' );

	$cat ['url'] = build_uri('category',array ('cid' => $cat_id),$cat['name']);
	$cat ['id'] = $cat_id;

	return $cat;
}

/**
 * 获得指定的品牌下的商品
 *
 * @access public
 * @param integer $brand_id
 *        	品牌的ID
 * @param integer $num
 *        	数量
 * @param integer $cat_id
 *        	分类编号
 * @param string $order_rule
 *        	指定商品排序规则
 * @return void
 */
function assign_brand_goods($brand_id, $num = 0, $cat_id = 0, $order_rule = '') {
	$db_brand = RC_Model::model('goods/brand_model');
	$dbview = RC_Model::model('goods/goods_member_viewmodel');

	$cat_where = '';
	if ($cat_id > 0) {
		$cat_where = get_children ( $cat_id );
	}
	$order_rule = empty ( $order_rule ) ? array ('g.sort_order' => 'asc','g.goods_id' => 'DESC') : $order_rule;


	$dbview->view = array (
		'member_price' => array (
			'type' => Component_Model_View::TYPE_LEFT_JOIN,
			'alias' => 'mp',
			'field' => "g.goods_id, g.goods_name, g.market_price, g.shop_price AS org_price,IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price,g.promote_price, g.promote_start_date, g.promote_end_date, g.goods_brief, g.goods_thumb, g.goods_img",
			'on' => 'mp.goods_id = g.goods_id and mp.user_rank = ' . $_SESSION ['user_rank'] . ''
		)
	);

	if ($num > 0) {
		$res = $dbview->where( "g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 AND g.brand_id = '$brand_id'" . $cat_where )->order ( $order_rule )->limit ( $num )->select ();
	}
	$res = $dbview->where( "g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 AND g.brand_id = '$brand_id'" . $cat_where )->order ( $order_rule )->select ();
	$idx = 0;
	$goods = array ();

	foreach ( $res as $row ) {
		if ($row ['promote_price'] > 0) {
			$promote_price = bargain_price ( $row ['promote_price'], $row ['promote_start_date'], $row ['promote_end_date'] );
		} else {
			$promote_price = 0;
		}

		$goods [$idx] ['id'] = $row ['goods_id'];
		$goods [$idx] ['name'] = $row ['goods_name'];
		$goods [$idx] ['short_name'] = ecjia::config ( 'goods_name_length' ) > 0 ? RC_String::sub_str ( $row ['goods_name'], ecjia::config ( 'goods_name_length' ) ) : $row ['goods_name'];
		$goods [$idx] ['market_price'] = price_format ( $row ['market_price'] );
		$goods [$idx] ['shop_price'] = price_format ( $row ['shop_price'] );
		$goods [$idx] ['promote_price'] = $promote_price > 0 ? price_format ( $promote_price ) : '';
		$goods [$idx] ['brief'] = $row ['goods_brief'];
		$goods [$idx] ['thumb'] = get_image_path ( $row ['goods_id'], $row ['goods_thumb'], true );
		$goods [$idx] ['goods_img'] = get_image_path ( $row ['goods_id'], $row ['goods_img'] );
		$goods [$idx] ['url'] = build_uri ('goods', array('gid' => $row['goods_id']), $row['goods_name']);
		$idx ++;
	}

	/* 分类信息 */
	$name = $db_brand->field ('brand_name')->find(array('brand_id' => $brand_id));
	$brand ['name'] = $name;
	$brand ['id'] 	= $brand_id;
	$brand ['url'] 	= build_uri ('brand', array('bid' => $brand_id), $brand['name'] );

	$brand_goods = array (
		'brand' => $brand,
		'goods' => $goods
	);
	return $brand_goods;
}

/**
 * 获得所有扩展分类属于指定分类的所有商品ID
 *
 * @access public
 * @param string $cat_id
 *        	分类查询字符串
 * @return string
 */
function get_extension_goods($cats) {
	$db_goods_cat = RC_Model::model('goods/cat_viewmodel');
	$extension_goods_array = '';
	$data = $db_goods_cat->field('goods_id')->where($cats)->select();

	foreach ( $data as $row ) {
		$extension_goods_array [] = $row ['goods_id'];
	}
	return db_create_in ( $extension_goods_array, 'g.goods_id' );
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
function bargain_price($price, $start, $end) {
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
function spec_price($spec, $goods_id = 0, $warehouse_area= array()) {
	$db_goods = RC_Model::model('goods/goods_model');
	$db = RC_Model::model('goods/goods_attr_model');
	if (! empty ( $spec )) {
		if (is_array ( $spec )) {
			foreach ( $spec as $key => $val ) {
				$spec [$key] = addslashes ( $val );
			}
		} else {
			$spec = addslashes ( $spec );
		}
		$model_attr = $db_goods->where(array('goods_id' => $goods_id))->get_field('model_attr');

		if ($model_attr == 1) { //仓库属性
			$db_warehouse_attr = RC_Model::model('warehouse/warehouse_attr_model');
			$warehouse_id = $warehouse_area['warehouse_id'];
			$price = $db_warehouse_attr->in(array('goods_attr_id' => $spec))->where(array('goods_id' => $goods_id, 'warehouse_id' => $warehouse_id))->sum('`attr_price`|attr_price');

		} elseif ($model_attr == 2) { //地区属性
			$db_warehouse_area_attr = RC_Model::model('warehouse/warehouse_area_attr_model');
			$area_id = $warehouse_area['area_id'];
			$price = $db_warehouse_area_attr->in(array('goods_attr_id' => $spec))->where(array('goods_id' => $goods_id, 'area_id' => $area_id))->sum('`attr_price`|attr_price');
		} elseif ($model_attr == 0){
			$price = $db->in(array('goods_attr_id' => $spec))->sum('`attr_price`|attr_price');
		}
	} else {
		$price = 0;
	}

	return $price;
}

/**
 * 取得团购活动信息
 *
 * @param int $group_buy_id
 *        	团购活动id
 * @param int $current_num
 *        	本次购买数量（计算当前价时要加上的数量）
 * @return array status 状态：
 */
function group_buy_info($group_buy_id, $current_num = 0) {
	$db = RC_Model::model('goods/goods_activity_model');
	/* 取得团购活动信息 */
	$group_buy_id = intval ( $group_buy_id );
	$group_buy = $db->field( '*,act_id as group_buy_id, act_desc as group_buy_desc, start_time as start_date, end_time as end_date' )->find(array('act_id' => $group_buy_id, 'act_type' => GAT_GROUP_BUY));
	/* 如果为空，返回空数组 */
	if (empty ( $group_buy )) {
		return array ();
	}

	$ext_info = unserialize ( $group_buy ['ext_info'] );
	$group_buy = array_merge ( $group_buy, $ext_info );

	/* 格式化时间 */
	$group_buy ['formated_start_date'] = RC_Time::local_date('Y/m/d H:i:s', $group_buy ['start_time'] );
	$group_buy ['formated_end_date'] = RC_Time::local_date('Y/m/d H:i:s', $group_buy ['end_time'] );

	/* 格式化保证金 */
	$group_buy ['formated_deposit'] = price_format ( $group_buy ['deposit'], false );

	/* 处理价格阶梯 */
	$price_ladder = $group_buy ['price_ladder'];
	if (! is_array ( $price_ladder ) || empty ( $price_ladder )) {
		$price_ladder = array (
			array ('amount' => 0, 'price' => 0)
		);
	} else {
		foreach ( $price_ladder as $key => $amount_price ) {
			$price_ladder [$key] ['formated_price'] = price_format ( $amount_price ['price'], false );
		}
	}
	$group_buy ['price_ladder'] = $price_ladder;

	/* 统计信息 */
	$stat = group_buy_stat ( $group_buy_id, $group_buy ['deposit'] );
	$group_buy = array_merge ( $group_buy, $stat );

	/* 计算当前价 */
	$cur_price = $price_ladder [0] ['price']; // 初始化
	$cur_amount = $stat ['valid_goods'] + $current_num; // 当前数量
	foreach ( $price_ladder as $amount_price ) {
		if ($cur_amount >= $amount_price ['amount']) {
			$cur_price = $amount_price ['price'];
		} else {
			break;
		}
	}
	$group_buy ['cur_price'] = $cur_price;
	$group_buy ['formated_cur_price'] = price_format ( $cur_price, false );

	/* 最终价 */
	$group_buy ['trans_price'] = $group_buy ['cur_price'];
	$group_buy ['formated_trans_price'] = $group_buy ['formated_cur_price'];
	$group_buy ['trans_amount'] = $group_buy ['valid_goods'];

	/* 状态 */
	$group_buy ['status'] = group_buy_status ( $group_buy );

	if (RC_Lang::get('goods::goods.gbs.' . $group_buy ['status'])) {
		$group_buy ['status_desc'] = RC_Lang::get('goods::goods.gbs.' . $group_buy ['status']);
	}

	$group_buy ['start_time'] = $group_buy ['formated_start_date'];
	$group_buy ['end_time'] = $group_buy ['formated_end_date'];

	return $group_buy;
}

/*
 * 取得某团购活动统计信息 @param int $group_buy_id 团购活动id
 * @param float $deposit 保证金
 *  @return array 统计信息
 *  total_order总订单数
 *  total_goods总商品数
 *  valid_order有效订单数
 *  valid_goods 有效商品数
 */
function group_buy_stat($group_buy_id, $deposit) {
	$group_buy_id = intval ( $group_buy_id );
    $db = RC_Model::model('goods/goods_activity_model');
	$dbview = RC_Model::model('goods/order_info_viewmodel');
	$group_buy_goods_id = $db->where(array('act_id' => $group_buy_id,'act_type' => GAT_GROUP_BUY))->get_field('goods_id');

	/* 取得总订单数和总商品数 */
	$dbview->view = array (
		'order_goods' => array (
			'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
			'alias' => 'g',
			'field' => 'COUNT(*) AS total_order, SUM(g.goods_number) AS total_goods',
			'on' 	=> 'o.order_id = g.order_id '
		)
	);

	$stat = $dbview->find ( "o.extension_code = 'group_buy' AND o.extension_id = '$group_buy_id' AND g.goods_id = '$group_buy_goods_id' AND (order_status = '" . OS_CONFIRMED . "' OR order_status = '" . OS_UNCONFIRMED . "')" );
	if ($stat ['total_order'] == 0) {
		$stat ['total_goods'] = 0;
	}

	/* 取得有效订单数和有效商品数 */
	$deposit = floatval ( $deposit );
	if ($deposit > 0 && $stat ['total_order'] > 0) {

	} else {
		$stat ['valid_order'] = $stat ['total_order'];
		$stat ['valid_goods'] = $stat ['total_goods'];
	}
	return $stat;
}

/**
 * 获得团购的状态
 *
 * @access public
 * @param
 *        	array
 * @return integer
 */
function group_buy_status($group_buy) {
	$now = RC_Time::gmtime ();
	if ($group_buy ['is_finished'] == 0) {
		/* 未处理 */
		if ($now < $group_buy ['start_time']) {
			$status = GBS_PRE_START;
		} elseif ($now > $group_buy ['end_time']) {
			$status = GBS_FINISHED;
		} else {
			if ($group_buy ['restrict_amount'] == 0 || $group_buy ['valid_goods'] < $group_buy ['restrict_amount']) {
				$status = GBS_UNDER_WAY;
			} else {
				$status = GBS_FINISHED;
			}
		}
	} elseif ($group_buy ['is_finished'] == GBS_SUCCEED) {
		/* 已处理，团购成功 */
		$status = GBS_SUCCEED;
	} elseif ($group_buy ['is_finished'] == GBS_FAIL) {
		/* 已处理，团购失败 */
		$status = GBS_FAIL;
	}
	return $status;
}

/**
 * 取得拍卖活动信息
 *
 * @param int $act_id
 *        	活动id
 * @return array
 */
function auction_info($act_id, $config = false) {
	$db_goods_activity = RC_Model::model('goods/goods_activity_model');
	$db_auction_log = RC_Model::model('auction/auction_log_model');
	$dbview = RC_Model::model('auction/auction_log_viewmodel');
	$db_order_info = RC_Model::model('orders/order_info_model');

	$auction = $db_goods_activity->find ( 'act_id = ' . $act_id . '' );
	if ($auction ['act_type'] != GAT_AUCTION) {
		return array ();
	}
	$auction ['status_no'] = auction_status ( $auction );
	if ($config == true) {

		$auction ['start_time'] = RC_Time::local_date ( 'Y-m-d H:i', $auction ['start_time'] );
		$auction ['end_time'] = RC_Time::local_date ( 'Y-m-d H:i', $auction ['end_time'] );
	} else {
		$auction ['start_time'] = RC_Time::local_date ( ecjia::config ( 'time_format' ), $auction ['start_time'] );
		$auction ['end_time'] = RC_Time::local_date ( ecjia::config ( 'time_format' ), $auction ['end_time'] );
	}
	$ext_info = unserialize ( $auction ['ext_info'] );
	$auction = array_merge ( $auction, $ext_info );
	$auction ['formated_start_price'] = price_format ( $auction ['start_price'] );
	$auction ['formated_end_price'] = price_format ( $auction ['end_price'] );
	$auction ['formated_amplitude'] = price_format ( $auction ['amplitude'] );
	$auction ['formated_deposit'] = price_format ( $auction ['deposit'] );

	/* 查询出价用户数和最后出价 */
	$auction ['bid_user_count'] = $db_auction_log->where(array('act_id' => $act_id))->count('DISTINCT bid_user');

	if ($auction ['bid_user_count'] > 0) {

	$row = $dbview->join ( 'users' )->order ( array ('a.log_id' => 'DESC' ) )->find ( array ('act_id' => $act_id ) );
		$row ['formated_bid_price'] = price_format ( $row ['bid_price'], false );
		$row ['bid_time'] = RC_Time::local_date ( ecjia::config ( 'time_format' ), $row ['bid_time'] );
		$auction ['last_bid'] = $row;
	}

	/* 查询已确认订单数 */
	if ($auction ['status_no'] > 1) {
		$auction ['order_count'] = $db_order_info->in ( array ('order_status' => array (OS_CONFIRMED, OS_UNCONFIRMED ) ) )->where ( array ('extension_code' => auction ) )->count ();
	} else {
		$auction ['order_count'] = 0;
	}

	/* 当前价 */
	$auction ['current_price'] = isset ( $auction ['last_bid'] ) ? $auction ['last_bid'] ['bid_price'] : $auction ['start_price'];
	$auction ['formated_current_price'] = price_format ( $auction ['current_price'], false );

	return $auction;
}

/**
 * 取得拍卖活动出价记录
 *
 * @param int $act_id
 *        	活动id
 * @return array
 */
function auction_log($act_id) {
	$dbview = RC_Model::model ('auction/auction_log_viewmodel');
	$log = array ();
	$res = $dbview->join('users')->where(array('act_id' => $act_id))->order('log_id DESC')->select();
	foreach ($res as $row) {
		$row ['bid_time'] = RC_Time::local_date (ecjia::config('time_format'), $row['bid_time']);
		$row ['formated_bid_price'] = price_format ($row ['bid_price'], false );
		$log [] = $row;
	}
	return $log;
}

/**
 * 计算拍卖活动状态（注意参数一定是原始信息）
 *
 * @param array $auction
 *        	拍卖活动原始信息
 * @return int
 */
function auction_status($auction) {
	$now = RC_Time::gmtime ();
	if ($auction ['is_finished'] == 0) {
		if ($now < $auction ['start_time']) {
			return PRE_START; // 未开始
		} elseif ($now > $auction ['end_time']) {
			return FINISHED; // 已结束，未处理
		} else {
			return UNDER_WAY; // 进行中
		}
	} elseif ($auction ['is_finished'] == 1) {
		return FINISHED; // 已结束，未处理
	} else {
		return SETTLED; // 已结束，已处理
	}
}

/**
 * 取得商品信息
 *
 * @param int $goods_id
 *        	商品id
 * @return array
 */
function goods_info($goods_id) {
	$row = RC_DB::table('goods as g')->leftJoin('brand as b', RC_DB::raw('g.brand_id'), '=', RC_DB::raw('b.brand_id'))
		->where(RC_DB::raw('g.goods_id'), $goods_id)
		->selectRaw('g.*, b.brand_name')
		->first();

	if (! empty ( $row )) {
		RC_Loader::load_app_func('global', 'goods');
		/* 修正重量显示 */
		$row ['goods_weight'] = (intval ( $row ['goods_weight'] ) > 0) ? $row ['goods_weight'] . RC_Lang::get('goods::goods.kilogram') : ($row ['goods_weight'] * 1000) . RC_Lang::get('goods::goods.gram');
		/* 修正图片 */
		$row ['goods_img'] = get_image_path ( $goods_id, $row ['goods_img'] );
	}
	// 添加图片路径处理
	$row ['goods_thumb'] = 'content/uploads/goods' . substr ( $row ['goods_thumb'], strpos ( $row ['goods_thumb'], '/' ) );
	$row ['original_img'] = 'content/uploads/goods' . substr ( $row ['original_img'], strpos ( $row ['original_img'], '/' ) );
	return $row;
}

/**
 * 批发信息
 *
 * @param int $act_id
 *        	活动id
 * @return array
 */
function wholesale_info($act_id) {
	$db = RC_Model::model('wholesale/wholesale_model');
	$row = $db->find(array (
		'act_id' => $act_id
	));
	if (!empty($row)) {
		$row['price_list'] = unserialize($row['prices']);
	}
	return $row;
}

/**
 * 添加商品名样式
 *
 * @param string $goods_name
 *        	商品名称
 * @param string $style
 *        	样式参数
 * @return string
 */
function add_style($goods_name, $style) {
	$goods_style_name = $goods_name;

	$arr = explode ( '+', $style );
	$font_color = ! empty ( $arr [0] ) ? $arr [0] : '';
	$font_style = ! empty ( $arr [1] ) ? $arr [1] : '';

	if ($font_color != '') {
		$goods_style_name = '<font color=' . $font_color . '>' . $goods_style_name . '</font>';
	}
	if ($font_style != '') {
		$goods_style_name = '<' . $font_style . '>' . $goods_style_name . '</' . $font_style . '>';
	}
	return $goods_style_name;
}

/**
 * 取得商品属性
 *
 * @param int $goods_id
 *        	商品id
 * @return array
 */
function get_goods_attr($goods_id) {
    $dbview = RC_Model::model('goods/goods_auto_viewmodel');
	$db_goods_attr = RC_Model::model('goods/goods_attr_model');

	$attr_list = array ();
	$dbview->view = array (
		'attribute' => array (
			'type' => Component_Model_View::TYPE_LEFT_JOIN,
			'alias' => 'a',
			'field' => 'a.attr_id, a.attr_name',
			'on' => 'g.goods_type = a.cat_id'
		)
	);

	$attr_id_list = $dbview->where( array ('g.goods_id' => $goods_id,'a.attr_type' => 1 ) )->get_field('attr_id',1);
	$data = $dbview->where ( array ('g.goods_id' => $goods_id,'a.attr_type' => 1 ) )->select ();

	if (! empty ( $data )) {
		foreach ( $data as $attr ) {
			if (defined ( 'IN_ADMIN' )) {
				$attr ['goods_attr_list'] = array (0 => RC_Lang::get('goods::goods.select_please'));
			} else {
				$attr ['goods_attr_list'] = array ();
			}
			$attr_list [$attr ['attr_id']] = $attr;
		}
	}

	$query = $db_goods_attr->field ('attr_id, goods_attr_id, attr_value')->where(array('goods_id' => $goods_id))->in(array('attr_id' => $attr_id_list))->select();
		if (!empty($query)) {
			foreach ( $query as $goods_attr ) {
				$attr_list [$goods_attr ['attr_id']] ['goods_attr_list'] [$goods_attr ['goods_attr_id']] = $goods_attr ['attr_value'];
			}
		}
		return $attr_list;
	}

/**
 * 获得购物车中商品的配件
 *
 * @access public
 * @param array $goods_list
 * @return array
 */
function get_goods_fittings($goods_list = array()) {
	$dbview = RC_Model::model('goods/group_viewmodel');

	$temp_index = 0;
	$arr = array ();
	$dbview->view = array (
		'goods ' => array (
			'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
			'alias' => 'g',
			'field' => "gg.parent_id, ggg.goods_name AS parent_name, gg.goods_id, gg.goods_price, g.goods_name, g.goods_thumb, g.goods_img, g.shop_price AS org_price,IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price",
			'on' 	=> 'g.goods_id = gg.goods_id'
		),
		'member_price' => array (
			'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
			'alias' => 'mp',
			'on' 	=> "mp.goods_id = gg.goods_id AND mp.user_rank = '$_SESSION[user_rank]'"
		),
		'goods' => array (
			'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
			'alias' => 'ggg',
			'on' 	=> 'ggg.goods_id = gg.parent_id'
		)
	);

	$res = $dbview->where('g.is_delete = 0 AND g.is_on_sale = 1')->in(array('gg.parent_id' => $goods_list))->order(array('gg.parent_id' => 'asc', 'gg.goods_id' => 'asc'))->select();

	if (!empty($res)) {
		foreach ($res as $row) {
			$arr [$temp_index] ['parent_id'] = $row ['parent_id'];		 	// 配件的基本件ID
			$arr [$temp_index] ['parent_name'] = $row ['parent_name']; 		// 配件的基本件的名称
			$arr [$temp_index] ['parent_short_name'] = ecjia::config ( 'goods_name_length' ) > 0 ? RC_String::sub_str ( $row ['parent_name'], ecjia::config ( 'goods_name_length' ) ) : $row ['parent_name']; // 配件的基本件显示的名称
			$arr [$temp_index] ['goods_id'] = $row ['goods_id']; 			// 配件的商品ID
			$arr [$temp_index] ['goods_name'] = $row ['goods_name']; 		// 配件的名称
			$arr [$temp_index] ['short_name'] = ecjia::config ( 'goods_name_length' ) > 0 ? RC_String::sub_str ( $row ['goods_name'], ecjia::config ( 'goods_name_length' ) ) : $row ['goods_name']; // 配件显示的名称
			$arr [$temp_index] ['fittings_price'] = price_format ( $row ['goods_price'] ); 	// 配件价格
			$arr [$temp_index] ['shop_price'] = price_format ( $row ['shop_price'] ); 		// 配件原价格
			$arr [$temp_index] ['goods_thumb'] = get_image_path ( $row ['goods_id'], $row ['goods_thumb'], true );
			$arr [$temp_index] ['goods_img'] = get_image_path ( $row ['goods_id'], $row ['goods_img'] );
			$arr [$temp_index] ['url'] = build_uri ('goods', array ('gid' => $row['goods_id']), $row ['goods_name']);
			$temp_index ++;
		}
	}
	return $arr;
}

/**
 * 取指定规格的货品信息
 *
 * @access public
 * @param string $goods_id
 * @param array $spec_goods_attr_id
 * @return array
 */
function get_products_info($goods_id, $spec_goods_attr_id, $warehouse_id=0, $area_id=0) {
	$model_attr = RC_DB::table('goods')->where('goods_id', $goods_id)->pluck('model_attr');

	$return_array = array ();

	if (empty ( $spec_goods_attr_id ) || ! is_array ( $spec_goods_attr_id ) || empty ( $goods_id )) {
		return $return_array;
	}
	$goods_attr_array = sort_goods_attr_id_array ( $spec_goods_attr_id );

	if (isset ( $goods_attr_array ['sort'] )) {
		$goods_attr = implode ( '|', $goods_attr_array ['sort'] );
		$return_array = RC_DB::table('products')->where('goods_id', $goods_id)->where('goods_attr', $goods_attr)->first();
	}
	return $return_array;
}

/**
 * 获得所有商品类型
 *
 * @access  public
 * @return  array
 */
function get_goods_type() {
	$filter['merchant_keywords']= !empty($_GET['merchant_keywords'])	? trim($_GET['merchant_keywords']) 	: '';
	$filter['keywords'] 		= !empty($_GET['keywords']) 			? trim($_GET['keywords']) 			: '';

	$db_goods_type = RC_DB::table('goods_type as gt')->leftJoin('store_franchisee as s', RC_DB::raw('s.store_id'), '=', RC_DB::raw('gt.store_id'));

	if (!empty($filter['merchant_keywords'])) {
		$db_goods_type->where(RC_DB::raw('s.merchants_name'), 'like', '%'.mysql_like_quote($filter['merchant_keywords']).'%');
	}

	if (!empty($filter['keywords'])) {
		$db_goods_type->where(RC_DB::raw('gt.cat_name'), 'like', '%'.mysql_like_quote($filter['keywords']).'%');
	}

	$filter_count = $db_goods_type
		->select(RC_DB::raw('count(*) as count'), RC_DB::raw('SUM(IF(s.manage_mode = "self", 1, 0)) as self'))
		->first();

	$filter['count']	= $filter_count['count'] > 0 ? $filter_count['count'] : 0;
	$filter['self'] 	= $filter_count['self'] > 0 ? $filter_count['self'] : 0;

	$filter['type'] = isset($_GET['type']) ? $_GET['type'] : '';
	if (!empty($filter['type'])) {
		$db_goods_type->where(RC_DB::raw('s.manage_mode'), 'self');
	}

	$count = $db_goods_type->count();
	$page = new ecjia_page($count, 15, 5);

	$field = 'gt.*, count(a.cat_id) as attr_count, s.merchants_name';
	$goods_type_list = $db_goods_type
		->leftJoin('attribute as a', RC_DB::raw('a.cat_id'), '=', RC_DB::raw('gt.cat_id'))
		->selectRaw($field)
		->groupBy(RC_DB::Raw('gt.cat_id'))
		->orderby(RC_DB::Raw('gt.cat_id'), 'desc')
		->take(15)
		->skip($page->start_id-1)
		->get();

	if (!empty($goods_type_list)) {
		foreach ($goods_type_list AS $key=>$val) {
			$goods_type_list[$key]['attr_group'] = strtr($val['attr_group'], array("\r" => '', "\n" => ", "));
			$goods_type_list[$key]['shop_name']  = $val['store_id'] == 0 ? '' : $val['merchants_name'];
		}
	}
	return array('item' => $goods_type_list, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());
}

/**
 * 获取属性列表
 *
 * @return  array
 */
function get_attr_list() {
	$db_attribute = RC_DB::table('attribute as a');
	/* 查询条件 */
	$filter = array();
	$filter['cat_id'] 		= empty($_REQUEST['cat_id']) 		? 0 			: intval($_REQUEST['cat_id']);
	$filter['sort_by'] 		= empty($_REQUEST['sort_by']) 		? 'sort_order' 	: trim($_REQUEST['sort_by']);
	$filter['sort_order']	= empty($_REQUEST['sort_order']) 	? 'asc' 		: trim($_REQUEST['sort_order']);

	$where = (!empty($filter['cat_id'])) ? " a.cat_id = '".$filter['cat_id']."' " : '';
	if (!empty($filter['cat_id'])) {
		$db_attribute->whereRaw($where);
	}
	$count = $db_attribute->count('attr_id');
	$page = new ecjia_page($count, 15, 5);

	$row = $db_attribute
		->leftJoin('goods_type as t', RC_DB::raw('a.cat_id'), '=', RC_DB::raw('t.cat_id'))
		->selectRaw('a.*, t.cat_name')
		->orderby($filter['sort_by'], $filter['sort_order'])
		->take(15)->skip($page->start_id-1)->get();

	if (!empty($row)) {
		foreach ($row AS $key => $val) {
			$row[$key]['attr_input_type_desc'] = RC_Lang::get('goods::attribute.value_attr_input_type.'.$val['attr_input_type']);
			$row[$key]['attr_values'] = str_replace("\n", ", ", $val['attr_values']);
		}
	}
	return array('item' => $row, 'page' => $page->show(5), 'desc' => $page->page_desc());
}


/**
 * 获得指定的商品类型的详情
 *
 * @param   integer     $cat_id 分类ID
 *
 * @return  array
 */
function get_goods_type_info($cat_id) {
	return RC_DB::table('goods_type')->where('cat_id', $cat_id)->first();
}

/**
 * 更新属性的分组
 *
 * @param   integer     $cat_id     商品类型ID
 * @param   integer     $old_group
 * @param   integer     $new_group
 *
 * @return  void
 */
function update_attribute_group($cat_id, $old_group, $new_group) {
	$data = array(
		'attr_group' => $new_group,
	);
	RC_DB::table('goods_type')->where('cat_id', $cat_id)->where('attr_group', $old_group)->update($data);
}

/**
 * 获得商家所有商品类型
 *
 * @access  public
 * @return  array
 */
function get_merchant_goods_type() {
	$filter['keywords'] = !empty($_GET['keywords']) ? trim($_GET['keywords']) : '';

	$_SESSION['store_id'] = !empty($_SESSION['store_id']) ? $_SESSION['store_id'] : 0;

	$db_goods_type = RC_DB::table('goods_type as gt')
		->leftJoin('store_franchisee as s', RC_DB::raw('s.store_id'), '=', RC_DB::raw('gt.store_id'))
		->where(RC_DB::raw('gt.store_id'), $_SESSION['store_id']);

	if (!empty($filter['keywords'])) {
		$db_goods_type->where(RC_DB::raw('gt.cat_name'), 'like', '%'.mysql_like_quote($filter['keywords']).'%');
	}

	$filter_count = $db_goods_type
		->select(RC_DB::raw('count(*) as count'), RC_DB::raw('SUM(IF(gt.store_id > 0, 1, 0)) as merchant'))
		->first();

	$filter['count'] 	= $filter_count['count'] > 0 ? $filter_count['count'] : 0;
	$filter['merchant'] = $filter_count['merchant'] > 0 ? $filter_count['merchant'] : 0;

	$filter['type'] = isset($_GET['type']) ? $_GET['type'] : '';
	if (!empty($filter['type'])) {
		$db_goods_type->where(RC_DB::raw('gt.store_id'), '>', 0);
	}

	$count = $db_goods_type->count();
	$page = new ecjia_merchant_page($count, 15, 5);

	$field = 'gt.*, count(a.cat_id) as attr_count, s.merchants_name';
	$goods_type_list = $db_goods_type
		->leftJoin('attribute as a', RC_DB::raw('a.cat_id'), '=', RC_DB::raw('gt.cat_id'))
		->selectRaw($field)
		->groupBy(RC_DB::Raw('gt.cat_id'))
		->orderby(RC_DB::Raw('gt.cat_id'), 'desc')
		->take(15)
		->skip($page->start_id-1)
		->get();

	if (!empty($goods_type_list)) {
		foreach ($goods_type_list AS $key=>$val) {
			$goods_type_list[$key]['attr_group'] = strtr($val['attr_group'], array("\r" => '', "\n" => ", "));
			$goods_type_list[$key]['shop_name'] = $val['store_id'] == 0 ? '' : $val['merchants_name'];
		}
	}
	return array('item' => $goods_type_list, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());
}

/**
 * 获取商家属性列表
 *
 * @return  array
 */
function get_merchant_attr_list() {
	// 	$dbview  = RC_Model::model('goods/attribute_goods_viewmodel');
	$db_attribute = RC_DB::table('attribute as a');
	/* 查询条件 */
	$filter = array();
	$filter['cat_id'] 		= empty($_REQUEST['cat_id']) 		? 0 			: intval($_REQUEST['cat_id']);
	$filter['sort_by'] 		= empty($_REQUEST['sort_by']) 		? 'sort_order' 	: trim($_REQUEST['sort_by']);
	$filter['sort_order']	= empty($_REQUEST['sort_order']) 	? 'asc' 		: trim($_REQUEST['sort_order']);

	$where = (!empty($filter['cat_id'])) ? " a.cat_id = '".$filter['cat_id']."' " : '';
	if (!empty($filter['cat_id'])) {
		$db_attribute->whereRaw($where);
	}
	$count = $db_attribute->count('attr_id');
	$page = new ecjia_merchant_page($count, 15, 5);

	$row = $db_attribute
	->leftJoin('goods_type as t', RC_DB::raw('a.cat_id'), '=', RC_DB::raw('t.cat_id'))
	->selectRaw('a.*, t.cat_name')
	->orderby($filter['sort_by'], $filter['sort_order'])
	->take(15)->skip($page->start_id-1)->get();

	if (!empty($row)) {
		foreach ($row AS $key => $val) {
			$row[$key]['attr_input_type_desc'] = RC_Lang::get('goods::attribute.value_attr_input_type.'.$val['attr_input_type']);
			$row[$key]['attr_values'] = str_replace("\n", ", ", $val['attr_values']);
		}
	}
	return array('item' => $row, 'page' => $page->show(5), 'desc' => $page->page_desc());
}

/**
 * 添加链接
 * @param   string $extension_code 虚拟商品扩展代码，实体商品为空
 * @return  array('href' => $href, 'text' => $text)
 */
function add_link($extension_code = '') {
	$pathinfo = 'goods/admin/add';
	$args = array();
	if (!empty($extension_code)) {
		$args['extension_code'] = $extension_code;
	}
	if ($extension_code == 'virtual_card') {
		$text = RC_Lang::get('system::system.51_virtual_card_add');
	} else {
		$text = RC_Lang::get('system::system.02_goods_add');
	}
	return array(
		'href' => RC_Uri::url($pathinfo, $args),
		'text' => $text
	);
}

/**
 * 检查图片网址是否合法
 * @param string $url 网址
 *
 * @return boolean
 */
function goods_parse_url($url) {
	$parse_url = @parse_url($url);
	return (!empty($parse_url['scheme']) && !empty($parse_url['host']));
}

/**
 * 取得商品列表：用于把商品添加到组合、关联类、赠品类
 * @param   object  $filters    过滤条件
 */
function get_goods_list($filter) {
	$db = RC_Model::model('goods/goods_auto_viewmodel');
	$filter = (object)$filter;
	$filter->keyword = $filter->keyword;
	//TODO 过滤条件为对象获取方式，后期换回数组
	$where = get_where_sql($filter); // 取得过滤条件
	/* 取得数据 */
	$row = $db->join(null)->field('goods_id, goods_name, shop_price')->where($where)->limit(50)->select();
	return $row;
}

/**
 * 生成过滤条件：用于 get_goodslist 和 get_goods_list
 * @param   object  $filter
 * @return  string
 */
function get_where_sql($filter) {
	$time = date('Y-m-d');

	$where  = isset($filter->is_delete) && $filter->is_delete == '1' ?
	' is_delete = 1 ' : ' is_delete = 0 ';
	$where .= (isset($filter->real_goods) && ($filter->real_goods > -1)) ? ' AND is_real = ' . intval($filter->real_goods) : '';
	$where .= isset($filter->cat_id) && $filter->cat_id > 0 ? ' AND ' . get_children($filter->cat_id) : '';
	$where .= isset($filter->brand_id) && $filter->brand_id > 0 ? " AND brand_id = '" . $filter->brand_id . "'" : '';
	$where .= isset($filter->intro_type) && $filter->intro_type != '0' ? ' AND ' . $filter->intro_type . " = '1'" : '';
	$where .= isset($filter->intro_type) && $filter->intro_type == 'is_promote' ?
	" AND promote_start_date <= '$time' AND promote_end_date >= '$time' " : '';
	$where .= isset($filter->keyword) && trim($filter->keyword) != '' ?
	" AND (goods_name LIKE '%" . mysql_like_quote($filter->keyword) . "%' OR goods_sn LIKE '%" . mysql_like_quote($filter->keyword) . "%' OR goods_id LIKE '%" . mysql_like_quote($filter->keyword) . "%') " : '';
	$where .= isset($filter->suppliers_id) && trim($filter->suppliers_id) != '' ?
	" AND (suppliers_id = '" . $filter->suppliers_id . "') " : '';

	$where .= isset($filter->in_ids) ? ' AND goods_id ' . db_create_in($filter->in_ids) : '';
	$where .= isset($filter->exclude) ? ' AND goods_id NOT ' . db_create_in($filter->exclude) : '';
	$where .= isset($filter->stock_warning) ? ' AND goods_number <= warn_number' : '';
	return $where;
}

/**
 * 获得店铺商品类型的列表
 *
 * @access  public
 * @param   integer     $selected   选定的类型编号
 * @param   integer     $store_id	店铺id
 * @param   boolean		是否显示平台规格
 * @return  string
 */
function goods_type_list($selected, $store_id = 0, $show_all = false) {
	$db_goods_type = RC_DB::table('goods_type')->select('cat_id', 'cat_name')->where('enabled', 1);

	$db_goods_type->where('store_id', $store_id);
	if ($show_all) {
		//自营商家可以使用平台后台添加的商品规格
		$store_info = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
		if ($store_info['manage_mode'] == 'self') {
			$db_goods_type->orWhere('store_id', 0);
		}
	}
	$data = $db_goods_type->get();

	$opt = '';
	if (!empty($data)) {
		foreach ($data as $row){
			$opt .= "<option value='$row[cat_id]'";
			$opt .= ($selected == $row['cat_id']) ? ' selected="true"' : '';
			$opt .= '>' . htmlspecialchars($row['cat_name']). '</option>';
		}
	}
	return $opt;
}

function brand_exists($brand_name) {
	$db = RC_Model::model('goods/brand_model');
	return ($db->where('brand_name = "'. $brand_name .'" ')->count() > 0 ) ? true : false;
}

/**
 * 获取订购信息
 *
 * @access  public
 *
 * @return array
 */
function get_bookinglist() {
	$args = $_GET;
	/* 查询条件 */
	$filter['keywords']		= empty($args['keywords'])		? '' : trim($args['keywords']);
	$filter['dispose']		= empty($args['dispose'])		? 0 : intval($args['dispose']);
	$filter['sort_by']		= empty($args['sort_by'])		? 'g.sort_order' : trim($args['sort_by']);
	$filter['sort_order']	= empty($args['sort_order'])	? 'DESC' : trim($args['sort_order']);

	$where = array();
	(!empty($args['keywords'])) ? $where['g.goods_name'] = array('like' => '%' . mysql_like_quote($filter['keywords']) . '%') : '';
	(!empty($args['dispose'])) ? $where['bg.is_dispose'] = $filter['dispose'] : '';

	$dbview = RC_Model::model('goods/order_booking_goods_viewmodel');
	$count = $dbview->join('goods')->where($where)->count();
	$filter['record_count'] = $count;

	//实例化分页
	$page = new ecjia_page($count, 15, 6);

	/* 获取缺货登记数据 */
	$dbview->view = array(
		'goods' => array(
			'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
			'alias'	=> 'g',
			'on'	=> 'bg.goods_id = g.goods_id',
		),
// 		'merchants_shop_information' => array(
// 			'type'  => Component_Model_View::TYPE_LEFT_JOIN,
// 			'alias'	=> 'ms',
// 			'field'	=> 'bg.rec_id, bg.link_man, g.goods_id, g.goods_name, bg.goods_number, bg.booking_time, bg.is_dispose, g.user_id, ms.shoprz_brandName, ms.shopNameSuffix',
// 			'on'    => 'ms.user_id = g.user_id',
// 		),
		'seller_shopinfo' => array(
			'type'  => Component_Model_View::TYPE_LEFT_JOIN,
			'alias'	=> 'ssi',
			'field'	=> 'bg.rec_id, bg.link_man, g.goods_id, g.goods_name, bg.goods_number, bg.booking_time, bg.is_dispose, g.seller_id, ssi.shop_name',
			'on'    => 'ssi.id = g.seller_id',
		)
	);

	$row = $dbview->join('goods,seller_shopinfo')->where($where)->order(array($filter['sort_by'] => $filter['sort_order']))->limit($page->limit())->select();

	if (!empty($row)) {
		foreach ($row AS $key => $val) {
			$row[$key]['booking_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['booking_time']);
			$row[$key]['shop_name'] = $val['seller_id'] == 0 ? '' : $val['shop_name'];
		}
	}
	$filter['keywords'] = stripslashes($filter['keywords']);
	$arr = array('item' => $row, 'filter' => $filter, 'page' => $page->show(15), 'desc' => $page->page_desc());

	return $arr;
}

/**
 * 根据id获得缺货登记的详细信息
 *
 * @param   integer     $id
 *
 * @return  array
 */
function get_booking_info($id) {
	$db = RC_Model::model('goods/goods_booking_viewmodel');
	$res = $db->join(array('goods','users'))->find(array('bg.rec_id' => $id));

	/* 格式化时间 */
	$res['booking_time'] = RC_Time::local_date(ecjia::config('time_format'),$res['booking_time']);
	if (!empty($res['dispose_time'])) {
		$res['dispose_time'] = RC_Time::local_date(ecjia::config('time_format'),$res['dispose_time']);
	}
	return $res;
}

/**
 * 保存某商品的扩展分类
 *
 * @param int $goods_id
 *            商品编号
 * @param array $cat_list
 *            分类编号数组
 * @return void
 */
function handle_other_cat($goods_id, $add_list) {
	/* 查询现有的扩展分类 */
	RC_DB::table('goods_cat')->where('goods_id', $goods_id)->delete();
	if (!empty ($add_list)) {
		$data = array();
		foreach ($add_list as $cat_id) {
			$data[] = array(
				'goods_id'  => $goods_id,
				'cat_id'    => $cat_id
			);
		}
		RC_DB::table('goods_cat')->insert($data);
	}
}

// end