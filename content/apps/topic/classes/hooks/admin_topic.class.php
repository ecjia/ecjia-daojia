<?php
defined('IN_ECJIA') or exit('No permission resources.');

class topic_admin_plugin
{

    public static function topic_admin_menu_api($menus)
    {
        $menu = ecjia_admin::make_admin_menu('06_topic_list', __('专题管理', 'topic'), RC_Uri::url('topic/admin/init'), 6)->add_purview('topic_manage');
        $menus->add_submenu($menu);
        return $menus;
    }
}

RC_Hook::add_filter('promotion_admin_menu_api', array('topic_admin_plugin', 'topic_admin_menu_api'));
// end
