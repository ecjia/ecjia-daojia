<?php

/*
|--------------------------------------------------------------------------
| Create The Royalcms
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$royalcms = new Royalcms\Component\Foundation\Royalcms(
    SITE_ROOT
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$royalcms->singleton(
	'Royalcms\Component\Contracts\Http\Kernel',
	'Ecjia\System\Http\Kernel'
);

$royalcms->singleton(
	'Royalcms\Component\Contracts\Console\Kernel',
	'Ecjia\System\Console\Kernel'
);

$royalcms->singleton(
	'Royalcms\Component\Contracts\Debug\ExceptionHandler',
	'Ecjia\System\Exceptions\Handler'
);

/*
|--------------------------------------------------------------------------
| Return The Royalcms
|--------------------------------------------------------------------------
|
| This script returns the royalcms instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $royalcms;
