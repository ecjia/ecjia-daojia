<?php

namespace Royalcms\Component\Error\Facades;

use Royalcms\Component\Support\Facades\Facade;

/**
 * @see \Royalcms\Component\Error\Error 
 */
class Error extends Facade
{

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
    {
	    return 'error';
	}

	
	/**
	 * Create a new RC_Error instance.
	 * 
	 * If code parameter is empty then nothing will be done. It is possible to
	 * add multiple messages to the same code, but with other methods in the
	 * class.
	 *
	 * All parameters are optional, but if the code parameter is set, then the
	 * data parameter is optional.
	 * 
	 * @since 4.1.0
	 *
	 * @param string|int $code Error code
	 * @param string $message Error message
	 * @param mixed $data Optional. Error data.
	 * @return RC_Error (\Royalcms\Component\Error\Error)
	 */
	public static function make($code = '', $message = '', $data = '')
	{
	    return new \Royalcms\Component\Error\Error($code, $message, $data);
	}
	
	/**
	 * Check whether variable is a Royalcms Error.
	 *
	 * Returns true if $thing is an object of the WP_Error class.
	 *
	 * @since 3.1.0
	 *
	 * @param mixed $thing Check if unknown variable is a RC_Error object.
	 * @return bool True, if RC_Error. False, if not RC_Error.
	 */
	public static function is_error($thing) {
	    if ( is_object($thing) && is_a($thing, '\Royalcms\Component\Error\Error') )
	        return true;
	    return false;
	}
}
