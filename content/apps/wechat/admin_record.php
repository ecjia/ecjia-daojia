<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA客服会话记录
 */
class admin_record extends ecjia_admin {
	private $wu_viewdb;
	private $wechat_user_db;
	private $wechat_user_group;
	private $wechat_tag;
	private $customer_session_viewdb;
	private $db_platform_account;
	private $db_customer_session;
	private $wechat_customer;
	private $wechat_user_tag;

	public function __construct() {
		parent::__construct();
		
		RC_Lang::load('wechat');
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		$this->wu_viewdb = RC_Loader::load_app_model('wechat_user_viewmodel');
		$this->wechat_user_db = RC_Loader::load_app_model('wechat_user_model');
		$this->wechat_user_group = RC_Loader::load_app_model('wechat_user_group_model');
		$this->wechat_tag = RC_Loader::load_app_model('wechat_tag_model');
		$this->wechat_customer = RC_Loader::load_app_model('wechat_customer_model');
		$this->wechat_user_tag = RC_Loader::load_app_model('wechat_user_tag_model');
		
		$this->customer_session_viewdb = RC_Loader::load_app_model('wechat_customer_session_viewmodel');
		$this->db_customer_session = RC_Loader::load_app_model('wechat_customer_session_model');
		$this->db_platform_account = RC_Loader::load_app_model('platform_account_model', 'platform');
		
		RC_Loader::load_app_class('platform_account', 'platform', false);
		RC_Loader::load_app_class('wechat_method', 'wechat', false);
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('admin_record', RC_App::apps_url('statics/js/admin_record.js', __FILE__));
		RC_Style::enqueue_style('admin_subscribe', RC_App::apps_url('statics/css/admin_subscribe.css', __FILE__));
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js') );
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		
		RC_Script::localize_script('admin_record', 'js_lang', RC_Lang::get('wechat::wechat.js_lang'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.customer_chat_record'), RC_Uri::url('wechat/admin_record/init')));
	}
	
	//客服消息记录列表
	public function init() {
		$this->admin_priv('wechat_record_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.customer_chat_record')));
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.customer_chat_record'));

		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
		} else {
			$this->assign('warn', 'warn');
			$this->assign('action', RC_Uri::url('wechat/admin_record/init'));
			$kf_list = $this->wechat_customer->where(array('wechat_id' => $wechat_id))->order(array('id' => 'asc'))->field('id, kf_nick, kf_account')->select();
			$this->assign('kf_list', $kf_list);
			
			$list = $this->get_record_list();
			$this->assign('list', $list);
			//获取公众号类型 0未认证 1订阅号 2服务号 3认证服务号 4企业号
			$types = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
			$this->assign('type', $types);
			$this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_service_info'), RC_Lang::get('wechat::wechat.wechat_type.'.$types)));
		}
		
		$this->assign_lang();
		$this->display('wechat_record_list.dwt');
	}
	
	//查看用户客服消息记录
	public function record_message() {
		$this->admin_priv('wechat_record_manage', ecjia::MSGTYPE_JSON);
	
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
	
		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
		} else {
			$this->assign('warn', 'warn');
			//获取公众号类型 0未认证 1订阅号 2服务号 3认证服务号 4企业号
			$type = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
			$this->assign('type', $type);
			$this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_subscribe_info'), RC_Lang::get('wechat::wechat.wechat_type.'.$type)));
		}
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.customer_message_record')));
	
		$uid          = !empty($_GET['uid'])          ? $_GET['uid']              : '';
		$page         = !empty($_GET['page'])         ? intval($_GET['page'])     : 1;
		$status       = !empty($_GET['status'])       ? intval($_GET['status'])   : 1;
		$kf_account   = !empty($_GET['kf_account'])   ? $_GET['kf_account']       : '';
	
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.customer_message_record'));
		$this->assign('action_link', array('text' => RC_Lang::get('wechat::wechat.customer_chat_record'), 'href'=> RC_Uri::url('wechat/admin_record/init', array('status' => $status, 'kf_account' => $kf_account, 'page' => $page))));
		$this->assign('chat_action', RC_Uri::url('wechat/admin_record/send_message'));
		$this->assign('last_action', RC_Uri::url('wechat/admin_record/read_message'));
	
		if (empty($uid)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.pls_select_user'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
		}
		
		$info = $this->wu_viewdb->join('users')->field('u.*, us.user_name')->where(array('u.uid' => $uid, 'u.wechat_id' => $wechat_id))->find();

		if ($info['subscribe_time']) {
			$info['subscribe_time'] = RC_Time::local_date(ecjia::config('time_format'), $info['subscribe_time'] - 8*3600);
		}
		$info['platform_name'] 	= $this->db_platform_account->where(array('id' => $wechat_id))->get_field('name');
		$info['name'] = $this->wechat_user_group->where(array('wechat_id' => $wechat_id, 'group_id' => $info['group_id']))->get_field('name');
	
		$this->assign('info', $info);
		$message = $this->get_message_list();
		$this->assign('message', $message);
	
		//最后发送时间
		$last_send_time = $this->customer_session_viewdb->join(null)->where(array('openid' => $info['openid'], 'opercode' => 2002))->order(array('cs.id' => 'desc'))->limit(1)->get_field('time');
		$time = RC_Time::gmtime();
		if ($time - $last_send_time > 48*3600) {
			$this->assign('disabled', '1');
		}
		$this->assign_lang();
		$this->display('wechat_record_message.dwt');
	}
	
	//获取消息列表
	public function get_record_list() {
		$customer_session_viewdb = RC_Loader::load_app_model('wechat_customer_session_viewmodel');
		$db_platform_account = RC_Loader::load_app_model('platform_account_model', 'platform');
		$wechat_user_db = RC_Loader::load_app_model('wechat_user_model');
	
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		$platform_name = $db_platform_account->where(array('id' => $wechat_id))->get_field('name');
	
		$openid_list = $wechat_user_db->where(array('wechat_id' => $wechat_id))->get_field('openid', true);
		$where = 'cs.opercode = 2003 and cs.wechat_id ='.$wechat_id;
	
		$filter['kf_account'] = !empty($_GET['kf_account']) ? $_GET['kf_account']     : '';
		$filter['status']     = !empty($_GET['status'])     ? intval($_GET['status']) : 1;
		
		if ($filter['kf_account']) {
			$where .= " and cs.kf_account = "."'$filter[kf_account]'";
		}
		
		$time_1 = RC_Time::local_mktime(0, 0, 0, date('m'), date('d')-4, date('Y'));
		$time_2 = RC_Time::local_mktime(0, 0, 0, date('m'), date('d')+1, date('Y'));
		$time_3 = RC_Time::local_mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$time_4 = RC_Time::local_mktime(0, 0, 0, date('m'), date('d')+1, date('Y'));
		
		$time_5 = RC_Time::local_mktime(0, 0, 0, date('m'), date('d')-1, date('Y'));
		$time_6 = RC_Time::local_mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		
		$time_7 = RC_Time::local_mktime(0, 0, 0, date('m'), date('d')-2, date('Y'));
		$time_8 = RC_Time::local_mktime(0, 0, 0, date('m'), date('d')-1, date('Y'));
		
		$time_9 = RC_Time::local_mktime(0,0,0, date('m'), date('d')-4, date('Y'));
	
		$where1 = $where.' and cs.time > '.$time_1.' and cs.time < '.$time_2;
		$where2 = $where.' and cs.time > '.$time_3.' and cs.time < '.$time_4;
		$where3 = $where.' and cs.time > '.$time_5.' and cs.time < '.$time_6;
		$where4 = $where.' and cs.time > '.$time_7.' and cs.time < '.$time_8;
		$where5 = $where.' and cs.time > 0'.' and cs.time < '.$time_9;
		
		switch ($filter['status']) {
			case '1' :
				$start_date = $time_1;
				$end_date = $time_2;
				break;
			case '2' :
				$start_date = $time_3;
				$end_date = $time_4;
				break;
			case '3' :
				$start_date = $time_5;
				$end_date = $time_6;
				break;
			case '4' :
				$start_date = $time_7;
				$end_date = $time_8;
				break;
			case '5' :
				$start_date = 0;
				$end_date = $time_9;
				break;
		}
		$where .= ' and cs.time > '.$start_date.' and cs.time < '.$end_date;
		
		$filter['last_five_days'] 			= count($customer_session_viewdb->join(array('wechat_user', 'wechat_customer'))->field('max(cs.id) as id')->where($where1)->group('cs.openid')->select());
		$filter['today'] 					= count($customer_session_viewdb->join(array('wechat_user', 'wechat_customer'))->field('max(cs.id) as id')->where($where2)->group('cs.openid')->select());
		$filter['yesterday'] 				= count($customer_session_viewdb->join(array('wechat_user', 'wechat_customer'))->field('max(cs.id) as id')->where($where3)->group('cs.openid')->select());
		$filter['the_day_before_yesterday'] = count($customer_session_viewdb->join(array('wechat_user', 'wechat_customer'))->field('max(cs.id) as id')->where($where4)->group('cs.openid')->select());
		$filter['earlier'] 					= count($customer_session_viewdb->join(array('wechat_user', 'wechat_customer'))->field('max(cs.id) as id')->where($where5)->group('cs.openid')->select());
		
		$total = $customer_session_viewdb->join(array('wechat_user', 'wechat_customer'))->field('max(cs.id) as id')->where($where)->group('cs.openid')->select();
		$count = count($total);
		$page = new ecjia_page($count, 10, 5);
		$list = $customer_session_viewdb->join(array('wechat_user', 'wechat_customer'))->field('max(cs.id) as id, wu.*')->where($where)->group('cs.openid')->limit($page->limit())->order(array('cs.time' => 'desc'))->select();
		
		$row = array();
		if (!empty($list)) {
			foreach ($list as $key => $val) {
				$info = $customer_session_viewdb->join(null)->find(array('cs.id' => $val['id']));
				$list[$key]['time']		= RC_Time::local_date(ecjia::config('time_format'), $info['time']);
				$list[$key]['text'] 	= $info['text'];
				$list[$key]['openid'] 	= $info['openid'];
			}
			$row = $this->array_sequence($list, 'time');
		}
		return array('item' => $row, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'filter' => $filter);
	}
	
	//获取信息
	public function read_message() {
		$this->admin_priv('wechat_record_manage', ecjia::MSGTYPE_JSON);
	
		$list = $this->get_message_list();
		$message = count($list['item']) < 10 ? RC_Lang::get('wechat::wechat.no_more_message') : RC_Lang::get('wechat::wechat.searched');
		if (!empty($list['item'])) {
			return $this->showmessage($message, ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('msg_list' => $list['item'], 'last_id' => $list['last_id']));
		} else {
			return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	//获取用户客服消息列表
	public function get_message_list() {
		$customer_session_viewdb = RC_Loader::load_app_model('wechat_customer_session_viewmodel');
	
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		$platform_name = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('name');
	
		$uid     = !empty($_GET['uid'])     ? $_GET['uid']             : '';
		$last_id = !empty($_GET['last_id']) ? intval($_GET['last_id']) : 0;
		$chat_id = !empty($_GET['chat_id']) ? $_GET['chat_id']         : 0;
		
		$openid = $this->wechat_user_db->where(array('uid' => $uid))->get_field('openid');
	
		if (!empty($last_id)) {
			$where =  "cs.openid = '".$chat_id."' AND cs.id <".$last_id;
		} else {
			$where =  "cs.openid = '".$openid."' ";
		}
		
		$count = $customer_session_viewdb->join(null)->where($where)->count();
		$page = new ecjia_page($count, 10, 5);
		$limit = $page->limit();
		$list = $customer_session_viewdb->join(array('wechat_user', 'wechat_customer'))->field('cs.*, c.kf_nick, wu.nickname')->where($where)->order(array('cs.time' => 'desc'))->limit($limit)->select();
		
		if (!empty($list)) {
			foreach ($list as $key => $val) {
				$list[$key]['time'] = RC_Time::local_date(ecjia::config('time_format'), $val['time']);
				if (!empty($val['iswechat'])) {
					$list[$key]['nickname'] = $platform_name;
				}
			}
			$end_list = end($list);
			$reverse_list = array_reverse($list);
		} else {
			$end_list = null;
			$reverse_list = null;
		}
		return array('item' => $reverse_list, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'last_id' => $end_list['id']);
	}
	
	//排序
	public function array_sequence($array, $field, $sort = 'SORT_DESC') {
		$arrsort = array();
		foreach ($array as $uniqid => $row) {
			foreach ($row as $key => $value) {
				$arrsort[$key][$uniqid] = $value;
			}
		}
		array_multisort($arrsort[$field], constant($sort), $array);
		return $array;
	}
	
	//获取用户信息
	public function get_user_info() {
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$uid = !empty($_GET['uid']) ? intval($_GET['uid']) : 0;
		$info = $this->wu_viewdb->join(array('users'))->field('u.*, us.user_name')->find(array('u.uid' => $uid, 'u.wechat_id' => $wechat_id));
		if ($info['subscribe_time']) {
			$info['subscribe_time'] = RC_Time::local_date(ecjia::config('time_format'), $info['subscribe_time']-8*3600);
			$tag_list = $this->wechat_user_tag->where(array('userid' => $info['uid']))->get_field('tagid', true);
			$name_list = $this->wechat_tag->where(array('tag_id' => $tag_list, 'wechat_id' => $wechat_id))->order(array('tag_id' => 'desc'))->get_field('name', true);
			if (!empty($name_list)) {
				$info['tag_name'] = implode('，', $name_list);
			} else {
				$info['tag_name'] = RC_Lang::get('wechat::wechat.no_tag');
			}
		}
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $info));
	}
	
	//获取客服会话聊天记录
	public function get_customer_record() {
		$this->admin_priv('wechat_record_manage', ecjia::MSGTYPE_JSON);
		
		$uuid = platform_account::getCurrentUUID('wechat');
		$wechat = wechat_method::wechat_instance($uuid);
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$start_time = RC_Time::local_mktime(0, 0, 0, date('m'), date('d')-4, date('Y')) + 28800;
		$end_time = RC_Time::local_mktime(0, 0, 0, date('m'), date('d')-3, date('Y')) + 28800;

		$p = 0;
		$id_list = $this->db_customer_session->where(array('wechat_id' => $wechat_id))->get_field('id', true);
		for ($j=1; $j<=5; $j++) {
			for ($i=1; ; $i++) {
				$info = $wechat->getMsgrecord($start_time, $end_time, $i, 50);
				if (RC_Error::is_error($info)) {
					return $this->showmessage(wechat_method::wechat_error($info->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
				$arr = array();
				if (!empty($info['recordlist'])) {
					foreach ($info['recordlist'] as $key => $val) {
						$data['wechat_id'] 	= $wechat_id;
						$data['kf_account'] = $val['worker'];
						$data['openid'] 	= $val['openid'];
						$data['opercode'] 	= $val['opercode'];
						$data['text'] 		= $val['text'];
						$data['time'] 		= $val['time']-8*3600;
						$arr[] = $data;
					}
					$this->db_customer_session->batch_insert($arr);
					$p++;
				} else {
					$start_time = RC_Time::local_mktime(0, 0, 0, date('m'), date('d')-4, date('Y')) + 28800;
					$end_time = RC_Time::local_mktime(0, 0, 0, date('m'), date('d')-3, date('Y')) + 28800;
					break;
				}
			}
			$start_time = $start_time + $j * 24*3600;
			$end_time = $end_time + $j * 24*3600;
		}
		if ($p > 0 && !empty($id_list)) {
			$this->db_customer_session->where(array('wechat_id' => $wechat_id, 'id' => $id_list))->delete();
		}
		return $this->showmessage(RC_Lang::get('wechat::wechat.get_message_record_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_record/init')));
	}
}

//end