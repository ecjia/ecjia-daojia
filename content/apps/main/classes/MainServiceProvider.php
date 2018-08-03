<?php

namespace Ecjia\App\Main;

use Royalcms\Component\App\AppParentServiceProvider;

class MainServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-main');
    }
    
    public function register()
    {
        
    }
    
    
    
}