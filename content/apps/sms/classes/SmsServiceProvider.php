<?php

namespace Ecjia\App\Sms;

use ecjia_admin_log;
use RC_Service;
use Royalcms\Component\App\AppParentServiceProvider;

class SmsServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-sms');

        $this->assignAdminLogContent();
    }
    
    public function register()
    {
        $this->registerAppService();
    }

    protected function registerAppService()
    {
        RC_Service::addService('admin_purview', 'sms', 'Ecjia\App\Sms\Services\AdminPurviewService');
        RC_Service::addService('admin_menu', 'sms', 'Ecjia\App\Sms\Services\AdminMenuService');
        RC_Service::addService('plugin_menu', 'sms', 'Ecjia\App\Sms\Services\PluginMenuService');
        RC_Service::addService('plugin_install', 'sms', 'Ecjia\App\Sms\Services\PluginInstallService');
        RC_Service::addService('plugin_uninstall', 'sms', 'Ecjia\App\Sms\Services\PluginUninstallService');
        RC_Service::addService('sms_template', 'sms', 'Ecjia\App\Sms\Services\SmsTemplateService');
        RC_Service::addService('send_event_sms', 'sms', 'Ecjia\App\Sms\Services\SendEventSmsService');
    }

    /**
     * 添加管理员记录日志操作对象
     */
    protected function assignAdminLogContent()
    {
        ecjia_admin_log::instance()->add_object('sms_template', __('短信模板', 'sms'));
        ecjia_admin_log::instance()->add_object('sms_config', __('短信配置', 'sms'));
        ecjia_admin_log::instance()->add_object('sms_record', __('短信记录', 'sms'));
        ecjia_admin_log::instance()->add_object('sms_channel', __('短信渠道', 'sms'));
        ecjia_admin_log::instance()->add_object('sms_channel_sort', __('短信渠道排序', 'sms'));
        ecjia_admin_log::instance()->add_object('sms', __('短信', 'sms'));
        ecjia_admin_log::instance()->add_object('sms_events', __('短信事件', 'sms'));

        ecjia_admin_log::instance()->add_action('batch_setup', __('批量设置', 'sms'));
        ecjia_admin_log::instance()->add_action('close', __('关闭', 'sms'));
    }
    
    
}