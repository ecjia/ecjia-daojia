<?php

namespace Royalcms\Component\Foundation\Http;

use Exception;
use Throwable;
use Royalcms\Component\Routing\Router;
use Royalcms\Component\Pipeline\Pipeline;
use Royalcms\Component\Support\Facades\Facade;
use Royalcms\Component\Contracts\Foundation\Royalcms;
use Royalcms\Component\Contracts\Http\Kernel as KernelContract;
use Symfony\Component\Debug\Exception\FatalThrowableError;

class Kernel implements KernelContract
{
    /**
     * The royalcms application implementation.
     *
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected $royalcms;

    /**
     * The router instance.
     *
     * @var \Royalcms\Component\Routing\Router
     */
    protected $router;

    /**
     * The bootstrap classes for the application.
     *
     * @var array
     */
    protected $bootstrappers = [
        'Royalcms\Component\Foundation\Bootstrap\Starting',
        'Royalcms\Component\Foundation\Bootstrap\DetectEnvironment',
        'Royalcms\Component\Foundation\Bootstrap\LoadConfiguration',
        'Royalcms\Component\Foundation\Bootstrap\RegisterNamespaces',
        'Royalcms\Component\Foundation\Bootstrap\ConfigureLogging',
        'Royalcms\Component\Foundation\Bootstrap\HandleExceptions',
        'Royalcms\Component\Foundation\Bootstrap\RegisterFacades',
        'Royalcms\Component\Foundation\Bootstrap\RegisterProviders',
        'Royalcms\Component\Foundation\Bootstrap\BootProviders',
        'Royalcms\Component\Foundation\Bootstrap\Booted',
    ];

    /**
     * The application's middleware stack.
     *
     * @var array
     */
    protected $middleware = [];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [];

    /**
     * Create a new HTTP kernel instance.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @param  \Royalcms\Component\Routing\Router  $router
     * @return void
     */
    public function __construct(Royalcms $royalcms, Router $router)
    {
        $this->royalcms = $royalcms;
        $this->router = $router;

        foreach ($this->routeMiddleware as $key => $middleware) {
            $router->middleware($key, $middleware);
        }
    }

    /**
     * Handle an incoming HTTP request.
     *
     * @param  \Royalcms\Component\Http\Request  $request
     * @return \Royalcms\Component\Http\Response
     */
    public function handle($request)
    {
        try {
            $request->enableHttpMethodParameterOverride();

            $response = $this->sendRequestThroughRouter($request);
        } catch (Exception $e) {
            $this->reportException($e);

            $response = $this->renderException($request, $e);
        } catch (Throwable $e) {
            $e = new FatalThrowableError($e);

            $this->reportException($e);

            $response = $this->renderException($request, $e);
        }

        $this->royalcms['events']->fire('kernel.handled', [$request, $response]);

        return $response;
    }

    /**
     * Send the given request through the middleware / router.
     *
     * @param  \Royalcms\Component\Http\Request  $request
     * @return \Royalcms\Component\Http\Response
     */
    protected function sendRequestThroughRouter($request)
    {
        $this->royalcms->instance('request', $request);

        Facade::clearResolvedInstance('request');

        $this->bootstrap();

        return with(new Pipeline($this->royalcms))
                    ->send($request)
                    ->through($this->royalcms->shouldSkipMiddleware() ? [] : $this->middleware)
                    ->then($this->dispatchToRouter());
    }

    /**
     * Call the terminate method on any terminable middleware.
     *
     * @param  \Royalcms\Component\Http\Request  $request
     * @param  \Royalcms\Component\Http\Response  $response
     * @return void
     */
    public function terminate($request, $response)
    {
        $middlewares = $this->royalcms->shouldSkipMiddleware() ? [] : array_merge(
            $this->gatherRouteMiddlewares($request),
            $this->middleware
        );

        foreach ($middlewares as $middleware) {
            list($name, $parameters) = $this->parseMiddleware($middleware);

            $instance = $this->royalcms->make($name);

            if (method_exists($instance, 'terminate')) {
                $instance->terminate($request, $response);
            }
        }

        $this->royalcms->terminate();
    }

    /**
     * Gather the route middleware for the given request.
     *
     * @param  \Royalcms\Component\Http\Request  $request
     * @return array
     */
    protected function gatherRouteMiddlewares($request)
    {
        if ($route = $request->route()) {
            return $this->router->gatherRouteMiddlewares($route);
        }

        return [];
    }

    /**
     * Parse a middleware string to get the name and parameters.
     *
     * @param  string  $middleware
     * @return array
     */
    protected function parseMiddleware($middleware)
    {
        list($name, $parameters) = array_pad(explode(':', $middleware, 2), 2, []);

        if (is_string($parameters)) {
            $parameters = explode(',', $parameters);
        }

        return [$name, $parameters];
    }

    /**
     * Add a new middleware to beginning of the stack if it does not already exist.
     *
     * @param  string  $middleware
     * @return $this
     */
    public function prependMiddleware($middleware)
    {
        if (array_search($middleware, $this->middleware) === false) {
            array_unshift($this->middleware, $middleware);
        }

        return $this;
    }

    /**
     * Add a new middleware to end of the stack if it does not already exist.
     *
     * @param  string  $middleware
     * @return $this
     */
    public function pushMiddleware($middleware)
    {
        if (array_search($middleware, $this->middleware) === false) {
            $this->middleware[] = $middleware;
        }

        return $this;
    }

    /**
     * Bootstrap the application for HTTP requests.
     *
     * @return void
     */
    public function bootstrap()
    {
        if (! $this->royalcms->hasBeenBootstrapped()) {
            $this->royalcms->bootstrapWith($this->bootstrappers());
        }
    }

    /**
     * Get the route dispatcher callback.
     *
     * @return \Closure
     */
    protected function dispatchToRouter()
    {
        return function ($request) {
            $this->royalcms->instance('request', $request);

            return $this->router->dispatch($request);
        };
    }

    /**
     * Determine if the kernel has a given middleware.
     *
     * @param  string  $middleware
     * @return bool
     */
    public function hasMiddleware($middleware)
    {
        return in_array($middleware, $this->middleware);
    }

    /**
     * Get the bootstrap classes for the application.
     *
     * @return array
     */
    protected function bootstrappers()
    {
        return $this->bootstrappers;
    }

    /**
     * Report the exception to the exception handler.
     *
     * @param  \Exception  $e
     * @return void
     */
    protected function reportException(Exception $e)
    {
        $this->royalcms['Royalcms\Component\Contracts\Debug\ExceptionHandler']->report($e);
    }

    /**
     * Render the exception to a response.
     *
     * @param  \Royalcms\Component\Http\Request  $request
     * @param  \Exception  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderException($request, Exception $e)
    {
        return $this->royalcms['Royalcms\Component\Contracts\Debug\ExceptionHandler']->render($request, $e);
    }

    /**
     * Get the Royalcms application instance.
     *
     * @return \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    public function getRoyalcms()
    {
        return $this->royalcms;
    }

    /**
     * Get the Royalcms application instance.
     *
     * @return \Royalcms\Component\Contracts\Foundation\Application
     */
    public function getApplication()
    {
        return $this->royalcms;
    }
}
