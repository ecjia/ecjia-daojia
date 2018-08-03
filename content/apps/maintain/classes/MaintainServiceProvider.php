<?php

namespace Ecjia\App\Maintain;

use Royalcms\Component\App\AppParentServiceProvider;

class MaintainServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-maintain');
    }
    
    public function register()
    {
        
    }
    
    
    
}