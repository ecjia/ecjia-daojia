<?php


namespace Royalcms\Component\Service;

use Royalcms\Component\Container\Container;
use Royalcms\Component\Contracts\Container\Container as ContainerContract;

class ServiceManager
{

    /**
     * The IoC container instance.
     *
     * @var \Royalcms\Component\Contracts\Container\Container
     */
    protected $container;

    protected $handles = [];


    /**
     * Create a new event dispatcher instance.
     *
     * @param  \Royalcms\Component\Contracts\Container\Container|null  $container
     * @return void
     */
    public function __construct(ContainerContract $container = null)
    {
        $this->container = $container ?: new Container;
    }

    /**
     * @param $tag
     * @param $handle
     */
    public function addService($tag, $app, $handle)
    {
        $this->handles[$tag][$app] = $handle;
    }

    /**
     * @return array
     */
    public function getHandles()
    {
        return $this->handles;
    }

    /**
     * @param $tag
     * @return array|null
     */
    public function getHandleWithTag($tag)
    {
        if ($this->hasHandleWithTag($tag)) {
            return $this->handles[$tag];
        }

        return null;
    }

    /**
     * @param $tag
     * @param $app
     * @return array|null
     */
    public function getHandleWithTagApp($tag, $app)
    {
        if ($this->hasHandleWithTag($tag, $app)) {
            return $this->handles[$tag][$app];
        }

        return null;
    }

    /**
     * @param $tag
     * @param null $app
     * @return bool
     */
    public function hasHandleWithTag($tag, $app = null)
    {
        if (is_null($app)) {
            return array_has($this->handles, $tag);
        }
        else {
            return array_has($this->handles, $tag.'.'.$app);
        }
    }

    /**
     * 指定一个tag和一个app调用服务
     * @param $tag
     * @param $app
     * @param array $params
     */
    public function fire($tag, $app, $params = array())
    {
        $handle = $this->getHandleWithTagApp($tag, $app);
        return $this->handle($handle, $params);
    }

    /**
     * 指定一个tag调用一组服务
     * @param $tag
     * @param array $params
     * @return array
     */
    public function fires($tag, $params = array())
    {
        $handles = $this->getHandleWithTag($tag);

        return collect($handles)->map(function ($handle) use ($params) {
            return $this->handle($handle, $params);
        })->all();
    }

    /**
     * @param $handle
     * @param array $params
     * @return mixed
     */
    public function handle($handle, $params = array())
    {
        $listener = $this->makeListener($handle);
        if (is_null($listener)) {
            return null;
        }

        return call_user_func($this->makeListener($handle), $params);
    }

    /**
     * Register an event listener with the dispatcher.
     *
     * @param  mixed  $listener
     * @return mixed
     */
    public function makeListener($listener)
    {
        return is_string($listener) ? $this->createClassListener($listener) : $listener;
    }

    /**
     * Create a class based listener using the IoC container.
     *
     * @param  mixed  $listener
     * @return callable
     */
    public function createClassListener($listener)
    {
        return $this->createClassCallable($listener, $this->container);
    }

    /**
     * Create the class based event callable.
     *
     * @param  string  $listener
     * @param  \Royalcms\Component\Container\Container  $container
     * @return callable
     */
    protected function createClassCallable($listener, $container)
    {
        list($class, $method) = $this->parseClassCallable($listener);

        if (! class_exists($class)) {
            \RC_Log::info(sprintf("Class %s not extsis.", $class));
            return null;
        }

        if (! $container->isShared($class)) {
            $container->singleton($class);
        }

        return [$container->make($class), $method];
    }

    /**
     * Parse the class listener into class and method.
     *
     * @param  string  $listener
     * @return array
     */
    protected function parseClassCallable($listener)
    {
        $segments = explode('@', $listener);

        return [$segments[0], count($segments) == 2 ? $segments[1] : 'handle'];
    }

}