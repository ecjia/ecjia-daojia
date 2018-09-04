<?php

namespace Royalcms\Component\Support\Facades;

/**
 * @see \Royalcms\Component\Routing\Redirector
 */
class Redirect extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        // If the session is set on the application instance, we'll inject it into
        // the redirector instance. This allows the redirect responses to allow
        // for the quite convenient "with" methods that flash to the session.
        if (isset(static::$royalcms['session.store'])) {
            static::$royalcms['redirect']->setSession(static::$royalcms['session.store']);
        }

        return 'redirect';
    }
}
