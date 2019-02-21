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
namespace Ecjia\App\Connect\ConnectUser;

use Ecjia\App\Connect\UserGenerate;

class ConnectUser extends ConnectUserAbstract
{
    /**
     * 访问用户信息的token
     * @var
     */
    protected $access_token;

    /**
     * 刷新用户信息授权的token
     * @var
     */
    protected $refresh_token;

    /**
     * 第三方平台的个人资料信息
     * @var array
     */
    protected $profile = array();

    /**
     * 创建时间
     * @var
     */
    protected $create_at;

    /**
     * 有效时间
     * @var
     */
    protected $expires_in;

    /**
     * 到期时间戳
     * @var
     */
    protected $expires_at;

    /**
     * 用户操作对象
     * @var \integrate
     */
    protected $integrate;

    protected $user_type = self::USER;

    public function __construct($connect_code, $open_id)
    {
        parent::__construct($open_id, $this->user_type);

        $this->connect_code = $connect_code;
        $this->open_id      = $open_id;

        $this->buildUserInfo();
    }

    /**
     * 获取绑定的用户信息
     */
    protected function buildUserInfo($model = null)
    {
        if (is_null($model)) {
            $model = $this->checkOpenId();
        }

        if ($model) {
            $this->user_id          = $model->user_id;
            $this->connect_platform = $model->connect_platform;
            $this->union_id         = $model->union_id;
            $this->access_token     = $model->access_token;
            $this->refresh_token    = $model->refresh_token;
            $this->profile          = unserialize($model->profile) ? unserialize($model->profile) : array();
            $this->create_at        = $model->create_at;
            $this->expires_in       = $model->expires_in;
            $this->expires_at       = $model->expires_at;

            return true;
        } else {
            return false;
        }
    }

    /**
     * 检查当前connect_code用户是否绑定
     */
    public function checkUser()
    {
        if (!empty($this->user_id)) {
            return true;
        }
        return false;
    }

    /**
     * 检查openid是否存在于数据库记录中
     * @return \Ecjia\App\Connect\Models\ConnectUserModel|boolean
     */
    public function checkOpenId()
    {
        $model = $this->getUserModel();

        if (!empty($model)) {
            return $model;
        } else {
            return false;
        }
    }


    public function getAccessToken()
    {
        return $this->access_token;
    }

    public function getRefreshToken()
    {
        return $this->refresh_token;
    }

    public function getCreateAtTime()
    {
        return $this->create_at;
    }

    public function getExpiresInTime()
    {
        return $this->expires_in;
    }

    public function getExpiresAtTime()
    {
        return $this->expires_at;
    }

    public function getProfile()
    {
        return $this->profile;
    }

    public function createUser($user_id)
    {
        $model = parent::createUser($user_id);

        $this->buildUserInfo($model);

        return $model;
    }

    /**
     * 刷新ConnectUser对象属性
     */
    public function refreshConnectUser()
    {
        return $this->buildUserInfo();
    }

    /**
     * 绑定用户
     * @param integer $user_id
     * @return boolean
     */
    public function bindUser($user_id)
    {
        if (parent::bindUser($user_id)) {
            return $this->buildUserInfo();
        } else {
            return false;
        }
    }

    /**
     * 获取用户的profile
     * @return mixed
     */
    public function getConnectProfile()
    {
        return $this->profile;
    }


    protected static $userGenerateInstance;

    /**
     * Handle dynamic static method calls into the method.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $user_generate_method = [
            'getGenerateEmail',
            'getGeneratePassword',
            'getGenerateUserName',
            'getUserHeaderImg',
            'getUserName',
            'setUserName',
            'getIntegrateUser',
            'getConnectPlugin',
            'getPluginProfile',
        ];

        // Check for scope method and call
        if (in_array($method, $user_generate_method)) {

            if (is_null(self::$userGenerateInstance)) {
                self::$userGenerateInstance = new UserGenerate($this);
            }

            return call_user_func_array([self::$userGenerateInstance, $method], $parameters);
        }

        return parent::__call($method, $parameters);
    }

}

// end