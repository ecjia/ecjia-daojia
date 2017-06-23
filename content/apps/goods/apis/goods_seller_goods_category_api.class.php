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
 * 获取店铺商品商品分类
 * @author will.chen
 */
class goods_seller_goods_category_api extends Component_Event_Api {
    /**
     * @param  $options['keyword'] 关键字
     *         $options['cat_id'] 分类id
     *         $options['brand_id'] 品牌id
     *         $options['type']
     * @return array
     */
	public function call(&$options) {
		//接口商家我的宝贝商品分类
		if (isset($options['store_id']) && isset($options['type']) && $options['type'] == 'seller_goods_cat_list_api') {
			$row = $this->cat_list(0, 0, false, 0, true, $options['store_id'], 'seller_goods_cat_list_api', $options['keywords']);
		}
		//总后台商品应用中店铺商品分类
		if (isset($options['store_id']) && isset($options['type']) && $options['type'] == 'seller_goods_cat_list') {
			$row = $this->cat_list(0, 0, false, 0, true, $options['seller_id']);
		}
		//总后台店铺商品分类编辑页
		if (isset($options['parent_id']) && isset($options['store_id']) && isset($options['type']) && ($options['type'] == 'edit')) {
			$row = $this->cat_list(0, $options['parent_id'], true, 0, true, $options['store_id']);
		}
		//总后台店铺商品分类更新
		if (isset($options['cat_id']) && isset($options['store_id']) && isset($options['type']) && $options['type'] == 'update') {
			$row = $this->cat_list($options['cat_id'], 0, false, 0, true, $options['store_id']);
		}
		//商家商品分类
		if (isset($options['cat_id']) && isset($options['store_id']) && isset($options['type']) && $options['type'] == 'seller_goods_cat') {
			$level = empty($options['level']) ? 0 : $options['level'];
		    $row = $this->cat_list($options['cat_id'], 0, false, $level, true, $options['store_id'], 'show');
		}
	    return $row;
	}

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
	 * @param int $is_show_all
	 *        	如果为true显示所有分类，如果为false隐藏不可见分类。
	 * @return mix
	 */
	function cat_list($cat_id = 0, $selected = 0, $re_type = true, $level = 0, $is_show_all = true, $seller_id, $type='', $keywords) {
		// 加载方法
		RC_Loader::load_app_func('global', 'goods');
		$db_goods = RC_Model::model('goods/goods_model');
		$db_category = RC_Model::model('goods/merchants_category_viewmodel');
		$db_goods_cat = RC_Model::model('goods/goods_cat_viewmodel');

		static $res = NULL;

		if ($res === NULL) {
			$data = false;
			if ($data === false) {
				//商户商品分类
                $where = array('c.store_id' => $seller_id);
                if (!empty($type)) {
					$where['c.is_show'] = 1;
				}
                $field = 'c.cat_id, c.cat_name, c.cat_image, c.parent_id, c.is_show, c.sort_order, COUNT(s.cat_id) AS has_children';
                $res = $db_category->join(array('merchants_category'))->field($field)->where($where)->group('c.cat_id')->order(array('c.parent_id' => 'asc', 'c.sort_order' => 'asc'))->select();

    			$res2 = RC_DB::table('goods')->selectRaw('cat_id, COUNT(*) as goods_num')->where('is_delete', 0)->where('is_on_sale', 1)->groupBy('cat_id')->get();

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

		$options = $this->cat_options ($cat_id, $res); // 获得指定分类下的子分类的数组

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
	 * 过滤和排序所有分类，返回一个带有缩进级别的数组
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
	function cat_options($spec_cat_id, $arr) {
		static $cat_options = array ();

		if (isset ($cat_options[$spec_cat_id])) {
			return $cat_options[$spec_cat_id];
		}

		if (!isset($cat_options[0])) {
			$level = $last_cat_id = 0;
			$options = $cat_id_array = $level_array = array ();
			$data = false;
			if ($data === false) {
				while (!empty($arr)) {
					foreach ( $arr as $key => $value ) {
						$cat_id = $value['cat_id'];
						if ($level == 0 && $last_cat_id == 0) {
							if ($value ['parent_id'] > 0) {
								break;
							}

							$options[$cat_id] = $value;
							$options[$cat_id]['level'] = $level;
							$options[$cat_id]['id'] = $cat_id;
							$options[$cat_id]['name'] = $value['cat_name'];
							unset($arr[$key]);
							if (isset($value['has_children'])) {
								if ($value ['has_children'] == 0) {
									continue;
								}
							}
							$last_cat_id = $cat_id;
							$cat_id_array = array (
									$cat_id
							);
							$level_array[$last_cat_id] = ++ $level;
							continue;
						}

						if ($value['parent_id'] == $last_cat_id) {
							$options [$cat_id] = $value;
							$options [$cat_id] ['level'] = $level;
							$options [$cat_id] ['id'] = $cat_id;
							$options [$cat_id] ['name'] = $value ['cat_name'];
							unset ( $arr [$key] );
							if (isset($value ['has_children'])) {
								if ($value ['has_children'] > 0) {
									if (end ( $cat_id_array ) != $last_cat_id) {
										$cat_id_array [] = $last_cat_id;
									}
									$last_cat_id = $cat_id;
									$cat_id_array [] = $cat_id;
									$level_array [$last_cat_id] = ++ $level;
								}
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
			} else {
				$options = $data;
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
			$cat_options[$spec_cat_id] = $spec_cat_id_array;

			return $spec_cat_id_array;
		}
	}
}

// end