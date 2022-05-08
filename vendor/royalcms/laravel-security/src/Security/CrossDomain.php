<?php


namespace Royalcms\Laravel\Security;


use Closure;

class CrossDomain
{

    /*
    |--------------------------------------------------------------------------
    | X-Permitted-Cross-Domain-Policies
    |--------------------------------------------------------------------------
    |
    | Adobe Flash and Adobe Acrobat can load content from your domain even from
    | other sites (in other words, cross-domain). This could cause unexpected data
    | disclosure in rare cases or extra bandwidth usage.
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

        // If you don’t want them to load data from your domain, set the header’s value to none
        $response->header('X-Permitted-Cross-Domain-Policies', 'none');

        return $response;

    }

}