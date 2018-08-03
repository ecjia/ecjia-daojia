<?php

namespace Ecjia\App\Comment;

use Royalcms\Component\App\AppParentServiceProvider;

class CommentServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-comment');
    }
    
    public function register()
    {
        
    }
    
    
    
}