<?php

namespace Ecjia\App\Merchant;

use Royalcms\Component\App\AppParentServiceProvider;

class MerchantServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-merchant');
    }
    
    public function register()
    {
        
    }
    
    
    
}