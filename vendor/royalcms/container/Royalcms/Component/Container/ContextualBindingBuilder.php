<?php

namespace Royalcms\Component\Container;

use Royalcms\Component\Contracts\Container\ContextualBindingBuilder as ContextualBindingBuilderContract;

class ContextualBindingBuilder implements ContextualBindingBuilderContract
{
    /**
     * The underlying container instance.
     *
     * @var \Royalcms\Component\Container\Container
     */
    protected $container;

    /**
     * The concrete instance.
     *
     * @var string
     */
    protected $concrete;

    /**
     * The abstract target.
     *
     * @var string
     */
    protected $needs;

    /**
     * Create a new contextual binding builder.
     *
     * @param  \Royalcms\Component\Container\Container  $container
     * @param  string  $concrete
     * @return void
     */
    public function __construct(Container $container, $concrete)
    {
        $this->concrete = $concrete;
        $this->container = $container;
    }

    /**
     * Define the abstract target that depends on the context.
     *
     * @param  string  $abstract
     * @return $this
     */
    public function needs($abstract)
    {
        $this->needs = $abstract;

        return $this;
    }

    /**
     * Define the implementation for the contextual binding.
     *
     * @param  \Closure|string  $implementation
     * @return void
     */
    public function give($implementation)
    {
        $this->container->addContextualBinding($this->concrete, $this->needs, $implementation);
    }
}
