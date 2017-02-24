<?php namespace Royalcms\Component\Queue\Capsule;

use Royalcms\Component\Support\Fluent;
use Royalcms\Component\Queue\QueueManager;
use Royalcms\Component\Container\Container;
use Royalcms\Component\Queue\QueueServiceProvider;

class Manager {

    /**
     * The current globally used instance.
     *
     * @var \Royalcms\Component\Queue\Capsule\Manager
     */
    protected static $instance;

    /**
     * The queue manager instance.
     *
     * @var \Royalcms\Component\Queue\QueueManager
     */
    protected $manager;

    /**
     * Create a new queue capsule manager.
     *
     * @param  \Royalcms\Component\Container\Container  $container
     * @return void
     */
    public function __construct(Container $container = null)
    {
        $this->setupContainer($container);

        // Once we have the container setup, we will setup the default configuration
        // options in the container "config" bindings. This just makes this queue
        // manager behave correctly since all the correct binding are in place.
        $this->setupDefaultConfiguration();

        $this->setupManager();

        $this->registerConnectors();
    }

    /**
     * Setup the IoC container instance.
     *
     * @param  \Royalcms\Component\Container\Container  $container
     * @return void
     */
    protected function setupContainer($container)
    {
        $this->container = $container ?: new Container;

        if ( ! $this->container->bound('config'))
        {
            $this->container->instance('config', new Fluent);
        }
    }

    /**
     * Setup the default queue configuration options.
     *
     * @return void
     */
    protected function setupDefaultConfiguration()
    {
        $this->container['config']['queue.default'] = 'default';
    }

    /**
     * Build the queue manager instance.
     *
     * @return void
     */
    protected function setupManager()
    {
        $this->manager = new QueueManager($this->container);
    }

    /**
     * Register the default connectors that the component ships with.
     *
     * @return void
     */
    protected function registerConnectors()
    {
        $provider = new QueueServiceProvider($this->container);

        $provider->registerConnectors($this->manager);
    }

    /**
     * Get a connection instance from the global manager.
     *
     * @param  string  $connection
     * @return \Royalcms\Component\Queue\QueueInterface
     */
    public static function connection($connection = null)
    {
        return static::$instance->getConnection($connection);
    }

    /**
     * Push a new job onto the queue.
     *
     * @param  string  $job
     * @param  mixed   $data
     * @param  string  $queue
     * @param  string  $connection
     * @return mixed
     */
    public static function push($job, $data = '', $queue = null, $connection = null)
    {
        return static::$instance->connection($connection)->push($job, $data, $queue);
    }

    /**
     * Push a new an array of jobs onto the queue.
     *
     * @param  array   $jobs
     * @param  mixed   $data
     * @param  string  $queue
     * @param  string  $connection
     * @return mixed
     */
    public static function bulk($jobs, $data = '', $queue = null, $connection = null)
    {
        return static::$instance->connection($connection)->bulk($jobs, $data, $queue);
    }

    /**
     * Push a new job onto the queue after a delay.
     *
     * @param  \DateTime|int  $delay
     * @param  string  $job
     * @param  mixed   $data
     * @param  string  $queue
     * @param  string  $connection
     * @return mixed
     */
    public static function later($delay, $job, $data = '', $queue = null, $connection = null)
    {
        return static::$instance->connection($connection)->later($delay, $job, $data, $queue);
    }

    /**
     * Get a registered connection instance.
     *
     * @param  string  $name
     * @return \Royalcms\Component\Queue\QueueInterface
     */
    public function getConnection($name = null)
    {
        return $this->manager->connection($name);
    }

    /**
     * Register a connection with the manager.
     *
     * @param  array   $config
     * @param  string  $name
     * @return void
     */
    public function addConnection(array $config, $name = 'default')
    {
        $this->container['config']["queue.connections.{$name}"] = $config;
    }

    /**
     * Make this capsule instance available globally.
     *
     * @return void
     */
    public function setAsGlobal()
    {
        static::$instance = $this;
    }

    /**
     * Get the queue manager instance.
     *
     * @return \Royalcms\Component\Queue\Manager
     */
    public function getQueueManager()
    {
        return $this->manager;
    }

    /**
     * Get the IoC container instance.
     *
     * @return \Royalcms\Component\Container\Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Set the IoC container instance.
     *
     * @param  \Illuminate\Container\Container  $container
     * @return void
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Pass dynamic instance methods to the manager.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array(array($this->manager, $method), $parameters);
    }

    /**
     * Dynamically pass methods to the default connection.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return call_user_func_array(array(static::connection(), $method), $parameters);
    }

}
