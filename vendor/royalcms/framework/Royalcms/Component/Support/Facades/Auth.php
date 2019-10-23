<?php

namespace Royalcms\Component\Support\Facades;

/**
 * @see \Royalcms\Component\Auth\AuthManager
 * @see \Royalcms\Component\Auth\Guard
 */
class Auth extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'auth';
    }
}
