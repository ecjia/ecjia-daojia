<?php

namespace Ecjia\App\Notification;

use Royalcms\Component\App\AppParentServiceProvider;

class NotificationServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-notification');
    }
    
    public function register()
    {
        
    }
    
    
    
}