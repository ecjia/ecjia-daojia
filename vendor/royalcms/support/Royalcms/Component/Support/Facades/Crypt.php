<?php

namespace Royalcms\Component\Support\Facades;

/**
 * @see \Royalcms\Component\Encryption\Encrypter
 */
class Crypt extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'encrypter';
    }
}
