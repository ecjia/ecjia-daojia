<?php

namespace Royalcms\Laravel\Security;

use Closure;

class XPoweredBy
{

    /*
    |------------------------------------------------------------------------------
    | X-Powered-By Attack
    |------------------------------------------------------------------------------
    |
    | Hackers can exploit known vulnerabilities in Express and Node if they know
    | you’re using it. Express (and other web technologies like PHP) set an X-Powered-By
    | header with every request, indicating what technology powers the server.
    | PHP , for example, sets this, which is a dead giveaway that your server is
    | powered by PHP.
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

        // remove X-Powered-By from Response
        header_remove("X-Powered-By");

        return $response;

    }

}
