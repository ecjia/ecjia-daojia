<?php

namespace Ecjia\App\Goods;

use Royalcms\Component\App\AppParentServiceProvider;

class GoodsServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-goods');
    }
    
    public function register()
    {
        
    }
    
    
    
}