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
 * ECJIA短信事件模块
 * @author songqian
 */
class admin_events extends ecjia_admin {
	
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		RC_Script::enqueue_script('tinymce');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('jquery-uniform');
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		
		RC_Script::enqueue_script('jquery.toggle.buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/jquery.toggle.buttons.js'));
		RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/bootstrap-toggle-buttons.css'));
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('jquery-dataTables-bootstrap');
		
		RC_Script::enqueue_script('sms_events', RC_App::apps_url('statics/js/sms_events.js', __FILE__), array(), false, false);
		RC_Script::enqueue_script('sms_template', RC_App::apps_url('statics/js/sms_template.js', __FILE__), array(), false, false);
		RC_Script::localize_script('sms_template', 'js_lang', RC_Lang::get('sms::sms.js_lang'));
		
	}
	
	/**
	 * 事件列表
	 */
	public function init () {
		$this->admin_priv('sms_events_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('短信事件'));
		$this->assign('ur_here', '短信事件列表');
		$this->assign('action_link', array('href'=>RC_Uri::url('sms/admin_template/init'), 'text' => '短信模板列表'));
		
		$data = $this->template_code_list();
		$database = RC_DB::table('notification_events')
					->where('channel_type', 'sms')
					->select('id', 'event_code','status')
					->get();
		foreach ($database as $key => $val) {
			$database[$val['event_code']] = $val;
			unset($database[$key]);
		}
		foreach ($data as $k => $v) {
			if (array_key_exists($v['code'], $database)) {
				$data[$k]['id'] = $database[$v['code']]['id'];
				$data[$k]['status'] = $database[$v['code']]['status'];
			}
		}
		$this->assign('data', $data);
		
		$this->display('sms_events_list.dwt');
	}
	
	public function open() {
		$this->admin_priv('sms_events_manage');
		if (empty($_GET['id'])) {
			$data = array(
				'event_code'  => $_GET['code'],
				'status'	  => 'open',
				'channel_type'=> 'sms',
			);
			RC_DB::table('notification_events')->insertGetId($data);
		} else {
			RC_DB::table('notification_events')->where('id', $_GET['id'])->update(array('status'=> 'open'));
		}
		ecjia_admin::admin_log($_GET['code'], 'add', 'sms_events');
		return $this->showmessage('开启成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('sms/admin_events/init')));
	}
	

	public function close() {
		$this->admin_priv('sms_events_manage');
		RC_DB::table('notification_events')->where('id', $_GET['id'])->update(array('status'=> 'close'));
		ecjia_admin::admin_log($_GET['code'], 'close', 'sms_events');
		return $this->showmessage('关闭成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('sms/admin_events/init')));
	}
	
	/**
	 * 获取模板code
	 */
	private function template_code_list() {
	
		$template_code_list = array();
		
		$factory = new Ecjia\App\Sms\EventFactory();
		$events = $factory->getEvents();
		foreach ($events as $k => $event) {
			$template_code_list[$k]['code'] = $event->getCode();
			$template_code_list[$k]['name'] = $event->getName();
			$template_code_list[$k]['description'] = $event->getDescription();
		}
		
		return $template_code_list;
	}
}

//end