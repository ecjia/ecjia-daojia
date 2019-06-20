<?php

namespace Royalcms\Component\App;

use Royalcms\Component\DefaultRoute\HttpQueryRoute;
use RC_Hook;
use Royalcms\Component\Error\Error;
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
    
    public function __construct()
    {
        $this->route = royalcms('default-router');

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
        else {

            try {
                //优化判断hook路由方法
                if (RC_Hook::has_action($this->routePath)) {
                    if (RC_Hook::has_filter('royalcms_handler_controller')) {
                        $controller = RC_Hook::apply_filters('royalcms_handler_controller', $controller, $this->route);
                    }
                    RC_Hook::do_action($this->routePath, new $controller);
                    return royalcms('response');
                } else {
                    $response = $this->route->runControllerAction($controller, $this->route->getAction());
                    if (is_null($response)) {
                        return royalcms('response');
                    }
                    return $response;
                }
            } catch (NotFoundHttpException $e) {
                abort(403, $e->getMessage());
            } catch (AccessDeniedHttpException $e) {
                abort(401, $e->getMessage());
            }

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
            abort(403, $error->get_error_message());
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
            abort(403, $e->getMessage());
        }
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
        $parameters = $route->parametersWithoutNulls();
        
        return $instance->callAction($method, $parameters);
    }
    
}

// end