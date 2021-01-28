<?php

namespace Royalcms\Laravel\JsonRpcServer\Errors;

interface ErrorInterface
{
    /**
     * Gets the error code.
     *
     * Code may be negative.
     *
     * @return int
     */
    public function getCode();

    /**
     * Gets the error message.
     *
     * @return string
     */
    public function getMessage();

    /**
     * Get additional information about the error.
     *
     * @return array|bool|float|int|mixed|object|string|null
     */
    public function getData();
}
