<?php


namespace Royalcms\Laravel\Security;

use Closure;

class DNS
{

    /*
     |--------------------------------------------------------------------------
     | DNS Prefetch Control
     |--------------------------------------------------------------------------
     |
     | The X-DNS-Prefetch-Control HTTP response header controls DNS prefetching,
     | a feature by which browsers proactively perform domain name resolution on
     | both links that the user may choose to follow as well as URLs for items
     | referenced by the document, including images, CSS, JavaScript, and so forth.
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

        $response->header('X-DNS-Prefetch-Control', 'off');

        return $response;

    }

}