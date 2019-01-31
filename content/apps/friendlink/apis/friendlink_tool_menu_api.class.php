<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 后台工具菜单API
 * @author royalwang
 *
 */
class friendlink_tool_menu_api extends Component_Event_Api
{
    public function call(&$options)
    {
        $menus = ecjia_admin::make_admin_menu('03_friendlink_manage', __('友情链接', 'friendlink'), RC_Uri::url('friendlink/admin/init'), 3)->add_purview('friendlink_manage');
        return $menus;
    }
}

// end
