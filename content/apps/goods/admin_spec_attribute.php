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
 * ECJIA 商品规格属性管理
 * songqianqian
 */

class admin_spec_attribute extends ecjia_admin {
	public function __construct() {
		parent::__construct();
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		
		RC_Style::enqueue_style('goods-colorpicker-style', RC_Uri::admin_url() . '/statics/lib/colorpicker/css/colorpicker.css');
		RC_Script::enqueue_script('goods-colorpicker-script', RC_Uri::admin_url('/statics/lib/colorpicker/bootstrap-colorpicker.js'), array(), false, 1);
		
		RC_Script::enqueue_script('bootstrap-editable-script', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'), array(), false, 1);
        RC_Style::enqueue_style('bootstrap-editable-css', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));

		RC_Script::enqueue_script('goods_attribute', RC_App::apps_url('statics/js/goods_attribute.js', __FILE__), array(), false, 1);
		RC_Script::localize_script('goods_attribute', 'js_lang', config('app-goods::jslang.attribute_page'));
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品规格模板', 'goods'), RC_Uri::url('goods/admin_spec/init')));

	}

	/**
	 * 商品规格属性列表
	 */
	public function init() {
		$this->admin_priv('goods_spec_attr_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('属性列表', 'goods')));
		$this->assign('ur_here', __('属性列表', 'goods'));
		
		$cat_id	= isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
		$this->assign('cat_id', $cat_id);
		
		$cat_name = RC_DB::TABLE('goods_type')->where('cat_id', $cat_id)->pluck('cat_name');
		$this->assign('cat_name', $cat_name);
		
		$this->assign('action_link', array('href' => RC_Uri::url('goods/admin_spec_attribute/add', array('cat_id' => $cat_id)), 'text' => __('添加属性', 'goods')));
		$this->assign('action_link2', array('text' => __('规格模板列表', 'goods'), 'href' => RC_Uri::url('goods/admin_spec/init')));
		
		$attr_list = array();
		if (!empty($cat_id)) {
			$goods_type_list = RC_DB::table('goods_type')->where('store_id', 0)->where('cat_type', 'specification')->lists('cat_id');
			if (in_array($cat_id, $goods_type_list)) {
				$attr_list = Ecjia\App\Goods\GoodsAttr::get_attr_list();
			}
		}
		$this->assign('attr_list', $attr_list);
		
		$this->assign('goods_type_list', Ecjia\App\Goods\GoodsAttr::goods_type_select_list($cat_id, 'specification'));

		$this->assign('form_action', RC_Uri::url('goods/admin_spec_attribute/batch'));
		
		return $this->display('spec_attribute_list.dwt');
	}
	
	/**
	 * 添加商品规格属性页面
	 */
	public function add() {
		$this->admin_priv('goods_spec_attr_update');

		$cat_id = isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('规格属性', 'goods'), RC_Uri::url('goods/admin_spec_attribute/init', array('cat_id' => $cat_id))));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加属性', 'goods')));

		$this->assign('ur_here', __('添加属性', 'goods'));
		$this->assign('action_link', array('href' => RC_Uri::url('goods/admin_spec_attribute/init', 'cat_id='.$cat_id), 'text' => __('属性列表', 'goods')));
		
		$info = RC_DB::table('goods_type')->where('cat_id', $cat_id)->first();
		
		$this->assign('goods_type_list', Ecjia\App\Goods\GoodsAttr::goods_type_select_list($cat_id, 'specification'));
		
		$this->assign('form_action', RC_Uri::url('goods/admin_spec_attribute/insert'));
	
		return $this->display('spec_attribute_info.dwt');
	}

	/**
	 * 添加商品规格属性数据处理
	 */
	public function insert() {
		$this->admin_priv('goods_spec_attr_update');
	
		$cat_id = isset($_POST['spec_cat_id']) ? intval($_POST['spec_cat_id']) : 0;
		
		if (empty($cat_id)) {
			return $this->showmessage(__('请选择规格模板', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$count = RC_DB::table('attribute')->where('attr_name', trim($_POST['attr_name']))->where('cat_id', $cat_id)->count();
		if ($count > 0) {
			return $this->showmessage(__('属性名称在当前规格模板下已存在，请您换一个名称', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (empty($_POST['attr_values'])) {
			return $this->showmessage(__('属性的可选值列表不能为空', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$attr = array(
			'cat_id'			=> $cat_id,
			'attr_name'			=> trim($_POST['attr_name']),
			'attr_cat_type'		=> intval($_POST['attr_cat_type']),
			'attr_input_type'	=> 1,
			'attr_values'       => $_POST['attr_values'],
		);
		
		$attr_id  =RC_DB::table('attribute')->insertGetId($attr);
		
		if ($attr_id) {
			ecjia_admin::admin_log($_POST['attr_name'], 'add', 'attribute');
			return $this->showmessage(sprintf(__('添加属性 [%s] 成功。', 'goods'), $attr['attr_name']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/admin_spec_attribute/edit', array('attr_id' => $attr_id))));
		} else {
			return $this->showmessage(sprintf(__('添加规格属性 [%s] 失败', 'goods'), $attr['attr_name']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

	/**
	 * 编辑商品规格属性页面
	 */
	public function edit() {
		$this->admin_priv('goods_spec_attr_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑属性', 'goods')));
		$this->assign('ur_here', __('编辑属性', 'goods'));
		
		$attr_info = RC_DB::table('attribute')->where('attr_id', $_GET['attr_id'])->first();
		$this->assign('attr', $attr_info);

		$this->assign('goods_type_list', Ecjia\App\Goods\GoodsAttr::goods_type_select_list($attr_info['cat_id'], 'specification'));
	
		$this->assign('action_link', array('href' => RC_Uri::url('goods/admin_spec_attribute/init', array('cat_id' => $attr_info['cat_id'])), 'text' => __('属性列表', 'goods')));
		
		$this->assign('form_action', RC_Uri::url('goods/admin_spec_attribute/update'));
		
		return $this->display('spec_attribute_info.dwt');
	}
	
	/**
	 * 编辑商品规格属性数据处理
	 */
	public function update() {
		$this->admin_priv('goods_spec_attr_update');
	
		$cat_id  = isset($_REQUEST['spec_cat_id']) ? intval($_REQUEST['spec_cat_id']) : 0;
		$attr_id = isset($_POST['attr_id']) ? intval($_POST['attr_id']) : 0;
		
		$count = RC_DB::table('attribute')->where('cat_id', $cat_id)->where('attr_name', trim($_POST['attr_name']))->where('attr_id', '!=', $_POST['attr_id'])->count();
		if ($count != 0) {
			return $this->showmessage(__('属性名称在当前规格模板下已存在，请您换一个名称', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (empty($_POST['attr_values'])) {
			return $this->showmessage(__('属性的可选值列表不能为空', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$attr = array(
			'cat_id'			=> $cat_id,
			'attr_name'			=> trim($_POST['attr_name']),
			//'attr_cat_type'		=> intval($_POST['attr_cat_type']),
			'attr_values'       => isset($_POST['attr_values']) ? $_POST['attr_values'] : '',
		);
		RC_DB::table('attribute')->where('attr_id', $attr_id)->update($attr);
		
		ecjia_admin::admin_log($_POST['attr_name'], 'edit', 'attribute');
		
		return $this->showmessage(sprintf(__('编辑规格属性 [%s] 成功。', 'goods'), $attr['attr_name']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/admin_spec_attribute/edit', array('attr_id' => $attr_id))));
	}
	
	/**
	 * 删除商品属性
	 */
	public function remove() {
		$this->admin_priv('goods_spec_attr_delete');

		$id = intval($_GET['id']);
		
		RC_DB::table('attribute')->where('attr_id', $id)->delete();
		RC_DB::table('goodslib_attr')->where('attr_id', $id)->delete();
		
		return $this->showmessage(__('删除成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	 * 删除属性(一个或多个)
	 */
	public function batch() {
		$this->admin_priv('goods_spec_attr_delete');
		
		$cat_id = !empty($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
		
		if (isset($_POST['checkboxes'])) {
			$ids	= explode(',', $_POST['checkboxes']);
			$count 	= count($ids);
			
			RC_DB::table('attribute')->whereIn('attr_id', $ids)->delete();
			RC_DB::table('goodslib_attr')->whereIn('attr_id', $ids)->delete();
			
			ecjia_admin::admin_log('', 'batch_remove', 'attribute');
			return $this->showmessage(sprintf(__('成功删除了 %d 条商品属性', 'goods'), $count), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/admin_spec_attribute/init', array('cat_id' => $cat_id))));
		}
	}
	
	/**
	 * 列表编辑属性名称
	 */
	public function edit_attr_name() {
		$this->admin_priv('goods_spec_attr_update');
	
		$id = intval($_POST['pk']);
		$val = trim($_POST['value']);
	
		$cat_id = RC_DB::table('attribute')->where('attr_id', $id)->pluck('cat_id');
		
		if (!empty($val)) {
			if (RC_DB::table('attribute')->where('attr_name', $val)->where('cat_id', $cat_id)->where('attr_id', '!=', $id)->count() != 0) {	
				return $this->showmessage(__('属性名称在当前规格模板下已存在，请您换一个名称', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$data = array(
				'attr_name' => $val
			);
			if (RC_DB::table('attribute')->where('attr_id', $id)->update($data)) {
				ecjia_admin::admin_log($val, 'edit', 'attribute');
				return $this->showmessage(__('编辑属性名称成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $val));
			}
		} else {
			return $this->showmessage(__('请输入属性名称', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 编辑排序序号
	 */
	public function edit_sort_order() {
		$this->admin_priv('goods_spec_attr_update');
	
		$id  = intval($_POST['pk']);
		$val = trim($_POST['value']);
	
		if (!is_numeric($val) || $val < 0 || strpos($val, '.') > 0) {
			return $this->showmessage(__('请输入大于0的整数', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	
		$data = array(
			'sort_order' 	=> $val
		);
		if (RC_DB::table('attribute')->where('attr_id', $id)->update($data)) {
			return $this->showmessage(__('编辑排序成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $val));
		}
	}
	
	/**
	 * 设置色值
	 */
	public function set_color_values() {
		$this->admin_priv('goods_spec_attr_update');
	
		$attr_id = intval($_POST['attr_id']);
		$attribute_info = RC_DB::TABLE('attribute')->where('attr_id', $attr_id)->select('attr_values', 'color_values', 'cat_id', 'attr_id')->first();
		$this->assign('cat_id', $attribute_info['cat_id']);
		$this->assign('attr_id', $attribute_info['attr_id']);
		$attr_values_list = explode("\n", $attribute_info['attr_values']);
		$color_values_list = explode("\n", $attribute_info['color_values']);
		
		$color_list_array = array();
		foreach ($attr_values_list as $key => $value){
			$color_list_array[$value] = $color_values_list[$key];
		}
		$this->assign('color_list_array', $color_list_array);

		$data = $this->fetch('set_color_values.dwt');

		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $data));
	}
	
	/**
	 * 设置色值处理
	 */
	public function set_color_values_insert() {
		$this->admin_priv('goods_spec_attr_update');
		
		$cat_id = intval($_POST['cat_id']);
		$attr_id = intval($_POST['attr_id']);
		
		$data = array(
			'attr_values'  => implode("\n", $_POST['attr_values']),
			'color_values' => implode("\n", $_POST['color_values']),
		);
		RC_DB::table('attribute')->where('attr_id', $attr_id)->update($data);
	
		return $this->showmessage(__('设置颜色色值成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/admin_spec_attribute/init', array('cat_id' => $cat_id))));
	}
}

// end