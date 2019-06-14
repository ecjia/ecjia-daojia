<?php

namespace Ecjia\System\Admins\Users;

use Ecjia\System\Frameworks\Contracts\UserInterface;
use Royalcms\Component\Repository\Repositories\AbstractRepository;
use RC_Hook;
use RC_Uri;

class AdminUser extends AbstractRepository implements UserInterface
{
    
    protected $model = 'Ecjia\System\Admins\Users\AdminUserModel';
    
    protected $user;
    
    /**
     * 
     * @var \Ecjia\System\Frameworks\Contracts\UserAllotPurview
     */
    protected $purview;
    
    public function __construct($userid, $purviewClass = null)
    {
        parent::__construct();
        
        $this->user = $this->find($userid);
        
        if (is_string($purviewClass) && class_exists($purviewClass)) {
            $this->purview = new $purviewClass($userid);
        }
        elseif (is_callable($purviewClass)) {
            $this->purview = $purviewClass($userid);
        }
        elseif (is_null($purviewClass)) {
            $pruviewClass = config('ecjia.admin_user_purview', '\Ecjia\System\Admins\Users\AdminUserDefaultAllotPurview');
            $this->purview = new $pruviewClass($userid);
        }
        
        $this->purview = RC_Hook::apply_filters('ecjia_admin_user_allot_purview_handle', $this->purview);
    }
    
    /**
     * 获取用户名
     */
    public function getUserName()
    {
        return $this->user->user_name;
    }
    
    /**
     * 获取用户ID
     */
    public function getUserId()
    {
        return $this->user->user_id;
    }
    
    /**
     * 获取用户的类型
     */
    public function getUserType()
    {
        return 'admin';
    }
    
    /**
     * 获取用户邮箱
     */
    public function getEmail()
    {
        return $this->user->email;
    }
    
    /**
     * 获取用户最后一次登录时间
     */
    public function getLastLogin()
    {
        return $this->user->last_login;
    }
    
    /**
     * 获取用户最后一次登录IP
     */
    public function getLastIp()
    {
        return $this->user->last_ip;
    }
    
    /**
     * 获取用户权限列表
     */
    public function getActionList()
    {
        return $this->purview->get();
    }
    
    /**
     * 设置用户公众平台权限
     * @param string $purview
     * @return boolean
     */
    public function setActionList($purview)
    {
        return $this->purview->save($purview);
    }
    
    
    /**
     * 获取用户设置的语言类型
     */
    public function getLangType()
    {
        return $this->user->lang_type;
    }
    
    /**
     * 获取用户的角色ID
     */
    public function getRoleId()
    {
        return $this->user->role_id;
    }
    
    /**
     * 获取用户的类型
     */
    public function getAddTime()
    {
        return $this->user->add_time;
    }
    
    /**
     * 获取退出登录地址
     */
    public function getLogoutUrl()
    {
        return str_replace('sites/platform/index.php', 'index.php', RC_Uri::url('@privilege/logout'));
    }
    
    /**
     * 获取登录地址
     */
    public function getLoginUrl()
    {
        return str_replace('sites/platform/index.php', 'index.php', RC_Uri::url('@privilege/login'));
    }
    
    /**
     * 获取个人设置地址
     */
    public function getProfileSettingUrl()
    {
        return str_replace('sites/platform/index.php', 'index.php', RC_Uri::url('@privilege/modif'));
    }
    
    /**
     * 获取个人头像地址
     */
    public function getAvatarUrl($default = null)
    {
        if (is_null($default)) {
            $avatar = RC_Uri::system_static_url('images/user_avatar.png');
        } else {
            $avatar = $default;
        }

        return $avatar;
    }
    
}