<?php

namespace Ecjia\App\Ucclient;

use Royalcms\Component\App\AppParentServiceProvider;

class UcclientServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-ucclient');
    }
    
    public function register()
    {
        
    }
    
    
    
}