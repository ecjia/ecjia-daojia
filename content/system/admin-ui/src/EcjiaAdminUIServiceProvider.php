<?php
namespace Ecjia\System\AdminUI;

use Ecjia\System\AdminUI\ScriptLoader\RegisterDefaultScripts;
use Ecjia\System\AdminUI\ScriptLoader\RegisterDefaultStyles;
use Royalcms\Component\App\AppParentServiceProvider;

class EcjiaAdminUIServiceProvider extends AppParentServiceProvider
{


    public function boot()
    {
        $this->registerDefaultStyles();
        $this->registerDefaultScripts();

    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }

    public function registerDefaultScripts()
    {
        //启动后执行
        $this->royalcms->booted(function () {
            (new RegisterDefaultScripts())();
        });
    }

    public function registerDefaultStyles()
    {
        //启动后执行
        $this->royalcms->booted(function () {
            (new RegisterDefaultStyles())();
        });
    }

}