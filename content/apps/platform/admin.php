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
 * ECJIA平台、公众号配置
 */
class admin extends ecjia_admin {
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
		
		$this->db_platform_account = RC_Loader::load_app_model('platform_account_model');
		$this->db_platform_config = RC_Loader::load_app_model('platform_config_model');
		$this->db_extend = RC_Loader::load_app_model('platform_extend_model');
		$this->dbview_platform_config = RC_Loader::load_app_model('platform_config_viewmodel');
		$this->db_command = RC_Loader::load_app_model('platform_command_model');
		$this->db_oauth = RC_Loader::load_app_model('wechat_oauth_model', 'wechat');
		
		RC_Loader::load_app_class('platform_factory', null, false);
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('bootstrap-placeholder');
		
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Style::enqueue_style('goods-colorpicker-style', RC_Uri::admin_url('statics/lib/colorpicker/css/colorpicker.css'));
		RC_Script::enqueue_script('goods-colorpicker-script', RC_Uri::admin_url('statics/lib/colorpicker/bootstrap-colorpicker.js'), array());
		
		RC_Script::enqueue_script('platform', RC_App::apps_url('statics/js/platform.js', __FILE__), array(), false, true);
		RC_Script::enqueue_script('generate_token', RC_App::apps_url('statics/js/generate_token.js', __FILE__), array(), false, true);
		RC_Script::localize_script('platform', 'js_lang', RC_Lang::get('platform::platform.js_lang'));
		RC_Style::enqueue_style('wechat_extend', RC_App::apps_url('statics/css/wechat_extend.css', __FILE__));
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('platform::platform.platform_list'), RC_Uri::url('platform/admin/init')));
	}
	
	/**
	 * 公众号列表
	 */
	public function init() {
		$this->admin_priv('platform_config_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('platform::platform.platform_list')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('platform::platform.summarize'),
			'content'	=>
			'<p>' . RC_Lang::get('platform::platform.welcome_pub_list') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('platform::platform.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:管理公众号" target="_blank">'.RC_Lang::get('platform::platform.pub_list_help').'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('platform::platform.platform_list'));
		$this->assign('action_link', array('text' => RC_Lang::get('platform::platform.platform_add'), 'href'=>RC_Uri::url('platform/admin/add')));
		
		$wechat_list = $this->wechat_list();
		$this->assign('wechat_list', $wechat_list);
		$this->assign('search_action', RC_Uri::url('platform/admin/init'));
		
		$this->assign_lang();
		$this->display('wechat_list.dwt');
	}
	
	/**
	 * 添加公众号页面
	 */
	public function add() {
		$this->admin_priv('platform_config_add');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('platform::platform.platform_list')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('platform::platform.summarize'),
			'content'	=>
			'<p>' . RC_Lang::get('platform::platform.welcome_pub_add') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('platform::platform.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:管理公众号#.E6.B7.BB.E5.8A.A0.E5.85.AC.E4.BC.97.E5.8F.B7" target="_blank">'.RC_Lang::get('platform::platform.add_pub_help').'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('platform::platform.platform_add'));
		$this->assign('action_link', array('text' => RC_Lang::get('platform::platform.platform_list'), 'href'=>RC_Uri::url('platform/admin/init')));
		$this->assign('form_action', RC_Uri::url('platform/admin/insert'));
		$this->assign('wechat', array('status' => 1));
		
		$this->assign_lang();
		$this->display('wechat_edit.dwt');
	}
	
	/**
	 * 添加公众号处理
	 */
	public function insert() {
		$this->admin_priv('platform_config_add', ecjia::MSGTYPE_JSON);
		
		if (empty($_POST['platform'])) {
			return $this->showmessage(RC_Lang::get('platform::platform.select_terrace'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$uuid = Royalcms\Component\Uuid\Uuid::generate();
		$uuid = str_replace("-", "", $uuid);
		
		if ((isset($_FILES['platform_logo']['error']) && $_FILES['platform_logo']['error'] == 0) || (!isset($_FILES['platform_logo']['error']) && isset($_FILES['platform_logo']['tmp_name'] ) &&$_FILES['platform_logo']['tmp_name'] != 'none')) {
			$upload = RC_Upload::uploader('image', array('save_path' => 'data/platform', 'auto_sub_dirs' => false));
			$image_info = $upload->upload($_FILES['platform_logo']);
			if (!empty($image_info)) {
				$platform_logo = $upload->get_position($image_info);
			} else {
				return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			$platform_logo ='';
		}
		
		$data = array(
			'uuid'		=>  $uuid,
			'platform'	=>	$_POST['platform'],
			'logo'		=> 	$platform_logo,
			'type'		=>	$_POST['type'],
			'name'		=>	$_POST['name'],
			'token'		=>	$_POST['token'],
			'appid'		=>	$_POST['appid'],
			'appsecret'	=>	$_POST['appsecret'],
			'aeskey'	=>	$_POST['aeskey'],
			'add_time'	=>	RC_Time::gmtime(),
			'sort'		=>	intval($_POST['sort']),
			'status'	=>	intval($_POST['status']),
		);
	
		$id = $this->db_platform_account->insert($data);
		
		ecjia_admin::admin_log($_POST['name'], 'add', 'wechat');
		return $this->showmessage(RC_Lang::get('platform::platform.add_pub_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('platform/admin/edit', array('id' => $id))));
	}
	
	/**
	 * 编辑公众号页面
	 */
	public function edit() {
		$this->admin_priv('platform_config_update');
	
		$this->assign('ur_here', RC_Lang::get('platform::platform.platform_edit'));
		$this->assign('action_link', array('text' => RC_Lang::get('platform::platform.platform_list'), 'href' => RC_Uri::url('platform/admin/init')));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('platform::platform.platform_edit')));
		
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('platform::platform.summarize'),
			'content'	=>
			'<p>' . RC_Lang::get('platform::platform.welcome_pub_edit') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('platform::platform.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:管理公众号#.E7.BC.96.E8.BE.91.E5.85.AC.E4.BC.97.E5.8F.B7" target="_blank">'.RC_Lang::get('platform::platform.edit_pub_help').'</a>') . '</p>'
		);
		
		$wechat = $this->db_platform_account->find(array('id' => intval($_GET['id'])));
		if (!empty($wechat['logo'])) {
			$wechat['logo'] = RC_Upload::upload_url($wechat['logo']);
		}
		$url = RC_Uri::home_url().'/sites/platform/?uuid='.$wechat['uuid'];
		$this->assign('wechat', $wechat);
		$this->assign('url', $url);
	
		$this->assign('form_action', RC_Uri::url('platform/admin/update'));
	
		$this->assign_lang();
		$this->display('wechat_edit.dwt');
	}
	
	/**
	 * 编辑公众号处理
	 */
	public function update() {
		$this->admin_priv('platform_config_update', ecjia::MSGTYPE_JSON);
		
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		if (empty($_POST['platform'])) {
			return $this->showmessage(RC_Lang::get('platform::platform.select_terrace2'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		//获取旧的logo
		$old_logo = $this->db_platform_account->where(array('id' => $id))->get_field('logo');
		
		if ((isset($_FILES['platform_logo']['error']) && $_FILES['platform_logo']['error'] == 0) || (!isset($_FILES['platform_logo']['error']) && isset($_FILES['platform_logo']['tmp_name'] ) &&$_FILES['platform_logo']['tmp_name'] != 'none')) {
			$upload = RC_Upload::uploader('image', array('save_path' => 'data/platform', 'auto_sub_dirs' => false));
			$image_info = $upload->upload($_FILES['platform_logo']);
			
			if (!empty($image_info)) {
				//删除原来的logo
				if (!empty($old_logo)) {
					$upload->remove($old_logo);
				}
				$platform_logo = $upload->get_position($image_info);
			} else {
				return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			$platform_logo = $old_logo;
		}
		$data = array(
			'platform'	=>	$_POST['platform'],
			'type'		=>	$_POST['type'],
			'name'		=>	$_POST['name'],
			'logo'		=> 	$platform_logo,
			'token'		=>	$_POST['token'],
			'appid'		=>	$_POST['appid'],
			'appsecret'	=>	$_POST['appsecret'],
			'aeskey'	=>	$_POST['aeskey'],
			'sort'		=>	intval($_POST['sort']),
			'status'	=>	intval($_POST['status']),
		);
	
		$this->db_platform_account->where(array('id' => $id))->update($data);
		
		ecjia_admin::admin_log($_POST['name'], 'edit', 'wechat');
		return $this->showmessage(RC_Lang::get('platform::platform.edit_pub_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('platform/admin/edit', array('id' => $id))));
	}

	
	/**
	 * 删除公众号
	 */
	public function remove()  {
		$this->admin_priv('platform_config_delete', ecjia::MSGTYPE_JSON);
		
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		$info = $this->db_platform_account->where(array('id' => $id))->field('name, logo')->find();
		if (!empty($info['logo'])){
			$disk = RC_Filesystem::disk();
			$disk->delete(RC_Upload::upload_path() . $info['logo']);
		}
		$success = $this->db_platform_account->where(array('id' => $id))->delete();
		//删除公众号扩展及扩展命令
		$this->db_platform_config->where(array('account_id' => $id))->delete();
		$this->db_command->where(array('account_id' => $id))->delete();
		$this->db_oauth->where(array('wechat_id' => $id))->delete();
		
		if ($success) {
			ecjia_admin::admin_log($info['name'], 'remove', 'wechat');
			return $this->showmessage(RC_Lang::get('platform::platform.remove_pub_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('platform/admin/init')));
		} else {
			return $this->showmessage(RC_Lang::get('platform::platform.remove_pub_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 删除logo
	 */
	public function remove_logo() {
		$this->admin_priv('platform_config_update', ecjia::MSGTYPE_JSON);
		
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		$info = $this->db_platform_account->where(array('id' => $id))->field('name,logo')->find();
		if (!empty($info['logo'])){
			$disk = RC_Filesystem::disk();
			$disk->delete(RC_Upload::upload_path() . $info['logo']);
		}
		$data = array('logo' => '');
		$update = $this->db_platform_account->where(array('id' => $id))->update($data);
		
		ecjia_admin::admin_log(RC_Lang::get('platform::platform.public_name_is').$info['name'], 'remove', 'platform_logo');
		
		if ($update) {
			return $this->showmessage(RC_Lang::get('platform::platform.remove_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage(RC_Lang::get('platform::platform.remove_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 切换状态
	 */
	public function toggle_show() {
		$this->admin_priv('platform_config_update', ecjia::MSGTYPE_JSON);
		
		$id	 = intval($_POST['id']);
		$val = intval($_POST['val']);
		$this->db_platform_account->where(array('id' => $id))->update(array('status' => $val));
		$name = $this->db_platform_account->where(array('id' => $id))->get_field('name');
		if ($val == 1) {
			ecjia_admin::admin_log($name, 'use', 'wechat');
		} else {
			ecjia_admin::admin_log($name, 'stop', 'wechat');
		}
		
		return $this->showmessage(RC_Lang::get('platform::platform.switch_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $val, 'pjaxurl' => RC_Uri::url('platform/admin/init')));
	}
	
	/**
	 * 手动排序
	 */
	public function edit_sort() {
		$this->admin_priv('platform_config_update', ecjia::MSGTYPE_JSON);
	
		$id    = intval($_POST['pk']);
		$sort  = trim($_POST['value']);
	
		if (!empty($sort)) {
			if (!is_numeric($sort)) {
				return $this->showmessage(RC_Lang::get('platform::platform.import_num'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				if ($this->db_platform_account->where(array('id' => $id))->update(array('sort' => $sort))) {
					return $this->showmessage(RC_Lang::get('platform::platform.editsort_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('platform/admin/init')));
				} else {
					return $this->showmessage(RC_Lang::get('platform::platform.editsort_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
		} else {
			return $this->showmessage(RC_Lang::get('platform::platform.pubsort_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 查看公众号扩展
	 */
	public function wechat_extend() {
		$this->admin_priv('platform_extend_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('platform::platform.public_extend')));
		$this->assign('ur_here', RC_Lang::get('platform::platform.public_extend'));
		$this->assign('action_link', array('text' => RC_Lang::get('platform::platform.platform_list'), 'href'=> RC_Uri::url('platform/admin/init')));

		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('platform::platform.summarize'),
			'content'	=>
			'<p>' . RC_Lang::get('platform::platform.welcome_pub_extend') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('platform::platform.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:公众号扩展#.E5.85.AC.E4.BC.97.E5.8F.B7.E6.89.A9.E5.B1.95" target="_blank">'.RC_Lang::get('platform::platform.pub_extend_help').'</a>') . '</p>'
		);
		
		$this->assign('form_action', RC_Uri::url('platform/admin/wechat_extend_insert'));
		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		$count = $this->db_platform_config->where(array('account_id' => $id))->count();
		$page = new ecjia_page($count,10,5);

		//已禁用的扩展不显示
		$where = '';
		$where = array('c.account_id' => $id, 'e.enabled' => array('neq' => 0));
		
		$arr = $this->dbview_platform_config->join(array('platform_extend', 'platform_account'))->field('a.id, c.account_id, a.name, a.platform, e.ext_name, c.ext_code, a.type, e.ext_desc')->where($where)->order(array('e.ext_id' => 'desc'))->limit($page->limit())->select();
		
		if	(!empty($arr)) {
			foreach ($arr as $k => $v) {
				$command_list = $this->db_command->where(array('account_id' => $v['account_id'], 'ext_code' => $v['ext_code']))->get_field('cmd_word', true);
				if (!empty($command_list)) {
					$arr[$k]['command_list'] = implode('; ', $command_list);
				}
			}
		}
		
		$list = array('item' => $arr, 'page' => $page->show(5), 'desc' => $page->page_desc());
			
		$this->assign('arr', $list);
		$this->assign('id', $id);
		
		$this->assign_lang();
		$this->display('wechat_extend.dwt');
	}
	
	/**
	 * 公众号扩展插入
	 */
	public function wechat_extend_insert() {
		$this->admin_priv('platform_extend_add', ecjia::MSGTYPE_JSON);
		
		$id = !empty($_POST['id']) ? intval($_POST['id']) : 0;
		if (empty($_POST['ext_code'])) {
			return $this->showmessage(RC_Lang::get('platform::platform.chosen_extend'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		foreach ($_POST as $key => $value) {
			if ($key == 'ext_code') {
				foreach ($value as $k => $v) {
					$data[$k]['ext_code'] = $v;
					$data[$k]['account_id'] = $id;
				}
			} elseif ($key == 'ext_config') {
				foreach ($value as $k => $v) {
					$data[$k]['ext_config'] = stripslashes($v);
				}
			}
		}
		$this->db_platform_config->batch_insert($data);
			
		foreach ($data as $k => $v) {
			$info = $this->dbview_platform_config->join(array('platform_extend', 'platform_account'))->where(array('c.account_id' => $id))->field('a.name, e.ext_name')->find();
			ecjia_admin::admin_log(RC_Lang::get('platform::platform.extend_name_is').$info['ext_name'].'，'.RC_Lang::get('platform::platform.public_name_is').$info['name'], 'batch_insert', 'wechat_extend');
		}
		if ($id) {
			return $this->showmessage(RC_Lang::get('platform::platform.add_pubext_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('platform/admin/wechat_extend', array('id' => $id))));
		} else {
			return $this->showmessage(RC_Lang::get('platform::platform.add_pubext_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 编辑扩展功能页面
	 */
	public function wechat_extend_edit() {
		$this->admin_priv('platform_extend_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('platform::platform.edit_pub_extend')));
		
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('platform::platform.summarize'),
			'content'	=>
			'<p>' . RC_Lang::get('platform::platform.welcome_pub_extend_edit') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('platform::platform.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:公众号扩展#.E7.BC.96.E8.BE.91.E5.85.AC.E4.BC.97.E5.8F.B7.E6.89.A9.E5.B1.95" target="_blank">'.RC_Lang::get('platform::platform.pub_editext_help').'</a>') . '</p>'
		);
		
		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		
		$this->assign('action_link', array('text' => RC_Lang::get('platform::platform.public_extend'), 'href' => RC_Uri::url('platform/admin/wechat_extend', array('id' => $id))));
		$this->assign('form_action', RC_Uri::url('platform/admin/wechat_extend_save'));
		$this->assign('ur_here', RC_Lang::get('platform::platform.edit_pub_extend'));
	
		$code = !empty($_GET['code']) ? trim($_GET['code']) : '';
		$name = $this->db_platform_account->where(array('id' => $id))->get_field('name');
		
		$bd = $this->db_platform_config->where(array('ext_code' => $code, 'account_id' => $id))->find();
		$bd['ext_name'] = $this->db_extend->where(array('ext_code' => $code))->get_field('ext_name');
		
		$ext_config = unserialize($bd['ext_config']);
		$code_list = array();
		if (!empty($ext_config)) {
			foreach ($ext_config as $key => $value) {
				$code_list[$value['name']] = $value['value'];
			}
		}
		$payment_handle = new platform_factory($code);
		$bd['ext_config'] = $payment_handle->configure_forms($code_list, true);
		$this->assign('bd', $bd);
		$this->assign('name', $name);
		
		$this->assign_lang();
		$this->display('wechat_extend_edit.dwt');
	}
	
	/**
	 * 编辑扩展功能处理
	 */
	public function wechat_extend_save() {
		$this->admin_priv('platform_extend_update', ecjia::MSGTYPE_JSON);
		
		$account_id = !empty($_POST['account_id']) ? intval($_POST['account_id']) : 0;
		$ext_code = !empty($_POST['ext_code']) ? trim($_POST['ext_code']) : '';
		
		/* 取得配置信息 */
		$ext_config = array();
		if (isset($_POST['cfg_value']) && is_array($_POST['cfg_value'])) {
			for ($i = 0; $i < count($_POST['cfg_value']); $i++) {
				$ext_config[] = array(
					'name'  => trim($_POST['cfg_name'][$i]),
					'type'  => trim($_POST['cfg_type'][$i]),
					'value' => trim($_POST['cfg_value'][$i])
				);
			}
		}
		$data['ext_config'] = serialize($ext_config);
		$update = $this->db_platform_config->where(array('ext_code' => $ext_code, 'account_id' => $account_id))->update($data);
	
		$info = $this->dbview_platform_config->join(array('platform_extend', 'platform_account'))->where(array('c.account_id' => $account_id))->field('a.name, e.ext_name')->find();
		ecjia_admin::admin_log(RC_Lang::get('platform::platform.extend_name_is').$info['ext_name'].'，'.RC_Lang::get('platform::platform.public_name_is').$info['name'], 'edit', 'wechat_extend');

		if ($update) {
			return $this->showmessage(RC_Lang::get('platform::platform.edit_pub_extend_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('platform/admin/wechat_extend_edit', array('code' => $ext_code, 'id' => $account_id))));
		} else {
			return $this->showmessage(RC_Lang::get('platform::platform.edit_pub_extend_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 删除公众号扩展
	 */
	public function wechat_extend_remove() {
		$this->admin_priv('platform_extend_delete', ecjia::MSGTYPE_JSON);
		
		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		$ext_code = !empty($_GET['code']) ? trim($_GET['code']) : '';
		
		$info = $this->dbview_platform_config->join(array('platform_extend', 'platform_account'))->where(array('c.account_id' => $id))->field('a.name, e.ext_name')->find();
		$success = $this->db_platform_config->where(array('account_id' => $id, 'ext_code' => $ext_code))->delete();
		
		//删除公众号扩展下的命令
		$this->db_command->where(array('account_id' => $id, 'ext_code' => $ext_code))->delete();
		
		ecjia_admin::admin_log(RC_Lang::get('platform::platform.extend_name_is').$info['ext_name'].'，'.RC_Lang::get('platform::platform.public_name_is').$info['name'], 'remove', 'wechat_extend');
		if ($success){
			return $this->showmessage(RC_Lang::get('platform::platform.remove_pub_extend_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('platform/admin/wechat_extend', array('id' => $id))));
		} else {
			return $this->showmessage(RC_Lang::get('platform::platform.remove_pub_extend_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 批量删除
	 */
	public function batch_remove() {
		$this->admin_priv('platform_extend_delete', ecjia::MSGTYPE_JSON);
		
		$idArr	= explode(',', $_POST['id']);
		$count	= count($idArr);
		
		$info = $this->db_platform_account->in(array('id' => $idArr))->field('name')->select();
		foreach ($info as $v) {
			ecjia_admin::admin_log($v['name'], 'batch_remove', 'wechat');
		}
		$this->db_platform_account->where(array('id' => $idArr))->delete();
		return $this->showmessage(RC_Lang::get('platform::platform.deleted')."[ ".$count." ]".RC_Lang::get('platform::platform.record_account'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('platform/admin/init')));
	}
	
	/**
	 * 生成token
	 */
	public function generate_token() {
		$key = rc_random(16, 'abcdefghijklmnopqrstuvwxyz0123456789');
		$key = 'ecjia'.$key;
		return $this->showmessage('生成token成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('token' => $key));
	}
	
	/**
	 * 公众号列表
	 */
	private function wechat_list() {
		$db_platform_account = RC_Loader::load_app_model('platform_account_model');
		
		$filter = array();
		$filter['keywords'] = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
		
		$where = '';
		if ($filter['keywords']) {
			$where[]= "name LIKE '%" . mysql_like_quote($filter['keywords']) . "%'";
		}
		
		$where['platform'] = array('neq' => 'weapp');
		
		$platform = !empty($_GET['platform']) ? $_GET['platform'] : '';
		if (!empty($platform)) {
			$where['platform'] = $platform;
		}
	
		$count = $db_platform_account->where($where)->count ();
		$filter['record_count'] = $count;
		$page = new ecjia_page($count, 10, 5);
	
		$arr = array();
		$data = $db_platform_account->where($where)->order (array('sort' => 'asc', 'add_time' => 'desc'))->limit($page->limit())->select();
		if (isset($data)) {
			foreach ($data as $rows) {
				$rows['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $rows['add_time']);
				if (empty($rows['logo'])) {
					$rows['logo'] = RC_Uri::admin_url('statics/images/nopic.png');
				} else {
					$rows['logo'] = RC_Upload::upload_url($rows['logo']);
				}
				$arr[] = $rows;
			}
		}
		return array('item' => $arr, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc());
	}
	
	/**
	 * 获取扩展列表
	 */
	public function get_extend_list() {
		$id = intval($_GET['JSON']['id']);
		$keywords = trim($_GET['JSON']['keywords']);
	
		$where = "1";
		if ($keywords) {
			$where = "ext_name LIKE '%" .$keywords. "%'";
			$where .= " OR ext_code LIKE '%" .$keywords. "%'";
		}
		//已禁用的扩展搜索不显示
		$where  .= " AND enabled != 0";
	
		//查找已关联的扩展
		$ext_code_list = $this->db_platform_config->where(array('account_id' => $id))->get_field('ext_code', true);
		$platform_list = $this->db_extend->where($where)->field('ext_id, ext_name, ext_code, ext_config')->order(array('ext_id' => 'desc'))->select();
	
		if ($ext_code_list) {
			if (!empty($platform_list)) {
				foreach ($platform_list as  $k => $v) {
					if (in_array($v['ext_code'], $ext_code_list)) {
						unset($platform_list[$k]);
					}
				}	
			}
		}
	
		$opt = array();
		if (!empty($platform_list)) {
			foreach ($platform_list AS $key => $val) {
				$opt[] = array(
					'ext_id' 		=> $val['ext_id'],
					'ext_name' 		=> $val['ext_name'],
					'ext_code'  	=> $val['ext_code'],
					'ext_config' 	=> $val['ext_config']
				);
			}
		}
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $opt));
	}
}

//end