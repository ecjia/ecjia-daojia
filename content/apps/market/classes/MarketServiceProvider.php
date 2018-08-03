<?php

namespace Ecjia\App\Market;

use Royalcms\Component\App\AppParentServiceProvider;

class MarketServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-market');
    }
    
    public function register()
    {
        
    }
    
    
    
}