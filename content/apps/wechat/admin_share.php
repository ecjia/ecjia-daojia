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