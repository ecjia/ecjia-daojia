<?php

namespace Ecjia\App\Captcha;

use Royalcms\Component\App\AppParentServiceProvider;

class CaptchaServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-captcha');
    }
    
    public function register()
    {
        
    }
    
    
    
}