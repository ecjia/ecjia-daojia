<?php

namespace Ecjia\App\Cron;

use ecjia_admin_log;
use RC_Service;
use Royalcms\Component\App\AppParentServiceProvider;

class CronServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-cron');

        $this->assignAdminLogContent();
    }
    
    public function register()
    {
        $this->registerNamespaces();

        $this->registerProviders();

        $this->registerAppService();
    }

    /**
     * Register the Namespaces
     */
    public function registerNamespaces()
    {
        //
    }

    /**
     * Register the Providers
     */
    public function registerProviders()
    {
        //
    }

    protected function registerAppService()
    {
        RC_Service::addService('admin_purview', 'cron', 'Ecjia\App\Cron\Services\CronAdminPurviewService');
        RC_Service::addService('cron_info', 'cron', 'Ecjia\App\Cron\Services\CronCronInfoService');
        RC_Service::addService('plugin_install', 'cron', 'Ecjia\App\Cron\Services\CronPluginInstallService');
        RC_Service::addService('plugin_menu', 'cron', 'Ecjia\App\Cron\Services\CronPluginMenuService');
        RC_Service::addService('plugin_uninstall', 'cron', 'Ecjia\App\Cron\Services\CronPluginUninstallService');
        RC_Service::addService('admin_menu', 'cron', 'Ecjia\App\Cron\Services\CronAdminMenuService');
    }

    /**
     * 添加管理员记录日志操作对象
     */
    protected function assignAdminLogContent()
    {
        ecjia_admin_log::instance()->add_action('enabled', __('启用', 'cron'));
        ecjia_admin_log::instance()->add_action('disable', __('禁用', 'cron'));
        ecjia_admin_log::instance()->add_action('run', __('执行', 'cron'));
        ecjia_admin_log::instance()->add_object('cron', __('计划任务', 'cron'));
    }
    
}