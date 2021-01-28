<?php

namespace Royalcms\Component\Support;

use Closure;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionMethod;

abstract class Manager extends \Illuminate\Support\Manager
{
    /**
     * The application instance.
     *
     * @var \Royalcms\Component\Foundation\Royalcms
     */
    protected $royalcms;

    /**
     * Create a new manager instance.
     *
     * @param  \Royalcms\Component\Foundation\Royalcms  $royalcms
     * @return void
     */
    public function __construct($royalcms)
    {
        parent::__construct($royalcms);

        $this->royalcms = $royalcms;
    }

    /**
     * Mix another object into the class.
     *
     * @royalcms 6.0.0
     * @param  object  $mixin
     * @param  bool  $replace
     * @return void
     *
     * @throws \ReflectionException
     */
    public function mixin($mixin, $replace = true)
    {
        $methods = (new ReflectionClass($mixin))->getMethods(
            ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_PROTECTED
        );

        foreach ($methods as $method) {
            if ($replace || ! isset($this->customCreators[$method->name])) {
                $method->setAccessible(true);
                $this->extend($method->name, $method->invoke($mixin));
            }
        }
    }

    /**
     * Will create the instances.
     *
     * @royalcms 6.0.0
     * @param $driver
     */
    public function resetDriver($driver)
    {
        // If the given driver has not been created before, we will create the instances
        // here and cache it so we can return it next time very quickly. If there is
        // already a driver created by this name, we'll just return that instance.
        if (isset($this->drivers[$driver])) {
            unset($this->drivers[$driver]);
            $this->drivers[$driver] = $this->createDriver($driver);
        }
    }

}
