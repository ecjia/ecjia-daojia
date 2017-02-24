<?php namespace Royalcms\Component\Cache;

use Royalcms\Component\Support\Manager;

class CacheManager extends Manager {
    
    /**
     * Get a filesystem instance.
     *
     * @param  string  $name
     * @return \Royalcms\Component\Cache\StoreInterface
     */
    public function drive($name = null)
    {
        $name = $name ?: $this->getDefaultDriver();
        
        return $this->drivers[$name] = $this->get($name);
    }
    
    /**
     * Attempt to get the pool from the file cache.
     *
     * @param  string  $name
     * @return \Royalcms\Component\Cache\StoreInterface
     */
    protected function get($name)
    {
        return isset($this->drivers[$name]) ? $this->drivers[$name] : $this->resolve($name);
    }
    
    /**
     * Resolve the given pool.
     *
     * @param  string  $name
     * @return \Royalcms\Component\Cache\StoreInterface
     */
    protected function resolve($name)
    {
        $config = $this->getConfig($name);
        
        if (isset($this->customCreators[$config['driver']]))
        {
            return $this->callCustomCreator($config);
        }
    
        return $this->{"create".ucfirst($config['driver'])."Driver"}($config);
    }

	/**
	 * Create an instance of the APC cache driver.
	 *
	 * @return \Royalcms\Component\Cache\ApcStore
	 */
	protected function createApcDriver(array $config)
	{
		return $this->repository(new ApcStore(new ApcWrapper, $this->getPrefix()));
	}

	/**
	 * Create an instance of the array cache driver.
	 *
	 * @return \Royalcms\Component\Cache\ArrayStore
	 */
	protected function createArrayDriver(array $config)
	{
		return $this->repository(new ArrayStore);
	}

	/**
	 * Create an instance of the file cache driver.
	 *
	 * @return \Royalcms\Component\Cache\FileStore
	 */
	protected function createFileDriver(array $config)
	{
		$path = $config['path'];

		return $this->repository(new FileStore($this->royalcms['files'], $path));
	}

	/**
	 * Create an instance of the Memcached cache driver.
	 *
	 * @return \Royalcms\Component\Cache\MemcachedStore
	 */
	protected function createMemcachedDriver(array $config)
	{
		$servers = $this->royalcms['config']['cache.memcached'];

		$memcached = $this->royalcms['memcached.connector']->connect($servers);

		return $this->repository(new MemcachedStore($memcached, $this->getPrefix()));
	}

	/**
	 * Create an instance of the WinCache cache driver.
	 *
	 * @return \Royalcms\Component\Cache\WinCacheStore
	 */
	protected function createWincacheDriver(array $config)
	{
		return $this->repository(new WinCacheStore($this->getPrefix()));
	}

	/**
	 * Create an instance of the XCache cache driver.
	 *
	 * @return \Royalcms\Component\Cache\WinCacheStore
	 */
	protected function createXcacheDriver(array $config)
	{
		return $this->repository(new XCacheStore($this->getPrefix()));
	}

	/**
	 * Create an instance of the Redis cache driver.
	 *
	 * @return \Royalcms\Component\Cache\RedisStore
	 */
	protected function createRedisDriver(array $config)
	{
		$redis = $this->royalcms['redis'];

		return $this->repository(new RedisStore($redis, $this->getPrefix()));
	}

	/**
	 * Create an instance of the database cache driver.
	 *
	 * @return \Royalcms\Component\Cache\DatabaseStore
	 */
	protected function createDatabaseDriver(array $config)
	{
		$connection = $this->getDatabaseConnection();

		$encrypter = $this->royalcms['encrypter'];

		// We allow the developer to specify which connection and table should be used
		// to store the cached items. We also need to grab a prefix in case a table
		// is being used by multiple applications although this is very unlikely.
		$table = $this->royalcms['config']['cache.table'];

		$prefix = $this->getPrefix();

		return $this->repository(new DatabaseStore($connection, $encrypter, $table, $prefix));
	}

	/**
	 * Get the database connection for the database driver.
	 *
	 * @return \Royalcms\Component\Database\Connection
	 */
	protected function getDatabaseConnection()
	{
		$connection = $this->royalcms['config']['cache.connection'];

		return $this->royalcms['db']->connection($connection);
	}

	/**
	 * Get the cache "prefix" value.
	 *
	 * @return string
	 */
	public function getPrefix()
	{
		return $this->royalcms['config']['cache.prefix'];
	}

	/**
	 * Set the cache "prefix" value.
	 *
	 * @param  string  $name
	 * @return void
	 */
	public function setPrefix($name)
	{
		$this->royalcms['config']['cache.prefix'] = $name;
	}

	/**
	 * Create a new cache repository with the given implementation.
	 *
	 * @param  \Royalcms\Component\Cache\StoreInterface  $store
	 * @return \Royalcms\Component\Cache\Repository
	 */
	protected function repository(StoreInterface $store)
	{
		return new Repository($store);
	}
	
	/**
	 * Get the filesystem connection configuration.
	 *
	 * @param  string  $name
	 * @return array
	 */
	protected function getConfig($name)
	{
	    return $this->royalcms['config']["cache.drivers.{$name}"];
	}

	/**
	 * Get the default cache driver name.
	 *
	 * @return string
	 */
	public function getDefaultDriver()
	{
		return $this->royalcms['config']['cache.default'];
	}

	/**
	 * Set the default cache driver name.
	 *
	 * @param  string  $name
	 * @return void
	 */
	public function setDefaultDriver($name)
	{
		$this->royalcms['config']['cache.default'] = $name;
	}
	
	/**
	 * Dynamically call the default driver instance.
	 *
	 * @param  string  $method
	 * @param  array   $parameters
	 * @return mixed
	 */
	public function __call($method, $parameters)
	{
	    return call_user_func_array(array($this->drive(), $method), $parameters);
	}

}
