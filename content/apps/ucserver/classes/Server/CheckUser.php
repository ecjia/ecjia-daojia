<?php

namespace Ecjia\App\Ucserver\Server;

use Ecjia\App\Ucserver\Models\UserModel;

class CheckUser
{
    protected $user;
    
    public function __construct(UserModel $user)
    {
        $this->user = $user;
    }

    /**
     * 检查邮箱是否存在，支持排除用户名
     *
     * @param $email
     * @param string $username 排除用户名
     * @return int
     */
    public function checkEmail($email, $username = '') 
    {
        if (!$this->user->check_emailformat($email)) {
            return ApiBase::UC_USER_EMAIL_FORMAT_ILLEGAL;
        } elseif ($this->user->check_emailexists($email, $username)) {
            return ApiBase::UC_USER_EMAIL_EXISTS;
        } else {
            return 1;
        }
    }

    /**
     * 检查手机号是否存在，支持排除用户名
     *
     * @param string $mobile 手机号
     * @param string $username 排除用户名
     * @return int
     */
    public function checkMobile($mobile, $username = '')
    {
        if (! $this->user->checkMobielFormat($mobile)) {
            return ApiBase::UC_USER_MOBILE_FORMAT_ILLEGAL;
        } elseif ($this->user->checkMobileExists($mobile, $username)) {
            return ApiBase::UC_USER_MOBILE_EXISTS;
        } else {
            return 1;
        }
    }

    /**
     * 检查用户名是否存在
     *
     * @param $username
     * @return int
     */
    public function checkUserName($username) 
    {
        $username = addslashes(trim(stripslashes($username)));
        if (!$this->user->check_username($username)) {
            return ApiBase::UC_USER_CHECK_USERNAME_FAILED;
        } elseif ($this->user->check_usernameexists($username)) {
            return ApiBase::UC_USER_USERNAME_EXISTS;
        }

        return 1;
    }

    /**
     * 检测用户是否允许登录
     *
     * @param $username
     * @param string $ip
     * @return int|mixed
     */
    public function checkCanLogin($username, $ip = '')
    {
        return $this->user->canDoLogin($username, $ip);
    }



    
}