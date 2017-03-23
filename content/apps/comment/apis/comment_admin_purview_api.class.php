<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 后台权限API
 * @author royalwang
 *
 */
class comment_admin_purview_api extends Component_Event_Api {
    
    public function call(&$options) {
        $purviews = array(
            array('action_name' => RC_Lang::get('comment::comment_manage.comment_manage'), 	'action_code' => 'comment_manage', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('comment::comment_manage.comment_update'), 	'action_code' => 'comment_update', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('comment::comment_manage.comment_delete'), 	'action_code' => 'comment_delete', 	'relevance' => ''),
        	array('action_name' => '评论回收站列表', 	'action_code' => ' comment_trash_list', 	'relevance' => ''),
        	array('action_name' => '评论申诉管理', 	'action_code' => 'appeal_manage', 	'relevance' => ''),
        	array('action_name' => '评论申诉审核', 	'action_code' => 'appeal_update', 	'relevance' => ''),
            array('action_name' => '评论设置', 	'action_code' => 'comment_config', 	'relevance' => ''),
            
        );
        
        return $purviews;
    }
}

// end