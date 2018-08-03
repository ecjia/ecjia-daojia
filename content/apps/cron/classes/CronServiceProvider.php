<?php

namespace Ecjia\App\Cron;

use Royalcms\Component\App\AppParentServiceProvider;

class CronServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-cron');
    }
    
    public function register()
    {
        
    }
    
    
    
}