<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 专题列表页
 * @author zrl
 *
 */
class topic_list_module extends api_front implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
    	
    	/* 获取数量 */
    	$size = $this->requestData('pagination.count', 15);
    	$page = $this->requestData('pagination.page', 1);
    	
    	$result = RC_Api::api('topic', 'topic_list', array('size' => $size, 'page' => $page));
    	$list = array();
    	if (!empty($result['list'])) {
    		foreach ($result['list'] as $val) {
    			if (substr($val['topic_img'], 0, 4) != 'http') {
    				$val['topic_img'] = !empty($val['topic_img']) ? RC_Upload::upload_url($val['topic_img']) : '';
    			}
    			$list[] = array(
    					'topic_id'				=> intval($val['topic_id']),
    					'topic_title'			=> empty($val['title']) ? '' : trim($val['title']),
    					'topic_description' 	=> empty($val['description']) ? '' : trim($val['description']),
    					'topic_image'			=> empty($val['topic_img']) ? '' : $val['topic_img']
    			);
    		}
    	}
    	
    	return array('data' => $list, 'pager' => $result['page']);
    }
}


// end