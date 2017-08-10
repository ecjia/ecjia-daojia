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

class admin_config extends ecjia_admin {

	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
	
		RC_Loader::load_app_func('merchant_store_category', 'store');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('bootstrap-placeholder');
		
		RC_Script::enqueue_script('admin_config', RC_App::apps_url('statics/js/admin_config.js', __FILE__), array(), false, true);
	}
					
	/**
	 * 后台设置
	 */
	public function init() {
	    $this->admin_priv('store_config_manage');
	   
		$this->assign('ur_here', '后台配置');
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('后台配置')));

		/* 判断定位范围设置code是否存在，如果不存在则插入*/
		if (!ecjia::config('mobile_location_range', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_location_range', 3, array('type' => 'text'));
        }
//     	$this->assign('config_cpname', ecjia::config('merchant_admin_cpname')); //需删除
    	
    	$this->assign('config_logoimg', RC_Upload::upload_url(ecjia::config('merchant_admin_login_logo')));
    	$this->assign('config_logo', ecjia::config('merchant_admin_login_logo'));
    	$this->assign('mobile_location_range', ecjia::config('mobile_location_range'));
    	$this->assign('current_code', 'store');
		$this->assign('form_action', RC_Uri::url('store/admin_config/update'));
		
		$store_model = ecjia::config('store_model');
		$store_list = array();
		
		if ($store_model == 'nearby' || empty($store_model)) {
			$store_model = 0;
		} else if (!empty($store_model)) {
			$store_id = $store_model;
			$store_model = explode(',', $store_model);
			if (count($store_model) == 1) {
				$store_list = RC_DB::table('store_franchisee')->select('store_id', 'merchants_name')->where('store_id', $store_id)->first();
				$store_model = 1;
			} else {
				$store_list = RC_DB::table('store_franchisee')->select('store_id', 'merchants_name')->whereIn('store_id', $store_model)->get();
				$store_model = 2;
			}
		}
		
		$this->assign('model', $store_model);
		$this->assign('store_list', $store_list);
		$this->assign('cat_list', cat_list(0, 0, true));
		
		$this->display('store_config_info.dwt');
	}
		
	/**
	 * 处理后台设置
	 */
	public function update() {
		$this->admin_priv('store_config_manage', ecjia::MSGTYPE_JSON);
		
		$merchant_admin_cpname 	= !empty($_POST['merchant_admin_cpname']) 	? trim($_POST['merchant_admin_cpname']) : '';
		
		$mobile_location_range  = isset($_POST['mobile_location_range']) ? intval($_POST['mobile_location_range']) : 0;

		$store_model = !empty($_POST['store_model']) ? intval($_POST['store_model']) : 0;
		
		//附近门店
		if ($store_model == 0) {
			$store_model = 'nearby';
		//单门店
		} elseif ($store_model == 1) {
			$store_id = !empty($_POST['store']) ? intval($_POST['store']) : 0;
			if (empty($store_id)) {
				$this->showmessage('请搜索后选择店铺', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}	
			$store_model = $store_id;
		//多门店
		} elseif ($store_model == 2) {
			$store_id = !empty($_POST['store_id']) ? $_POST['store_id'] : '';
			if (empty($store_id)) {
				$this->showmessage('请搜索后选择店铺', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			if (count($store_id) < 2) {
				$this->showmessage('请至少选择两个店铺', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$store_model = implode(',', $store_id);
		}
		
		//后台名称
		ecjia_config::instance()->write_config('merchant_admin_cpname', $merchant_admin_cpname);
		
		//搜索范围
		ecjia_config::instance()->write_config('mobile_location_range', $mobile_location_range);
		
		$upload = RC_Upload::uploader('image', array('save_path' => 'data/assets', 'save_name' => 'merchant_admin_logo', 'replace' => true, 'auto_sub_dirs' => false));
		
		//登录logo
		$image_info = $upload->upload($_FILES['merchant_admin_login_logo']);		
		/* 判断是否上传成功 */
		if (!empty($image_info)) {
			$old_logo = ecjia::config('merchant_admin_login_logo');
			if (!empty($old_logo)) {
				$upload->remove($old_logo);
			}
			$logo = $upload->get_position($image_info);	
			ecjia_config::instance()->write_config('merchant_admin_login_logo', $logo);
		}
		
		//门店模式
		ecjia_config::instance()->write_config('store_model', $store_model);
		
		ecjia_admin::admin_log('商家入驻>后台设置', 'setup', 'config');
		return $this->showmessage(__('更新商店设置成功！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin_config/init')));
	}
	
	/**
	 * 删除上传文件
	 */
	public function del() {
		$this->admin_priv('store_config_manage', ecjia::MSGTYPE_JSON);
		$type = !empty($_GET['type']) ? $_GET['type'] : '';
		
		if (!empty($type)) {
			$disk = RC_Filesystem::disk();
			if ($type == 'logo') {
				$disk->delete(RC_Upload::upload_path() . ecjia::config('merchant_admin_login_logo'));
				ecjia_config::instance()->write_config('merchant_admin_login_logo', '');
			}
		}
		return $this->showmessage(__('删除图片成功！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin_config/init')));
	}
	
	/**
	 * 搜索店铺
	 */
	public function search_store() {
		$cat_id = !empty($_POST['cat_id']) ? intval($_POST['cat_id']) : 0;
		$keywords = !empty($_POST['keywords']) ? trim($_POST['keywords']) : '';

		$db_store_franchisee = RC_DB::table('store_franchisee');
		if (!empty($cat_id)) {
			$db_store_franchisee->where('cat_id', $cat_id);
		}
		if (!empty($keywords)) {
			$db_store_franchisee->where('merchants_name', 'like', '%'.mysql_like_quote($keywords).'%');
		}
		$data = $db_store_franchisee->select('store_id', 'merchants_name')->where('shop_close', 0)->where('status', 1)->get();
		
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $data));
	}
}

//end