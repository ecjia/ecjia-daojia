<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA扫码引荐
 */
class admin_share extends ecjia_admin {
	private $db_qrcode;
	private $db_platform_account;

	public function __construct() {
		parent::__construct();
		
		RC_Lang::load('wechat');
		RC_Loader::load_app_func('global');
		assign_adminlog_content();

		$this->db_qrcode = RC_Loader::load_app_model('wechat_qrcode_model');
		$this->db_platform_account = RC_Loader::load_app_model('platform_account_model', 'platform');
		
		RC_Loader::load_app_class('platform_account', 'platform', false);

		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('wechat_qrcodeshare', RC_App::apps_url('statics/js/wechat_qrcodeshare.js', __FILE__), array(), false, true);
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js') );
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		
		RC_Script::localize_script('wechat_qrcodeshare', 'js_lang', RC_Lang::get('wechat::wechat.js_lang'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.scan_code'), RC_Uri::url('wechat/admin_share/init')));
	}

	/**
	 * 扫码引荐列表加载
	 */
	public function init() {
		$this->admin_priv('wechat_share_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.scan_code')));
		$this->assign('action_link', array('text' => RC_Lang::get('wechat::wechat.add_qr_code'), 'href'=> RC_Uri::url('wechat/admin_share/add')));
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.scan_code_list'));
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
		} else { 
			$this->assign('warn', 'warn');
			$type = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
			$this->assign('type', $type);
			$this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_service_info'), RC_Lang::get('wechat::wechat.wechat_type.'.$type)));
			
			$listdb = $this->get_sharelist();
			$this->assign('listdb', $listdb);
		}
		
		$this->assign_lang();
		$this->display('wechat_share_list.dwt');
	}
	
	/**
	 * 添加扫码引荐
	 */
	public function add() {
		$this->admin_priv('wechat_share_add');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.add_qr_code')));
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.add_qr_code'));
		$this->assign('action_link', array('href' => RC_Uri::url('wechat/admin_share/init'), 'text' => RC_Lang::get('wechat::wechat.scan_code_list')));
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
		} else {
			$this->assign('warn', 'warn');
			$type = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
			$this->assign('type', $type);
			$this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_service_info'), RC_Lang::get('wechat::wechat.wechat_type.'.$type)));
			$this->assign('form_action', RC_Uri::url('wechat/admin_share/insert'));
		}
		
		$this->assign_lang();
		$this->display('wechat_share_edit.dwt');
	}
	
	/**
	 * 添加扫码引荐处理
	 */
	public function insert() {
		$this->admin_priv('wechat_share_add', ecjia::MSGTYPE_JSON);
	
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$data = array(
			'wechat_id'			=>	$wechat_id,
			'username'			=>	trim($_POST['username']),
			'scene_id'			=>	intval($_POST['scene_id']),
	  		'expire_seconds'	=>	intval($_POST['expire_seconds']),
			'function'			=>	$_POST['functions'],
			'sort'  			=>	intval($_POST['sort'])
		);
		$this->db_qrcode->insert($data);
		
		ecjia_admin::admin_log(sprintf(RC_Lang::get('wechat::wechat.recommended_person'), $_POST['username']), 'add', 'share');
		return $this->showmessage(RC_Lang::get('wechat::wechat.add_scan_code_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_share/init')));
	}
		
	/**
	 * 删除扫码引荐
	 */
	public function remove()  {
		$this->admin_priv('wechat_share_delete', ecjia::MSGTYPE_JSON);
		
		$id = intval($_GET['id']);
		$username = $this->db_qrcode->where(array('id' =>$id))->get_field('username');
		$this->db_qrcode->where(array('id' => $id))->delete();
		ecjia_admin::admin_log(sprintf(RC_Lang::get('wechat::wechat.recommended_person'), $username), 'remove', 'share');
		
		return $this->showmessage(RC_Lang::get('wechat::wechat.remove_scan_code_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_share/init')));
	}
		
	/**
	 * 手动排序
	 */
	public function edit_sort() {
		$this->admin_priv('wechat_share_update', ecjia::MSGTYPE_JSON);

		$id    = intval($_POST['pk']);
		$sort  = trim($_POST['value']);
		$username = $this->db_qrcode->where(array('id' =>$id))->get_field('username');
		if (!empty($sort)) {
			if (!is_numeric($sort)) {
				return $this->showmessage(RC_Lang::get('wechat::wechat.qrcode_sort_numeric'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				if ($this->db_qrcode->where(array('id' => $id))->update(array('sort' => $sort))) {
					ecjia_admin::admin_log(sprintf(RC_Lang::get('wechat::wechat.recommended_person'), $username), 'edit', 'share');
					return $this->showmessage(RC_Lang::get('wechat::wechat.edit_sort_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('wechat/admin_share/init')));
				}
			}
		} else {
			return $this->showmessage(RC_Lang::get('wechat::wechat.qrcode_sort_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 取得二维码信息
	 */
	private function get_sharelist() {
		$db_qrcode = RC_Loader::load_app_model('wechat_qrcode_model');
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		$where[] ="wechat_id = '" .$wechat_id. "' and username is not null";
		$count = $db_qrcode->where($where)->count();
		$page = new ecjia_page($count, 10, 5);
	
		$arr = array ();
		$data = $db_qrcode->where($where)->order('sort asc')->limit($page->limit())->select();
		if (isset($data)) {
			foreach ($data as $rows) {
				$arr [] = $rows;
			}
		}
		return array ('share_list' => $arr, 'page' => $page->show (5), 'desc' => $page->page_desc());
	}
}

//end