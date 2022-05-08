<?php

namespace Ecjia\System\AdminPanel\Services;


/**
 * 后台权限API
 * @author royalwang
 *
 */
class SystemPurviewService
{
    /**
     * @param $options
     * @return array
     */
    public function handle($options)
    {
        $purviews = array(
            array('action_name' => __('授权证书'), 'action_code' => 'shop_authorized', 'relevance' => ''),
            array('action_name' => __('更新缓存'), 'action_code' => 'admin_cache', 'relevance' => ''),

            array('action_name' => __('应用管理'), 'action_code' => 'application_manage', 'relevance' => ''),
            array('action_name' => __('卸载应用'), 'action_code' => 'application_uninstall', 'relevance' => ''),
            array('action_name' => __('安装应用'), 'action_code' => 'application_install', 'relevance' => ''),

            array('action_name' => __('插件管理'), 'action_code' => 'plugin_manage', 'relevance' => ''),
            array('action_name' => __('卸载插件'), 'action_code' => 'plugin_uninstall', 'relevance' => ''),
            array('action_name' => __('安装插件'), 'action_code' => 'plugin_install', 'relevance' => ''),

            array('action_name' => __('文件校验'), 'action_code' => 'file_check', 'relevance' => ''),
            array('action_name' => __('文件权限检验'), 'action_code' => 'file_priv', 'relevance' => ''),

            array('action_name' => __('角色管理'), 'action_code' => 'role_manage', 'relevance' => ''),
            array('action_name' => __('分派权限'), 'action_code' => 'allot_priv', 'relevance' => 'admin_manage'),
            array('action_name' => __('管理员添加/编辑'), 'action_code' => 'admin_manage', 'relevance' => ''),
            array('action_name' => __('删除管理员'), 'action_code' => 'admin_drop', 'relevance' => 'admin_manage'),

            array('action_name' => __('管理日志列表'), 'action_code' => 'logs_manage', 'relevance' => ''),
            array('action_name' => __('删除管理日志'), 'action_code' => 'logs_drop', 'relevance' => 'logs_manage'),
            array('action_name' => __('会话管理'), 'action_code' => 'session_manage', 'relevance' => ''),
            array('action_name' => __('删除会话记录'), 'action_code' => 'session_drop', 'relevance' => 'session_manage'),
            array('action_name' => __('登录日志列表'), 'action_code' => 'session_login_manage', 'relevance' => ''),
            array('action_name' => __('删除登录日志'), 'action_code' => 'session_login_drop', 'relevance' => 'session_login_manage'),

        );

        return $purviews;
    }
}

// end