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
 * ECJIA短信模块
 * @author songqian
 */
class admin extends ecjia_admin {
	private $db_sms_sendlist;
	
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		$this->db_sms_sendlist 	= RC_Model::model('sms/sms_sendlist_model');
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		
		//时间控件
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
		
		RC_Script::enqueue_script('sms', RC_App::apps_url('statics/js/sms.js', __FILE__), array(), false, true);
		RC_Script::localize_script('sms', 'js_lang', RC_Lang::get('sms::sms.js_lang'));
		
		RC_Style::enqueue_style('hint.min', RC_Uri::admin_url('statics/lib/hint_css/hint.min.css'));
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('sms::sms.sms_record_list'), RC_Uri::url('sms/admin/init')));
	}
					
	/**
	 * 发送短信页面
	 */
	public function display_send_ui() {
	    $this->admin_priv('sms_send_manage');
	    
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('sms::sms.send_sms')));
	    $this->assign('action_link', array('text' => RC_Lang::get('sms::sms.sms_record_list'), 'href'=> RC_Uri::url('sms/admin/init')));
		$this->assign('ur_here', RC_Lang::get('sms::sms.send_sms'));

		$special_ranks = RC_Model::Model('sms/sms_user_rank_model')->get_rank_list();
		$send_rank['1_0'] = RC_Lang::get('sms::sms.user_list');
		
		foreach ($special_ranks as $rank_key => $rank_value) {
			$send_rank['2_' . $rank_key] = $rank_value;
		}
		$this->assign('send_rank', $send_rank);
		$this->assign('form_action', RC_Uri::url('sms/admin/send_sms'));
		
		$this->display('sms_send.dwt');
	}
			
	/**
	 * 发送短信处理
	 */
	public function send_sms() {	
		$send_num = isset($_POST['send_num']) ? $_POST['send_num'] : '';
		
		if (isset($send_num)) {
			$phone = $send_num.',';
		}
		$send_rank = isset($_POST['send_rank']) ? $_POST['send_rank'] : 0;
		
		if ($send_rank != 0) {
			$rank_array = explode('_', $send_rank);
			if ($rank_array['0'] == 1) {
				$data = RC_DB::table('users')->where('mobile_phone', '!=', '')->select('mobile_phone')->get();
				
				if (!empty($data)) {
					foreach ($data as $rank_rs) {
						$value[] = $rank_rs['mobile_phone'];
					}
				}
			} else {
				$rank_row = RC_DB::table('user_rank')->where('rank_id', $rank_array['1'])->first();
				
				foreach ($data as $rank_rs) {
					$value[] = $rank_rs['mobile_phone'];
				}
			}
			if (isset($value)) {
				$phone .= implode(',', $value);
			}
		}
		$msg       = isset($_POST['msg'])       ? $_POST['msg']         : '';
		$send_date = isset($_POST['send_date']) ? $_POST['send_date']   : '';
		$link[]    = array('text' => RC_Lang::get('system::system.back') .  RC_Lang::get('sms::sms.sms_record'), 'href' => 'index.php?m=admincp&c=admin&a=display_send_ui');
	}
		
	/**
	 * 显示发送记录的
	 */
	public function init() {
		$this->admin_priv('sms_history_manage');
	
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('sms::sms.sms_record')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('sms::sms.overview'),
			'content'	=> '<p>' . RC_Lang::get('sms::sms.sms_history_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('sms::sms.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:短信记录" target="_blank">'. RC_Lang::get('sms::sms.about_sms_history') .'</a>') . '</p>'
		);
		
		$this->assign('action_link', array('text' => RC_Lang::get('sms::sms.add_sms_send'), 'href'=> RC_Uri::url('sms/admin/display_send_ui')));
		$this->assign('ur_here', RC_Lang::get('sms::sms.sms_record_list'));
		
		$listdb = $this->db_sms_sendlist->get_sendlist();
		$this->assign('listdb', $listdb);

		$this->assign('search_action', RC_Uri::url('sms/admin/init'));
	
		$this->display('sms_send_history.dwt');
	}
	
	/**
	 * 再次发送短信
	 */
	public function resend() {
		$this->admin_priv('sms_history_manage');
		
		$smsid  = intval($_GET['id']);
		$result = \Ecjia\App\Sms\SmsManager::make()->resend($smsid);
		ecjia_admin::admin_log(sprintf(RC_Lang::get('sms::sms.receive_number_is'), $smsid), 'setup', 'sms_record');
		if (is_ecjia_error($result)) {
			return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('sms/admin/init')));
		}else{
			return $this->showmessage(RC_Lang::get('sms::sms.send_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('sms/admin/init')));
		}
	}
	
	/**
	 * 批量再次发送短信记录
	 */
	public function batch_resend() {
		$this->admin_priv('sms_history_manage');
		
		$smsids = explode(",", $_POST['sms_id']);
		
		foreach ($smsids as $value) {
			$result = \Ecjia\App\Sms\SmsManager::make()->resend($value);
		}
		
		if (is_ecjia_error($result)) {
			return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('sms/admin/init')));
		} else {
			return $this->showmessage(RC_Lang::get('sms::sms.batch_send_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('sms/admin/init')));
		}
	}
}

//end