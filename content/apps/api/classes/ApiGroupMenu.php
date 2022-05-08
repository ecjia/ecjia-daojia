<?php

namespace Ecjia\App\Api;

use admin_menu;
use Ecjia\Component\ApiServer\Route\ApiRouteManager;
use Ecjia\Component\Menu\AdminMenu;
use ecjia_admin;
use RC_Object;
use RC_Uri;

class ApiGroupMenu extends RC_Object
{

    protected $menus;

    public function __construct()
    {
        $this->menus = $this->loadGroups();
    }

    /**
     * 获取菜单，并鉴权和排序
     * @return array
     */
    public function getMenus()
    {

        $menus = collect($this->menus)->map(function ($admin_menu, $key) {
            /**
             * @var AdminMenu $admin_menu
             */
            if ($this->checkAdminMenuPrivilege($admin_menu)) {

                if ($admin_menu->has_submenus) {

                    if ($admin_menu->has_submenus()) {
                        collect($admin_menu->submenus())->map(function ($sub_menu) use ($admin_menu) {

                            if ($this->checkAdminMenuPrivilege($sub_menu)) {
                                return $sub_menu;
                            } else {
                                $admin_menu->remove_submenu($sub_menu);
                            }

                            return $sub_menu;
                        });

                        return $admin_menu;
                    } else {
                        return null;
                    }

                } else {
                    return $admin_menu;
                }

            } else {
                return null;
            }

        })->filter()->sort(array('ecjia_utility', 'admin_menu_by_sort'));

        return $menus;
    }

    /**
     * 加载菜单
     * @return array|mixed
     */
    protected function loadGroups()
    {
        $apis = (new ApiRouteManager())->getApiListGroupBy();

        $menus = collect($apis)->keys()->map(function ($item, $key) {
            return ecjia_admin::make_admin_menu(
                $item,
                $item,
                RC_Uri::url('api/admin/init', array('code' => $item)),
                $key
            );
        });

        return $menus;
    }

    /**
     * 检查管理员菜单权限
     */
    protected function checkAdminMenuPrivilege(AdminMenu $admin_menu)
    {
        return true;
    }


}