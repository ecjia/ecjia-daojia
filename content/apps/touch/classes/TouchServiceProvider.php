<?php

namespace Ecjia\App\Touch;

use Royalcms\Component\App\AppParentServiceProvider;

class TouchServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-touch');
    }
    
    public function register()
    {
        
    }
    
    
    
}