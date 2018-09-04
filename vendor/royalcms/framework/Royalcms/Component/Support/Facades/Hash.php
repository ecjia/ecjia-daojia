<?php

namespace Royalcms\Component\Support\Facades;

/**
 * @see \Royalcms\Component\Hashing\BcryptHasher
 */
class Hash extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'hash';
    }
}
