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
 * 文章分类类
 */
class article_cat {
	/**
	 * 获得指定分类下的子分类的数组
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
	 * @param int $cat_type
	 *        	文章分类类型。article普通分类，2系统保留分类，3网店信息分类，4网店帮助分类，5网店帮助下的分类，6商家公告
	 * @return mix
	 */
	public static function article_cat_list($cat_id = 0, $selected = 0, $re_type = true, $level = 0, $cat_type = 0) {
		$db_article = RC_DB::table('article_cat as c')
			->leftJoin('article_cat as s', RC_DB::raw('s.parent_id'), '=', RC_DB::raw('c.cat_id'))
			->leftJoin('article as a', RC_DB::raw('a.cat_id'), '=', RC_DB::raw('c.cat_id'));
		if (!empty($cat_type)) {
			$db_article->where(RC_DB::raw('c.cat_type'), $cat_type);
		}
		
		$res = $db_article
			->select(RC_DB::raw('c.*'), RC_DB::raw('COUNT(s.cat_id) as has_children'), RC_DB::raw('COUNT(a.article_id) as article_num'))
			->whereNotIn(RC_DB::raw('c.parent_id'), array(1,2,3))
			->groupby(RC_DB::raw('c.cat_id'))
			->orderby('parent_id', 'asc')
			->orderby('sort_order', 'asc')
			->get();
		
		if (empty($res) == true) {
			return $re_type ? '' : array ();
		}
		$options = self::article_cat_options($cat_id, $res); // 获得指定分类下的子分类的数组
	
		/* 截取到指定的缩减级别 */
		if ($level > 0) {
			if ($cat_id == 0) {
				$end_level = $level;
			} else {
				$first_item = reset ( $options ); // 获取第一个元素
				$end_level  = $first_item['level'] + $level;
			}
	
			/* 保留level小于end_level的部分 */
			foreach ($options as $key => $val ) {
				if ($val['level'] >= $end_level) {
					unset ( $options[$key] );
				}
			}
		}
		$pre_key = 0;
		if (! empty ( $options )) {
			foreach ( $options as $key => $value ) {
				$options[$key]['has_children'] = 1;
				if ($pre_key > 0) {
					if ($options[$pre_key]['cat_id'] == $options[$key]['parent_id']) {
						$options[$pre_key]['has_children'] = 1;
					}
				}
				$pre_key = $key;
			}
		}
		if ($re_type == true) {
			$select = '';
			foreach ( $options as $var ) {
				$select .= '<option value="' . $var['cat_id'] . '" ';
				$select .= ' cat_type="' . $var['cat_type'] . '" ';
				$select .= ($selected == $var['cat_id']) ? "selected='ture'" : '';
				$select .= '>';
				if ($var['level'] > 0) {
					$select .= str_repeat ( '&nbsp;', $var['level'] * 4 );
				}
				$select .= htmlspecialchars ( addslashes ( $var['cat_name'] ) ) . '</option>';
			}
	
			return $select;
		} else {
			if (!empty($options)) {
				foreach($options as $key => $value) {
					$options[$key]['url'] = build_uri('article_cat', array ('acid' => $value['cat_id']), $value['cat_name'] );
				}
			}
			return $options;
		}
	}

	/**
	 * 过滤和排序所有文章分类，返回一个带有缩进级别的数组
	 *
	 * @access private
	 * @param int $cat_id
	 *        	上级分类ID
	 * @param array $arr
	 *        	含有所有分类的数组
	 * @param int $level
	 *        	级别
	 * @return void
	 */
	public static function article_cat_options($spec_cat_id, $arr) {
		static $cat_options = array ();
	
		if (isset ( $cat_options [$spec_cat_id] )) {
			return $cat_options [$spec_cat_id];
		}
		if (!isset ( $cat_options [0] )) {
			$level = $last_cat_id = 0;
			$options = $cat_id_array = $level_array = array ();
			while ( ! empty ( $arr ) ) {
				foreach ( $arr as $key => $value ) {
					$cat_id = $value ['cat_id'];
					if ($level == 0 && $last_cat_id == 0) {
						if ($value ['parent_id'] > 0) {
							break;
						}
	
						$options [$cat_id] = $value;
						$options [$cat_id] ['level'] = $level;
						$options [$cat_id] ['id'] = $cat_id;
						$options [$cat_id] ['name'] = $value ['cat_name'];
						unset ( $arr [$key] );
	
						if ($value ['has_children'] == 0) {
							continue;
						}
						$last_cat_id = $cat_id;
						$cat_id_array = array (
								$cat_id
						);
						$level_array [$last_cat_id] = ++ $level;
						continue;
					}
	
					if ($value ['parent_id'] == $last_cat_id) {
						$options [$cat_id] = $value;
						$options [$cat_id] ['level'] = $level;
						$options [$cat_id] ['id'] = $cat_id;
						$options [$cat_id] ['name'] = $value ['cat_name'];
						unset ( $arr [$key] );
	
						if ($value ['has_children'] > 0) {
							if (end ( $cat_id_array ) != $last_cat_id) {
								$cat_id_array [] = $last_cat_id;
							}
							$last_cat_id = $cat_id;
							$cat_id_array [] = $cat_id;
							$level_array [$last_cat_id] = ++ $level;
						}
					} elseif ($value ['parent_id'] > $last_cat_id) {
						break;
					}
				}
	
				$count = count ( $cat_id_array );
				if ($count > 1) {
					$last_cat_id = array_pop ( $cat_id_array );
				} elseif ($count == 1) {
					if ($last_cat_id != end ( $cat_id_array )) {
						$last_cat_id = end ( $cat_id_array );
					} else {
						$level = 0;
						$last_cat_id = 0;
						$cat_id_array = array ();
						continue;
					}
				}
	
				if ($last_cat_id && isset ( $level_array [$last_cat_id] )) {
					$level = $level_array [$last_cat_id];
				} else {
					$level = 0;
				}
			}
			$cat_options [0] = $options;
		} else {
			$options = $cat_options [0];
		}
	
		if (! $spec_cat_id) {
			return $options;
		} else {
			if (empty ( $options [$spec_cat_id] )) {
				return array ();
			}
	
			$spec_cat_id_level = $options [$spec_cat_id] ['level'];
	
			foreach ( $options as $key => $value ) {
				if ($key != $spec_cat_id) {
					unset ( $options [$key] );
				} else {
					break;
				}
			}
	
			$spec_cat_id_array = array ();
			foreach ( $options as $key => $value ) {
				if (($spec_cat_id_level == $value ['level'] && $value ['cat_id'] != $spec_cat_id) || ($spec_cat_id_level > $value ['level'])) {
					break;
				} else {
					$spec_cat_id_array [$key] = $value;
				}
			}
			$cat_options [$spec_cat_id] = $spec_cat_id_array;
			return $spec_cat_id_array;
		}
	}
	
	/**
	 * 获得指定文章分类下所有底层分类的ID
	 *
	 * @access public
	 * @param integer $cat 指定的分类ID
	 * @return void
	 */
	public static function get_article_children($cat = 0) {
		return self::db_create_in(array_unique(array_merge(array($cat), array_keys(self::article_cat_list($cat, 0, false)))), 'cat_id');
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
	public static function db_create_in($item_list, $field_name = '') {
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
	 * 获得指定文章分类下所有底层分类的ID数组
	 *
	 * @access public
	 * @param integer $cat 指定的分类ID
	 * @return array
	 */
	public static function get_children_list($cat = 0) {
		return array_unique(array_merge(array($cat), array_keys(self::article_cat_list($cat, 0, false))));
	}
}

// end