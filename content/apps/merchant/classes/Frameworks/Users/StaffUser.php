<?php

namespace Ecjia\App\Merchant\Frameworks\Users;

use Ecjia\System\Frameworks\Contracts\UserInterface;
use Ecjia\App\Merchant\Frameworks\Users\StaffUserDefaultAllotPurview;
use Royalcms\Component\Repository\Repositories\AbstractRepository;
use RC_Uri;
use RC_Upload;

class StaffUser extends AbstractRepository implements UserInterface
{
    
    protected $model = 'Ecjia\App\Merchant\Models\StaffUserModel';
    
    protected $user;
    
    /**
     * 
     * @var \Ecjia\App\Platform\Frameworks\Users\AdminUserAllotPurview
     */
    protected $purview;
    
    public function __construct($userid, $storeid, $purviewClass = null)
    {
        parent::__construct();
        
        $this->user = $this->findWhere(['user_id' => $userid, 'store_id' => $storeid])->first();
        
        if (is_string($purviewClass) && class_exists($purviewClass)) {
            $this->purview = new $purviewClass($userid, $storeid);
        }
        elseif (is_callable($purviewClass)) {
            $this->purview = $purviewClass($userid, $storeid);
        }
        elseif (is_null($purviewClass)) {
            $this->purview = new StaffUserDefaultAllotPurview($userid, $storeid);
        }
    }
    
    /**
     * 获取用户名
     */
    public function getUserName()
    {
        return $this->user->name;
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
        return 'merchant';
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
        return null;
    }
    
    /**
     * 获取用户的角色ID
     */
    public function getRoleId()
    {
        return $this->user->group_id;
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
        return str_replace('sites/platform/index.php', 'sites/merchant/index.php', RC_Uri::url('staff/privilege/logout'));
    }
    
    /**
     * 获取登录地址
     */
    public function getLoginUrl()
    {
        return str_replace('sites/platform/index.php', 'sites/merchant/index.php', RC_Uri::url('staff/privilege/login'));
    }
    
    /**
     * 获取个人设置地址
     */
    public function getProfileSettingUrl()
    {
        return str_replace('sites/platform/index.php', 'sites/merchant/index.php', RC_Uri::url('staff/mh_profile/init'));
    }
    
    /**
     * 获取个人头像地址
     */
    public function getAvatarUrl()
    {
        return RC_Upload::upload_url($this->user->avatar);
    }
    
    
}