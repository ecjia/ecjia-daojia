<?php

namespace Ecjia\App\Maintain\Services;


use ecjia_admin;
use RC_Uri;

/**
 * 后台菜单API
 * @author royalwang
 */
class ToolMenuService
{
    /**
     * @param $options
     * @return
     */
    public function handle($options)
    {

        $menus = ecjia_admin::make_admin_menu('06_maintain_list', __('运维工具', 'maintain'), RC_Uri::url('maintain/admin/init'), 6)->add_purview('maintain_manage');

        return $menus;

    }
}

// end