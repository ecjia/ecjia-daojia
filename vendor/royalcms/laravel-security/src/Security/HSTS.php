<?php


namespace Royalcms\Laravel\Security;

use Closure;

class HSTS
{

    /*
     |--------------------------------------------------------------------------
     | Strict-Transport-Security
     |--------------------------------------------------------------------------
     |
     | The HTTP Strict-Transport-Security response header (often abbreviated as
     | HSTS) lets a web site tell browsers that it should only be accessed using
     | HTTPS, instead of using HTTP.
     |
     */

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $response = $next($request);

        //Sets "X-Content-Type-Options: nosniff".

        $response->header('Strict-Transport-Security', 'max-age=5184000,preload');

        return $response;

    }

}