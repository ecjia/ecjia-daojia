<?php

namespace Royalcms\Component\Routing;

use Illuminate\Contracts\View\Factory as ViewFactoryContract;
use Royalcms\Component\Support\ServiceProvider;
use Zend\Diactoros\Response as PsrResponse;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;

class RoutingServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->loadAlias();

        $this->registerRouter();

        $this->registerUrlGenerator();

        $this->registerRedirector();

        $this->registerPsrRequest();

        $this->registerPsrResponse();

        $this->registerResponseFactory();

        $this->registerResponse();
    }

    /**
     * Register the router instance.
     * @return void
     */
    protected function registerRouter()
    {
        $this->royalcms->singleton('router', function ($royalcms) {
            return new Router($royalcms['events'], $royalcms);
        });
    }

    /**
     * Register the URL generator service.
     * @return void
     */
    protected function registerUrlGenerator()
    {
        $this->royalcms->singleton('url', function ($royalcms) {
            $routes = $royalcms['router']->getRoutes();

            // The URL generator needs the route collection that exists on the router.
            // Keep in mind this is an object, so we're passing by references here
            // and all the registered routes will be available to the generator.
            $royalcms->instance('routes', $routes);

            $url = new UrlGenerator(
                $routes, $royalcms->rebinding(
                'request', $this->requestRebinder()
            )
            );

            $url->setSessionResolver(function () {
                return $this->royalcms['session'];
            });

            // If the route collection is "rebound", for example, when the routes stay
            // cached for the application, we will need to rebind the routes on the
            // URL generator instance so it has the latest version of the routes.
            $royalcms->rebinding('routes', function ($royalcms, $routes) {
                $royalcms['url']->setRoutes($routes);
            });

            return $url;
        });
    }

    /**
     * Get the URL generator request rebinder.
     * @return \Closure
     */
    protected function requestRebinder()
    {
        return function ($royalcms, $request) {
            $royalcms['url']->setRequest($request);
        };
    }

    /**
     * Register the Redirector service.
     * @return void
     */
    protected function registerRedirector()
    {
        $this->royalcms->singleton('redirect', function ($royalcms) {
            $redirector = new Redirector($royalcms['url']);

            // If the session is set on the application instance, we'll inject it into
            // the redirector instance. This allows the redirect responses to allow
            // for the quite convenient "with" methods that flash to the session.
            // @todo 在调用的地方设置session
            //if (isset($royalcms['session.store'])) {
            //    $redirector->setSession($royalcms['session.store']);
            //}

            return $redirector;
        });
    }

    /**
     * Register a binding for the PSR-7 request implementation.
     * @return void
     */
    protected function registerPsrRequest()
    {
        $this->royalcms->bind('Psr\Http\Message\ServerRequestInterface', function ($royalcms) {
            return (new DiactorosFactory)->createRequest($royalcms->make('request'));
        });
    }

    /**
     * Register a binding for the PSR-7 response implementation.
     * @return void
     */
    protected function registerPsrResponse()
    {
        $this->royalcms->bind('Psr\Http\Message\ResponseInterface', function ($royalcms) {
            return new PsrResponse();
        });
    }

    /**
     * Register the response factory implementation.
     * @return void
     */
    protected function registerResponseFactory()
    {
        $this->royalcms->singleton('Royalcms\Component\Contracts\Routing\ResponseFactory', function ($royalcms) {
            return new ResponseFactory($royalcms['Illuminate\Contracts\View\Factory'], $royalcms['redirect']);
        });

        $this->royalcms->alias('Royalcms\Component\Contracts\Routing\ResponseFactory', 'Illuminate\Contracts\Routing\ResponseFactory');
    }

    /**
     * Register the router instance.
     * @royalcms 5.0.0
     * @return void
     */
    protected function registerResponse()
    {
        $this->royalcms->singleton('response', function ($royalcms) {
            return new \Royalcms\Component\Http\Response();
        });
    }


    /**
     * Load the alias = One less install step for the user
     */
    protected function loadAlias()
    {
        $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();

        foreach (self::aliases() as $class => $alias) {
            $loader->alias($class, $alias);
        }
    }

    /**
     * Load the alias = One less install step for the user
     */
    public static function aliases()
    {

        return [
            'Royalcms\Component\Routing\Console\ControllerMakeCommand' => 'Illuminate\Routing\Console\ControllerMakeCommand',
            'Royalcms\Component\Routing\Console\MiddlewareMakeCommand' => 'Illuminate\Routing\Console\MiddlewareMakeCommand',
            'Royalcms\Component\Routing\Matching\HostValidator'        => 'Illuminate\Routing\Matching\HostValidator',
            'Royalcms\Component\Routing\Matching\MethodValidator'      => 'Illuminate\Routing\Matching\MethodValidator',
            'Royalcms\Component\Routing\Matching\SchemeValidator'      => 'Illuminate\Routing\Matching\SchemeValidator',
            'Royalcms\Component\Routing\Matching\UriValidator'         => 'Illuminate\Routing\Matching\UriValidator',
            'Royalcms\Component\Routing\Matching\ValidatorInterfacer'  => 'Illuminate\Routing\Matching\ValidatorInterface',
            'Royalcms\Component\Routing\Redirector'                    => 'Illuminate\Routing\Redirector',
            'Royalcms\Component\Routing\ResourceRegistrar'             => 'Illuminate\Routing\ResourceRegistrar',
            'Royalcms\Component\Routing\Route'                         => 'Illuminate\Routing\Route',
            'Royalcms\Component\Routing\RouteCollection'               => 'Illuminate\Routing\RouteCollection',
            'Royalcms\Component\Routing\RouteDependencyResolverTrait'  => 'Illuminate\Routing\RouteDependencyResolverTrait',
            'Royalcms\Component\Routing\Router'                        => 'Illuminate\Routing\Router',
            'Royalcms\Component\Routing\UrlGenerator'                  => 'Illuminate\Routing\UrlGenerator',
        ];
    }

}
