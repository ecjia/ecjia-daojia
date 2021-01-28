<?php

namespace Royalcms\Component\Foundation;

use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Illuminate\Support\Env;
use Illuminate\Support\Str;
use Royalcms\Component\Exception\ExceptionRenderInterface;
use Royalcms\Component\Foundation\PackageManifest;
use Royalcms\Component\Container\ContainerServiceProvider;
use Royalcms\Component\Contracts\ContractsServiceProvider;
use Royalcms\Component\Filesystem\FilesystemServiceProvider;
use Royalcms\Component\Http\HttpServiceProvider;
use Royalcms\Component\Support\SupportServiceProvider;
use Royalcms\Component\Filesystem\Filesystem;
use Royalcms\Component\Events\EventServiceProvider;
use Royalcms\Component\Routing\RoutingServiceProvider;
use Royalcms\Component\Log\LogServiceProvider;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Royalcms\Component\Contracts\Foundation\Royalcms as RoyalcmsContract;
use Royalcms\Component\Contracts\Container\Container as ContainerContracts;

class Royalcms extends Application implements RoyalcmsContract, ContainerContracts
{
    /**
     * The Royalcms framework version.
     *
     * @var string
     */
    const VERSION = '8.3.0';

    /**
     * The Royalcms framework release.
     *
     * @var string
     */
    const RELEASE = '2020-12-31';

    /**
     * A custom callback used to configure Monolog.
     *
     * @var callable|null
     */
    protected $monologConfigurator;

    /**
     * Indicates if the storage directory should be used for optimizations.
     *
     * @var bool
     */
    protected $useStoragePathForOptimizations = false;

    /**
     * The custom system path defined by the developer.
     *
     * @var string
     */
    protected $systemPath;

    /**
     * The custom site name defined by the developer.
     *
     * @var string
     */
    protected $site;

    /**
     * Create a new Royalcms application instance.
     *
     * @param  string|null  $basePath
     * @return void
     */
    public function __construct($basePath = null)
    {
        $basePath = realpath($basePath);

        parent::__construct($basePath);
    }

    /**
     * Get the version number of the royalcms.
     *
     * @return string
     */
    public function version()
    {
        return $this->laravelVersion();
    }

    /**
     * Get the version number of the laravel.
     *
     * @return string
     */
    public function laravelVersion()
    {
        return Application::VERSION;
    }

    /**
     * Get the version number of the laravel.
     *
     * @return string
     */
    public function royalcmsVersion()
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
        parent::registerBaseBindings();

        $this->instance(PackageManifest::class, new PackageManifest(
            new \Illuminate\Filesystem\Filesystem, $this->basePath(), $this->getCachedPackagesPath()
        ));

        $this->instance('royalcms', $this);
    }

    /**
     * Register all of the base service providers.
     *
     * @return void
     */
    protected function registerBaseServiceProviders()
    {
        $this->register(new EventServiceProvider($this));
        $this->register(new LogServiceProvider($this));
        $this->register(new RoutingServiceProvider($this));
        $this->register(new HttpServiceProvider($this));
        $this->register(new FilesystemServiceProvider($this));
        $this->register(new ContainerServiceProvider($this));
        $this->register(new ContractsServiceProvider($this));
        $this->register(new SupportServiceProvider($this));
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
     * Bind all of the application paths in the container.
     *
     * @return void
     */
    protected function bindPathsInContainer()
    {
        $this->instance('path', $this->path());
        $this->instance('path.base', $this->basePath());
        $this->instance('path.content', $this->contentPath());
        $this->instance('path.site', $this->sitePath());
        $this->instance('path.system', $this->systemPath());
        $this->instance('path.config', $this->configPath());
        $this->instance('path.public', $this->publicPath());
        $this->instance('path.database', $this->databasePath());
        $this->instance('path.lang', $this->langPath());
        $this->instance('path.app', $this->appPath());
        $this->instance('path.plugin', $this->pluginPath());
        $this->instance('path.theme', $this->themePath());
        $this->instance('path.upload', $this->uploadPath());
        $this->instance('path.storage', $this->storagePath());
        $this->instance('path.bootstrap', $this->bootstrapPath());
        $this->instance('path.resource', $this->resourcePath());
        $this->instance('path.vendor', $this->vendorPath());
        $this->instance('path.test', $this->testPath());
    }

    /**
     * Get the path to the application current "site" directory.
     *
     * @param  string  $path
     * @return string
     */
    public function path($path = '')
    {
        if ($this->runningInSite()) {
            $appPath = $this->sitePath().DIRECTORY_SEPARATOR.$this->currentSite();
        } else {
            $appPath = $this->basePath();
        }

        return $appPath . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Get the base path of the Royalcms installation.
     *
     * @param  string  $path Optionally, a path to append to the base path
     * @return string
     */
    public function basePath($path = '')
    {
        return $this->basePath.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the content path of the Royalcms installation.
     *
     * @return string
     */
    public function contentPath()
    {
        return $this->basePath().DIRECTORY_SEPARATOR.'content';
    }

    /**
     * Get the site content path of the Royalcms installation.
     *
     * @return string
     */
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
    public function systemPath($path = null)
    {
        if ($this->systemPath) {
            $basePath = $this->systemPath;
        } else {
            $basePath = $this->siteContentPath().DIRECTORY_SEPARATOR.'system';

            if (! ($this->runningInSite() && is_dir($basePath))) {
                $basePath = $this->contentPath().DIRECTORY_SEPARATOR.'system';
            }
        }

        return $basePath . ($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Set the database directory.
     *
     * @param  string  $path
     * @return $this
     */
    public function useSystemPath($path)
    {
        $this->databasePath = $path;

        $this->instance('path.system', $path);

        return $this;
    }

    /**
     * Get the path to the bootstrap app files.
     *
     * @return string
     */
    public function bootstrapPath($path = '')
    {
        $basePath = $this->siteContentPath().DIRECTORY_SEPARATOR.'bootstrap';

        if (! ($this->runningInSite() && is_dir($basePath))) {
            $basePath = $this->contentPath().DIRECTORY_SEPARATOR.'bootstrap';
        }

        return $basePath.($path ? DIRECTORY_SEPARATOR.$path : $path);
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
    public function themePath($dir = null)
    {
        if (! is_null($dir)) {
            $dir = DIRECTORY_SEPARATOR . $dir;
        }

        $path = $this->siteContentPath().DIRECTORY_SEPARATOR.'themes'.$dir;

        if ($this->runningInSite() && is_dir($path)) {
            return $path;
        } else {
            return $this->contentPath().DIRECTORY_SEPARATOR.'themes'.$dir;
        }
    }

    /**
     * Get the path to the application theme files.
     *
     * @return string
     */
    public function uploadPath($dir = null)
    {
        if (! is_null($dir)) {
            $dir = DIRECTORY_SEPARATOR . $dir;
        }

        $path = $this->siteContentPath().DIRECTORY_SEPARATOR.'uploads'.$dir;

        if ($this->runningInSite() && is_dir($path)) {
            return $path;
        } else {
            return $this->contentPath().DIRECTORY_SEPARATOR.'uploads'.$dir;
        }
    }

    /**
     * Get the path to the resources files.
     *
     * @return string
     */
    public function resourcePath($dir = null)
    {
        if (! is_null($dir)) {
            $dir = DIRECTORY_SEPARATOR . $dir;
        }

        $path = $this->siteContentPath().DIRECTORY_SEPARATOR.'resources'.$dir;

        if ($this->runningInSite() && is_dir($path)) {
            return $path;
        } else {
            return $this->contentPath().DIRECTORY_SEPARATOR.'resources'.$dir;
        }
    }

    /**
     * Get the path to the application theme files.
     *
     * @return string
     */
    public function testPath($dir = null)
    {
        if (! is_null($dir)) {
            $dir = DIRECTORY_SEPARATOR . $dir;
        }

        $path = $this->siteContentPath().DIRECTORY_SEPARATOR.'tests'.$dir;

        if ($this->runningInSite() && is_dir($path)) {
            return $path;
        } else {
            return $this->contentPath().DIRECTORY_SEPARATOR.'tests'.$dir;
        }
    }

    /**
     * Get the path to the application configuration files.
     *
     * @return string
     */
    public function configPath($dir = null)
    {
        if (! is_null($dir)) {
            $dir = DIRECTORY_SEPARATOR . $dir;
        }

        $path = $this->siteContentPath().DIRECTORY_SEPARATOR.'configs'.$dir;

        if ($this->runningInSite() && is_dir($path)) {
            return $path;
        } else {
            return $this->contentPath().DIRECTORY_SEPARATOR.'configs'.$dir;
        }
    }

    /**
     * Get the path to the database directory.
     *
     * @return string
     */
    public function databasePath($path = '')
    {
        if ($this->databasePath) {
            $basePath = $this->databasePath;
        } else {

            $basePath = $this->siteContentPath().DIRECTORY_SEPARATOR.'database';

            if (! ($this->runningInSite() && is_dir($basePath))) {
                $basePath = $this->contentPath().DIRECTORY_SEPARATOR.'database';
            }

        }

        return $basePath . ($path ? DIRECTORY_SEPARATOR.$path : $path);
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
    public function langPath($dir = null)
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
     * @param  string  $path Optionally, a path to append to the storage path
     * @return string
     */
    public function storagePath($path = '')
    {
        if ($this->storagePath) {
            $basePath = $this->storagePath;
        } else {

            $basePath = $this->siteContentPath().DIRECTORY_SEPARATOR.'storages';

            if (! ($this->runningInSite() && is_dir($basePath)) ) {
                $basePath = $this->contentPath().DIRECTORY_SEPARATOR.'storages';
            }

        }

        return $basePath . ($path ? DIRECTORY_SEPARATOR.$path : $path);
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

    public function useSiteDirectory($site)
    {
        $this->site = $site;

        return $this;
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
     * Return current Site directory name.
     *
     * @return string
     */
    public function currentSite()
    {
        if (empty($this->site) && defined('RC_SITE')) {
            $this->site = RC_SITE;
        }

        return $this->site;
    }

    /**
     * Register all of the configured providers.
     *
     * @return void
     */
    public function registerConfiguredProviders()
    {
        $providers = Collection::make($this->config['coreservice.providers'])
            ->partition(function ($provider) {
                return Str::startsWith($provider, 'Royalcms\\Component\\') || Str::startsWith($provider, 'Illuminate\\');
            });

        $providers->splice(1, 0, [$this->make(PackageManifest::class)->providers()]);

        $manifestPath = $this->getCachedServicesPath();

        (new ProviderRepository($this, new Filesystem, $manifestPath))
                    ->load($providers->collapse()->toArray());
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
        $class = is_string($provider) ? $provider : get_class($provider);

        $this['events']->fire($class, [$provider]);

        $this->serviceProviders[] = $provider;

        $this->loadedProviders[$class] = true;
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
            $path = $this->bootstrapPath().'/cache/routes.php';
        }
        else
        {
            $path = $this->storagePath().'/framework/routes.php';
        }

        return Env::get('APP_ROUTES_CACHE', $path);
    }

    /**
     * Get the path to the cached "compiled.php" file.
     *
     * @return string
     */
    public function getCachedCompilePath()
    {
        $path = $this->contentPath().'/bootstrap/cache/compiled.php';

        return Env::get('APP_COMPILED_CACHE', $path);
    }

    /**
     * Get the path to the cached "aliases.php" file.
     *
     * @return string
     */
    public function getCachedAliasesPath()
    {
        $path = $this->contentPath().'/bootstrap/cache/aliases.php';

        return Env::get('APP_ALIASES_CACHE', $path);
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
     * Get the path to the cached application_packages.php file.
     *
     * @return string
     */
    public function getCachedAppPackagesPath()
    {
        return $this->normalizeCachePath('APP_APPPACKAGES_CACHE', 'cache/apppackages.php');
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
     * Register an application error handler.
     *
     * @royalcms royalcms
     * @param  \Closure  $callback
     * @return void
     */
    public function errorRender(ExceptionRenderInterface $callback)
    {
        $this['exception.handler']->errorRender($callback);
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
        $this->error(function(\Symfony\Component\Debug\Exception\FatalThrowableError $e) use ($callback)
        {
            return call_user_func($callback, $e);
        });
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
            'royalcms'             => [
                'Royalcms\Component\Foundation\Royalcms',
                'Royalcms\Component\Contracts\Container\Container',
                'Royalcms\Component\Contracts\Foundation\Royalcms',
                \Illuminate\Contracts\Container\Container::class,
                \Illuminate\Contracts\Foundation\Application::class,
                \Illuminate\Foundation\Application::class,
                \Psr\Container\ContainerInterface::class,
            ],
            'auth'                 => [
                'Royalcms\Component\Auth\AuthManager',
                \Illuminate\Auth\AuthManager::class,
                \Illuminate\Contracts\Auth\Factory::class
            ],
            'auth.driver'          => [
                'Royalcms\Component\Auth\Guard',
                'Royalcms\Component\Contracts\Auth\Guard',
                \Illuminate\Contracts\Auth\Guard::class
            ],
            'auth.password.tokens' => [
                'Royalcms\Component\Auth\Passwords\TokenRepositoryInterface'
            ],
            'blade.compiler'       => [
                'Royalcms\Component\View\Compilers\BladeCompiler',
                \Illuminate\View\Compilers\BladeCompiler::class
            ],
            'cache'                => [
                'Royalcms\Component\Cache\CacheManager',
                'Royalcms\Component\Contracts\Cache\Factory',
                \Illuminate\Cache\CacheManager::class,
                \Illuminate\Contracts\Cache\Factory::class
            ],
            'cache.store'          => [
                'Royalcms\Component\Cache\Repository',
                'Royalcms\Component\Contracts\Cache\Repository',
                \Illuminate\Cache\Repository::class,
                \Illuminate\Contracts\Cache\Repository::class,
                \Psr\SimpleCache\CacheInterface::class
            ],
            'cache.psr6'           => [
                \Symfony\Component\Cache\Adapter\Psr16Adapter::class,
                \Symfony\Component\Cache\Adapter\AdapterInterface::class,
                \Psr\Cache\CacheItemPoolInterface::class
            ],
            'config'               => [
                'Royalcms\Component\Config\Repository',
                'Royalcms\Component\Contracts\Config\Repository',
                \Illuminate\Config\Repository::class,
                \Illuminate\Contracts\Config\Repository::class
            ],
            'cookie'               => [
                'Royalcms\Component\Cookie\CookieJar',
                'Royalcms\Component\Contracts\Cookie\Factory',
                'Royalcms\Component\Contracts\Cookie\QueueingFactory',
                \Illuminate\Cookie\CookieJar::class,
                \Illuminate\Contracts\Cookie\Factory::class,
                \Illuminate\Contracts\Cookie\QueueingFactory::class
            ],
            'encrypter'            => [
                'Royalcms\Component\Encryption\Encrypter',
                'Royalcms\Component\Contracts\Encryption\Encrypter',
                \Illuminate\Encryption\Encrypter::class,
                \Illuminate\Contracts\Encryption\Encrypter::class
            ],
            'db'                   => [
                'Royalcms\Component\Database\DatabaseManager',
                \Illuminate\Database\DatabaseManager::class,
                \Illuminate\Database\ConnectionResolverInterface::class
            ],
            'db.connection'        => [
                'Royalcms\Component\Database\Connection',
                'Royalcms\Component\Database\ConnectionInterface',
                \Illuminate\Database\Connection::class,
                \Illuminate\Database\ConnectionInterface::class
            ],
            'events'               => [
                'Royalcms\Component\Events\Dispatcher',
                'Royalcms\Component\Contracts\Events\Dispatcher',
                \Illuminate\Events\Dispatcher::class,
                \Illuminate\Contracts\Events\Dispatcher::class
            ],
            'files'                => [
                'Royalcms\Component\Filesystem\Filesystem',
                \Illuminate\Filesystem\Filesystem::class
            ],
            'filesystem'           => [
                'Royalcms\Component\Filesystem\FilesystemManager',
                'Royalcms\Component\Contracts\Filesystem\Factory',
                \Illuminate\Filesystem\FilesystemManager::class,
                \Illuminate\Contracts\Filesystem\Factory::class
            ],
            'filesystem.disk'      => [
                'Royalcms\Component\Contracts\Filesystem\Filesystem',
                \Illuminate\Contracts\Filesystem\Filesystem::class
            ],
            'filesystem.cloud'     => [
                'Royalcms\Component\Contracts\Filesystem\Cloud',
                \Illuminate\Contracts\Filesystem\Cloud::class
            ],
            'hash'                 => [
                'Royalcms\Component\Contracts\Hashing\Hasher',
                \Illuminate\Hashing\HashManager::class
            ],
            'hash.driver'          => [
                \Illuminate\Contracts\Hashing\Hasher::class
            ],
            'translator'           => [
                'Royalcms\Component\Translation\Translator',
                'Symfony\Component\Translation\TranslatorInterface',
                \Illuminate\Translation\Translator::class,
                \Illuminate\Contracts\Translation\Translator::class
            ],
            'log'                  => [
                'Royalcms\Component\Log\Writer',
                'Royalcms\Component\Contracts\Logging\Log',
                'Psr\Log\LoggerInterface',
                \Illuminate\Log\LogManager::class,
                \Psr\Log\LoggerInterface::class
            ],
            'mailer'               => [
                'Royalcms\Component\Mail\Mailer',
                'Royalcms\Component\Contracts\Mail\Mailer',
                'Royalcms\Component\Contracts\Mail\MailQueue',
                \Illuminate\Mail\Mailer::class,
                \Illuminate\Contracts\Mail\Mailer::class,
                \Illuminate\Contracts\Mail\MailQueue::class
            ],
            'auth.password'        => [
                'Royalcms\Component\Auth\Passwords\PasswordBroker',
                'Royalcms\Component\Contracts\Auth\PasswordBroker',
                \Illuminate\Auth\Passwords\PasswordBrokerManager::class,
                \Illuminate\Contracts\Auth\PasswordBrokerFactory::class
            ],
            'auth.password.broker' => [
                \Illuminate\Auth\Passwords\PasswordBroker::class,
                \Illuminate\Contracts\Auth\PasswordBroker::class
            ],
            'queue'                => [
                'Royalcms\Component\Queue\QueueManager',
                'Royalcms\Component\Contracts\Queue\Factory',
                'Royalcms\Component\Contracts\Queue\Monitor',
                \Illuminate\Queue\QueueManager::class,
                \Illuminate\Contracts\Queue\Factory::class,
                \Illuminate\Contracts\Queue\Monitor::class
            ],
            'queue.connection'     => [
                'Royalcms\Component\Contracts\Queue\Queue',
                \Illuminate\Contracts\Queue\Queue::class
            ],
            'queue.failer'         => [
                \Illuminate\Queue\Failed\FailedJobProviderInterface::class
            ],
            'redirect'             => [
                'Royalcms\Component\Routing\Redirector',
                \Illuminate\Routing\Redirector::class
            ],
            'redis'                => [
                'Royalcms\Component\Redis\Database',
                'Royalcms\Component\Contracts\Redis\Database',
                \Illuminate\Redis\RedisManager::class,
                \Illuminate\Contracts\Redis\Factory::class
            ],
            'request'              => [
                'Royalcms\Component\Http\Request',
                \Illuminate\Http\Request::class,
                \Symfony\Component\HttpFoundation\Request::class
            ],
            'router'               => [
                'Royalcms\Component\Routing\Router',
                'Royalcms\Component\Contracts\Routing\Registrar',
                \Illuminate\Routing\Router::class,
                \Illuminate\Contracts\Routing\Registrar::class,
                \Illuminate\Contracts\Routing\BindingRegistrar::class
            ],
            'session'              => [
                'Royalcms\Component\Session\SessionManager',
                \Illuminate\Session\SessionManager::class
            ],
            'session.store'        => [
                'Royalcms\Component\Session\Store',
                'Symfony\Component\HttpFoundation\Session\SessionInterface',
                \Illuminate\Session\Store::class,
                \Illuminate\Contracts\Session\Session::class
            ],
            'url'                  => [
                'Royalcms\Component\Routing\UrlGenerator',
                'Royalcms\Component\Contracts\Routing\UrlGenerator',
                \Illuminate\Routing\UrlGenerator::class,
                \Illuminate\Contracts\Routing\UrlGenerator::class
            ],
            'validator'            => [
                'Royalcms\Component\Validation\Factory',
                'Royalcms\Component\Contracts\Validation\Factory',
                \Illuminate\Validation\Factory::class,
                \Illuminate\Contracts\Validation\Factory::class
            ],
            'view'                 => [
                'Royalcms\Component\View\Factory',
                'Royalcms\Component\Contracts\View\Factory',
                \Illuminate\View\Factory::class,
                \Illuminate\Contracts\View\Factory::class
            ],
        ];

        foreach ($aliases as $key => $aliases) {
            foreach ((array) $aliases as $alias) {
                $this->alias($key, $alias);
            }
        }
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
