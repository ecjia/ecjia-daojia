<?php


namespace Ecjia\System\Events;


use Ecjia\System\Admins\Users\AdminUserModel;

class AdminUserForgetPasswordEvent
{

    /**
     * 管理员用户模型
     * @var AdminUserModel
     */
    public $admin_model;

    /**
     * AdminUserForgetPasswordEvent constructor.
     * @param AdminUserModel $admin_model
     */
    public function __construct($admin_model)
    {
        $this->admin_model = $admin_model;
    }


}