<?php

namespace Ecjia\App\Affiliate;

use Royalcms\Component\App\AppParentServiceProvider;

class AffiliateServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-affiliate');
    }
    
    public function register()
    {
        
    }
    
    
    
}