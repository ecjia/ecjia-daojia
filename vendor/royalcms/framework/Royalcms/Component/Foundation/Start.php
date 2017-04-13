<?php

/*
|--------------------------------------------------------------------------
| Set PHP Error Reporting Options
|--------------------------------------------------------------------------
|
| Here we will set the strictest error reporting options, and also turn
| off PHP's error reporting, since all errors will be handled by the
| framework and we don't want any output leaking back to the user.
|
*/

error_reporting(-1);

/*
|--------------------------------------------------------------------------
| Check Extensions
|--------------------------------------------------------------------------
|
| Laravel requires a few extensions to function. Here we will check the
| loaded extensions to make sure they are present. If not we'll just
| bail from here. Otherwise, Composer will crazily fall back code.
|
*/

if ( ! extension_loaded('mcrypt'))
{
	echo 'Mcrypt PHP extension required.'.PHP_EOL;

	exit(1);
}

/*
|--------------------------------------------------------------------------
| Register Class Imports
|--------------------------------------------------------------------------
|
| Here we will just import a few classes that we need during the booting
| of the framework. These are mainly classes that involve loading the
| config files for this application, such as the config repository.
|
*/

use Royalcms\Component\Support\Facades\Facade;
use Royalcms\Component\Foundation\AliasLoader;
use Royalcms\Component\ClassLoader\ClassManager;
use Royalcms\Component\Config\EnvironmentVariables;
use Royalcms\Component\Config\Repository as Config;

/*
|--------------------------------------------------------------------------
| Bind The Application In The Container
|--------------------------------------------------------------------------
|
| This may look strange, but we actually want to bind the app into itself
| in case we need to Facade test an application. This will allow us to
| resolve the "app" key out of this container for this app's facade.
|
*/

$royalcms->instance('royalcms', $royalcms);

/*
|--------------------------------------------------------------------------
| Check For The Test Environment
|--------------------------------------------------------------------------
|
| If the "unitTesting" variable is set, it means we are running the unit
| tests for the application and should override this environment here
| so we use the right configuration. The flag gets set by TestCase.
|
*/

if (isset($unitTesting))
{
	$royalcms['env'] = $env = $testEnvironment;
}

/*
|--------------------------------------------------------------------------
| Load The Royalcms Facades
|--------------------------------------------------------------------------
|
| The facades provide a terser static interface over the various parts
| of the application, allowing their methods to be accessed through
| a mixtures of magic methods and facade derivatives. It's slick.
|
*/

Facade::clearResolvedInstances();

Facade::setFacadeRoyalcms($royalcms);

/*
|--------------------------------------------------------------------------
| Register Facade Aliases To Full Classes
|--------------------------------------------------------------------------
|
| By default, we use short keys in the container for each of the core
| pieces of the framework. Here we will register the aliases for a
| list of all of the fully qualified class names making DI easy.
|
*/

$royalcms->registerCoreContainerAliases();

/*
|--------------------------------------------------------------------------
| Register The Environment Variables
|--------------------------------------------------------------------------
|
| Here we will register all of the $_ENV and $_SERVER variables into the
| process so that they're globally available configuration options so
| sensitive configuration information can be swept out of the code.
|
*/

with($envVariables = new EnvironmentVariables(
	$royalcms->getEnvironmentVariablesLoader()
	))->load($env);

/*
|--------------------------------------------------------------------------
| Register The Configuration Repository
|--------------------------------------------------------------------------
|
| The configuration repository is used to lazily load in the options for
| this application from the configuration files. The files are easily
| separated by their concerns so they do not become really crowded.
|
*/

$royalcms->instance('config', $config = new Config(
	$royalcms->getConfigLoader(), $env
));

/*
|--------------------------------------------------------------------------
| Register Application Exception Handling
|--------------------------------------------------------------------------
|
| We will go ahead and register the application exception handling here
| which will provide a great output of exception details and a stack
| trace in the case of exceptions while an application is running.
|
*/

$royalcms->startExceptionHandling();

if ($env != 'testing') ini_set('display_errors', 'Off');

/*
|--------------------------------------------------------------------------
| Set The Default Timezone
|--------------------------------------------------------------------------
|
| Here we will set the default timezone for PHP. PHP is notoriously mean
| if the timezone is not explicitly set. This will be used by each of
| the PHP date and date-time functions throughout the application.
|
*/

$config = $royalcms['config']['system'];

date_default_timezone_set($config['timezone']);

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
ClassManager::addNamespaces($royalcms['config']->get('namespaces', array()));

/*
|--------------------------------------------------------------------------
| Register The Alias Loader
|--------------------------------------------------------------------------
|
| The alias loader is responsible for lazy loading the class aliases setup
| for the application. We will only register it if the "config" service
| is bound in the application since it contains the alias definitions.
|
*/

$aliases = $config['aliases'];
if (! interface_exists('SessionHandlerInterface', false)) {
    $aliases['SessionHandlerInterface'] = 'Royalcms\Component\Session\SessionCustomHandlerInterface';
}

AliasLoader::getInstance($aliases);
AliasLoader::getInstance($royalcms['config']->get('facade', array()))->register();

/*
|--------------------------------------------------------------------------
| Enable HTTP Method Override
|--------------------------------------------------------------------------
|
| Next we will tell the request class to allow HTTP method overriding
| since we use this to simulate PUT and DELETE requests from forms
| as they are not currently supported by plain HTML form setups.
|
*/

RC_Request::enableHttpMethodParameterOverride();

/*
|--------------------------------------------------------------------------
| Register The Core Service Providers
|--------------------------------------------------------------------------
|
| The Royalcms core service providers register all of the core pieces
| of the Illuminate framework including session, caching, encryption
| and more. It's simply a convenient wrapper for the registration.
|
*/

$providers = $config['providers'];

$royalcms->getProviderRepository()->load($royalcms, $providers);

/*
|--------------------------------------------------------------------------
| Load The Royalcms bootstrap before Start Script
|--------------------------------------------------------------------------
|
| The start scripts gives this royalcms the opportunity to override
| any of the existing IoC bindings, as well as register its own new
| bindings for things like repositories, etc. We'll load it here.
|
*/

$path = $royalcms['path.system'].'/start/bootstrap.php';

if (file_exists($path)) require $path;

/*
|--------------------------------------------------------------------------
| Register The User Service Providers
|--------------------------------------------------------------------------
|
| The Royalcms user service providers register all of the core pieces
| of the Illuminate framework including session, caching, encryption
| and more. It's simply a convenient wrapper for the registration.
|
*/

collect($royalcms['config']->get('provider', array()))->map(function($provider) use ($royalcms) {
    if (class_exists($provider)) $royalcms->register($provider);
});

/*
|--------------------------------------------------------------------------
| Register Booted Start Files
|--------------------------------------------------------------------------
|
| Once the royalcms has been booted there are several "start" files
| we will want to include. We'll register our "booted" handler here
| so the files are included after the application gets booted up.
|
*/

$royalcms->booted(function() use ($royalcms, $env)
{
    
if (! MAGIC_QUOTES_GPC) {
    $_POST = rc_addslashes($_POST);
    $_GET = rc_addslashes($_GET);
    $_REQUEST = rc_addslashes($_REQUEST);
    $_COOKIE = rc_addslashes($_COOKIE);
}

// 加载扩展函数库
RC_Loader::auto_load_func();
    
/*
 |--------------------------------------------------------------------------
| Load The Royalcms Start Script
|--------------------------------------------------------------------------
|
| The start scripts gives this royalcms the opportunity to override
| any of the existing IoC bindings, as well as register its own new
| bindings for things like repositories, etc. We'll load it here.
|
*/

$path = $royalcms['path.system'].'/start/global.php';

if (file_exists($path)) require $path;

/*
|--------------------------------------------------------------------------
| Load The Environment Start Script
|--------------------------------------------------------------------------
|
| The environment start script is only loaded if it exists for the app
| environment currently active, which allows some actions to happen
| in one environment while not in the other, keeping things clean.
|
*/

$path = $royalcms['path.system']."/start/{$env}.php";

if (file_exists($path)) require $path;

/*
|--------------------------------------------------------------------------
| Load The Royalcms Routes
|--------------------------------------------------------------------------
|
| The Royalcms routes are kept separate from the royalcms starting
| just to keep the file a little cleaner. We'll go ahead and load in
| all of the routes now and return the application to the callers.
|
*/

Route::any('/', function()
{
    $app = new \Royalcms\Component\App\App();
    $app->init();
});

Route::any('{url}', function($url)
{
    $app = new \Royalcms\Component\App\App();
    $app->init();
});

$routes = $royalcms['path.system'].'/start/routes.php';

if (file_exists($routes)) require $routes;

try {
    /**
     * Fires after ECJia has finished loading but before any headers are sent.
     *
     * @since 1.5.0
     */
    RC_Hook::do_action('init');
    
    RC_Rewrite::add_rewrite_rule('^admincp/([^/]*)/([^/]*)/?', 'index.php?m=admincp&c=$matches[1]&a=$matches[2]', 'top');
    
    $rules = $royalcms['config']['route.rules'];
    if ($rules) {
        foreach ($rules as $key => $value) {
            RC_Rewrite::add_rewrite_rule($key, $value, 'top');
        }
    }
    
} catch (Exception $exception) {
    $err = array(
        'file'      => $exception->getFile(),
        'line'      => $exception->getLine(),
        'code'      => $exception->getCode(),
        'url'       => RC_Request::fullUrl(),
    );
    RC_Logger::getLogger(RC_Logger::LOG_ERROR)->error($exception->getMessage(), $err);
}


});
