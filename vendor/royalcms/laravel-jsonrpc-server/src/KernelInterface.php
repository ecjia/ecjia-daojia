<?php

namespace Royalcms\Laravel\JsonRpcServer;

use Royalcms\Laravel\JsonRpcServer\Requests\RequestsStackInterface;
use Royalcms\Laravel\JsonRpcServer\Responses\ResponsesStackInterface;

interface KernelInterface
{
    /**
     * Handle an incoming RPC request.
     *
     * @param RequestsStackInterface $requests
     *
     * @return ResponsesStackInterface
     */
    public function handle(RequestsStackInterface $requests): ResponsesStackInterface;
}
