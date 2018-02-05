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
            array('action_name' => RC_Lang::get('friendlink::friend_link.friendlink_manage'), 'action_code' => 'friendlink_manage', 'relevance' => ''),
            array('action_name' => RC_Lang::get('friendlink::friend_link.friendlink_update'), 'action_code' => 'friendlink_update', 'relevance' => ''),
            array('action_name' => RC_Lang::get('friendlink::friend_link.friendlink_delete'), 'action_code' => 'friendlink_delete', 'relevance' => ''),
        );
        return $purviews;
    }
}

// end
