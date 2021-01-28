<?php

namespace Ecjia\App\Mail;

use Ecjia\App\Mail\Events\ResetMailConfigEvent;
use Ecjia\App\Mail\Listeners\ResetMailSmtpServiceListener;
use ecjia_admin_log;
use RC_Event;
use RC_Hook;
use RC_Service;
use Royalcms\Component\App\AppParentServiceProvider;

class MailServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-mail');

        $this->assignAdminLogContent();

        $this->bootEvent();

        //hook
//        RC_Hook::add_action('reset_mail_config', ['Ecjia\Component\Mailer\Mailer', 'ecjia_mail_config']);
    }
    
    public function register()
    {
        $this->registerAppService();
    }

    protected function registerAppService()
    {
        RC_Service::addService('admin_purview', 'mail', 'Ecjia\App\Mail\Services\AdminPurviewService');
        RC_Service::addService('admin_menu', 'mail', 'Ecjia\App\Mail\Services\AdminMenuService');
        RC_Service::addService('mail_template', 'mail', 'Ecjia\App\Mail\Services\MailTemplateService');
        RC_Service::addService('plugin_menu', 'mail', 'Ecjia\App\Mail\Services\PluginMenuService');
        RC_Service::addService('plugin_install', 'mail', 'Ecjia\App\Mail\Services\PluginInstallService');
        RC_Service::addService('plugin_uninstall', 'mail', 'Ecjia\App\Mail\Services\PluginUninstallService');
        RC_Service::addService('send_event_mail', 'mail', 'Ecjia\App\Mail\Services\SendEventMailService');
    }

    protected function bootEvent()
    {
        RC_Event::listen(ResetMailConfigEvent::class, ResetMailSmtpServiceListener::class);
    }

    /**
     * 添加管理员记录日志操作对象
     */
    protected function assignAdminLogContent()
    {
        ecjia_admin_log::instance()->add_object('email', __('邮件地址', 'mail'));
        ecjia_admin_log::instance()->add_object('subscription_email', __('订阅邮件', 'mail'));
        ecjia_admin_log::instance()->add_object('email_template', __('邮件模板', 'mail'));
        ecjia_admin_log::instance()->add_object('email_sendlist', __('邮件记录', 'mail'));

        ecjia_admin_log::instance()->add_action('batch_send', __('批量发送', 'mail'));
        ecjia_admin_log::instance()->add_action('all_send', __('全部发送', 'mail'));

        ecjia_admin_log::instance()->add_action('batch_exit', __('批量退订', 'mail'));
        ecjia_admin_log::instance()->add_action('batch_ok', __('批量确定', 'mail'));

        ecjia_admin_log::instance()->add_action('batch_setup', __('批量设置', 'mail'));
    }
    
}