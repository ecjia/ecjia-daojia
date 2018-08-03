<?php

namespace Ecjia\App\Api;

use Royalcms\Component\App\AppParentServiceProvider;

class ApiServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-api');
    }
    
    public function register()
    {
        
    }
    
    
    
}