<?php

namespace Royalcms\Component\Support\Facades;

/**
 * @method static mixed guard(string|null $name = null)
 * @method static void shouldUse(string $name);
 * @method static bool check()
 * @method static bool guest()
 * @method static \Illuminate\Contracts\Auth\Authenticatable|null user()
 * @method static int|string|null id()
 * @method static bool validate(array $credentials = [])
 * @method static void setUser(\Illuminate\Contracts\Auth\Authenticatable $user)
 * @method static bool attempt(array $credentials = [], bool $remember = false)
 * @method static bool once(array $credentials = [])
 * @method static void login(\Illuminate\Contracts\Auth\Authenticatable $user, bool $remember = false)
 * @method static \Illuminate\Contracts\Auth\Authenticatable loginUsingId(mixed $id, bool $remember = false)
 * @method static bool onceUsingId(mixed $id)
 * @method static bool viaRemember()
 * @method static void logout()
 * @method static \Symfony\Component\HttpFoundation\Response|null onceBasic(string $field = 'email',array $extraConditions = [])
 * @method static bool|null logoutOtherDevices(string $password, string $attribute = 'password')
 * @method static \Illuminate\Contracts\Auth\UserProvider|null createUserProvider(string $provider = null)
 * @method static \Illuminate\Auth\AuthManager extend(string $driver, \Closure $callback)
 * @method static \Illuminate\Auth\AuthManager provider(string $name, \Closure $callback)
 *
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
