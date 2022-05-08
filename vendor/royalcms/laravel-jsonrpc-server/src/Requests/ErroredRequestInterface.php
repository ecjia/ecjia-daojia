<?php

namespace Royalcms\Laravel\JsonRpcServer\Requests;

use Royalcms\Laravel\JsonRpcServer\Errors\ErrorInterface;

/**
 * @see ErroredRequest
 */
interface ErroredRequestInterface extends BasicRequestInterface
{
    /**
     * Get request error.
     *
     * @return ErrorInterface
     */
    public function getError(): ErrorInterface;
}
