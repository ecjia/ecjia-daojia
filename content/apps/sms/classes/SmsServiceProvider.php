<?php

namespace Ecjia\App\Sms;

use Royalcms\Component\App\AppParentServiceProvider;

class SmsServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-sms');
    }
    
    public function register()
    {
        
    }
    
    
    
}