<?php


namespace Royalcms\Laravel\Security;

use Closure;

class FrameGuard
{

    /*
     |--------------------------------------------------------------------------
     | Click Jacking Attack
     |--------------------------------------------------------------------------
     |
     | Clickjacking, also known as a "UI redress attack", is when an attacker
     | uses multiple transparent or opaque layers to trick a user into clicking
     | on a button or link on another page when they were intending to click on
     | the the top level page. Thus, the attacker is "hijacking" clicks meant for
     | their page and routing them to another page, most likely owned by another
     | application, domain, or both.
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

        // The X-Frame-Options HTTP response header can be used to indicate whether or not a browser
        // should be allowed to render a page in a <frame>, <iframe>, <embed> or <object> . Sites can use
        // this to avoid frameGuard attacks, by ensuring that their content is not embedded into other sites.

        $response->header('X-Frame-Options', 'deny');

        return $response;

    }



}