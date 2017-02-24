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
/**
 * ECJIA 留言管理 -管理员留言程序
 */
defined('IN_ECJIA') or exit('No permission resources.');

class admin_message extends ecjia_admin {
	private $db_admin;
	private $db_message;
	private $db_session;
	private $db_view;
	
	public function __construct() {
		parent::__construct();
		
		$this->db_session	= RC_Loader::load_model('session_model');
		$this->db_admin		= RC_Model::model('admin_user_model');
		$this->db_message	= RC_Loader::load_model('admin_message_model');
		$this->db_view		= RC_Loader::load_model('admin_message_user_viewmodel');
	}
	
	
	/**
	 * 留言列表页面
	 */
	public function init() {
		
		/* 加载所需js */
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('ecjia-admin_cleditor', RC_Uri::admin_url() . '/statics/lib/CLEditor/jquery.cleditor.js', array('ecjia-admin'), false, true);
		RC_Script::enqueue_script('ecjia-admin_message_list');

		/* 页面所需CSS加载 */
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('bootstrap-responsive');
		RC_Style::enqueue_style('admin_cleditor_style', RC_Uri::admin_url() . '/statics/lib/CLEditor/jquery.cleditor.css');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('管理员留言')));	
		$this->assign('ur_here', __('管理员留言'));
		
		ecjia_screen::get_current_screen()->add_help_tab( array(
		'id'        => 'overview',
		'title'     => __('概述'),
		'content'   =>
		'<p>' . __('欢迎访问ECJia智能后台管理员留言页面，所有管理员可以在此进行留言交谈方便管理。') . '</p>'
		) );
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
		'<p><strong>' . __('更多信息：') . '</strong></p>' .
		'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:管理员留言" target="_blank">关于管理员留言帮助文档</a>') . '</p>'
		);

		//交谈用户id
		$chat_id = isset($_GET['chat_id'])	? intval($_GET['chat_id']) : 0;
		
		$chat_list = ecjia_admin_message::get_admin_chat();
		/* 获取管理员列表 */
		$admin_list = $this->db_admin->field('user_id, user_name')->select();
		$tmp_online = $this->db_session->field('adminid')->where(array('adminid' => array('gt' => 0)))->select();

        $admin_online_sort = $admin_id_sort = $admin_online = array();

		foreach ($tmp_online as $v) {
			$admin_online[] = $v['adminid'];
		}
		if (!empty($admin_list)) {
			foreach ($admin_list as $k => $v) {
				$admin_list[$k]['is_online'] = in_array($v['user_id'], $admin_online) ? 1 : 0;
				$v['user_id'] == $_SESSION['admin_id'] && $admin_list[$k]['is_online'] = 2;
				$v['user_id'] == $chat_id && $this->assign('chat_name' , $v['user_name']);
				
				$admin_list[$k]['icon'] = in_array($v['user_id'], $admin_online) ? RC_Uri::admin_url('statics/images/humanoidIcon_online.png') : RC_Uri::admin_url('statics/images/humanoidIcon.png');

				$admin_online_sort[$k] = $admin_list[$k]['is_online'];
				$admin_id_sort[$k] = $v['user_id'];
			}
		}
		//排序用户数组
		array_multisort($admin_online_sort, SORT_DESC, $admin_id_sort, SORT_ASC, $admin_list);

		$this->assign('admin_list',		$admin_list);
		$this->assign('message_list',	$chat_list['item']);
		$this->assign('message_lastid',	$chat_list['last_id']);
		
		$this->display('message_list.dwt');
	}
	
	/**
	 * 获取已读的留言
	 */
	public function readed_message() {
		/* 获取留言 */
		$list = ecjia_admin_message::get_admin_chat();
		$message = count($list['item']) < 10 ? __('没有更多消息了') : __('搜索到了');
		if (!empty($list['item'])) {
			return $this->showmessage($message, ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('msg_list' => $list['item'], 'last_id' => $list['last_id']));
		} else {
			return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

	/**
	 * 处理留言的发送
	 */
	public function insert() {
		$id = !empty($_REQUEST['chat_id']) ? intval($_REQUEST['chat_id']) : 0;
		$title = !empty($_POST['title']) ? $_POST['title'] : '';
		$data = array (
			'sender_id'		=> $_SESSION['admin_id'],
			'receiver_id'	=> $id,
			'sent_time'		=> RC_Time::gmtime(),
			'read_time'		=> '0',
			'readed'		=> '0',
			'deleted'		=> '0',
			'title'			=> $title,
			'message'		=> $_POST['message'],
		);
	
		if (!empty($_POST['message'])) {
			$messageone_id = $this->db_message->insert($data);
		}
		
		if ($messageone_id) {
			//回复消息之前，所有收到的消息设为已读
			ecjia_admin_message::read_meg($id);
			ecjia_admin::admin_log(__('发送留言'), 'add', 'admin_message');
			return $this->showmessage(__('发送成功'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('sent_time' => RC_Time::local_date(ecjia::config('time_format'), RC_Time::gmtime())));
		} else {
			return $this->showmessage(__('发送失败'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
}

// end