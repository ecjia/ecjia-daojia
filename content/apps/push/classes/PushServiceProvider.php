<?php

namespace Ecjia\App\Push;

use Royalcms\Component\App\AppParentServiceProvider;

class PushServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-push');
    }
    
    public function register()
    {
        
    }
    
    
    
}