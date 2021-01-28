<?php

namespace Royalcms\Component\Pay\Exceptions;

class GatewayException extends Exception
{
    /**
     * Bootstrap.
     *
     * @param string       $message
     * @param array|string $raw
     * @param int|string   $code
     */
    public function __construct($message, $raw = [], $code = 4)
    {
        parent::__construct($message, $raw, $code);
    }
}
