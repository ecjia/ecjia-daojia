<?php

namespace Royalcms\Component\App;

use Royalcms\Component\DefaultRoute\HttpQueryRoute;
use RC_Hook;
use Royalcms\Component\Error\Error;
use Royalcms\Component\Pipeline\Pipeline;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use InvalidArgumentException;
use Royalcms\Component\Http\Response as RoyalcmsResponse;

class AppControllerDispatcher
{
    /**
     * @var HttpQueryRoute
     */
    protected $route;
    
    protected $manager;
    
    protected $routePath;

    protected $container;
    
    public function __construct($route = null)
    {
        $this->container = royalcms();

        if (is_null($route)) {
            $this->route = royalcms('default-router');
        }
        else {
            $this->route = $route;
        }

        $this->route->parser();

        $this->manager = royalcms('app');
        
        $this->routePath = $this->route->getModule() . '/' . $this->route->getController() . '/' . $this->route->getAction();
    }

    /**
     * @return HttpQueryRoute
     */
    public function getRoute()
    {
        return $this->route;
    }
    
    
    /**
     * Dispatch a request to a given controller and method.
     *
     * @param  string  $controller
     * @param  string  $method
     * @return mixed
     */
    public function dispatch()
    {
        try {
            // First we will make an instance of this controller via the IoC container instance
            // so that we can call the methods on it. We will also apply any "after" filters
            // to the route so that they will be run by the routers after this processing.
            $controller = $this->makeController();

            if ( $controller instanceof RoyalcmsResponse) {
                return $controller;
            }

            if (is_rc_error($controller)) {
                return $this->handlerNotFoundController($controller);
            }

            $route = $this->routePath;
            $request = royalcms('request');
            $method = $this->route->getAction();
            $this->container->singleton($controller);
            $instance = $this->container->make($controller);
            $response = $this->callWithinStack($instance, $route, $request, $method);
            return $response;
        } catch (NotFoundHttpException $e) {
            abort(404, $e->getMessage());
        } catch (AccessDeniedHttpException $e) {
            abort(401, $e->getMessage());
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    /**
     * @param \Royalcms\Component\Error\Error $error
     * @return mixed|\Royalcms\Component\Foundation\Royalcms
     */
    protected function handlerNotFoundController(Error $error)
    {
        if (RC_Hook::has_action('royalcms_default_controller')) {
            RC_Hook::do_action('royalcms_default_controller', $this->routePath);
        }

        if (RC_Hook::has_action($this->routePath)) {
            RC_Hook::do_action($this->routePath);
            return royalcms('response');
        } else {
            abort(404, $error->get_error_message());
        }
    }
    
    
    /**
     * Make a controller instance via the IoC container.
     *
     * @param  string  $controller
     * @return mixed
     */
    protected function makeController()
    {
        try {
            /**
             * @var $bundle BundleAbstract
             */
            $bundle = $this->manager->driver($this->route->getModule());
            if ( ! $bundle) {
                abort(404, "App {$this->route->getModule()} does not found.");
            }

            $controller = $bundle->getControllerClassName($this->route->getController());
            
            return $controller;
        } catch (InvalidArgumentException $e) {
            abort(404, $e->getMessage());
        }
    }

    /**
     * Call the given controller instance method.
     *
     * @param  \Royalcms\Component\Routing\Controller  $instance
     * @param  \Royalcms\Component\Routing\Route  $route
     * @param  \Royalcms\Component\Http\Request  $request
     * @param  string  $method
     * @return mixed
     */
    protected function callWithinStack($instance, $route, $request, $method)
    {
//        $shouldSkipMiddleware = $this->container->bound('middleware.disable') &&
//        $this->container->make('middleware.disable') === true;
//
//        $middleware = $shouldSkipMiddleware ? [] : $this->getMiddleware($instance, $method);

        // Here we will make a stack onion instance to execute this request in, which gives
        // us the ability to define middlewares on controllers. We will return the given
        // response back out so that "after" filters can be run after the middlewares.
//        return (new Pipeline($this->container))
//                ->send($request)
//                ->through($middleware)
//                ->then(function ($request) use ($instance, $route, $method) {
//                        return $this->call($instance, $route, $method);
//        });

        return $this->call($instance, $route, $method);
    }

    /**
     * Get the middleware for the controller instance.
     *
     * @param  \Royalcms\Component\Routing\Controller  $controller
     * @param  string  $method
     * @return array
     */
    public function getMiddleware($controller, $method)
    {
        if (! method_exists($controller, 'getMiddleware')) {
            return [];
        }

        $results = [];

        foreach ($controller->getMiddleware() as $data) {
            $name = $data['middleware'];
            if (! $this->methodExcludedByOptions($method, $data['options'])) {
                $results[] = $this->resolveMiddlewareClassName($name);
            }
        }

        return $results;
    }

    /**
     * Determine if the given options exclude a particular method.
     *
     * @param  string  $method
     * @param  array  $options
     * @return bool
     */
    protected static function methodExcludedByOptions($method, array $options)
    {
        return (isset($options['only']) && ! in_array($method, (array) $options['only'])) ||
            (! empty($options['except']) && in_array($method, (array) $options['except']));
    }

    /**
     * Resolve the middleware name to a class name preserving passed parameters.
     *
     * @param  string  $name
     * @return string
     */
    public function resolveMiddlewareClassName($name)
    {
        list($name, $parameters) = array_pad(explode(':', $name, 2), 2, null);

        return $name.($parameters !== null ? ':'.$parameters : '');
    }
    
    /**
     * Call the given controller instance method.
     *
     * @param  \Royalcms\Component\Routing\Controller  $instance
     * @param  \Royalcms\Component\Routing\Route  $route
     * @param  string  $method
     * @return mixed
     */
    protected function call($instance, $route, $method)
    {
        //优化判断hook路由方法
        if (RC_Hook::has_action($route)) {
            if (RC_Hook::has_filter('royalcms_handler_controller_instance')) {
                $instance = RC_Hook::apply_filters('royalcms_handler_controller_instance', $instance, $route);
            }
            RC_Hook::do_action($route, $instance);
            return royalcms('response');
        }

        $response = $this->route->runControllerAction(get_class($instance), $method);
        if (is_null($response)) {
            return royalcms('response');
        }
        elseif (is_rc_error($response)) {
            return royalcms('response')->setContent($response->get_error_message());
        }
        return $response;
    }
    
}

// end