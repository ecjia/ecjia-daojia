<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA二维码
 */
class admin_qrcode extends ecjia_admin {
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
		RC_Script::enqueue_script('wechat_qrcode', RC_App::apps_url('statics/js/wechat_qrcode.js', __FILE__), array(), false, true);
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js') );
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		
		RC_Script::localize_script('wechat_qrcode', 'js_lang', RC_Lang::get('wechat::wechat.js_lang'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.qrcode_manage'), RC_Uri::url('wechat/admin_qrcode/init')));
	}

	/**
	 * 二维码列表
	 */
	public function init() {
		$this->admin_priv('wechat_qrcode_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.qrcode_manage')));
		$this->assign('action_link', array('text' => RC_Lang::get('wechat::wechat.add_qr_code'), 'href'=> RC_Uri::url('wechat/admin_qrcode/add')));
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.qrcode_manage'));

		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('wechat::wechat.overview'),
			'content'	=> '<p>' . RC_Lang::get('wechat::wechat.qrcode_content') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:二维码管理#.E4.BA.8C.E7.BB.B4.E7.A0.81.E7.AE.A1.E7.90.86" target="_blank">'.RC_Lang::get('wechat::wechat.qrcode_help').'</a>') . '</p>'
		);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		if(is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
		} else {
			$this->assign('warn', 'warn');
			$type = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
			$this->assign('type', $type);
			$this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_service_info'), RC_Lang::get('wechat::wechat.wechat_type.'.$type)));
			
			$listdb = $this->get_qrcodelist();
			$this->assign('listdb', $listdb);
			$this->assign('search_action', RC_Uri::url('wechat/admin_qrcode/init'));
		}

		$this->assign_lang();
		$this->display('wechat_qrcode_list.dwt');
	}
	
	/**
	 * 添加二维码页面
	 */
	public function add() {
		$this->admin_priv('wechat_qrcode_add');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.add_qr_code')));
		
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.add_qr_code'));
		$this->assign('action_link', array('href' => RC_Uri::url('wechat/admin_qrcode/init'), 'text' => RC_Lang::get('wechat::wechat.qrcode_list')));
		
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('wechat::wechat.overview'),
			'content'	=> '<p>' . RC_Lang::get('wechat::wechat.qrcode_add_content') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:二维码管理#.E6.B7.BB.E5.8A.A0.E4.BA.8C.E7.BB.B4.E7.A0.81" target="_blank">'.RC_Lang::get('wechat::wechat.qrcode_add_help').'</a>') . '</p>'
		);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		if(is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
		} else {
			$this->assign('warn', 'warn');
			$type = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
			$this->assign('type', $type);
			$this->assign('form_action', RC_Uri::url('wechat/admin_qrcode/insert'));
		}
		
		$this->assign_lang();
		$this->display('wechat_qrcode_edit.dwt');
	}
	
	/**
	 * 添加二维码处理
	 */
	public function insert() {
		$this->admin_priv('wechat_qrcode_add', ecjia::MSGTYPE_JSON);
	
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$type 			= isset($_POST['type']) 			? intval($_POST['type']) 			: 0;
		$expire_seconds = isset($_POST['expire_seconds']) 	? intval($_POST['expire_seconds']) 	: 0;
		$functions 		= isset($_POST['functions']) 		? $_POST['functions'] 				: '';
		$scene_id 		= isset($_POST['scene_id']) 		? intval($_POST['scene_id']) 		: 0;
		$status 		= isset($_POST['status']) 			? intval($_POST['status']) 			: 0;
		$sort 			= isset($_POST['sort']) 			? intval($_POST['sort']) 			: 0;

		$data = array(
			'wechat_id'			=>	$wechat_id,
			'type'				=>	$type,
	  		'expire_seconds'	=>	$expire_seconds,
			'function'			=>	$functions,
			'scene_id'			=>	$scene_id,
			'status' 	 		=>	$status,
			'sort'  			=>	$sort
		);
		$this->db_qrcode->insert($data);
		
		ecjia_admin::admin_log(sprintf(RC_Lang::get('wechat::wechat.function_is'), $functions), 'add', 'qrcode');
		return $this->showmessage(RC_Lang::get('wechat::wechat.add_qrcode_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_qrcode/init')));
	}
		
	/**
	 * 删除二维码
	 */
	public function remove()  {
		$this->admin_priv('wechat_qrcode_delete', ecjia::MSGTYPE_JSON);
		
		$id = intval($_GET['id']);
		$function = $this->db_qrcode->where(array('id' => $id))->get_field('function');
		
		$this->db_qrcode->where(array('id' => $id))->delete();
		
		ecjia_admin::admin_log(sprintf(RC_Lang::get('wechat::wechat.function_is'), $function), 'remove', 'qrcode');
		return $this->showmessage(RC_Lang::get('wechat::wechat.remove_qrcode_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_qrcode/init')));
	}
	
	/**
	 * 批量删除二维码
	 */
	public function batch() {
		$this->admin_priv('wechat_qrcode_delete', ecjia::MSGTYPE_JSON);
		
		$info = $this->db_qrcode->in(array('id' => $_POST['id']))->select();
		
		$success = $this->db_qrcode->in(array('id' => $_POST['id']))->delete();
		
		foreach ($info as $v) {
			ecjia_admin::admin_log(sprintf(RC_Lang::get('wechat::wechat.function_is'), $v['function']), 'batch_remove', 'qrcode');
		}
		return $this->showmessage(RC_Lang::get('wechat::wechat.batch_operate_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_qrcode/init')));
	}
	
	/**
	 * 更新并获取二维码
	 */
	public function qrcode_get() {
		$this->admin_priv('wechat_qrcode_update', ecjia::MSGTYPE_JSON);
		
		$this->admin_priv('wechat_subscribe_manage');
		
		$uuid = platform_account::getCurrentUUID('wechat');
		
		$id = $_GET['id'];
		$field = 'type, scene_id, expire_seconds, qrcode_url, status, function';
		$qrcode = $this->db_qrcode->field($field)->find(array('id' => $id));
		if ($qrcode['status'] == 0) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.pls_restart'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (empty($qrcode['qrcode_url'])) {
			if($qrcode['type'] == 0) {
				$data = array(
					'expire_seconds' => $qrcode['expire_seconds'],
					'action_name'    => 'QR_SCENE',
					'action_info'    => array('scene'=>(array('scene_id' => $qrcode['scene_id'])))
				);
			} else {
				$data = array(
					'action_name' => 'QR_LIMIT_SCENE',
					'action_info' => array('scene'=>(array('scene_id' => $qrcode['scene_id'])))
				);
			}
			RC_Loader::load_app_class('wechat_method', 'wechat', false);
			$wechat = wechat_method::wechat_instance($uuid);
			// 获取二维码ticket
			$ticket = $wechat->getQrcodeTicket($data);
			if (RC_Error::is_error($ticket)) {
				return $this->showmessage(wechat_method::wechat_error($ticket->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				$data['ticket'] = $ticket['ticket'];
				$data['expire_seconds'] = $ticket['expire_seconds'];
				if($qrcode['type'] == 0) {
					$data['endtime'] = time() + $ticket['expire_seconds'];
				}
				// 二维码地址
				$data['qrcode_url'] = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$data['ticket'];
				$this->db_qrcode->where(array('id' => $id))->update($data);
				$qrcode_url = $data['qrcode_url'];
			}
		} else {
			$qrcode_url = $qrcode['qrcode_url'];
		}
		ecjia_admin::admin_log(sprintf(RC_Lang::get('wechat::wechat.function_is'), $qrcode['function']), 'setup', 'qrcode');
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $qrcode_url));
	}
	
	/**
	 * 切换状态
	 */
	public function toggle_show() {
		$this->admin_priv('wechat_qrcode_update', ecjia::MSGTYPE_JSON);
	
		$id     = intval($_POST['id']);
		$val    = intval($_POST['val']);
		
		$function = $this->db_qrcode->where(array('id' => $id))->get_field('function');
		$this->db_qrcode->where(array('id' => $id))->update(array('status' => $val));
		
		if ($val == 1) {
			ecjia_admin::admin_log(sprintf(RC_Lang::get('wechat::wechat.open_function_is'), $function), 'setup', 'qrcode');
		} else {
			ecjia_admin::admin_log(sprintf(RC_Lang::get('wechat::wechat.close_function_is'), $function), 'setup', 'qrcode');
		}
		return $this->showmessage(RC_Lang::get('wechat::wechat.edit_status_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_qrcode/init')));
	}
	
	/**
	 * 手动排序
	 */
	public function edit_sort() {
		$this->admin_priv('wechat_qrcode_update', ecjia::MSGTYPE_JSON);

		$id    = intval($_POST['pk']);
		$sort  = trim($_POST['value']);
		$function = $this->db_qrcode->where(array('id' =>$id))->get_field('function');
		if (!empty($sort)) {
			if (!is_numeric($sort)) {
				return $this->showmessage(RC_Lang::get('wechat::wechat.qrcode_sort_numeric'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				if ($this->db_qrcode->where(array('id' => $id))->update(array('sort' => $sort))) {
					ecjia_admin::admin_log(sprintf(RC_Lang::get('wechat::wechat.function_is'), $function), 'edit', 'qrcode');
					return $this->showmessage(RC_Lang::get('wechat::wechat.edit_sort_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('wechat/admin_qrcode/init')) );
				}
			}
		} else {
			return $this->showmessage(RC_Lang::get('wechat::wechat.qrcode_sort_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 取得二维码信息
	 */
	private function get_qrcodelist() {
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$db_qrcode = RC_Loader::load_app_model('wechat_qrcode_model');
		
		$filter = array ();
		$filter['keywords'] = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);

		if ($filter['keywords']) {
			$where[]= "function LIKE '%" . mysql_like_quote($filter['keywords']) . "%'";
		}
		$where[] ="wechat_id = '" .$wechat_id. "' and username is null";
		$count = $db_qrcode->where($where)->count();
		$page = new ecjia_page($count,10, 5);
	
		$arr = array ();
		$data = $db_qrcode->where($where)->order('sort asc')->limit($page->limit())->select();
		if (isset($data)) {
			foreach ($data as $rows) {
				$arr [] = $rows;
			}
		}
		return array ('qrcode_list' => $arr, 'filter'=>$filter, 'page' => $page->show(5), 'desc' => $page->page_desc());
	}
}

//end