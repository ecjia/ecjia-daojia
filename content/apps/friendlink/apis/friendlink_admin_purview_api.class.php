<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 后台权限API
 * @author royalwang
 *
 */
class friendlink_admin_purview_api extends Component_Event_Api
{
    public function call(&$options)
    {
        $purviews = array(
            array('action_name' => __('友情链接管理', 'friendlink'), 'action_code' => 'friendlink_manage', 'relevance' => ''),
            array('action_name' => __('编辑友情链接', 'friendlink'), 'action_code' => 'friendlink_update', 'relevance' => ''),
            array('action_name' => __('删除友情链接', 'friendlink'), 'action_code' => 'friendlink_delete', 'relevance' => ''),
        );
        return $purviews;
    }
}

// end
