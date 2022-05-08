<?php


namespace Ecjia\App\Installer\Middleware;


use Closure;
use Ecjia\App\Installer\Helper;
use RC_Uri;

class CheckInstalledMiddleware
{

    public function handle($request, Closure $next)
    {
        /* 初始化流程控制变量 */
        if (Helper::checkInstallLock()) {
            return redirect(RC_Uri::url('installer/index/installed'));
        }

        return $next($request);
    }

}