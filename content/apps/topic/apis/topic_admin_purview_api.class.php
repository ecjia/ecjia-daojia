<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 后台权限API
 * @author songqian
 *
 */
class topic_admin_purview_api extends Component_Event_Api
{

    public function call(&$options)
    {
        $purviews = array(
            array('action_name' => __('专题管理', 'topic'), 'action_code' => 'topic_manage', 'relevance' => ''),
            array('action_name' => __('专题更新', 'topic'), 'action_code' => 'topic_update', 'relevance' => ''),
            array('action_name' => __('删除专题', 'topic'), 'action_code' => 'topic_delete', 'relevance' => ''),
        );

        return $purviews;
    }
}

// end
