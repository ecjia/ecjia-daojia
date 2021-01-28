<?php

namespace Royalcms\Laravel\JsonRpcServer\Responses;

use Royalcms\Laravel\JsonRpcServer\Errors\ErrorInterface;

/**
 * @see ErrorResponse
 */
interface ErrorResponseInterface extends ResponseInterface
{
    /**
     * Get response error data.
     *
     * @return ErrorInterface
     */
    public function getError(): ErrorInterface;
}
