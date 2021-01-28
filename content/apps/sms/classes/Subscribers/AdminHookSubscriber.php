<?php


namespace Ecjia\App\Sms\Subscribers;

use ecjia_admin;
use RC_Uri;
use Royalcms\Component\Hook\Dispatcher;

class AdminHookSubscriber
{
    public static function append_admin_setting_group($menus) {
        $menus[] = ecjia_admin::make_admin_menu('nav-header', __('短信', 'sms'), '', 280)->add_purview(array('shop_config'));
        $menus[] = ecjia_admin::make_admin_menu('sms', __('短信通知', 'sms'), RC_Uri::url('sms/admin_config/init'), 281)->add_purview('shop_config')->add_icon('fontello-icon-chat-empty');

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

        //RC_Hook::add_action( 'append_admin_setting_group', array('sms_admin_hooks', 'append_admin_setting_group') );


    }

}