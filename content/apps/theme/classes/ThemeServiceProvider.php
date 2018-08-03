<?php

namespace Ecjia\App\Theme;

use Royalcms\Component\App\AppParentServiceProvider;

class ThemeServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-theme');
    }
    
    public function register()
    {
        
    }
    
    
    
}