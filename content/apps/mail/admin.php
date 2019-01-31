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
 * ECJIA 管理中心模板管理程序
 * @author songqian
 */
class admin extends ecjia_admin {
	
	public function __construct() {
		parent::__construct();
		
		
		Ecjia\App\Mail\Helper::assign_adminlog_content();
		
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-dataTables-bootstrap');
		RC_Script::enqueue_script('mail_template', RC_App::apps_url('statics/js/mail_template.js', __FILE__), array(), false, false);
		
		RC_Script::localize_script('mail_template', 'js_lang', config('app-mail::jslang.mail_template_page'));
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('邮件模板', 'mail'), RC_Uri::url('mail/admin/init')));
	}
	
	/**
	 * 模板列表
	 */
	public function init() {
		$this->admin_priv('mail_template_manage');

		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('邮件模板', 'mail')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> __('概述', 'mail'),
			'content'	=> '<p>' . __('欢迎访问ECJia智能后台邮件模板列表页面，系统中所有的邮件模板都会显示在此列表中。', 'mail') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . __('概述', 'mail') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:邮件模板" target="_blank">'. __('关于邮件模板列表帮助文档', 'mail') .'</a>') . '</p>'
		);
		
		$this->assign('ur_here', __('邮件模板', 'mail'));
		
		$cur = null;
		//$data = $this->db_mail->mail_templates_select('template', array('template_id', 'template_code'));
		$data 	= Ecjia\App\Mail\MailTeplates::MailTemplatesSelect('template', array('template_id', 'template_code'));

		$data or $data = array();
		foreach ($data as $key => $row) {
			//todo 语言包方法待确认
			$data[$key]['template_name'] = RC_Lang::lang($row['template_code']);
		}
		$this->assign('templates', $data);
		
		$this->assign_lang();
		$this->display('mail_template_list.dwt');
	}

	/**
	 * 模板修改
	 */
	public function edit() {
		$this->admin_priv('mail_template_update');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑邮件模板', 'mail')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> __('概述', 'mail'),
			'content'	=> '<p>' . __('欢迎访问ECJia智能后台编辑邮件模板页面，可以在此编辑相应的邮件模板信息。', 'mail') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . __('更多信息：', 'mail') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:邮件模板" target="_blank">'.__('关于编辑邮件模板帮助文档', 'mail').'</a>') . '</p>'
		);
		
		$this->assign('ur_here', __('编辑邮件模板', 'mail'));
		$this->assign('action_link', array('href'=>RC_Uri::url('mail/admin/init'), 'text' => __('邮件模板', 'mail')));
		
		$tpl 		= safe_replace($_GET['tpl']);
		$mail_type 	= isset($_GET['mail_type']) ? $_GET['mail_type'] : -1;
		//$content 	= $this->db_mail->load_template($tpl);
		
		$content 	= Ecjia\App\Mail\MailTeplates::LoadTemplate($tpl);

		if ($content === NULL || empty($tpl)) {
			return $this->showmessage(__('邮件模板不存在，请访问正确的邮件模板！', 'mail'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回'), 'href' => 'javascript:window.history.back(-1);'))));
		}
		//todo 语言包方法待确认
		$content['template_name'] = RC_Lang::lang($tpl) . " [$tpl]";
		$content['template_code'] = $tpl;
		
		if (($mail_type == -1 && $content['is_html'] == 1) || $mail_type == 1) {
			$content['is_html'] = 1;
		} elseif ($mail_type == 0) {
			$content['is_html'] = 0;
		}
		if (!empty($content['template_content'])) {
			$content['template_content'] = stripslashes($content['template_content']);
		}
		$this->assign('tpl', $tpl);
		$this->assign('template', $content);
		
		$this->assign_lang();
		$this->display('mail_template_info.dwt');
	}
	
	/**
	 * 保存模板内容
	 */
	public function save_template() {
		$this->admin_priv('mail_template_update', ecjia::MSGTYPE_JSON);
		
		if (empty($_POST['subject'])) {
			return $this->showmessage(__('对不起，邮件的主题不能为空。', 'mail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$subject = trim($_POST['subject']);
		}
		
		if (empty($_POST['content'])) {
			return $this->showmessage(__('对不起，邮件的内容不能为空。', 'mail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$content = trim($_POST['content']);
		}
		
		$type   	= intval($_POST['mail_type']);
		$tpl_code 	= safe_replace($_POST['tpl']);

		$data = array(
			'template_subject' => str_replace('\\\'\\\'', '\\\'', $subject),
			'template_content' => str_replace('\\\'\\\'', '\\\'', $content),
			'is_html'          => $type,
			'last_modify'      => RC_Time::gmtime()
		);
		//$this->db_mail->mail_templates_update($tpl_code, $data);

		$update = Ecjia\App\Mail\MailTeplates::MailTemplatesUpdate($tpl_code, $data);
		
	    if ($update) {
			//todo 语言包方法待确认
			ecjia_admin::admin_log(RC_Lang::lang($tpl_code), 'edit', 'email_template');
			return $this->showmessage(__('保存模板内容成功。', 'mail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage(__('保存模板内容失败。', 'mail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 载入指定模板
	 */
	public function loat_template() {
		$this->admin_priv('mail_template_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑邮件模板', 'mail')));
		
		$tpl       = safe_replace($_GET['tpl']);
		$mail_type = isset($_GET['mail_type']) ? $_GET['mail_type'] : -1;
	
		//$content   = $this->db_mail->load_template($tpl);
		$content 	 = Ecjia\App\Mail\MailTeplates::LoadTemplate($tpl);

		//todo 语言包方法待确认
		$content['template_name'] = RC_Lang::lang($tpl) . " [$tpl]";
		$content['template_code'] = $tpl;
	
		if (($mail_type == -1 && $content['is_html'] == 1) || $mail_type == 1) {
			$content['is_html'] = 1;
		} elseif ($mail_type == 0) {
			$content['is_html'] = 0;
		}
		
		$this->assign('ur_here', __('邮件模板', 'mail'));
		$this->assign('tpl', $tpl);
		$this->assign('action_link', array('href'=> RC_Uri::url('mail/admin/init'), 'text' => __('邮件模板', 'mail')));
		$this->assign('template', $content);

		$this->assign_lang();
		$this->display('mail_template_info.dwt');
	}
}

// end