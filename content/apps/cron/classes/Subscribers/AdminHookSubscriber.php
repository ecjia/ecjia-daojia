<?php


namespace Ecjia\App\Cron\Subscribers;


use ecjia_admin;
use RC_Hook;
use RC_Uri;
use Royalcms\Component\Hook\Dispatcher;

class AdminHookSubscriber
{

    public static function append_admin_setting_group($menus)
    {
        $menus[] = ecjia_admin::make_admin_menu('nav-header', '计划任务', '', 120)->add_purview(array('cron_config_manage'));
        $menus[] = ecjia_admin::make_admin_menu('cron', '计划任务', RC_Uri::url('cron/admin_config/init'), 121)->add_purview('cron_config_manage');

        return $menus;
    }


    /**
     * Register the listeners for the subscriber.
     *
     * @param \Royalcms\Component\Hook\Dispatcher $events
     * @return void
     */
    public function subscribe(Dispatcher $events)
    {
        RC_Hook::add_action('append_admin_setting_group', array(__CLASS__, 'append_admin_setting_group'));
    }

}