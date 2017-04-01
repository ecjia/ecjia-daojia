<?php
/*
|--------------------------------------------------------------------------
| Include The Compiled Class File
|--------------------------------------------------------------------------
|
| To dramatically increase your application's performance, you may use a
| compiled class file which contains all of the classes commonly used
| by a request. The Artisan "optimize" is used to create this file.
|
*/

if (file_exists($compiled = SITE_ROOT.'bootstrap/compiled.php'))
{
    require $compiled;
}

/*
|--------------------------------------------------------------------------
| Register The Royalcms Auto Loader ClassMap
|--------------------------------------------------------------------------
|
| We register an auto-loader "behind" the Composer loader that can load
| model classes on the fly, even if the autoload files have not been
| regenerated for the application. We'll add it to the stack here.
|
*/

if (file_exists($classmap_file = SITE_ROOT.'bootstrap/classmap.php'))
{
    $classmap = include $classmap_file;
    if (is_array($classmap)) ComposerAutoloaderInit::getLoader()->addClassMap($classmap);
}

/*
|--------------------------------------------------------------------------
| Setup Patchwork UTF-8 Handling
|--------------------------------------------------------------------------
|
| The Patchwork library provides solid handling of UTF-8 strings as well
| as provides replacements for all mb_* and iconv type functions that
| are not available by default in PHP. We'll setup this stuff here.
|
*/

Patchwork\Utf8\Bootup::initMbstring(); 

/*
|--------------------------------------------------------------------------
| Register The Royalcms Auto Loader
|--------------------------------------------------------------------------
|
| We register an auto-loader "behind" the Composer loader that can load
| model classes on the fly, even if the autoload files have not been
| regenerated for the application. We'll add it to the stack here.
|
*/

Royalcms\Component\Support\ClassLoader::register();

/*
|--------------------------------------------------------------------------
| autoload cloass manager
|--------------------------------------------------------------------------
*/
Royalcms\Component\ClassLoader\ClassManager::auto_loader_class();

/*
|--------------------------------------------------------------------------
| loading helpers functions
|--------------------------------------------------------------------------
*/
require_once ROYALCMS_PATH . 'bootstrap/helpers.php';
require_once ROYALCMS_PATH . 'bootstrap/compatible.php';

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

$royalcms = new Royalcms\Component\Foundation\Royalcms;

/*
|--------------------------------------------------------------------------
| Detect The Royalcms Environment
|--------------------------------------------------------------------------
|
| Royalcms takes a dead simple approach to your application environments
| so you can just specify a machine name for the host that matches a
| given environment, then we will automatically detect it for you.
|
*/

try
{
    Royalcms\Component\Config\Dotenv::load(SITE_PATH, $royalcms->environmentFile());
}
catch (InvalidArgumentException $e)
{
    try {
        Royalcms\Component\Config\Dotenv::load(SITE_ROOT, $royalcms->environmentFile());
    }
    catch (InvalidArgumentException $e)
    {
        //
    }
}
$env = $royalcms->detectEnvironment(function() {
    
    return env('ROYALCMS_ENV', 'production');

});

/*
|--------------------------------------------------------------------------
| Bind Paths
|--------------------------------------------------------------------------
|
| Here we are binding the paths configured in paths.php to the app. You
| should not be changing these here. If you need to change these you
| may do so within the paths.php file and they will be bound here.
|
*/

$royalcms->bindInstallPaths(require __DIR__.'/paths.php');

/*
|--------------------------------------------------------------------------
| Load The Royalcms
|--------------------------------------------------------------------------
|
| Here we will load this Illuminate application. We will keep this in a
| separate location so we can isolate the creation of an application
| from the actual running of the application with a given request.
|
*/

require $royalcms->getBootstrapFile();

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
