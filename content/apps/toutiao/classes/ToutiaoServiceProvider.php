<?php

namespace Ecjia\App\Toutiao;

use Royalcms\Component\App\AppParentServiceProvider;

class ToutiaoServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-toutiao');
    }
    
    public function register()
    {
        
    }
    
    
    
}