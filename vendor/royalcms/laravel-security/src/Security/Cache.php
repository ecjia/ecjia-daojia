<?php

namespace Royalcms\Laravel\Security;

use Closure;

class Cache
{

    /*
    |------------------------------------------------------------------------------
    | Cache Control Attack
    |------------------------------------------------------------------------------
    |
    | Cache-control is an HTTP header that dictates browser caching behavior.
    | In a nutshell, when someone visits a website, their browser will save certain
    | resources, such as images and website data, in a store called the cache.
    | When that user revisits the same website, cache-control sets the rules which
    | determine whether that user will have those resources loaded from their local
    | cache, or whether the browser will have to send a request to the server for
    | fresh resources. In order to understand cache-control in greater depth,
    | a basic understanding of browser caching and HTTP headers is required.
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

        $response->header('Cache-Control','no-store, no-cache, must-revalidate, max-age=0, s-maxage=0');

        return $response;

    }



}
