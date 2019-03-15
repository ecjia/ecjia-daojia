<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/3/10
 * Time: 03:12
 */

namespace Ecjia\App\Captcha\Enums;


use Royalcms\Component\Enum\Enum;

class CaptchaEnum extends Enum
{

    /* 验证码 */
    const CAPTCHA_REGISTER      = 1; //注册时使用验证码
    const CAPTCHA_LOGIN         = 2; //登录时使用验证码
    const CAPTCHA_COMMENT       = 4; //评论时使用验证码
    const CAPTCHA_ADMIN         = 8; //后台登录时使用验证码
    const CAPTCHA_LOGIN_FAIL    = 16; //登录失败后显示验证码
    const CAPTCHA_MESSAGE       = 32; //留言时使用验证码

    protected function __statusMap()
    {

        return [
            self::CAPTCHA_REGISTER      => __('注册时使用验证码', 'captcha'),
            self::CAPTCHA_LOGIN         => __('登录时使用验证码', 'captcha'),
            self::CAPTCHA_COMMENT       => __('评论时使用验证码', 'captcha'),
            self::CAPTCHA_ADMIN         => __('后台登录时使用验证码', 'captcha'),
            self::CAPTCHA_LOGIN_FAIL    => __('登录失败后显示验证码', 'captcha'),
            self::CAPTCHA_MESSAGE       => __('留言时使用验证码', 'captcha'),
        ];
    }
}