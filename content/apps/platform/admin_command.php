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
 * 公众平台命令速查
 */
class admin_command extends ecjia_admin {
	private $command_viewdb;
	private $db_platform_account;
	private $db_extend;
	private $db_platform_config;
	private $dbview_platform_config;
	private $db_command;
	private $db_oauth;

	public function __construct() {
		parent::__construct();
		
		RC_Lang::load('platform');
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		$this->command_viewdb = RC_Loader::load_app_model('platform_command_viewmodel');
		$this->db_platform_account = RC_Loader::load_app_model('platform_account_model');
		$this->db_platform_config = RC_Loader::load_app_model('platform_config_model');
		$this->db_extend = RC_Loader::load_app_model('platform_extend_model');
		$this->dbview_platform_config = RC_Loader::load_app_model('platform_config_viewmodel');
		$this->db_command = RC_Loader::load_app_model('platform_command_model');
		$this->db_oauth = RC_Loader::load_app_model('wechat_oauth_model', 'wechat');

		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js') );
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::enqueue_script('platform', RC_App::apps_url('statics/js/platform.js', __FILE__), array(), false, true);
		RC_Style::enqueue_style('wechat_extend', RC_App::apps_url('statics/css/wechat_extend.css', __FILE__));
		RC_Script::localize_script('platform', 'js_lang', RC_Lang::get('platform::platform.js_lang'));
	}

	/**
	 * 查询页面
	 */
	public function search() {
		$this->admin_priv('platform_command_manage');
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('platform::platform.command_search')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('platform::platform.summarize'),
			'content'	=>
			'<p>' . RC_Lang::get('platform::platform.welcome') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('platform::platform.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:命令速查" target="_blank">'.RC_Lang::get('platform::platform.command_search_help').'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('platform::platform.command_search'));
		$this->assign('search_action', RC_Uri::url('platform/admin_command/search'));
		
		$keywords = !empty($_GET['keywords']) ? trim($_GET['keywords']) : '';
		$platform = !empty($_GET['platform']) ? $_GET['platform'] : '';
		$where = '';
		if (!empty($keywords)) {
			$where['c.cmd_word'] = array('like' => '%'.$keywords.'%');
		}
		
		$list = array();
		if (!empty($keywords)) {
			if (!empty($platform)) {
				$where['c.platform'] = $platform;
			}
			$where['a.shop_id'] = 0;
			$count = $this->command_viewdb->join(array('platform_extend', 'platform_account'))->where($where)->count();
			$page = new ecjia_page($count, 20, 5);
			
			$arr = $this->command_viewdb->join(array('platform_extend', 'platform_account'))->field('e.ext_name, c.*, a.name')->where($where)->limit($page->limit())->select();
			$list = array ('item' => $arr, 'page' => $page->show(5), 'desc' => $page->page_desc());
		}
		$this->assign('keywords', $keywords);
		$this->assign('list', $list);
		
		$this->assign_lang();
		$this->display('command_search_list.dwt');
	}
	
	/**
	 * 查看公众号扩展下的命令
	 */
	public function init() {
		$this->admin_priv('platform_command_manage');
	
		$cmd_id = !empty($_GET['cmd_id']) ? $_GET['cmd_id'] : 0;
		$account_id = !empty($_GET['account_id']) ? $_GET['account_id'] : 0;
		$code = !empty($_GET['code']) ? trim($_GET['code']) : '';
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('platform::platform.public_extend'), RC_Uri::url('platform/admin/wechat_extend', array('id' => $account_id))));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('platform::platform.command_list')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('platform::platform.summarize'),
			'content'	=>
			'<p>' . RC_Lang::get('platform::platform.welcome_extend') . '</p>'
		));
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('platform::platform.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:公众号扩展#.E5.85.AC.E4.BC.97.E5.8F.B7.E6.89.A9.E5.B1.95.E5.91.BD.E4.BB.A4" target="_blank">'.RC_Lang::get('platform::platform.pub_commandlist_help').'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('platform::platform.command_list'));
		$this->assign('back_link', array('text' =>RC_Lang::get('platform::platform.public_extend'), 'href' => RC_Uri::url('platform/admin/wechat_extend', array('id' => $account_id))));
		$this->assign('search_action', RC_Uri::url('platform/admin_command/init', array('code' => $code, 'account_id' => $account_id)));
		$this->assign('form_action', RC_Uri::url('platform/admin_command/insert', array('code' => $code, 'account_id' => $account_id, 'cmd_id' => $cmd_id)));
	
		$ext_name = $this->db_extend->where(array('ext_code' => $code))->get_field('ext_name');
	
		$this->assign('cmd_id', $cmd_id);
		$this->assign('account_id', $account_id);
		$this->assign('code', $code);
		$this->assign('ext_name', $ext_name);
	
		$modules = $this->command_list();
		$this->assign('modules', $modules);
	
		$this->assign_lang();
		$this->display('wechat_extend_command.dwt');
	}
	
	/**
	 * 添加公众号扩展下的命令
	 */
	public function insert() {
		$this->admin_priv('platform_command_add', ecjia::MSGTYPE_JSON);
	
		$code = !empty($_GET['code']) ? trim($_GET['code']) : '';
		$account_id = !empty($_GET['account_id']) ? intval($_GET['account_id']) : 0;
		$platform = $this->db_platform_account->where(array('id' => $account_id))->get_field('platform');
		if (!empty($_POST)) {
			foreach ($_POST as $key => $value) {
				if ($key == 'newcmd_word') {
					foreach ($value as $k => $v) {
						if (empty($v)) {
							return $this->showmessage(RC_Lang::get('platform::platform.keyword_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
						} else {
							$data[$k]['cmd_word'] = $v;
						}
						//判断关键词是否重复
						$count = $this->db_command->where(array('account_id' => $account_id, 'cmd_word' => $v))->count();
						if ($count != 0) {
							return $this->showmessage(sprintf(RC_Lang::get('platform::platform.keywords_exist'), $v), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
						}
						$data[$k]['ext_code'] = $code;
						$data[$k]['account_id'] = $account_id;
						$data[$k]['platform'] = $platform;
						$arr[] = $data[$k]['cmd_word'];
					}
				} elseif ($key == 'newsub_code') {
					foreach ($value as $k => $v) {
						$data[$k]['sub_code'] = $v;
					}
				}
			}
		} else {
			return $this->showmessage(RC_Lang::get('platform::platform.clickmore'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	
		$count = array_count_values($arr);
		foreach ($count as $c) {
			if ($c > 1) {
				return $this->showmessage(RC_Lang::get('platform::platform.keyword_notrepeat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		$this->db_command->batch_insert($data);
	
		$name = $this->db_platform_account->where(array('id' => $account_id))->get_field('name');
		foreach ($data as $v) {
			$ext_name = $this->db_extend->where(array('ext_code' => $v['ext_code']))->get_field('ext_name');
			ecjia_admin::admin_log(RC_Lang::get('platform::platform.public_name_is').$name.'，'.RC_Lang::get('platform::platform.extend_name_is').$ext_name.'，'.RC_Lang::get('platform::platform.keyword_is').$v['cmd_word'], 'add', 'platform_extend_command');
		}
		return $this->showmessage(RC_Lang::get('platform::platform.add_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('platform/admin_command/init', array('code' => $code, 'account_id' => $account_id))));
	}
	
	/**
	 * 更新公众号扩展下的命令
	 */
	public function update() {
		$this->admin_priv('platform_command_update', ecjia::MSGTYPE_JSON);
	
		$cmd_word 	= !empty($_POST['cmd_word']) 	? trim($_POST['cmd_word']) 	: '';
		$sub_code 	= !empty($_POST['sub_code']) 	? trim($_POST['sub_code']) 	: '';
		$cmd_id 	= !empty($_GET['cmd_id']) 		? $_GET['cmd_id'] 			: 0;
		$code 		= !empty($_GET['code']) 		? $_GET['code'] 			: '';
		$account_id = !empty($_GET['account_id']) 	? $_GET['account_id'] 		: '';
	
		if (empty($cmd_word)) {
			return $this->showmessage(RC_Lang::get('platform::platform.keyword_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	
		//检查改公众号下的扩展名称下是否有重复关键字
		$count = $this->db_command->where(array('account_id' => $account_id, 'cmd_word' => $cmd_word, 'cmd_id' => array('neq' => $cmd_id)))->count();
	
		if ($count != 0) {
			return $this->showmessage(sprintf(RC_Lang::get('platform::platform.keywords_exist'), $cmd_word), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	
		$data = array(
			'cmd_word'	=> $cmd_word,
			'sub_code'	=> $sub_code
		);
		$this->db_command->where(array('cmd_id' => $cmd_id))->update($data);
	
		$info = $this->dbview_platform_config->join(array('platform_extend', 'platform_account'))->field('e.ext_name, a.name')->where(array('a.id' => $account_id, 'e.ext_code' => $code))->find();
		//记录日志
		ecjia_admin::admin_log(RC_Lang::get('platform::platform.public_name_is').$info['name'].'，'.RC_Lang::get('platform::platform.extend_name_is').$info['ext_name'].'，'.RC_Lang::get('platform::platform.keyword_is').$cmd_word, 'edit', 'platform_extend_command');
		
		return $this->showmessage(RC_Lang::get('platform::platform.edit_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('platform/admin_command/init', array('code' => $code, 'account_id' => $account_id))));
	}
	
	/**
	 * 删除公众号扩展下的命令
	 */
	public function remove() {
		$this->admin_priv('platform_command_delete', ecjia::MSGTYPE_JSON);
	
		$cmd_id = intval($_GET['cmd_id']);
		$data = $this->db_command->find(array('cmd_id' => $cmd_id));
		$info = $this->dbview_platform_config->join(array('platform_extend', 'platform_account'))->field('e.ext_name, a.name')->where(array('a.id' => $data['account_id'], 'e.ext_code' => $data['ext_code']))->find();
		
		$delete = $this->db_command->where(array('cmd_id' => $cmd_id))->delete();
		
		//记录日志
		ecjia_admin::admin_log(RC_Lang::get('platform::platform.public_name_is').$info['name'].'，'.RC_Lang::get('platform::platform.extend_name_is').$info['ext_name'].'，'.RC_Lang::get('platform::platform.keyword_is').$data['cmd_word'], 'remove', 'platform_extend_command');
		if ($delete) {
			return $this->showmessage(RC_Lang::get('platform::platform.remove_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage(RC_Lang::get('platform::platform.remove_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 扩展下的命令列表
	 */
	public function extend_command() {
		$this->admin_priv('platform_command_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('platform::platform.function_extend'), RC_Uri::url('platform/admin_plugin/init')));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('platform::platform.command_list')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('platform::platform.summarize'),
			'content'	=>
			'<p>' . RC_Lang::get('platform::platform.welcome_command') . '</p>'
		));
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('platform::platform.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:功能扩展#.E6.9F.A5.E7.9C.8B.E5.91.BD.E4.BB.A4" target="_blank">'.RC_Lang::get('platform::platform.extend_commandlist_help').'</a>') . '</p>'
		);
		
		$id 	= !empty($_GET['id']) 	? $_GET['id'] 			: 0;
		$code 	= !empty($_GET['code']) ? trim($_GET['code']) 	: '';
	
		$this->assign('ur_here', RC_Lang::get('platform::platform.command_list'));
		$this->assign('back_link', array('text' =>RC_Lang::get('platform::platform.function_extend'), 'href' => RC_Uri::url('platform/admin_plugin/init')));
		$this->assign('search_action', RC_Uri::url('platform/admin_command/extend_command', array('code' => $code)));
	
		$ext_name = $this->db_extend->where(array('ext_code' => $code))->get_field('ext_name');
		$this->assign('code', $code);
		$this->assign('ext_name', $ext_name);
	
		$ext_type_list = array('wechat', 'weibo', 'alipay');
		$this->assign('type_list', $ext_type_list);
	
		$this->assign('id', $id);
		$modules = $this->get_command_list();
		$this->assign('modules', $modules);
		
		$this->assign_lang();
		$this->display('extend_command_list.dwt');
	}
	
	
	/**
	 * 公众号扩展下的命令列表
	 */
	private function command_list() {
		$db_command_view = RC_Loader::load_app_model('platform_command_viewmodel');
	
		$type = !empty($_GET['platform']) ? $_GET['platform'] : '';
		$keywords = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
	
		$where['c.ext_code'] = !empty($_GET['code']) ? trim($_GET['code']) : '';
		$where['c.account_id'] = !empty($_GET['account_id']) ? intval($_GET['account_id']) : 0;
	
		if (!empty($type)) {
			$where['c.platform'] = $type;
		}
		if ($keywords) {
			$where['c.cmd_word'] = array('like' => '%'.$keywords.'%');
		}
	
		$where['a.shop_id'] = 0;
		$count = $db_command_view->join(array('platfrom_command', 'platform_account'))->where($where)->count();
		$page = new ecjia_page($count, 15, 5);
	
		$arr = array();
		$data = $db_command_view->join(array('platfrom_command', 'platform_account'))->field('c.*')->where($where)->order('cmd_id ASC')->limit($page->limit())->select();
	
		if (isset($data)) {
			foreach ($data as $rows) {
				$arr[] = $rows;
			}
		}
		return array('module' => $arr, 'page' => $page->show(5), 'desc' => $page->page_desc());
	}
	
	/**
	 * 扩展下的命令列表
	 */
	private function get_command_list() {
		$db_command_view= RC_Loader::load_app_model('platform_command_viewmodel');
	
		$type = !empty($_GET['platform']) ? $_GET['platform'] : '';
		$keywords = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
	
		$where['c.ext_code'] = $_GET['code'];
		if (!empty($type)) {
			$where['c.platform'] = $type;
		}
		if ($keywords) {
			$where['c.cmd_word'] = array('like' => '%'.$keywords.'%');
		}
		$where['a.shop_id'] = 0;
		
		$count = $db_command_view->join(array('platform_account', 'platform_command'))->where($where)->count();
		$page = new ecjia_page($count, 15, 5);
	
		$arr = array();
		$data = $db_command_view->join(array('platform_account', 'platform_command'))->field('c.*, a.name')->where($where)->order('cmd_id ASC')->limit($page->limit())->select();
		
		return array('module' => $data, 'page' => $page->show(5), 'desc' => $page->page_desc());
	}
}

//end