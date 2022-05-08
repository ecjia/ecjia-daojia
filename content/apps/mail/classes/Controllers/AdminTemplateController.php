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
namespace Ecjia\App\Mail\Controllers;

use admin_nav_here;
use admin_notice;
use ecjia;
use Ecjia\App\Mail\EventFactory\EventFactory;
use Ecjia\App\Mail\Lists\TemplateCodeAvailableOptions;
use Ecjia\App\Mail\Lists\TemplateCodeList;
use Ecjia\App\Mail\Models\MailTemplateModel;
use Ecjia\Component\ActionLink\ActionLink;
use Ecjia\Component\ActionLink\ActionLinkGroup;
use Ecjia\Component\ActionLink\ActionLinkRender;
use ecjia_admin;
use ecjia_screen;
use Illuminate\Support\Facades\Mail;
use RC_Api;
use RC_App;
use RC_DB;
use RC_Script;
use RC_Style;
use RC_Time;
use RC_Uri;

/**
 * ECJIA消息模板模块
 * @author songqian
 */
class AdminTemplateController extends AdminBase
{
	
	public function __construct()
    {
		parent::__construct();
		
		
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

		RC_Script::enqueue_script('push_template', RC_App::apps_url('statics/js/mail_template.js', $this->__FILE__), array(), false, false);
		RC_Script::localize_script('push_template', 'js_lang_mail_template', config('app-mail::jslang.mail_template_page'));

		RC_Script::enqueue_script('push_events', RC_App::apps_url('statics/js/mail_events.js', $this->__FILE__), array(), false, false);
		RC_Script::localize_script('push_events', 'js_lang_mail_events', config('app-mail::jslang.mail_events_page'));
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('邮件模板', 'mail'), RC_Uri::url('mail/admin_template/init')));
	}
	
	/**
	 * 消息模板
	 */
	public function init()
    {
		$this->admin_priv('mail_template_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('邮件模板', 'mail')));

		$action_links = (new ActionLinkGroup())->addLink(
                            new ActionLink(RC_Uri::url('mail/admin_events/init'), __('邮件事件列表', 'mail'), 'fontello-icon-reply')
                        )->addLink(
                            new ActionLink(RC_Uri::url('mail/admin_template/add'), __('添加邮件模板', 'mail'), 'fontello-icon-plus')
                        );
		$render = (new ActionLinkRender($action_links))->render();

		$this->assign('ur_here', __('邮件模板', 'push'));
		$this->assign('action_links', $render);

		$template = MailTemplateModel::mail()->select('id', 'template_code', 'template_subject', 'template_content')
                    ->where('channel_type', 'mail')
                    ->orderby('id', 'desc')
                    ->get()->toArray();

		$this->assign('template', $template);

        return $this->display('mail_template_list.dwt');
	}

	/**
	 * 添加模板页面
	 */
	public function add()
    {
		$this->admin_priv('mail_template_update');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('邮件模板', 'mail')));

		$channel_code = $this->request->input('channel_code');

        $action_links = (new ActionLinkGroup())->addLink(
            new ActionLink(RC_Uri::url('mail/admin_template/init'), __('邮件模板列表', 'mail'), 'fontello-icon-reply')
        );
        $render = (new ActionLinkRender($action_links))->render();
	
		$this->assign('ur_here', __('添加邮件模板', 'mail'));
		$this->assign('action_links', $render);
		
		$template_code_list = (new TemplateCodeAvailableOptions())();

		if (empty($template_code_list)) {
            ecjia_screen::get_current_screen()->add_admin_notice(new admin_notice(__('<strong>温馨提示：</strong>暂时没有邮件模板可添加。', 'mail')));
        }

		$this->assign('template_code_list', $template_code_list);
		
		$this->assign('channel_code', $channel_code);
	
		$this->assign('form_action', RC_Uri::url('mail/admin_template/insert'));
		$this->assign('action', 'insert');

        return $this->display('mail_template_info.dwt');
	}
	
	public function ajax_event()
    {
        $this->admin_priv('mail_template_update');

	    $code = trim($_POST['code']);
	    $channel_code = trim($_POST['channel_code']);
	    $event = with(new EventFactory)->event($code);

        $hits = [];
	    $getValueHit = $event->getValueHit();
	    if (!empty($getValueHit)) {
            $hits[] = sprintf(__('可用变量：%s', 'mail'), $getValueHit);
	    }
        $hits[] = __('变量使用说明：变量不限位置摆放，可自由摆放，但变量不可自定义名称，需保持与以上名称一致。', 'mail');
	    	    
	    $template = $event->getTemplate();

	    $desc = implode('<br>', $hits);

	    return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array(
	        'content' => '<span class="help-block">'.$desc.'</span>',
            'template' => $template,
        ));
	}
	
	/**
	 * 添加模板处理
	 */
	public function insert()
    {
		$this->admin_priv('mail_template_update');
		
		$template_code = $_POST['template_code'];
		$subject       = trim($_POST['subject']);
		$content       = trim($_POST['content']);
		$channel_code  = $_POST['channel_code'];
		
		if (empty($template_code)) {
			return $this->showmessage(__('请选择消息事件', 'mail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$query = MailTemplateModel::mail()->where('template_code', $template_code)->count();
		if ($query > 0) {
			return $this->showmessage(__('该邮件模板代号在该渠道下已存在', 'mail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$data = array(
			'template_code'    => $template_code,
			'template_subject' => $subject,
			'template_content' => $content,
			'content_type'	   => 'text',
			'last_modify'      => RC_Time::gmtime(),
			'channel_type'     => 'mail',
			'channel_code'	   => $channel_code,
		);
		$id = MailTemplateModel::insertGetId($data);
		
		ecjia_admin::admin_log($subject, 'add', 'mail_template');

		return $this->showmessage(__('添加邮件模板成功', 'mail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mail/admin_template/edit', array('id' => $id, 'event_code' => $template_code))));
	}
	
	/**
	 * 模板修改
	 */
	public function edit()
    {
		$this->admin_priv('mail_template_update');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('邮件模板', 'mail')));

        $this->assign('ur_here', __('编辑邮件模板', 'mail'));

        $action_links = (new ActionLinkGroup())->addLink(
            new ActionLink(RC_Uri::url('mail/admin_template/init'), __('邮件模板列表', 'mail'), 'fontello-icon-reply')
        );
        $render = (new ActionLinkRender($action_links))->render();

		$this->assign('action_links', $render);


        $template_code_list = (new TemplateCodeAvailableOptions())();
		
		$this->assign('template_code_list', $template_code_list);


        $id = intval($_GET['id']);

		$data = RC_DB::connection('ecjia')->table('notification_templates')->where('id', $id)->first();
		$this->assign('data', $data);
		
		$channel_code = trim($_GET['channel_code']);
		$this->assign('channel_code', $channel_code);
		
		$event_code = trim($_GET['event_code']);

		$event = with(new EventFactory)->event($event_code);
		
		$hits = [];
		$getValueHit = $event->getValueHit();
		if (!empty($getValueHit)) {
            $hits[] = sprintf(__('可用变量：%s', 'push'), $getValueHit);
		}
        $hits[] = __('变量使用说明：变量不限位置摆放，可自由摆放，但变量不可自定义名称，需保持与以上名称一致。', 'mail');

        $desc = implode('<br>', $hits);

		$this->assign('desc', $desc);
		
		$this->assign('form_action', RC_Uri::url('mail/admin_template/update'));

        return $this->display('mail_template_info.dwt');
	}
	
	/**
	 * 保存模板内容
	 */
	public function update()
    {
		$this->admin_priv('mail_template_update');
		
		$id = intval($_POST['id']);
		$template_code = $_POST['template_code'];
		$subject       = trim($_POST['subject']);
		$content       = trim($_POST['content']);
		$channel_code  = $_POST['channel_code'];
	
		if (empty($template_code)) {
			return $this->showmessage(__('请选择邮件事件', 'mail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$query = MailTemplateModel::mail()->where('template_code', $template_code)->where('id', '!=', $id)->count();
    	if ($query > 0) {
    		return $this->showmessage(__('该消息邮件代号在该渠道下已存在', 'mail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}

		$data = array(
			'template_code'    => $template_code,
			'template_subject' => $subject,
			'template_content' => $content,
			'last_modify'      => RC_Time::gmtime(),
		);
		MailTemplateModel::mail()->where('id', $id)->update($data);
		
		ecjia_admin::admin_log($subject, 'edit', 'mail_template');

	  	return $this->showmessage(__('编辑邮件模板成功', 'mail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('mail/admin_template/edit', array('id' => $id, 'event_code' => $template_code))));
	}

	/**
	 * 删除消息模板
	 */
	public function remove()
    {
		$this->admin_priv('mail_template_delete');
	
		$id = intval($_GET['id']);

		$info = MailTemplateModel::mail()->where('id', $id)->select('template_subject')->first();
		MailTemplateModel::mail()->where('id', $id)->delete();
		 
		ecjia_admin::admin_log($info['template_subject'], 'remove', 'mail_template');

		return $this->showmessage(__('删除消息模板成功', 'push'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mail/admin_template/init')));
	}

}

//end