<?php


namespace Ecjia\System\Hookers;


use Ecjia\System\Admins\AdminMenu\SidebarMenuGroup;
use RC_Uri;

class DisplayAdminSidebarNavAction
{

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        $groups = (new SidebarMenuGroup())->getMenus();

        if (!empty($groups)) {
            foreach ($groups as $group) {
                //应用菜单
                if (!empty($group['menus'])) {
                    foreach ($group['menus'] as $k => $menu) {
                        $this->displayMenus($menu, $k, $group);
                    }
                }
            }
        }
    }

    /**
     * @param $menu
     * @param $k
     * @param \Ecjia\Component\Menu\MenuGroup\AbstractMenuGroup $group
     */
    protected function displayMenus($menu, $k, $group)
    {
        $key = $group['group'] . $k;

        echo '<div class="accordion-group">';
        echo '<div class="accordion-heading">';
        echo '<a class="accordion-toggle" href="#collapse_' . $key . '" data-parent="#side_accordion" data-toggle="collapse">';
        echo '<i class="icon-folder-close"></i> ' . $menu->name;
        echo '</a>';
        echo '</div>';
        if ($menu->has_submenus) {
            echo '<div class="accordion-body collapse" id="collapse_' . $key . '">';
            echo '<div class="accordion-inner">';
            echo '<ul class="nav nav-list">';
            if ($menu->submenus) {
                foreach ($menu->submenus as $child) {
                    if ($child->action == 'divider') {
                        echo '<li class="divider"></li>';
                    } elseif ($child->action == 'nav-header') {
                        echo '<li class="nav-header">' . $child->name . '</li>';
                    } else {
                        if(RC_Uri::current_url() === $child->link){
                            echo '<li class="active"><a href="' . $child->link . '">' . $child->name . '</a></li>';
                        }else {
                            echo '<li><a href="' . $child->link . '">' . $child->name . '</a></li>';
                        }
                    }
                }
            }
            echo '</ul>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    }

}