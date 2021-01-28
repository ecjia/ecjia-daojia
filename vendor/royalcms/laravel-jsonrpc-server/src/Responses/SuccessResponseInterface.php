<?php

namespace Royalcms\Laravel\JsonRpcServer\Responses;

/**
 * @see SuccessResponse
 */
interface SuccessResponseInterface extends ResponseInterface
{
    /**
     * Get response result data.
     *
     * @return array|bool|float|int|mixed|object|string|null
     */
    public function getResult();
}
