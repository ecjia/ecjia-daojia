<?php

/**
 * Determine the minimum version of PHP
 */
if (version_compare(PHP_VERSION, '5.5.9', '<')) {
    echo 'Current PHP Version: ' . PHP_VERSION . ', Required Version: 5.5.9';
    exit(1);
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels nice to relax.
|
*/

require __DIR__.'/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to Royalcms PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this royalcms so that we can run it and send
| the responses back to the browser and delight our users.
|
*/

$royalcms = require_once __DIR__.'/royalcms.php';

/*
|--------------------------------------------------------------------------
| Run The Royalcms
|--------------------------------------------------------------------------
|
| Once we have the royalcms, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$kernel = $royalcms->make('Royalcms\Component\Contracts\Http\Kernel');

$response = $kernel->handle(
    $request = Royalcms\Component\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
