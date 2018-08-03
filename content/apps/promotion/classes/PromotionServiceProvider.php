<?php

namespace Ecjia\App\Promotion;

use Royalcms\Component\App\AppParentServiceProvider;

class PromotionServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-promotion');
    }
    
    public function register()
    {
        
    }
    
    
    
}