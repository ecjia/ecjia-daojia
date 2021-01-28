<?php
namespace Ecjia\App\Mail\Services;


use ecjia_admin;
use RC_Uri;

/**
 * 后台菜单API
 * @author royalwang
 */
class AdminMenuService
{
    /**
     * @param $options
     * @return
     */
	public function handle(& $options)
    {
        $menus = ecjia_admin::make_admin_menu('14_email_manage', __('邮件管理', 'mail'), '', 14);

        $submenus = array(
            ecjia_admin::make_admin_menu('mail_template', __('邮件模板', 'mail'), RC_Uri::url('mail/admin_template/init'), 11)->add_purview('mail_template_manage'),
            ecjia_admin::make_admin_menu('mail_event', __('邮件事件', 'mail'), RC_Uri::url('mail/admin_events/init'), 13)->add_purview('mail_events_manage'),
            ecjia_admin::make_admin_menu('mail_plugin', __('邮件渠道', 'mail'), RC_Uri::url('mail/admin_plugin/init'), 14)->add_purview('mail_plugin_manage'),
            ecjia_admin::make_admin_menu('mail_test', __('发送测试邮件', 'mail'), RC_Uri::url('mail/admin_mail_test/init'), 14)->add_purview('mail_plugin_manage'),
            ecjia_admin::make_admin_menu('view_sendlist', __('邮件发送队列', 'mail'), RC_Uri::url('mail/admin_mail_sendlist/init'), 16)->add_purview('email_sendlist_manage'),
        );

        $menus->add_submenu($submenus);
    	
    	return $menus;
    	
    }
}

// end