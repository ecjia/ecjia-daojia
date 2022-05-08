<?php

namespace Ecjia\System\Admins\Users;

use Ecjia\System\Frameworks\Contracts\UserAllotPurview;
use RC_Hook;

class AdminUserMetaAllotPurview implements UserAllotPurview
{
    protected $model_class = 'Ecjia\System\Admins\Users\AdminUserModel';

    protected $userid;

    protected $meta_key     = 'admin_allot_purview';

    public function __construct($userid)
    {
        $this->userid = $userid;
        $this->model_class = RC_Hook::apply_filters('ecjia_admin_user_model', $this->model_class);
        $this->model = (new $this->model_class)->where('user_id', $userid)->first();
    }


    /**
     * 获取当前用户ID
     */
    public function getUserId()
    {
        return $this->userid;
    }


    /**
     * 保存权限值给指定用户
     * @param string $value
     */
    public function save($value)
    {
        $this->model->setMeta($this->meta_key, $value);
    }

    /**
     * 获取用户的权限值
     */
    public function get()
    {
        return $this->model->getMeta($this->meta_key);
    }


}