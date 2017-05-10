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
 * 商品列表相关处理类
 * @author will.chen
 */
class goods_list {

	private static $keywords_where;
	/* 初始化搜索条件 */
	public static function get_keywords_where($keyword) {

		$keywords = '';
		$tag_where = '';
		if (!empty($keyword)) {
			$arr = array();
			if (stristr($keyword, ' AND ') !== false) {
				/* 检查关键字中是否有AND，如果存在就是并 */
				$arr = explode('AND', $keyword);
				$operator = " AND ";
			} elseif (stristr($keyword, ' OR ') !== false) {
				/* 检查关键字中是否有OR，如果存在就是或 */
				$arr = explode('OR', $keyword);
				$operator = " OR ";
			} elseif (stristr($keyword, ' + ') !== false) {
				/* 检查关键字中是否有加号，如果存在就是或 */
				$arr = explode('+', $keyword);
				$operator = " OR ";
			} else {
				/* 检查关键字中是否有空格，如果存在就是并 */
				$arr = explode(' ', $keyword);
				$operator = " AND ";
			}

			$keywords = '(';
			$goods_ids = array();
			if (!empty($arr)) {
				$db_keywords = RC_Model::model('goods/keywords_model');
				foreach ($arr as $key => $val) {
					if ($key > 0 && $key < count($arr) && count($arr) > 1) {
						$keywords .= $operator;
					}
					$val = mysql_like_quote(trim($val));
					$keywords .= "(goods_name LIKE '%$val%' OR goods_sn LIKE '%$val%' OR keywords LIKE '%$val%')";
					//插入keywords表数据 will.chen
					$count = $db_keywords->where(array('date' => RC_Time::local_date('Y-m-d'), 'keyword'=>addslashes(str_replace('%', '', $val))))->get_field('count');
					if (!empty($count) && $count > 0) {
						$db_keywords->where(array('date'=>RC_Time::local_date('Y-m-d'),'keyword'=>addslashes(str_replace('%', '', $val))))->update(array('count' => $count + 1));
					} else {
						$data = array(
								'date' => RC_Time::local_date('Y-m-d'),
								'searchengine' => 'ecjia',
								'count'=> '1',
								'keyword' => addslashes(str_replace('%', '', $val)));
						$db_keywords->insert($data);
					}
				}
			}
			$keywords .= ')';
		}
		self::$keywords_where['keywords']	= $keywords;
		return true;
	}


	/**
	 * 取得商品列表
	 * @param   object  $filters    过滤条件
	 */
	public static function get_goods_list($filter) {
		RC_Loader::load_app_class('goods_category', 'goods', false);
		$dbview = RC_Model::model('goods/goods_member_viewmodel');
		$dbview->view = array(
			'store_franchisee' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'sf',
				'on' 	=> "g.store_id = sf.store_id"
			),
			'member_price' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'mp',
				'on' 	=> "mp.goods_id = g.goods_id and mp.user_rank = '".$_SESSION['user_rank']."'"
			)
		);
		$field = "g.goods_id, g.goods_name, g.store_id, g.goods_name_style, g.market_price,
				  g.is_new, g.is_best, g.is_hot, g.shop_price AS org_price, 
				  IFNULL(mp.user_price, g.shop_price * ".$_SESSION['discount'].") AS shop_price, 
				  g.promote_price, g.goods_type, g.promote_start_date, g.promote_end_date,
				  g.goods_brief, g.goods_thumb, g.original_img, g.goods_img,
				  sf.merchants_name,sf.manage_mode";
		$where = array(
		    'is_on_sale'	=> 1,
		    'is_alone_sale' => 1,
		    'is_delete'		=> 0,
			'shop_close'	=> 0,
		);
		
		/* 商品列表缓存key*/
		$cache_key = 'goods-list-'. $_SESSION['user_rank'];
		
		/* 分类条件*/
		if (isset($filter['cat_id']) && !empty($filter['cat_id'])) {
			$key = 'category-children-'.$filter['cat_id'];
			$category_children_cachekey = sprintf('%X', crc32($key));
			$children = RC_Cache::app_cache_get($category_children_cachekey, 'goods');
			if (empty($children)) {
				$children = goods_category::get_children($filter['cat_id']);
				RC_Cache::app_cache_set($category_children_cachekey, $children, 'goods');
			}
			$cache_key .= '-cat-' . $filter['cat_id'];
		}
		
		/* 店铺条件*/
		if (isset($filter['store_id']) && !empty($filter['store_id'])) {
			$where['g.store_id'] = $filter['store_id'];
			/* 缓存对象*/
			if (is_array($filter['store_id'])) {
				foreach ($filter['store_id'] as $v) {
					$cache_key .= '-store-' . $v;
				}
			} else {
				$cache_key .= '-store-' . $filter['store_id'];
			}
		}
		 
		/* 地理位置获取店铺*/
		if (isset($filter['geohash']) && !empty($filter['geohash'])) {
	        $store_id_group = RC_Api::api('store', 'neighbors_store_id', array('geohash' => $filter['geohash']));
// 	        if (empty($store_id_group)) {
// 	            $store_id_group = RC_Api::api('store', 'neighbors_store_id', array('geohash' => substr($filter['geohash'], 0, 4)));
// 	        }
	        $where['g.store_id'] = !empty($store_id_group) ? $store_id_group : 0;
	        $cache_key .= '-geohash-' . $filter['geohash'];
		}
		
		/* 城市id */
		if (isset($filter['city_id'])) {
			$where['sf.city'] = $filter['city_id'];
			$cache_key .= '-city-' . $filter['city_id'];
		}
		
		if (isset($filter['merchant_cat_id']) && !empty($filter['merchant_cat_id']) && isset($filter['store_id']) && !empty($filter['store_id']) ) {
		    $merchant_cat_list = RC_DB::table('merchants_category')
		    	->selectRaw('cat_id')
			    ->where('parent_id', $filter['merchant_cat_id'])
			    ->where('store_id', $filter['store_id'])
			    ->where('is_show', 1)
			    ->get();
		    $children_cat = "'".$filter['merchant_cat_id']."'";
		    if ($merchant_cat_list) {
		        foreach ($merchant_cat_list as $cat) {
		            $children_cat .= ",'".$cat['cat_id']."'";
		        }
		    }

		    $where[] = "merchant_cat_id IN (" . $children_cat.")";
		    $cache_key .= '-merchant_cat_id-' . $filter['merchant_cat_id'];
		}


    	$where['g.review_status'] = array('gt' => 2);

		if (!empty($children)) {
			$where[] = "(". $children ." OR ".goods_category::get_extension_goods($children).")";
		}
		
		if (isset($filter['brand']) && $filter['brand'] > 0) {
			$where['brand_id'] = $filter['brand'];
			$cache_key .= '-brand-' . $filter['brand'];
		}
		if (isset($filter['min']) && $filter['min'] > 0) {
			$where[] = "shop_price >= ".$filter['min'];
			$cache_key .= '-min-' . $filter['min'];
		}
		if (isset($filter['max']) && $filter['max'] > 0) {
			$where[] = "shop_price <= ".$filter['max'];
			$cache_key .= '-max-' . $filter['max'];
		}

		if (isset(self::$keywords_where['keywords']) && !empty(self::$keywords_where['keywords']) && isset($filter['keywords']) && !empty($filter['keywords'])) {
			$where[] = self::$keywords_where['keywords'];
			$cache_key .= '-keywords-' . $filter['keywords'];
		}

		if (!empty($filter['intro'])) {
			if (in_array($filter['intro'], array('best', 'new', 'hot', 'promotion'))) {
				$cache_key .= '-intro-' . $filter['intro'];
			}
			
			switch ($filter['intro']) {
				case 'best':
					$where['g.is_best'] = 1;
					break;
				case 'new':
					$where['g.is_new'] = 1;
					break;
				case 'hot':
					$where['g.is_hot'] = 1;
					break;
				case 'promotion':
					$time    = RC_Time::gmtime();
					$where['g.promote_price']		= array('gt' => 0);
					$where['g.promote_start_date']	= array('elt' => $time);
					$where['g.promote_end_date']	= array('egt' => $time);
					break;
				default:
			}
		}

		if (isset($filter['store_intro']) && !empty($filter['store_intro'])) {
			if (in_array($filter['store_intro'], array('best', 'new', 'hot', 'promotion'))) {
				$cache_key .= '-store_intro-' . $filter['store_intro'];
			}
			switch ($filter['store_intro']) {
				case 'best':
					$where['g.store_best'] = 1;
					break;
				case 'new':
					$where['g.store_new'] = 1;
					break;
				case 'hot':
					$where['g.store_hot'] = 1;
					break;
				case 'promotion':
					$time    = RC_Time::gmtime();
					$where['g.promote_price']		= array('gt' => 0);
					$where['g.promote_start_date']	= array('elt' => $time);
					$where['g.promote_end_date']	= array('egt' => $time);
					break;
				default:

			}
		}

		/* 扩展商品查询条件 */
		if (!empty($filter['filter_attr'])) {
			$cat = goods_category::get_cat_info($filter['cat_id']);
			$cat_filter_attr = explode(',', $cat['filter_attr']);       //提取出此分类的筛选属性
			$ext_group_goods = array();
			$db_goods_attr_view = RC_Model::model('goods/goods_attr_viewmodel');
			$db_goods_attr_view->view = array(
				'goods_attr' => array(
					'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
					'alias'		=> 'b',
					'on'		=> 'b.attr_value = ga.attr_value'
				)
			);
			/* 查出符合所有筛选属性条件的商品id */
			foreach ($filter['filter_attr'] AS $k => $v) {
				$goods_ids = array();
				if (is_numeric($v) && $v !=0 && isset($cat_filter_attr[$k])) {
					$ext_group_goods = $db_goods_attr_view->field(array('DISTINCT(b.goods_id) as goods_id'))->join(array('goods_attr'))->where(array('b.attr_id' => $cat_filter_attr[$k], 'ga.goods_attr_id' => $v))->select();

					if (!empty($ext_group_goods)) {
						foreach ($ext_group_goods as $val) {
							$goods_ids[] = $val['goods_id'];
						}
					}
					$where[] = self::db_create_in($goods_ids, 'g.goods_id');
				}
			}
			$cache_key .= '-filter_attr-' . $filter['filter_attr'];
		}

		if (!empty($filter['size']) && !empty($filter['page'])) {
			$cache_key .= '-page-' . $filter['page'] . '-size-'. $filter['size'];
		}
		
		if (isset($filter['sort']) && !empty($filter['sort'])) {
			foreach ($filter['sort'] as $key => $val) {
				$cache_key .= '-' . $key . '-' . $val;
			}
		} else {
			$filter['sort'] = array('g.store_sort_order' => 'ASC');
		}
		$goods_db = RC_Model::model('goods/orm_goods_model');
		/* 储存商品列表缓存key*/
		$fomated_cache_key = $goods_db->create_cache_key_array($cache_key, 2880);
		
		$goods_result = $goods_db->get_cache_item($fomated_cache_key);
		
		if (empty($goods_result['list'])) {
			/* 返回商品总数 */
			$count = $dbview->join(array('store_franchisee'))->where($where)->count();
			
			//实例化分页
			if (empty($filter['size']) && empty($filter['page'])) {
				$page_row = new ecjia_page($count, 20, 6, '', 1);
				$limit = null;
			} else {
				$page_row = new ecjia_page($count, $filter['size'], 6, '', $filter['page']);
					
				$limit = $page_row->limit();
			}
			
			$data = $dbview->join(array('member_price', 'store_franchisee'))->field($field)->where($where)->order($filter['sort'])->limit($limit)->select();
			
			$arr = array();
			if (!empty($data)) {
				RC_Loader::load_app_func('admin_goods', 'goods');
				foreach ($data as $key => $row) {
					if ($row['promote_price'] > 0) {
						$promote_price = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
					} else {
						$promote_price = 0;
					}
					if ($filter['display'] == 'grid') {
						$arr[$key]['goods_name'] = ecjia::config('goods_name_length') > 0 ? RC_String::sub_str($row['goods_name'], ecjia::config('goods_name_length')) : $row['goods_name'];
					} else {
						$arr[$key]['goods_name'] = $row['goods_name'];
					}
			
					$arr[$key]['goods_id']		= $row['goods_id'];
					$arr[$key]['name']			= $row['goods_name'];
					$arr[$key]['goods_brief'] 	= $row['goods_brief'];
					$arr[$key]['store_id']		= $row['store_id'];
					$arr[$key]['store_name']	= $row['merchants_name'];
					$arr[$key]['manage_mode']	= $row['manage_mode'];
					/* 增加商品样式*/
					$arr[$key]['goods_style_name'] = add_style($row['goods_name'], $row['goods_name_style']);
					$arr[$key]['market_price']	= $row['market_price'] > 0 ? price_format($row['market_price']) : 0;
					$arr[$key]['shop_price']	= $row['shop_price'] > 0 ? price_format($row['shop_price']) : RC_Lang::get('goods::goods.free');
					$arr[$key]['type']			= $row['goods_type'];
					$arr[$key]['promote_price']	= ($promote_price > 0) ? price_format($promote_price) : '';
					//增加促销时间
					$arr[$key]['promote_start_date']=  RC_Time::local_date('Y/m/d H:i:s O', $row['promote_start_date']);
					$arr[$key]['promote_end_date']	=  RC_Time::local_date('Y/m/d H:i:s O', $row['promote_end_date']);
			
					$arr[$key]['goods_thumb']	= !empty($row['goods_thumb']) ? RC_Upload::upload_url($row['goods_thumb']) : RC_Uri::admin_url('statics/images/nopic.png');
					$arr[$key]['original_img']	= !empty($row['original_img']) ? RC_Upload::upload_url($row['original_img']) : RC_Uri::admin_url('statics/images/nopic.png');
					$arr[$key]['goods_img']		= !empty($row['goods_img']) ? RC_Upload::upload_url($row['goods_img']) : RC_Uri::admin_url('statics/images/nopic.png');
					$arr[$key]['url'] 			= build_uri('goods', array('gid' => $row['goods_id']), $row['goods_name']);
			
					/* 增加返回原始未格式价格  will.chen*/
					$arr[$key]['unformatted_shop_price']	= $row['shop_price'];
					$arr[$key]['unformatted_promote_price'] = $promote_price;
					$arr[$key]['unformatted_market_price'] = $row['market_price'];
				}
			}
			$goods_result = array('list' => $arr, 'page' => $page_row);
			$goods_db->set_cache_item($fomated_cache_key, $goods_result, 2880);
		}
		
		return $goods_result;
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
	private function db_create_in($item_list, $field_name = '') {
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
}

// end