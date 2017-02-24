<?php namespace Royalcms\Component\Foundation\Bootstrap;

use Royalcms\Component\Config\Repository;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Royalcms\Component\Foundation\Contracts\Royalcms;
use Royalcms\Component\Config\Contracts\Repository as RepositoryContract;

class LoadConfiguration { 

	/**
	 * Bootstrap the given application.
	 *
	 * @param  \Royalcms\Component\Foundation\Contracts\Royalcms  $royalcms
	 * @return void
	 */
	public function bootstrap(Royalcms $royalcms)
	{
		$items = [];

		// First we will see if we have a cache configuration file. If we do, we'll load
		// the configuration items from that file so that it is very quick. Otherwise
		// we will need to spin through every configuration file and load them all.
		if (file_exists($cached = $royalcms->getCachedConfigPath()))
		{
			$items = require $cached;

			$loadedFromCache = true;
		}

		$royalcms->instance('config', $config = new Repository($items));

		// Next we will spin through all of the configuration files in the configuration
		// directory and load each one into the repository. This will make all of the
		// options available to the developer for use in various parts of this app.
		if ( ! isset($loadedFromCache))
		{
			$this->loadConfigurationFiles($royalcms, $config);
		}

		date_default_timezone_set($config['app.timezone']);

		mb_internal_encoding('UTF-8');
	}

	/**
	 * Load the configuration items from all of the files.
	 *
	 * @param  \Royalcms\Component\Foundation\Contracts\Royalcms  $royalcms
	 * @param  \Royalcms\Component\Contracts\Config\Repository  $config 
	 * @return void
	 */
	protected function loadConfigurationFiles(Royalcms $royalcms, RepositoryContract $config)
	{
		foreach ($this->getConfigurationFiles($royalcms) as $key => $path)
		{
			$config->set($key, require $path);
		}
	}

	/**
	 * Get all of the configuration files for the application.
	 *
	 * @param  \Royalcms\Component\Foundation\Contracts\Royalcms  $royalcms
	 * @return array
	 */
	protected function getConfigurationFiles(Royalcms $royalcms)
	{
		$files = [];

		foreach (Finder::create()->files()->name('*.php')->in($royalcms->configPath()) as $file)
		{
			$nesting = $this->getConfigurationNesting($file);

			$files[$nesting.basename($file->getRealPath(), '.php')] = $file->getRealPath();
		}

		return $files;
	}

	/**
	 * Get the configuration file nesting path.
	 *
	 * @param  \Symfony\Component\Finder\SplFileInfo  $file
	 * @return string
	 */
	private function getConfigurationNesting(SplFileInfo $file)
	{
		$directory = dirname($file->getRealPath());

		$tree = trim(str_replace(config_path(), '', $directory), DIRECTORY_SEPARATOR);
		if ($tree)
		{
			$tree = str_replace(DIRECTORY_SEPARATOR, '.', $tree).'.';
		}

		return $tree;
	}

}
