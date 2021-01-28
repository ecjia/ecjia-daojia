<?php

namespace Royalcms\Laravel\JsonRpcServer\Router;

use Exception;
use InvalidArgumentException;

interface RouterInterface
{
    /**
     * Register action for method.
     *
     * @param string          $method_name
     * @param callable|string $do_action
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public function on(string $method_name, $do_action): void;

    /**
     * Determine if method is registered.
     *
     * @param string $method_name
     *
     * @return bool
     */
    public function methodExists(string $method_name): bool;

    /**
     * Handle an RPC request.
     *
     * @param string $method_name
     *
     * @throws Exception
     *
     * @return mixed
     */
    public function call(string $method_name);

    /**
     * Get registered method names.
     *
     * @return array<string>
     */
    public function methods(): array;
}
