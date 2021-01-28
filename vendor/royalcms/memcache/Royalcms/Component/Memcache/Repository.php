<?php namespace Royalcms\Component\Memcache;

use Closure;
use ArrayAccess;
use Royalcms\Component\Memcache\CommandFactory;

class Repository implements ArrayAccess {
	
	/**
	 * The Server name.
	 */
	protected $hostname;
	
	/**
	 * The Server port.
	 */
	protected $port;
	
	/**
	 * The Server driver.
	 */
	protected $driver;
	
	/**
	 * An array of registered Cache macros.
	 *
	 * @var array
	 */
	protected $macros = array();
	
	
	protected $error;

	/**
	 * Create a new memcache repository.
	 *
	 * @param  string  $hostname
	 * @param  integer  $port
	 * @param  string  $drive
	 * @return void
	 */
	public function __construct($hostname, $port, $driver = null)
	{
		$this->switchServer($hostname, $port, $driver);
	}
	
	public function switchServer($hostname, $port, $driver = null) {
	    $this->hostname = $hostname;
	    $this->port = $port;
        
	    if ($driver) {
	        $this->driver = $driver;
	    } else {
	        if (extension_loaded('memcached')) {
	            $this->driver = 'Memcached';
	        } elseif (extension_loaded('memcache')) {
	            $this->driver = 'Memcache';
	        } else {
	            $this->driver = 'Server';
	        }
	    }
	    
	    $this->error = new DataError();
	    
	    return $this;
	}
	
	/**
	 * Specified drive operation
	 * @param string $driver
	 */
	public function driver($driver)
	{
	    $this->driver = $driver;
	    return $this;
	}
	
	
	/**
	 * Get the Memcahce drive
	 * @return string
	 */
	public function getDriver()
	{
	    return $this->driver;
	}
	
	
	public function getMemcache()
	{
	    return $this->driver->getMemcache();
	}
	
	/**
	 * Send stats command to server
	 * Return the result if successful or false otherwise
	 *
	 * @return Array|Boolean
	 */
	public function stats()
	{
	    return CommandFactory::api($this->driver)->stats($this->hostname, $this->port);
	}
	
	/**
	 * Retrieve slabs stats
	 * Return the result if successful or false otherwise
	 *
	 * @return Array|Boolean
	 */
	public function slabs()
	{
	    return CommandFactory::api($this->driver)->slabs($this->hostname, $this->port);
	}
	
	/**
	 * Send stats settings command to server
	 * Return the result if successful or false otherwise
	 *
	 * @return Array|Boolean
	 */
	public function settings()
	{
	    return CommandFactory::api($this->driver)->settings($this->hostname, $this->port);
	}
	
	/**
	 * Send sizes command to server
	 * Return the result if successful or false otherwise
	 *
	 * @return Array|Boolean
	 */
	public function sizes()
	{
	    return CommandFactory::api($this->driver)->sizes($this->hostname, $this->port);
	}
	
	/**
	 * Send stats cachedump command to server to retrieve slabs items
	 * Return the result if successful or false otherwise
	 *
	 * @param Interger $slab Slab ID
	 *
	 * @return Array|Boolean
	 */
	public function items($slab)
	{
	   return CommandFactory::api($this->driver)->items($this->hostname, $this->port, $slab);
    }
    
    /**
     * Send stats cachedump command to server to retrieve slabs items
     * Return the result if successful or false otherwise
     *
     * @param Interger $slab Slab ID
     * @param Interger $maxnum Max num
     *
     * @return Array|Boolean
     */
    public function cachedump($slab, $maxnum)
    {
        return CommandFactory::api($this->driver)->cachedump($this->hostname, $this->port, $slab, $maxnum);
    }

	/**
	 * Get the specified configuration value.
	 *
	 * @param  string  $key
	 * @param  mixed   $default
	 * @return mixed
	 */
	public function get($key, $default = null)
	{		
		$value = CommandFactory::api($this->driver)->get($this->hostname, $this->port, $key);

		return $value ?: $default;
	}

	/**
	 * Set a given configuration value.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function set($key, $value, $duration = 2592000)
	{		
		return CommandFactory::api($this->driver)->set($this->hostname, $this->port, $key, $value, $duration);
	}
	
	/**
	 * Add an item
	 * Return the result
	 *
	 * @param String $server Hostname
	 * @param Integer $port Hostname Port
	 * @param String $key Key to store
	 * @param Mixed $value Data to store
	 * @param Integer $duration Duration
	 *
	 * @return String
	 */
	public function add($key, $value, $duration = 2592000)
	{
	   return CommandFactory::api($this->driver)->add($this->hostname, $this->port, $key, $value, $duration);
	}
	
	/**
	 * Replace an item
	 * Return the result
	 *
	 * @param String $server Hostname
	 * @param Integer $port Hostname Port
	 * @param String $key Key to store
	 * @param Mixed $value Data to store
	 * @param Integer $duration Duration
	 *
	 * @return String
	 */
	public function replace($key, $value, $duration = 2592000)
	{
	    return CommandFactory::api($this->driver)->replace($this->hostname, $this->port, $key, $value, $duration);
	}
	
	/**
	 * Delete a given configuration value.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function delete($key)
	{
	    return CommandFactory::api($this->driver)->delete($this->hostname, $this->port, $key);
	}
	
	/**
	 * Increment a given configuration value.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function increment($key, $value)
	{
	    return CommandFactory::api($this->driver)->increment($this->hostname, $this->port, $key, $value);
	}
	
	/**
	 * Decrement a given configuration value.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function decrement($key, $value)
	{
	    return CommandFactory::api($this->driver)->decrement($this->hostname, $this->port, $key, $value);
	}
	
	/**
	 * Flush all given configuration value.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function flush($delay)
	{
	    return CommandFactory::api($this->driver)->flush($this->hostname, $this->port, $delay);
	}
	
	/**
     * Search for item
     * Return all the items matching parameters if successful, false otherwise
     *
     * @param String $key Key to search
     * @param String $level Level of Detail
     * @param String $more More action
     *
     * @return array
     */
	public function search($search, $level = false, $more = false)
	{
	    return CommandFactory::api($this->driver)->search($this->hostname, $this->port, $search, $level, $more);
	}
	
	/**
	 * Telnet a given configuration value.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function telnet($key)
	{
	    return CommandFactory::api($this->driver)->telnet($this->hostname, $this->port, $key);
	}
	
	
	public function getResultMessage()
	{
	    return CommandFactory::api($this->driver)->getResultMessage();
	}
	
	
	public function getDataError()
	{
	    return $this->error;
	}


	/**
	 * Determine if the given configuration option exists.
	 *
	 * @param  string  $key
	 * @return bool
	 */
	public function offsetExists($key)
	{
		return $this->get($key) ? true : false;
	}

	/**
	 * Get a configuration option.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function offsetGet($key)
	{
		return $this->get($key);
	}

	/**
	 * Set a configuration option.
	 *
	 * @param  string  $key
	 * @param  mixed  $value
	 * @return void
	 */
	public function offsetSet($key, $value)
	{
		$this->set($key, $value);
	}

	/**
	 * Unset a configuration option.
	 *
	 * @param  string  $key
	 * @return void
	 */
	public function offsetUnset($key)
	{
		$this->set($key, null);
	}
	
	/**
	 * Register a macro with the Cache class.
	 *
	 * @param  string    $name
	 * @param  callable  $callback
	 * @return void
	 */
	public function macro($name, $callback)
	{
	    $this->macros[$name] = $callback;
	}
	
	/**
	 * Handle dynamic calls into macros or pass missing methods to the store.
	 *
	 * @param  string  $method
	 * @param  array   $parameters
	 * @return mixed
	 */
	public function __call($method, $parameters)
	{
	    if (isset($this->macros[$method]))
	    {
	        return call_user_func_array($this->macros[$method], $parameters);
	    }
	    else
	    {
	        return call_user_func_array(array($this->driver, $method), $parameters);
	    }
	}

}
