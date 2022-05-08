<?php

namespace Royalcms\Component\Support\Facades;

use Mockery;
use RuntimeException;
use Mockery\MockInterface;

abstract class Facade extends \Illuminate\Support\Facades\Facade
{
    /**
     * The royalcms instance being facaded.
     *
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected static $royalcms;

    /**
     * Hotswap the underlying instance behind the facade.
     *
     * @param  mixed  $instance
     * @return void
     */
    public static function swap($instance)
    {
        static::$resolvedInstance[static::getFacadeAccessor()] = $instance;

        if (isset(static::$royalcms)) {
            static::$royalcms->instance(static::getFacadeAccessor(), $instance);
        }
    }

    /**
     * Resolve the facade root instance from the container.
     *
     * @param  string|object  $name
     * @return mixed
     */
    protected static function resolveFacadeInstance($name)
    {
        if (is_object($name)) {
            return $name;
        }

        if (isset(static::$resolvedInstance[$name])) {
            return static::$resolvedInstance[$name];
        }

        return static::$resolvedInstance[$name] = static::$royalcms[$name];
    }

    /**
     * Get the application instance behind the facade.
     *
     * @return \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    public static function getFacadeRoyalcms()
    {
        return static::$royalcms;
    }

    /**
     * Set the application instance.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @return void
     */
    public static function setFacadeRoyalcms($royalcms)
    {
        static::$royalcms = $royalcms;
        static::$app = $royalcms;
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
    
        if (! $instance) {
            throw new RuntimeException('A facade root has not been set.');
        }

        switch (count($args)) {
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
                return call_user_func_array([$instance, $method], $args);
        }
    }
}
