<?php

namespace Ecjia\System\Admins\Users;

use Ecjia\System\Frameworks\Meta\MetaAbstract;
use Ecjia\System\Frameworks\Contracts\UserAllotPurview;

class AdminUserAllotPurview extends MetaAbstract implements UserAllotPurview
{
    
    protected $meta_key     = 'admin_allot_purview';
    
    protected $object_type  = 'ecjia.system';
    
    protected $object_group = 'admin_user';
    
    protected $object_id;
    
    public function getUserId()
    {
        return $this->object_id;
    }
}