<?php

namespace Ecjia\App\Customer;

use Royalcms\Component\App\AppParentServiceProvider;

class CustomerServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-customer');
    }
    
    public function register()
    {
        
    }
    
    
    
}