<?php

namespace Royalcms\Component\Support\Facades;

/**
 * @see \Royalcms\Component\Session\SessionManager
 * @see \Royalcms\Component\Session\Store
 */
class Session extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'session';
    }

    public static function start()
    {
        return royalcms('session.start')->start(royalcms('request'));
    }

    public static function close()
    {
        return royalcms('session.start')->close();
    }
}
