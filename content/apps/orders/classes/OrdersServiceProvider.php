<?php

namespace Ecjia\App\Orders;

use Royalcms\Component\App\AppParentServiceProvider;

class OrdersServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-orders');
    }
    
    public function register()
    {
        
    }
    
    
    
}