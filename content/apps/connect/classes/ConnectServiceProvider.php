<?php

namespace Ecjia\App\Connect;

use Royalcms\Component\App\AppParentServiceProvider;

class ConnectServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-connect');
    }
    
    public function register()
    {
        
    }
    
    
    
}