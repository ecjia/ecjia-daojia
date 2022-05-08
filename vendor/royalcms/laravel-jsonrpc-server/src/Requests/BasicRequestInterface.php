<?php

namespace Royalcms\Laravel\JsonRpcServer\Requests;

/**
 * @see RequestInterface
 * @see ErroredRequestInterface
 */
interface BasicRequestInterface
{
    /**
     * Get request identifier.
     *
     * @return int|string|null
     */
    public function getId();
}
