<?php 

namespace Royalcms\Component\Cache;

use Closure;
use InvalidArgumentException;
use Royalcms\Component\Cache\Contracts\Store;
use Royalcms\Component\Cache\Contracts\Factory as FactoryContract;

class CacheManager implements FactoryContract
{
    /**
     * The royalcms instance.
     *
     * @var \Royalcms\Component\Foundation\Royalcms
     */
    protected $royalcms;
    
    /**
     * The array of resolved cache stores.
     *
     * @var array
     */
    protected $stores = [];
    
    /**
     * The registered custom driver creators.
     *
     * @var array
     */
    protected $customCreators = [];
    
    /**
     * Create a new Cache manager instance.
     *
     * @param  \Royalcms\Component\Foundation\Royalcms $royalcms
     * @return void
     */
    public function __construct($royalcms)
    {
        $this->royalcms = $royalcms;
    }
    
    /**
     * Get a cache store instance by name.
     *
     * @param  string|null  $name
     * @return mixed
     */
    public function store($name = null)
    {
        $name = $name ?: $this->getDefaultDriver();
        
        return $this->stores[$name] = $this->get($name);
    }
    
    /**
	 * Get a cache driver instance.
	 *
	 * @param  string  $driver
	 * @return mixed
	 */
	public function driver($driver = null)
	{
		return $this->store($driver);
	}
    
    /**
     * Attempt to get the pool from the file cache.
     *
     * @param  string  $name
     * @return \Royalcms\Component\Cache\Contracts\Repository
     */
    protected function get($name)
    {
        return isset($this->drivers[$name]) ? $this->drivers[$name] : $this->resolve($name);
    }
    
    /**
     * Resolve the given pool.
     *
     * @param  string  $name
     * @return \Royalcms\Component\Cache\Contracts\Repository
     */
    protected function resolve($name)
    {
        $config = $this->getConfig($name);
        
        if (is_null($config))
        {
            throw new InvalidArgumentException("Cache store [{$name}] is not defined.");
        }
        
        if (isset($this->customCreators[$config['driver']]))
        {
            return $this->callCustomCreator($config);
        }
    
        return $this->{"create".ucfirst($config['driver'])."Driver"}($config);
    }
    
    /**
     * Call a custom driver creator.
     *
     * @param  array  $config
     * @return mixed
     */
    protected function callCustomCreator(array $config)
    {
        return $this->customCreators[$config['driver']]($this->app, $config);
    }

	/**
	 * Create an instance of the APC cache driver.
	 *
	 * @return \Royalcms\Component\Cache\ApcStore
	 */
	protected function createApcDriver(array $config)
	{
	    $prefix = $this->getPrefix($config);
	    
	    return $this->repository(new ApcStore(new ApcWrapper, $prefix));
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
	    $prefix = $this->getPrefix($config);

	    $memcached = $this->royalcms['memcached.connector']->connect($config['servers']);

	    return $this->repository(new MemcachedStore($memcached, $prefix));
	}
	
	/**
	 * Create an instance of the Null cache driver.
	 *
	 * @return \Royalcms\Component\Cache\NullStore
	 */
	protected function createNullDriver()
	{
	    return $this->repository(new NullStore);
	}

	/**
	 * Create an instance of the WinCache cache driver.
	 *
	 * @return \Royalcms\Component\Cache\WinCacheStore
	 */
	protected function createWincacheDriver(array $config)
	{
	    return $this->repository(new WinCacheStore($this->getPrefix($config)));
	}

	/**
	 * Create an instance of the XCache cache driver.
	 *
	 * @return \Royalcms\Component\Cache\WinCacheStore
	 */
	protected function createXcacheDriver(array $config)
	{
	    return $this->repository(new XCacheStore($this->getPrefix($config)));
	}

	/**
	 * Create an instance of the Redis cache driver.
	 *
	 * @return \Royalcms\Component\Cache\RedisStore
	 */
	protected function createRedisDriver(array $config)
	{
		$redis = $this->royalcms['redis'];
		
		$connection = array_get($config, 'connection', 'default') ?: 'default';

		return $this->repository(new RedisStore($redis, $this->getPrefix($config), $connection));
	}

	/**
	 * Create an instance of the database cache driver.
	 *
	 * @return \Royalcms\Component\Cache\DatabaseStore
	 */
	protected function createDatabaseDriver(array $config)
	{
	    $connection = $this->royalcms['db']->connection(array_get($config, 'connection'));

		$encrypter = $this->royalcms['encrypter'];

		// We allow the developer to specify which connection and table should be used
		// to store the cached items. We also need to grab a prefix in case a table
		// is being used by multiple applications although this is very unlikely.
		$table = $config['table'];

		$prefix = $this->getPrefix($config);

		return $this->repository(new DatabaseStore($connection, $encrypter, $table, $prefix));
	}
	
	/**
	 * Create a new cache repository with the given implementation.
	 *
	 * @param  \Royalcms\Component\Cache\Contracts\Store  $store
	 * @return \Royalcms\Component\Cache\Repository
	 */
	public function repository(Store $store)
	{
	    $repository = new Repository($store);
	    
	    if ($this->royalcms->bound('Royalcms\Component\Events\Contracts\Dispatcher'))
	    {
	        $repository->setEventDispatcher(
	            $this->royalcms['Royalcms\Component\Events\Contracts\Dispatcher']
	            );
	    }
	    
	    return $repository;
	}

	/**
	 * Get the cache "prefix" value.
	 *
	 * @return string
	 */
	public function getPrefix(array $config)
	{
	    return array_get($config, 'prefix') ?: $this->royalcms['config']['cache.prefix'];
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
	 * Get the filesystem connection configuration.
	 *
	 * @param  string  $name
	 * @return array
	 */
	protected function getConfig($name)
	{
	    return $this->royalcms['config']["cache.stores.{$name}"];
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
	 * Register a custom driver creator Closure.
	 *
	 * @param  string    $driver
	 * @param  \Closure  $callback
	 * @return $this
	 */
	public function extend($driver, Closure $callback)
	{
	    $this->customCreators[$driver] = $callback;
	    
	    return $this;
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
	    return call_user_func_array(array($this->store(), $method), $parameters);
	}

}
