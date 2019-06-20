<?php

namespace Ecjia\App\Ucserver;

use Royalcms\Component\App\AppParentServiceProvider;

class UcserverServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-ucserver');
    }
    
    public function register()
    {
        $ucmykey = Helper::generateAuthKey();
        define('UC_MYKEY', $ucmykey);
    }
    
    
    
}