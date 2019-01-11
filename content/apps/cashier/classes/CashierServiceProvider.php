<?php

namespace Ecjia\App\Cashier;

use Royalcms\Component\App\AppParentServiceProvider;

class CashierServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-cashier');
    }
    
    public function register()
    {
        
    }
    
    
    
}