<?php


namespace Ecjia\System\Hookers;


use ecjia_admin;
use RC_Hook;
use RC_Uri;

class AdminHeaderProfileLinksAction
{

    /**
     * Handle the event.
     * hook:admin_dashboard_header_links
     * @return void
     */
    public function handle()
    {
        $menus = $this->getProfileMenus();

        collect($menus)->each(function ($menu) {
            if ($menu->action == 'divider') {
                echo '<li class="divider"></li>';
            }
            else {
                echo '<li><a href="' .$menu->link. '" target="' . $menu->target . '">' .$menu->name. '</a></li>';
            }
        });

    }


    protected function getProfileMenus()
    {
        $menus = [
            ecjia_admin::make_admin_menu('admin_privilege_modif', __('个人设置'), RC_Uri::url('@privilege/modif'), 1),
            ecjia_admin::make_admin_menu('divider', '', '', 11),
            ecjia_admin::make_admin_menu('admin_message', __('退出'), RC_Uri::url('@privilege/logout'), 12),
        ];

        $menus = RC_Hook::apply_filters('ecjia_admin_profile_menus', $menus);

        usort($menus, array('ecjia_utility', 'admin_menu_by_sort'));

        return $menus;
    }

}