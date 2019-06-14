<?php

namespace Royalcms\Component\App;

use Royalcms\Component\DefaultRoute\HttpQueryRoute;
use RC_Hook;
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
        elseif (is_rc_error($controller)) {

            if (RC_Hook::has_action('royalcms_default_controller')) {
                RC_Hook::do_action('royalcms_default_controller', $this->routePath);
            }

//            if (RC_Hook::has_action($this->routePath)) {
//                RC_Hook::do_action($this->routePath);
//                return royalcms('response');
//            } else {
//                abort(403, $controller->get_error_message());
//            }

        }

        try {
            
            if (RC_Hook::has_action($this->routePath)) {
                // 实例化控制器对象，辅助给hook方法使用

//                with(new $controller);
                RC_Hook::do_action($this->routePath);
                return royalcms('response');
            } else {
                
                $response = $this->route->runControllerAction($controller, $this->route->getAction());

                if ( $response instanceof RoyalcmsResponse) {
                    if (! is_null($response->getOriginalContent())) {
                        return $response;
                    }
                }

                if (! is_null($response)) {
                    return $response;
                }

                return royalcms('response');
            }
            
        } catch (NotFoundHttpException $e) {
            abort(403, $e->getMessage());
        } catch (AccessDeniedHttpException $e) {
            abort(401, $e->getMessage());
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
            $bundle = $this->manager->driver($this->route->getModule());
            if ( ! $bundle) {
                abort(404, "App {$this->route->getModule()} does not found.");
            }
            
            $controller = $bundle->getControllerClassName($this->route->getController());
//            if (RC_Error::is_error($controller)) {
//
//                if (RC_Hook::has_action('royalcms_default_controller')) {
//                    RC_Hook::do_action('royalcms_default_controller', $this->routePath);
//                }
//
//                if (RC_Hook::has_action($this->routePath)) {
//                    RC_Hook::do_action($this->routePath);
//                    return royalcms('response');
//                } else {
//                    abort(403, $controller->get_error_message());
//                }
//
//            } else {
//                return $controller;
//            }
            return $controller;
        } catch (InvalidArgumentException $e) {
            abort(403, $e->getMessage());
        }
    }
    
    
    /**
     * Call the "before" filters for the controller.
     *
     * @param  \Royalcms\Component\Routing\Controller  $instance
     * @param  \Royalcms\Component\Routing\Route  $route
     * @param  \Royalcms\Component\Http\Request  $request
     * @param  string  $method
     * @return mixed
     */
    protected function before($instance, $route, $request, $method)
    {
        foreach ($instance->getBeforeFilters() as $filter)
        {
            if ($this->filterApplies($filter, $request, $method))
            {
                // Here we will just check if the filter applies. If it does we will call the filter
                // and return the responses if it isn't null. If it is null, we will keep hitting
                // them until we get a response or are finished iterating through this filters.
                $response = $this->callFilter($filter, $route, $request);
                
                if ( ! is_null($response)) return $response;
            }
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