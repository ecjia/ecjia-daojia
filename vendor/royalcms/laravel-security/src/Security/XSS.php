<?php


namespace Royalcms\Laravel\Security;

use Closure;

class XSS
{

    /*
    |--------------------------------------------------------------------------
    | XSS Attack
    |--------------------------------------------------------------------------
    |
    | Cross site scripting (XSS) is a common attack vector that injects malicious
    | code into a vulnerable web application. XSS differs from other web attack
    | vectors (e.g., SQL injections), in that it does not directly target the
    | application itself. Instead, the users of the web application are the ones
    | at risk.
    | Depending on the severity of the attack, user accounts may be compromised,
    | Trojan horse programs activated and page content modified, misleading users
    | into willingly surrendering their private data. Finally, session cookies
    | could be revealed, enabling a perpetrator to impersonate valid users and
    | abuse their private accounts.
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

        $response->header('X-XSS-Protection', '1; mode=block');

        return $response;
    }


}