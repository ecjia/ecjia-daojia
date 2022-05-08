<?php


namespace Ecjia\System\Middleware;


use Closure;

class XFrameOptionsMiddleware
{

    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        return $response;
    }

}