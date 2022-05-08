<?php

namespace Ecjia\System\Admins\AdminPrivilege;

use Royalcms\Component\Foundation\RoyalcmsObject;

class AdminPrivilege extends RoyalcmsObject
{

    protected $action_list;

    /**
     * admin_priv constructor.
     * @param $action_list
     */
    public function __construct($action_list = null)
    {
        $this->action_list = $action_list ?: session('action_list');
    }


    /**
     * 判断管理员对某一个操作是否有权限。
     *
     * 根据当前对应的action_code，然后再和用户session里面的action_list做匹配，以此来决定是否可以继续执行。
     * @param string $priv_str 操作对应的priv_str
     * @return bool
     */
    public function isChecked($priv_str)
    {
        if ($this->action_list == 'all') {
            return true;
        }

        if (strpos(',' . $this->action_list . ',', ',' . $priv_str . ',') === false) {
            return false;
        } else {
            return true;
        }
    }

}