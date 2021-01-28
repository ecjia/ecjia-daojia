<?php

declare(strict_types=1);

namespace Royalcms\Laravel\JsonRpcServer;

use Illuminate\Support\Facades\Facade;
use Royalcms\Laravel\JsonRpcServer\Router\RouterInterface;
use Royalcms\Laravel\JsonRpcServer\Requests\RequestInterface as RPCRequest;

/**
 * @method static void on(string $method_name, $do_action)
 * @method static bool methodExists(string $method_name)
 * @method static mixed call(RPCRequest $request)
 * @method static array<string> methods()
 *
 * @see \Royalcms\Laravel\JsonRpcServer\Router\RouterInterface
 * @see \Royalcms\Laravel\JsonRpcServer\Router\Router
 */
class RpcRouter extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return RouterInterface::class;
    }
}
