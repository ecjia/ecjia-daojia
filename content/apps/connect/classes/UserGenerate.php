<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/14
 * Time: 11:07
 */

namespace Ecjia\App\Connect;

use ecjia_integrate;
use Ecjia\App\Connect\ConnectUser\ConnectUserAbstract;

class UserGenerate
{

    /**
     * 用户操作对象
     * @var \Ecjia\App\Integrate\UserIntegrate
     */
    protected $integrate;

    protected $user_name;

    protected $connect_user;
    protected $connect_code;

    public function __construct(ConnectUserAbstract $connect_user)
    {
        $this->connect_user = $connect_user;
        $this->connect_code = $connect_user->getConnectCode();
    }

    public function getConnectPlugin()
    {
        static $connects = array();
        if (array_get($connects, $this->connect_code)) {
            return array_get($connects, $this->connect_code);
        }

        $connects[$this->connect_code] = with(new ConnectPlugin())->channel($this->connect_code);
        $connects[$this->connect_code]->setProfile($this->getPluginProfile());

        return $connects[$this->connect_code];
    }

    public function getPluginProfile()
    {
        return $this->connectPluginHandleProfile($this->connect_user->getConnectProfile());
    }

    protected function connectPluginHandleProfile($profile)
    {
        return $profile;
    }

    /**
     * 创建会员整合操作对象
     * @return \Ecjia\App\Integrate\UserIntegrate
     */
    protected function cretateIntegrateUser()
    {
        $this->integrate = ecjia_integrate::init_users();

        return $this->integrate;
    }

    /**
     * 获取会员整合操作对象
     * @return \Ecjia\App\Integrate\UserIntegrate
     */
    public function getIntegrateUser()
    {
        if (is_null($this->integrate)) {
            $this->cretateIntegrateUser();
        }
        return $this->integrate;
    }

    /**
     * 设置用户名
     * @param $user_name
     * @return $this
     */
    public function setUserName($user_name)
    {
        $this->user_name = $user_name;

        return $this;
    }

    /**
     * 获取用户名
     * @return string
     */
    public function getUserName()
    {
        if ($this->user_name) {
            $username = $this->user_name;
        } else {
            $username = $this->getConnectPlugin()->get_username();
        }

        //ecjia_log_debug('ConnectPlugin getConnectProfile', $this->connect_user->getConnectProfile());
        //ecjia_log_debug('ConnectPlugin getUserName', (array)$username);

        return $this->filterUserName($username);
    }

    /**
     * 获取用户头像
     * @return string
     */
    public function getUserHeaderImg()
    {
        return $this->getConnectPlugin()->get_headerimg();
    }

    /**
     * 过滤用户呢称中的非法字符
     * @param string $username
     * @return string
     */
    public function filterUserName($username)
    {
        $username = \RC_Format::filterEmoji($username);
        $username = safe_replace($username);
        return $username;
    }


    /**
     * 生成用户名
     * @return string
     */
    public function getGenerateUserName()
    {
        $username = $this->getUserName();

        if ($this->getIntegrateUser()->checkUser($username)) {
            return $username . rc_random(4, 'abcdefghijklmnopqrstuvwxyz0123456789');
        } else {
            return $username;
        }
    }

    /**
     * 生成邮箱
     * @return string
     */
    public function getGenerateEmail()
    {
        $connect_handle = $this->getConnectPlugin();
        $email = $connect_handle->get_email();

        if ($this->getIntegrateUser()->checkEmail($email)) {
            return 'a' . rc_random(2, 'abcdefghijklmnopqrstuvwxyz0123456789') . '_' . $email;
        } else {
            return $email;
        }
    }

    /**
     * 生成密码
     * @return mixed
     */
    public function getGeneratePassword()
    {
        $connect_handle = $this->getConnectPlugin();
        $password = $connect_handle->get_password();

        return $password;
    }


}