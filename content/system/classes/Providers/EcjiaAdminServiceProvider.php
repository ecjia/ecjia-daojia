<?php


namespace Ecjia\System\Providers;

use Royalcms\Component\App\AppParentServiceProvider;
use Royalcms\Component\Hook\Dispatcher;

class EcjiaAdminServiceProvider extends AppParentServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;


    public function boot(Dispatcher $dispatcher)
    {
//        $dispatcher->subscribe('Ecjia\System\Subscribers\AdminSystemSubscriber');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {


    }



    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

}