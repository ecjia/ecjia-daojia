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
 * 添加管理员操作对象
 */
function assign_adminlog_content() {
    ecjia_admin_log::instance()->add_object('category_goods', 	'分类商品');
    ecjia_admin_log::instance()->add_action('move', 			'转移');
    ecjia_admin_log::instance()->add_action('batch_start',	    '批量上架');
    ecjia_admin_log::instance()->add_action('batch_end',	    '批量下架');
}

/*
 * 上传图片
 *  @param string $path 上传路径
 *  @param string $code 接收图片参数
 *  @param string $old_images 旧图片
 */
function goods_file_upload_info($path, $code, $old_images)
{
    $code = empty($code) ? $path : $code;
    $upload = RC_Upload::uploader('image', array('save_path' => 'merchant/' . $_SESSION['store_id'] . '/data/' . $path, 'auto_sub_dirs' => true));
    $file = $_FILES[$code];
    if (!empty($file) && (isset($file['error']) && $file['error'] == 0 || !isset($file['error']) && $file['tmp_name'] != 'none')) {
        // 检测图片类型是否符合
        if (!$upload->check_upload_file($file)) {
            ecjia_admin::$controller->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            $image_info = $upload->upload($file);
            if (empty($image_info)) {
                ecjia_admin::$controller->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            // 删除旧的图片
            if (!empty($old_images)) {
                $upload->remove($old_images);
            }
            $img_path = $upload->get_position($image_info);
        }
        return $img_path;
    }
}

/**
 * 获取分类属性列表
 *
 * @access  public
 * @param
 *
 * @return void
 */
function get_category_attr_list() {
	$arr = RC_DB::table('attribute as a')
		->leftJoin('goods_type as gt', RC_DB::raw('a.cat_id'), '=', RC_DB::raw('gt.cat_id'))
		->selectRaw('a.attr_id')
		->where(RC_DB::raw('gt.enabled'), 1)
		->orderBy(RC_DB::raw('a.cat_id'), 'asc')
		->orderBy(RC_DB::raw('a.sort_order'), 'asc')
		->get();

	$list = array();
	if (!empty($arr)) {
		foreach ($arr as $val) {
			if (isset($val['cat_id'])) {
				$list[$val['cat_id']][] = array($val['attr_id'] => $val['attr_name']);
			}
		}
	}
	return $list;
}

/*------------------------------------------------------ */
/*-- TODO API使用到的方法------------------------------------*/
/*------------------------------------------------------ */
/**
* 获得分类下的商品总数
*
* @access  public
* @param   string     $cat_id
* @return  integer
*/
function get_cagtegory_goods_count($children, $brand = 0, $min = 0, $max = 0, $ext='') {
	$db = RC_Model::model('goods/goods_model');
	$dbview = RC_Model::model('goods/goods_member_viewmodel');
	RC_Loader::load_app_func('admin_goods','goods');
	
	$where = array(
		'is_on_sale' => 1,
		'is_alone_sale' => 1,
		'is_delete' => 0,
		"(".$children ." OR ".get_extension_goods($children).")",
	);
	if(ecjia::config('review_goods') == 1){
		$where['review_status'] = array('gt' => 2);
	}
	if ($brand > 0) {
		$where['brand_id'] = $brand;
	}
	if ($min > 0) {
		$where[] = "shop_price >= $min";
	}
	if ($max > 0) {
		$where[] = "shop_price <= $max ";
	}
	if (!empty($ext)) {
		array_push($where, $ext);
	}
	/* 返回商品总数 */
	$count = $dbview->join(null)->where($where)->count();
	return  $count;
}

/**
* 取得最近的上级分类的grade值
*
* @access  public
* @param   int     $cat_id    //当前的cat_id
*
* @return int
*/
function get_parent_grade($cat_id) {
	$db = RC_Model::model('category_model','goods');
	static $res = NULL;
	if ($res === NULL) {
		$data = false;
		if ($data === false) {      
			$res =  $db->field('parent_id, cat_id, grade')->select();       
		} else {
			$res = $data;
		}
	}

	if (!$res) {
		return 0;
	}

	$parent_arr = array();
	$grade_arr = array();

	foreach ($res as $val) {
		$parent_arr[$val['cat_id']] = $val['parent_id'];
		$grade_arr[$val['cat_id']] = $val['grade'];
	}

	while ($parent_arr[$cat_id] >0 && $grade_arr[$cat_id] == 0) {
		$cat_id = $parent_arr[$cat_id];
	}

	return $grade_arr[$cat_id];
}

/**
 * 获得指定商品的关联文章
 *
 * @access  public
 * @param   integer     $goods_id
 * @return  void
 */
function get_linked_articles($goods_id) {
    $dbview = RC_Model::model('article/goods_article_viewmodel');
    $data = $dbview->join('article')->where(array('ga.goods_id' => "$goods_id" ,'a.article_approved' => '1'))->order(array('a.add_time' =>'DESC'))->select();

    $arr = array();

    foreach ($data as $row) {
        $row['url']         = $row['article_type'] == 'article' ?
        build_uri('article', array('aid'=>$row['article_id']), $row['title']) : trim($row['file_url']);
        $row['add_time']    = RC_Time::local_date(ecjia::config('date_format'), $row['add_time']);
        $row['short_title'] = ecjia::config('article_title_length') > 0 ?
        RC_String::sub_str($row['title'], ecjia::config('article_title_length')) : $row['title'];

        $arr[] = $row;
    }

    return $arr;
}

/**
 *
 *
 * @access public
 * @param
 *
 * @return void
 */
function is_not_null($value) {
    if (is_array($value)) {
        return (!empty($value['from'])) || (!empty($value['to']));
    } else {
        return !empty($value);
    }
}

/**
* 获得可以检索的属性
*
* @access  public
* @params  integer $cat_id
* @return  void
*/
function get_seachable_attributes($cat_id = 0) {
	$db_good = RC_Model::model('goods/goods_type_viewmodel');
	$db_attribute = RC_Model::model('goods/attribute_model');

	$attributes = array(
		'cate' => array(),
		'attr' => array()
	);

	/* 获得可用的商品类型 */
	$db_good->view =array(
		'attribute' => array(
			'type'  => Component_Model_View::TYPE_LEFT_JOIN,
			'alias' => 'a',
			'field' => 'gt.cat_id, cat_name',
			'on'    => 'a.cat_id = gt.cat_id'
		)
	);
	$cat = $db_good->where(array('gt.enabled' => 1, 'a.attr_index' => array('gt' => 0)))->select();

	/* 获取可以检索的属性 */
	if (!empty($cat)) {
		foreach ($cat AS $val) {
			$attributes['cate'][$val['cat_id']] = $val['cat_name'];
		}
		$where = $cat_id > 0 ? ' AND cat_id = ' . $cat_id : " AND cat_id = " . $cat[0]['cat_id'];
		$data = $db_attribute->field('attr_id, attr_name, attr_input_type, attr_type, attr_values, attr_index, sort_order')->where('attr_index > 0'.$where)->order(array('cat_id' =>'asc', 'sort_order'=>'ASC'))->select();
		foreach ($data as $row) {
			if ($row['attr_index'] == 1 && $row['attr_input_type'] == 1) {
				$row['attr_values'] = str_replace("\r", '', $row['attr_values']);
				$options = explode("\n", $row['attr_values']);

				$attr_value = array();
				foreach ($options AS $opt) {
					$attr_value[$opt] = $opt;
				}
				$attributes['attr'][] = array(
					'id'      => $row['attr_id'],
					'attr'    => $row['attr_name'],
					'options' => $attr_value,
					'type'    => 3
				);
			} else {
				$attributes['attr'][] = array(
					'id'   => $row['attr_id'],
					'attr' => $row['attr_name'],
					'type' => $row['attr_index']
				);
			}
		}
	}
	return $attributes;
}



/*------------------------------------------------------ */
//-- PRIVATE FUNCTION品牌表的方法
/*------------------------------------------------------ */

/**
* 获得指定品牌的详细信息
*
* @access  private
* @param   integer $id
* @return  void
*/
function get_brand_info($id) {
	$db = RC_Model::model('goods/brand_model');
	return $db->find(array('brand_id' => $id));
}

/**
* 获得指定品牌下的推荐和促销商品
*
* @access  private
* @param   string  $type
* @param   integer $brand
* @return  array
*/
function brand_recommend_goods($type, $brand, $cat = 0) {
	$db = RC_Model::model('goods/goods_auto_viewmodel');

	static $result = NULL;
	$time = RC_Time::gmtime();

	if ($result === NULL) {
		if ($cat > 0) {
			$cat_where = "AND " . get_children($cat);
		} else {
			$cat_where = '';
		}

		$db->view =array(
			'brand' => array(
				'type' => 	Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'b',
				'field' => "g.goods_id, g.goods_name, g.market_price, g.shop_price AS org_price, g.promote_price,IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price,promote_start_date, promote_end_date, g.goods_brief, g.goods_thumb, goods_img,b.brand_name, g.is_best, g.is_new, g.is_hot, g.is_promote",
				'on' 	=> 'b.brand_id = g.brand_id '
			),
			'member_price'	=> array(
				'type'	=>	Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'mp',
				'on' 	=> 'mp.goods_id = g.goods_id and mp.user_rank = '.$_SESSION['user_rank'].''
			)	
		);
		$result = $db->where('g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 AND g.brand_id = "'.$brand.'" and (g.is_best = 1 OR (g.is_promote = 1 AND promote_start_date <= "'.$time.'" and promote_end_date >= "'.$time.'"))'.$cat_where)->order(array('g.sort_order'=>'asc','g.last_update'=>'desc'))->select();
	}

	/* 取得每一项的数量限制 */
	$num = 0;
	$type2lib = array('best'=>'recommend_best', 'new'=>'recommend_new', 'hot'=>'recommend_hot', 'promote'=>'recommend_promotion');
	$num = get_library_number($type2lib[$type]);

	$idx = 0;
	$goods = array();
	foreach ($result AS $row) {
		if ($idx >= $num) {
			break;
		}

		if (($type == 'best' && $row['is_best'] == 1) || ($type == 'promote' && $row['is_promote'] == 1 && $row['promote_start_date'] <= $time && $row['promote_end_date'] >= $time)) {
			if ($row['promote_price'] > 0) {
				$promote_price = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
				$goods[$idx]['promote_price'] = $promote_price > 0 ? price_format($promote_price) : '';
			} else {
				$goods[$idx]['promote_price'] = '';
			}

			$goods[$idx]['id']           = $row['goods_id'];
			$goods[$idx]['name']         = $row['goods_name'];
			$goods[$idx]['brief']        = $row['goods_brief'];
			$goods[$idx]['brand_name']   = $row['brand_name'];
			$goods[$idx]['short_style_name']   = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
			RC_String::sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
			$goods[$idx]['market_price'] = price_format($row['market_price']);
			$goods[$idx]['shop_price']   = price_format($row['shop_price']);
			$goods[$idx]['thumb']        = get_image_path($row['goods_id'], $row['goods_thumb'], true);
			$goods[$idx]['goods_img']    = get_image_path($row['goods_id'], $row['goods_img']);
			$goods[$idx]['url']          = build_uri('goods', array('gid' => $row['goods_id']), $row['goods_name']);

			$idx++;
		}
	}

	return $goods;
}

/**
* 获得指定的品牌下的商品总数
*
* @access  private
* @param   integer     $brand_id
* @param   integer     $cate
* @return  integer
*/
function goods_count_by_brand($brand_id, $cate = 0) {
	$db = RC_Model::model('goods/goods_member_viewmodel');
	if ($cate > 0) {
		$query = $db->join(null)->where('brand_id = '.$brand_id.' AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 AND '. get_children($cate).'')->count();
	}
	$query = $db->join(null)->where(array('brand_id' => $brand_id, 'g.is_on_sale' => 1, 'g.is_alone_sale' => 1, 'g.is_delete' => 0))->count();
	return $query;
}

/**
* 获得品牌下的商品
*
* @access  private
* @param   integer  $brand_id
* @return  array
*/
function brand_get_goods($brand_id, $cate, $size, $page, $sort, $order) {
	$dbview = RC_Model::model('goods/goods_member_viewmodel');
	$cate_where = ($cate > 0) ? 'AND ' . get_children($cate) : '';

	/* 获得商品列表 */
	$dbview->view =array(
		'member_price' 	=> array(
			'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
			'alias' => 'mp',
			'field' => "g.goods_id, g.goods_name, g.market_price, g.shop_price AS org_price,IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, g.promote_price,g.promote_start_date, g.promote_end_date, g.goods_brief, g.goods_thumb , g.goods_img",
			'on' 	=> 'mp.goods_id = g.goods_id and mp.user_rank = '.$_SESSION['user_rank'].''
		)
	);
	$data = $dbview->where('g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 AND g.brand_id = '.$brand_id.$cate_where.'')->order(array($sort => $order))->limit(($page - 1) * $size,$size)->select();

	$arr = array();
	if(!empty($data)) {
		foreach ($data as $row) {
			if ($row['promote_price'] > 0) {
				$promote_price = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
			} else {
				$promote_price = 0;
			}

			$arr[$row['goods_id']]['goods_id']      = $row['goods_id'];
			if($GLOBALS['display'] == 'grid') {
				$arr[$row['goods_id']]['goods_name']       = $GLOBALS['_CFG']['goods_name_length'] > 0 ? RC_String::sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
			} else {
				$arr[$row['goods_id']]['goods_name']       = $row['goods_name'];
			}
			$arr[$row['goods_id']]['market_price']  = price_format($row['market_price']);
			$arr[$row['goods_id']]['shop_price']    = price_format($row['shop_price']);
			$arr[$row['goods_id']]['promote_price'] = ($promote_price > 0) ? price_format($promote_price) : '';
			$arr[$row['goods_id']]['goods_brief']   = $row['goods_brief'];
			$arr[$row['goods_id']]['goods_thumb']   = get_image_path($row['goods_id'], $row['goods_thumb'], true);
			$arr[$row['goods_id']]['goods_img']     = get_image_path($row['goods_id'], $row['goods_img']);
			$arr[$row['goods_id']]['url']           = build_uri('goods', array('gid' => $row['goods_id']), $row['goods_name']);
		}
	}
	return $arr;
}

/**
* 获得与指定品牌相关的分类
*
* @access  public
* @param   integer $brand
* @return  array
*/
function brand_related_cat($brand) {
	$db = RC_Model::model('goods/category_viewmodel');
	$arr[] = array(
		'cat_id' 	=> 0,
		'cat_name'	=> RC_Lang::get('goods::goods.all_category'),
		'url'		=> build_uri('brand', array('bid' => $brand), RC_Lang::get('goods::goods.all_category'))
	);
	$data = $db->join('goods')->where(array('g.brand_id' => $brand))->group('g.cat_id')->select();
	if(!empty($data)) {
		foreach ($data as $row) {
			$row['url'] = build_uri('brand', array('cid' => $row['cat_id'], 'bid' => $brand), $row['cat_name']);
			$arr[] = $row;
		}
	}
	return $arr;
}
/*------------------------------------------------------ */
//-- END PRIVATE FUNCTION品牌表的方法结束
/*------------------------------------------------------ */

/*------------------------------------------------------ */
//-- 所有分类及品牌的方法
/*------------------------------------------------------ */
/**
* 计算指定分类的商品数量
*
* @access public
* @param   integer     $cat_id
*
* @return void
*/
function calculate_goods_num($cat_list, $cat_id) {
	$goods_num = 0;

	foreach ($cat_list AS $cat) {
		if ($cat['parent_id'] == $cat_id && !empty($cat['goods_num'])) {
			$goods_num += $cat['goods_num'];
		}
	}
	return $goods_num;
}

/**
 * 获得商家指定品牌下的推荐和促销商品
 *
 * @access  private
 * @param   string  $type
 * @param   integer $brand
 * @return  array
 */
function merchant_brand_recommend_goods($type, $brand, $cat = 0) {
	$db = RC_Model::model('goods/goods_auto_viewmodel');

	static $result = NULL;
	$time = RC_Time::gmtime();

	if ($result === NULL) {
		if ($cat > 0) {
			$cat_where = "AND " . merchant_get_children($cat);
		} else {
			$cat_where = '';
		}

		$db->view =array(
			'brand' => array(
				'type' => 	Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'b',
				'field' => "g.goods_id, g.goods_name, g.market_price, g.shop_price AS org_price, g.promote_price,IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price,promote_start_date, promote_end_date, g.goods_brief, g.goods_thumb, goods_img,b.brand_name, g.is_best, g.is_new, g.is_hot, g.is_promote",
				'on' 	=> 'b.brand_id = g.brand_id '
			),
			'member_price'	=> array(
				'type'	=>	Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'mp',
				'on' 	=> 'mp.goods_id = g.goods_id and mp.user_rank = '.$_SESSION['user_rank'].''
			)
		);
		$result = $db->where('g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 AND g.brand_id = "'.$brand.'" and (g.is_best = 1 OR (g.is_promote = 1 AND promote_start_date <= "'.$time.'" and promote_end_date >= "'.$time.'"))'.$cat_where)->order(array('g.sort_order'=>'asc','g.last_update'=>'desc'))->select();
	}

	/* 取得每一项的数量限制 */
	$num = 0;
	$type2lib = array('best'=>'recommend_best', 'new'=>'recommend_new', 'hot'=>'recommend_hot', 'promote'=>'recommend_promotion');
	$num = get_library_number($type2lib[$type]);

	$idx = 0;
	$goods = array();
	foreach ($result AS $row) {
		if ($idx >= $num) {
			break;
		}

		if (($type == 'best' && $row['is_best'] == 1) || ($type == 'promote' && $row['is_promote'] == 1 && $row['promote_start_date'] <= $time && $row['promote_end_date'] >= $time)) {
			if ($row['promote_price'] > 0) {
				$promote_price = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
				$goods[$idx]['promote_price'] = $promote_price > 0 ? price_format($promote_price) : '';
			} else {
				$goods[$idx]['promote_price'] = '';
			}

			$goods[$idx]['id']           = $row['goods_id'];
			$goods[$idx]['name']         = $row['goods_name'];
			$goods[$idx]['brief']        = $row['goods_brief'];
			$goods[$idx]['brand_name']   = $row['brand_name'];
			$goods[$idx]['short_style_name']   = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
			RC_String::sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
			$goods[$idx]['market_price'] = price_format($row['market_price']);
			$goods[$idx]['shop_price']   = price_format($row['shop_price']);
			$goods[$idx]['thumb']        = get_image_path($row['goods_id'], $row['goods_thumb'], true);
			$goods[$idx]['goods_img']    = get_image_path($row['goods_id'], $row['goods_img']);
			$goods[$idx]['url']          = build_uri('goods', array('gid' => $row['goods_id']), $row['goods_name']);

			$idx++;
		}
	}

	return $goods;
}

/**
 * 获得商家指定的品牌下的商品总数
 *
 * @access  private
 * @param   integer     $brand_id
 * @param   integer     $cate
 * @return  integer
 */
function merchant_goods_count_by_brand($brand_id, $cate = 0) {
	$db = RC_Model::model('goods/goods_member_viewmodel');
	if ($cate > 0) {
		$query = $db->join(null)->where('brand_id = '.$brand_id.' AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 AND '. merchant_get_children($cate).'')->count();
	}
	$query = $db->join(null)->where(array('brand_id' => $brand_id, 'g.is_on_sale' => 1, 'g.is_alone_sale' => 1, 'g.is_delete' => 0))->count();
	return $query;
}

/**
 * 获得商家品牌下的商品
 *
 * @access  private
 * @param   integer  $brand_id
 * @return  array
 */
function merchant_brand_get_goods($brand_id, $cate, $size, $page, $sort, $order) {
	$dbview = RC_Model::model('goods/goods_member_viewmodel');
	$cate_where = ($cate > 0) ? 'AND ' . merchant_get_children($cate) : '';

	/* 获得商品列表 */
	$dbview->view =array(
		'member_price' 	=> array(
			'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
			'alias' => 'mp',
			'field' => "g.goods_id, g.goods_name, g.market_price, g.shop_price AS org_price,IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, g.promote_price,g.promote_start_date, g.promote_end_date, g.goods_brief, g.goods_thumb , g.goods_img",
			'on' 	=> 'mp.goods_id = g.goods_id and mp.user_rank = '.$_SESSION['user_rank'].''
		)
	);
	$data = $dbview->where('g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 AND g.brand_id = '.$brand_id.$cate_where.'')->order(array($sort => $order))->limit(($page - 1) * $size,$size)->select();

	$arr = array();
	if(!empty($data)) {
		foreach ($data as $row) {
			if ($row['promote_price'] > 0) {
				$promote_price = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
			} else {
				$promote_price = 0;
			}

			$arr[$row['goods_id']]['goods_id']      = $row['goods_id'];
			if($GLOBALS['display'] == 'grid') {
				$arr[$row['goods_id']]['goods_name']       = $GLOBALS['_CFG']['goods_name_length'] > 0 ? RC_String::sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
			} else {
				$arr[$row['goods_id']]['goods_name']       = $row['goods_name'];
			}
			$arr[$row['goods_id']]['market_price']  = price_format($row['market_price']);
			$arr[$row['goods_id']]['shop_price']    = price_format($row['shop_price']);
			$arr[$row['goods_id']]['promote_price'] = ($promote_price > 0) ? price_format($promote_price) : '';
			$arr[$row['goods_id']]['goods_brief']   = $row['goods_brief'];
			$arr[$row['goods_id']]['goods_thumb']   = get_image_path($row['goods_id'], $row['goods_thumb'], true);
			$arr[$row['goods_id']]['goods_img']     = get_image_path($row['goods_id'], $row['goods_img']);
			$arr[$row['goods_id']]['url']           = build_uri('goods', array('gid' => $row['goods_id']), $row['goods_name']);
		}
	}
	return $arr;
}

/**
 * 保存某商品的会员价格
 *
 * @param int $goods_id
 *            商品编号
 * @param array $rank_list
 *            等级列表
 * @param array $price_list
 *            价格列表
 * @return void
 */
function handle_member_price($goods_id, $rank_list, $price_list) {
	/* 循环处理每个会员等级 */
	if (!empty($rank_list)) {
		foreach ($rank_list as $key => $rank) {
			/* 会员等级对应的价格 */
			$price = $price_list [$key];
			// 插入或更新记录
			$count = RC_DB::table('member_price')->where('goods_id', $goods_id)->where('user_rank', $rank)->count();

			if ($count) {
				/* 如果会员价格是小于0则删除原来价格，不是则更新为新的价格 */
				if ($price < 0) {
					RC_DB::table('member_price')->where('goods_id', $goods_id)->where('user_rank', $rank)->delete();
				} else {
					$data = array(
						'user_price' => $price
					);
					RC_DB::table('member_price')->where('goods_id', $goods_id)->where('user_rank', $rank)->update($data);
				}
			} else {
				if ($price == -1) {
					$sql = '';
				} else {
					$data = array(
						'goods_id' 		=> $goods_id,
						'user_rank' 	=> $rank,
						'user_price' 	=> $price
					);
					RC_DB::table('member_price')->insert($data);
				}
			}
		}
	}
}

/**
 * 保存某商品的优惠价格
 * @param   int $goods_id 商品编号
 * @param   array $number_list 优惠数量列表
 * @param   array $price_list 价格列表
 * @return  void
 */
function handle_volume_price($goods_id, $number_list, $price_list) {
	RC_DB::table('volume_price')->where('price_type', 1)->where('goods_id', $goods_id)->delete();
	/* 循环处理每个优惠价格 */
	foreach ($price_list AS $key => $price) {
		/* 价格对应的数量上下限 */
		$volume_number = $number_list[$key];
		if (!empty($price)) {
			$data = array(
				'price_type'	=> 1,
				'goods_id'		=> $goods_id,
				'volume_number' => $volume_number,
				'volume_price'  => $price,
			);
			RC_DB::table('volume_price')->insert($data);
		}
	}
}

/**
 * 获得指定商品相关的商品
 *
 * @access public
 * @param integer $goods_id
 * @return array
 */
function get_linked_goods($goods_id) {
	$dbview = RC_Model::model('goods/link_goods_viewmodel');
	$dbview->view = array(
		'goods' => array(
			'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
			'alias' => 'g',
			'field' => 'lg.link_goods_id AS goods_id, g.goods_name, lg.is_double',
			'on' 	=> 'lg.link_goods_id = g.goods_id'
		)
	);
	if ($goods_id == 0) {
		$row = $dbview->where(array('lg.admin_id' => $_SESSION['admin_id']))->select();
	}
	$row = $dbview->where(array('lg.goods_id' => $goods_id))->select();
	return $row;
}

/**
 * 修改商品库存
 * @param   string $goods_id 商品编号，可以为多个，用 ',' 隔开
 * @param   string $value 字段值
 * @return  bool
 */
function update_goods_stock($goods_id, $value) {
	$db = RC_Model::model('goods/goods_model');
	if ($goods_id) {
		return $db->inc('goods_number', 'goods_id  ='.$goods_id, "'".$value."', last_update=".RC_Time::gmtime());
	} else {
		return false;
	}
}

/**
 * 列表链接
 * @param   bool $is_add 是否添加（插入）
 * @param   string $extension_code 虚拟商品扩展代码，实体商品为空
 * @return  array('href' => $href, 'text' => $text)
 */
function list_link($extension_code = '') {
	$pathinfo = 'goods/admin/init';
	$args = array();
	if (!empty($extension_code)) {
		$args['extension_code'] = $extension_code;
	}
	if ($extension_code == 'virtual_card') {
		$text = RC_Lang::get('system::system.50_virtual_card_list');
	} else {
		$text = RC_Lang::get('system::system.01_goods_list');
	}
	return array(
		'href' => RC_Uri::url($pathinfo, $args),
		'text' => $text
	);
}

/**
 * 获得指定的商品类型下所有的属性分组
 *
 * @param   integer     $cat_id     商品类型ID
 *
 * @return  array
 */
function get_attr_groups($cat_id) {
	$data = RC_DB::table('goods_type')->where('cat_id', $cat_id)->pluck('attr_group');
	$grp = str_replace("\r", '', $data);
	if ($grp) {
		return explode("\n", $grp);
	} else {
		return array();
	}
}

/**
 * 获取指定分类的str 例：分类1,分类2,分类3
 */
function get_cat_str($cat_id = 0) {
	if (empty($cat_id)) {
		return '';
	}
	$cat_info = RC_DB::table('category')->where('cat_id', $cat_id)->select('parent_id', 'cat_name')->first();
	$str = $cat_info['cat_name'];

	if (!empty($cat_info['parent_id'])) {
		$html_tmp = get_cat_str($cat_info['parent_id']);
		if (!empty($html_tmp)) {
			$str .= ','.$html_tmp;
		}
	}
	return $str;
}

/**
 * 获取指定分类的html 例：分类1>>分类2>>分类3
 */
function get_cat_html($str) {
	$cat_list = explode(',', $str);

	$html = '';
	foreach (array_reverse($cat_list) as $k => $v) {
		if ($k == 0) {
			$html .= $v;
		} else {
			$html .= '>'.$v;
		}
	}
	return $html;
}

/**
 * 取得品牌列表
 *
 * @return array 品牌列表 id => name
 */
function get_brand_list() {
	$res = RC_DB::table('brand')->select('brand_id', 'brand_name')->orderBy('sort_order', 'asc')->get();

	$brand_list = array ();
	if (! empty ( $res )) {
		foreach ( $res as $row ) {
			$brand_list[$row ['brand_id']] = addslashes($row ['brand_name']);
		}
	}
	return $brand_list;
}

/*返回商品详情页面的导航条数组*/
function get_goods_info_nav($goods_id=0, $extension_code='') {
	return array(
		'edit'                  => array('name' => RC_Lang::get('goods::goods.tab_general'), 'pjax' => 1, 'href' => RC_Uri::url('goods/admin/edit', "goods_id=$goods_id".$extension_code)),
		'edit_goods_desc'       => array('name' => RC_Lang::get('goods::goods.tab_detail'), 'pjax' => 1, 'href' => RC_Uri::url('goods/admin/edit_goods_desc', "goods_id=$goods_id".$extension_code)),
		'edit_goods_attr'       => array('name' => RC_Lang::get('goods::goods.tab_properties'), 'pjax' => 1, 'href' => RC_Uri::url('goods/admin/edit_goods_attr', "goods_id=$goods_id".$extension_code)),
		'edit_goods_photo'      => array('name' => RC_Lang::get('goods::goods.tab_gallery'), 'pjax' => 1, 'href' => RC_Uri::url('goods/admin_gallery/init', "goods_id=$goods_id".$extension_code)),
		'edit_link_goods'       => array('name' => RC_Lang::get('goods::goods.tab_linkgoods'), 'pjax' => 1, 'href' => RC_Uri::url('goods/admin/edit_link_goods', "goods_id=$goods_id".$extension_code)),
// 		'edit_link_parts'       => array('name' => RC_Lang::get('goods::goods.tab_groupgoods'), 'pjax' => 1, 'href' => RC_Uri::url('goods/admin/edit_link_parts', "goods_id=$goods_id".$extension_code)),
		'edit_link_article'     => array('name' => RC_Lang::get('goods::goods.tab_article'), 'pjax' => 1, 'href' => RC_Uri::url('goods/admin/edit_link_article', "goods_id=$goods_id".$extension_code)),
		'product_list'          => array('name' => RC_Lang::get('goods::goods.tab_product'), 'pjax' => 1, 'href' => RC_Uri::url('goods/admin/product_list', "goods_id=$goods_id".$extension_code)),
	);
}

/*返回商家商品详情页面的导航条数组*/
function get_merchant_goods_info_nav($goods_id=0, $extension_code='') {
	return array(
		'edit'                  => array('name' => RC_Lang::get('goods::goods.tab_general'), 'pjax' => 1, 'href' => RC_Uri::url('goods/merchant/edit', "goods_id=$goods_id".$extension_code)),
		'edit_goods_desc'       => array('name' => RC_Lang::get('goods::goods.tab_detail'), 'pjax' => 1, 'href' => RC_Uri::url('goods/merchant/edit_goods_desc', "goods_id=$goods_id".$extension_code)),
		'edit_goods_attr'       => array('name' => RC_Lang::get('goods::goods.tab_properties'), 'pjax' => 1, 'href' => RC_Uri::url('goods/merchant/edit_goods_attr', "goods_id=$goods_id".$extension_code)),
		'edit_goods_photo'      => array('name' => RC_Lang::get('goods::goods.tab_gallery'), 'pjax' => 1, 'href' => RC_Uri::url('goods/mh_gallery/init', "goods_id=$goods_id".$extension_code)),
		'edit_link_goods'       => array('name' => RC_Lang::get('goods::goods.tab_linkgoods'), 'pjax' => 1, 'href' => RC_Uri::url('goods/merchant/edit_link_goods', "goods_id=$goods_id".$extension_code)),
// 		'edit_link_parts'       => array('name' => RC_Lang::get('goods::goods.tab_groupgoods'), 'pjax' => 1, 'href' => RC_Uri::url('goods/merchant/edit_link_parts', "goods_id=$goods_id".$extension_code)),
		'edit_link_article'     => array('name' => RC_Lang::get('goods::goods.tab_article'), 'pjax' => 1, 'href' => RC_Uri::url('goods/merchant/edit_link_article', "goods_id=$goods_id".$extension_code)),
		'product_list'          => array('name' => RC_Lang::get('goods::goods.tab_product'), 'pjax' => 1, 'href' => RC_Uri::url('goods/merchant/product_list', "goods_id=$goods_id".$extension_code)),
	);
}

/**
 * 取得某商品的会员价格列表
 *
 * @param int $goods_id
 *            商品编号
 * @return array 会员价格列表 user_rank => user_price
 */
function get_member_price_list($goods_id) {
	/* 取得会员价格 */
	$data = RC_DB::table('member_price')->select('user_rank', 'user_price')->where('goods_id', $goods_id)->get();

	$price_list = array();
	if (!empty($data)) {
		foreach ($data as $row) {
			$price_list[$row ['user_rank']] = $row ['user_price'];
		}
	}
	return $price_list;
}

/**
 * 插入或更新商品属性
 *
 * @param int $goods_id
 *            商品编号
 * @param array $id_list
 *            属性编号数组
 * @param array $is_spec_list
 *            是否规格数组 'true' | 'false'
 * @param array $value_price_list
 *            属性值数组
 * @return array 返回受到影响的goods_attr_id数组
 */
function handle_goods_attr($goods_id, $id_list, $is_spec_list, $value_price_list) {
	$goods_attr_id = array();
	/* 循环处理每个属性 */
	if (!empty($id_list)) {
		foreach ($id_list as $key => $id) {
			$is_spec = $is_spec_list [$key];
			if ($is_spec == 'false') {
				$value = $value_price_list [$key];
				$price = '';
			} else {
				$value_list = array();
				$price_list = array();
				if ($value_price_list [$key]) {
					$vp_list = explode(chr(13), $value_price_list [$key]);
					foreach ($vp_list as $v_p) {
						$arr = explode(chr(9), $v_p);
						$value_list [] = $arr [0];
						$price_list [] = $arr [1];
					}
				}
				$value = join(chr(13), $value_list);
				$price = join(chr(13), $price_list);
			}

			// 插入或更新记录
			$result_id = RC_DB::table('goods_attr')->where('goods_id', $goods_id)->where('attr_id', $id)->where('attr_value', $value)->pluck('goods_attr_id');
				
			if (!empty ($result_id)) {
				$data = array(
					'attr_value' => $value
				);
				RC_DB::table('goods_attr')->where('goods_id', $goods_id)->where('attr_id', $id)->where('goods_attr_id', $result_id)->update($data);

				$goods_attr_id [$id] = $result_id;
			} else {
				$data = array(
					'goods_id' 		=> $goods_id,
					'attr_id' 		=> $id,
					'attr_value' 	=> $value,
					'attr_price' 	=> $price
				);
				$goods_attr_id [$id] = RC_DB::table('goods_attr')->insertGetId($data);
			}
		}
	}
	return $goods_attr_id;
}

/**
 * 商品的货品货号是否重复
 *
 * @param string $product_sn
 *            商品的货品货号；请在传入本参数前对本参数进行SQl脚本过滤
 * @param int $product_id
 *            商品的货品id；默认值为：0，没有货品id
 * @return bool true，重复；false，不重复
 */
function check_product_sn_exist($product_sn, $product_id = 0) {
	$product_sn = trim($product_sn);
	$product_id = intval($product_id);

	if (strlen($product_sn) == 0) {
		return true; // 重复
	}

	$query = RC_DB::table('goods')->where('goods_sn', $product_sn)->pluck('goods_id');
	if ($query) {
		return true; // 重复
	}
	$db_product = RC_DB::table('products')->where('product_sn', $product_sn);
	if (!empty($product_id)) {
		$db_product->where('product_id', '!=', $product_id);
	}
	$res = $db_product->pluck('product_id');

	if (empty ($res)) {
		return false; // 不重复
	} else {
		return true; // 重复
	}
}

/**
 * 修改商品某字段值
 *
 * @param string $goods_id
 *            商品编号，可以为多个，用 ',' 隔开
 * @param string $field
 *            字段名
 * @param string $value
 *            字段值
 * @return bool
 */
function update_goods($goods_id, $field, $value) {
	if ($goods_id) {
		$data = array(
			$field 			=> $value,
			'last_update' 	=> RC_Time::gmtime()
		);
		$db_goods = RC_DB::table('goods')->whereIn('goods_id', $goods_id);
		if (!empty($_SESSION['store_id'])) {
			$db_goods->where('store_id', $_SESSION['store_id']);
		}
		$db_goods->update($data);
	} else {
		return false;
	}
}

/**
 * 从回收站删除多个商品
 *
 * @param mix $goods_id
 *            商品id列表：可以逗号格开，也可以是数组
 * @return void
 */
function delete_goods($goods_id) {
	if (empty($goods_id)) {
		return;
	}
	$data = RC_DB::table('goods')->select('goods_thumb', 'goods_img', 'original_img')->whereIn('goods_id', $goods_id)->get();

	if (!empty($data)) {
		$disk = RC_Filesystem::disk();
		foreach ($data as $goods) {
			if (!empty($goods['goods_thumb'])) {
				$disk->delete(RC_Upload::upload_path() . $goods['goods_thumb']);
			}
			if (!empty($goods['goods_img'])) {
				$disk->delete(RC_Upload::upload_path() . $goods['goods_img']);
			}
			if (!empty($goods['original_img'])) {
				$disk->delete(RC_Upload::upload_path() . $goods['original_img']);
			}
		}
	}
	/* 删除商品 */
	$db_goods = RC_DB::table('goods')->whereIn('goods_id', $goods_id);
	if (!empty($_SESSION['store_id'])) {
		$db_goods->where('store_id', $_SESSION['store_id']);
	}
	$db_goods->delete();

	/* 删除商品的货品记录 */
	RC_DB::table('products')->whereIn('goods_id', $goods_id)->delete();

	/* 删除商品相册的图片文件 */
	$data = RC_DB::table('goods_gallery')->select('img_url', 'thumb_url', 'img_original')->whereIn('goods_id', $goods_id)->get();

	if (!empty($data)) {
		$disk = RC_Filesystem::disk();
		foreach ($data as $row) {
			if (!empty($row ['img_url'])) {
				$disk->delete(RC_Upload::upload_path() . $row['img_url']);
			}
			if (!empty($row['thumb_url'])) {
				$disk->delete(RC_Upload::upload_path() . $row['thumb_url']);
			}
			if (!empty($row['img_original'])) {
				strrpos($row['img_original'], '?') && $row['img_original'] = substr($row['img_original'], 0, strrpos($row['img_original'], '?'));
				$disk->delete(RC_Upload::upload_path() . $row['img_original']);
			}
		}
	}
	/* 删除商品相册 */
	RC_DB::table('goods_gallery')->whereIn('goods_id', $goods_id)->delete();

	/* 删除相关表记录 */
	RC_DB::table('collect_goods')->whereIn('goods_id', $goods_id)->delete();
	RC_DB::table('goods_article')->whereIn('goods_id', $goods_id)->delete();
	RC_DB::table('goods_attr')->whereIn('goods_id', $goods_id)->delete();
	RC_DB::table('goods_cat')->whereIn('goods_id', $goods_id)->delete();
	RC_DB::table('member_price')->whereIn('goods_id', $goods_id)->delete();
	RC_DB::table('group_goods')->whereIn('parent_id', $goods_id)->orWhereIn('goods_id', $goods_id)->delete();
	RC_DB::table('link_goods')->whereIn('goods_id', $goods_id)->orWhereIn('link_goods_id', $goods_id)->delete();
	RC_DB::table('comment')->where('comment_type', 0)->whereIn('id_value', $goods_id)->delete();
}

/**
 * 为某商品生成唯一的货号
 *
 * @param int $goods_id
 *            商品编号
 * @return string 唯一的货号
 */
function generate_goods_sn($goods_id) {
	$goods_sn = ecjia::config('sn_prefix') . str_repeat('0', 6 - strlen($goods_id)) . $goods_id;
	$sn_list = RC_DB::table('goods')
		->where('goods_sn', 'like', '%' . mysql_like_quote($goods_sn) . '%')
		->where('goods_id', '!=', $goods_id)->orderBy(RC_DB::raw('LENGTH(goods_sn)'), 'desc')
		->get();

	/* 判断数组为空就创建数组类型否则类型为null 报错 */
	$sn_list = empty($sn_list) ? array() : $sn_list;
	if (in_array($goods_sn, $sn_list)) {
		$max = pow(10, strlen($sn_list[0]) - strlen($goods_sn) + 1) - 1;
		$new_sn = $goods_sn . mt_rand(0, $max);
		while (in_array($new_sn, $sn_list)) {
			$new_sn = $goods_sn . mt_rand(0, $max);
		}
		$goods_sn = $new_sn;
	}
	return $goods_sn;
}

/**
 * 商品货号是否重复
 *
 * @param string $goods_sn
 *            商品货号；请在传入本参数前对本参数进行SQl脚本过滤
 * @param int $goods_id
 *            商品id；默认值为：0，没有商品id
 * @return bool true，重复；false，不重复
 */
function check_goods_sn_exist($goods_sn, $goods_id = 0) {
	$goods_sn = trim($goods_sn);
	$goods_id = intval($goods_id);

	if (strlen($goods_sn) == 0) {
		return true; // 重复
	}
	$db_goods = RC_DB::table('goods');

	$db_goods->where('goods_sn', $goods_sn);
	if (!empty ($goods_id)) {
		$db_goods->where('goods_id', '!=', $goods_id);
	}
	$res = $db_goods->first();

	if (empty ($res)) {
		return false; // 不重复
	} else {
		return true; // 重复
	}
}

/**
 * 取得通用属性和某分类的属性，以及某商品的属性值
 *
 * @param int $cat_id
 *            分类编号
 * @param int $goods_id
 *            商品编号
 * @return array 规格与属性列表
 */
function get_cat_attr_list($cat_id, $goods_id = 0) {
	$dbview = RC_Model::model('goods/attribute_goods_viewmodel');
	if (empty ($cat_id)) {
		return array();
	}

	$dbview->view = array(
		'goods_attr' => array(
			'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
			'alias' => 'v',
			'field' => 'a.attr_id, a.attr_name, a.attr_input_type, a.attr_type, a.attr_values, v.attr_value, v.attr_price',
			'on' 	=> "v.attr_id = a.attr_id AND v.goods_id = '$goods_id'"
		)
	);
	$row = $dbview
		->where('a.cat_id = "' . intval($cat_id) . '"')
		->order(array('a.sort_order' => 'asc', 'a.attr_type' => 'asc', 'a.attr_id' => 'asc', 'v.attr_price' => 'asc', 'v.goods_attr_id' => 'asc'))
		->select();
	return $row;
}

/**
 * 根据属性数组创建属性的表单
 *
 * @access public
 * @param int $cat_id
 *            分类编号
 * @param int $goods_id
 *            商品编号
 * @return string
 */
function build_attr_html($cat_id, $goods_id = 0) {
	$attr = get_cat_attr_list($cat_id, $goods_id);
	$html = '';
	$spec = 0;

	if (!empty($attr)) {
		foreach ($attr as $key => $val) {
			$html .= "<div class='control-group formSep'><label class='control-label'>";
			$html .= "$val[attr_name]</label><div class='controls'><input type='hidden' name='attr_id_list[]' value='$val[attr_id]' />";
			if ($val ['attr_input_type'] == 0) {
				$html .= '<input name="attr_value_list[]" type="text" value="' . htmlspecialchars($val ['attr_value']) . '" size="40" /> ';
			} elseif ($val ['attr_input_type'] == 2) {
				$html .= '<textarea name="attr_value_list[]" rows="3" cols="40">' . htmlspecialchars($val ['attr_value']) . '</textarea>';
			} else {
				$html .= '<select name="attr_value_list[]" autocomplete="off">';
				$html .= '<option value="">' . RC_Lang::get('goods::goods.select_please') . '</option>';
				$attr_values = explode("\n", $val ['attr_values']);
				foreach ($attr_values as $opt) {
					$opt = trim(htmlspecialchars($opt));

					$html .= ($val ['attr_value'] != $opt) ? '<option value="' . $opt . '">' . $opt . '</option>' : '<option value="' . $opt . '" selected="selected">' . $opt . '</option>';
				}
				$html .= '</select> ';
			}
			$html .= ($val ['attr_type'] == 1 || $val ['attr_type'] == 2) ? '<span class="m_l5 m_r5">' . RC_Lang::get('goods::goods.spec_price') . '</span>' . ' <input type="text" name="attr_price_list[]" value="' . $val ['attr_price'] . '" size="5" maxlength="10" />' : ' <input type="hidden" name="attr_price_list[]" value="0" />';
			if ($val ['attr_type'] == 1 || $val ['attr_type'] == 2) {
				$html .= ($spec != $val ['attr_id']) ? "<a class='m_l5' href='javascript:;' data-toggle='clone-obj' data-parent='.control-group'><i class='fontello-icon-plus'></i></a>" : "<a class='m_l5' href='javascript:;' data-trigger='toggleSpec'><i class='fontello-icon-minus'></i></a>";
				$spec = $val ['attr_id'];
			}
			$html .= '</div></div>';
		}
	}
	$html .= '';
	return $html;
}

/**
 * 根据商家属性数组创建属性的表单
 *
 * @access public
 * @param int $cat_id
 *            分类编号
 * @param int $goods_id
 *            商品编号
 * @return string
 */
function build_merchant_attr_html($cat_id, $goods_id = 0) {
	$attr = get_cat_attr_list($cat_id, $goods_id);
	$html = '';
	$spec = 0;

	if (!empty($attr)) {
		foreach ($attr as $key => $val) {
			$html .= "<div class='form-group'><label class='control-label col-lg-2'>";
			$html .= "$val[attr_name]</label><div class='col-lg-8'><input type='hidden' name='attr_id_list[]' value='$val[attr_id]' />";
			if ($val ['attr_input_type'] == 0) {
				$html .= '<div class="col-lg-5 p_l0"><input class="form-control" name="attr_value_list[]" type="text" value="' . htmlspecialchars($val ['attr_value']) . '" size="40" /></div> ';
			} elseif ($val ['attr_input_type'] == 2) {
				$html .= '<div class="col-lg-5 p_l0"><textarea class="form-control" name="attr_value_list[]" rows="3" cols="40">' . htmlspecialchars($val ['attr_value']) . '</textarea></div>';
			} else {
				$html .= '<div class="col-lg-5 p_l0"><select class="form-control" name="attr_value_list[]" autocomplete="off">';
				$html .= '<option value="">' . RC_Lang::get('goods::goods_batch.select_please') . '</option>';
				$attr_values = explode("\n", $val ['attr_values']);
				foreach ($attr_values as $opt) {
					$opt = trim(htmlspecialchars($opt));

					$html .= ($val ['attr_value'] != $opt) ? '<option value="' . $opt . '">' . $opt . '</option>' : '<option value="' . $opt . '" selected="selected">' . $opt . '</option>';
				}
				$html .= '</select></div>';
			}
			$html .= ($val ['attr_type'] == 1 || $val ['attr_type'] == 2) ? '<span class="m_l5 m_r5 f_l l_h30">' . RC_Lang::get('goods::goods.spec_price') . '</span>' . ' <div class="col-lg-5 p_l0"><input class="form-control" type="text" name="attr_price_list[]" value="' . $val ['attr_price'] . '" size="5" maxlength="10" /></div>' : ' <input type="hidden" name="attr_price_list[]" value="0" />';
			if ($val ['attr_type'] == 1 || $val ['attr_type'] == 2) {
				$html .= ($spec != $val ['attr_id']) ? "<a class='m_l5 l_h30' href='javascript:;' data-toggle='clone-obj' data-parent='.form-group'><i class='fa fa-plus'></i></a>" : "<a class='m_l5 l_h30' href='javascript:;' data-trigger='toggleSpec'><i class='fa fa-times'></i></a>";
				$spec = $val ['attr_id'];
			}
			$html .= '</div></div>';
		}
	}
	$html .= '';
	return $html;
}

/**
 * 获取商品类型中包含规格的类型列表
 *
 * @access public
 * @return array
 */
function get_goods_type_specifications() {
	$row = RC_DB::table('attribute')->selectRaw('DISTINCT cat_id')->where('attr_type', 1)->get();
	$return_arr = array();
	if (!empty($row)) {
		foreach ($row as $value) {
			$return_arr[$value['cat_id']] = $value['cat_id'];
		}
	}
	return $return_arr;
}

/**
 * 获得指定商品的配件
 *
 * @access public
 * @param integer $goods_id
 * @return array
 */
function get_group_goods($goods_id) {
	$dbview = RC_Model::model('goods/group_viewmodel');
	$dbview->view = array(
		'goods' => array(
			'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
			'alias' => 'g',
			'field' => "gg.goods_id, g.goods_name, gg.goods_price",
			'on' 	=> 'gg.goods_id = g.goods_id'
		)
	);
	if ($goods_id == 0) {
		$row = $dbview->where(array('gg.parent_id' => $goods_id, 'gg.admin_id' => $_SESSION ['admin_id']))->select();
	}
	$row = $dbview->where(array('gg.parent_id' => $goods_id))->select();
	return $row;
}

/**
 * 获得商品的关联文章
 *
 * @access public
 * @param integer $goods_id
 * @return array
 */
function get_goods_articles($goods_id) {
	$dbview = RC_Model::model('goods/goods_article_viewmodel');
	$dbview->view = array(
		'article' => array(
			'type'  => Component_Model_View::TYPE_LEFT_JOIN,
			'alias' => 'a',
			'field' => 'ga.article_id, a.title',
			'on'    => 'ga.article_id = a.article_id'
		)
	);
	if ($goods_id == 0) {
// 		$row = $dbview->where(array('ga.goods_id' => $goods_id, 'ga.admin_id' => $_SESSION ['admin_id']))->select();
		$row = $dbview->where(array('ga.goods_id' => $goods_id))->select();
	}
	return $dbview->where(array('ga.goods_id' => $goods_id))->select();
}

/**
 * 获得商品的货品总库存
 *
 * @access public
 * @param
 *            s integer $goods_id 商品id
 * @param
 *            s string $conditions sql条件，AND语句开头
 * @return string number
 */
function product_number_count($goods_id, $conditions = '') {
	if (empty($goods_id)) {
		return -1; // $goods_id不能为空
	}
	$nums = RC_DB::table('products')->whereRaw('goods_id = ' . $goods_id . $conditions . '')->sum('product_number');
	$nums = empty ($nums) ? 0 : $nums;
	return $nums;
}

/**
 * 获得商品的规格属性值列表
 *
 * @access public
 * @param
 *            s integer $goods_id
 * @return array
 */
function product_goods_attr_list($goods_id) {
	$results = RC_DB::table('goods_attr')->select('goods_attr_id', 'attr_value')->where('goods_id', $goods_id)->get();

	$return_arr = array();
	if (!empty ($results)) {
		foreach ($results as $value) {
			$return_arr [$value ['goods_attr_id']] = $value ['attr_value'];
		}
	}
	return $return_arr;
}

/**
 * 获得商品的货品列表
 *
 * @access public
 * @param
 *            s integer $goods_id
 * @param
 *            s string $conditions
 * @return array
 */
function product_list($goods_id, $conditions = '') {
	$db = RC_Model::model('goods/products_model');
	/* 过滤条件 */
	$param_str = '-' . $goods_id;

	$day 	= getdate();
	$today 	= RC_Time::local_mktime(23, 59, 59, $day ['mon'], $day ['mday'], $day ['year']);
	$filter ['goods_id'] 		= $goods_id;
	$filter ['keyword'] 		= empty ($_REQUEST ['keyword']) ? '' : trim($_REQUEST ['keyword']);
	$filter ['stock_warning'] 	= empty ($_REQUEST ['stock_warning']) ? 0 : intval($_REQUEST ['stock_warning']);
	$filter ['sort_by'] 		= empty ($_REQUEST ['sort_by']) ? 'product_id' : trim($_REQUEST ['sort_by']);
	$filter ['sort_order'] 		= empty ($_REQUEST ['sort_order']) ? 'DESC' : trim($_REQUEST ['sort_order']);
	$filter ['extension_code'] 	= empty ($_REQUEST ['extension_code']) ? '' : trim($_REQUEST ['extension_code']);
	$filter ['page_count'] 		= isset ($filter ['page_count']) ? $filter ['page_count'] : 1;

	$where = '';
	/* 库存警告 */
	if ($filter ['stock_warning']) {
		$where .= ' AND goods_number <= warn_number ';
	}

	/* 关键字 */
	if (!empty ($filter ['keyword'])) {
		$where .= " AND (product_sn LIKE '%" . $filter ['keyword'] . "%')";
	}

	$where .= $conditions;

	/* 记录总数 */
	$count = RC_DB::table('products')->whereRaw('goods_id = ' . $goods_id . $where)->count();
	$filter ['record_count'] = $count;

	$row = RC_DB::table('products')
		->selectRaw('product_id, goods_id, goods_attr as goods_attr_str, goods_attr, product_sn, product_number')
		->whereRaw('goods_id = ' . $goods_id . $where)
		->orderBy($filter ['sort_by'], $filter['sort_order'])
		->get();

	/* 处理规格属性 */
	$goods_attr = product_goods_attr_list($goods_id);
	if (!empty ($row)) {
		foreach ($row as $key => $value) {
			$_goods_attr_array = explode('|', $value ['goods_attr']);
			if (is_array($_goods_attr_array)) {
				$_temp = '';
				foreach ($_goods_attr_array as $_goods_attr_value) {
					$_temp[] = $goods_attr [$_goods_attr_value];
				}
				$row [$key] ['goods_attr'] = $_temp;
			}
		}
	}
	return array(
		'product'		=> $row,
		'filter'		=> $filter,
		'page_count'	=> $filter ['page_count'],
		'record_count'	=> $filter ['record_count']
	);
}

/**
 * 获得商品已添加的规格列表
 *
 * @access public
 * @param
 *            s integer $goods_id
 * @return array
 */
function get_goods_specifications_list($goods_id) {
	if (empty($goods_id)) {
		return array(); // $goods_id不能为空
	}
	return RC_DB::table('goods_attr as ga')
		->leftJoin('attribute as a', RC_DB::raw('a.attr_id'), '=', RC_DB::raw('ga.attr_id'))
		->where('goods_id', $goods_id)
		->where(RC_DB::raw('a.attr_type'), 1)
		->selectRaw('ga.goods_attr_id, ga.attr_value, ga.attr_id, a.attr_name')
		->orderBy(RC_DB::raw('ga.attr_id'), 'asc')
		->get();
}

/**
 * 取货品信息
 *
 * @access public
 * @param int $product_id
 *            货品id
 * @param int $filed
 *            字段
 * @return array
 */
function get_product_info($product_id, $field = '') {
	$return_array = array();
	if (empty ($product_id)) {
		return $return_array;
	}
	$filed = trim($filed);
	if (empty ($filed)) {
		$filed = '*';
	}
	return RC_DB::table('products')->selectRaw($field)->where('product_id', $product_id)->first();
}

/**
 * 商品的货品规格是否存在
 *
 * @param string $goods_attr
 *            商品的货品规格
 * @param string $goods_id
 *            商品id
 * @param int $product_id
 *            商品的货品id；默认值为：0，没有货品id
 * @return bool true，重复；false，不重复
 */
function check_goods_attr_exist($goods_attr, $goods_id, $product_id = 0) {
	$db_products = RC_DB::table('products');
	$goods_id = intval($goods_id);
	if (strlen($goods_attr) == 0 || empty ($goods_id)) {
		return true; // 重复
	}

	$db_products->where('goods_attr', $goods_attr)->where('goods_id', $goods_id);
	if (!empty ($product_id)) {
		$db_products->where('product_id', '!=', $product_id);
	}
	$res = $db_products->pluck('product_id');
	if (empty ($res)) {
		return false; // 不重复
	} else {
		return true; // 重复
	}
}

/**
 * 创建像这样的查询: "IN('a','b')";
 *
 * @access public
 * @param mix $item_list
 *        	列表数组或字符串
 * @param string $field_name
 *        	字段名称
 *
 * @return void
 */
function db_create_in($item_list, $field_name = '') {
	if (empty ( $item_list )) {
		return $field_name . " IN ('') ";
	} else {
		if (! is_array ( $item_list )) {
			$item_list = explode ( ',', $item_list );
		}
		$item_list = array_unique ( $item_list );
		$item_list_tmp = '';
		foreach ( $item_list as $item ) {
			if ($item !== '') {
				$item_list_tmp .= $item_list_tmp ? ",'$item'" : "'$item'";
			}
		}
		if (empty ( $item_list_tmp )) {
			return $field_name . " IN ('') ";
		} else {
			return $field_name . ' IN (' . $item_list_tmp . ') ';
		}
	}
}

/**
 * 重新获得商品图片与商品相册的地址
 *
 * @param int $goods_id
 *        	商品ID
 * @param string $image
 *        	原商品相册图片地址
 * @param boolean $thumb
 *        	是否为缩略图
 * @param string $call
 *        	调用方法(商品图片还是商品相册)
 * @param boolean $del
 *        	是否删除图片
 *
 * @return string $url
 */
function get_image_path($goods_id, $image = '', $thumb = false, $call = 'goods', $del = false) {
	if (empty($image)) {
		$url = RC_Uri::admin_url('statics/images/nopic.png');
	} else {
		$url = RC_Upload::upload_url() . '/' . $image;
	}
	return $url;
}

/**
 * 取得商品优惠价格列表
 *
 * @param string $goods_id
 *        	商品编号
 * @param string $price_type
 *        	价格类别(0为全店优惠比率，1为商品优惠价格，2为分类优惠比率)
 *
 * @return 优惠价格列表
 */
function get_volume_price_list($goods_id, $price_type = '1') {
	$res = RC_DB::table('volume_price')
		->select('volume_number', 'volume_price')
		->where('goods_id', $goods_id)
		->where('price_type', $price_type)
		->orderBy('volume_number', 'asc')
		->get();

	$volume_price = array();
	$temp_index = '0';
	if (!empty($res)) {
		foreach ($res as $k => $v) {
			$volume_price[$temp_index] 					= array();
			$volume_price[$temp_index]['number'] 		= $v['volume_number'];
			$volume_price[$temp_index]['price'] 		= $v['volume_price'];
			$volume_price[$temp_index]['format_price'] 	= price_format($v['volume_price']);
			$temp_index ++;
		}
	}
	return $volume_price;
}

/**
 * 将 goods_attr_id 的序列按照 attr_id 重新排序
 *
 * 注意：非规格属性的id会被排除
 *
 * @access public
 * @param array $goods_attr_id_array
 *        	一维数组
 * @param string $sort
 *        	序号：asc|desc，默认为：asc
 *
 * @return string
 */
function sort_goods_attr_id_array($goods_attr_id_array, $sort = 'asc') {
	if (empty($goods_attr_id_array)) {
		return $goods_attr_id_array;
	}
	// 重新排序
	$row = RC_DB::table('attribute as a')
		->leftJoin('goods_attr as v', function($join){
			$join->on(RC_DB::raw('v.attr_id'), '=', RC_DB::raw('a.attr_id'))->on(RC_DB::raw('a.attr_type'), '=', RC_DB::raw('1'));
		})
		->selectRaw('a.attr_type, v.attr_value, v.goods_attr_id')
		->whereIn(RC_DB::raw('v.goods_attr_id'), $goods_attr_id_array)
		->orderby(RC_DB::raw('a.attr_id'), $sort)
		->get();
	 
	$return_arr = array();
	if (! empty($row)) {
		foreach ($row as $value) {
			$return_arr['sort'][] = $value['goods_attr_id'];

			$return_arr['row'][$value['goods_attr_id']] = $value;
		}
	}
	return $return_arr;
}

/**
 * 调用array_combine函数
 *
 * @param array $keys
 * @param array $values
 *
 * @return $combined
 */
if (! function_exists ( 'array_combine' )) {
	function array_combine($keys, $values) {
		if (! is_array ( $keys )) {
			user_error ( 'array_combine() expects parameter 1 to be array, ' . gettype ( $keys ) . ' given', E_USER_WARNING );
			return;
		}
		if (! is_array ( $values )) {
			user_error ( 'array_combine() expects parameter 2 to be array, ' . gettype ( $values ) . ' given', E_USER_WARNING );
			return;
		}

		$key_count = count ( $keys );
		$value_count = count ( $values );
		if ($key_count !== $value_count) {
			user_error ( 'array_combine() Both parameters should have equal number of elements', E_USER_WARNING );
			return false;
		}

		if ($key_count === 0 || $value_count === 0) {
			user_error ( 'array_combine() Both parameters should have number of elements at least 0', E_USER_WARNING );
			return false;
		}

		$keys = array_values ( $keys );
		$values = array_values ( $values );

		$combined = array ();
		for($i = 0; $i < $key_count; $i ++) {
			$combined [$keys [$i]] = $values [$i];
		}

		return $combined;
	}
}

/**
 * 返回订单中的虚拟商品
 *
 * @access public
 * @param int $order_id
 *        	订单id值
 * @param bool $shipping
 *        	是否已经发货
 *
 * @return array()
 */
function get_virtual_goods($order_id, $shipping = false) {
	$db = RC_Model::model('orders/order_goods_model');
	if ($shipping) {
		$res = $db->field('goods_id, goods_name, send_number|num, extension_code' )->where ( 'order_id = ' . $order_id . ' AND extension_code > " " ' )->select ();
	} else {
		$res = $db->field('goods_id, goods_name, (goods_number - send_number)|num, extension_code' )->where ( 'order_id = ' . $order_id . ' AND is_real = 0 AND (goods_number - send_number) > 0 AND extension_code > " " ' )->select ();
	}

	$virtual_goods = array ();
	if (! empty ( $res )) {
		foreach ( $res as $row ) {
			$virtual_goods [$row ['extension_code']] [] = array (
					'goods_id' => $row ['goods_id'],
					'goods_name' => $row ['goods_name'],
					'num' => $row ['num']
			);
		}
	}
	return $virtual_goods;
}

/**
 *
 * 是否存在规格
 *
 * @access public
 * @param array $goods_attr_id_array
 *        	一维数组
 *
 * @return string
 */
function is_spec($goods_attr_id_array, $sort = 'asc') {
	$dbview = RC_Model::model('goods/sys_attribute_viewmodel');

	if (empty ( $goods_attr_id_array )) {
		return $goods_attr_id_array;
	}

	// 重新排序
	$row = $dbview->join ( 'goods_attr' )->in ( array ('v.goods_attr_id' => $goods_attr_id_array) )->order ( array ('a.attr_id' => $sort) )->select ();

	$return_arr = array ();
	foreach ( $row as $value ) {
		$return_arr ['sort'] [] = $value ['goods_attr_id'];
		$return_arr ['row'] [$value ['goods_attr_id']] = $value;
	}

	if (! empty ( $return_arr )) {
		return true;
	} else {
		return false;
	}
}

/**
 * 取得商品最终使用价格
 *
 * @param string $goods_id
 *        	商品编号
 * @param string $goods_num
 *        	购买数量
 * @param boolean $is_spec_price
 *        	是否加入规格价格
 * @param mix $spec
 *        	规格ID的数组或者逗号分隔的字符串
 *
 * @return 商品最终购买价格
 */
function get_final_price($goods_id, $goods_num = '1', $is_spec_price = false, $spec = array(), $warehouse_id = 0, $area_id = 0) {
	$dbview = RC_Model::model('goods/sys_goods_member_viewmodel');
	RC_Loader::load_app_func('admin_goods', 'goods');

	$final_price = '0'; // 商品最终购买价格
	$volume_price = '0'; // 商品优惠价格
	$promote_price = '0'; // 商品促销价格
	$user_price = '0'; // 商品会员价格

	// 取得商品优惠价格列表
	$price_list = get_volume_price_list ( $goods_id, '1' );

	if (! empty ( $price_list )) {
		foreach ( $price_list as $value ) {
			if ($goods_num >= $value ['number']) {
				$volume_price = $value ['price'];
			}
		}
	}
	// 取得商品促销价格列表
	$goods = $dbview->join ( 'member_price' )->find (array('g.goods_id' => $goods_id, 'g.is_delete' => 0));
	/* 计算商品的促销价格 */
	if ($goods ['promote_price'] > 0) {
		$promote_price = bargain_price ( $goods ['promote_price'], $goods ['promote_start_date'], $goods ['promote_end_date'] );
	} else {
		$promote_price = 0;
	}

	// 取得商品会员价格列表
	$user_price = $goods ['shop_price'];

	// 比较商品的促销价格，会员价格，优惠价格
	if (empty ( $volume_price ) && empty ( $promote_price )) {
		// 如果优惠价格，促销价格都为空则取会员价格
		$final_price = $user_price;
	} elseif (! empty ( $volume_price ) && empty ( $promote_price )) {
		// 如果优惠价格为空时不参加这个比较。
		$final_price = min ( $volume_price, $user_price );
	} elseif (empty ( $volume_price ) && ! empty ( $promote_price )) {
		// 如果促销价格为空时不参加这个比较。
		$final_price = min ( $promote_price, $user_price );
	} elseif (! empty ( $volume_price ) && ! empty ( $promote_price )) {
		// 取促销价格，会员价格，优惠价格最小值
		$final_price = min ( $volume_price, $promote_price, $user_price );
	} else {
		$final_price = $user_price;
	}
	/* 手机专享*/
	$mobilebuy_db = RC_Model::model('goods/goods_activity_model');
	$mobilebuy_ext_info = array('price' => 0);
	$mobilebuy = $mobilebuy_db->find(array(
		'goods_id'	 => $goods_id,
		'start_time' => array('elt' => RC_Time::gmtime()),
		'end_time'	 => array('egt' => RC_Time::gmtime()),
		'act_type'	 => GAT_MOBILE_BUY,
	));
	if (!empty($mobilebuy)) {
		$mobilebuy_ext_info = unserialize($mobilebuy['ext_info']);
	}
	$final_price =  ($final_price > $mobilebuy_ext_info['price'] && !empty($mobilebuy_ext_info['price'])) ? $mobilebuy_ext_info['price'] : $final_price;

	// 如果需要加入规格价格
	if ($is_spec_price) {
		if (! empty ( $spec )) {
			$spec_price = spec_price ( $spec );
			$final_price += $spec_price;
		}
	}
	// 返回商品最终购买价格
	return $final_price;
}

/**
 * 格式化重量：小于1千克用克表示，否则用千克表示
 *
 * @param float $weight
 *        	重量
 * @return string 格式化后的重量
 */
function formated_weight($weight) {
	$weight = round(floatval($weight), 3);
	if ($weight > 0) {
		if ($weight < 1) {
			/* 小于1千克，用克表示 */
			return intval($weight * 1000) . RC_Lang::get('goods::goods.gram');
		} else {
			/* 大于1千克，用千克表示 */
			return $weight . RC_Lang::get('goods::goods.kilogram');
		}
	} else {
		return 0;
	}
}

/**
 * 获得指定礼包的商品
 *
 * @access public
 * @param integer $package_id
 * @return array
 */
function get_package_goods($package_id) {
	if ($package_id == 0) {
		$where = " AND pg.admin_id = '$_SESSION[admin_id]'";
	}
	$resource = RC_DB::table('package_goods as pg')
		->leftJoin('goods as g', RC_DB::raw('g.goods_id'), '=', RC_DB::raw('pg.goods_id'))
		->leftJoin('products as p', RC_DB::raw('pg.product_id'), '=', RC_DB::raw('p.product_id'))
		->selectRaw('pg.goods_id, g.goods_name, pg.goods_number, p.goods_attr, p.product_number, p.product_id')
		->whereRaw('pg.package_id = '.$package_id.''.$where)
		->get();

	if (!$resource) {
		return array();
	}
	$row = array();
	/* 生成结果数组 取存在货品的商品id 组合商品id与货品id */
	$good_product_str = '';

	if (! empty ( $resource )) {
		foreach ( $resource as $_row ) {
			if ($_row ['product_id'] > 0) {
				/* 取存商品id */
				$good_product_str .= ',' . $_row ['goods_id'];

				/* 组合商品id与货品id */
				$_row ['g_p'] = $_row ['goods_id'] . '_' . $_row ['product_id'];
			} else {
				/* 组合商品id与货品id */
				$_row ['g_p'] = $_row ['goods_id'];
			}
			 
			// 生成结果数组
			$row [] = $_row;
		}
	}
	$good_product_str = trim ( $good_product_str, ',' );

	/* 释放空间 */
	unset ( $resource, $_row, $sql );

	/* 取商品属性 */
	if ($good_product_str != '') {
		$result_goods_attr = RC_DB::table('goods_attr')->select('goods_attr_id', 'attr_value')->whereIn('goods_id', $good_product_str)->get();

		$_goods_attr = array ();
		foreach ( $result_goods_attr as $value ) {
			$_goods_attr [$value ['goods_attr_id']] = $value ['attr_value'];
		}
	}
	/* 过滤货品 */
	$format [0] = '%s[%s]';
	$format [1] = '%s';
	if (!empty($row)) {
		foreach ( $row as $key => $value ) {
			if ($value ['goods_attr'] != '') {
				$goods_attr_array = explode ( '|', $value ['goods_attr'] );

				$goods_attr = array ();
				foreach ( $goods_attr_array as $_attr ) {
					$goods_attr [] = $_goods_attr [$_attr];
				}

				$row [$key] ['goods_name'] = sprintf ( $format [0], $value ['goods_name'], implode ( '，', $goods_attr ));
			} else {
				$row [$key] ['goods_name'] = sprintf ( $format [1], $value ['goods_name']);
			}
		}
	}
	return $row;
}

/**
 * 获取审核状态
 */
function get_review_status($store_id) {
    $review_status = 1;
    if (ecjia::config('review_goods') == 0) {
        $review_status = 5;
    } else {
        if (isset($store_id) && $store_id > 0) {
            $shop_review_goods = RC_DB::table('merchants_config')->where('store_id', $store_id)->where('code', 'shop_review_goods')->pluck('value');
            if ($shop_review_goods == 0) {
                $review_status = 5;
            } else {
                $review_status = 1;
            }
        } else {
            $review_status = 5;
        }
    }
    return $review_status;
}

/**
 * 获得指定商品的相册
 *
 * @access public
 * @param integer $goods_id
 * @return array
 */
function get_goods_gallery_gol($goods_id) {
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

// end