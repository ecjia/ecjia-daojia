<?php


namespace Ecjia\System\Admins\AdminMenu;


/**
 * 后台顶部菜单
 * Class HeaderMenuGroup
 * @package Ecjia\System\Admins\AdminMenu
 */
class HeaderMenuGroup extends AbstractMenuGroup
{
    /**
     * 缓存Key
     * @var string
     */
    protected $cache_key = 'admin_menus_by_header_menu';

    protected $groups = [
        \Ecjia\Component\Menu\MenuGroup\SystemMenuGroup::class,
        \Ecjia\Component\Menu\MenuGroup\AppsMenuGroup::class,
        \Ecjia\Component\Menu\MenuGroup\ToolsMenuGroup::class,
        \Ecjia\Component\Menu\MenuGroup\SettingMenuGroup::class,
        \Ecjia\Component\Menu\MenuGroup\ServiceMenuGroup::class,
    ];

    public function __construct()
    {
        parent::__construct();

        $this->isExistsThemes();
    }

    /**
     * 判断是否启用主题目录
     */
    protected function isExistsThemes()
    {
        //判断是否启用主题目录，启用才开放此功能
        if (file_exists(SITE_THEME_PATH) || file_exists(RC_THEME_PATH)) {
            $this->groups[] = \Ecjia\Component\Menu\MenuGroup\SkinMenuGroup::class;
        }
    }



}