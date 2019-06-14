<?php

namespace Royalcms\Component\Foundation;

use Closure;
use RuntimeException;
use Royalcms\Component\Support\Arr;
use Royalcms\Component\Support\Str;
use Royalcms\Component\Http\Request;
use Royalcms\Component\Container\Container;
use Royalcms\Component\Filesystem\Filesystem;
use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Events\EventServiceProvider;
use Royalcms\Component\Routing\RoutingServiceProvider;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Royalcms\Component\Contracts\Foundation\Royalcms as RoyalcmsContract;
use Royalcms\Component\Contracts\Debug\ExceptionHandler;

class Royalcms extends Container implements RoyalcmsContract, HttpKernelInterface
{
    /**
     * The Royalcms framework version.
     *
     * @var string
     */
    const VERSION = '5.15.0';

    /**
     * The Royalcms framework release.
     *
     * @var string
     */
    const RELEASE = '2019-06-14';

    /**
     * The base path for the Laravel installation.
     *
     * @var string
     */
    protected $basePath;

    /**
     * Indicates if the application has been bootstrapped before.
     *
     * @var bool
     */
    protected $hasBeenBootstrapped = false;

    /**
     * Indicates if the application has "booted".
     *
     * @var bool
     */
    protected $booted = false;

    /**
     * The array of booting callbacks.
     *
     * @var array
     */
    protected $bootingCallbacks = [];

    /**
     * The array of booted callbacks.
     *
     * @var array
     */
    protected $bootedCallbacks = [];

    /**
     * The array of terminating callbacks.
     *
     * @var array
     */
    protected $terminatingCallbacks = [];

    /**
     * All of the registered service providers.
     *
     * @var array
     */
    protected $serviceProviders = [];

    /**
     * The names of the loaded service providers.
     *
     * @var array
     */
    protected $loadedProviders = [];

    /**
     * The deferred services and their providers.
     *
     * @var array
     */
    protected $deferredServices = [];

    /**
     * A custom callback used to configure Monolog.
     *
     * @var callable|null
     */
    protected $monologConfigurator;

    /**
     * The custom database path defined by the developer.
     *
     * @var string
     */
    protected $databasePath;

    /**
     * The custom storage path defined by the developer.
     *
     * @var string
     */
    protected $storagePath;

    /**
     * The custom environment path defined by the developer.
     *
     * @var string
     */
    protected $environmentPath;

    /**
     * Indicates if the storage directory should be used for optimizations.
     *
     * @var bool
     */
    protected $useStoragePathForOptimizations = false;

    /**
     * The environment file to load during bootstrapping.
     *
     * @var string
     */
    protected $environmentFile = '.env';

    /**
     * The application namespace.
     *
     * @var string
     */
    protected $namespace = null;

    /**
     * Create a new Royalcms application instance.
     *
     * @param  string|null  $basePath
     * @return void
     */
    public function __construct($basePath = null)
    {
        $this->registerBaseBindings();

        $this->registerBaseServiceProviders();

        $this->registerCoreContainerAliases();

        if ($basePath) {
            $this->setBasePath($basePath);
        }
    }

    /**
     * Get the version number of the royalcms.
     *
     * @return string
     */
    public function version()
    {
        return static::VERSION;
    }

    /**
     * Get the release number of the royalcms.
     *
     * @return string
     */
    public function release()
    {
        return static::RELEASE;
    }

    /**
     * Register the basic bindings into the container.
     *
     * @return void
     */
    protected function registerBaseBindings()
    {
        static::setInstance($this);

        $this->instance('royalcms', $this);

        $this->instance('Royalcms\Component\Container\Container', $this);
    }

    /**
     * Register all of the base service providers.
     *
     * @return void
     */
    protected function registerBaseServiceProviders()
    {
        $this->register(new EventServiceProvider($this));

        $this->register(new RoutingServiceProvider($this));
    }

    /**
     * Run the given array of bootstrap classes.
     *
     * @param  array  $bootstrappers
     * @return void
     */
    public function bootstrapWith(array $bootstrappers)
    {
        $this->hasBeenBootstrapped = true;

        foreach ($bootstrappers as $bootstrapper) {
            $this['events']->fire('bootstrapping: '.$bootstrapper, [$this]);

            $this->make($bootstrapper)->bootstrap($this);

            $this['events']->fire('bootstrapped: '.$bootstrapper, [$this]);
        }
    }

    /**
     * Register a callback to run after loading the environment.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public function afterLoadingEnvironment(Closure $callback)
    {
        return $this->afterBootstrapping(
            'Royalcms\Component\Foundation\Bootstrap\DetectEnvironment', $callback
        );
    }

    /**
     * Register a callback to run before a bootstrapper.
     *
     * @param  string  $bootstrapper
     * @param  Closure  $callback
     * @return void
     */
    public function beforeBootstrapping($bootstrapper, Closure $callback)
    {
        $this['events']->listen('bootstrapping: '.$bootstrapper, $callback);
    }

    /**
     * Register a callback to run after a bootstrapper.
     *
     * @param  string  $bootstrapper
     * @param  Closure  $callback
     * @return void
     */
    public function afterBootstrapping($bootstrapper, Closure $callback)
    {
        $this['events']->listen('bootstrapped: '.$bootstrapper, $callback);
    }

    /**
     * Determine if the application has been bootstrapped before.
     *
     * @return bool
     */
    public function hasBeenBootstrapped()
    {
        return $this->hasBeenBootstrapped;
    }

    /**
     * Set the base path for the application.
     *
     * @param  string  $basePath
     * @return $this
     */
    public function setBasePath($basePath)
    {
        $this->basePath = rtrim($basePath, '\/');

        $this->bindPathsInContainer();

        return $this;
    }

    /**
     * Bind all of the application paths in the container.
     *
     * @return void
     */
    protected function bindPathsInContainer()
    {
        $this->instance('path', $this->path());

        foreach (['base', 'content', 'site', 'system', 'config', 'database', 'lang',  'app', 'plugin', 'theme', 'upload', 'storage', 'bootstrap', 'resource', 'vendor'] as $path) {
            $this->instance('path.'.$path, $this->{$path.'Path'}());
        }
    }

    /**
     * Get the base path of the Royalcms installation.
     *
     * @return string
     */
    public function basePath()
    {
        return $this->basePath;
    }

    /**
     * Get the path to the application current "site" directory.
     *
     * @return string
     */
    public function path()
    {
        if ($this->runningInSite()) {
            return $this->sitePath().DIRECTORY_SEPARATOR.RC_SITE;
        } else {
            return $this->basePath();
        }
    }

    public function contentPath()
    {
        return $this->basePath().DIRECTORY_SEPARATOR.'content';
    }

    public function siteContentPath()
    {
        return $this->path().DIRECTORY_SEPARATOR.'content';
    }

    /**
     * Get the site path of the Royalcms Multi-Sites.
     *
     * @return string
     */
    public function sitePath()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'sites';
    }

    /**
     * Get the path to the application system files.
     *
     * @return string
     */
    public function systemPath()
    {
        $path = $this->siteContentPath().DIRECTORY_SEPARATOR.'system';

        if ($this->runningInSite() && is_dir($path)) {
            return $path;
        } else {
            return $this->contentPath().DIRECTORY_SEPARATOR.'system';
        }
    }

    /**
     * Get the path to the bootstrap app files.
     *
     * @return string
     */
    public function bootstrapPath()
    {
        $path = $this->siteContentPath().DIRECTORY_SEPARATOR.'bootstrap';

        if ($this->runningInSite() && is_dir($path)) {
            return $path;
        } else {
            return $this->contentPath().DIRECTORY_SEPARATOR.'bootstrap';
        }
    }

    /**
     * Get the path to the application app files.
     *
     * @return string
     */
    public function appPath($dir = null)
    {
        if (! is_null($dir)) {
            $dir = DIRECTORY_SEPARATOR . $dir;
        }

        $path = $this->siteContentPath().DIRECTORY_SEPARATOR.'apps'.$dir;

        if ($this->runningInSite() && is_dir($path)) {
            return $path;
        } else {
            return $this->contentPath().DIRECTORY_SEPARATOR.'apps'.$dir;
        }
    }

    /**
     * Get the path to the application plugin files.
     *
     * @return string
     */
    public function pluginPath($dir = null)
    {
        if (! is_null($dir)) {
            $dir = DIRECTORY_SEPARATOR . $dir;
        }

        $path = $this->siteContentPath().DIRECTORY_SEPARATOR.'plugins'.$dir;

        if ($this->runningInSite() && is_dir($path)) {
            return $path;
        } else {
            return $this->contentPath().DIRECTORY_SEPARATOR.'plugins'.$dir;
        }
    }

    /**
     * Get the path to the application theme files.
     *
     * @return string
     */
    public function themePath()
    {
        $path = $this->siteContentPath().DIRECTORY_SEPARATOR.'themes';

        if ($this->runningInSite() && is_dir($path)) {
            return $path;
        } else {
            return $this->contentPath().DIRECTORY_SEPARATOR.'themes';
        }
    }

    /**
     * Get the path to the application theme files.
     *
     * @return string
     */
    public function uploadPath()
    {
        $path = $this->siteContentPath().DIRECTORY_SEPARATOR.'uploads';

        if ($this->runningInSite() && is_dir($path)) {
            return $path;
        } else {
            return $this->contentPath().DIRECTORY_SEPARATOR.'uploads';
        }
    }

    /**
     * Get the path to the resources files.
     *
     * @return string
     */
    public function resourcePath()
    {
        $path = $this->siteContentPath().DIRECTORY_SEPARATOR.'resources';

        if ($this->runningInSite() && is_dir($path)) {
            return $path;
        } else {
            return $this->contentPath().DIRECTORY_SEPARATOR.'resources';
        }
    }

    /**
     * Get the path to the application theme files.
     *
     * @return string
     */
    public function testPath()
    {
        $path = $this->siteContentPath().DIRECTORY_SEPARATOR.'tests';

        if ($this->runningInSite() && is_dir($path)) {
            return $path;
        } else {
            return $this->contentPath().DIRECTORY_SEPARATOR.'tests';
        }
    }

    /**
     * Get the path to the application configuration files.
     *
     * @return string
     */
    public function configPath()
    {
        $path = $this->siteContentPath().DIRECTORY_SEPARATOR.'configs';

        if ($this->runningInSite() && is_dir($path)) {
            return $path;
        } else {
            return $this->contentPath().DIRECTORY_SEPARATOR.'configs';
        }
    }

    /**
     * Get the path to the database directory.
     *
     * @return string
     */
    public function databasePath()
    {
        if ($this->databasePath) {
            return $this->databasePath;
        } else {

            $path = $this->siteContentPath().DIRECTORY_SEPARATOR.'database';

            if ($this->runningInSite() && is_dir($path)) {
                return $path;
            } else {
                return $this->contentPath().DIRECTORY_SEPARATOR.'database';
            }

        }
    }

    /**
     * Set the database directory.
     *
     * @param  string  $path
     * @return $this
     */
    public function useDatabasePath($path)
    {
        $this->databasePath = $path;

        $this->instance('path.database', $path);

        return $this;
    }

    /**
     * Get the path to the language files.
     *
     * @return string
     */
    public function langPath()
    {
        $path = $this->siteContentPath().DIRECTORY_SEPARATOR.'languages';

        if ($this->runningInSite() && is_dir($path)) {
            return $path;
        } else {
            return $this->contentPath().DIRECTORY_SEPARATOR.'languages';
        }
    }

    /**
     * Get the path to the public / web directory.
     *
     * @return string
     */
    public function publicPath()
    {
        return $this->basePath();
    }

    /**
     * Get the path to the vendor / web directory.
     *
     * @return string
     */
    public function vendorPath()
    {
        return $this->basePath().DIRECTORY_SEPARATOR.'vendor';
    }

    /**
     * Get the path to the storage directory.
     *
     * @return string
     */
    public function storagePath()
    {
        if ($this->storagePath) {
            return $this->storagePath;
        } else {

            $path = $this->siteContentPath().DIRECTORY_SEPARATOR.'storages';

            if ($this->runningInSite() && is_dir($path)) {
                return $path;
            } else {
                return $this->contentPath().DIRECTORY_SEPARATOR.'storages';
            }

        }
    }

    /**
     * Set the storage directory.
     *
     * @param  string  $path
     * @return $this
     */
    public function useStoragePath($path)
    {
        $this->storagePath = $path;

        $this->instance('path.storage', $path);

        return $this;
    }

    /**
     * Get the path to the environment file directory.
     *
     * @return string
     */
    public function environmentPath()
    {
        return $this->environmentPath ?: $this->basePath;
    }

    /**
     * Set the directory for the environment file.
     *
     * @param  string  $path
     * @return $this
     */
    public function useEnvironmentPath($path)
    {
        $this->environmentPath = $path;

        return $this;
    }

    /**
     * Set the environment file to be loaded during bootstrapping.
     *
     * @param  string  $file
     * @return $this
     */
    public function loadEnvironmentFrom($file)
    {
        $this->environmentFile = $file;

        return $this;
    }

    /**
     * Get the environment file the application is using.
     *
     * @return string
     */
    public function environmentFile()
    {
        return $this->environmentFile ?: '.env';
    }

    /**
     * Get or check the current application environment.
     *
     * @param  mixed
     * @return string
     */
    public function environment()
    {
        if (func_num_args() > 0) {
            $patterns = is_array(func_get_arg(0)) ? func_get_arg(0) : func_get_args();

            foreach ($patterns as $pattern) {
                if (Str::is($pattern, $this['env'])) {
                    return true;
                }
            }

            return false;
        }

        return $this['env'];
    }

    /**
     * Determine if application is in local environment.
     *
     * @return bool
     */
    public function isLocal()
    {
        return $this['env'] == 'local';
    }

    /**
     * Detect the application's current environment.
     *
     * @param  \Closure  $callback
     * @return string
     */
    public function detectEnvironment(Closure $callback)
    {
        $args = isset($_SERVER['argv']) ? $_SERVER['argv'] : null;

        return $this['env'] = (new EnvironmentDetector())->detect($callback, $args);
    }

    /**
     * Determine if we are running in the console.
     *
     * @return bool
     */
    public function runningInSite()
    {
        return defined('RC_SITE');
    }

    /**
     * Determine if we are running in the console.
     *
     * @return bool
     */
    public function runningInConsole()
    {
        return php_sapi_name() == 'cli';
    }

    /**
     * Determine if we are running unit tests.
     *
     * @return bool
     */
    public function runningUnitTests()
    {
        return $this['env'] == 'testing';
    }

    /**
     * Register all of the configured providers.
     *
     * @return void
     */
    public function registerConfiguredProviders()
    {
        $manifestPath = $this->getCachedServicesPath();

        (new ProviderRepository($this, new Filesystem, $manifestPath))
                    ->load($this->config['coreservice.providers']);
    }

    /**
     * Force register a service provider with the application.
     *
     * @param  \Royalcms\Component\Support\ServiceProvider|string  $provider
     * @param  array  $options
     * @return \Royalcms\Component\Support\ServiceProvider
     */
    public function forgeRegister($provider, $options = array())
    {
        return $this->register($provider, $options, true);
    }

    /**
     * Register a service provider with the application.
     *
     * @param  \Royalcms\Component\Support\ServiceProvider|string  $provider
     * @param  array  $options
     * @param  bool   $force
     * @return \Royalcms\Component\Support\ServiceProvider
     */
    public function register($provider, $options = [], $force = false)
    {
        if (($registered = $this->getProvider($provider)) && ! $force) {
            return $registered;
        }

        // If the given "provider" is a string, we will resolve it, passing in the
        // application instance automatically for the developer. This is simply
        // a more convenient way of specifying your service provider classes.
        if (is_string($provider)) {
            $provider = $this->resolveProviderClass($provider);
        }

        $provider->register();

        // Once we have registered the service we will iterate through the options
        // and set each of them on the application so they will be available on
        // the actual loading of the service objects and for developer usage.
        foreach ($options as $key => $value) {
            $this[$key] = $value;
        }

        $this->markAsRegistered($provider);

        // If the application has already booted, we will call this boot method on
        // the provider class so it has an opportunity to do its boot logic and
        // will be ready for any usage by the developer's application logics.
        if ($this->booted) {
            $this->bootProvider($provider);
        }

        return $provider;
    }

    /**
     * Get the registered service provider instance if it exists.
     *
     * @param  \Royalcms\Component\Support\ServiceProvider|string  $provider
     * @return \Royalcms\Component\Support\ServiceProvider|null
     */
    public function getProvider($provider)
    {
        $name = is_string($provider) ? $provider : get_class($provider);

        return Arr::first($this->serviceProviders, function ($value, $key) use ($name) {
            return $value instanceof $name;
        });
    }

    /**
     * Resolve a service provider instance from the class name.
     *
     * @param  string  $provider
     * @return \Royalcms\Component\Support\ServiceProvider
     */
    public function resolveProviderClass($provider)
    {
        return new $provider($this);
    }

    /**
     * Mark the given provider as registered.
     *
     * @param  \Royalcms\Component\Support\ServiceProvider  $provider
     * @return void
     */
    protected function markAsRegistered($provider)
    {
        $this['events']->fire($class = get_class($provider), [$provider]);

        $this->serviceProviders[] = $provider;

        $this->loadedProviders[$class] = true;
    }

    /**
     * Load and boot all of the remaining deferred providers.
     *
     * @return void
     */
    public function loadDeferredProviders()
    {
        // We will simply spin through each of the deferred providers and register each
        // one and boot them if the application has booted. This should make each of
        // the remaining services available to this application for immediate use.
        foreach ($this->deferredServices as $service => $provider) {
            $this->loadDeferredProvider($service);
        }

        $this->deferredServices = [];
    }

    /**
     * Load the provider for a deferred service.
     *
     * @param  string  $service
     * @return void
     */
    public function loadDeferredProvider($service)
    {
        if (! isset($this->deferredServices[$service])) {
            return;
        }

        $provider = $this->deferredServices[$service];

        // If the service provider has not already been loaded and registered we can
        // register it with the application and remove the service from this list
        // of deferred services, since it will already be loaded on subsequent.
        if (! isset($this->loadedProviders[$provider])) {
            $this->registerDeferredProvider($provider, $service);
        }
    }

    /**
     * Register a deferred provider and service.
     *
     * @param  string  $provider
     * @param  string  $service
     * @return void
     */
    public function registerDeferredProvider($provider, $service = null)
    {
        // Once the provider that provides the deferred service has been registered we
        // will remove it from our local list of the deferred services with related
        // providers so that this container does not try to resolve it out again.
        if ($service) {
            unset($this->deferredServices[$service]);
        }

        $this->register($instance = new $provider($this));

        if (! $this->booted) {
            $this->booting(function () use ($instance) {
                $this->bootProvider($instance);
            });
        }
    }

    /**
     * Resolve the given type from the container.
     *
     * (Overriding Container::make)
     *
     * @param  string  $abstract
     * @param  array   $parameters
     * @return mixed
     */
    public function make($abstract, array $parameters = [])
    {
        $abstract = $this->getAlias($abstract);

        if (isset($this->deferredServices[$abstract])) {
            $this->loadDeferredProvider($abstract);
        }

        return parent::make($abstract, $parameters);
    }

    /**
     * Determine if the given abstract type has been bound.
     *
     * (Overriding Container::bound)
     *
     * @param  string  $abstract
     * @return bool
     */
    public function bound($abstract)
    {
        return isset($this->deferredServices[$abstract]) || parent::bound($abstract);
    }

    /**
     * Determine if the application has booted.
     *
     * @return bool
     */
    public function isBooted()
    {
        return $this->booted;
    }

    /**
     * Boot the application's service providers.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->booted) {
            return;
        }

        // Once the application has booted we will also fire some "booted" callbacks
        // for any listeners that need to do work after this initial booting gets
        // finished. This is useful when ordering the boot-up processes we run.
        $this->fireAppCallbacks($this->bootingCallbacks);

        array_walk($this->serviceProviders, function ($p) {
            $this->bootProvider($p);
        });

        $this->booted = true;

        $this->fireAppCallbacks($this->bootedCallbacks);
    }

    /**
     * Boot the given service provider.
     *
     * @param  \Royalcms\Component\Support\ServiceProvider  $provider
     * @return mixed
     */
    protected function bootProvider(ServiceProvider $provider)
    {
        if (method_exists($provider, 'boot')) {
            return $this->call([$provider, 'boot']);
        }
    }

    /**
     * Register a new boot listener.
     *
     * @param  mixed  $callback
     * @return void
     */
    public function booting($callback)
    {
        $this->bootingCallbacks[] = $callback;
    }

    /**
     * Register a new "booted" listener.
     *
     * @param  mixed  $callback
     * @return void
     */
    public function booted($callback)
    {
        $this->bootedCallbacks[] = $callback;

        if ($this->isBooted()) {
            $this->fireAppCallbacks([$callback]);
        }
    }

    /**
     * Call the booting callbacks for the application.
     *
     * @param  array  $callbacks
     * @return void
     */
    protected function fireAppCallbacks(array $callbacks)
    {
        foreach ($callbacks as $callback) {
            call_user_func($callback, $this);
        }
    }

    /**
     * Handles a Request to convert it to a Response.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param int $type
     * @param bool $catch
     * @return mixed
     */
    public function handle(SymfonyRequest $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        return $this['Royalcms\Component\Contracts\Http\Kernel']->handle(Request::createFromBase($request));
    }

    /**
     * Determine if middleware has been disabled for the application.
     *
     * @return bool
     */
    public function shouldSkipMiddleware()
    {
        return $this->bound('middleware.disable') &&
               $this->make('middleware.disable') === true;
    }

    /**
     * Determine if the application configuration is cached.
     *
     * @return bool
     */
    public function configurationIsCached()
    {
        return $this['files']->exists($this->getCachedConfigPath());
    }

    /**
     * Get the path to the configuration cache file.
     *
     * @return string
     */
    public function getCachedConfigPath()
    {
        if ($this->vendorIsWritableForOptimizations())
        {
            return $this->contentPath().'/bootstrap/cache/config.php';
        }
        else
        {
            return $this->storagePath().'/framework/config.php';
        }
    }

    /**
     * Get the path to the translation cache file.
     *
     * @return string
     */
    public function getCachedTranslationPath($locale = null)
    {
        if (is_null($locale))
        {
            $locale = $this['config']->get('system.locale');
        }

        if ($this->vendorIsWritableForOptimizations())
        {
            return $this->contentPath()."/bootstrap/cache/{$locale}.php";
        }
        else
        {
            return $this->storagePath()."/framework/{$locale}.php";
        }
    }

    /**
     * Determine if the application routes are cached.
     *
     * @return bool
     */
    public function routesAreCached()
    {
        return $this['files']->exists($this->getCachedRoutesPath());
    }

    /**
     * Get the path to the routes cache file.
     *
     * @return string
     */
    public function getCachedRoutesPath()
    {
        if ($this->vendorIsWritableForOptimizations())
        {
            return $this->contentPath().'/bootstrap/cache/routes.php';
        }
        else
        {
            return $this->storagePath().'/framework/routes.php';
        }
    }

    /**
     * Get the path to the cached "compiled.php" file.
     *
     * @return string
     */
    public function getCachedCompilePath()
    {
        if ($this->vendorIsWritableForOptimizations())
        {
            return $this->contentPath().'/bootstrap/cache/compiled.php';
        }
        else
        {
            return $this->storagePath().'/framework/compiled.php';
        }
    }

    /**
     * Get the path to the cached services.json file.
     *
     * @return string
     */
    public function getCachedServicesPath()
    {
        if ($this->vendorIsWritableForOptimizations())
        {
            return $this->contentPath().'/bootstrap/cache/services.json';
        }
        else
        {
            return $this->storagePath().'/framework/services.json';
        }
    }

    /**
     * Determine if vendor path is writable.
     *
     * @return bool
     */
    public function vendorIsWritableForOptimizations()
    {
        if ($this->useStoragePathForOptimizations) return false;

        return is_writable($this->basePath().'/vendor');
    }

    /**
     * Determines if storage directory should be used for optimizations.
     *
     * @param  bool  $value
     * @return $this
     */
    public function useStoragePathForOptimizations($value = true)
    {
        $this->useStoragePathForOptimizations = $value;

        return $this;
    }

    /**
     * Determine if the application is currently down for maintenance.
     *
     * @return bool
     */
    public function isDownForMaintenance()
    {
        return file_exists($this->storagePath().'/framework/down');
    }

    /**
     * Throw an HttpException with the given data.
     *
     * @param  int     $code
     * @param  string  $message
     * @param  array   $headers
     * @return void
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function abort($code, $message = '', array $headers = [])
    {
        if ($code == 404) {
            throw new NotFoundHttpException($message);
        }

        throw new HttpException($code, $message, null, $headers);
    }

    /**
     * Register a 404 error handler.
     *
     * @royalcms royalcms
     * @param  Closure  $callback
     * @return void
     */
    public function missing(Closure $callback)
    {
        $this->error(function(NotFoundHttpException $e) use ($callback)
        {
            return call_user_func($callback, $e);
        });
    }

    /**
     * Register an application error handler.
     *
     * @royalcms royalcms
     * @param  \Closure  $callback
     * @return void
     */
    public function error(Closure $callback)
    {
        $this['exception.handler']->error($callback);
    }

    /**
     * Register an error handler at the bottom of the stack.
     *
     * @royalcms royalcms
     * @param  \Closure  $callback
     * @return void
     */
    public function pushError(Closure $callback)
    {
        $this['exception.handler']->pushError($callback);
    }

    /**
     * Register an error handler for fatal errors.
     *
     * @royalcms royalcms
     * @param  Closure  $callback
     * @return void
     */
    public function fatal(Closure $callback)
    {
        $this->error(function(\Symfony\Component\Debug\Exception\FatalErrorException $e) use ($callback)
        {
            return call_user_func($callback, $e);
        });
    }

    /**
     * Register a terminating callback with the application.
     *
     * @param  \Closure  $callback
     * @return $this
     */
    public function terminating(Closure $callback)
    {
        $this->terminatingCallbacks[] = $callback;

        return $this;
    }

    /**
     * Terminate the application.
     *
     * @return void
     */
    public function terminate()
    {
        foreach ($this->terminatingCallbacks as $terminating) {
            $this->call($terminating);
        }
    }

    /**
     * Get the service providers that have been loaded.
     *
     * @return array
     */
    public function getLoadedProviders()
    {
        return $this->loadedProviders;
    }

    /**
     * Get the application's deferred services.
     *
     * @return array
     */
    public function getDeferredServices()
    {
        return $this->deferredServices;
    }

    /**
     * Set the application's deferred services.
     *
     * @param  array  $services
     * @return void
     */
    public function setDeferredServices(array $services)
    {
        $this->deferredServices = $services;
    }

    /**
     * Add an array of services to the application's deferred services.
     *
     * @param  array  $services
     * @return void
     */
    public function addDeferredServices(array $services)
    {
        $this->deferredServices = array_merge($this->deferredServices, $services);
    }

    /**
     * Determine if the given service is a deferred service.
     *
     * @param  string  $service
     * @return bool
     */
    public function isDeferredService($service)
    {
        return isset($this->deferredServices[$service]);
    }

    /**
     * Define a callback to be used to configure Monolog.
     *
     * @param  callable  $callback
     * @return $this
     */
    public function configureMonologUsing(callable $callback)
    {
        $this->monologConfigurator = $callback;

        return $this;
    }

    /**
     * Determine if the application has a custom Monolog configurator.
     *
     * @return bool
     */
    public function hasMonologConfigurator()
    {
        return ! is_null($this->monologConfigurator);
    }

    /**
     * Get the custom Monolog configurator for the application.
     *
     * @return callable
     */
    public function getMonologConfigurator()
    {
        return $this->monologConfigurator;
    }

    /**
     * Get the current application locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this['config']->get('system.locale');
    }

    /**
     * Set the current application locale.
     *
     * @param  string  $locale
     * @return void
     */
    public function setLocale($locale)
    {
        $this['config']->set('system.locale', $locale);

        $this['translator']->setLocale($locale);

        $this['events']->fire('locale.changed', [$locale]);
    }

    /**
     * Register the core class aliases in the container.
     *
     * @return void
     */
    public function registerCoreContainerAliases()
    {
        $aliases = [
            'royalcms'             => ['Royalcms\Component\Foundation\Royalcms', 'Royalcms\Component\Contracts\Container\Container', 'Royalcms\Component\Contracts\Foundation\Royalcms'],
            'auth'                 => 'Royalcms\Component\Auth\AuthManager',
            'auth.driver'          => ['Royalcms\Component\Auth\Guard', 'Royalcms\Component\Contracts\Auth\Guard'],
            'auth.password.tokens' => 'Royalcms\Component\Auth\Passwords\TokenRepositoryInterface',
            'blade.compiler'       => 'Royalcms\Component\View\Compilers\BladeCompiler',
            'cache'                => ['Royalcms\Component\Cache\CacheManager', 'Royalcms\Component\Contracts\Cache\Factory'],
            'cache.store'          => ['Royalcms\Component\Cache\Repository', 'Royalcms\Component\Contracts\Cache\Repository'],
            'config'               => ['Royalcms\Component\Config\Repository', 'Royalcms\Component\Contracts\Config\Repository'],
            'cookie'               => ['Royalcms\Component\Cookie\CookieJar', 'Royalcms\Component\Contracts\Cookie\Factory', 'Royalcms\Component\Contracts\Cookie\QueueingFactory'],
            'encrypter'            => ['Royalcms\Component\Encryption\Encrypter', 'Royalcms\Component\Contracts\Encryption\Encrypter'],
            'db'                   => 'Royalcms\Component\Database\DatabaseManager',
            'db.connection'        => ['Royalcms\Component\Database\Connection', 'Royalcms\Component\Database\ConnectionInterface'],
            'events'               => ['Royalcms\Component\Events\Dispatcher', 'Royalcms\Component\Contracts\Events\Dispatcher'],
            'files'                => 'Royalcms\Component\Filesystem\Filesystem',
            'filesystem'           => ['Royalcms\Component\Filesystem\FilesystemManager', 'Royalcms\Component\Contracts\Filesystem\Factory'],
            'filesystem.disk'      => 'Royalcms\Component\Contracts\Filesystem\Filesystem',
            'filesystem.cloud'     => 'Royalcms\Component\Contracts\Filesystem\Cloud',
            'hash'                 => 'Royalcms\Component\Contracts\Hashing\Hasher',
            'translator'           => ['Royalcms\Component\Translation\Translator', 'Symfony\Component\Translation\TranslatorInterface'],
            'log'                  => ['Royalcms\Component\Log\Writer', 'Royalcms\Component\Contracts\Logging\Log', 'Psr\Log\LoggerInterface'],
            'mailer'               => ['Royalcms\Component\Mail\Mailer', 'Royalcms\Component\Contracts\Mail\Mailer', 'Royalcms\Component\Contracts\Mail\MailQueue'],
            'auth.password'        => ['Royalcms\Component\Auth\Passwords\PasswordBroker', 'Royalcms\Component\Contracts\Auth\PasswordBroker'],
            'queue'                => ['Royalcms\Component\Queue\QueueManager', 'Royalcms\Component\Contracts\Queue\Factory', 'Royalcms\Component\Contracts\Queue\Monitor'],
            'queue.connection'     => 'Royalcms\Component\Contracts\Queue\Queue',
            'redirect'             => 'Royalcms\Component\Routing\Redirector',
            'redis'                => ['Royalcms\Component\Redis\Database', 'Royalcms\Component\Contracts\Redis\Database'],
            'request'              => 'Royalcms\Component\Http\Request',
            'router'               => ['Royalcms\Component\Routing\Router', 'Royalcms\Component\Contracts\Routing\Registrar'],
            'session'              => 'Royalcms\Component\Session\SessionManager',
            'session.store'        => ['Royalcms\Component\Session\Store', 'Symfony\Component\HttpFoundation\Session\SessionInterface'],
            'url'                  => ['Royalcms\Component\Routing\UrlGenerator', 'Royalcms\Component\Contracts\Routing\UrlGenerator'],
            'validator'            => ['Royalcms\Component\Validation\Factory', 'Royalcms\Component\Contracts\Validation\Factory'],
            'view'                 => ['Royalcms\Component\View\Factory', 'Royalcms\Component\Contracts\View\Factory'],
        ];

        foreach ($aliases as $key => $aliases) {
            foreach ((array) $aliases as $alias) {
                $this->alias($key, $alias);
            }
        }
    }

    /**
     * Flush the container of all bindings and resolved instances.
     *
     * @return void
     */
    public function flush()
    {
        parent::flush();

        $this->loadedProviders = [];
    }

    /**
     * Get the used kernel object.
     *
     * @return \Royalcms\Component\Contracts\Console\Kernel|\Royalcms\Component\Contracts\Http\Kernel
     */
    protected function getKernel()
    {
        $kernelContract = $this->runningInConsole()
                    ? 'Royalcms\Component\Contracts\Console\Kernel'
                    : 'Royalcms\Component\Contracts\Http\Kernel';

        return $this->make($kernelContract);
    }

    /**
     * Get the application namespace.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public function getNamespace()
    {
        if (! is_null($this->namespace)) {
            return $this->namespace;
        }

        $composer = json_decode(file_get_contents(base_path('composer.json')), true);

        foreach ((array) data_get($composer, 'autoload.psr-4') as $namespace => $path) {
            foreach ((array) $path as $pathChoice) {
                if (realpath(app_path()) == realpath(base_path().'/'.$pathChoice)) {
                    return $this->namespace = $namespace;
                }
            }
        }

        throw new RuntimeException('Unable to detect application namespace.');
    }

    /**
     * Register a maintenance mode event listener.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public function down(Closure $callback)
    {
        $this['events']->listen('royalcms.app.down', $callback);
    }

}
