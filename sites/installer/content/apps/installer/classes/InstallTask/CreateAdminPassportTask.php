<?php

namespace Ecjia\App\Installer\InstallTask;

use ecjia_error;
use RC_DB;
use RC_Time;
use Royalcms\Component\Database\QueryException;

class CreateAdminPassportTask
{

    /**
     * @param $admin_name
     * @param $admin_password
     * @param $admin_email
     * @return bool|ecjia_error
     */
    public function __invoke($admin_name, $admin_password, $admin_email)
    {
        try {
            $data = array(
                'user_name'     => $admin_name,
                'email'         => $admin_email,
                'password'      => md5($admin_password),
                'add_time'      => RC_Time::gmtime(),
                'action_list'   => 'all',
                'nav_list'      => ''
            );

            //清空数据表
            RC_DB::table('admin_user')->truncate();
            return RC_DB::table('admin_user')->insert($data);
        } catch (QueryException $e) {
            return new ecjia_error('create_passport_failed', sprintf(__('创建管理员帐号失败【%s】', 'installer'), $e->getMessage()));
        }
    }

}