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
 * ECJIA 商品参数模板管理
 * songqianqian
*/
class admin_parameter extends ecjia_admin {
	public function __construct() {
		parent::__construct();
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		
		RC_Script::enqueue_script('adsense-bootstrap-editable-script', RC_Uri::admin_url() . '/statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js', array(), false, 1);
		RC_Style::enqueue_style('adsense-bootstrap-editable-style', RC_Uri::admin_url() . '/statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css');
		
		RC_Script::enqueue_script('goods_attribute', RC_App::apps_url('statics/js/goods_attribute.js', __FILE__) , array() , false, 1);
        RC_Script::localize_script('goods_attribute', 'js_lang', config('app-goods::jslang.attribute_page'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品参数模板', 'goods'), RC_Uri::url('goods/admin_parameter/init')));
	}
	
	/**
	 * 商品参数模板列表页面
	 */
	public function init() {
		$this->admin_priv('goods_parameter_attr_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品参数模板', 'goods')));
		$this->assign('ur_here',          	__('商品参数模板', 'goods'));
		$this->assign('action_link',      	array('text' => __('参数模板', 'goods'), 'href' => RC_Uri::url('goods/admin_parameter/add')));
		
		$parameter_template_list = Ecjia\App\Goods\GoodsAttr::get_goods_type_list('parameter');
		$this->assign('parameter_template_list',	$parameter_template_list);
		
		$this->assign('filter',	$parameter_template_list['filter']);

		$this->assign('form_search',  		RC_Uri::url('goods/admin_parameter/init'));
		
		return $this->display('parameter_template_list.dwt');
	}
	
	/**
	 * 添加参数模板页面
	 */
	public function add() {
		$this->admin_priv('goods_parameter_attr_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加参数模板', 'goods')));
		$this->assign('ur_here', __('添加参数模板', 'goods'));
		$this->assign('action_link', array('href'=>	RC_Uri::url('goods/admin_parameter/init'), 'text' => __('参数模板列表', 'goods')));
		
		$this->assign('action', 'add');
		
		$this->assign('parameter_template_info', array('enabled' => 1));
		
		$this->assign('form_action',  RC_Uri::url('goods/admin_parameter/insert'));

		return $this->display('parameter_template_info.dwt');
	}
		
	/**
	 * 添加参数模板数据处理
	 */
	public function insert() {
		$this->admin_priv('goods_parameter_attr_update');
		
		$par_template['store_id']	    = 0;
		$par_template['cat_name']		= trim($_POST['cat_name']);
		$par_template['cat_type']		= 'parameter';
		$par_template['enabled']		= intval($_POST['enabled']);
		$par_template['attr_group']	    = $_POST['attr_group'];
		
		$count = RC_DB::table('goods_type')->where('cat_type', 'parameter')->where('cat_name', $par_template['cat_name'])->where('store_id', 0)->count();
		if ($count > 0 ){
			return $this->showmessage(__('参数模板名称已存在。', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$cat_id = RC_DB::table('goods_type')->insertGetId($par_template);
			if ($cat_id) {
				return $this->showmessage(__('添加参数模板成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/admin_parameter/edit', array('cat_id' => $cat_id))));
			} else {
				return $this->showmessage(__('添加参数模板失败', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
	}
	
	/**
	 * 编辑参数模板页面
	 */
	public function edit() {
		$this->admin_priv('goods_parameter_attr_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑参数模板', 'goods')));
		$this->assign('ur_here', __('编辑参数模板', 'goods'));
		$this->assign('action_link', array('href'=>RC_Uri::url('goods/admin_parameter/init'), 'text' => __('参数模板列表', 'goods')));
		
		$parameter_template_info = RC_DB::table('goods_type')->where('cat_id', intval($_GET['cat_id']))->where('store_id', 0)->first();
		$this->assign('parameter_template_info', $parameter_template_info);
		
		$this->assign('form_action', RC_Uri::url('goods/admin_parameter/update'));
		
		return $this->display('parameter_template_info.dwt');
	}
	
	/**
	 * 编辑参数模板数据处理
	 */
	public function update() {
		$this->admin_priv('goods_parameter_attr_update');
		
		$cat_id	= intval($_POST['cat_id']);
		$parameter_template['cat_name']		= trim($_POST['cat_name']);
		$parameter_template['enabled']		= intval($_POST['enabled']);
		$parameter_template['attr_group']	= $_POST['attr_group'];
        $parameter_template['cat_type']	    = 'parameter';
		
		$old_groups	= Ecjia\App\Goods\GoodsAttr::get_attr_groups($cat_id);
		$count = RC_DB::table('goods_type')
			->where('cat_name', $parameter_template['cat_name'])
			->where('cat_id', '!=', $cat_id)
			->where('cat_type', 'parameter')
			->where('store_id', 0)
			->count();

		if ($count > 0) {
			return $this->showmessage(__('参数模板名称已存在。', 'goods'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			RC_DB::table('goods_type')->where('cat_id', $cat_id)->where('store_id',0)->update($parameter_template);
			
			/* 对比原来的分组 */
			$new_groups = explode("\n", str_replace("\r", '', $parameter_template['attr_group']));  // 新的分组
			if (!empty($old_groups)) {
				foreach ($old_groups AS $key=>$val) {
					$found = array_search($val, $new_groups);
					if ($found === NULL || $found === false) {
						/* 老的分组没有在新的分组中找到 */
						Ecjia\App\Goods\GoodsAttr::update_attribute_group($cat_id, $key, 0);
					} else {
						/* 老的分组出现在新的分组中了 */
						if ($key != $found) {
							Ecjia\App\Goods\GoodsAttr::update_attribute_group($cat_id, $key, $found); // 但是分组的key变了,需要更新属性的分组
						}
					}
				}
			}
			return $this->showmessage(__('编辑参数模板成功。', 'goods'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/admin_parameter/edit', array('cat_id' => $cat_id))));
		}
	}
	
	/**
	 * 切换启用状态
	 */
	public function toggle_enabled() {
		$this->admin_priv('goods_parameter_attr_update');
	
		$id		= intval($_POST['id']);
		$val    = intval($_POST['val']);
	
		RC_DB::table('goods_type')->where('cat_id', $id)->update(array('enabled' => $val));
	
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $val));
	}
	
	/**
	 * 删除商品参数模板
	 */
	public function remove() {
		$this->admin_priv('goods_parameter_attr_delete');
		
		$id = intval($_GET['id']);
		$name = RC_DB::table('goods_type')->where('cat_id', $id)->value('cat_name');
		
		if (RC_DB::table('goods_type')->where('cat_id', $id)->delete()) {
			/* 清除该类型下的所有属性 */
			$arr = RC_DB::table('attribute')->where('cat_id', $id)->lists('attr_id');
			if (!empty($arr)) {
				RC_DB::table('attribute')->whereIn('attr_id', $arr)->delete();
				RC_DB::table('goodslib_attr')->whereIn('attr_id', $arr)->delete();
			}
			return $this->showmessage(__('删除成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage(__('删除失败', 'goods'),  ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

	/**
	 * 修改参数模板名称
	 */
	public function edit_type_name() {
		$this->admin_priv('goods_parameter_attr_update');
		
		$type_id   = !empty($_POST['pk'])  		? intval($_POST['pk'])	: 0;
		$type_name = !empty($_POST['value']) 	? trim($_POST['value'])	: '';

		if(!empty($type_name)) {
			$is_only = RC_DB::table('goods_type')->where('cat_type', 'parameter')->where('cat_name', $type_name)->where('store_id', 0)->count();
			if ($is_only > 0) {
				return $this->showmessage(__('参数模板名称已存在。', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				RC_DB::table('goods_type')->where('cat_id', $type_id)->update(array('cat_name' => $type_name));
				return $this->showmessage(__('编辑成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => stripslashes($type_name)));
			}
		} else {
			return $this->showmessage(__('参数模板名称不能为空！', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
}
