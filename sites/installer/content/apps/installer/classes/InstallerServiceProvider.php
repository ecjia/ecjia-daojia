<?php

namespace Ecjia\App\Installer;

use Royalcms\Component\App\AppParentServiceProvider;

class InstallerServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-installer');
    }
    
    public function register()
    {
        
    }
    
    
    
}