<?php

use Ecjia\App\Integrate\UserIntegrateAbstract;

defined('IN_ECJIA') or exit('No permission resources.');

/**
 * UCenter 会员数据处理类
 */
class ecjiauc extends UserIntegrateAbstract
{

    /* 是否需要同步数据到商城 */
    protected $need_sync = false;

    public function setConfig(array $config)
    {
        parent::setConfig($config);

        if (! empty($config['uc_key'])) {
            RC_Config::set('ucenter::ucenter.key', $config['uc_key']);
        }

        if (! empty($config['uc_url'])) {
            RC_Config::set('ucenter::ucenter.api', $config['uc_url']);
        }

        if (! empty($config['uc_charset'])) {
            RC_Config::set('ucenter::ucenter.charset', $config['uc_charset']);
        }

        if (! empty($config['uc_id'])) {
            RC_Config::set('ucenter::ucenter.appid', $config['uc_id']);
        }

        if (! empty($config['uc_ip'])) {
            RC_Config::set('ucenter::ucenter.ip', $config['uc_ip']);
        }

    }

    /**
     * 获取插件代号
     *
     * @see \Ecjia\System\Plugin\PluginInterface::getCode()
     */
    public function getCode()
    {
        return 'ecjiauc';
    }

    /**
     * 加载配置文件
     *
     * @see \Ecjia\System\Plugin\PluginInterface::loadConfig()
     */
    public function loadConfig($key = null, $default = null)
    {
        return $this->loadPluginData(RC_Plugin::plugin_dir_path(__FILE__) . 'config.php', $key, $default);
    }

    /**
     * 加载语言包
     *
     * @see \Ecjia\System\Plugin\PluginInterface::loadLanguage()
     */
    public function loadLanguage($key = null, $default = null)
    {
        $locale = RC_Config::get('system.locale');

        return $this->loadPluginData(RC_Plugin::plugin_dir_path(__FILE__) . '/languages/'.$locale.'/plugin.lang.php', $key, $default);
    }

    /**
     * 获取插件的元数据
     *
     * @return \Royalcms\Component\Support\Collection
     */
    public function getPluginMateData()
    {
        return collect([
            'integrate_id'      => 3,
            'integrate_code'    => $this->getCode(),
            'integrate_name'    => $this->loadLanguage('ecjiauc'),
            'integrate_desc'    => $this->loadLanguage('ecjiauc_desc'),
            'configure'         => null,
        ]);
    }

    /**
     *  获取指定用户的信息
     *
     * @param $username
     * @return array
     */
    public function getProfileByName($username)
    {
        $row = RC_DB::table('users')
            ->select('user_id', 'user_name', 'email', 'sex', 'birthday', 'reg_time', 'password', 'mobile_phone')
            ->where('user_name', $username)
            ->first();

        return $row;
    }


    /**
     *  获取指定用户的信息
     *
     * @param $id
     * @return array
     */
    public function getProfileById($id)
    {
        $row = RC_DB::table('users')
            ->select('user_id', 'user_name', 'email', 'sex', 'birthday', 'reg_time', 'password', 'mobile_phone')
            ->where('user_id', $id)
            ->first();

        return $row;
    }


    /**
     *  获取指定用户的信息
     *
     * @param $mobile
     * @return array
     */
    public function getProfileByMobile($mobile)
    {
        $row = RC_DB::table('users')
            ->select('user_id', 'user_name', 'email', 'sex', 'birthday', 'reg_time', 'password', 'mobile_phone')
            ->where('mobile_phone', $mobile)
            ->first();

        return $row;
    }


    /**
     *  用户登录函数
     *
     * @access  public
     * @param   string  $username
     * @param   string  $password
     *
     * @return boolean
     */
    public function login($username, $password, $remember = null)
    {
        /**
         * $username 这里的$username 是手机号
         */
		if (is_email($username)) {
            $count = RC_DB::table('users')->where('email', $username)->count();
			if ($count > 1) {

				$this->error = '邮箱有重复，请使用用户名登录！';

				return false;

			} else {
                $username = RC_DB::table('users')->select('user_name')->where('email', $username)->pluck('user_name');

				if (! $username) {
					$this->error = '邮箱或密码错误！';

					return false;	
				}
			}
		}

		$isuid = 6;

        list($uid, $uname, $pwd, $email, $repeat) = ecjia_uc_call("uc_user_login", array($username, $password, $isuid));
        $uname = addslashes($uname);

        if ($uid < 0) {
            //检查Ucenter用户是否存在,不存在如果本地有用户，直接添加用户到Ucenter
            //检查用户是否存在,不存在直接放入用户表
            $localUser = new \Ecjia\App\User\LocalUser();
            $user = $localUser->getProfileByMobile($username);
            if (empty($user)) {
                $local_user_id = 0;
            } else {
                $mobile = $user->mobile_phone;
                $uid = uc_call('uc_user_register', array($mobile, $password, $user->email));
                $local_user_id = $user->user_id;
            }
        }

        if ($uid > 0) {
            // 优先兼容 connect_user 表
            //检查用户是否存在, 不存在直接放入ConnectUser表
            $connect_user_id = ecjiauc_connect_user($uid, 'user')->getUserId();
            if (empty($connect_user_id)) {
                if (empty($local_user_id)) {
                    // 首次登录或其他应用用户
                    $localUser = new \Ecjia\App\User\LocalUser();
                    $userModel = $localUser->createWithMobile($username);
                    $local_user_id = $userModel->user_id;

                    ecjiauc_connect_user($uid, 'user')->bindUser($local_user_id);
                } else {
                    ecjiauc_connect_user($uid, 'user')->createUser($local_user_id);
                }
            }

            $this->setSession($uname);
            $this->setCookie($uname);
            $this->ucdata = ecjia_uc_call('uc_user_synlogin', array($uid));

            return true;
        } elseif($uid == -1) {
            $this->error = self::ERR_INVALID_USERNAME;
            return false;
        } elseif ($uid == -2) {
            $this->error = self::ERR_INVALID_PASSWORD;
            return false;
        } else {
            return false;
        }
    }

    /**
     * 用户退出
     *
     * @return bool
     */
    public function logout()
    {
        $this->setCookie();  //清除cookie
        $this->setSession(); //清除session
        $this->ucdata = ecjia_uc_call('uc_user_synlogout');   //同步退出
        return true;
    }

    /**
     * 添加用户
     *
     * @param string $username
     * @param string $password
     * @param string $email
     * @param string $mobile
     * @param int $gender
     * @param int $bday
     * @param int $reg_date
     * @param string $md5password
     * @return bool
     */
    public function addUser($username, $password, $email, $mobile = null, $gender = -1, $bday = null, $reg_date = 0, $md5password = null)
    {
        /* 检测手机号 */
        if (is_null($mobile)) {
            $this->error = self::ERR_INVALID_MOBILE;
            return false;
        }

        if ($this->checkMobile($mobile)) {
            $this->error = self::ERR_MOBILE_EXISTS;
            return false;
        }

        $uid = uc_call('uc_user_register', array($mobile, $password, $email));
        if ($uid <= 0) {
            if($uid == -1) {
                $this->error = self::ERR_INVALID_USERNAME;
                return false;
            } elseif($uid == -2) {
                $this->error = self::ERR_USERNAME_NOT_ALLOW;
                return false;
            } elseif($uid == -3) {
                $this->error = self::ERR_USERNAME_EXISTS;
                return false;
            } elseif($uid == -4) {
                $this->error = self::ERR_INVALID_EMAIL;
                return false;
            } elseif($uid == -5) {
                $this->error = self::ERR_EMAIL_NOT_ALLOW;
                return false;
            } elseif($uid == -6) {
                $this->error = self::ERR_EMAIL_EXISTS;
                return false;
            } else {
                return false;
            }
        } else {
            //注册成功，插入用户表
            $ip = RC_Ip::client_ip();
            $password = $this->compilePassword($password);
            $data = array(
            	'user_id'      => $uid,
                'email'        => $email,
                'mobile_phone' => $mobile,
                'user_name'    => $username,
                'password'     => $password,
                'sex'          => $gender,
                'birthday'     => $bday,
                'reg_time'     => $reg_date,
                'last_ip'      => $ip
            );
            $user_id = RC_DB::table('users')->insertGetId($data);

            ecjiauc_connect_user($uid, 'user')->createUser($user_id);

            return true;
        }
    }

    /**
     *  检查指定用户是否存在及密码是否正确
     *
     * @param   string  $username   用户名
     * @return  int
     */
    public function checkUser($username, $password = null)
    {
        $userdata = ecjia_uc_call('uc_user_checkname', array($username));
        if ($userdata == 1) {
            return false;
        } else {
            return  true;
        }
    }

    /**
     * 检测Email是否合法
     *
     * @param   string  $email   邮箱
     * @return  boolean
     */
    public function checkEmail($email, $exclude_username = null)
    {
        if (! empty($email)) {
            $email_exist = ecjia_uc_call('uc_user_checkemail', array($email));
            if ($email_exist == 1) {
                return false;
            } else {
                $this->error = self::ERR_EMAIL_EXISTS;
                return true;
            }
        }
        return true;
    }

    /**
     * 检测手机号是否合法
     *
     * @param   string  $mobile  手机号
     * @return  boolean
     */
    public function checkMobile($mobile, $exclude_username = null)
    {
        if (! empty($mobile)) {
            $mobile_exist = ecjia_uc_call('uc_user_checkmobile', array($mobile));
            if ($mobile_exist == 1) {
                return false;
            } else {
                $this->error = self::ERR_MOBILE_EXISTS;
                return true;
            }
        }
        return true;
    }

    /**
     * 编辑用户信息
     *
     * @param $username
     * @param null $password
     * @param null $old_password
     * @param $email
     * @param int $gender
     * @param int $bday
     * @param null $md5_password
     * @param null $forget_pwd
     * @return bool
     */
    public function editUser($params)
    {
        $username       = array_get($params, 'username');
        $password       = array_get($params, 'password');
        $oldpassword    = array_get($params, 'old_password');
        $email          = array_get($params, 'email');
        $gender         = array_get($params, 'gender', '-1');
        $bday           = array_get($params, 'birthday', '0');
        $md5password    = array_get($params, 'md5_password');
        $forget_pwd     = array_get($params, 'forget_pwd');

        $real_username = $username;
        $username = addslashes($username);
        $data = array(
            'email'     => $email,
            'sex'       => $gender,
            'birthday'  => $bday,
        );

        $flag  = false;

        if (!empty($data)) {
            RC_DB::table('users')->where('user_name', $username)->update($data);
            $flag  = true;
        }

        if (!empty($email)) {
            $ucresult = ecjia_uc_call("uc_user_edit", array($username, '', '', $email, 1));
            if ($ucresult > 0 ) {
                $flag = true;
            } elseif($ucresult == -4) {
                //echo 'Email 格式有误';
                $this->error = self::ERR_INVALID_EMAIL;
                return false;
            } elseif($ucresult == -5) {
                //echo 'Email 不允许注册';
                $this->error = self::ERR_INVALID_EMAIL;
                return false;
            } elseif($ucresult == -6) {
                //echo '该 Email 已经被注册';
                $this->error = self::ERR_EMAIL_EXISTS;
                return false;
            } elseif ($ucresult < 0 ) {
                return false;
            }
        }
        
        if (!empty($oldpassword) && !empty($password) && $forget_pwd == 0) {
            $ucresult = ecjia_uc_call("uc_user_edit", array($real_username, $oldpassword, $password, null));
            if ($ucresult > 0 ) {
                return true;
            } else {
                $this->error = self::ERR_INVALID_PASSWORD;
                return false;
            }
        } elseif (!empty($password) && $forget_pwd == 1) {
            $ucresult = ecjia_uc_call("uc_user_edit", array($real_username, '', $password, '', 1));
            if ($ucresult > 0 ) {
                $flag = true;
            }
        }

        return $flag;
    }


    /**
     * 检查cookie是正确，返回用户名
     *
     * @return
     */
    public function checkCookie()
    {
        return '';
    }

    /**
     * 根据登录状态设置cookie
     *
     * @return bool
     */
    public function getCookie()
    {
        $id = $this->checkCookie();
        if ($id) {
            $this->setSession($id);
            return true;
        } else {
            return false;
        }
    }


    /**
     * 删除用户
     *
     * @param $username
     */
    public function removeUser($username)
    {
        //仅删除本地用户，不删除UCenter用户
        $this->syncRemoveUser($username);

        return true;
    }

}

// end