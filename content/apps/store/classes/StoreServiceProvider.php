<?php

namespace Ecjia\App\Store;

use Royalcms\Component\App\AppParentServiceProvider;

class StoreServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-store');
    }
    
    public function register()
    {
        
    }
    
    
    
}