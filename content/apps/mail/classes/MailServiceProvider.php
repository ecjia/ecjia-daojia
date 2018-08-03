<?php

namespace Ecjia\App\Mail;

use Royalcms\Component\App\AppParentServiceProvider;

class MailServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-mail');
    }
    
    public function register()
    {
        
    }
    
    
    
}