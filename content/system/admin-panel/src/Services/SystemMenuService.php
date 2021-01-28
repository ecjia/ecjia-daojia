<?php

namespace Ecjia\System\AdminPanel\Services;

use ecjia_admin;
use RC_Hook;
use RC_Uri;

/**
 * 后台菜单API
 * @author royalwang
 */
class SystemMenuService
{
    /**
     * @param $options
     * @return array|\admin_menu
     */
	public function handle(& $options)
    {
        $menus = array(
            ecjia_admin::make_admin_menu('dashboard', __('仪表盘'), RC_Uri::url('@index/init'), 1),
            ecjia_admin::make_admin_menu('homepage', __('访问首页'), RC_Uri::site_url(), 2, '_blank'),
            ecjia_admin::make_admin_menu('divider', '', '', 3)->add_purview(array('shop_authorized', 'admin_cache', 'shop_config', 'admin_manage', 'area_manage', 'role_manage', 'logs_manage')),
            ecjia_admin::make_admin_menu('privilege', __('权限管理'), '', 4)->add_submenu(array(
                ecjia_admin::make_admin_menu('nav-header', 'Purview', '', 0)->add_purview(array('admin_manage', 'admin_drop', 'allot_priv', 'logs_manage', 'logs_drop', 'role_manage')),
                ecjia_admin::make_admin_menu('privilege', __('管理员列表'), RC_Uri::url('@admin_user/init'), 1)->add_purview(array('admin_manage', 'admin_drop', 'allot_priv')),
                ecjia_admin::make_admin_menu('role_list', __('角色管理'), RC_Uri::url('@admin_role/init'), 2)->add_purview('role_manage'),
                ecjia_admin::make_admin_menu('nav-header', 'Log', '', 10)->add_purview(array('logs_manage')),
                ecjia_admin::make_admin_menu('admin_logs', __('管理员日志'), RC_Uri::url('@admin_logs/init'), 11)->add_purview(array('logs_manage', 'logs_drop')),
                ecjia_admin::make_admin_menu('session_logins', __('登录日志'), RC_Uri::url('@admin_session_login/init'), 11)->add_purview(array('session_login_manage', 'session_login_drop')),
                ecjia_admin::make_admin_menu('nav-header', 'Session', '', 20)->add_purview(array('session_manage')),
                ecjia_admin::make_admin_menu('admin_session', __('会话管理'), RC_Uri::url('@admin_session/init'), 21)->add_purview(array('session_manage', 'session_drop')),
            )),
            ecjia_admin::make_admin_menu('shop_authorized', __('授权证书'), RC_Uri::url('@license/license'), 6)->add_purview('shop_authorized'),
            ecjia_admin::make_admin_menu('admin_cache', __('更新缓存'), RC_Uri::url('@admin_cache/init'), 7)->add_purview('admin_cache'),
            ecjia_admin::make_admin_menu('divider', '', '', 11)->add_purview(array('application_manage', 'plugin_manage')),
            ecjia_admin::make_admin_menu('application_manage', __('应用管理'), RC_Uri::url('@admin_application/init'), 12)->add_purview('application_manage'),
            ecjia_admin::make_admin_menu('plugin_manage', __('插件管理'), RC_Uri::url('@admin_plugin/init'), 13)->add_purview('plugin_manage'),
            ecjia_admin::make_admin_menu('plugin_config', __('插件配置'), RC_Uri::url('@admin_plugin/config'), 15)->add_purview('plugin_config'),
        );

        if (config('site.shop_type') == 'cityo2o') {
            $menus[] = ecjia_admin::make_admin_menu('divider', '', '', 21)->add_purview(array('admin_upgrade', 'file_check', 'file_priv'));
            $menus[] = ecjia_admin::make_admin_menu('upgrade', __('可用更新'), RC_Uri::url('@upgrade/init'), 22)->add_purview('admin_upgrade');
            $menus[] = ecjia_admin::make_admin_menu('admin_filehash', __('文件校验'), RC_Uri::url('@admin_filehash/init'), 23)->add_purview('file_check');
            $menus[] = ecjia_admin::make_admin_menu('admin_filepermission', __('目录权限检测'), RC_Uri::url('@admin_file_permission/init'), 24)->add_purview('file_priv');
        }

        if (RC_Hook::apply_filters('ecjia_admin_about_show', true)) {
            $menus[] = ecjia_admin::make_admin_menu('divider', '', '', 31);
            $menus[] = ecjia_admin::make_admin_menu('about_us', __('关于'), RC_Uri::url('@about/about_us'), 32);
        }

        return $menus;
    }
}

// end