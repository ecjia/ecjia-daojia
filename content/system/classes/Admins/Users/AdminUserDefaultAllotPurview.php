<?php

namespace Ecjia\System\Admins\Users;

use Ecjia\System\Frameworks\Contracts\UserAllotPurview;
use RC_DB;

class AdminUserDefaultAllotPurview implements UserAllotPurview
{
    
    protected $userid;
    
    public function __construct($userid)
    {
        $this->userid = $userid;
    }
    
    
    public function getUserId()
    {
        return $this->userid;
    }
    
    
    public function save($value)
    {
        return RC_DB::connection(config('ecjia.database_connection', 'default'))->table('admin_user')->where('user_id', $this->userid)->update(['action_list' => $value]);
    }
    
    
    public function get()
    {
        return RC_DB::connection(config('ecjia.database_connection', 'default'))->table('admin_user')->where('user_id', $this->userid)->pluck('action_list')->toArray();
    }
    
}