<?php

namespace Royalcms\Component\Support\Facades;

/**
 * @method static \Illuminate\Http\RedirectResponse home(int $status = 302)
 * @method static \Illuminate\Http\RedirectResponse back(int $status = 302, array $headers = [], $fallback = false)
 * @method static \Illuminate\Http\RedirectResponse refresh(int $status = 302, array $headers = [])
 * @method static \Illuminate\Http\RedirectResponse guest(string $path, int $status = 302, array $headers = [], bool $secure = null)
 * @method static \Illuminate\Http\RedirectResponse intended(string $default = '/', int $status = 302, array $headers = [], bool $secure = null)
 * @method static \Illuminate\Http\RedirectResponse to(string $path, int $status = 302, array $headers = [], bool $secure = null)
 * @method static \Illuminate\Http\RedirectResponse away(string $path, int $status = 302, array $headers = [])
 * @method static \Illuminate\Http\RedirectResponse secure(string $path, int $status = 302, array $headers = [])
 * @method static \Illuminate\Http\RedirectResponse route(string $route, array $parameters = [], int $status = 302, array $headers = [])
 * @method static \Illuminate\Http\RedirectResponse action(string $action, array $parameters = [], int $status = 302, array $headers = [])
 * @method static \Illuminate\Routing\UrlGenerator getUrlGenerator()
 * @method static void setSession(\Illuminate\Session\Store $session)
 * 
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
