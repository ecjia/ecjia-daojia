<?php

namespace Ecjia\App\Touch;

use Royalcms\Component\App\AppParentServiceProvider;

class TouchServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-touch');
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
            $loader->alias('ecjia_touch', 'Ecjia\App\Touch\Frameworks\EcjiaTouch');

            $loader->alias('ecjia_touch_manager', 'Ecjia\App\Touch\ApiRequest\ApiManager');
            $loader->alias('ecjia_touch_api', 'Ecjia\App\Touch\ApiRequest\ApiConst');
            $loader->alias('ecjia_touch_page', 'Ecjia\App\Touch\Frameworks\Component\Page');
            $loader->alias('ecjia_touch_user', 'Ecjia\App\Touch\Frameworks\Component\User');
        });
    }
    
    
}