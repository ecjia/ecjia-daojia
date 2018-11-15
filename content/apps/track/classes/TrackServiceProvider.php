<?php

namespace Ecjia\App\Track;

use Royalcms\Component\App\AppParentServiceProvider;

class TrackServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-track');
    }
    
    public function register()
    {
        
    }
    
    
    
}