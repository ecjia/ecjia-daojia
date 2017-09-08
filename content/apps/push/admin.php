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
 * ECJIA消息模块
 */
class admin extends ecjia_admin {

	public function __construct() {
		parent::__construct();
		
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
		
		RC_Script::enqueue_script('push', RC_App::apps_url('statics/js/push.js', __FILE__), array(), false, true);
		RC_Script::enqueue_script('push_action', RC_App::apps_url('statics/js/push_action.js', __FILE__), array(), false, true);
		
		RC_Style::enqueue_style('push_event', RC_App::apps_url('statics/css/push_event.css', __FILE__), array(), false, false);
		RC_Style::enqueue_style('push_action', RC_App::apps_url('statics/css/push_action.css', __FILE__), array(), false, false);
		
		RC_Style::enqueue_style('hint.min', RC_Uri::admin_url('statics/lib/hint_css/hint.min.css'));
		
		RC_Script::localize_script('push', 'js_lang', RC_Lang::get('push::push.js_lang'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('push::push.msg_record'), RC_Uri::url('push/admin/init')));
	}

	/**
	 * 显示发送记录的
	 */
	public function init() {
		$this->admin_priv('push_history_manage');

		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('push::push.msg_record')));
		
		$this->assign('action_link_device', array('text' => '群发推送', 'href'=> RC_Uri::url('push/admin/push_action')));
		$this->assign('ur_here', RC_Lang::get('push::push.msg_record_list'));
		
		$listdb = $this->get_sendlist();
		$this->assign('listdb', $listdb);
		
		$this->assign('search_action', RC_Uri::url('push/admin/init'));
			
		$this->display('push_send_history.dwt');
	}
	
	/**
	 * 发送消息页面
	 */
	public function push_action() {
		$this->admin_priv('push_message');
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('push::push.msg_push')));
		$this->assign('ur_here', '消息推送');
		$this->assign('action_link', array('text' => '消息记录列表', 'href' => RC_Uri::url('push/admin/init')));

		$product_device_list = $this->get_product_device_list();
		$this->assign('product_device_list', $product_device_list);

		$this->assign('form_action', RC_Uri::url('push/admin/push_action_insert'));
		$push['device_token'] = 'broadcast';
		$this->assign('push', $push);
		
		$this->display('push_send.dwt');
	}
	
	
	/**
	 * 选择产品获取不同推送对象
	 */
	public function ajax_event_select(){
		$this->admin_priv('push_message');
		
		$device_code = $_POST['device_code'];
		if (!empty($device_code)) {
			$client_info = with(new Ecjia\App\Mobile\ApplicationFactory)->client($device_code);
			$push_object = $client_info->getPlatform()->getOpenTypes();
			$object_data = array();
			foreach ($push_object as $k => $event) {
				$object_data[$k]['name'] = $event->getName();
				$object_data[$k]['type'] = $event->getOpenType();
			}
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('object_data' => $object_data));
		}	
	}
	
	
	/**
	 * 选择产品获取不同推送对象
	 */
	public function ajax_event_input(){
		$this->admin_priv('push_message');
		
		$device_code = $_POST['device_code'];
		$object_type = $_POST['object_type'];
		if(!empty($object_type)) {
			$client_info = with(new Ecjia\App\Mobile\ApplicationFactory)->client($device_code);
			$object_info = $client_info->getPlatform()->getOpenTypes($object_type);
			$args = $object_info->getArguments();
			
			$args_list = array();
			foreach ($args as $k => $event) {
				$args_list[$k]['code'] = $event->getCode();
				$args_list[$k]['name'] = $event->getNmae();
				$args_list[$k]['description'] = $event->getDescription();
			}
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('args_list' => $args_list));
		}
	}
	

	/**
	 * 消息主题 title
	 * 消息内容 content
	 * 推送产品 push_product_device
	 * 推送行为  打开动作 object_value
	 * 动作参数args=array();
	 * 推送对象 target=0 全部 1=单播【device_token】
	 * 推送时机 priority 1及时 0稍候
	 */
	public function push_action_insert() {
		$this->admin_priv('push_message');
		
		$title = trim($_POST['title']);
		$content = trim($_POST['content']);
		$device_code = trim($_POST['push_product_device']);//6001
		
		$open_type = trim($_POST['object_value']);//打开动作
		if (!empty($open_type)) {
			$args = $_POST['args'];
			$arr= array(
				'open_type' => $open_type,
			);
			if(!empty($args)) {
				$field = array_merge($args, $arr);
			} else {
				$field = $arr;
			}
		} else {
			$field = [];
		}
		$target = $_POST['target'];
		$priority = intval($_POST['priority']);
		$push_content = new \Ecjia\App\Push\PushContent();
		$push_content->setContent($content);
		$push_content->setSubject($title);
		if ($target == 1) {
			$device_token = trim($_POST['device_token']);
			$result = \Ecjia\App\Push\PushManager::make()
			->setPushContent($push_content)
			->unicastSend($device_code, $device_token, $field, $priority);
		} elseif($target =='admin' || $target =='user' || $target =='merchant' ) {
			$admin_id  = intval($_POST['admin_id']);
			$uid       = intval($_POST['user_id']);
			$merchant_user_id = intval($_POST['merchant_user_id']);
			if (!empty($admin_id)) {
				$user_id = $admin_id;
			} elseif (!empty($uid)) {
				$user_id = $uid;
			} elseif (!empty($merchant_user_id)) {
				$user_id = $merchant_user_id;
			}
			if(!empty($user_id)) {
				$result = \Ecjia\App\Push\PushManager::make()
				->setPushUser(new Ecjia\App\Mobile\User($target, $user_id))
				->setPushContent($push_content)
				->userSend($field, $priority);
			} else {
				return $this->showmessage('未获取到要推送的用户', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			$result = \Ecjia\App\Push\PushManager::make()
			->setPushContent($push_content)
			->broadcastSend($device_code, $field, $priority);
		}

		if (is_ecjia_error($result)) {
			return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}else{
			return $this->showmessage('推送成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('push/admin/init')));
		}
	}

	/**
	 * 再次推送消息（单条）
	 */
	public function resend() {
		$this->admin_priv('push_message');
		
		$pushid  = intval($_GET['message_id']);
		$result = \Ecjia\App\Push\PushManager::make()->resend($pushid);
		
		if (is_ecjia_error($result)) {
			return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('push/admin/init')));
		}else{
			return $this->showmessage('推送成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('push/admin/init')));
		}
	}
		
	/**
	 * 批量再次推送消息
	 */
	public function batch_resend() {
		$this->admin_priv('push_message');
	
		$pushids = explode(",", $_POST['message_id']);
	
		foreach ($pushids as $value) {
			$result = \Ecjia\App\Push\PushManager::make()->resend($value);
		}
	
		if (is_ecjia_error($result)) {
			return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('push/admin/init')));
		} else {
			return $this->showmessage('消息推送成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('push/admin/init')));
		}
	}
	
	
	/**
	 *copy消息页面
	 */
	public function push_copy() {
		$this->admin_priv('push_message');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('消息复用'));
		$this->assign('ur_here', '消息复用');
		$this->assign('action_link', array('text' => '消息记录列表', 'href' => RC_Uri::url('push/admin/init')));
		
		//获取产品
		$product_device_list = $this->get_product_device_list();
		$this->assign('product_device_list', $product_device_list);
		
		$message_id = intval($_GET['message_id']);
		$push = RC_DB::table('push_message')->where('message_id', $message_id)->first();
	
		$push['extradata'] = unserialize($push['extradata']);
		$open_type = $push['extradata']['open_type'];
		$this->assign('open_type', $open_type);
		
		
		//获取打开动作列表
		$client_info = with(new Ecjia\App\Mobile\ApplicationFactory)->client($push['device_code']);
		$push_object = $client_info->getPlatform()->getOpenTypes();
		$action_list = array();
		foreach ($push_object as $k => $event) {
			$action_list[$event->getOpenType()] = $event->getName();
		}
		$this->assign('action_list', $action_list);
		

		//获取打开动作信息
		$object_info = $push_object[$open_type];
		$args = $object_info->getArguments();
		$args_list = array();
		foreach ($args as $k => $event) {
			$args_list[$k]['code'] = $event->getCode();
			$args_list[$k]['name'] = $event->getNmae().'：';
			$args_list[$k]['description'] = $event->getDescription();
		}
		
		foreach ($args_list as $k => $v) {
			if (array_key_exists($v['code'], $push['extradata'])) {
				$args_list[$k]['value'] = $push['extradata'][$v['code']];
			}
		}
		$this->assign('args_list', $args_list);
		
		$this->assign('push', $push);
		$this->assign('form_action', RC_Uri::url('push/admin/push_action_insert'));

		$this->display('push_send.dwt');
	}

	
	/**
	 * 获取推送消息的列表信息
	 */
	private function get_sendlist() {
		$keywords = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
			
		$where = array();
		$filter['keywords']   = $keywords;
		$filter['errorval']   = empty($_GET['errorval']) ? 0 : intval($_GET['errorval']);
			
		$db_push_sendlist = RC_DB::table('push_message');
			
		if ($filter['keywords']) {
			$db_push_sendlist->where(function($query) use ($keywords) {
				$query->where('title', 'like', '%'.mysql_like_quote($keywords).'%');
			});
		}
	
		$msg_count = $db_push_sendlist
		->select(RC_DB::raw('count(*) AS count, SUM(IF(in_status = 0, 1, 0)) AS faild, SUM(IF(in_status = 1, 1, 0)) AS success, SUM(IF(in_status < 0, 1, 0)) AS wait'))
		->first();
	
		$msg_count = array(
			'count'		=> empty($msg_count['count']) 	? 0 : $msg_count['count'],
			'faild'	    => empty($msg_count['faild']) 	? 0 : $msg_count['faild'],
			'success'	=> empty($msg_count['success']) ? 0 : $msg_count['success'],
			'wait'	    => empty($msg_count['wait']) 	? 0 : $msg_count['wait']
		);
			
		//待发送
		if ($filter['errorval'] == 1) {
			$db_push_sendlist->where('in_status', '=', -1);
		}
	
		//发送成功
		if ($filter['errorval'] == 2) {
			$db_push_sendlist->where('in_status', '=', 1);
		}
	
		//发送失败
		if ($filter['errorval'] == 3) {
			$db_push_sendlist->where('in_status', '=', 0);
		}
	
		$count = $db_push_sendlist->count();
		$page = new ecjia_page($count, 15, 6);
			
		$row = $db_push_sendlist
		->select('*')->orderby('push_time', 'desc')
		->take(15)
		->skip($page->start_id-1)
		->get();
		
		$device_list = with(new Ecjia\App\Mobile\Models\MobileManageModel)->getAllDeviceCode();
		if (!empty($row)) {
			foreach ($row AS $key => $val) {
				$row[$key]['push_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['push_time']);
				$device_info = array_get($device_list, $val['device_code']);
				$row[$key]['app_name'] = $device_info['app_name'];
			}
		}
		return array('item' => $row, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc(), 'msg_count' => $msg_count);
	}
	
	/**
	 * 获取产品
	 */
	private function get_product_device_list() {
		$product_device_list = RC_DB::TABLE('mobile_manage')->select('app_name', 'device_client', 'platform', 'device_code')->get();

		$android_img = RC_App::apps_url('statics/images/android.png', __FILE__);
		$iphone_img = RC_App::apps_url('statics/images/iphone.png', __FILE__);
		$wechant_img = RC_App::apps_url('statics/images/wechant.png', __FILE__);
		$h5_img = RC_App::apps_url('statics/images/h5.png', __FILE__);
		
		foreach ($product_device_list as $key => $val) {
			if ($val['device_client'] == 'iphone') {
		
				$product_device_list[$key]['client_name'] = 'iPhone';
				$product_device_list[$key]['icon'] = $iphone_img;
					
			} elseif ($val['device_client'] == 'android') {
		
				$product_device_list[$key]['client_name'] = 'Android';
				$product_device_list[$key]['icon'] = $android_img;
					
			} elseif ($val['device_client'] == 'h5') {
		
				$product_device_list[$key]['client_name'] = 'H5';
				$product_device_list[$key]['icon'] = $h5_img;
					
			} elseif ($val['device_client'] == 'weapp') {
		
				$product_device_list[$key]['client_name']= 'Weapp';
				$product_device_list[$key]['icon'] = $wechant_img;
		
			}
		}
	
		return $product_device_list;
	}
	
	//搜索管理员
	public function search_admin_list() {
		$this->admin_priv('push_message');
		
		$admin_list = array();
        $admin_keywords = trim($_POST['admin_keywords']);
        if(!empty($admin_keywords)) {
        	$list = RC_DB::TABLE('admin_user')->where('user_name', 'like', '%'.mysql_like_quote($admin_keywords).'%')->select('user_id', 'user_name')->get();
        	if (!empty($list)) {
        		foreach ($list AS $key => $val) {
        			$admin_list[] = array(
        				'value' => $val['user_id'],
        				'text'  => $val['user_name'],
        			);
        		}
        	}
        }
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $admin_list));
	}
	
	

	//搜索会员
	public function search_user_list() {
		$this->admin_priv('push_message');
		
		$user_list = array();
		$user_keywords = trim($_POST['user_keywords']);
		if(!empty($user_keywords)) {
			$list = RC_DB::TABLE('users')->where('mobile_phone', 'like', '%'.mysql_like_quote($user_keywords).'%')->select('user_id', 'user_name')->get();
			if (!empty($list)) {
				foreach ($list AS $key => $val) {
					$user_list[] = array(
						'value' => $val['user_id'],
						'text'  => $val['user_name'],
					);
				}
			}
		}
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $user_list));
	}
	
	

	//搜索商家会员
	public function search_merchant_list() {
		$this->admin_priv('push_message');
		
		$mer_user_list = array();
		$mer_keywords = trim($_POST['mer_keywords']);
		if(!empty($mer_keywords)) {
			$list = RC_DB::TABLE('staff_user')->where('mobile', 'like', '%'.mysql_like_quote($mer_keywords).'%')->select('user_id', 'name')->get();
			if (!empty($list)) {
				foreach ($list AS $key => $val) {
					$mer_user_list[] = array(
						'value' => $val['user_id'],
						'text'  => $val['name'],
					);
				}
			}
		}
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $mer_user_list));
	}
		
}

//end