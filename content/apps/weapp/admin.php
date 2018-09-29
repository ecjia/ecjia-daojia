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
		
		Ecjia\App\Weapp\Helper::assign_adminlog_content();
		
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
	
	public function autologin()
	{
		$id = $this->request->input('id');
	
		$uuid = RC_DB::table('platform_account')->where('id', $id)->pluck('uuid');
		if (empty($uuid)) {
			return $this->showmessage(__('该小程序不存在', 'app-weapp'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
		}
	
		//公众平台的超管权限同平台后台的权限
		if (session('action_list') == all) {
			$user = new Ecjia\System\Admins\Users\AdminUser(session('admin_id'), '\Ecjia\App\Platform\Frameworks\Users\AdminUserAllotPurview');
			if ($user->getActionList() != 'all') {
				$user->setActionList('all');
			}
		}
	
		$authcode_array = [
			'uuid' => $uuid,
			'user_id' => session('admin_id'),
			'user_type' => 'admin',
			'time' => RC_Time::gmtime(),
		];
	
		$authcode_str = http_build_query($authcode_array);
		$authcode = RC_Crypt::encrypt($authcode_str);
	
		if (defined('RC_SITE')) {
			$index = 'sites/' . RC_SITE . '/index.php';
		} else {
			$index = 'index.php';
		}
	
		$url = str_replace($index, "sites/platform/index.php", RC_Uri::url('platform/privilege/autologin')) . '&authcode=' . $authcode;
		return $this->redirect($url);
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
	
}

//end