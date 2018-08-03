<?php

namespace Ecjia\App\Staff;

use Royalcms\Component\App\AppParentServiceProvider;

class StaffServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-staff');
    }
    
    public function register()
    {
        
    }
    
    
    
}