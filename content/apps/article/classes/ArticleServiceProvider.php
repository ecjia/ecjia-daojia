<?php

namespace Ecjia\App\Article;

use Royalcms\Component\App\AppParentServiceProvider;

class ArticleServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-article');
    }
    
    public function register()
    {
        
    }
    
    
    
}