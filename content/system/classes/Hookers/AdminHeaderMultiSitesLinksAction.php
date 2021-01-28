<?php


namespace Ecjia\System\Hookers;


use ecjia_admin;
use RC_Hook;
use RC_Uri;

class AdminHeaderMultiSitesLinksAction
{

    /**
     * Handle the event.
     * hook:admin_dashboard_header_links
     * @return void
     */
    public function handle()
    {
        $menus = $this->getMultSitesMenus();
        if (!empty($menus)) {
            echo '<li class="divider-vertical hidden-phone hidden-tablet"></li>';
            echo '<li class="dropdown">';
            echo '    <a class="dropdown-toggle nav_condensed" href="#" data-toggle="dropdown"><i class="fontello-icon-sitemap"></i> 多站点切换</a>';
            echo '    <ul class="dropdown-menu">';
            collect($menus)->each(function ($menu) {
                if ($menu->action == 'divider') {
                    echo '<li class="divider"></li>';
                }
                else {
                    echo '<li><a href="' .$menu->link. '" target="' . $menu->target . '">' .$menu->name. '</a></li>';
                }
            });
            echo '    </ul>';
            echo '</li>';
        }
    }


    protected function getMultSitesMenus()
    {
        $sites = config('multisites');

        foreach ($sites as $key => $site) {
            $url = RC_Uri::url('@index/init');
            $site_dir = rtrim($site['site_dir'], '/');
            $url = str_replace(RC_Uri::site_url(), RC_Uri::home_url($site_dir), $url);
            $menus[] = ecjia_admin::make_admin_menu($site['site_id'], $site['site_name'], $url, $key);
        }

        $menus = RC_Hook::apply_filters('ecjia_admin_extend_menus', $menus);

        usort($menus, array('ecjia_utility', 'admin_menu_by_sort'));

        return $menus;
    }

}