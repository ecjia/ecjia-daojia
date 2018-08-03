<?php

namespace Ecjia\App\Merchant\Frameworks\Users;

use Ecjia\System\Frameworks\Contracts\UserAllotPurview;
use RC_DB;

class StaffUserDefaultAllotPurview implements UserAllotPurview
{
    
    protected $userid;
    
    protected $storeid;
    
    public function __construct($userid, $storeid = null)
    {
        $this->userid = $userid;
        
        $this->storeid = $storeid;
    }
    
    
    public function getUserId()
    {
        return $this->userid;
    }
    
    
    public function save($value)
    {
        return RC_DB::table('staff_user')->where('store_id', $this->storeid)->where('user_id', $this->userid)->update(['action_list' => $value]);
    }
    
    
    public function get()
    {
        return RC_DB::table('staff_user')->where('store_id', $this->storeid)->where('user_id', $this->userid)->pluck('action_list');
    }
    
}