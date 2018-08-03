<?php

namespace Ecjia\App\Shopguide;

use Royalcms\Component\App\AppParentServiceProvider;

class ShopguideServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-shopguide');
    }
    
    public function register()
    {
        
    }
    
    
    
}