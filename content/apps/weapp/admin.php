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
 * ECJIA平台、小程序配置
 */
class admin extends ecjia_admin {
	
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		RC_Loader::load_app_class('platform_account', 'platform', false);
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Style::enqueue_style('bootstrap-responsive');
		
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Style::enqueue_style('admin_subscribe', RC_App::apps_url('statics/css/admin_subscribe.css', __FILE__));
		RC_Script::enqueue_script('weapp', RC_App::apps_url('statics/js/weapp.js', __FILE__), array(), false, true);
		RC_Script::localize_script('weapp', 'js_lang', RC_Lang::get('weapp::weapp.js_lang'));
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('weapp::weapp.weapp_list'), RC_Uri::url('weapp/admin/init')));
	}
	
	/**
	 * 小程序列表
	 */
	public function init() {
		$this->admin_priv('weapp_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('weapp::weapp.weapp_list')));
		//ecjia_screen::get_current_screen()->add_help_tab(array(
		//	'id'		=> 'overview',
		//	'title'		=> RC_Lang::get('platform::platform.summarize'),
		//	'content'	=>
		//	'<p>' . RC_Lang::get('platform::platform.welcome_pub_list') . '</p>'
		//));
		
		//ecjia_screen::get_current_screen()->set_help_sidebar(
		//	'<p><strong>' . RC_Lang::get('platform::platform.more_info') . '</strong></p>' .
		//	'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:管理公众号" target="_blank">'.RC_Lang::get('platform::platform.pub_list_help').'</a>') . '</p>'
		//);
		$this->assign('ur_here', RC_Lang::get('weapp::weapp.weapp_list'));
		$this->assign('action_link', array('text' => RC_Lang::get('weapp::weapp.weapp_add'), 'href'=>RC_Uri::url('weapp/admin/add')));
		
		$weapp_list = $this->weapp_list();
		$this->assign('weapp_list', $weapp_list);
		$this->assign('search_action', RC_Uri::url('weapp/admin/init'));

		$this->display('weapp_list.dwt');
	}
	
	/**
	 * 添加小程序页面
	 */
	public function add() {
		$this->admin_priv('weapp_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('weapp::weapp.weapp_add')));
		//ecjia_screen::get_current_screen()->add_help_tab(array(
		//	'id'		=> 'overview',
		//	'title'		=> RC_Lang::get('platform::platform.summarize'),
		//	'content'	=>
		//	'<p>' . RC_Lang::get('platform::platform.welcome_pub_add') . '</p>'
		//));
		//ecjia_screen::get_current_screen()->set_help_sidebar(
		//	'<p><strong>' . RC_Lang::get('platform::platform.more_info') . '</strong></p>' .
		//	'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:管理公众号#.E6.B7.BB.E5.8A.A0.E5.85.AC.E4.BC.97.E5.8F.B7" target="_blank">'.RC_Lang::get('platform::platform.add_pub_help').'</a>') . '</p>'
		//);
		
		$this->assign('ur_here', RC_Lang::get('weapp::weapp.weapp_add'));
		$this->assign('action_link', array('text' => RC_Lang::get('weapp::weapp.weapp_list'), 'href'=>RC_Uri::url('weapp/admin/init')));
		$this->assign('form_action', RC_Uri::url('weapp/admin/insert'));
		
		$this->display('weapp_edit.dwt');
	}
	
	/**
	 * 添加小程序
	 */
	public function insert() {
		$this->admin_priv('weapp_update', ecjia::MSGTYPE_JSON);
		
		if ((isset($_FILES['weapp_logo']['error']) && $_FILES['platform_logo']['error'] == 0) || (!isset($_FILES['weapp_logo']['error']) && isset($_FILES['weapp_logo']['tmp_name'] ) &&$_FILES['weapp_logo']['tmp_name'] != 'none')) {
			$upload = RC_Upload::uploader('image', array('save_path' => 'data/wxapp', 'auto_sub_dirs' => false));
			$image_info = $upload->upload($_FILES['weapp_logo']);
			if (!empty($image_info)) {
				$wxapp_logo = $upload->get_position($image_info);
			} else {
				return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			$wxapp_logo ='';
		}
		
		$uuid = Royalcms\Component\Uuid\Uuid::generate();
		$uuid = str_replace("-", "", $uuid);
		
		$data = array(
			'uuid'		=> $uuid,
			'platform'	=> 'weapp',
			'logo'		=> 	$wxapp_logo,
			'name'		=>	trim($_POST['name']),
			'appid'		=>	trim($_POST['appid']),
			'appsecret'	=>	trim($_POST['appsecret']),
			'add_time'	=>	RC_Time::gmtime(),
			'sort'		=>	intval($_POST['sort']),
			'status'	=>	intval($_POST['status']),
		);
	
		$id = RC_DB::table('platform_account')->insertGetId($data);
				
		ecjia_admin::admin_log($_POST['name'], 'add', 'weapp');
		return $this->showmessage(RC_Lang::get('weapp::weapp.add_weapp_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('weapp/admin/edit', array('id' => $id))));
	}
	
	/**
	 * 编辑小程序页面
	 */
	public function edit() {
		$this->admin_priv('weapp_update');
	
		$this->assign('ur_here', RC_Lang::get('weapp::weapp.weapp_edit'));
		$this->assign('action_link', array('text' => RC_Lang::get('weapp::weapp.weapp_list'), 'href' => RC_Uri::url('weapp/admin/init')));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('weapp::weapp.weapp_edit')));
		//ecjia_screen::get_current_screen()->add_help_tab(array(
		//	'id'		=> 'overview',
		//	'title'		=> RC_Lang::get('platform::platform.summarize'),
		//	'content'	=>
		//	'<p>' . RC_Lang::get('platform::platform.welcome_pub_edit') . '</p>'
		//));
		//ecjia_screen::get_current_screen()->set_help_sidebar(
		//	'<p><strong>' . RC_Lang::get('platform::platform.more_info') . '</strong></p>' .
		//	'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:管理公众号#.E7.BC.96.E8.BE.91.E5.85.AC.E4.BC.97.E5.8F.B7" target="_blank">'.RC_Lang::get('platform::platform.edit_pub_help').'</a>') . '</p>'
		//);
		$wxapp_info = RC_DB::table('platform_account')->where('id', intval($_GET['id']))->first();
		if (!empty($wxapp_info['logo'])) {
			$wxapp_info['logo'] = RC_Upload::upload_url($wxapp_info['logo']);
		}
		$this->assign('form_action', RC_Uri::url('weapp/admin/update'));
		$this->assign('wxapp_info', $wxapp_info);
		$this->display('weapp_edit.dwt');
	}
	
	/**
	 * 编辑小程序处理
	 */
	public function update() {
		$this->admin_priv('weapp_update', ecjia::MSGTYPE_JSON);
		
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		
		//获取旧的logo
		$old_logo = RC_DB::table('platform_account')->where('id', $id)->pluck('logo');
		
		if ((isset($_FILES['weapp_logo']['error']) && $_FILES['weapp_logo']['error'] == 0) || (!isset($_FILES['weapp_logo']['error']) && isset($_FILES['weapp_logo']['tmp_name'] ) &&$_FILES['weapp_logo']['tmp_name'] != 'none')) {
			$upload = RC_Upload::uploader('image', array('save_path' => 'data/weapp', 'auto_sub_dirs' => false));
			$image_info = $upload->upload($_FILES['weapp_logo']);
			
			if (!empty($image_info)) {
				//删除原来的logo
				if (!empty($old_logo)) {
					$upload->remove($old_logo);
				}
				$wxapp_logo = $upload->get_position($image_info);
			} else {
				return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			$wxapp_logo = $old_logo;
		}
		$data = array(
			'name'		=>	trim($_POST['name']),
			'logo'		=> 	$wxapp_logo,
			'appid'		=>	trim($_POST['appid']),
			'appsecret'	=>	trim($_POST['appsecret']),
			'sort'		=>	intval($_POST['sort']),
			'status'	=>	intval($_POST['status']),
		);
		
		RC_DB::table('platform_account')->where('id', $id)->update($data);
		
		ecjia_admin::admin_log($_POST['name'], 'edit', 'weapp');
		return $this->showmessage(RC_Lang::get('weapp::weapp.edit_weapp_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('weapp/admin/edit', array('id' => $id))));
	}

	
	/**
	 * 删除小程序
	 */
	public function remove()  {
		$this->admin_priv('weapp_delete', ecjia::MSGTYPE_JSON);
		
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		$info = RC_DB::table('platform_account')->where('id', $id)->select('name', 'logo')->first();
		
		if (!empty($info['logo'])){
			$disk = RC_Filesystem::disk();
			$disk->delete(RC_Upload::upload_path() . $info['logo']);
		}
		
		$success = RC_DB::table('platform_account')->where('id', $id)->delete();
		
		if ($success) {
			ecjia_admin::admin_log($info['name'], 'remove', 'weapp');
			return $this->showmessage(RC_Lang::get('weapp::weapp.remove_weapp_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('weapp/admin/init')));
		} else {
			return $this->showmessage(RC_Lang::get('weapp::weapp.remove_weapp_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 删除小程序logo
	 */
	public function remove_logo() {
		$this->admin_priv('weapp_update', ecjia::MSGTYPE_JSON);
		
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		
		$info = RC_DB::table('platform_account')->where('id', $id)->select('name', 'logo')->first();
		
		if (!empty($info['logo'])){
			$disk = RC_Filesystem::disk();
			$disk->delete(RC_Upload::upload_path() . $info['logo']);
		}
		$data = array('logo' => '');
		
		$update = RC_DB::table('platform_account')->where('id', $id)->update($data);
		
		ecjia_admin::admin_log(RC_Lang::get('weapp::weapp.weapp_name_is').$info['name'], 'remove', 'weapp_logo');
		
		if ($update) {
			return $this->showmessage(RC_Lang::get('weapp::weapp.remove_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage(RC_Lang::get('weapp::weapp.remove_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 切换状态
	 */
	public function toggle_show() {
		$this->admin_priv('weapp_update', ecjia::MSGTYPE_JSON);
		
		$id	 = intval($_POST['id']);
		$val = intval($_POST['val']);
		RC_DB::table('platform_account')->where('id', $id)->update(array('status' => $val));
		$name = RC_DB::table('platform_account')->where('id', $id)->pluck('name');
		if ($val == 1) {
			ecjia_admin::admin_log($name, 'use', 'weapp');
		} else {
			ecjia_admin::admin_log($name, 'stop', 'weapp');
		}
		
		return $this->showmessage(RC_Lang::get('weapp::weapp.switch_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $val, 'pjaxurl' => RC_Uri::url('weapp/admin/init')));
	}
	
	/**
	 * 排序
	 */
	public function edit_sort() {
		$this->admin_priv('weapp_update', ecjia::MSGTYPE_JSON);	
		$id    = intval($_POST['pk']);
		$sort  = trim($_POST['value']);
		if (!empty($sort)) {
			if (!is_numeric($sort)) {
				return $this->showmessage(RC_Lang::get('weapp::weapp.import_num'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				$update = RC_DB::table('platform_account')->where('id', $id)->update(array('sort' => $sort));
				if ($update) {
					return $this->showmessage(RC_Lang::get('weapp::weapp.editsort_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('weapp/admin/init')));
				} else {
					return $this->showmessage(RC_Lang::get('weapp::weapp.editsort_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
		} else {
			return $this->showmessage(RC_Lang::get('platform::platform.weappsort_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

	
	/**
	 * 批量删除
	 */
	public function batch_remove() {
		$this->admin_priv('weapp_delete', ecjia::MSGTYPE_JSON);
		
		$idArr	= explode(',', $_POST['id']);
		$count	= count($idArr);
		
		$info = RC_DB::table('platform_account')->whereIn('id', $idArr)->select('name')->get();
		
		foreach ($info as $v) {
			ecjia_admin::admin_log($v['name'], 'batch_remove', 'weapp');
		}
	
		RC_DB::table('platform_account')->whereIn('id', $idArr)->delete();
		return $this->showmessage(RC_Lang::get('weapp::weapp.deleted')."[ ".$count." ]".RC_Lang::get('weapp::weapp.record_account'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('weapp/admin/init')));
	}
	
	/**
	 * 小程序用户列表
	 */
	public function user_list() {
		$this->admin_priv('weapp_user_manage');
	
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('weapp::weapp.weapp_user_manage')));
		$this->assign('ur_here', RC_Lang::get('weapp::weapp.weapp_user_manage'));
		//$this->assign('action_link', array('text' => RC_Lang::get('weapp::weapp.weapp_add'), 'href'=>RC_Uri::url('weapp/admin/add')));
		
		//获取当前选中小程序的id
		$platform_account = platform_account::make(platform_account::getCurrentUUID('weapp'));
		$wechat_id = $platform_account->getAccountID();
		
		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('weapp::weapp.add_weapp_first'));
		} else{
			$weapp_user_list = $this->weapp_user_list($wechat_id);
			$this->assign('weapp_user_list', $weapp_user_list);
			
			//用户标签列表
			$tag_arr = array();
			$tag_arr['all']	= RC_DB::table('wechat_user')->where('wechat_id', $wechat_id)->where('subscribe', 1)->where('group_id', '!=', 1)->count();
			$tag_arr['item']= RC_DB::table('wechat_tag')->where('wechat_id', $wechat_id)->orderBy('id', 'desc')->selectRaw('id, tag_id, name, count')->get();
			$this->assign('tag_arr', $tag_arr);
			
			//取消关注用户数量
			$num = RC_DB::table('wechat_user')->where('wechat_id', $wechat_id)->where('subscribe', 0)->where('group_id', 0)->count();
			$this->assign('num', $num);
		}

		$this->assign('get_checked', RC_Uri::url('weapp/admin/get_checked_tag'));
		$this->assign('label_action', RC_Uri::url('weapp/admin/batch_tag'));
		
		$this->assign('search_action', RC_Uri::url('weapp/admin/user_list'));
	
		$this->display('weapp_user_list.dwt');
	}
	
	/**
	 * 添加用户标签
	 */
	public function edit_tag() {
		$this->admin_priv('update_user_tag', ecjia::MSGTYPE_JSON);
		
		//$uuid = platform_account::getCurrentUUID('weapp');		
		//$wechat = wechat_method::wechat_instance($uuid);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('weapp'));
		$wechat_id = $platform_account->getAccountID();
	
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('weapp::weapp.add_weapp_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	
		$id = !empty($_POST['id']) ? intval($_POST['id']) : 0;
		$name = !empty($_POST['new_tag']) ? $_POST['new_tag'] : '';
		if (empty($name)) {
			return $this->showmessage(RC_Lang::get('weapp::weapp.tag_name_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if (!empty($id)) {
			$data = array('name' => $name);
			$is_only = RC_DB::table('wechat_tag')->where(RC_DB::raw('id'), '!=', $id)->where(RC_DB::raw('name'), $name)->where(RC_DB::raw('wechat_id'), $wechat_id)->count();
			if ($is_only != 0 ) {
				return $this->showmessage(RC_Lang::get('weapp::weapp.tag_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
				
			//$tag_id = $this->wechat_tag->where(array('id' => $id))->get_field('tag_id');
			//微信端更新
			//$rs = $wechat->setTag($tag_id, $name);
			//if (RC_Error::is_error($rs)) {
			//	return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			//}
				
			//本地更新
			$update = RC_DB::table('wechat_tag')->where(RC_DB::raw('id'), $id)->where(RC_DB::raw('wechat_id'), $wechat_id)->update($data);
			
			//记录日志
			ecjia_admin::admin_log($name, 'edit', 'users_tag');
			if ($update) {
				return $this->showmessage(RC_Lang::get('weapp::weapp.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('weapp/admin/user_list')));
			} else {
				return $this->showmessage(RC_Lang::get('weapp::weapp.edit_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			$count = RC_DB::table('wechat_tag')->where(RC_DB::raw('wechat_id'), $wechat_id)->count();
			if ($count == 100) {
				return $this->showmessage(RC_Lang::get('weapp::weapp.up_tag_info'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
				
			$is_only = RC_DB::table('wechat_tag')->where(RC_DB::raw('name'), $name)->where(RC_DB::raw('wechat_id'), $wechat_id)->count();
			if ($is_only != 0 ) {
				return $this->showmessage(RC_Lang::get('weapp::weapp.tag_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
				
			//微信端添加
			//$rs = $wechat->addTag($name);
			//if (RC_Error::is_error($rs)) {
			//	return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			//}
			//$tag_id = $rs['tag']['id'];
			
			//生成tag_id
			$max_tag_id= RC_DB::table('wechat_tag')->where(RC_DB::raw('wechat_id'), $wechat_id)->max('tag_id');
			$tag_id = $max_tag_id > 100 ? ($max_tag_id + 1) : 101;
			//本地添加
			$data = array('name' => $name, 'wechat_id' => $wechat_id, 'tag_id' => $tag_id);
			$id = RC_DB::table('wechat_tag')->insertGetId($data);
			//记录日志
			ecjia_admin::admin_log($name, 'add', 'users_tag');
			if ($id) {
				return $this->showmessage(RC_Lang::get('weapp::weapp.add_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('weapp/admin/user_list')));
			} else {
				return $this->showmessage(RC_Lang::get('weapp::weapp.add_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
	}
		
	
	/**
	 * 获取选择用户的标签
	 */
	public function get_checked_tag() {
		$platform_account = platform_account::make(platform_account::getCurrentUUID('weapp'));
		$wechat_id = $platform_account->getAccountID();
	
		$uid = !empty($_POST['uid']) ? intval($_POST['uid']) : '';
		$tag_arr   = RC_DB::table('wechat_tag')->selectRaw('id, tag_id, name, count')->where(RC_DB::raw('wechat_id'), $wechat_id)->orderBy(RC_DB::raw('id'), 'desc')->get();
		
		$user_tag_list = array();
		if (!empty($uid)) {
			$user_tag_list = RC_DB::table('wechat_user_tag')->where(RC_DB::raw('userid'), $uid)->lists('tagid');
			if (empty($user_tag_list)) {
				$user_tag_list = array();
			}
		}
		foreach ($tag_arr as $k => $v) {
			if (in_array($v['tag_id'], $user_tag_list)) {
				$tag_arr[$k]['checked'] = 1;
			}
			if ($v['tag_id'] == 1) {
				unset($tag_arr[$k]);
			}
		}
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $tag_arr));
	}
	
	
	/**
	 * 删除标签
	 */
	public function remove_tag() {
		$this->admin_priv('user_tag_delete', ecjia::MSGTYPE_JSON);
	
		$tag_id = !empty($_GET['tag_id']) ? intval($_GET['tag_id']) : 0;
		$id     = !empty($_GET['id'])     ? intval($_GET['id'])     : 0;
	
		//$uuid = platform_account::getCurrentUUID('wechat');
		//$wechat = wechat_method::wechat_instance($uuid);
	
		$platform_account = platform_account::make(platform_account::getCurrentUUID('weapp'));
		$wechat_id = $platform_account->getAccountID();
	
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('weapp::weapp.add_weapp_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		//微信端删除
		//$rs = $wechat->deleteTag($tag_id);
		//if (RC_Error::is_error($rs)) {
		//	return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		//}
	
		//本地删除
		$name = RC_DB::table('wechat_tag')->where(RC_DB::raw('id'), $id)->pluck('name');
		$delete = RC_DB::table('wechat_tag')->where(RC_DB::raw('id'), $id)->where(RC_DB::raw('tag_id'), $tag_id)->delete();
		//记录日志
		ecjia_admin::admin_log($name, 'remove', 'users_tag');
		$tag_id = RC_DB::table('wechat_tag')->where(RC_DB::raw('id'), $id)->pluck('tag_id');
		RC_DB::table('wechat_user')->where(RC_DB::raw('group_id'), $tag_id)->update(array('group_id' => 0));
	
		if ($delete){
			return $this->showmessage(RC_Lang::get('weapp::weapp.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage(RC_Lang::get('weapp::weapp.remove_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 给用户批量打标签
	 */
	public function batch_tag() {
		$this->admin_priv('update_user_tag', ecjia::MSGTYPE_JSON);
		$platform_account = platform_account::make(platform_account::getCurrentUUID('weapp'));
		$wechat_id = $platform_account->getAccountID();
	
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('weapp::weapp.add_weapp_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$action = !empty($_GET['action']) 	? $_GET['action'] 	: '';
		$uid 	= !empty($_POST['uid']) 	? $_POST['uid'] 	: '';
		$openid = !empty($_POST['openid']) 	? $_POST['openid'] 	: '';
		$tag_id = !empty($_POST['tag_id']) 	? $_POST['tag_id'] 	: '';
		
		if (count($tag_id) > 3) {
			return $this->showmessage(RC_Lang::get('weapp::weapp.up_tag_count'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$openid_list = explode(',', $openid);
		
		$tag = array();
		$openids_no_tag = $openids_tag = array();
		foreach ($openid_list as $k => $v) {
			$db = RC_DB::table('wechat_user as wu')->leftJoin('wechat_user_tag as wut', RC_DB::raw('wu.uid'), '=', RC_DB::raw('wut.userid'));
			$tag = $db->where(RC_DB::raw('wu.openid'), $v)->where(RC_DB::raw('wu.wechat_id'), $wechat_id)->selectRaw('wut.tagid, wu.uid, wu.openid')->get();
			foreach ($tag as $key => $val) {
				if (empty($val['tagid'])) {
					//没有标签的用户
					$openids_no_tag['openid'][] = $val['openid'];
					$openids_no_tag['uid'][]	= $val['uid'];
				} else {
					//有标签的用户
					$openids_tag[$val['uid']][] = array('tagid' => $val['tagid'], 'openid' => $val['openid']);
				}
			}
		}
		
		if (!empty($openids_no_tag)) {
			//添加用户标签
			if (!empty($tag_id)) {
				foreach ($tag_id as $v) {
					//$rs = $wechat->setBatchTag($openids_no_tag['openid'], $v);
					//if (RC_Error::is_error($rs)) {
					//	return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
					//}
					
					foreach ($openids_no_tag['uid'] as $val) {
						//$this->wechat_user_tag->insert(array('userid' => $val, 'tagid' => $v));
						RC_DB::table('wechat_user_tag')->insertGetId(array('userid' => $val, 'tagid' => $v));
						//更新wechat_tag表中的count
						$this->update_count($v, $wechat_id);
					}
				}
			}
		}
	
		//取消用户标签
		if (!empty($openids_tag)) {
			foreach ($openids_tag as $k => $v) {
				//foreach ($v as $val) {
				//	$rs = $wechat->setBatchunTag($val['openid'], $val['tagid']);
				//	if (RC_Error::is_error($rs)) {
				//		return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				//	}
				//}
				RC_DB::table('wechat_user_tag')->where(RC_DB::raw('userid'), $k)->delete();
				foreach ($v as $val) {
					//更新wechat_tag表中的count
					$this->update_count($val['tagid'], $wechat_id);
				}
				$new_uid[] = $k;
				$new_openid[] = $val['openid'];
				
			}
				
			if (!empty($new_openid)) {
				$openid_unique = array_unique($new_openid);
			}
			if (!empty($tag_id)) {
				foreach ($tag_id as $v) {
					//$rs = $wechat->setBatchTag($openid_unique, $v);
					//if (RC_Error::is_error($rs)) {
					//	return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
					//}
					foreach ($new_uid as $val) {
						RC_DB::table('wechat_user_tag')->insertGetId(array('userid' => $val, 'tagid' => $v));
						//更新wechat_tag表中的count
						$this->update_count($v, $wechat_id);
					}
				}
			}
		}
		//$this->get_user_tags();
		if ($action == 'set_label') {
			$url = RC_Uri::url('weapp/admin/user_list', array('type' => 'all'));
		} elseif ($action == 'set_user_label') {
			$url = RC_Uri::url('weapp/admin/weapp_userinfo', array('uid' => $uid));
		}
		return $this->showmessage(RC_Lang::get('weapp::weapp.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $url));
	}
	
	/**
	 * 用户信息
	 */
	public function weapp_userinfo() {
		$this->admin_priv('view_weapp_userinfo');
	
		$platform_account = platform_account::make(platform_account::getCurrentUUID('weapp'));
		$wechat_id = $platform_account->getAccountID();
	
		$page = !empty($_GET['page']) ? intval($_GET['page']) : 1;
		$this->assign('ur_here', RC_Lang::get('weapp::weapp.weapp_userinfo'));
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('weapp::weapp.weapp_user_manage'), RC_Uri::url('weapp/admin/user_list')));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('weapp::weapp.weapp_userinfo')));
		$this->assign('action_link', array('text' => RC_Lang::get('weapp::weapp.weapp_user_manage'), 'href'=> RC_Uri::url('weapp/admin/user_list', array('page' => $page))));
	
		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('weapp::weapp.add_weapp_first'));
		} else {
			$uid = !empty($_GET['uid']) ? intval($_GET['uid']) : 0;
			$this->assign('label_action', RC_Uri::url('weapp/admin/batch_tag'));
			$this->assign('get_checked', RC_Uri::url('weapp/admin/get_checked_tag'));
	
			if (empty($uid)) {
				return $this->showmessage(RC_Lang::get('weapp::weapp.pls_select_user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$db = RC_DB::table('wechat_user as wu')
							->leftJoin('connect_user as cu', RC_DB::raw('wu.unionid'), '=', RC_DB::raw('cu.open_id'))
							->leftJoin('users as u', RC_DB::raw('u.user_id'), '=', RC_DB::raw('cu.user_id'));
			$db->where(RC_DB::raw('wu.wechat_id'), $wechat_id);
			
			$info = $db->where(RC_DB::raw('wu.uid'), $uid)->where(RC_DB::raw('wu.wechat_id'), $wechat_id)->selectRaw('wu.*, u.user_name')->first();
			if (!empty($info)) {
				if ($info['subscribe_time']) {
					$info['subscribe_time'] = RC_Time::local_date(ecjia::config('time_format'), $info['subscribe_time']);
				}
				$tag_list = RC_DB::table('wechat_user_tag')->where(RC_DB::raw('userid'), $info['uid'])->lists('tagid');
				if (!empty($tag_list)){
					$name_list = RC_DB::table('wechat_tag')->whereIn(RC_DB::raw('tag_id'), $tag_list)->where(RC_DB::raw('wechat_id'), $wechat_id)
					->orderBy(RC_DB::raw('tag_id'), 'desc')->lists('name');
					if (!empty($name_list)) {
						$info['tag_name'] = implode('，', $name_list);
					}
				}
			}
			$this->assign('info', $info);
		}
		
		$this->display('weapp_userinfo.dwt');
	}
	
	/**
	 * 修改用户备注
	 */
	public function edit_remark() {
		$this->admin_priv('update_usersinfo', ecjia::MSGTYPE_JSON);
	
		//$uuid = platform_account::getCurrentUUID('wechat');
		//$wechat = wechat_method::wechat_instance($uuid);
		$platform_account = platform_account::make(platform_account::getCurrentUUID('weapp'));
		$wechat_id = $platform_account->getAccountID();
		
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('weapp::weapp.add_weapp_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		// 数据更新
		$remark	= !empty($_POST['remark'])	? trim($_POST['remark']) : '';
		$openid = !empty($_POST['openid']) 	? trim($_POST['openid']) : '';
		$page 	= !empty($_POST['page']) 	? intval($_POST['page']) : 1;
		$uid 	= !empty($_POST['uid']) 	? intval($_POST['uid'])  : 0;
	
		if (strlen($remark) > 30) {
			return $this->showmessage(RC_Lang::get('weapp::weapp.up_remark_count'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		//微信端更新
		//$rs = $wechat->setUserRemark($openid, $remark);
		//if (RC_Error::is_error($rs)) {
		//	return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		//}
		$info = RC_DB::table('wechat_user')->where(RC_DB::raw('openid'), $openid)->first();
		$data = array('remark' => $remark);
		$update = RC_DB::table('wechat_user')->where(RC_DB::raw('openid'), $openid)->where(RC_DB::raw('wechat_id'), $wechat_id)->update($data);
		ecjia_admin::admin_log(sprintf(RC_Lang::get('weapp::weapp.edit_remark_to'), $info['nickname'], $remark), 'edit', 'users_info');
		if ($update) {
			return $this->showmessage(RC_Lang::get('weapp::weapp.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('weapp/admin/weapp_userinfo', array('uid' => $uid, 'page' => $page))));
		} else {
			return $this->showmessage(RC_Lang::get('weapp::weapp.edit_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 添加/移出黑名单
	 */
	public function backlist() {
		$this->admin_priv('update_usersinfo', ecjia::MSGTYPE_JSON);
	
		//$uuid = platform_account::getCurrentUUID('wechat');
		//$wechat = wechat_method::wechat_instance($uuid);
		$platform_account = platform_account::make(platform_account::getCurrentUUID('weapp'));
		$wechat_id = $platform_account->getAccountID();
	
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.add_weapp_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$uid 	= !empty($_GET['uid']) 		? intval($_GET['uid']) 		: 0;
		$type 	= !empty($_GET['type']) 	? trim($_GET['type']) 		: '';
		$page 	= !empty($_GET['page']) 	? intval($_GET['page']) 	: 1;
		$openid = !empty($_GET['openid']) 	? trim($_GET['openid']) 	: '';
	
		if ($type == 'remove_out') {
			$data['group_id']  = 0;
			$data['subscribe'] = 1;
			$sn                = RC_Lang::get('weapp::weapp.remove_blacklist');
			$success_msg       = RC_Lang::get('weapp::weapp.remove_blacklist_success');
			$error_msg         = RC_Lang::get('weapp::weapp.remove_blacklist_error');
		} else {
			$data['group_id']  = 1;
			$data['subscribe'] = 0;
			$sn                = RC_Lang::get('weapp::weapp.add_blacklist');
			$success_msg       = RC_Lang::get('weapp::weapp.add_blacklist_success');
			$error_msg         = RC_Lang::get('weapp::weapp.add_blacklist_error');
		}
	
		//微信端更新
		//$rs = $wechat->setUserGroup($openid, $data['group_id']);
		//if (RC_Error::is_error($rs)) {
		//	return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		//}
		ecjia_admin::admin_log($sn, 'setup', 'users_info');
		$update = RC_DB::table('wechat_user')->where(RC_DB::raw('uid'), $uid)->update($data);
	
		if ($update) {
			//$this->get_user_tags();
			return $this->showmessage($success_msg, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('weapp/admin/weapp_userinfo', array('uid' => $uid, 'page' => $page))));
		} else {
			return $this->showmessage($error_msg, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 更新wechat_tag表中count
	 * @param int $tagid
	 * @param int $wechat_id
	 */
	public function update_count($tagid, $wechat_id) {
		$userids = RC_DB::table('wechat_user_tag')->where(RC_DB::raw('tagid'), $tagid)->lists('userid');//当前tag_id所拥有的userids
		$uids =  RC_DB::table('wechat_user')->where(RC_DB::raw('wechat_id'), $wechat_id)->lists('uid');//所有小程序用户uids
		$arr = array_intersect($userids, $uids);//交集
		$count = count($arr);
		$result = RC_DB::table('wechat_tag')->where(RC_DB::raw('wechat_id'), $wechat_id)->where(RC_DB::raw('tag_id'), $tagid)->update(array('count' => $count));
		if ($result) {
			return true;
		}
	}
	
	/**
	 * 小程序列表
	 */
	private function weapp_list() {
		$db_platform_account = RC_DB::table('platform_account');
		$filter = array();
		$filter['keywords'] = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
		
		if ($filter['keywords']) {
			$db_platform_account->where(RC_DB::Raw('name'), 'like', '%' . mysql_like_quote($filter['keywords']) . '%');
		}
		$db_platform_account->where('platform', 'weapp');
	
		$count = $db_platform_account->count ();
		$filter['record_count'] = $count;
		$page = new ecjia_page($count, 10, 5);
	
		$arr = array();
		$data = $db_platform_account->orderBy(RC_DB::Raw('sort'), 'asc')->take(10)->skip($page->start_id-1)->get();
		if (isset($data)) {
			foreach ($data as $rows) {
				$rows['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $rows['add_time']);
				if (empty($rows['logo'])) {
					$rows['logo'] = RC_Uri::admin_url('statics/images/nopic.png');
				} else {
					$rows['logo'] = RC_Upload::upload_url($rows['logo']);
				}
				$arr[] = $rows;
			}
		}
		return array('item' => $arr, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());
	}
	
	
	/**
	 * 小程序用户列表
	 */
	private function weapp_user_list($weapp_id) {
		$db_wechat_user = RC_DB::table('wechat_user as wu')
							->leftJoin('platform_account as pa', RC_DB::raw('pa.id'), '=', RC_DB::raw('wu.wechat_id'));
		$filter = array();
		$filter['keywords'] = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
		$filter['type']     = isset($_GET['type'])     ? $_GET['type']  : 'all';
		
		//全部用户
		if ($filter['type'] == 'all') {
			$db_wechat_user->where(RC_DB::raw('wu.subscribe'), 1)->where(RC_DB::raw('wu.group_id'), '!=', 1);
			//标签用户
		} elseif ($filter['type'] == 'subscribed') {
			$tag_id = isset($_GET['tag_id']) ? $_GET['tag_id'] : '';
			if (!empty($tag_id)) {
				$user_list = RC_DB::table('wechat_user_tag')->where(RC_DB::raw('tagid'), $tag_id)->lists('userid');
				
				if (empty($user_list)) {
					$user_list = 0;
				}
				$db_wechat_user->where(RC_DB::raw('wu.group_id'), '!=', 1)->whereIn(RC_DB::raw('wu.uid'), $user_list);
			}
			//黑名单
		} elseif ($filter['type'] == 'blacklist') {
			$db_wechat_user->where(RC_DB::raw('wu.group_id'), 1);
			//取消关注
		} elseif ($filter['type'] == 'unsubscribe') {
			$db_wechat_user->where(RC_DB::raw('wu.subscribe'), 0)->where(RC_DB::raw('wu.group_id'), 0);
		}
	
		if ($filter['keywords']) {
			$db_wechat_user ->whereRaw('(wu.nickname like  "%' . mysql_like_quote($filter['keywords']) . '%" or wu.province like "%'.mysql_like_quote($filter['keywords']).'%" or wu.city like "%'.mysql_like_quote($filter['keywords']).'%")');
		}
		
		if ($weapp_id) {
			/*属于当前小程序用户筛选条件*/
			$db_wechat_user->where(RC_DB::raw('wu.wechat_id'), $weapp_id);
		} 

		$db_wechat_user->where(RC_DB::raw('pa.platform'), 'weapp');
		$count = $db_wechat_user->count (RC_DB::raw('wu.uid'));
		$filter['record_count'] = $count;
		$page = new ecjia_page($count, 10, 5);
	
		$arr = array();
		$data = $db_wechat_user
					->selectRaw('wu.*')
					->orderBy(RC_DB::Raw('subscribe_time'), 'desc')->take(10)->skip($page->start_id-1)->get();
		
		if (isset($data)) {
			foreach ($data as $rows) {
				//获取绑定会员的名称
					$user_name = RC_DB::table('connect_user as cu')
										->leftJoin('users as u', RC_DB::raw('cu.user_id'), '=', RC_DB::raw('u.user_id'))
										->where(RC_DB::raw('cu.open_id'), $rows['unionid'])
										->pluck('user_name');				
				if (!empty($user_name)){
					$rows['user_name'] = $user_name;
				} else {
					$rows['user_name'] = '暂未绑定';
				}				
				//关注时间
				$rows['subscribe_time'] = RC_Time::local_date(ecjia::config('time_format'), $rows['subscribe_time']);
				if (empty($rows['headimgurl'])) {
					$rows['headimgurl'] = RC_Uri::admin_url('statics/images/nopic.png');
				}
			
				//假如不是黑名单，获取用户标签
				if ($rows['group_id'] != 1) {
					$tag_list = RC_DB::table('wechat_user_tag')->where(RC_DB::raw('userid'), $rows['uid'])->lists('tagid');
					if (!empty($tag_list)) {
						$db = RC_DB::table('wechat_tag');
						$name_list = $db->whereIn(RC_DB::raw('tag_id'), $tag_list)->where(RC_DB::raw('wechat_id'), $weapp_id)->orderBy(RC_DB::raw('tag_id'), 'desc')->lists('name');
						if (!empty($name_list)) {
							$rows['tag_name'] = implode('，', $name_list);
						}
					}
				}				
				$arr[] = $rows;
			}
		}
		
		return array('item' => $arr, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());
	}
}

//end