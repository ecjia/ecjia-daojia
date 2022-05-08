<?php


namespace Royalcms\Laravel\Security;


use Closure;

class CORS
{

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS)
    |--------------------------------------------------------------------------
    |
    | Cross-Origin Resource Sharing (CORS) is a mechanism that uses additional
    | HTTP headers to tell a browser to let a web application running at one origin
    | (domain) have permission to access selected resources from a server at a
    | different origin. A web application executes a cross-origin HTTP request
    | when it requests a resource that has a different origin (domain, protocol,
    | and port) than its own origin.An example of a cross-origin request: The
    | frontend JavaScript code for a web application served from http://domain-a.com
    | uses XMLHttpRequest to make a request for http://api.domain-b.com/data.json.
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

        // "*" wildcard, to tell browsers to allow any origin to access the resource.
        $response->header('Access-Control-Allow-Origin', '*');

        $response->header('Access-Control-Allow-Headers', '*');

        // The Access-Control-Allow-Methods header specifies the method or methods allowed when
        // accessing the resource
        $response->header('Access-Control-Allow-Methods', 'GET,POST,PUT,DELETE');

        return $response;
    }



}