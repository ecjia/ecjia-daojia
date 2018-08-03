<?php

namespace Ecjia\App\Franchisee;

use Royalcms\Component\App\AppParentServiceProvider;

class FranchiseeServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-franchisee');
    }
    
    public function register()
    {
        
    }
    
    
    
}