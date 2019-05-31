<?php

namespace Ecjia\System\Http;

use Royalcms\Component\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
//		'Royalcms\Component\Foundation\Http\Middleware\CheckForMaintenanceMode',
//		'Royalcms\Component\Cookie\Middleware\EncryptCookies',
//		'Royalcms\Component\Cookie\Middleware\AddQueuedCookiesToResponse',
//		'Royalcms\Component\Session\Middleware\StartSession',
//		'Royalcms\Component\View\Middleware\ShareErrorsFromSession',
//		'Ecjia\System\Http\Middleware\VerifyCsrfToken',
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'verify_csrf_token' => 'Ecjia\System\Http\Middleware\VerifyCsrfToken',
//		'auth' => 'App\Http\Middleware\Authenticate',
//		'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
//		'guest' => 'App\Http\Middleware\RedirectIfAuthenticated',
	];

}
