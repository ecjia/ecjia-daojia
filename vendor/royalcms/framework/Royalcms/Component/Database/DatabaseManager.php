<?php namespace Royalcms\Component\Database;

use Royalcms\Component\Database\Connectors\ConnectionFactory;

class DatabaseManager implements ConnectionResolverInterface {

	/**
	 * The application instance.
	 *
	 * @var \Royalcms\Component\Foundation\Royalcms
	 */
	protected $royalcms;

	/**
	 * The database connection factory instance.
	 *
	 * @var \Royalcms\Component\Database\Connectors\ConnectionFactory
	 */
	protected $factory;

	/**
	 * The active connection instances.
	 *
	 * @var array
	 */
	protected $connections = array();

	/**
	 * The custom connection resolvers.
	 *
	 * @var array
	 */
	protected $extensions = array();

	/**
	 * Create a new database manager instance.
	 *
	 * @param  \Royalcms\Component\Foundation\Royalcms  $royalcms
	 * @param  \Royalcms\Component\Database\Connectors\ConnectionFactory  $factory
	 * @return void
	 */
	public function __construct($royalcms, ConnectionFactory $factory)
	{
		$this->royalcms = $royalcms;
		$this->factory = $factory;
	}

	/**
	 * Get a database connection instance.
	 *
	 * @param  string  $name
	 * @return \Royalcms\Component\Database\Connection
	 */
	public function connection($name = null)
	{
		$name = $name ?: $this->getDefaultConnection();

		// If we haven't created this connection, we'll create it based on the config
		// provided in the application. Once we've created the connections we will
		// set the "fetch mode" for PDO which determines the query return types.
		if ( ! isset($this->connections[$name]))
		{
			$connection = $this->makeConnection($name);

			$this->connections[$name] = $this->prepare($connection);
		}

		return $this->connections[$name];
	}

	/**
	 * Reconnect to the given database.
	 *
	 * @param  string  $name
	 * @return \Royalcms\Component\Database\Connection
	 */
	public function reconnect($name = null)
	{
		$name = $name ?: $this->getDefaultConnection();

		$this->disconnect($name);

		return $this->connection($name);
	}

	/**
	 * Disconnect from the given database.
	 *
	 * @param  string  $name
	 * @return void
	 */
	public function disconnect($name = null)
	{
		$name = $name ?: $this->getDefaultConnection();

		unset($this->connections[$name]);
	}

	/**
	 * Make the database connection instance.
	 *
	 * @param  string  $name
	 * @return \Royalcms\Component\Database\Connection
	 */
	protected function makeConnection($name)
	{
		$config = $this->getConfig($name);

		// First we will check by the connection name to see if an extension has been
		// registered specifically for that connection. If it has we will call the
		// Closure and pass it the config allowing it to resolve the connection.
		if (isset($this->extensions[$name]))
		{
			return call_user_func($this->extensions[$name], $config, $name);
		}

		$driver = $config['driver'];

		// Next we will check to see if an extension has been registered for a driver
		// and will call the Closure if so, which allows us to have a more generic
		// resolver for the drivers themselves which applies to all connections.
		if (isset($this->extensions[$driver]))
		{
			return call_user_func($this->extensions[$driver], $config, $name);
		}

		return $this->factory->make($config, $name);
	}

	/**
	 * Prepare the database connection instance.
	 *
	 * @param  \Royalcms\Component\Database\Connection  $connection
	 * @return \Royalcms\Component\Database\Connection
	 */
	protected function prepare(Connection $connection)
	{
		$connection->setFetchMode($this->royalcms['config']['database.fetch']);

		if ($this->royalcms->bound('events'))
		{
			$connection->setEventDispatcher($this->royalcms['events']);
		}

		// The database connection can also utilize a cache manager instance when cache
		// functionality is used on queries, which provides an expressive interface
		// to caching both fluent queries and Eloquent queries that are executed.
		$royalcms = $this->royalcms;

		$connection->setCacheManager(function() use ($royalcms)
		{
			return $royalcms['cache'];
		});

		// We will setup a Closure to resolve the paginator instance on the connection
		// since the Paginator isn't used on every request and needs quite a few of
		// our dependencies. It'll be more efficient to lazily resolve instances.
		$connection->setPaginator(function() use ($royalcms)
		{
			return $royalcms['paginator'];
		});

		return $connection;
	}

	/**
	 * Get the configuration for a connection.
	 *
	 * @param  string  $name
	 * @return array
	 *
	 * @throws \InvalidArgumentException
	 */
	protected function getConfig($name)
	{
		$name = $name ?: $this->getDefaultConnection();

		// To get the database connection configuration, we will just pull each of the
		// connection configurations and get the configurations for the given name.
		// If the configuration doesn't exist, we'll throw an exception and bail.
		$connections = $this->royalcms['config']['database.connections'];

		if (is_null($config = array_get($connections, $name)))
		{
			throw new \InvalidArgumentException("Database [$name] not configured.");
		}

		return $config;
	}

	/**
	 * Get the default connection name.
	 *
	 * @return string
	 */
	public function getDefaultConnection()
	{
		return $this->royalcms['config']['database.defaultconnection'];
	}

	/**
	 * Set the default connection name.
	 *
	 * @param  string  $name
	 * @return void
	 */
	public function setDefaultConnection($name)
	{
		$this->royalcms['config']['database.defaultconnection'] = $name;
	}

	/**
	 * Register an extension connection resolver.
	 *
	 * @param  string    $name
	 * @param  callable  $resolver
	 * @return void
	 */
	public function extend($name, $resolver)
	{
		$this->extensions[$name] = $resolver;
	}

	/**
	 * Return all of the created connections.
	 *
	 * @return array
	 */
	public function getConnections()
	{
		return $this->connections;
	}

	/**
	 * Dynamically pass methods to the default connection.
	 *
	 * @param  string  $method
	 * @param  array   $parameters
	 * @return mixed
	 */
	public function __call($method, $parameters)
	{
		return call_user_func_array(array($this->connection(), $method), $parameters);
	}

}
