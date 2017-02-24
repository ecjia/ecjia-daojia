<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA消息模板
 */
class admin_template extends ecjia_admin {
	private $db_mail;
	
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		$this->db_mail = RC_Loader::load_app_model('mail_templates_model');
	
		RC_Script::enqueue_script('tinymce');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('jquery-uniform');
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		
		RC_Script::enqueue_script('jquery-dataTables-bootstrap');
		RC_Script::enqueue_script('message_template', RC_App::apps_url('statics/js/message_template.js', __FILE__), array(), false, false);
		
		RC_Script::localize_script('message_template', 'js_lang', RC_Lang::get('wechat::wechat.js_lang'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.message_template'), RC_Uri::url('wechat/admin_template/init')));
	}

	/**
	 * 消息模板
	 */
	public function init () {
		$this->admin_priv('message_template_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.message_template')));
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.message_template'));
		$this->assign('action_link', array('href'=>RC_Uri::url('wechat/admin_template/add'), 'text' => RC_Lang::get('wechat::wechat.add_message_template')));

		$data = $this->db_mail->field('template_id, template_code, template_subject, template_content')->where(array('type' => 'push'))->select();
		$this->assign('templates', $data);

		$this->display('message_template_list.dwt');
	}
	
	/**
	 * 添加模板页面
	 */
	public function add() {
		$this->admin_priv('message_template_add');
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.add_message_template')));
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.add_message_template'));
		$this->assign('action_link', array('href'=>RC_Uri::url('wechat/admin_template/init'), 'text' => RC_Lang::get('wechat::wechat.message_template_list')));
		
		$this->assign('form_action', RC_Uri::url('wechat/admin_template/insert'));
		$this->assign('action', 'insert');
		
		$this->assign_lang();
		$this->display('message_template_info.dwt');
	}
	
	/**
	 * 添加模板处理
	 */
	public function insert() {
		$this->admin_priv('message_template_add', ecjia::MSGTYPE_JSON);
		
		$template_code = trim($_POST['template_code']);
		$subject       = trim($_POST['subject']);
		$content       = trim($_POST['content']);
		
		$titlecount = $this->db_mail->where(array('template_code' => $template_code, 'type' => 'push'))->count();
		if ($titlecount > 0) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.message_template_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$data = array(
			'template_code'    => $template_code,
			'template_subject' => $subject,
			'template_content' => $content,
			'last_modify'      => RC_Time::gmtime(),
			'type'             =>'push'
		);
		
		$tid=$this->db_mail->insert($data);
		ecjia_admin::admin_log($subject, 'add', 'template');
		
		$links[] = array('text' => RC_Lang::get('wechat::wechat.continue_add_template'), 'href'=> RC_Uri::url('wechat/admin_template/add'));
		return $this->showmessage(RC_Lang::get('wechat::wechat.add_template_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links , 'pjaxurl' => RC_Uri::url('wechat/admin_template/edit', array('id' => $tid))));
	}
	
	/**
	 * 模版修改
	 */
	public function edit() {
		$this->admin_priv('message_template_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.edit_message_template')));
		
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.edit_message_template'));
		$this->assign('action_link', array('href'=>RC_Uri::url('wechat/admin_template/init'), 'text' => RC_Lang::get('wechat::wechat.message_template_list')));

		$tid = intval($_GET['id']);
		$template = $this->db_mail->find(array('template_id' => $tid));
		
		$this->assign('template', $template);
		$this->assign('form_action', RC_Uri::url('wechat/admin_template/update'));
		
		$this->display('message_template_info.dwt');
	}
	
	/**
	 * 保存模板内容
	 */
	public function update() {
		$this->admin_priv('message_template_update', ecjia::MSGTYPE_JSON);
		
		$id			   = intval($_POST['id']);
		$template_code = trim($_POST['template_code']);
		$subject       = trim($_POST['subject']);
		$content       = trim($_POST['content']);
	
		$old_template_code = trim($_POST['old_template_code']);
		if ($template_code != $old_template_code) {
			$titlecount = $this->db_mail->where(array('template_code' => $template_code, 'type' => 'push'))->count();
			if ($titlecount > 0) {
				return $this->showmessage(RC_Lang::get('wechat::wechat.message_template_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}

		$data = array(
			'template_code'    => $template_code,
			'template_subject' => $subject,
			'template_content' => $content,
			'last_modify'      => RC_Time::gmtime(),
			'type'             =>'push'
		);
		
		$this->db_mail->where(array('template_id' => $id))->update($data);
		ecjia_admin::admin_log($subject, 'edit', 'template');
		
	  	return $this->showmessage(RC_Lang::get('wechat::wechat.edit_template_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 删除消息模板
	 */
	public function remove()  {
		$this->admin_priv('message_template_delete', ecjia::MSGTYPE_JSON);
	
		$id = intval($_GET['id']);
		$template_subject = $this->db_mail->where(array('template_id' =>$id))->get_field('template_subject');
		
		$this->db_mail->where(array('template_id' => $id))->delete();
		
		ecjia_admin::admin_log($template_subject, 'remove', 'template');
		return $this->showmessage(RC_Lang::get('wechat::wechat.remove_template_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
}

//end