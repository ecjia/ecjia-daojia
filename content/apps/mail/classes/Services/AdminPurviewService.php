<?php
namespace Ecjia\App\Mail\Services;


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
//             array('action_name' => __('邮件订阅管理', 'mail'), 	'action_code' => 'email_list_manage', 'relevance' => ''),
//             array('action_name' => __('邮件订阅更新', 'mail'), 	'action_code' => 'email_list_update', 'relevance' => ''),
//             array('action_name' => __('邮件订阅删除', 'mail'),	'action_code' => 'email_list_delete', 'relevance' => ''),

//             array('action_name' => __('邮件队列管理', 'mail'), 	'action_code' => 'email_sendlist_manage',	'relevance' => ''),
//             array('action_name' => __('邮件队列发送', 'mail'), 	'action_code' => 'email_sendlist_send', 	'relevance' => ''),
//             array('action_name' => __('邮件队列删除', 'mail'), 	'action_code' => 'email_sendlist_delete',	'relevance' => ''),

            array('action_name' => __('邮件模板管理', 'mail'),    'action_code' => 'mail_template_manage', 'relevance' => ''),
            array('action_name' => __('邮件模板更新', 'mail'),    'action_code' => 'mail_template_update', 'relevance' => ''),

            array('action_name' => __('邮件服务器设置', 'mail'),   'action_code' => 'mail_settings_manage', 'relevance' => ''),
        );
        return $purviews;
    }
}

// end