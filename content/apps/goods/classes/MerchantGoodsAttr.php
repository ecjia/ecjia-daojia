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

namespace Ecjia\App\Goods;

use RC_DB;
use ecjia_merchant_page;
use RC_Uri;

defined('IN_ECJIA') or exit('No permission resources.');

class MerchantGoodsAttr {
	
	public function __construct()
	{
		
	}
	
	/**
	 * 获得商家商品[规格/参数]模板（列表下拉）--获取平台启用的
	 * @access  public
	 * @param   integer     $selected   选定的模板编号
	 * @param   string      $type       模板类型
	 * @param   boolean     $enabled    激活状态 
	 * @return  string
	 */
	public static function goods_type_list_select($selected, $type) {
		$data = RC_DB::table('goods_type')
		->whereIn('store_id', [0, $_SESSION['store_id']])
		->where('cat_type', $type)
		->select('cat_id', 'cat_name', 'store_id', 'enabled')
		->orderBy('store_id', 'desc')
		->get();
		
		$opt = '';
		if (!empty($data)) {
			foreach ($data as $row){
				if($row['store_id']===0 && $row['enabled']===0) {
					unset($row);
				} else {
					if($row['store_id']===0) {
						$title = ' [平台]';
					} else {
						$title = ' [商家]';
					}
					$opt .= "<option value='$row[cat_id]'";
					$opt .= ($selected == $row['cat_id']) ? ' selected="true"' : '';
					$opt .= '>' . htmlspecialchars($row['cat_name']). $title .'</option>';
				}
			}
		}
		return $opt;
	}
	
	
	/**
	 * 获得商家商品[规格/参数]模板 添加编辑属性（下拉）只允许读商家
	 * @access  public
	 * @param   integer     $selected   选定的模板编号
	 * @param   string      $type       模板类型
	 * @return  string
	 */
	public static function goods_type_add_select($selected, $type) {
		$data =  RC_DB::table('goods_type')
		->where('cat_type', $type)->where('store_id', $_SESSION['store_id'])->select('cat_id', 'cat_name')->get();
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
	 * 获得商家商品[规格/参数]模板列表数据
	 * @access  public
	 * @param   string $type 模板类型
	 */
	public static function get_merchant_goods_type_list($type) {
		$db_goods_type = RC_DB::table('goods_type as gt');
		
		$store_id = intval($_SESSION['store_id']);
		
		$db_goods_type->where(function ($query) use ($type) {
			$query->where('cat_type', $type)->orWhere(function ($query) {
				$query->whereNull('cat_type');
			});
		});
		
		$filter['keywords'] = !empty($_GET['keywords']) ? trim($_GET['keywords']) : '';
		if (!empty($filter['keywords'])) {
			$db_goods_type->where(RC_DB::raw('gt.cat_name'), 'like', '%'.mysql_like_quote($filter['keywords']).'%');
		}
		
		$type_count = $db_goods_type
		->select(RC_DB::raw('SUM(IF(gt.enabled = 1 and gt.store_id = 0, 1, 0)) as platform'),
				RC_DB::raw('SUM(IF(gt.store_id = ' . $store_id . ', 1, 0)) as merchant'))
				->first();
		
		$store_type = !empty($_GET['store_type']) ? trim($_GET['store_type']) : 0;
		if ($store_type == 1) {
			$db_goods_type->where(RC_DB::raw('gt.store_id'), 0);
			$db_goods_type->where(RC_DB::raw('gt.enabled'), 1);
		} else {
			$db_goods_type->where(RC_DB::raw('gt.store_id'), $store_id);
		}

		$count = $db_goods_type->count();
		$page = new ecjia_merchant_page($count, 15, 5);
	
		$field = 'gt.*, count(a.cat_id) as attr_count';
		$goods_type_list = $db_goods_type
		->leftJoin('attribute as a', RC_DB::raw('a.cat_id'), '=', RC_DB::raw('gt.cat_id'))
		->select(RC_DB::raw($field))
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
		return array('item' => $goods_type_list, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc(), 'type_count' => $type_count);
	}
	
	
	/**
	 * 获取商家[属性/参数]列表数据
	 *
	 * @return  array
	 */
	public static function get_merchant_attr_list() {
		$db_attribute = RC_DB::table('attribute as a');
		
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
		->select(RC_DB::raw('a.*, t.cat_name'))
		->orderby($filter['sort_by'], $filter['sort_order'])
		->take(15)->skip($page->start_id-1)->get();
	
		if (!empty($row)) {
			foreach ($row AS $key => $val) {
				$row[$key]['attr_input_type_desc'] = self::getAttrInputTypeLabel($val['attr_input_type']);
				$row[$key]['attr_values'] = str_replace("\n", ", ", $val['attr_values']);
			}
		}
		return array('item' => $row, 'page' => $page->show(5), 'desc' => $page->page_desc());
	}
	
	/**
	 * 平台获得指定的参数模板下的参数分组
	 *
	 * @param   integer     $cat_id     参数模板id
	 *
	 * @return  array
	 */
	public static function get_attr_groups($cat_id) {
		$data = RC_DB::table('goods_type')->where('cat_id', $cat_id)->pluck('attr_group');
		$grp = str_replace("\r", '', $data);
		if ($grp) {
			return explode("\n", $grp);
		} else {
			return array();
		}
	}
	
	//能否进行检索 数组
	public static function getAttrIndex() {
		$indexArr = [
		0 => __('不需要检索', 'goods'),
		1 => __('关键字检索', 'goods'),
		2 => __('范围检索', 'goods'),
		];
	
		return $indexArr;
	
	}
	
	//能否进行检索 名称
	public static function getAttrIndexLabel($indexValue) {
		$indexArr = self::getAttrIndex();
	
		if(! array_key_exists($indexValue, $indexArr)) {
			return __('未知', 'goods');
		}
	
		return array_get($indexArr, $indexValue);
	
	}
	
	//属性是否可选 数组
	public static function getAttrType() {
		$typeArr = [
		0 => __('唯一参数', 'goods'),
		2 => __('复选参数', 'goods'),
		];
	
		return $typeArr;
	
	}
	
	//属性是否可选 名称
	public static function getAttrTypeLabel($typeValue) {
		$typeArr = self::getAttrType();
	
		if(! array_key_exists($typeValue, $typeArr)) {
			return __('未知', 'goods');
		}
	
		return array_get($typeArr, $typeValue);
	
	}
	
	//属性值的录入方式 数组
	public static function getAttrInputType() {
		$typeArr = [
		ATTR_TEXT     => __('手工录入', 'goods'),
		ATTR_OPTIONAL => __('从下面的列表中选择（一行代表一个可选值）', 'goods'),
		ATTR_TEXTAREA => __('多行文本框', 'goods'),
		];
	
		return $typeArr;
	
	}
	
	//属性值的录入方式 名称
	public static function getAttrInputTypeLabel($inputTypeValue) {
		$typeArr = self::getAttrInputType();
		$typeArr[ATTR_OPTIONAL] = __('从列表中选择', 'goods');
	
		if(! array_key_exists($inputTypeValue, $typeArr)) {
			return __('未知', 'goods');
		}
	
		return array_get($typeArr, $inputTypeValue);
	
	}
	
	
	/**
	 * 商家商品分类绑定[规格/参数]模板包含平台数据（下拉）
	 * @access  public
	 * @param   integer     $selected   选定的模板编号
	 * @param   string      $type       模板类型
	 * @param   boolean     $enabled    激活状态
	 * @return  string
	 */
	public static function category_bind($selected, $type) {
		$data = RC_DB::table('goods_type')
			->whereIn('store_id', [0, $_SESSION['store_id']])
			->where('cat_type', $type)
			->where('enabled', 1)
			->select('cat_id', 'cat_name', 'store_id')
			->orderBy('store_id', 'desc')
			->get();
		
		$opt = '';
		if (!empty($data)) {
			foreach ($data as $row){
				if($row['store_id']===0) {
					$title = ' [平台]';
				} else {
					$title = ' [商家]';
				}
				$opt .= "<option value='$row[cat_id]'";
				$opt .= ($selected == $row['cat_id']) ? ' selected="true"' : '';
				$opt .= '>' . htmlspecialchars($row['cat_name']). $title .'</option>';
			}
		}
		return $opt;
	}
	
	/**
	 * 商家商品根据分类获取[规格/参数]模板
	 */
	public static function get_cat_template($type, $cat_id) {
		$template_id = 0;
		if ($type === 'parameter') {
			$template_id = RC_DB::table('merchants_category')->where('store_id', $_SESSION['store_id'])->where('cat_id', $cat_id)->pluck('parameter_id');
		} else {
			$template_id = RC_DB::table('merchants_category')->where('store_id', $_SESSION['store_id'])->where('cat_id', $cat_id)->pluck('specification_id');
		}
		if (empty($template_id)) {
			$category_info = RC_DB::table('merchants_category')->where('cat_id', $cat_id)->first();
			if ($category_info['parent_id'] > 0) {
				$template_id = self::get_cat_template($type, $category_info['parent_id']);
			}
		}
		return $template_id;
	}
	

	/**
	 * 获取[规格/参数]模板详细信息
	 * 
	 */
	public static function get_template_info($template_id) {
		$template_info = RC_DB::table('goods_type')->where('cat_id', $template_id)->first();
		
		return $template_info;
	}
	
	/**
	 * 根据参数类型数组创建属性的表单
	 * 
    */
	public static function build_parameter_html($cat_id, $goods_id = 0) {

		$attr = self::get_cat_attr_list($cat_id, $goods_id);
	
		$html = '';
		$spec = 0;
		if (!empty($attr)) {
			foreach ($attr as $key => $val) {
				$html .= "<div class='form-group'><label class='control-label col-lg-2'>";
				if ($val ['attr_input_type'] == 0) {//手工录入
					$html .= "$val[attr_name]</label><div class='col-lg-8'><input type='hidden' name='attr_id_list[]' value='$val[attr_id]' />";
					$html .= '<div class="col-lg-5 p_l0"><input class="form-control" name="'.$val[attr_id].'_attr_value_list" type="text" value="' . htmlspecialchars($val['attr_value'][0]) . '" size="40" /></div> ';
				} elseif ($val ['attr_input_type'] == 2) {//多行文本框
					$html .= "$val[attr_name]</label><div class='col-lg-8'><input type='hidden' name='attr_id_list[]' value='$val[attr_id]' />";
					$html .= '<div class="col-lg-5 p_l0"><textarea class="form-control" name="'.$val[attr_id].'_attr_value_list" rows="3" cols="40">' . htmlspecialchars($val['attr_value'][0]) . '</textarea></div>';
				} else {//从下面列表中选择
					if($val['attr_type'] == 2) {//复选属性checkbox
						$attr_values = explode("\n", $val['attr_values']);//模板中的复选框的值
						$html .= "$val[attr_name]</label><div class='col-lg-8'><input type='hidden' name='attr_id_list[]' value='$val[attr_id]' />";
						foreach ($attr_values as $opt) {
							$opt = trim(htmlspecialchars($opt));
							$html .= (in_array($opt, $val['attr_value'])) ? '<input id="'.$val[attr_id].$opt.'" type="checkbox" name="'.$val[attr_id].'_attr_value_list[]" checked="true" value="'. $opt .'" />' : '<input id="'.$val[attr_id].$opt.'" type="checkbox" name="'.$val[attr_id].'_attr_value_list[]" value="'. $opt .'" />';
							$html .= '<label for="'.$val[attr_id].$opt.'">'.$opt.'</label>';
						}
					} else {//唯一参数
						$attr_values = explode("\n", $val['attr_values']);
						$html .= "$val[attr_name]</label><div class='col-lg-8'><input type='hidden' name='attr_id_list[]' value='$val[attr_id]' />";
						$html .= '<div class="col-lg-5 p_l0"><select class="form-control" name="'.$val[attr_id].'_attr_value_list" autocomplete="off">';
						$html .= '<option value="">' . __('请选择...', 'goods') . '</option>';
						foreach ($attr_values as $opt) {
							$opt = trim(htmlspecialchars($opt));
							$html .= ($val['attr_value'][0] != $opt) ? '<option value="' . $opt . '">' . $opt . '</option>' : '<option value="' . $opt . '" selected="selected">' . $opt . '</option>';
						}
						$html .= '</select></div>';
					}
				}
				
				$html .= '</div></div>';
			}
		}
		$html .= '';
		return $html;
	}
	
	/**
	 * 根据规格类型数组创建参数的表单
	 *
	 */
	public static function build_specification_html($cat_id, $goods_id = 0) {
	
		$attr = self::get_cat_attr_list($cat_id, $goods_id);
		$html = '';
		$spec = 0;
		
		if (!empty($attr)) {
			foreach ($attr as $key => $val) {
				$html .= "<div class='form-group'><label class='control-label col-lg-2'>";
				$attr_values = explode("\n", $val['attr_values']);//模板中的复选框的值
				$attr_values = collect($attr_values)->filter()->all();
				$html .= "$val[attr_name]</label><div class='col-lg-8'><input type='hidden' name='attr_id_list[]' value='$val[attr_id]' />";
				foreach ($attr_values as $opt) {
					$html .= '<div class="check-box">';
					$opt = trim(htmlspecialchars($opt));
					$html .= (in_array($opt, $val['attr_value'])) ? '<input id="'.$val[attr_id].$opt.'" type="checkbox" name="'.$val[attr_id].'_attr_value_list[]" checked="true" value="'. $opt .'" />' : '<input id="'.$val[attr_id].$opt.'" type="checkbox" name="'.$val[attr_id].'_attr_value_list[]" value="'. $opt .'" />';
					$html .= '<label for="'.$val[attr_id].$opt.'">'.$opt.'</label>';
					$html .= '</div>';
				}
				$html .= '</div></div>';
			}
		}
		$html .= '';
		return $html;
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
	public static function get_cat_attr_list($cat_id, $goods_id = 0) {
		//商品绑定参数模板相关
		$row = RC_DB::table('attribute as a')
		->select(RC_DB::raw('a.attr_id'), RC_DB::raw('a.attr_name'), RC_DB::raw('a.attr_input_type'), RC_DB::raw('a.attr_type'), RC_DB::raw('a.attr_values'))
		->where(RC_DB::raw('a.cat_id'), $cat_id)
		->orderby(RC_DB::raw('a.attr_id'), 'asc')
		->get();
		
		foreach($row as $key => $val) {
			$row[$key]['attr_value'] = RC_DB::TABLE('goods_attr')->where('attr_id', $val['attr_id'])->where('goods_id', $goods_id)->lists('attr_value');
		}
		return $row;
	}
	
	/**
	 * 获得商品已添加的规格列表
	 *
	 * @access public
	 * @param
	 *            s integer $goods_id
	 * @return array
	 */
	public static function get_goods_spec_list($goods_id) {
		if (empty($goods_id)) {
			return array();
		}
		 
		return RC_DB::table('goods_attr as ga')
		->leftJoin('attribute as a', RC_DB::raw('a.attr_id'), '=', RC_DB::raw('ga.attr_id'))
		->where('goods_id', $goods_id)
		->where(RC_DB::raw('a.attr_type'), 1)
		->select(RC_DB::raw('ga.goods_attr_id, ga.attr_value, ga.attr_id, a.attr_name'))
		->orderBy(RC_DB::raw('ga.attr_id'), 'asc')
		->get();
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
	public static function check_goods_attr_exist($goods_attr, $goods_id, $product_id = 0) {
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
	 * 获得商品的货品列表
	 *
	 * @access public
	 * @param
	 *            s integer $goods_id
	 * @param
	 *            s string $conditions
	 * @return array
	 */
	public static function product_list($goods_id, $conditions = '') {
	
	
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
		->select(RC_DB::raw('product_id, goods_id, goods_attr as goods_attr_str, goods_attr, product_sn, product_number, product_shop_price, product_bar_code'))
		->whereRaw('goods_id = ' . $goods_id . $where)
		->orderBy($filter ['sort_by'], $filter['sort_order'])
		->get();
	
		/* 处理规格属性 */
		$goods_attr = self::product_goods_attr_list($goods_id);
		if (!empty ($row)) {
			foreach ($row as $key => $value) {
				$_goods_attr_array = explode('|', $value ['goods_attr']);
				if (is_array($_goods_attr_array)) {
					$_temp = [];
					foreach ($_goods_attr_array as $_goods_attr_value) {
						$attr_id = RC_DB::table('goods_attr')->where('goods_attr_id', $_goods_attr_value)->pluck('attr_id');
						$_temp[$attr_id] = $goods_attr[$_goods_attr_value];
					}
					ksort($_temp);
					$row[$key]['goods_attr'] = $_temp;
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
	 * 获得商品的规格属性值列表
	 *
	 * @access public
	 * @param
	 *            s integer $goods_id
	 * @return array
	 */
	public static function product_goods_attr_list($goods_id) {
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
	 * 获得返回不同商品的链接	 *
	 * @access public
	 * @param
	 *            s integer $goods_id
	 * @return array
	 */
	public static function goods_back_goods_url($action_type){
		if ($action_type == 'sale') {
			$href_link = RC_Uri::url('goods/merchant/init');
		} elseif ($action_type == 'finish') {
			$href_link = RC_Uri::url('goods/merchant/finish');
		} elseif ($action_type == 'obtained') {
			$href_link = RC_Uri::url('goods/merchant/obtained');
		} else {
			$href_link = RC_Uri::url('goods/merchant/check');
		}
		
		return $href_link;
	}
}
