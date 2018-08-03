<?php

namespace Ecjia\App\Upgrade;

use Royalcms\Component\App\AppParentServiceProvider;

class UpgradeServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-upgrade');
    }
    
    public function register()
    {
        
    }
    
    
    
}