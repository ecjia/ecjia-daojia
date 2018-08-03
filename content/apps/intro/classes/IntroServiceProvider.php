<?php

namespace Ecjia\App\Intro;

use Royalcms\Component\App\AppParentServiceProvider;

class IntroServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-intro');
    }
    
    public function register()
    {
        
    }
    
    
    
}