<?php

namespace Ecjia\Kernel\Providers;

use RC_Hook;
use Royalcms\Component\Routing\Router;
use Royalcms\Component\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use function Composer\Autoload\includeFile;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Ecjia\Kernel\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param \Royalcms\Component\Routing\Router $router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapSiteRoutes();

        $this->mapRoutes();

        RC_Hook::do_action('kernel_map_routes');
    }

    /**
     * Traverse the route definition of the root site
     */
    protected function mapRoutes()
    {
        $path = royalcms()->contentPath().'/routes/routes.php';
        includeFile($path);
    }

    /**
     * Traverse the route definition of the root site
     */
    protected function mapSiteRoutes()
    {
        $path = royalcms()->siteContentPath().'/routes/routes.php';
        includeFile($path);
    }

}