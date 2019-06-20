<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 专题详情内容
 * @author will.chen
 *
 */
class topic_topic_info_api extends Component_Event_Api
{
    /**
     * @param  array $options    条件参数
     * @return array|ecjia_error
     */
    public function call(&$options)
    {
        if (!is_array($options)
            || empty($options['topic_id'])) {
            return new ecjia_error('invalid_parameter', sprintf(__('请求接口%s参数无效', 'topic'), __CLASS__));
        }

        return $this->topic_info($options);
    }

    /**
     * 取得广告位列表
     * @param   array $options    条件参数
     * @return  array   文章列表
     */

    private function topic_info($options)
    {
        $db_topic           = RC_DB::table('topic');
       
        $db_topic->where('start_time', '<=', RC_Time::gmtime())->where('end_time', '>=', RC_Time::gmtime());

        $topic = $db_topic->where('topic_id', $options['topic_id'])->first();

        $topic['topic_cat_name'] = unserialize($topic['data']);
        
        if (is_object($topic['topic_cat_name'])) {
            $topic['topic_cat_name'] = (array) $topic['topic_cat_name'];
        }
        if (substr($topic['topic_img'], 0, 4) != 'http') {
        	$topic['topic_img'] = !empty($topic['topic_img']) ? RC_Upload::upload_url($topic['topic_img']) : '';
        }
        return $topic;
    }
}

// end
