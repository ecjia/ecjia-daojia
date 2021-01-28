<?php


namespace Ecjia\Kernel\Http\Middleware;


use Closure;

class ForceSecureRequests
{

    public function handle($request, Closure $next)
    {
        if (env('HTTPS')) {
            $request->server->set('HTTPS', env('HTTPS'));
        }

        return $next($request);
    }

}