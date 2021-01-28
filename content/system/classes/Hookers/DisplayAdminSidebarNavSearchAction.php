<?php


namespace Ecjia\System\Hookers;


use Ecjia\System\Admins\AdminMenu\SidebarMenuGroup;

class DisplayAdminSidebarNavSearchAction
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
     * @param string $menu
     * @param int $k
     * @param \Ecjia\Component\Menu\MenuGroup\AbstractMenuGroup $group
     */
    protected function displayMenus($menu, $k, $group)
    {
        if ($menu->has_submenus) {
            if ($menu->submenus) {
                foreach ($menu->submenus as $child) {
                    if ($child->action == 'divider') {
                        echo '<li class="divider"></li>';
                    } elseif ($child->action == 'nav-header') {
                        echo '<li class="nav-header">' . $child->name . '</li>';
                    } else {
                        echo '<li><a href="' . $child->link . '">' . $child->name . '</a></li>';
                    }
                }
            }
        }
    }

}