<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA API请求次数统计
 */
class admin_request extends ecjia_admin {
	public function __construct() {
		parent::__construct();
		
		RC_Lang::load('wechat');
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
		RC_Script::enqueue_script('admin_request', RC_App::apps_url('statics/js/admin_request.js', __FILE__), array(), false, true);
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::localize_script('admin_request', 'js_lang', RC_Lang::get('wechat::wechat.js_lang'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.api_request_list'), RC_Uri::url('wechat/admin_request/init')));
	}

	/**
	 * Api请求次数统计列表
	 */
	public function init() {
		$this->admin_priv('wechat_request_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.api_request')));
		$this->assign('ur_list', RC_Lang::get('wechat::wechat.api_request_list'));
		
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('wechat::wechat.overview'),
			'content'	=>
			'<p>' . RC_Lang::get('wechat::wechat.api_request_statistics') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('wechat::wechat.lable_more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:API请求统计" target="_blank">'.RC_Lang::get('wechat::wechat.api_statistics_document').'</a>') . '</p>'
		);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.add_accounts_operation'));
		} else {
			$limits['item'] = RC_Loader::load_app_config('api_limit', 'wechat');
			$type = !empty($_GET['type']) ? intval($_GET['type']) : 1; //1今天 2昨天
			
			$list = $this->get_list();
			if (!empty($limits['item'])) {
				foreach ($limits['item'] as $k => $v) {
					if (!empty($list)) {
						foreach ($list as $key => $val) {
							if ($k == $val['api_name']) {
								$limits['item'][$k]['info'] = $val;
							}
						}	
					}
					//次数无限制的不显示
					if ($v['times'] == '') {
						unset($limits['item'][$k]);
					}
				}
			}
			$limits['date']['today'] = RC_Time::local_date(ecjia::config('date_format'), RC_Time::gmtime());
			$limits['date']['yesterday'] = RC_Time::local_date(ecjia::config('date_format'), RC_Time::gmtime()-86400);
			
			$this->assign('type', $type);
			$this->assign('list', $limits);
		}
		
		$this->assign_lang();
		$this->display('wechat_request_list.dwt');
	}
	
	private function get_list() {
		$db_request = RC_Loader::load_app_model('wechat_request_times_model');
	
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$where = "wechat_id = '$wechat_id'";
		$type = !empty($_GET['type']) ? intval($_GET['type']) : 1;
		
		//今天
		if ($type == 1) {
			$start_date = RC_Time::local_date(ecjia::config('date_format'), RC_Time::local_mktime(0,0,0,date('m'),date('d')-1,date('Y')));
			$end_date = RC_Time::local_date(ecjia::config('date_format'), RC_Time::local_mktime(0,0,0,date('m'),date('d')+1,date('Y')));
			
			$where .= " AND day > '$start_date' AND day < '$end_date' ";
		//昨天
		} elseif ($type == 2) {
			$start_date = RC_Time::local_date(ecjia::config('date_format'), RC_Time::local_mktime(0,0,0,date('m'),date('d')-2,date('Y')));
			$end_date = RC_Time::local_date(ecjia::config('date_format'), RC_Time::local_mktime(0,0,0,date('m'),date('d'),date('Y')));
				
			$where .= " AND day > '$start_date' AND day < '$end_date' ";
		} 
		
		$data = $db_request->where($where)->order('last_time asc')->select();
		if (!empty($data)) {
			foreach ($data as $k => $v) {
				if (isset($v['day'])) {
					$data[$k]['date'] = $v['day'];
				}
				$data[$k]['last_time'] = RC_Time::local_date('Y-m-d H:i:s', $v['last_time']);
			}
		}
		return $data;
	}
}

//end