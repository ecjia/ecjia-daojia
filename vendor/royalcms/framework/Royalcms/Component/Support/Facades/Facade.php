<?php namespace Royalcms\Component\Support\Facades;

abstract class Facade {

	/**
	 * The application instance being facaded.
	 *
	 * @var \Royalcms\Component\Foundation\Royalcms
	 */
	protected static $royalcms;

	/**
	 * The resolved object instances.
	 *
	 * @var array
	 */
	protected static $resolvedInstance;

	/**
	 * Hotswap the underlying instance behind the facade.
	 *
	 * @param  mixed  $instance
	 * @return void
	 */
	public static function swap($instance)
	{
		static::$resolvedInstance[static::getFacadeAccessor()] = $instance;

		static::$system->instance(static::getFacadeAccessor(), $instance);
	}

	/**
	 * Get the root object behind the facade.
	 *
	 * @return mixed
	 */
	public static function getFacadeRoot()
	{
		return static::resolveFacadeInstance(static::getFacadeAccessor());
	}

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 *
	 * @throws \RuntimeException
	 */
	protected static function getFacadeAccessor()
	{
		throw new \RuntimeException("Facade does not implement getFacadeAccessor method.");
	}

	/**
	 * Resolve the facade root instance from the container.
	 *
	 * @param  string  $name
	 * @return mixed
	 */
	protected static function resolveFacadeInstance($name)
	{
		if (is_object($name)) return $name;

		if (isset(static::$resolvedInstance[$name]))
		{
			return static::$resolvedInstance[$name];
		}

		return static::$resolvedInstance[$name] = static::$royalcms[$name];
	}

	/**
	 * Clear a resolved facade instance.
	 *
	 * @param  string  $name
	 * @return void
	 */
	public static function clearResolvedInstance($name)
	{
		unset(static::$resolvedInstance[$name]);
	}

	/**
	 * Clear all of the resolved instances.
	 *
	 * @return void
	 */
	public static function clearResolvedInstances()
	{
		static::$resolvedInstance = array();
	}

	/**
	 * Get the system instance behind the facade.
	 *
	 * @return \Royalcms\Component\Foundation\Royalcms
	 */
	public static function getFacadeRoyalcms()
	{
		return static::$royalcms;
	}

	/**
	 * Set the system instance.
	 *
	 * @param  \Royalcms\Component\Foundation\Royalcms  $royalcms
	 * @return void
	 */
	public static function setFacadeRoyalcms($royalcms)
	{
		static::$royalcms = $royalcms;
	}

	/**
	 * Handle dynamic, static calls to the object.
	 *
	 * @param  string  $method
	 * @param  array   $args
	 * @return mixed
	 */
	public static function __callStatic($method, $args)
	{
		$instance = static::getFacadeRoot();

		switch (count($args))
		{
			case 0:
				return $instance->$method();

			case 1:
				return $instance->$method($args[0]);

			case 2:
				return $instance->$method($args[0], $args[1]);

			case 3:
				return $instance->$method($args[0], $args[1], $args[2]);

			case 4:
				return $instance->$method($args[0], $args[1], $args[2], $args[3]);

			default:
				return call_user_func_array(array($instance, $method), $args);
		}
	}

}
