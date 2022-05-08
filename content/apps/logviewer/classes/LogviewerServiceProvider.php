<?php

namespace Ecjia\App\Logviewer;

use RC_Service;
use Royalcms\Component\App\AppParentServiceProvider;

class LogviewerServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-logviewer');
    }
    
    public function register()
    {
//         RC_Service::addService('admin_purview', 'logviewer', \Ecjia\App\Logviewer\Services\LogviewerAdminPurviewService::class);
        RC_Service::addService('tool_menu', 'logviewer', \Ecjia\App\Logviewer\Services\LogviewerToolMenuService::class);
    }
    
    
    
}