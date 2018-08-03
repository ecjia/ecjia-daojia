<?php

namespace Ecjia\App\Friendlink;

use Royalcms\Component\App\AppParentServiceProvider;

class FriendlinkServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-friendlink');
    }
    
    public function register()
    {
        
    }
    
    
    
}