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
namespace Ecjia\App\Connect;

use Royalcms\Component\Repository\Repositories\AbstractRepository;
use RC_Loader;
use RC_Time;
use RC_Hook;

class ConnectUser extends AbstractRepository
{
    /**
     * 用户类型定义
     * @var string
     */
    const USER      = 'user';
    const MERCHANT  = 'merchant';
    const ADMIN     = 'admin';
    
    /**
     * 数据模型
     * @var \Ecjia\App\Connect\Models\ConnectUserModel
     */
    protected $model = 'Ecjia\App\Connect\Models\ConnectUserModel';
    

    protected $connect_code;
    protected $open_id;
    protected $user_id;
    protected $user_type;
    protected $access_token;
    protected $profile = array();
    protected $create_at;
    protected $expires_in;
    protected $expires_at;
    protected $user_name;
    
    /**
     * 用户操作对象
     * @var \integrate
     */
    protected $integrate;
    
    public function __construct($connect_code, $open_id, $user_type = self::USER) {
        parent::__construct();
        
        $this->connect_code     = $connect_code;
        $this->open_id          = $open_id;
        $this->user_type        = $user_type;
        
        $this->buildUserInfo();
    }
    
    /**
     * 获取绑定的用户信息
     */
    protected function buildUserInfo()
    {
        if (($model = $this->checkOpenId()) !== false) {
            $this->user_id      = $model['user_id'];
            $this->access_token = $model['access_token'];
            $this->profile      = unserialize($model['profile']) ? unserialize($model['profile']) : array();
            $this->create_at    = $model['create_at'];
            $this->expires_in   = $model['expires_in'];
            $this->expires_at   = $model['expires_at'];
        }
    }

    /**
     * 创建用户操作对象
     */
    protected function cretateIntegrateUser()
    {
        RC_Loader::load_app_class('integrate', 'user', false);
        $this->integrate = \integrate::init_users();
    }
    
    public function getIntegrateUser()
    {
        if (is_null($this->integrate)) {
            $this->cretateIntegrateUser();
        }
        return $this->integrate;
    }
    
    public function setUserName($user_name)
    {
        $this->user_name = $user_name;
        
        return $this;
    }
    
    public function getUserName()
    {
        if ($this->user_name) {
            return $this->user_name;
        } else {
            return $this->getConnectPlugin()->get_username();
        }
    }
    
    public function getUserHeaderImg()
    {
        return $this->getConnectPlugin()->get_headerimg();
    }
    
    public function getOpenId()
    {
        return $this->open_id;
    }
    
    public function getConnectCode()
    {
        return $this->connect_code;
    }
    
    public function getConnectPlugin()
    {
        static $connects = array();
        if (array_get($connects, $this->connect_code)) {
            return array_get($connects, $this->connect_code);
        }
        
        $connects[$this->connect_code] = with(new ConnectPlugin())->channel($this->connect_code);
        $connects[$this->connect_code]->setProfile($this->getProfile());
        
        return $connects[$this->connect_code];
    }
    
    public function getUserId()
    {
        return $this->user_id;
    }
    
    public function getUserType()
    {
        return $this->user_type;
    }
    
    
    public function getAccessToken() 
    {
        return $this->access_token;
    }
    
    public function getProfile()
    {
        return $this->connectPluginHandleProfile($this->profile);
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
    
    
    protected function connectPluginHandleProfile($profile)
    {
        return $profile;
    }
    
    /**
     * 检查用户是否存在
     */
    public function checkUser() {
        if (!empty($this->user_id)) {
            return true;
        }
        return false;
    }
    
    /**
     * 检查openid是否存在于数据库记录中
     * @return \Royalcms\Component\Database\Eloquent\Model|boolean
     */
    public function checkOpenId() {
        $where = array(
            'open_id'       => $this->open_id,
            'connect_code'  => $this->connect_code,
            'user_type'     => $this->user_type
        );
        
        $row = $this->findWhere($where);
        
        if (!$row->isEmpty()) {
            $model = $row->first();
            return $model;
        } else {
            return false;
        }
    }
    
    public function saveOpenId($access_token, $refresh_token, $user_profile, $expires_time) {
        $curr_time = RC_Time::gmtime();
        if ($this->checkUser()) {
            $data = array(
                'create_at'     => $curr_time,
                'expires_in'    => $expires_time,
                'expires_at'    => $curr_time + $expires_time,
            );
            
            if ($access_token) {
                $data['access_token'] = $access_token;
            }
            
            if ($refresh_token) {
                $data['refresh_token'] = refresh_token;
            }
            
            if ($user_profile) {
                if (is_array($user_profile)) {
                    $user_profile = serialize($user_profile);
                }
                $data['profile'] = $user_profile;
            }
            
            $this->newQuery();
            $result = $this->query->where('open_id', $this->open_id)
                               ->where('connect_code', $this->connect_code)
                               ->where('user_type', $this->user_type)
                               ->update($data);
        } 
        elseif (($model = $this->checkOpenId()) !== false) {
            $data = array(
                'create_at'     => $curr_time,
                'expires_in'    => $expires_time,
                'expires_at'    => $curr_time + $expires_time,
                'user_type'     => $this->user_type,
            );
            
            if ($access_token) {
                $data['access_token'] = $access_token;
            }
            
            if ($refresh_token) {
                $data['refresh_token'] = refresh_token;
            }
            
            if ($user_profile) {
                if (is_array($user_profile)) {
                    $user_profile = serialize($user_profile);
                }
                $data['profile'] = $user_profile;
            }
            
            $result = $this->update($model, $data);
        }
        else {
            if (is_array($user_profile)) {
                $user_profile = serialize($user_profile);
            }
            
            $data = array(
                'connect_code'	=> $this->connect_code,
                'open_id'		=> $this->open_id,
                'access_token'	=> $access_token,
                'refresh_token' => $refresh_token,
                'profile'       => $user_profile,
                'create_at'     => $curr_time,
                'expires_in'    => $expires_time,
                'expires_at'    => $curr_time + $expires_time,
                'user_type'     => $this->user_type,
            );
            
            /**
             * 创建用户
             * 旧的handle废弃：connect_openid_exist_userid
             * 新的handle分为三个：connect_openid_create_user_userid, 
             *                  connect_openid_create_merchant_userid, 
             *                  connect_openid_create_admin_userid
             */ 
            $user_id = RC_Hook::apply_filters(sprintf("connect_openid_create_%s_userid", $this->user_type), 0, $this);
            if (!empty($user_id)) {
                $data['user_id']    = $user_id;
            }
            $result = $this->create($data);
        }
        
        if ($result) {
            $this->buildUserInfo();
        }
        
        return $result;
    }
    
    /**
     * 绑定用户
     * @param integer $user_id
     * @return boolean
     */
    public function bindUser($user_id) {
        if (!$this->checkUser() && $user_id && ($model = $this->checkOpenId()) !== false) {
            $data = array(
                'user_id' => $user_id,
            );
            $result = $this->update($model, $data);
            
            if ($result) {
                $this->buildUserInfo();
            }
            
            return $result;
        } else {
            return false;
        }
    }
    
    public function getGenerateUserName() {
        $username = $this->getUserName();
        
        if ($this->getIntegrateUser()->check_user($username)) {
            return $username . rc_random(4, 'abcdefghijklmnopqrstuvwxyz0123456789');
        } else {
            return $username;
        }
    }
    
    public function getGenerateEmail() {
        $connect_handle = $this->getConnectPlugin();
        $email = $connect_handle->get_email();
        
        if ($this->getIntegrateUser()->check_email($email)) {
            return 'a' . rc_random(2, 'abcdefghijklmnopqrstuvwxyz0123456789') . '_' . $email;
        } else {
            return $email;
        }
    }
    
    public function getGeneratePassword() {
        $connect_handle = $this->getConnectPlugin();
        $password = $connect_handle->get_password();
        
        return $password;
    }
     
}

// end