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
 * 检查商家分类是否已经存在
 *
 * @param   string      $cat_name       分类名称
 * @param   integer     $parent_cat     上级分类
 * @param   integer     $exclude        排除的分类ID
 *
 * @return  boolean
 */
function merchant_cat_exists($cat_name, $parent_cat, $exclude = 0) {
	return (RC_DB::table('merchants_category')
		->where('parent_id', $parent_cat)
		->where('cat_name', $cat_name)
		->where('cat_id', '!=', $exclude)
		->where('store_id', $_SESSION['store_id'])
		->count() > 0) ? true : false;
}

/**
 * 获得商家指定分类下的子分类的数组
 *
 * @access public
 * @param int $cat_id
 *        	分类的ID
 * @param int $selected
 *        	当前选中分类的ID
 * @param boolean $re_type
 *        	返回的类型: 值为真时返回下拉列表,否则返回数组
 * @param int $level
 *        	限定返回的级数。为0时返回所有级数
 * @param int $is_show_all
 *        	如果为true显示所有分类，如果为false隐藏不可见分类。
 * @return mix
 */
function merchant_cat_list($cat_id = 0, $selected = 0, $re_type = true, $level = 0, $is_show_all = true) {
	// 加载方法
	RC_Loader::load_app_func('admin_category', 'goods');
	static $res = NULL;
	if ($res === NULL) {
		$data = false;
		if ($data === false) {
			$res = RC_DB::table('merchants_category as c')
				->leftJoin('merchants_category as s', RC_DB::raw('c.cat_id'), '=', RC_DB::raw('s.parent_id'))
				->selectRaw('c.cat_id, c.cat_name, c.parent_id, c.is_show, c.sort_order, COUNT(s.cat_id) AS has_children')
				->groupBy(RC_DB::raw('c.cat_id'))
				->orderBy(RC_DB::raw('c.parent_id'), 'asc')->orderBy(RC_DB::raw('c.sort_order'), 'asc')
				->where(RC_DB::raw('c.store_id'), $_SESSION['store_id'])
				->get();
				
			$res2 = RC_DB::table('goods')
				->selectRaw('cat_id, COUNT(*) as goods_num')
				->where('is_delete', 0)
				->where('is_on_sale', 1)
				->groupBy('cat_id')
				->get();
				
			$res3 = RC_DB::table('goods_cat as gc')
				->leftJoin('goods as g', RC_DB::raw('g.goods_id'), '=', RC_DB::raw('gc.goods_id'))
				->where(RC_DB::raw('g.is_delete'), 0)->where(RC_DB::raw('g.is_on_sale'), 1)
				->groupBy(RC_DB::raw('gc.cat_id'))
				->get();
				
			$newres = array ();
			if (!empty($res2)) {
				foreach($res2 as $k => $v) {
					$newres [$v ['cat_id']] = $v ['goods_num'];
					if (!empty($res3)) {
						foreach ( $res3 as $ks => $vs ) {
							if ($v ['cat_id'] == $vs ['cat_id']) {
								$newres [$v ['cat_id']] = $v ['goods_num'] + $vs ['goods_num'];
							}
						}
					}
				}
			}
			if (! empty ( $res )) {
				foreach ( $res as $k => $v ) {
					$res [$k] ['goods_num'] = ! empty($newres [$v ['cat_id']]) ? $newres [$v['cat_id']] : 0;
				}
			}
				
		} else {
			$res = $data;
		}
	}
	if (empty ( $res ) == true) {
		return $re_type ? '' : array ();
	}

	$options = cat_options ( $cat_id, $res ); // 获得指定分类下的子分类的数组

	$children_level = 99999; // 大于这个分类的将被删除
	if ($is_show_all == false) {
		foreach ( $options as $key => $val ) {
			if ($val ['level'] > $children_level) {
				unset ( $options [$key] );
			} else {
				if ($val ['is_show'] == 0) {
					unset ( $options [$key] );
					if ($children_level > $val ['level']) {
						$children_level = $val ['level']; // 标记一下，这样子分类也能删除
					}
				} else {
					$children_level = 99999; // 恢复初始值
				}
			}
		}
	}

	/* 截取到指定的缩减级别 */
	if ($level > 0) {
		if ($cat_id == 0) {
			$end_level = $level;
		} else {
			$first_item = reset ( $options ); // 获取第一个元素
			$end_level = $first_item ['level'] + $level;
		}

		/* 保留level小于end_level的部分 */
		foreach ( $options as $key => $val ) {
			if ($val ['level'] >= $end_level) {
				unset ( $options [$key] );
			}
		}
	}

	if ($re_type == true) {
		$select = '';
		if (! empty ( $options )) {
			foreach ( $options as $var ) {
				$select .= '<option value="' . $var ['cat_id'] . '" ';
				$select .= ($selected == $var ['cat_id']) ? "selected='ture'" : '';
				$select .= '>';
				if ($var ['level'] > 0) {
					$select .= str_repeat ( '&nbsp;', $var ['level'] * 4 );
				}
				$select .= htmlspecialchars ( addslashes($var ['cat_name'] ), ENT_QUOTES ) . '</option>';
			}
		}
		return $select;
	} else {
		if (! empty($options )) {
			foreach ($options as $key => $value ) {
				$options [$key] ['url'] = build_uri ('category', array('cid' => $value ['cat_id']), $value ['cat_name']);
			}
		}
		return $options;
	}
}

/**
 * 获得商家指定分类下所有底层分类的ID
 *
 * @access public
 * @param integer $cat
 *        	指定的分类ID
 * @return string
 */
function merchant_get_children($cat = 0) {
	RC_Loader::load_app_func('global', 'goods');
	return 'g.merchant_cat_id ' . db_create_in (array_unique(array_merge(array($cat), array_keys(merchant_cat_list($cat, 0, false )))));
}

/**
 * 获得商家商品分类的所有信息
 *
 * @param   integer     $cat_id     指定的分类ID
 *
 * @return  mix
 */
function get_merchant_cat_info($cat_id) {
	$info = RC_DB::table('merchants_category')->where('cat_id', $cat_id)->where('store_id', $_SESSION['store_id'])->first();
	if (!empty($info['cat_image'])) {
	    $info['cat_image_base'] = $info['cat_image'];
	    $info['cat_image'] = RC_Upload::upload_url($info['cat_image']);
	}
	return $info;
}

/**
 * 添加商家商品分类
 *
 * @param   integer $cat_id
 * @param   array   $args
 *
 * @return  mix
 */
function merchant_cat_update($cat_id, $args) {
	if (empty($args) || empty($cat_id)) {
		return false;
	}
	return RC_DB::table('merchants_category')->where('cat_id', $cat_id)->where('store_id', $_SESSION['store_id'])->update($args);
}

/**
 * 添加商家链接
 * @param   string $extension_code 虚拟商品扩展代码，实体商品为空
 * @return  array('href' => $href, 'text' => $text)
 */
function add_merchant_link($extension_code = '') {
	$pathinfo = 'goods/merchant/add';
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
 * 获得商家指定的商品类型的详情
 *
 * @param   integer     $cat_id 分类ID
 *
 * @return  array
 */
function get_merchant_goods_type_info($cat_id) {
	return RC_DB::table('goods_type')->where('cat_id', $cat_id)->where('store_id', $_SESSION['store_id'])->first();
}

/**
 * 列表链接
 * @param   bool $is_add 是否添加（插入）
 * @param   string $extension_code 虚拟商品扩展代码，实体商品为空
 * @return  array('href' => $href, 'text' => $text)
 */
function list_merchant_link($extension_code = '') {
	$pathinfo = 'goods/merchant/init';
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
 * 获取商家品牌列表
 * @access  public
 * @return  array
 */
function get_merchants_brandlist() {
	$dbview = RC_Model::model('goods/merchants_shop_brand_viewmodel');
	$db = RC_Model::model('goods/brand_model');

	$keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
	$where = array();
	if ($keywords) {
		$where[] = "ssi.shop_name LIKE '%" . mysql_like_quote($keywords) . "%'";
	}
	$count = $dbview->where($where)->count();

	$page = new ecjia_page ($count, 10, 5);
	$field = 'mb.*, ssi.shop_name';

	$data = $dbview->field($field)->where($where)->order('sort_order asc')->limit($page->limit())->select();

	if (!empty($data)) {
		foreach ($data as $key => $val) {
			$data[$key]['shop_name'] = $val['shop_name'];
			$logo_url = RC_Upload::upload_url($val['brandLogo']);
			if (empty($val['brandLogo'])) {
				$logo_url = RC_Uri::admin_url('statics/images/nopic.png');
				$data[$key]['brandLogo'] = "<img src='" . $logo_url . "' style='width:100px;height:100px;' />";
			} else {
				$disk = RC_Filesystem::disk();
				$logo_url = $disk->exists(RC_Upload::upload_path($val['brandLogo'])) ? $logo_url : RC_Uri::admin_url('statics/images/nopic.png');
				$data[$key]['brandLogo'] = "<img src='" . $logo_url . "' style='width:100px;height:100px;' />";
			}
		}
	}
	return $data;
}

/**
 * 取得商家商品列表：用于把商品添加到组合、关联类、赠品类
 * @param   object  $filters    过滤条件
 */
function get_merchant_goods_list($filter) {
	$db = RC_Model::model('goods/goods_auto_viewmodel');
	$filter = (object)$filter;
	$filter->keyword = $filter->keyword;
	//TODO 过滤条件为对象获取方式，后期换回数组
	$where = get_merchant_where_sql($filter); // 取得过滤条件
	/* 取得数据 */
	$row = $db->join(null)->field('goods_id, goods_name, shop_price')->where($where)->limit(50)->select();
	return $row;
}

/**
 * 生成商家过滤条件：用于 get_goodslist 和 get_goods_list
 * @param   object  $filter
 * @return  string
 */
function get_merchant_where_sql($filter) {
	$time = date('Y-m-d');

	$where  = isset($filter->is_delete) && $filter->is_delete == '1' ?
	' is_delete = 1 ' : ' is_delete = 0 ';
	$where .= isset($filter->is_on_sale) && $filter->is_on_sale == '1' ?
	' AND is_on_sale = 1 ' : ' is_on_sale = 0 ';
	$where .= (isset($filter->real_goods) && ($filter->real_goods > -1)) ? ' AND is_real = ' . intval($filter->real_goods) : '';
	$where .= isset($filter->cat_id) && $filter->cat_id > 0 ? ' AND ' . merchant_get_children($filter->cat_id) : '';
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
	/*商家条件*/
	$where .= isset($filter->store_id) ? ' AND store_id = '.intval($filter->store_id) : '';
	return $where;
}

/**
 * 获得是否启用的商品类型列表
 *
 * @access  public
 * @param   integer     $selected   选定的类型编号
 * @param   boolean     $enabled    是否显示
 * @param   boolean     $show_all   是否显示平台规格
 * @return  string
 */
function goods_enable_type_list($selected, $enabled = false, $show_all = false) {
	$db_goods_type = RC_DB::table('goods_type')->where('store_id', $_SESSION['store_id']);

	if ($enabled) {
		$db_goods_type->where('enabled', 1);
	}

	if ($show_all) {
		//自营商家可以使用平台后台添加的商品规格
		$store_info = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->first();
		if ($store_info['manage_mode'] == 'self') {
			$db_goods_type->orWhere('store_id', 0);
		}
	}
	$data = $db_goods_type->select('cat_id', 'cat_name')->get();
	
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

/**
 * 获取审核状态
 */
function get_merchant_review_status() {
	$review_status = 1;
	if (ecjia::config('review_goods') == 0) {
		$review_status = 5;
	} else {
		if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
			$shop_review_goods = RC_DB::table('merchants_config')->where('store_id', $_SESSION['store_id'])->where('code', 'shop_review_goods')->pluck('value');
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

//end