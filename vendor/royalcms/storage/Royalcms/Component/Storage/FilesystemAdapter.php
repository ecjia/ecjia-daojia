<?php

namespace Royalcms\Component\Storage;

use Closure;
use BadMethodCallException;
use Royalcms\Component\Error\Facades\Error as RC_Error;

class FilesystemAdapter {

	/**
	 * The Flysystem filesystem implementation.
	 *
	 * @var \Royalcms\Component\Storage\FilesystemBase
	 */
	protected $driver;

	/**
	 * Create a new filesystem adapter instance.
	 *
	 * @param  \Royalcms\Component\Storage\FilesystemBase  $driver
	 * @return void
	 */
	public function __construct(FilesystemBase $driver)
	{
		$this->driver = $driver;
		
		//Define the timeouts for the connections. Only available after the construct is called to allow for per-transport overriding of the default.
		if ( ! defined('FS_CONNECT_TIMEOUT') )
		    define('FS_CONNECT_TIMEOUT', 30);
		if ( ! defined('FS_TIMEOUT') )
		    define('FS_TIMEOUT', 30);
		
		if ( RC_Error::is_error($this->driver->errors) && $this->driver->errors->get_error_code() )
		    return false;
		
		if ( !$this->driver->connect() )
		    return false; //There was an error connecting to the server.
		
		// Set the permission constants if not already set.
		if ( ! defined('FS_CHMOD_DIR') )
		    define('FS_CHMOD_DIR', ( fileperms( SITE_ROOT ) & 0777 | 0755 ) );
		if ( ! defined('FS_CHMOD_FILE') )
		    define('FS_CHMOD_FILE', ( fileperms( SITE_ROOT . 'index.php' ) & 0777 | 0644 ) );
	}
	
	/**
	 * Get the Flysystem driver.
	 *
	 * @return \Royalcms\Component\Storage\FilesystemBase
	 */
	public function getDriver()
	{
	    return $this->driver;
	}
	
	/**
	 * The registered string macros.
	 *
	 * @var array
	 */
	protected static $macros = array();
	
	/**
	 * Register a custom macro.
	 *
	 * @param  string    $name
	 * @param  callable  $macro
	 * @return void
	*/
	public static function macro($name, callable $macro)
	{
	    static::$macros[$name] = $macro;
	}
	
	/**
	 * Checks if macro is registered.
	 *
	 * @param  string  $name
	 * @return bool
	 */
	public static function hasMacro($name)
	{
	    return isset(static::$macros[$name]);
	}
	
	/**
	 * Dynamically handle calls to the class.
	 *
	 * @param  string  $method
	 * @param  array   $parameters
	 * @return mixed
	 *
	 * @throws \BadMethodCallException
	 */
	public static function __callStatic($method, $parameters)
	{
	    if (static::hasMacro($method))
	    {
	        if (static::$macros[$method] instanceof Closure)
	        {
	            return call_user_func_array(Closure::bind(static::$macros[$method], null, get_called_class()), $parameters);
	        }
	        else
	        {
	            return call_user_func_array(static::$macros[$method], $parameters);
	        }
	    }
	
	    throw new BadMethodCallException("Method {$method} does not exist.");
	}
	
	public function __call($method, $parameters) {
	    if (static::hasMacro($method))
	    {
	        if (static::$macros[$method] instanceof Closure)
	        {
	            return call_user_func_array(static::$macros[$method]->bindTo($this, get_class($this)), $parameters);
	        }
	        else
	        {
	            return call_user_func_array(static::$macros[$method], $parameters);
	        }
	    }
	    elseif (method_exists($this->driver, $method))
	    {
	        return call_user_func_array(array($this->driver, $method), $parameters);
	    }
	
	    throw new BadMethodCallException("Method {$method} does not exist.");
	}

}
