<?php


namespace Royalcms\Laravel\Security;

use Closure;

class NoSniff
{

    /*
    |--------------------------------------------------------------------------
    | Mime Sniffing Attack
    |--------------------------------------------------------------------------
    |
    | MIME sniffing was, and still is, a technique used by some web browsers
    | (primarily Internet Explorer) to examine the content of a particular asset.
    | This is done for the purpose of determining an asset’s file format.
    | This technique is useful in the event that there is not enough metadata
    | information present for a particular asset, thus leaving the possibility that
    | the browser interprets the asset incorrectly.
    | Although MIME sniffing can be useful to determine an asset’s correct file format,
    | it can also cause a security vulnerability. This vulnerability can be quite dangerous
    | both for site owners as well as site visitors. This is because an attacker can leverage
    | MIME sniffing to send an XSS (Cross Site Scripting) attack. This article will explain
    | how to protect your site against MIME sniffing vulnerabilities.
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

        $response->header('X-Content-Type-Options', 'nosniff');

        return $response;

    }


}