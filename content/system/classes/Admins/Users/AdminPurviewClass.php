<?php


namespace Ecjia\System\Admins\Users;


use Ecjia\System\Frameworks\Contracts\UserAllotPurview;
use RC_Hook;

class AdminPurviewClass
{

    protected $pruview_class;

    protected $user_id;

    /**
     * AdminPruviewClass constructor.
     * @param $pruview_class
     */
    public function __construct($user_id, $pruview_class = null)
    {
        $this->user_id = $user_id;
        $this->pruview_class = $pruview_class;
    }

    /**
     * @return UserAllotPurview
     */
    public function getPurviewInstance()
    {
        if (is_string($this->pruview_class) && class_exists($this->pruview_class)) {
            $this->purview = new $this->pruview_class($this->user_id);
        }
        elseif (is_callable($this->pruview_class)) {
            $this->purview = ($this->pruview_class)($this->user_id);
        }
        elseif (is_null($this->pruview_class)) {
            $pruviewClass = config('ecjia.admin_user_purview', '\Ecjia\System\Admins\Users\AdminUserDefaultAllotPurview');
            $this->purview = new $pruviewClass($this->user_id);
        }

        $this->purview = RC_Hook::apply_filters('ecjia_admin_user_allot_purview_handle', $this->purview);

        return $this->purview;
    }

    public function getPurviewClass()
    {
        return $this->pruview_class;
    }



}