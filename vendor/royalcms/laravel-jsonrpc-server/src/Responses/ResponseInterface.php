<?php

namespace Royalcms\Laravel\JsonRpcServer\Responses;

/**
 * @see ErrorResponseInterface
 * @see SuccessResponseInterface
 */
interface ResponseInterface
{
    /**
     * Get response identifier.
     *
     * @return int|string|null
     */
    public function getId();
}
