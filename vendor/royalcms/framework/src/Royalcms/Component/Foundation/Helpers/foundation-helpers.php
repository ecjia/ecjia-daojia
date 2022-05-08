<?php

use Illuminate\Support\Arr;
use Royalcms\Component\Support\Str;
use Royalcms\Component\View\Expression;
use Royalcms\Component\Container\Container;
use Royalcms\Component\Support\Collection;

//if (! function_exists('abort')) {
//    /**
//     * Throw an HttpException with the given data.
//     *
//     * @param  int     $code
//     * @param  string  $message
//     * @param  array   $headers
//     * @return void
//     *
//     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
//     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
//     */
//    function abort($code, $message = '', array $headers = [])
//    {
//        return royalcms()->abort($code, $message, $headers);
//    }
//}

//if (! function_exists('action')) {
//    /**
//     * Generate a URL to a controller action.
//     *
//     * @param  string  $name
//     * @param  array   $parameters
//     * @param  bool    $absolute
//     * @return string
//     */
//    function action($name, $parameters = [], $absolute = true)
//    {
//        return royalcms('url')->action($name, $parameters, $absolute);
//    }
//}

if (! function_exists('royalcms')) {
    /**
     * Get the available container instance.
     *
     * @param  string  $make
     * @param  array   $parameters
     * @return mixed|\Royalcms\Component\Foundation\Royalcms
     */
    function royalcms($make = null, $parameters = [])
    {
        if (is_null($make)) {
            return Container::getInstance();
        }

        return Container::getInstance()->make($make, $parameters);
    }
}

if (! function_exists('app_path')) {
    /**
     * Get the path to the application folder.
     *
     * @param  string  $path
     * @return string
     */
    function app_path($path = '')
    {
        return royalcms('path').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (! function_exists('asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool    $secure
     * @return string
     */
    function asset($path, $secure = null)
    {
        return royalcms('url')->asset($path, $secure);
    }
}

//if (! function_exists('auth')) {
//    /**
//     * Get the available auth instance.
//     *
//     * @return \Royalcms\Component\Contracts\Auth\Guard
//     */
//    function auth()
//    {
//        return royalcms(Guard::class);
//    }
//}

//if (! function_exists('back')) {
//    /**
//     * Create a new redirect response to the previous location.
//     *
//     * @param  int    $status
//     * @param  array  $headers
//     * @return \Royalcms\Component\Http\RedirectResponse
//     */
//    function back($status = 302, $headers = [])
//    {
//        return royalcms('redirect')->back($status, $headers);
//    }
//}

if (! function_exists('base_path')) {
    /**
     * Get the path to the base of the install.
     *
     * @param  string  $path
     * @return string
     */
    function base_path($path = '')
    {
        return royalcms()->basePath().($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (! function_exists('vendor_path')) {
    /**
     * Get the path to the base of the install.
     *
     * @royalcms 5.0.0
     * @param  string  $path
     * @return string
     */
    function vendor_path($path = '')
    {
        return royalcms()->vendorPath().($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (! function_exists('bcrypt')) {
    /**
     * Hash the given value.
     *
     * @param  string  $value
     * @param  array   $options
     * @return string
     */
    function bcrypt($value, $options = [])
    {
        return royalcms('hash')->make($value, $options);
    }
}

if (! function_exists('config')) {
    /**
     * Get / set the specified configuration value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param  array|string  $key
     * @param  mixed  $default
     * @return mixed
     */
    function config($key = null, $default = null)
    {
        if (is_null($key)) {
            return royalcms('config');
        }

        if (is_array($key)) {
            return royalcms('config')->set($key);
        }

        return royalcms('config')->get($key, $default);
    }
}

if (! function_exists('config_path')) {
    /**
     * Get the configuration path.
     *
     * @param  string  $path
     * @return string
     */
    function config_path($path = '')
    {
        return royalcms()->make('path.config').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

//if (! function_exists('cookie')) {
//    /**
//     * Create a new cookie instance.
//     *
//     * @param  string  $name
//     * @param  string  $value
//     * @param  int     $minutes
//     * @param  string  $path
//     * @param  string  $domain
//     * @param  bool    $secure
//     * @param  bool    $httpOnly
//     * @return \Symfony\Component\HttpFoundation\Cookie
//     */
//    function cookie($name = null, $value = null, $minutes = 0, $path = null, $domain = null, $secure = false, $httpOnly = true)
//    {
//        $cookie = royalcms(CookieFactory::class);
//
//        if (is_null($name)) {
//            return $cookie;
//        }
//
//        return $cookie->make($name, $value, $minutes, $path, $domain, $secure, $httpOnly);
//    }
//}

if (! function_exists('database_path')) {
    /**
     * Get the database path.
     *
     * @param  string  $path
     * @return string
     */
    function database_path($path = '')
    {
        return royalcms()->databasePath().($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (! function_exists('delete')) {
    /**
     * Register a new DELETE route with the router.
     *
     * @param  string  $uri
     * @param  \Closure|array|string  $action
     * @return \Royalcms\Component\Routing\Route
     */
    function delete($uri, $action)
    {
        return royalcms('router')->delete($uri, $action);
    }
}

//if (! function_exists('dispatch')) {
//    /**
//     * Dispatch a job to its appropriate handler.
//     *
//     * @param  mixed  $job
//     * @return mixed
//     */
//    function dispatch($job)
//    {
//        return royalcms(Dispatcher::class)->dispatch($job);
//    }
//}

//if (! function_exists('dispatch_now')) {
//    /**
//     * Dispatch a command to its appropriate handler in the current process.
//     *
//     * @param  mixed  $job
//     * @param  mixed  $handler
//     * @return mixed
//     */
//    function dispatch_now($job, $handler = null)
//    {
//        return royalcms(Dispatcher::class)->dispatchNow($job, $handler);
//    }
//}

//if (! function_exists('elixir')) {
//    /**
//     * Get the path to a versioned Elixir file.
//     *
//     * @param  string  $file
//     * @return string
//     *
//     * @throws \InvalidArgumentException
//     */
//    function elixir($file)
//    {
//        static $manifest = null;
//
//        if (is_null($manifest)) {
//            $manifest = json_decode(file_get_contents(public_path('build/rev-manifest.json')), true);
//        }
//
//        if (isset($manifest[$file])) {
//            return '/build/'.$manifest[$file];
//        }
//
//        throw new InvalidArgumentException("File {$file} not defined in asset manifest.");
//    }
//}

if (! function_exists('env')) {
    /**
     * Gets the value of an environment variable. Supports boolean, empty and null.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return value($default);
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return;
        }

        if (strlen($value) > 1 && Str::startsWith($value, '"') && Str::endsWith($value, '"')) {
            return substr($value, 1, -1);
        }

        return $value;
    }
}

//if (! function_exists('event')) {
//    /**
//     * Fire an event and call the listeners.
//     *
//     * @param  string|object  $event
//     * @param  mixed  $payload
//     * @param  bool  $halt
//     * @return array|null
//     */
//    function event($event, $payload = [], $halt = false)
//    {
//        return royalcms('events')->fire($event, $payload, $halt);
//    }
//}

//if (! function_exists('factory')) {
//    /**
//     * Create a model factory builder for a given class, name, and amount.
//     *
//     * @param  dynamic  class|class,name|class,amount|class,name,amount
//     * @return \Royalcms\Component\Database\Eloquent\FactoryBuilder
//     */
//    function factory()
//    {
//        $factory = royalcms(EloquentFactory::class);
//
//        $arguments = func_get_args();
//
//        if (isset($arguments[1]) && is_string($arguments[1])) {
//            return $factory->of($arguments[0], $arguments[1])->times(isset($arguments[2]) ? $arguments[2] : 1);
//        } elseif (isset($arguments[1])) {
//            return $factory->of($arguments[0])->times($arguments[1]);
//        } else {
//            return $factory->of($arguments[0]);
//        }
//    }
//}

if (! function_exists('get')) {
    /**
     * Register a new GET route with the router.
     *
     * @param  string  $uri
     * @param  \Closure|array|string  $action
     * @return \Royalcms\Component\Routing\Route
     */
    function get($uri, $action)
    {
        return royalcms('router')->get($uri, $action);
    }
}

//if (! function_exists('info')) {
//    /**
//     * Write some information to the log.
//     *
//     * @param  string  $message
//     * @param  array   $context
//     * @return void
//     */
//    function info($message, $context = [])
//    {
//        return royalcms('log')->info($message, $context);
//    }
//}

//if (! function_exists('logger')) {
//    /**
//     * Log a debug message to the logs.
//     *
//     * @param  string  $message
//     * @param  array  $context
//     * @return null|\Royalcms\Component\Contracts\Logging\Log
//     */
//    function logger($message = null, array $context = [])
//    {
//        if (is_null($message)) {
//            return royalcms('log');
//        }
//
//        return royalcms('log')->debug($message, $context);
//    }
//}

//if (! function_exists('method_field')) {
//    /**
//     * Generate a form field to spoof the HTTP verb used by forms.
//     *
//     * @param  string  $method
//     * @return string
//     */
//    function method_field($method)
//    {
//        return new Expression('<input type="hidden" name="_method" value="'.$method.'">');
//    }
//}

//if (! function_exists('now')) {
//    /**
//     * Create a new Carbon instance for the current time.
//     *
//     * @param  \DateTimeZone|string|null $tz
//     * @return \Royalcms\Component\Support\Carbon
//     */
//    function now($tz = null)
//    {
//        return \Royalcms\Component\Support\Carbon::now($tz);
//    }
//}

//if (! function_exists('old')) {
//    /**
//     * Retrieve an old input item.
//     *
//     * @param  string  $key
//     * @param  mixed   $default
//     * @return mixed
//     */
//    function old($key = null, $default = null)
//    {
//        return royalcms('request')->old($key, $default);
//    }
//}

if (! function_exists('patch')) {
    /**
     * Register a new PATCH route with the router.
     *
     * @param  string  $uri
     * @param  \Closure|array|string  $action
     * @return \Royalcms\Component\Routing\Route
     */
    function patch($uri, $action)
    {
        return royalcms('router')->patch($uri, $action);
    }
}

//if (! function_exists('policy')) {
//    /**
//     * Get a policy instance for a given class.
//     *
//     * @param  object|string  $class
//     * @return mixed
//     *
//     * @throws \InvalidArgumentException
//     */
//    function policy($class)
//    {
//        return royalcms(Gate::class)->getPolicyFor($class);
//    }
//}

if (! function_exists('post')) {
    /**
     * Register a new POST route with the router.
     *
     * @param  string  $uri
     * @param  \Closure|array|string  $action
     * @return \Royalcms\Component\Routing\Route
     */
    function post($uri, $action)
    {
        return royalcms('router')->post($uri, $action);
    }
}

if (! function_exists('public_path')) {
    /**
     * Get the path to the public folder.
     *
     * @param  string  $path
     * @return string
     */
    function public_path($path = '')
    {
        return royalcms()->make('path.sitebase').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (! function_exists('put')) {
    /**
     * Register a new PUT route with the router.
     *
     * @param  string  $uri
     * @param  \Closure|array|string  $action
     * @return \Royalcms\Component\Routing\Route
     */
    function put($uri, $action)
    {
        return royalcms('router')->put($uri, $action);
    }
}

//if (! function_exists('redirect')) {
//    /**
//     * Get an instance of the redirector.
//     *
//     * @param  string|null  $to
//     * @param  int     $status
//     * @param  array   $headers
//     * @param  bool    $secure
//     * @return \Royalcms\Component\Routing\Redirector|\Royalcms\Component\Http\RedirectResponse
//     */
//    function redirect($to = null, $status = 302, $headers = [], $secure = null)
//    {
//        if (is_null($to)) {
//            return royalcms('redirect');
//        }
//
//        return royalcms('redirect')->to($to, $status, $headers, $secure);
//    }
//}

//if (! function_exists('request')) {
//    /**
//     * Get an instance of the current request or an input item from the request.
//     *
//     * @param  string  $key
//     * @param  mixed   $default
//     * @return \Royalcms\Component\Http\Request|string|array
//     */
//    function request($key = null, $default = null)
//    {
//        if (is_null($key)) {
//            return royalcms('request');
//        }
//
//        return royalcms('request')->input($key, $default);
//    }
//}

if (! function_exists('resource')) {
    /**
     * Route a resource to a controller.
     *
     * @param  string  $name
     * @param  string  $controller
     * @param  array   $options
     * @return \Royalcms\Component\Routing\Route
     */
    function resource($name, $controller, array $options = [])
    {
        return royalcms('router')->resource($name, $controller, $options);
    }
}

//if (! function_exists('response')) {
//    /**
//     * Return a new response from the application.
//     *
//     * @param  string  $content
//     * @param  int     $status
//     * @param  array   $headers
//     * @return \Symfony\Component\HttpFoundation\Response|\Royalcms\Component\Contracts\Routing\ResponseFactory
//     */
//    function response($content = '', $status = 200, array $headers = [])
//    {
//        $factory = royalcms(ResponseFactory::class);
//
//        if (func_num_args() === 0) {
//            return $factory;
//        }
//
//        return $factory->make($content, $status, $headers);
//    }
//}

//if (! function_exists('route')) {
//    /**
//     * Generate a URL to a named route.
//     *
//     * @param  string  $name
//     * @param  array   $parameters
//     * @param  bool    $absolute
//     * @param  \Royalcms\Component\Routing\Route  $route
//     * @return string
//     */
//    function route($name, $parameters = [], $absolute = true, $route = null)
//    {
//        return royalcms('url')->route($name, $parameters, $absolute, $route);
//    }
//}

//if (! function_exists('secure_asset')) {
//    /**
//     * Generate an asset path for the application.
//     *
//     * @param  string  $path
//     * @return string
//     */
//    function secure_asset($path)
//    {
//        return asset($path, true);
//    }
//}

//if (! function_exists('secure_url')) {
//    /**
//     * Generate a HTTPS url for the application.
//     *
//     * @param  string  $path
//     * @param  mixed   $parameters
//     * @return string
//     */
//    function secure_url($path, $parameters = [])
//    {
//        return url($path, $parameters, true);
//    }
//}

//if (! function_exists('session')) {
//    /**
//     * Get / set the specified session value.
//     *
//     * If an array is passed as the key, we will assume you want to set an array of values.
//     *
//     * @param  array|string  $key
//     * @param  mixed  $default
//     * @return mixed
//     */
//    function session($key = null, $default = null)
//    {
//        if (is_null($key)) {
//            return royalcms('session');
//        }
//
//        if (is_array($key)) {
//            return royalcms('session')->put($key);
//        }
//
//        return royalcms('session')->get($key, $default);
//    }
//}

if (! function_exists('storage_path')) {
    /**
     * Get the path to the storage folder.
     *
     * @param  string  $path
     * @return string
     */
    function storage_path($path = '')
    {
        return royalcms('path.storage').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

//if (! function_exists('trans')) {
//    /**
//     * Translate the given message.
//     *
//     * @param  string  $id
//     * @param  array   $parameters
//     * @param  string  $domain
//     * @param  string  $locale
//     * @return string
//     */
//    function trans($id = null, $parameters = [], $domain = 'messages', $locale = null)
//    {
//        if (is_null($id)) {
//            return royalcms('translator');
//        }
//
//        return royalcms('translator')->get($id, $parameters, $domain, $locale);
//    }
//}

//if (! function_exists('trans_choice')) {
//    /**
//     * Translates the given message based on a count.
//     *
//     * @param  string  $id
//     * @param  int     $number
//     * @param  array   $parameters
//     * @param  string  $domain
//     * @param  string  $locale
//     * @return string
//     */
//    function trans_choice($id, $number, array $parameters = [], $domain = 'messages', $locale = null)
//    {
//        return royalcms('translator')->choice($id, $number, $parameters, $domain, $locale);
//    }
//}

//if (! function_exists('url')) {
//    /**
//     * Generate a url for the application.
//     *
//     * @param  string  $path
//     * @param  mixed   $parameters
//     * @param  bool    $secure
//     * @return string
//     */
//    function url($path = null, $parameters = [], $secure = null)
//    {
//        return royalcms(UrlGenerator::class)->to($path, $parameters, $secure);
//    }
//}

//if (! function_exists('view')) {
//    /**
//     * Get the evaluated view contents for the given view.
//     *
//     * @param  string  $view
//     * @param  array   $data
//     * @param  array   $mergeData
//     * @return \Royalcms\Component\View\View|\Royalcms\Component\Contracts\View\Factory
//     */
//    function view($view = null, $data = [], $mergeData = [])
//    {
//        $factory = royalcms(ViewFactory::class);
//
//        if (func_num_args() === 0) {
//            return $factory;
//        }
//
//        return $factory->make($view, $data, $mergeData);
//    }
//}

if ( ! function_exists('_404'))
{
    /**
     * 404错误
     *
     * @param string $msg 提示信息
     * @param string $url 跳转url
     */
    function _404($msg = null, $url = null)
    {
        RC_Hook::do_action('handle_404_error', $msg, $url);
    }
}

if ( ! function_exists('_500'))
{
    /**
     * 404错误
     *
     * @param string $msg 提示信息
     * @param string $url 跳转url
     */
    function _500($msg = null, $url = null)
    {
        RC_Hook::do_action('handle_500_error', $msg, $url);
    }
}

if ( ! function_exists('is_rc_error'))
{
    /**
     * Check whether variable is a \Royalcms\Component\Error\Error.
     *
     * Returns true if $thing is an object of the ecjia_error class.
     *
     * @since 1.0.0
     *
     * @param mixed $thing Check if unknown variable is a RC_Error object.
     * @return bool True, if RC_Error. False, if not RC_Error.
     */
    function is_rc_error($thing) {
        return RC_Error::is_error($thing);
    }
}

if (! function_exists('remove_route_var')) {
    /**
     * 移出$_GET中路由变量参数
     */
    function remove_route_var() {
        $module = config('route.module');
        $controller = config('route.controller');
        $action = config('route.action');

        unset($_GET[$module]);
        unset($_GET[$controller]);
        unset($_GET[$action]);
    }
}

if (!function_exists('debug')) {
    /**
     * Adds one or more messages to the MessagesCollector
     *
     * @param  mixed ...$value
     * @return string
     */
    function debug($value)
    {
        $debugbar = royalcms('debugbar');
        foreach (func_get_args() as $value) {
            $debugbar->addMessage($value, 'debug');
        }
    }
}

if (!function_exists('add_measure')) {
    /**
     * Adds a measure
     *
     * @param string $label
     * @param float $start
     * @param float $end
     */
    function add_measure($label, $start, $end)
    {
        royalcms('debugbar')->addMeasure($label, $start, $end);
    }
}

if (!function_exists('start_measure')) {
    /**
     * Starts a measure
     *
     * @param string $name Internal name, used to stop the measure
     * @param string $label Public name
     */
    function start_measure($name, $label = null)
    {
        royalcms('debugbar')->startMeasure($name, $label);
    }
}

if (!function_exists('stop_measure')) {
    /**
     * Stop a measure
     *
     * @param string $name Internal name, used to stop the measure
     */
    function stop_measure($name)
    {
        royalcms('debugbar')->stopMeasure($name);
    }
}

if (!function_exists('measure')) {
    /**
     * Utility function to measure the execution of a Closure
     *
     * @param string $label
     * @param \Closure $closure
     */
    function measure($label, \Closure $closure)
    {
        royalcms('debugbar')->measure($label, $closure);
    }
}


/**
 * compat.php 兼容函数库
 * @package Royalcms
 */

if ( !function_exists('iconv') )
{
    /**
     * iconv 编码转换
     */
    function iconv($in_charset, $out_charset, $str)
    {
        $in_charset = strtoupper($in_charset);
        $out_charset = strtoupper($out_charset);
        if (function_exists('mb_convert_encoding')) {
            return mb_convert_encoding($str, $out_charset, $in_charset);
        } else {
            $in_charset = strtoupper($in_charset);
            $out_charset = strtoupper($out_charset);
            if ($in_charset == 'UTF-8' && ($out_charset == 'GBK' || $out_charset == 'GB2312')) {
                return Royalcms\Component\Convert\Charset::utf8_to_gbk($str);
            }
            if (($in_charset == 'GBK' || $in_charset == 'GB2312') && $out_charset == 'UTF-8') {
                return Royalcms\Component\Convert\Charset::gbk_to_utf8($str);
            }
            return $str;
        }
    }
}

if ( ! function_exists('link_to_action'))
{
    /**
     * Generate a HTML link to a controller action.
     *
     * @param  string  $action
     * @param  string  $title
     * @param  array   $parameters
     * @param  array   $attributes
     * @return string
     */
    function link_to_action($action, $title = null, $parameters = array(), $attributes = array())
    {
        return royalcms('html')->linkAction($action, $title, $parameters, $attributes);
    }
}

if ( ! function_exists('link_to_route'))
{
    /**
     * Generate a HTML link to a named route.
     *
     * @param  string  $name
     * @param  string  $title
     * @param  array   $parameters
     * @param  array   $attributes
     * @return string
     */
    function link_to_route($name, $title = null, $parameters = array(), $attributes = array())
    {
        return royalcms('html')->linkRoute($name, $title, $parameters, $attributes);
    }
}

if ( ! function_exists('link_to_asset'))
{
    /**
     * Generate a HTML link to an asset.
     *
     * @param  string  $url
     * @param  string  $title
     * @param  array   $attributes
     * @param  bool    $secure
     * @return string
     */
    function link_to_asset($url, $title = null, $attributes = array(), $secure = null)
    {
        return royalcms('html')->linkAsset($url, $title, $attributes, $secure);
    }
}

if ( ! function_exists('link_to'))
{
    /**
     * Generate a HTML link.
     *
     * @param  string  $url
     * @param  string  $title
     * @param  array   $attributes
     * @param  bool    $secure
     * @return string
     */
    function link_to($url, $title = null, $attributes = array(), $secure = null)
    {
        return royalcms('html')->link($url, $title, $attributes, $secure);
    }
}

if ( ! function_exists('__'))
{
    /**
     * Retrieve the translation of $text. If there is no translation,
     * or the text domain isn't loaded, the original text is returned.
     *
     * @since 3.0.0
     *
     * @param string $text   Text to translate.
     * @param string $domain Optional. Text domain. Unique identifier for retrieving translated strings.
     * @return string Translated text.
     */
    function __($text, $domain = 'default')
    {
        return RC_Locale::translate($text, $domain);
    }
}

if ( ! function_exists('_e'))
{
    /**
     * Display translated text.
     *
     * @since 3.0.0
     *
     * @param string $text
     *            Text to translate.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     */
    function _e($text, $domain = 'default')
    {
        echo RC_Locale::translate($text, $domain);
    }
}

if ( ! function_exists('_x'))
{
    /**
     * Retrieve translated string with gettext context.
     *
     * Quite a few times, there will be collisions with similar translatable text
     * found in more than two places, but with different translated context.
     *
     * By including the context in the pot file, translators can translate the two
     * strings differently.
     *
     * @since 3.0.0
     *
     * @param string $text
     *            Text to translate.
     * @param string $context
     *            Context information for the translators.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     * @return string Translated context string without pipe.
     */
    function _x($text, $context, $domain = 'default')
    {
        return RC_Locale::translate_with_gettext_context($text, $context, $domain);
    }
}

if ( ! function_exists('_ex'))
{
    /**
     * Display translated string with gettext context.
     *
     * @since 3.0.0
     *
     * @param string $text
     *            Text to translate.
     * @param string $context
     *            Context information for the translators.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     * @return string Translated context string without pipe.
     */
    function _ex($text, $context, $domain = 'default')
    {
        echo _x($text, $context, $domain);
    }
}

if ( ! function_exists('esc_attr__'))
{
    /**
     * Retrieve the translation of $text and escapes it for safe use in an attribute.
     *
     * If there is no translation, or the text domain isn't loaded, the original text is returned.
     *
     * @since 3.0.0
     *
     * @param string $text
     *            Text to translate.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     * @return string Translated text on success, original text on failure.
     */
    function esc_attr__($text, $domain = 'default')
    {
        return RC_Format::esc_attr(RC_Locale::translate($text, $domain));
    }
}

if ( ! function_exists('esc_html__'))
{
    /**
     * Retrieve the translation of $text and escapes it for safe use in HTML output.
     *
     * If there is no translation, or the text domain isn't loaded, the original text is returned.
     *
     * @since 3.0.0
     *
     * @param string $text
     *            Text to translate.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     * @return string Translated text
     */
    function esc_html__($text, $domain = 'default')
    {
        return RC_Format::esc_html(RC_Locale::translate($text, $domain));
    }
}


if ( ! function_exists('esc_attr_e'))
{
    /**
     * Display translated text that has been escaped for safe use in an attribute.
     *
     * @since 3.0.0
     *
     * @param string $text
     *            Text to translate.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     */
    function esc_attr_e($text, $domain = 'default')
    {
        echo RC_Format::esc_attr(RC_Locale::translate($text, $domain));
    }
}

if ( ! function_exists('esc_html_e'))
{
    /**
     * Display translated text that has been escaped for safe use in HTML output.
     *
     * @since 3.0.0
     *
     * @param string $text
     *            Text to translate.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     */
    function esc_html_e($text, $domain = 'default')
    {
        echo RC_Format::esc_html(RC_Locale::translate($text, $domain));
    }
}

if ( ! function_exists('esc_attr_x'))
{
    /**
     * Translate string with gettext context, and escapes it for safe use in an attribute.
     *
     * @since 3.0.0
     *
     * @param string $text
     *            Text to translate.
     * @param string $context
     *            Context information for the translators.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     * @return string Translated text
     */
    function esc_attr_x($text, $context, $domain = 'default')
    {
        return RC_Format::esc_attr(RC_Locale::translate_with_gettext_context($text, $context, $domain));
    }
}

if ( ! function_exists('esc_html_x'))
{
    /**
     * Translate string with gettext context, and escapes it for safe use in HTML output.
     *
     * @since 3.0.0
     *
     * @param string $text
     *            Text to translate.
     * @param string $context
     *            Context information for the translators.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     * @return string Translated text.
     */
    function esc_html_x($text, $context, $domain = 'default')
    {
        return RC_Format::esc_html(RC_Locale::translate_with_gettext_context($text, $context, $domain));
    }
}

if ( ! function_exists('rc_get_temp_dir'))
{
    /**
     * Determine a writable directory for temporary files.
     *
     * Function's preference is the return value of sys_get_temp_dir(),
     * followed by your PHP temporary upload directory, followed by RC_CONTENT_DIR,
     * before finally defaulting to /tmp/
     *
     * In the event that this function does not find a writable location,
     * It may be overridden by the RC_TEMP_DIR constant in your wp-config.php file.
     *
     * @since 2.5.0
     *
     * @return string Writable temporary directory.
     */
    function rc_get_temp_dir() {
        static $temp;
        if ( defined('RC_TEMP_DIR') )
        {
            return RC_Format::trailingslashit(RC_TEMP_DIR);
        }

        if ( $temp )
        {
            return RC_Format::trailingslashit( $temp );
        }

        if ( function_exists('sys_get_temp_dir') ) {
            $temp = sys_get_temp_dir();
            if ( @is_dir( $temp ) && rc_is_writable( $temp ) )
            {
                return RC_Format::trailingslashit( $temp );
            }
        }

        $temp = ini_get('upload_tmp_dir');
        if ( @is_dir( $temp ) && rc_is_writable( $temp ) )
        {
            return RC_Format::trailingslashit( $temp );
        }

        $temp = RC_CONTENT_DIR . '/';
        if ( is_dir( $temp ) && rc_is_writable( $temp ) )
        {
            return $temp;
        }

        $temp = '/tmp/';
        return $temp;
    }
}

if ( ! function_exists('rc_tempnam'))
{
    /**
     * Returns a filename of a Temporary unique file.
     * Please note that the calling function must unlink() this itself.
     *
     * The filename is based off the passed parameter or defaults to the current unix timestamp,
     * while the directory can either be passed as well, or by leaving it blank, default to a writable temporary directory.
     *
     * @since 2.6.0
     *
     * @param string $filename (optional) Filename to base the Unique file off
     * @param string $dir (optional) Directory to store the file in
     * @return string a writable filename
     */
    function rc_tempnam($filename = '', $dir = '') {
        if ( empty($dir) )
        {
            $dir = rc_get_temp_dir();
        }

        $filename = basename($filename);
        if ( empty($filename) )
        {
            $filename = time();
        }

        $filename = preg_replace('|\..*$|', '.tmp', $filename);
        $filename = $dir . rc_unique_filename($dir, $filename);
        touch($filename);
        return $filename;
    }
}

if ( ! function_exists('rc_unique_filename'))
{
    /**
     * Get a filename that is sanitized and unique for the given directory.
     *
     * If the filename is not unique, then a number will be added to the filename
     * before the extension, and will continue adding numbers until the filename is
     * unique.
     *
     * The callback is passed three parameters, the first one is the directory, the
     * second is the filename, and the third is the extension.
     *
     * @since 2.5.0
     *
     * @param string   $dir                      Directory.
     * @param string   $filename                 File name.
     * @param callback $unique_filename_callback Callback. Default null.
     * @return string New filename, if given wasn't unique.
     */
    function rc_unique_filename( $dir, $filename, $unique_filename_callback = null ) {
        // Sanitize the file name before we begin processing.
        $filename = RC_Format::sanitize_file_name($filename);

        // Separate the filename into a name and extension.
        $info = pathinfo($filename);
        $ext = !empty($info['extension']) ? '.' . $info['extension'] : '';
        $name = basename($filename, $ext);

        // Edge case: if file is named '.ext', treat as an empty name.
        if ( $name === $ext )
            $name = '';

        /*
         * Increment the file number until we have a unique file to save in $dir.
        * Use callback if supplied.
        */
        if ( $unique_filename_callback && is_callable( $unique_filename_callback ) ) {
            $filename = call_user_func( $unique_filename_callback, $dir, $name, $ext );
        }
        else {
            $number = '';

            // Change '.ext' to lower case.
            if ( $ext && strtolower($ext) != $ext ) {
                $ext2 = strtolower($ext);
                $filename2 = preg_replace( '|' . preg_quote($ext) . '$|', $ext2, $filename );

                // Check for both lower and upper case extension or image sub-sizes may be overwritten.
                while ( file_exists($dir . "/$filename") || file_exists($dir . "/$filename2") ) {
                    $new_number = $number + 1;
                    $filename = str_replace( "$number$ext", "$new_number$ext", $filename );
                    $filename2 = str_replace( "$number$ext2", "$new_number$ext2", $filename2 );
                    $number = $new_number;
                }
                return $filename2;
            }

            while ( file_exists( $dir . "/$filename" ) ) {
                if ( '' == "$number$ext" )
                {
                    $filename = $filename . ++$number . $ext;
                }
                else
                {
                    $filename = str_replace( "$number$ext", ++$number . $ext, $filename );
                }
            }
        }

        return $filename;
    }
}

if ( ! function_exists('rc_extension_exists'))
{
    /**
     * 验证扩展是否加载
     *
     * @param string $ext
     * @return bool
     */
    function rc_extension_exists($ext)
    {
        $ext = strtolower($ext);
        $loaded_extensions = get_loaded_extensions();
        return in_array($ext, RC_Array::transform_value_case($loaded_extensions));
    }
}

if (! function_exists('array_fetch')) {
    /**
     * Fetch a flattened array of a nested array element.
     *
     * @param  array   $array
     * @param  string  $key
     * @return array
     *
     * @deprecated since version 5.1. Use array_pluck instead.
     */
    function array_fetch($array, $key)
    {
        return Arr::fetch($array, $key);
    }
}

if (! function_exists('array_build')) {
    /**
     * Build a new array using a callback.
     *
     * @param  array  $array
     * @param  callable  $callback
     * @return array
     */
    function array_build($array, callable $callback)
    {
        return Arr::build($array, $callback);
    }
}

if (! function_exists('collect')) {
    /**
     * Create a collection from the given value.
     *
     * @param  mixed  $value
     * @return \Royalcms\Component\Support\Collection
     */
    function collect($value = null)
    {
        return new Collection($value);
    }
}