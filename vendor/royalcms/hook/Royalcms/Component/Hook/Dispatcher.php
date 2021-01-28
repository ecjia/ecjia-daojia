<?php


namespace Royalcms\Component\Hook;

use Royalcms\Component\Container\Container;
use Royalcms\Component\Contracts\Container\Container as ContainerContract;

class Dispatcher
{

    /**
     * The IoC container instance.
     *
     * @var \Royalcms\Component\Contracts\Container\Container
     */
    protected $container;

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
     * Register an event subscriber with the dispatcher.
     *
     * @param  object|string  $subscriber
     * @return void
     */
    public function subscribe($subscriber)
    {
        $subscriber = $this->resolveSubscriber($subscriber);

        $subscriber->subscribe($this);
    }

    /**
     * Resolve the subscriber instance.
     *
     * @param  object|string  $subscriber
     * @return mixed
     */
    protected function resolveSubscriber($subscriber)
    {
        $container = $this->container;

        if (is_string($subscriber)) {

            if (! $container->isShared($subscriber)) {
                $container->singleton($subscriber);
            }

            return $container->make($subscriber);
        }

        return $subscriber;
    }

    /**
     * Parse the class listener into class and method.
     *
     * @param  string|array  $listener
     * @return array
     */
    protected function parseListenerWithAcceptedArgs($listener)
    {
        if (is_array($listener)) {
            if (! isset($listener[1])) {
                $listener[1] = null;
            }
            if (! isset($listener[2])) {
                $listener[2] = null;
            }
            list($class, $priority, $accepted_args) = $listener;
            $priority = $priority ?: 10;
            $accepted_args = $accepted_args ?: 1;
        }
        else {
            $class = $listener;
            $priority = 10;
            $accepted_args = 1;
        }

        return [$class, $priority, $accepted_args];
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


    /**
     * add hook action
     */
    public function addAction($event, $hooker, $assign_priority = null, $assign_accepted_args = null)
    {
        list($class, $priority, $accepted_args) = $this->parseListenerWithAcceptedArgs($hooker);

        if ($assign_priority) {
            $priority = $assign_priority;
        }

        if ($assign_accepted_args) {
            $accepted_args = $assign_accepted_args;
        }

        royalcms('hook')->add_action($event, $this->makeListener($class), $priority, $accepted_args);
    }

    /**
     * remove hook action
     */
    public function removeAction($event, $hooker, $assign_priority = null)
    {
        list($class, $priority, $accepted_args) = $this->parseListenerWithAcceptedArgs($hooker);

        if ($assign_priority) {
            $priority = $assign_priority;
        }

        royalcms('hook')->remove_action($event, $this->makeListener($class), $priority);
    }

    /**
     * add hook filter
     */
    public function addFilter($event, $hooker, $assign_priority = null, $assign_accepted_args = null)
    {
        list($class, $priority, $accepted_args) = $this->parseListenerWithAcceptedArgs($hooker);

        if ($assign_priority) {
            $priority = $assign_priority;
        }

        if ($assign_accepted_args) {
            $accepted_args = $assign_accepted_args;
        }

        royalcms('hook')->add_filter($event, $this->makeListener($class), $priority, $accepted_args);
    }

    /**
     * remove hook filter
     */
    public function removeFilter($event, $hooker, $assign_priority = null)
    {
        list($class, $priority, $accepted_args) = $this->parseListenerWithAcceptedArgs($hooker);

        if ($assign_priority) {
            $priority = $assign_priority;
        }

        royalcms('hook')->remove_filter($event, $this->makeListener($class), $priority);
    }

}