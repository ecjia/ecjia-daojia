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
	}
	
	public function getMemcache()
	{
	    return $this;
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
	function add($server, $port, $key, $value, $duration)
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
	function replace($server, $port, $key, $value, $duration)
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
	    CommandFactory::api($this->driver)->set($this->hostname, $this->port, $key);
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
	    CommandFactory::api($this->driver)->increment($this->hostname, $this->port, $key, $value);
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
	    CommandFactory::api($this->driver)->decrement($this->hostname, $this->port, $key, $value);
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
	    CommandFactory::api($this->driver)->flush_all($this->hostname, $this->port, $delay);
	}
	
	/**
	 * Search a given configuration value.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function search($telnet)
	{
	    CommandFactory::api($this->driver)->search($this->hostname, $this->port, $telnet);
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
	    CommandFactory::api($this->driver)->telnet($this->hostname, $this->port, $key);
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

}
