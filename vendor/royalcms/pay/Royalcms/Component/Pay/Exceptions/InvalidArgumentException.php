<?php

namespace Royalcms\Component\Pay\Exceptions;

class InvalidArgumentException extends Exception
{
    /**
     * Bootstrap.
     *
     * @param string       $message
     * @param array|string $raw
     * @param int|string   $code
     */
    public function __construct($message, $raw = [], $code = 3)
    {
        parent::__construct($message, $raw, $code);
    }
}
