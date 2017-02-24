<?php namespace Royalcms\Component\FilesystemKernel;

use Royalcms\Component\Support\ServiceProvider;

class FilesystemServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerManager();

		$this->royalcms->bindShared('filesystemkernel.disk', function($royalcms)
		{
			return $royalcms['filesystemkernel']->disk($this->getDefaultDriver());
		});

		$this->royalcms->bindShared('filesystemkernel.cloud', function($royalcms)
		{
			return $royalcms['filesystemkernel']->disk($this->getCloudDriver());
		});
	}

	/**
	 * Register the filesystem manager.
	 *
	 * @return void
	 */
	protected function registerManager()
	{
		$this->royalcms->bindShared('filesystemkernel', function($royalcms)
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
