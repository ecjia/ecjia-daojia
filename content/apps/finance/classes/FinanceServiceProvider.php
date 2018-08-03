<?php

namespace Ecjia\App\Finance;

use Royalcms\Component\App\AppParentServiceProvider;

class FinanceServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-finance');
    }
    
    public function register()
    {
        
    }
    
    
    
}