<?php

namespace Ecjia\App\Api\Services;

use ecjia_admin;
use RC_Uri;

/**
 * 后台工具菜单API
 * @author royalwang
 */
class AdminMenuService
{
    /**
     * @param $options
     * @return mixed
     */
    public function handle(&$options)
    {
        $menus = ecjia_admin::make_admin_menu('api_manage', __('API管理', 'api'), '', 20);

        $submenus = array(
            ecjia_admin::make_admin_menu('api_manage_list', __('API管理', 'api'), RC_Uri::url('api/admin/init'), 20)->add_purview('api_manage'),
        );

        $menus->add_submenu($submenus);

        return $menus;
    }
}

// end