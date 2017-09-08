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
 * ECJIA 属性规格管理
 */
class mh_attribute extends ecjia_merchant {
	public function __construct() {
		parent::__construct();

		RC_Loader::load_app_func('admin_goods');
		RC_Loader::load_app_func('global');
		RC_Loader::load_app_func('merchant_goods');
		
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('uniform-aristo');
		
		RC_Script::enqueue_script('bootstrap-editable-script', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/x-editable/bootstrap-editable/js/bootstrap-editable.min.js', array());
		RC_Style::enqueue_style('bootstrap-editable-css', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/x-editable/bootstrap-editable/css/bootstrap-editable.css', array(), false, false);
		
		RC_Script::enqueue_script('goods_attribute', RC_App::apps_url('statics/js/merchant_goods_attribute.js', __FILE__), array(), false, true);
		RC_Script::localize_script('goods_attribute', 'js_lang', RC_Lang::get('goods::goods.js_lang'));
		
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('商品管理', RC_Uri::url('goods/merchant/init')));
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('goods::goods_spec.goods_spec_list'), RC_Uri::url('goods/mh_spec/init')));
		ecjia_merchant_screen::get_current_screen()->set_parentage('goods', 'goods/mh_attribute.php');
	}

	/**
	 * 属性列表
	 */
	public function init() {
		$this->admin_priv('attr_manage');
		
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('goods::attribute.goods_attribute')));
		ecjia_merchant_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('goods::attribute.overview'),
			'content'	=> '<p>' . RC_Lang::get('goods::attribute.goods_attribute_help') . '</p>'
		));
		
		ecjia_merchant_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('goods::attribute.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:商品类型#.E5.B1.9E.E6.80.A7.E5.88.97.E8.A1.A8" target="_blank">'. RC_Lang::get('goods::attribute.about_goods_attribute') .'</a>') . '</p>'
		);
		
		$goods_type	= isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
		$attr_list = array();
		
		if (!empty($goods_type)) {
			$goods_type_list = RC_DB::table('goods_type')->where('store_id', $_SESSION['store_id'])->lists('cat_id');
			if (in_array($goods_type, $goods_type_list)) {
				$attr_list = get_merchant_attr_list();
			}
		}
		
		$this->assign('ur_here', RC_Lang::get('goods::attribute.goods_attribute'));
		$this->assign('action_link', array('href' => RC_Uri::url('goods/mh_attribute/add', array('cat_id' => $goods_type)), 'text' => RC_Lang::get('system::system.10_attribute_add')));
		$this->assign('action_link2', array('text' => RC_Lang::get('goods::goods_spec.goods_spec_list'), 'href' => RC_Uri::url('goods/mh_spec/init')));
		
		$this->assign('goods_type_list', goods_enable_type_list($goods_type));
		$this->assign('attr_list', $attr_list);
		$this->assign('cat_id', $goods_type);
		$this->assign('form_action', RC_Uri::url('goods/mh_attribute/batch'));
		
		$this->display('attribute_list.dwt');		
	}
	
	/**
	 * 添加/编辑属性
	 */
	public function add() {
		$this->admin_priv('attr_update');

		/* 取得属性信息 */
		$cat_id = isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('goods::attribute.goods_attribute'), RC_Uri::url('goods/mh_attribute/init', 'cat_id='.$cat_id)));
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('goods::attribute.add_attribute')));
	
		ecjia_merchant_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('goods::attribute.overview'),
			'content'	=> '<p>' . RC_Lang::get('goods::attribute.add_attribute_help') . '</p>'
		));
		
		ecjia_merchant_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('goods::attribute.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:商品类型#.E6.B7.BB.E5.8A.A0.E5.B1.9E.E6.80.A7" target="_blank">'. RC_Lang::get('goods::attribute.about_add_attribute') .'</a>') . '</p>'
		);
		
		/* 取得商品分类列表 */
		$this->assign('goods_type_list', goods_enable_type_list($cat_id));
		$this->assign('attr_groups', get_attr_groups($cat_id));
		
		$this->assign('ur_here', RC_Lang::get('goods::attribute.add_attribute'));
		$this->assign('action_link', array('href' => RC_Uri::url('goods/mh_attribute/init', 'cat_id='.$cat_id), 'text' => RC_Lang::get('goods::attribute.goods_attribute')));
		$this->assign('form_action', RC_Uri::url('goods/mh_attribute/insert'));
	
		$this->display('attribute_info.dwt');
	}

	/**
	 * 插入/更新属性
	 */
	public function insert() {
		$this->admin_priv('attr_update', ecjia::MSGTYPE_JSON);
	
		/* 检查该类型下名称是否重复 */
		$cat_id = isset($_POST['cat_id']) ? intval($_POST['cat_id']) : 0;

		if (empty($cat_id)) {
			return $this->showmessage(RC_Lang::get('goods::attribute.cat_not_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$count = RC_DB::table('attribute')->where('attr_name', trim($_POST['attr_name']))->where('cat_id', $cat_id)->count();
		if ($count) {
			return $this->showmessage(RC_Lang::get('goods::attribute.name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		/* 取得属性信息 */
		$attr = array(
			'cat_id'			=> $cat_id,
			'attr_name'			=> trim($_POST['attr_name']),
			'attr_index'		=> $_POST['attr_index'],
			'attr_input_type'	=> $_POST['attr_input_type'],
			'is_linked'			=> $_POST['is_linked'],
			'attr_values'       => isset($_POST['attr_values']) ? $_POST['attr_values'] 		: '',
			'attr_type'			=> !empty($_POST['attr_type']) 	? intval($_POST['attr_type']) 	: 0,
			'attr_group'		=> isset($_POST['attr_group']) 	? intval($_POST['attr_group']) 	: 0
		);
		
		/* 入库、记录日志、提示信息 */
		$attr_id  =RC_DB::table('attribute')->insertGetId($attr);
		
		if ($attr_id) {
			ecjia_merchant::admin_log($_POST['attr_name'], 'add', 'attribute');
			$links = array(
				array('text' => RC_Lang::get('goods::attribute.back_list'), 'href' => RC_Uri::url('goods/mh_attribute/init', array('cat_id' => $cat_id))),
				array('text' => RC_Lang::get('goods::attribute.add_next'), 'href' => RC_Uri::url('goods/mh_attribute/add', array('cat_id' => $cat_id))),
			);
			return $this->showmessage(sprintf(RC_Lang::get('goods::attribute.add_ok'), $attr['attr_name']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/mh_attribute/edit', array('attr_id' => $attr_id)), 'links' => $links));
		}
	}

	/**
	 * 添加/编辑属性
	 */
	public function edit() {
		$this->admin_priv('attr_update');
		
		$is_add = !empty($_GET['act']) ? 'add' : '';
		$this->assign('form_act', $is_add ? 'insert' : 'update');
		/* 取得属性信息 */
		if ($is_add) {
			$goods_type = isset($_GET['goods_type']) ? intval($_GET['goods_type']) : 0;
			$attr = array(
				'attr_id' 			=> 0,
				'cat_id' 			=> $goods_type,
				'attr_name' 		=> '',
				'attr_input_type'	=> 0,
				'attr_index'  		=> 0,
				'attr_values' 		=> '',
				'attr_type' 		=> 0,
				'is_linked' 		=> 0,
			);
		} else {
			$attr = RC_DB::table('attribute')->where('attr_id', $_GET['attr_id'])->first();
		}
		$this->assign('attr', $attr);
		$this->assign('attr_groups', get_attr_groups($attr['cat_id']));
		/* 取得商品分类列表 */
		$this->assign('goods_type_list', goods_enable_type_list($attr['cat_id']));
	
		/* 模板赋值 */
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__($is_add ? RC_Lang::get('system::system.10_attribute_add') : RC_Lang::get('system::system.52_attribute_add'))));
		$this->assign('ur_here', $is_add ? RC_Lang::get('system::system.10_attribute_add') : RC_Lang::get('system::system.52_attribute_add'));
		$this->assign('action_link', array('href' => RC_Uri::url('goods/mh_attribute/init', array('cat_id' => $attr['cat_id'])), 'text' => RC_Lang::get('goods::attribute.goods_attribute')));
		$this->assign('form_action', RC_Uri::url('goods/mh_attribute/update'));
		
		ecjia_merchant_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('goods::attribute.overview'),
			'content'	=> '<p>' . RC_Lang::get('goods::attribute.edit_attribute_help') . '</p>'
		));
		
		ecjia_merchant_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('goods::attribute.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:商品类型#.E7.BC.96.E8.BE.91.E5.B1.9E.E6.80.A7" target="_blank">'. RC_Lang::get('goods::attribute.about_edit_attribute') .'</a>') . '</p>'
		);
		
		$this->display('attribute_info.dwt');
	}
	
	/**
	 * 插入/更新属性
	 */
	public function update() {
		$this->admin_priv('attr_update', ecjia::MSGTYPE_JSON);
	
		$cat_id = isset($_REQUEST['cat_id']) ? intval($_REQUEST['cat_id']) : 0;
		$attr_id = isset($_POST['attr_id']) ? intval($_POST['attr_id']) : 0;
		/* 检查名称是否重复 */
		if (RC_DB::table('attribute')->where('cat_id', $cat_id)->where('attr_name', trim($_POST['attr_name']))->where('attr_id', '!=', $_POST['attr_id'])->count()) {
			return $this->showmessage(RC_Lang::get('goods::attribute.name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
			
		/* 取得属性信息 */
		$attr = array(
			'cat_id'			=> $cat_id,
			'attr_name'			=> trim($_POST['attr_name']),
			'attr_index'		=> $_POST['attr_index'],
			'attr_input_type'	=> $_POST['attr_input_type'],
			'is_linked'			=> $_POST['is_linked'],
			'attr_values'       => isset($_POST['attr_values']) ? $_POST['attr_values'] 		: '',
			'attr_type'			=> !empty($_POST['attr_type']) 	? intval($_POST['attr_type']) 	: 0 ,
			'attr_group'		=> isset($_POST['attr_group']) 	? intval($_POST['attr_group']) 	: 0
		);
	
		/* 入库、记录日志、提示信息 */
		RC_DB::table('attribute')->where('attr_id', $attr_id)->update($attr);
		ecjia_merchant::admin_log($_POST['attr_name'], 'edit', 'attribute');
		
		$links = array(
			array('text' => RC_Lang::get('goods::attribute.back_list'), 'href' => RC_Uri::url('goods/mh_attribute/init', array('cat_id' => $cat_id))),
		);
		return $this->showmessage(sprintf(RC_Lang::get('goods::attribute.edit_ok'), $attr['attr_name']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('goods/mh_attribute/edit', array('attr_id' => $attr_id))));
	}
	
	/**
	 * 删除商品属性
	 */
	public function remove() {
		$this->admin_priv('attr_delete', ecjia::MSGTYPE_JSON);

		$id = intval($_GET['id']);
		
		RC_DB::table('attribute')->where('attr_id', $id)->delete();
		RC_DB::table('goods_attr')->where('attr_id', $id)->delete();
		
		return $this->showmessage(RC_Lang::get('goods::attribute.drop_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	 * 删除属性(一个或多个)
	 */
	public function batch() {
		$this->admin_priv('attr_delete', ecjia::MSGTYPE_JSON);
		
		$cat_id = !empty($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
		/* 取得要操作的编号 */
		if (isset($_POST['checkboxes'])) {
			$ids	= explode(',', $_POST['checkboxes']);
			$count 	= count($ids);
			
			RC_DB::table('attribute')->whereIn('attr_id', $ids)->delete();
			RC_DB::table('goods_attr')->whereIn('attr_id', $ids)->delete();
			
			/* 记录日志 */
			ecjia_merchant::admin_log('', 'batch_remove', 'attribute');
			return $this->showmessage(sprintf(RC_Lang::get('goods::attribute.drop_ok'), $count), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/mh_attribute/init', array('cat_id' => $cat_id))));
		}
	}
	
	/**
	 * 编辑属性名称
	 */
	public function edit_attr_name() {
		$this->admin_priv('attr_update', ecjia::MSGTYPE_JSON);
	
		$id = intval($_POST['pk']);
		$val = trim($_POST['value']);
	
		/* 取得该属性所属商品属性id */
		$cat_id = RC_DB::table('attribute')->where('attr_id', $id)->pluck('cat_id');
		/* 检查名称是否重复 */
		if (!empty($val)) {
			if (RC_DB::table('attribute')->where('attr_name', $val)->where('cat_id', $cat_id)->where('attr_id', '!=', $id)->count() != 0) {	
				return $this->showmessage(RC_Lang::get('goods::attribute.name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$data = array(
				'attr_name' => $val
			);
			if (RC_DB::table('attribute')->where('attr_id', $id)->update($data)) {
				ecjia_merchant::admin_log($val, 'edit', 'attribute');
				return $this->showmessage(RC_Lang::get('goods::attribute.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $val));
			}
		} else {
			return $this->showmessage(RC_Lang::get('goods::attribute.name_not_null'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 编辑排序序号
	 */
	public function edit_sort_order() {
		$this->admin_priv('attr_update', ecjia::MSGTYPE_JSON);
	
		$id = intval($_POST['pk']);
		$val = trim($_POST['value']);
	
		/* 验证参数有效性 */
		if (!is_numeric($val) || $val < 0 || strpos($val, '.') > 0) {
			return $this->showmessage(RC_Lang::get('goods::attribute.format_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	
		$data = array(
			'sort_order' 	=> $val
		);
		if (RC_DB::table('attribute')->where('attr_id', $id)->update($data)) {
			return $this->showmessage(RC_Lang::get('goods::attribute.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $val));
		}
	}
	
	public function get_attr_group() {
		$cat_id = !empty($_POST['cat_id']) ? $_POST['cat_id'] : 0;
	
		$data = get_attr_groups($cat_id);
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $data));
	}

}

// end