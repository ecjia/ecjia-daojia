<?php


namespace Ecjia\System\Admins\AdminMenu;

/**
 * 后台左侧边栏的菜单
 * Class SidebarMenuGroup
 * @package Ecjia\System\Admins\AdminMenu
 */
class SidebarMenuGroup extends AbstractMenuGroup
{
    /**
     * 缓存Key
     * @var string
     */
    protected $cache_key = 'admin_menus_for_sidebar_menu';

    protected $cache_seconds = 3600;

    protected $groups = [
        \Ecjia\Component\Menu\MenuGroup\ShortcutMenuGroup::class,
        \Ecjia\Component\Menu\MenuGroup\AppsMenuGroup::class,
    ];


}