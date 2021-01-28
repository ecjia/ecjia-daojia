<?php


namespace Ecjia\System\Middleware;


use Closure;
use RC_Uri;

class CheckInstalledEcjiaSystemMiddleware
{

    public function handle($request, Closure $next)
    {
        if (! is_installed_ecjia()) {
            if ($request->query('m') != 'installer') {
                $url = RC_Uri::url('installer/index/init');
                $url = str_replace(RC_Uri::site_url(), RC_Uri::home_url('sites/installer/'), $url);
                return redirect($url);
            }
        }

        return $next($request);
    }

}