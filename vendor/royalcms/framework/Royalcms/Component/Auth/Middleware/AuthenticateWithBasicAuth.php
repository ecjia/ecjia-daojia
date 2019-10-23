<?php

namespace Royalcms\Component\Auth\Middleware;

use Closure;
use Royalcms\Component\Contracts\Auth\Guard;

class AuthenticateWithBasicAuth
{
    /**
     * The guard instance.
     *
     * @var \Royalcms\Component\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Royalcms\Component\Contracts\Auth\Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Royalcms\Component\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $this->auth->basic() ?: $next($request);
    }
}
