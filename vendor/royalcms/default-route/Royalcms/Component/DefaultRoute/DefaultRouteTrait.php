<?php

namespace Royalcms\Component\DefaultRoute;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait DefaultRouteTrait
{
    protected $defaultAction = 'init';
    
    protected $originalAction;
    
    protected $originalController;

    /**
     * @param null $action
     * @return mixed
     */
    public function runAction($action = null)
    {
        $request = royalcms('request');

        $method = $this->resolveActionInCertainController($request, get_class($this), $action);

        list($class, $method) = explode('@', $method);

//        return royalcms()->call([$this, substr(strrchr($method, '@'), 1)]);

        $dispatcher = royalcms('royalcms.route.dispatcher');

        $route = royalcms('router')->getCurrentRoute();

        return $dispatcher->dispatch($route, $request, $class, $method);
    }

    /**
     * @param $controller
     * @param null $action
     * @return mixed
     */
    public function runControllerAction($controller, $action = null)
    {
        $request = royalcms('request');
      
        $method = $this->resolveControllerAction($request, $controller, $action);
        
//        return royalcms()->call($method);
        list($class, $method) = explode('@', $method);

        $dispatcher = royalcms('royalcms.route.dispatcher');

        $route = royalcms('router')->getCurrentRoute();

        return $dispatcher->dispatch($route, $request, $controller, $method);
    }

    /**
     * @param $module
     * @param $controller
     * @param null $action
     * @return mixed
     */
    public function runModuleControllerAction($module, $controller, $action = null)
    {
        return $this->runControllerAction($module.'/'.$controller, $action);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string                                    $controller
     * @param string|null                               $action
     *
     * @return \ReflectionMethod
     */
    protected function resolveControllerAction(Request $request, $controller, $action = null)
    {
        $this->originalController = $controller;
        $this->originalAction = $action;
        
        $controllerPrefix = $this->getControllerPrefix();
        $controllerSuffix = $this->getControllerSuffix();

        // foo/bar:
        // 1. FooController@bar
        // 2. Foo\BarController@index

        if (empty($action)) {
            $action = substr(strrchr($controller, '/'), 1);
            $controller = substr($controller, 0, strlen($controller) - strlen($action) + 1);
        }

        $controller = $this->normalizeName($controller);
        $action = $this->normalizeName($action);
       
        try {
            // firstly, try foo/bar as FooController@bar
            $controllerClass = $controllerPrefix.$controller.$controllerSuffix;
            
            return $this->resolveActionInCertainController($request, $controllerClass, $action);
        } catch (NotFoundHttpException $e) {
            // then, try foo/bar as Foo\BarController@index
            $controllerClass = $controllerPrefix.$controller.'\\'.$action.$controllerSuffix;

            return $this->resolveActionInCertainController($request, $controllerClass, $this->defaultAction);
        }
    }

    protected function getControllerPrefix()
    {
        return config('defaultroutes.controller-prefix', '');
    }

    protected function getControllerSuffix()
    {
        return config('defaultroutes.controller-suffix', '');
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string                                    $controllerClass
     * @param string|null                               $action
     *
     * @return \ReflectionMethod | string
     */
    protected function resolveActionInCertainController(Request $request, $controllerClass, $action)
    {
        $action = $this->normalizeName($action);
        $action = $action ?: $this->defaultAction;

        $httpMethod = $request->getMethod();
        $classMethod = "action{$httpMethod}{$action}";
        
        if (preg_match('/^[_]/i', $this->originalAction)) {
            throw new AccessDeniedHttpException("You are visiting the {$this->originalAction} is to protect the private action");
        }
        else if (!method_exists($controllerClass, $classMethod)) {
            $classMethod = "action{$action}";
            
            if (!method_exists($controllerClass, $classMethod)) {
                $classMethod = $this->originalAction;
                $controllerClass = $this->originalController;
                
                if (!method_exists($controllerClass, $classMethod)) {
                    
                    // classMethod not exists
                    throw new NotFoundHttpException("Action {$controllerClass}@{$classMethod} cannot be found");
                }
            }
        }

        try {
            $reflectionMethod = new \ReflectionMethod($controllerClass, $classMethod);

            // only public method are allowed to access
            if (!$reflectionMethod->isPublic()) {
                throw new AccessDeniedHttpException("Action $action is not allowed");
            }

            return $controllerClass.'@'.$classMethod;
        } catch (\ReflectionException $e) {
            throw new NotFoundHttpException("Action $action cannot be found");
        }
    }

    protected function normalizeName($name)
    {
        // convert foo-bar to FooBar
        $name = implode('', array_map('ucfirst', explode('-', $name)));

        // convert foo_bar to FooBar
        $name = implode('', array_map('ucfirst', explode('_', $name)));

        // convert foot/bar to Foo\Bar
        $name = implode('\\', array_map('ucfirst', explode('/', $name)));

        return $name;
    }
}
