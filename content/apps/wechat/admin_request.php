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