<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/5
 * Time: 10:03
 */

//hook扩展插件智能回复
RC_Hook::add_filter('wechat_command_empty_reply', function($data, $keyword, $WechatCommand) {

    $extend_handle = with(new \Ecjia\App\Platform\Plugin\PlatformPlugin)->channel('mp_daojia');

    if (is_ecjia_error($extend_handle)) {
        return null;
    }

    return $WechatCommand->commandHandler($extend_handle, null, $keyword);
}, 10 , 3);