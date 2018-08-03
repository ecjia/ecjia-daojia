<?php

namespace Ecjia\App\Groupbuy;

use Royalcms\Component\App\AppParentServiceProvider;

class GroupbuyServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-groupbuy');
    }
    
    public function register()
    {
        
    }
    
    
    
}