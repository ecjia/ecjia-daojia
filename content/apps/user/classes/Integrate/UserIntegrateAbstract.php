<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
namespace Ecjia\App\User\Integrate;

use Ecjia\System\Plugin\AbstractPlugin;
use RC_DB;
use RC_Api;
use RC_Session;
use RC_Ip;

/**
 * 会员融合插件抽象类
 *
 * Class IntegrateAbstract
 * @package Ecjia\App\User\Integrate
 */
abstract class UserIntegrateAbstract extends AbstractPlugin implements UserIntegrateInterface
{

    /**
     * 用户名已经存在
     */
    const ERR_USERNAME_EXISTS       = 1;

    /**
     * Email已经存在
     */
    const ERR_EMAIL_EXISTS          = 2;

    /**
     * 无效的user_id
     */
    const ERR_INVALID_USERID        = 3;

    /**
     * 无效的用户名
     */
    const ERR_INVALID_USERNAME      = 4;

    /**
     * 密码错误
     */
    const ERR_INVALID_PASSWORD      = 5;

    /**
     * Email错误
     */
    const ERR_INVALID_EMAIL         = 6;

    /**
     * 用户名不允许注册
     */
    const ERR_USERNAME_NOT_ALLOW    = 7;

    /**
     * EMAIL不允许注册
     */
    const ERR_EMAIL_NOT_ALLOW       = 8;


    protected $error_message = [
        self::ERR_USERNAME_EXISTS         => '用户名已经存在',
        self::ERR_EMAIL_EXISTS            => 'Email已经存在',
        self::ERR_INVALID_USERID          => '无效的user_id',
        self::ERR_INVALID_USERNAME        => '无效的用户名',
        self::ERR_INVALID_PASSWORD        => '密码错误',
        self::ERR_INVALID_EMAIL           => 'Email错误',
        self::ERR_USERNAME_NOT_ALLOW      => '用户名不允许注册',
        self::ERR_EMAIL_NOT_ALLOW         => 'Email不允许注册',
    ];


    protected $cookie_domain;

    protected $cookie_path;

    /* 是否需要同步数据到商城 */
    protected $need_sync = true;

    protected $error = 0;


    public function getError()
    {
        return $this->error;
    }

    public function getErrorMessage()
    {
        return array_get($this->error_message, $this->error, '未知错误');
    }

    public function needSync()
    {
        return $this->need_sync;
    }

    /**
     * 获取插件的元数据
     *
     * @return \Royalcms\Component\Support\Collection
     */
    abstract public function getPluginMateData();

    /**
     *  获取指定用户的信息
     *
     * @param $username
     * @return array
     */
    abstract public function getProfileByName($username);


    /**
     *  获取指定用户的信息
     *
     * @param $id
     * @return array
     */
    abstract public function getProfileById($id);


    /**
     * 编译密码函数 包含参数为 $password, $md5password, $salt, $type
     *
     * @param $password
     * @param $md5password
     * @param null $salt
     * @param null $type
     * @return mixed
     */
    public function compilePassword($password, $md5password = null, $salt = null, $type = Password::PWD_MD5)
    {
        $password = with(new Password())->compilePassword($password, $md5password, $salt, $type);

        return $password;
    }

    /**
     * @param $username
     * @return array
     */
    public function getUserInfo($username)
    {
        return $this->getProfileByName($username);
    }


    /**
     *  获取论坛有效积分及单位
     *
     * @access  public
     * @param
     *
     * @return array
     */
    public function getPointsName()
    {
        return array();
    }

    /**
     * 同步删除用户
     *
     * @param $username
     */
    public function syncRemoveUser($username)
    {
        $user_id = RC_DB::table('users')->where('user_name', $username)->pluck('user_id');

        if ($user_id) {

            $result = $this->userRemoveClearData($user_id);
            if ($result) {
                //将删除用户的下级的parent_id 改为0
                RC_DB::table('users')->where('parent_id', $user_id)->update(['parent_id' => 0]);

                //删除用户
                RC_DB::table('users')->where('user_id', $user_id)->delete();

            }

        }
    }

    /**
     * 会员同步
     * 使用第三方用户数据表同步时，将用户信息同步一份到ecjia_users数据表中
     *
     * @param string $username
     * @param null $password
     * @param null $md5password
     * @return bool
     */
    public function sync($username, $password = null, $md5password = null)
    {

        if ((!empty($password)) && empty($md5password)) {
            $md5password = md5($password);
        }

        $main_profile = $this->getProfileByName($username);
        if (empty($main_profile)) {
            return false;
        }

        $profile = RC_DB::table('users')
            ->select('user_name', 'email', 'password', 'sex', 'birthday')
            ->where('user_name', $username)
            ->first();

        if (empty($profile)) {
            /* 向用户表插入一条新记录 */
            if (empty($md5password)) {
                $data = array(
                    'user_name'  => $username,
                    'email'      => $main_profile['email'],
                    'sex'        => $main_profile['sex'],
                    'birthday'   => $main_profile['birthday'] ,
                    'reg_time'   => $main_profile['reg_time'],
                );
                RC_DB::table('users')->insert($data);
            } else {
                $data = array(
                    'user_name'  => $username,
                    'email'      => $main_profile['email'],
                    'sex'        => $main_profile['sex'],
                    'birthday'   => $main_profile['birthday'] ,
                    'reg_time'   => $main_profile['reg_time'],
                    'password'   => $md5password
                );
                RC_DB::table('users')->insert($data);
            }
            return true;
        } else {
            $values = array();
            if ($main_profile['email'] != $profile['email']) {
                $values['email'] = $main_profile['email'];
            }

            if ($main_profile['sex'] != $profile['sex']) {
                $values['sex'] = $main_profile['sex'];
            }

            if ($main_profile['birthday'] != $profile['birthday']) {
                $values['birthday'] = $main_profile['birthday'];
            }

            if ((!empty($md5password)) && ($md5password != $profile['password'])) {
                $values['password'] = $md5password;
            }

            if (empty($values)) {
                return true;
            } else {
                RC_DB::table('users')->where('user_name', $username)->update($values);
                return true;
            }
        }
    }

    /**
     * 删除用户时，清除用户数据
     *
     * @param $user_id
     * @return mixed
     */
    protected function userRemoveClearData($user_id)
    {
        //删除用户订单
        //删除会员收藏商品
        //删除用户留言
        //删除用户地址
        //删除用户红包
        //删除用户帐号金额
        //删除用户标记
        //删除用户帐户日志
        //删除用户关联帐号连接

        return RC_Api::apis('user_remove_cleardata', array('user_id' => $user_id));
    }

    /**
     *  用户登录函数
     *
     * @param   string  $username
     * @param   string  $password
     *
     * @return boolean
     */
    public function login($username, $password, $remember = null)
    {
        if ($this->checkUser($username, $password) > 0) {
            if ($this->need_sync) {
                $this->sync($username, $password);
            }
            $this->setSession($username);
            $this->setCookie($username, $remember);
        
            return true;
        } else {
            return false;
        }
        
    }
    
    
    /**
     *
     * 用户退出登录
     * 
     * @return void
     */
    public function logout()
    {
        //清除cookie
        $this->clearCookie(); 
        
        //清除session
        $this->clearSession(); 
    }

    /**
     * 检查cookie是正确，返回用户名
     *
     * @return boolean
     */
    public function checkCookie()
    {
        return null;
    }

    /**
     *  设置cookie
     *
     * @return void
     */
    public function setCookie($username, $remember = null)
    {
        if (empty($username)) {
            /* 摧毁cookie */
            $time = SYS_TIME - 3600;
            setcookie("ECJIA[user_id]",  '', $time, $this->cookie_path);
            setcookie("ECJIA[password]", '', $time, $this->cookie_path);

        } elseif ($remember) {
            /* 设置cookie */
            $time = SYS_TIME + 3600 * 24 * 15;
            setcookie("ECJIA[username]", $username, $time, $this->cookie_path, $this->cookie_domain);

            $row = RC_DB::table('users')->select('user_id', 'password')->where('user_name', $username)->first();
            if ($row) {
                setcookie("ECJIA[user_id]", $row['user_id'], $time, $this->cookie_path, $this->cookie_domain);
                setcookie("ECJIA[password]", $row['password'], $time, $this->cookie_path, $this->cookie_domain);
            }
        }
    }

    /**
     * 根据登录状态设置cookie
     *
     * @return boolean
     */
    public function getCookie()
    {
        $username = $this->checkCookie();
        if ($username) {
            if ($this->need_sync) {
                $this->sync($username);
            }
            $this->setSession($username);
            return true;
        } else {
            return false;
        }
    }

    
    public function clearCookie()
    {
        
    }

    /**
     *  设置指定用户SESSION
     *
     * @access  public
     *
     * @return void
     */
    public function setSession($username = null)
    {
        if (empty($username)) {

            RC_Session::destroy();

        } else {
            $row = RC_DB::table('users')->select('user_id', 'password', 'email')->where('user_name', $username)->first();
            if ($row) {
                RC_Session::set('user_id', $row['user_id']);
                RC_Session::set('user_name', $username);
                RC_Session::set('session_user_id', $row['user_id']);
                RC_Session::set('session_user_type', 'user');
                RC_Session::set('email', $row['email']);
                RC_Session::set('ip', RC_Ip::client_ip());
            }
        }
    }
    
    public function clearSession()
    {
        
    }
    
    
    
}