<?php

namespace Ecjia\App\Refund;

use Royalcms\Component\App\AppParentServiceProvider;

class RefundServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-refund');
    }
    
    public function register()
    {
        
    }
    
    
    
}