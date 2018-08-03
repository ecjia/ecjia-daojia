<?php

namespace Ecjia\App\Adsense;

use Royalcms\Component\App\AppParentServiceProvider;

class AdsenseServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-adsense');
    }
    
    public function register()
    {
        
    }
    
    
    
}