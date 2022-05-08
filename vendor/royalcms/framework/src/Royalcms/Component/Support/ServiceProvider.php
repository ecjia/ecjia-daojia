<?php

namespace Royalcms\Component\Support;

use BadMethodCallException;
use ReflectionClass;

abstract class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * The application instance.
     *
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected $royalcms;


    /**
     * Create a new service provider instance.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @return void
     */
    public function __construct($royalcms)
    {
        $this->royalcms = $royalcms;

        parent::__construct($royalcms);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Merge the given configuration with the existing configuration.
     *
     * @param  string  $path
     * @param  string  $key
     * @return void
     */
    protected function mergeConfigFrom($path, $key)
    {
        $config = $this->royalcms['config']->get($key, []);

        $this->royalcms['config']->set($key, array_merge(require $path, $config));
    }

    /**
     * Load the given routes file if routes are not already cached.
     *
     * @param  string  $path
     * @return void
     */
    protected function loadRoutesFrom($path)
    {
        if (! $this->royalcms->routesAreCached()) {
            require $path;
        }
    }

    /**
     * Register a view file namespace.
     *
     * @param  string  $path
     * @param  string  $namespace
     * @return void
     */
    protected function loadViewsFrom($path, $namespace)
    {
        if (is_dir($appPath = $this->royalcms->contentPath().'/resources/views/vendor/'.$namespace)) {
            $this->royalcms['view']->addNamespace($namespace, $appPath);
        }

        $this->royalcms['view']->addNamespace($namespace, $path);
    }

    /**
     * Register a translation file namespace.
     *
     * @param  string  $path
     * @param  string  $namespace
     * @return void
     */
    protected function loadTranslationsFrom($path, $namespace)
    {
        $this->royalcms['translator']->addNamespace($namespace, $path);
    }

    /**
     * Register the package's component namespaces.
     *
     * @royalcms 5.0.0
     * @param  string  $package
     * @param  string  $namespace
     * @param  string  $path
     * @return void
     */
    public function package($package, $namespace = null, $path = null)
    {
        $namespace = $this->getPackageNamespace($package, $namespace);

        // In this method we will register the configuration package for the package
        // so that the configuration options cleanly cascade into the application
        // folder to make the developers lives much easier in maintaining them.
        $path = $path ?: $this->guessPackagePath($package);

        $config = $path.'/config';

        if ($this->royalcms['files']->isDirectory($config))
        {
            $this->royalcms['config']->package($package, $config, $namespace);
        }

        // Next we will check for any "language" components. If language files exist
        // we will register them with this given package's namespace so that they
        // may be accessed using the translation facilities of the application.
        $lang = $path.'/lang';

        if ($this->royalcms['files']->isDirectory($lang))
        {
            $this->royalcms['translator']->addNamespace($namespace, $lang);
        }

        // Next, we will see if the application view folder contains a folder for the
        // package and namespace. If it does, we'll give that folder precedence on
        // the loader list for the views so the package views can be overridden.
        $appView = $this->getAppViewPath($package);

        if ($this->royalcms['files']->isDirectory($appView))
        {
            $this->royalcms['view']->addNamespace($namespace, $appView);
        }

        // Finally we will register the view namespace so that we can access each of
        // the views available in this package. We use a standard convention when
        // registering the paths to every package's views and other components.
        $view = $path.'/views';

        if ($this->royalcms['files']->isDirectory($view))
        {
            $this->royalcms['view']->addNamespace($namespace, $view);
        }
    }

    /**
     * Guess the package path for the provider.
     *
     * @royalcms 5.0.0
     * @return string
     */
    public function guessPackagePath($package = null)
    {
        $path = $this->royalcms['path.vendor'] . '/' . $package;

        if ($this->royalcms['files']->isDirectory($path))
        {
            return $path;
        }
        else
        {
            $path = with(new ReflectionClass($this))->getFileName();
            return realpath(dirname($path).'/../../../');
        }
    }

    /**
     * Guess the package path for the provider.
     *
     * @royalcms 5.0.0
     * @return string
     */
    public static function guessPackageClassPath($package = null)
    {
        if (strpos($package, 'royalcms/', 0) !== false) {
            $path = base_path() . '/vendor/'.$package.'/Royalcms/Component/'.self::normalizeName(str_replace('royalcms/', '', $package));
            return $path;
        }
        else
        {
            $path = base_path() . '/vendor/' . $package;
            return $path;
        }
    }

    /**
     * @royalcms 5.0.0
     * @param $name
     * @return string
     */
    protected static function normalizeName($name)
    {
        // convert foo-bar to FooBar
        $name = implode('', array_map('ucfirst', explode('-', $name)));

        // convert foo_bar to FooBar
        $name = implode('', array_map('ucfirst', explode('_', $name)));

        // convert foot/bar to Foo\Bar
        $name = implode('\\', array_map('ucfirst', explode('/', $name)));

        return $name;
    }

    /**
     * Determine the namespace for a package.
     *
     * @royalcms 5.0.0
     * @param  string  $package
     * @param  string  $namespace
     * @return string
     */
    protected function getPackageNamespace($package, $namespace)
    {
        if (is_null($namespace))
        {
            list($vendor, $namespace) = explode('/', $package);
        }

        return $namespace;
    }

    /**
     * Get the application package view path.
     *
     * @todo royalcms
     * @param  string  $package
     * @return string
     */
    protected function getAppViewPath($package)
    {
        return $this->royalcms['path']."/views/packages/{$package}";
    }

    /**
     * Register the package's custom Artisan commands.
     *
     * @param  array|mixed  $commands
     * @return void
     */
    public function commands($commands)
    {
        $commands = is_array($commands) ? $commands : func_get_args();

        // To register the commands with Artisan, we will grab each of the arguments
        // passed into the method and listen for Artisan "start" event which will
        // give us the Artisan console instance which we will give commands to.
        $events = $this->royalcms['events'];

        $events->listen('royalcms.start', function ($artisan) use ($commands) {
            $artisan->resolveCommands($commands);
        });
    }

    /**
     * Get a list of files that should be compiled for the package.
     *
     * @return array
     */
    public static function compiles()
    {
        return [];
    }

    /**
     * Dynamically handle missing method calls.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if ($method == 'boot') {
            return;
        }

        throw new BadMethodCallException("Call to undefined method [{$method}]");
    }
}
