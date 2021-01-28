<?php
namespace Ecjia\App\Maintain\Services;


/**
 * 后台权限API
 * @author royalwang
 *
 */
class AdminPurviewService
{
    /**
     * @param $options
     * @return array
     */
    public function handle(& $options)
    {
         $purviews = array(
             array('action_name' => __('运维工具管理', 'maintain'), 'action_code' => 'maintain_manage', 'relevance' => ''),
         	 array('action_name' => __('日志查看管理', 'maintain'), 'action_code' => 'logviewer_manage', 'relevance' => ''),
        );
        return $purviews;
    }
}

// end