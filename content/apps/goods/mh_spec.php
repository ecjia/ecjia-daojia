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
 * ECJIA 商品规格模板管理
 * songqianqian
*/
class mh_spec extends ecjia_merchant {
	public function __construct() {
		parent::__construct();
		
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('uniform-aristo');
		
		RC_Script::enqueue_script('bootstrap-editable-script', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/x-editable/bootstrap-editable/js/bootstrap-editable.min.js', array(), false, 1);
		RC_Style::enqueue_style('bootstrap-editable-css', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/x-editable/bootstrap-editable/css/bootstrap-editable.css', array(), false, false);
		
		RC_Script::enqueue_script('goods_attribute', RC_App::apps_url('statics/js/merchant_goods_attribute.js', __FILE__) , array() , false, 1);
        RC_Script::localize_script('goods_attribute', 'js_lang', config('app-goods::jslang.attribute_page'));
        
        RC_Script::enqueue_script('attribute-colorpicker-script', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js', array(), false, 1);
        RC_Style::enqueue_style('attribute-colorpicker-style', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/bootstrap-colorpicker/css/colorpicker.css', array(), false, false);
        
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品管理', 'goods'), RC_Uri::url('goods/merchant/init')));
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品规格模板', 'goods'), RC_Uri::url('goods/mh_spec/init')));
		
		ecjia_merchant_screen::get_current_screen()->set_parentage('goods', 'goods/mh_spec.php');
	}
	
	/**
	 * 商品规格模板列表页面
	 */
	public function init() {
		$this->admin_priv('goods_spec_attr_manage');

		ecjia_merchant_screen::get_current_screen()->remove_last_nav_here();
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品规格模板', 'goods')));
		
		$this->assign('ur_here',          	__('商品规格模板', 'goods'));
		$this->assign('action_link',      	array('text' => __('规格模板', 'goods'), 'href' => RC_Uri::url('goods/mh_spec/add')));
		$this->assign('form_search',  		RC_Uri::url('goods/mh_spec/init'));
		
		$spec_template_list = Ecjia\App\Goods\MerchantGoodsAttr::get_merchant_goods_type_list('specification');
		$this->assign('spec_template_list',	$spec_template_list);
		
		$this->assign('filter',	$spec_template_list['filter']);

		$this->display('spec_template_list.dwt');
	}
	
	/**
	 * 添加商品规格模板页面
	 */
	public function add() {
		$this->admin_priv('goods_spec_attr_update');
		
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加规格模板', 'goods')));
		
		$this->assign('ur_here', __('添加规格模板', 'goods'));
		$this->assign('action_link', array('href'=>	RC_Uri::url('goods/mh_spec/init'), 'text' => __('规格模板列表', 'goods')));
		
		$this->assign('action', 'add');
		
		$this->assign('spec_template_info', array('enabled' => 1));
		
		$this->assign('form_action',  RC_Uri::url('goods/mh_spec/insert'));

		$this->display('spec_template_info.dwt');
	}
	
	/**
	 * 添加商品规格模板数据处理
	 */
	public function insert() {
		$this->admin_priv('goods_spec_attr_update');
		
		$spec_template['store_id']		= !empty($_SESSION['store_id']) ? $_SESSION['store_id'] : 0;
		$spec_template['cat_name']		= trim($_POST['cat_name']);
		$spec_template['cat_type']		= 'specification';
		$spec_template['enabled']		= intval($_POST['enabled']);
		
		$count = RC_DB::table('goods_type')->where('cat_type', 'specification')->where('cat_name', $spec_template['cat_name'])->where('store_id', $spec_template['store_id'])->count();
		if ($count > 0 ){
			return $this->showmessage(__('规格模板名称已存在', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$cat_id = RC_DB::table('goods_type')->insertGetId($spec_template);
			if ($cat_id) {
				return $this->showmessage(__('添加规格模板成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/mh_spec/edit', array('cat_id' => $cat_id))));
			} else {
				return $this->showmessage(__('添加规格模板失败', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
	}
	
	/**
	 * 编辑商品规格模板页面
	 */
	public function edit() {
		$this->admin_priv('goods_spec_attr_update');
		
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑规格模板', 'goods')));
		$this->assign('ur_here', __('编辑规格模板', 'goods'));
		$this->assign('action_link', array('href'=>RC_Uri::url('goods/mh_spec/init'), 'text' => __('商品规格模板', 'goods')));
		
		$spec_template_info = RC_DB::table('goods_type')->where('cat_id', intval($_GET['cat_id']))->where('store_id', $_SESSION['store_id'])->first();
		$this->assign('spec_template_info', $spec_template_info);
		
		$this->assign('form_action', RC_Uri::url('goods/mh_spec/update'));
		
		$this->display('spec_template_info.dwt');
	}
	
	/**
	 * 编辑商品规格模板页面
	 */
	public function update() {
		$this->admin_priv('goods_spec_attr_update');
		
		$cat_id						= intval($_POST['cat_id']);
		$spec_template['cat_name']	= trim($_POST['cat_name']);
		$spec_template['enabled']	= intval($_POST['enabled']);
		$spec_template['cat_type']	= 'specification';
		
		$count = RC_DB::table('goods_type')->where('cat_type', 'specification')->where('cat_name', $spec_template['cat_name'])->where('cat_id', '!=', $cat_id)->where('store_id', $_SESSION['store_id'])->count();
		if ($count > 0 ){
			return $this->showmessage(__('规格模板名称已存在', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			RC_DB::table('goods_type')->where('cat_id', $cat_id)->where('store_id', $_SESSION['store_id'])->update($spec_template);
			return $this->showmessage(__('编辑规格模板成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/mh_spec/edit', array('cat_id' => $cat_id))));
		}
	}
	
	/**
	 * 切换商品规格模板启用状态
	 */
	public function toggle_enabled() {
		$this->admin_priv('goods_spec_attr_update');
	
		$id		= intval($_POST['id']);
		$val    = intval($_POST['val']);
	
		RC_DB::table('goods_type')->where('cat_id', $id)->where('store_id', $_SESSION['store_id'])->update(array('enabled' => $val));
	
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $val));
	}
	

	/**
	 * 修改商品规格模板名称
	 */
	public function edit_type_name() {
		$this->admin_priv('goods_spec_attr_update');
	
		$cat_id   = !empty($_POST['pk'])  		? intval($_POST['pk'])	: 0;
		$cat_name = !empty($_POST['value']) 	? trim($_POST['value'])	: '';
	
		if(!empty($cat_name)) {
			$is_only = RC_DB::table('goods_type')->where('cat_type', 'specification')->where('cat_name', $cat_name)->where('store_id', $_SESSION['store_id'])->count();
			if ($is_only > 0) {
				return $this->showmessage(__('规格模板名称已存在', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				RC_DB::table('goods_type')->where('cat_id', $cat_id)->where('store_id', $_SESSION['store_id'])->update(array('cat_name' => $cat_name));
				return $this->showmessage(__('编辑规格模板名称成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => stripslashes($cat_name)));
			}
		} else {
			return $this->showmessage(__('规格模板名称不能为空', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 删除商品规格模板
	 */
	public function remove() {
		$this->admin_priv('goods_spec_attr_delete');
		
		$cat_id = intval($_GET['id']);
		$cat_name = RC_DB::table('goods_type')->where('cat_id', $cat_id)->pluck('cat_name');

		if (RC_DB::table('goods_type')->where('cat_id', $cat_id)->where('store_id', $_SESSION['store_id'])->delete()) {
			
			ecjia_merchant::admin_log(addslashes($cat_name), 'remove', 'goods_type');
			
			/* 清除该类型下的所有属性 */
			$arr = RC_DB::table('attribute')->where('cat_id', $cat_id)->lists('attr_id');
			if (!empty($arr)) {
				RC_DB::table('attribute')->whereIn('attr_id', $arr)->delete();
				RC_DB::table('goods_attr')->whereIn('attr_id', $arr)->delete();
			}
			return $this->showmessage(__('删除成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage(__('删除失败', 'goods'),  ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
}
