<?php namespace Royalcms\Component\Filesystem;

use Royalcms\Component\Support\ServiceProvider;

class FilesystemServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerNativeFilesystem();

		$this->registerFlysystem();
	}

	/**
	 * Register the native filesystem implementation.
	 *
	 * @return void
	 */
	protected function registerNativeFilesystem()
	{
		$this->royalcms->bindShared('files', function() 
		{ 
		    return new Filesystem(); 
		});
	}

	/**
	 * Register the driver based filesystem.
	 *
	 * @return void
	 */
	protected function registerFlysystem()
	{
		$this->registerManager();

		$this->royalcms->bindShared('filesystem.disk', function($royalcms)
		{
			return $royalcms['filesystem']->disk($this->getDefaultDriver());
		});

		$this->royalcms->bindShared('filesystem.cloud', function($royalcms)
		{
			return $royalcms['filesystem']->disk($this->getCloudDriver());
		});
	}

	/**
	 * Register the filesystem manager.
	 *
	 * @return void
	 */
	protected function registerManager()
	{
		$this->royalcms->bindShared('filesystem', function($royalcms)
		{
			return new FilesystemManager($royalcms);
		});
	}

	/**
	 * Get the default file driver.
	 *
	 * @return string
	 */
	protected function getDefaultDriver()
	{
		return $this->royalcms['config']['filesystems.default'];
	}

	/**
	 * Get the default cloud based file driver.
	 *
	 * @return string
	 */
	protected function getCloudDriver()
	{
		return $this->royalcms['config']['filesystems.cloud'];
	}

}
