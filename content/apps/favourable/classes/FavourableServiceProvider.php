<?php

namespace Ecjia\App\Favourable;

use Royalcms\Component\App\AppParentServiceProvider;

class FavourableServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-favourable');
    }
    
    public function register()
    {
        
    }
    
    
    
}