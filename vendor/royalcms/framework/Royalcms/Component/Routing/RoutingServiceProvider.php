<?php

namespace Royalcms\Component\Routing;

use Royalcms\Component\Support\ServiceProvider;
use Zend\Diactoros\Response as PsrResponse;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;

class RoutingServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
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
     *
     * @return void
     */
    protected function registerRouter()
    {
        $this->royalcms['router'] = $this->royalcms->share(function ($royalcms) {
            return new Router($royalcms['events'], $royalcms);
        });
    }

    /**
     * Register the URL generator service.
     *
     * @return void
     */
    protected function registerUrlGenerator()
    {
        $this->royalcms['url'] = $this->royalcms->share(function ($royalcms) {
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
     *
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
     *
     * @return void
     */
    protected function registerRedirector()
    {
        $this->royalcms['redirect'] = $this->royalcms->share(function ($royalcms) {
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
     *
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
     *
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
     *
     * @return void
     */
    protected function registerResponseFactory()
    {
        $this->royalcms->singleton('Royalcms\Component\Contracts\Routing\ResponseFactory', function ($royalcms) {
            return new ResponseFactory($royalcms['Royalcms\Component\Contracts\View\Factory'], $royalcms['redirect']);
        });

        //$this->royalcms->alias('response', 'Royalcms\Component\Contracts\Routing\ResponseFactory');
    }

    /**
     * Register the router instance.
     *
     * @royalcms 5.0.0
     * @return void
     */
    protected function registerResponse()
    {
        $this->royalcms['response'] = $this->royalcms->share(function($royalcms)
        {
            return new \Royalcms\Component\Http\Response();
        });
    }
}
