<?php


namespace Royalcms\Laravel\JsonRpcServer\Http\Middleware;


use Closure;
use Royalcms\Laravel\JsonRpcServer\Http\AuthUser\AuthUser;
use Royalcms\Laravel\JsonRpcServer\Http\AuthUser\AuthUserInterface;

class HttpBasicAuthenticated
{
    private static $realm = 'Private';

    public function handle($request, Closure $next)
    {
        if (!self::isAuthenticated($request)) {
            self::errorUnauthenticated();
        }

        return $next($request);
    }

    private static function isAuthenticated($request)
    {
        $username = $request->server('PHP_AUTH_USER', null);
        $password = $request->server('PHP_AUTH_PW', null);

        // This example is vulnerable to a timing attack and uses a plaintext password
        // The "password_verify" function can protect you from those issues:
        // http://php.net/manual/en/function.password-verify.php
        return app(AuthUserInterface::class)->verify($username, $password);
    }

    private static function errorUnauthenticated()
    {
        header('WWW-Authenticate: Basic realm="'. self::$realm . '"');
        header('HTTP/1.1 401 Unauthorized');
        exit();
    }

}

