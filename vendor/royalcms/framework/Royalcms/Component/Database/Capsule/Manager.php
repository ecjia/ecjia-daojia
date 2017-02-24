<?php namespace Royalcms\Component\Database\Capsule;

use PDO;
use Royalcms\Component\Support\Fluent;
use Royalcms\Component\Event\Dispatcher;
use Royalcms\Component\Cache\CacheManager;
use Royalcms\Component\Container\Container;
use Royalcms\Component\Database\DatabaseManager;
use Royalcms\Component\Database\Eloquent\Model as Eloquent;
use Royalcms\Component\Database\Connectors\ConnectionFactory;

class Manager {

	/**
	 * The current globally used instance.
	 *
	 * @var \Royalcms\Component\Database\Capsule\Manager
	 */
	protected static $instance;

	/**
	 * The database manager instance.
	 *
	 * @var \Royalcms\Component\Database\DatabaseManager
	 */
	protected $manager;

	/**
	 * The container instance.
	 *
	 * @var \Royalcms\Component\Container\Container 
	 */
	protected $container;

	/**
	 * Create a new database capsule manager.
	 *
	 * @param  \Royalcms\Component\Container\Container|null  $container
	 * @return void
	 */
	public function __construct(Container $container = null)
	{
		$this->setupContainer($container);

		// Once we have the container setup, we will setup the default configuration
		// options in the container "config" binding. This will make the database
		// manager behave correctly since all the correct binding are in place.
		$this->setupDefaultConfiguration();

		$this->setupManager();
	}

	/**
	 * Setup the IoC container instance.
	 *
	 * @param  \Royalcms\Component\Container\Container|null  $container
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
	 * Setup the default database configuration options.
	 *
	 * @return void
	 */
	protected function setupDefaultConfiguration()
	{
		$this->container['config']['database.fetch'] = PDO::FETCH_ASSOC;

		$this->container['config']['database.defaultconnection'] = 'default';
	}

	/**
	 * Build the database manager instance.
	 *
	 * @return void
	 */
	protected function setupManager()
	{
		$factory = new ConnectionFactory($this->container);

		$this->manager = new DatabaseManager($this->container, $factory);
	}

	/**
	 * Get a connection instance from the global manager.
	 *
	 * @param  string  $connection
	 * @return \Royalcms\Component\Database\Connection
	 */
	public static function connection($connection = null)
	{
		return static::$instance->getConnection($connection);
	}

	/**
	 * Get a fluent query builder instance.
	 *
	 * @param  string  $table
	 * @param  string  $connection
	 * @return \Royalcms\Component\Database\Query\Builder
	 */
	public static function table($table, $connection = null)
	{
		return static::$instance->connection($connection)->table($table);
	}

	/**
	 * Get a schema builder instance.
	 *
	 * @param  string  $connection
	 * @return \Royalcms\Component\Database\Schema\Builder
	 */
	public static function schema($connection = null)
	{
		return static::$instance->connection($connection)->getSchemaBuilder();
	}

	/**
	 * Get a registered connection instance.
	 *
	 * @param  string  $name
	 * @return \Royalcms\Component\Database\Connection
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
		$connections = $this->container['config']['database.connections'];

		$connections[$name] = $config;

		$this->container['config']['database.connections'] = $connections;
	}

	/**
	 * Bootstrap Eloquent so it is ready for usage.
	 *
	 * @return void
	 */
	public function bootEloquent()
	{
		Eloquent::setConnectionResolver($this->manager);

		// If we have an event dispatcher instance, we will go ahead and register it
		// with the Eloquent ORM, allowing for model callbacks while creating and
		// updating "model" instances; however, if it not necessary to operate.
		$dispatcher = $this->getEventDispatcher();
		if ($dispatcher)
		{
			Eloquent::setEventDispatcher($dispatcher);
		}
	}

	/**
	 * Set the fetch mode for the database connections.
	 *
	 * @param  int  $fetchMode
	 * @return \Royalcms\Component\Database\Capsule\Manager
	 */
	public function setFetchMode($fetchMode)
	{
		$this->container['config']['database.fetch'] = $fetchMode;

		return $this;
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
	 * Get the database manager instance.
	 *
	 * @return \Royalcms\Component\Database\Manager
	 */
	public function getDatabaseManager()
	{
		return $this->manager;
	}

	/**
	 * Get the current event dispatcher instance.
	 *
	 * @return \Royalcms\Component\Event\Dispatcher
	 */
	public function getEventDispatcher()
	{
		if ($this->container->bound('events'))
		{
			return $this->container['events'];
		}
	}

	/**
	 * Set the event dispatcher instance to be used by connections.
	 *
	 * @param  \Royalcms\Component\Event\Dispatcher  $dispatcher
	 * @return void
	 */
	public function setEventDispatcher(Dispatcher $dispatcher)
	{
		$this->container->instance('events', $dispatcher);
	}

	/**
	 * Get the current cache manager instance.
	 *
	 * @return \Royalcms\Component\Cache\Manager
	 */
	public function getCacheManager()
	{
		if ($this->container->bound('cache'))
		{
			return $this->container['cache'];
		}
	}

	/**
	 * Set the cache manager to be used by connections.
	 *
	 * @param  \Royalcms\Component\Cache\CacheManager  $cache
	 * @return void
	 */
	public function setCacheManager(CacheManager $cache)
	{
		$this->container->instance('cache', $cache);
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
	 * @param  \Royalcms\Component\Container\Container  $container
	 * @return void
	 */
	public function setContainer(Container $container)
	{
		$this->container = $container;
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
