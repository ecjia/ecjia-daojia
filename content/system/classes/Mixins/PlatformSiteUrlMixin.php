<?php


namespace Ecjia\System\Mixins;


use RC_Uri;

class PlatformSiteUrlMixin
{

    /**
     * 获取退出登录地址
     */
    public function getLogoutUrl()
    {
        return function () {
            return str_replace('sites/platform/index.php', 'index.php', RC_Uri::url('@privilege/logout'));
        };
    }

    /**
     * 获取登录地址
     */
    public function getLoginUrl()
    {
        return function () {
            return str_replace('sites/platform/index.php', 'index.php', RC_Uri::url('@privilege/login'));
        };
    }

    /**
     * 获取个人设置地址
     */
    public function getProfileSettingUrl()
    {
        return function () {
            return str_replace('sites/platform/index.php', 'index.php', RC_Uri::url('@privilege/modif'));
        };
    }

    /**
     * 获取个人头像地址
     */
    public function getAvatarUrl()
    {
        return function ($default = null) {
            if (is_null($default)) {
                $avatar = RC_Uri::system_static_url('images/user_avatar.png');
            } else {
                $avatar = $default;
            }

            return $avatar;
        };
    }

}