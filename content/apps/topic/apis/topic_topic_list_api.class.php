<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 专题列表
 * @author will.chen
 *
 */
class topic_topic_list_api extends Component_Event_Api
{
    /**
     * @param  array $options    条件参数
     * @return array
     */
    public function call(&$options)
    {
    	if (!is_array($options)) 
    	{
    		return new ecjia_error('invalid_parameter', __('调用api文件topic_list_api参数无效！', 'topic'));
    	}
    	
        return $this->topic_list($options);
    }

    /**
     * 取得专题列表
     * @param   array $options    条件参数
     * @return  array   专题列表
     */

    private function topic_list($options)
    {
        $db_topic = RC_DB::table('topic');

        $filter                 = array();
        $filter['keywords']     = empty($options['keywords']) ? '' : trim($options['keywords']);
        
        $size    				= empty($options['size']) ? 15 : 	intval($options['size']);
        $page    				= empty($options['page']) ? 1 : 	intval($options['page']);

        if (!empty($filter['keywords'])) {
            $db_topic->where('title', 'like', '%' . $filter['keywords'] . '%');
        }
        
        $db_topic->where('start_time', '<=', RC_Time::gmtime())->where('end_time', '>=', RC_Time::gmtime());

        $count = $db_topic->count();
       	$page_row = new ecjia_page($count, $size, 6, '', $page);
       
       	$db_topic->take($size)->skip($page->start_id - 1);
       	
        $result = $db_topic->get();
        
        $pager = array(
				'total' => $page_row->total_records,
				'count' => $page_row->total_records,
				'more'	=> $page_row->total_pages <= $page ? 0 : 1,
		);

        return array('list' => $result, 'page' => $pager);
    }
}
// end
