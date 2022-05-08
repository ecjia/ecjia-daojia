<?php


namespace Ecjia\App\Installer\Subscribers;


use admin_notice;
use ecjia_screen;
use Royalcms\Component\Hook\Dispatcher;

class AdminHookSubscriber
{
    /**
     * Handle events.
     */
    public function onDisplayInstallerExistsAppAction()
    {
        if (file_exists(RC_APP_PATH . 'installer') && ecjia_is_super_admin()) {
            $warning = sprintf(__('您还没有删除 %s 文件夹，出于安全的考虑，我们建议您删除 %s 文件夹。', 'installer'), 'installer', 'content/apps/installer');
            ecjia_screen::get_current_screen()->add_admin_notice(new admin_notice($warning));
        }
    }


    /**
     * Register the listeners for the subscriber.
     *
     * @param \Royalcms\Component\Hook\Dispatcher $events
     * @return void
     */
    public function subscribe(Dispatcher $events)
    {

        $events->addAction(
            'ecjia_admin_dashboard_index',
            'Ecjia\App\Installer\Subscribers\AdminHookSubscriber@onDisplayInstallerExistsAppAction'
        );

    }

}