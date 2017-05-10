<?php

namespace Royalcms\Component\Support\Traits;

use Royalcms\Component\Support\Fluent;
use Royalcms\Component\Container\Contracts\Container;

trait CapsuleManagerTrait
{
    /**
     * The current globally used instance.
     *
     * @var object
     */
    protected static $instance;

    /**
     * The container instance.
     *
     * @var \Royalcms\Component\Container\Contracts\Container
     */
    protected $container;

    /**
     * Setup the IoC container instance.
     *
     * @param  \Royalcms\Component\Container\Contracts\Container  $container
     * @return void
     */
    protected function setupContainer(Container $container)
    {
        $this->container = $container;

        if (! $this->container->bound('config')) {
            $this->container->instance('config', new Fluent);
        }
    }

    /**
     * Make this capsule instance available globally.
     *
     * @return void
     */
    public function setAsGlobal()
    {
        static::$instance = $this;
    }

    /**
     * Get the IoC container instance.
     *
     * @return \Royalcms\Component\Container\Contracts\Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Set the IoC container instance.
     *
     * @param  \Royalcms\Component\Container\Contracts\Container  $container
     * @return void
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }
}
