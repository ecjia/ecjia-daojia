<?php

namespace Royalcms\Component\Foundation\Support\Providers;

use Royalcms\Component\Routing\Router;
use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Contracts\Routing\UrlGenerator;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The controller namespace for the application.
     *
     * @var string|null
     */
    protected $namespace;

    /**
     * Bootstrap any application services.
     *
     * @param  \Royalcms\Component\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        $this->setRootControllerNamespace();

        if ($this->royalcms->routesAreCached()) {
            $this->loadCachedRoutes();
        } else {
            $this->loadRoutes();

            $this->royalcms->booted(function () use ($router) {
                $router->getRoutes()->refreshNameLookups();
            });
        }
    }

    /**
     * Set the root controller namespace for the application.
     *
     * @return void
     */
    protected function setRootControllerNamespace()
    {
        if (is_null($this->namespace)) {
            return;
        }

        $this->royalcms[UrlGenerator::class]->setRootControllerNamespace($this->namespace);
    }

    /**
     * Load the cached routes for the application.
     *
     * @return void
     */
    protected function loadCachedRoutes()
    {
        $this->royalcms->booted(function () {
            require $this->royalcms->getCachedRoutesPath();
        });
    }

    /**
     * Load the application routes.
     *
     * @return void
     */
    protected function loadRoutes()
    {
        $this->royalcms->call([$this, 'map']);
    }

    /**
     * Load the standard routes file for the application.
     *
     * @param  string  $path
     * @return mixed
     */
    protected function loadRoutesFrom($path)
    {
        $router = $this->royalcms->make(Router::class);

        if (is_null($this->namespace)) {
            return require $path;
        }

        $router->group(['namespace' => $this->namespace], function (Router $router) use ($path) {
            require $path;
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Pass dynamic methods onto the router instance.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->royalcms->make(Router::class), $method], $parameters);
    }
}
