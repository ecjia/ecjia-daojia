<?php


namespace Ecjia\System\Providers;

use Ecjia\System\Admins\AdminLog\AdminLog;
use Royalcms\Component\App\AppParentServiceProvider;

class EcjiaAdminServiceProvider extends AppParentServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAdminLog();

    }


    public function registerAdminLog()
    {
        $this->royalcms->bindShared('ecjia.admin.log', function($royalcms) {
            return AdminLog::instance();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array(
            'ecjia.admin.log',
        );
    }

}