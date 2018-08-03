<?php

namespace Ecjia\App\Platform;

use Royalcms\Component\App\AppParentServiceProvider;

class PlatformServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-platform');
    }
    
    public function register()
    {
        
    }
    
    
    
}