<?php

declare(strict_types=1);

namespace Royalcms\Laravel\JsonRpcServer\Router;

use Closure;
use InvalidArgumentException;
use Illuminate\Contracts\Container\Container;

class Router implements RouterInterface
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var array<callable|string>
     */
    protected $map = [];

    /**
     * Router constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function on(string $method_name, $do_action): void
    {
        if (\is_callable($do_action)) {
            $this->map[$method_name] = Closure::fromCallable($do_action);
        } elseif (\is_string($do_action)) {
            $this->map[$method_name] = $do_action;
        } else {
            throw new InvalidArgumentException(
                'Wrong action passed. It should be a class name with action (like \\My\\Class@method) or callable.'
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function call(string $method_name)
    {
        if (! $this->methodExists($method_name)) {
            throw new InvalidArgumentException("Method [{$method_name}] does not exists");
        }

        // Make method calling
        return $this->container->call($this->map[$method_name]);
    }

    /**
     * {@inheritdoc}
     */
    public function methodExists(string $method_name): bool
    {
        return \in_array($method_name, $this->methods(), true);
    }

    /**
     * {@inheritdoc}
     */
    public function methods(): array
    {
        return \array_keys($this->map);
    }
}
