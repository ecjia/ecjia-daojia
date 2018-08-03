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
class admin extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();

        Ecjia\App\Sms\Helper::assign_adminlog_content();

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
     * 显示发送记录的
     */
    public function init()
    {
        $this->admin_priv('sms_history_manage');

        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('sms::sms.sms_record')));
        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => RC_Lang::get('sms::sms.overview'),
            'content' => '<p>' . RC_Lang::get('sms::sms.sms_history_help') . '</p>',
        ));

        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . RC_Lang::get('sms::sms.more_info') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:短信记录" target="_blank">' . RC_Lang::get('sms::sms.about_sms_history') . '</a>') . '</p>'
        );

        $this->assign('action_link', array('text' => RC_Lang::get('sms::sms.add_sms_send'), 'href' => RC_Uri::url('sms/admin/display_send_ui')));
        $this->assign('ur_here', RC_Lang::get('sms::sms.sms_record_list'));

        $listdb = $this->get_sendlist();
        $this->assign('listdb', $listdb);

        $this->assign('search_action', RC_Uri::url('sms/admin/init'));

        $this->display('sms_send_history.dwt');
    }

    /**
     * 再次发送短信
     */
    public function resend()
    {
        $this->admin_priv('sms_history_manage');

        $smsid  = intval($_GET['id']);
        $result = \Ecjia\App\Sms\SmsManager::make()->resend($smsid);
        ecjia_admin::admin_log(sprintf(RC_Lang::get('sms::sms.receive_number_is'), $smsid), 'setup', 'sms_record');
        if (is_ecjia_error($result)) {
            return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('sms/admin/init')));
        } else {
            return $this->showmessage(RC_Lang::get('sms::sms.send_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('sms/admin/init')));
        }
    }

    /**
     * 批量再次发送短信记录
     */
    public function batch_resend()
    {
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
    
    /**
     * 获取短信发送记录列表
     */
   	private function get_sendlist() {
    	$start_date	= empty($_GET['start_date'])	? '' : RC_Time::local_strtotime($_GET['start_date']);
    	$end_date	= empty($_GET['end_date']) 		? '' : RC_Time::local_strtotime($_GET['end_date']);
    	$keywords	= empty($_GET['keywords']) 		? '' : trim($_GET['keywords']);
    	 
    	$where = array();
    	$filter['keywords']   = $keywords;
    	$filter['start_date'] = $start_date;
    	$filter['end_date']   = $end_date;
    	$filter['errorval']   = empty($_GET['errorval']) ? 0 : intval($_GET['errorval']);
    	 
    	$db_sms_sendlist = RC_DB::table('sms_sendlist');
    	 
    	if ($filter['keywords']) {
    		$db_sms_sendlist->where(function($query) use ($keywords) {
    			$query->where('mobile', 'like', '%'.mysql_like_quote($keywords).'%')->orWhere('sms_content', 'like', '%'.mysql_like_quote($keywords).'%');
    		});
    	}
    
    	if ($filter['start_date'] ) {
    		$db_sms_sendlist->where('last_send', '>=', $start_date);
    	}
    
    	if ($filter['end_date']) {
    		$db_sms_sendlist->where('last_send', '<=', $end_date);
    	}
    	 
    	$msg_count = $db_sms_sendlist->select(RC_DB::raw('count(*) AS count, SUM(IF(error > 0, 1, 0)) AS faild, SUM(IF(error = 0, 1, 0)) AS success, SUM(IF(error < 0, 1, 0)) AS wait'))
    	->first();
    
    	$msg_count = array(
    			'count'		=> empty($msg_count['count']) 	? 0 : $msg_count['count'],
    			'faild'	    => empty($msg_count['faild']) 	? 0 : $msg_count['faild'],
    			'success'	=> empty($msg_count['success']) ? 0 : $msg_count['success'],
    			'wait'	    => empty($msg_count['wait']) 	? 0 : $msg_count['wait']
    	);
    	 
    	//待发送
    	if ($filter['errorval'] == 1) {
    		$where['error'] = -1;
    		 
    		$db_sms_sendlist->where('error', '=', -1);
    	}
    
    	//发送成功
    	if ($filter['errorval'] == 2) {
    		$where['error'] = 0;
    		 
    		$db_sms_sendlist->where('error', '=', 0);
    	}
    
    	//发送失败
    	if ($filter['errorval'] == 3) {
    		$where['error'] = array('gt' => 0);
    		 
    		$db_sms_sendlist->where('error', '>', 0);
    	}
    
    	$count = $db_sms_sendlist->count();
    	$page = new ecjia_page($count, 15, 6);
    	 
    	$row = $db_sms_sendlist->select('*')->orderby('last_send', 'desc')->take(15)->skip($page->start_id-1)->get();
    
    	if (!empty($row)) {
    		foreach ($row AS $key => $val) {
    			$row[$key]['last_send'] = RC_Time::local_date(ecjia::config('time_format'), $val['last_send']);
    			$row[$key]['channel_name'] = RC_DB::table('notification_channels')->where('channel_code', $val['channel_code'])->pluck('channel_name');
    		}
    	}
    
    	$filter['start_date'] = RC_Time::local_date(ecjia::config('date_format'), $filter['start_date']);
    	$filter['end_date']   = RC_Time::local_date(ecjia::config('date_format'), $filter['end_date']);
    	 
    	return array('item' => $row, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc(), 'msg_count' => $msg_count);
    }
}

//end
