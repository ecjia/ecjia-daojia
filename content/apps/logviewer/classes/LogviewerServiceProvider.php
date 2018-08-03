<?php

namespace Ecjia\App\Logviewer;

use Royalcms\Component\App\AppParentServiceProvider;

class LogviewerServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-logviewer');
    }
    
    public function register()
    {
        
    }
    
    
    
}