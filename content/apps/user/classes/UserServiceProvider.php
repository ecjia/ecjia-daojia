<?php

namespace Ecjia\App\User;

use Royalcms\Component\App\AppParentServiceProvider;

class UserServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-user');
    }
    
    public function register()
    {
        $this->loadAlias();
    }


    /**
     * Load the alias = One less install step for the user
     */
    protected function loadAlias()
    {
        $this->royalcms->booting(function()
        {
            $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();
            $loader->alias('ecjia_user', 'Ecjia\App\User\Frameworks\EcjiaUser');

        });
    }
    
}