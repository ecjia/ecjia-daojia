<?php

namespace Royalcms\Laravel\JsonRpcServer\MethodParameters;

/**
 * @see \Royalcms\Laravel\JsonRpcServer\Router\Router::call
 *
 * DI is allowed in constructors.
 */
interface MethodParametersInterface
{
    /**
     * Parse passed into method parameters.
     *
     * IMPORTANT: This method will be called automatically by RPC router before injecting into controller.
     *
     * @param array<mixed>|object|null $params
     *
     * @return void
     */
    public function parse($params): void;
}
