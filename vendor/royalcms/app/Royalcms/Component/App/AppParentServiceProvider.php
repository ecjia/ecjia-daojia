<?php 

namespace Royalcms\Component\App;

use ReflectionClass;
use Royalcms\Component\Support\ServiceProvider;

abstract class AppParentServiceProvider extends ServiceProvider
{

	/**
	 * Register the package's component namespaces.
	 *
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
		$path = $path ?: $this->guessPackagePath($namespace);

		$config = $path.'/configs';

		if ($this->royalcms['files']->isDirectory($config))
		{
			$this->royalcms['config']->package($package, $config, $namespace);
		}

		// Next we will check for any "language" components. If language files exist
		// we will register them with this given package's namespace so that they
		// may be accessed using the translation facilities of the application.
		$lang = $path.'/languages';

		if ($this->royalcms['files']->isDirectory($lang))
		{
			$this->royalcms['translator']->addNamespace($namespace, $lang);
			if (strpos($namespace, 'app-', 0) !== false) {
                $this->royalcms['translator']->addNamespace(str_replace('app-', '', $namespace), $lang);
            }
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
		$view = $path.'/templates';

		if ($this->royalcms['files']->isDirectory($view))
		{
			$this->royalcms['view']->addNamespace($namespace, $view);
		}
	}

	/**
	 * Guess the package path for the provider.
	 *
	 * @return string
	 */
	public function guessPackagePath($namespace = null)
	{
        if (strpos($namespace, 'app-', 0) !== false) {
            $app = str_replace('app-', '', $namespace);
            return realpath($this->royalcms->appPath($app));
        }

		$path = with(new ReflectionClass($this))->getFileName();

		return realpath(dirname($path).'/../');
	}

	/**
	 * Determine the namespace for a package.
	 *
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
	 * Register the package's custom Artisan commands.
	 *
	 * @param  array  $commands
	 * @return void
	 */
	public function commands($commands)
	{
		$commands = is_array($commands) ? $commands : func_get_args();

		// To register the commands with Artisan, we will grab each of the arguments
		// passed into the method and listen for Artisan "start" event which will
		// give us the Artisan console instance which we will give commands to.
		$events = $this->royalcms['events'];

		$events->listen('royalcms.start', function($royalcms) use ($commands)
		{
			$royalcms->resolveCommands($commands);
		});
	}

	/**
	 * Get the application package view path.
	 *
	 * @param  string  $package
	 * @return string
	 */
	protected function getAppViewPath($package)
	{
		return $this->royalcms['path']."/views/packages/{$package}";
	}


}
