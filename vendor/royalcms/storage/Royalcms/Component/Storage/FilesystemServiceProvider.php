<?php namespace Royalcms\Component\Storage;

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

		$this->royalcms->bindShared('storage.disk', function($royalcms)
		{
			return $royalcms['storage']->disk($this->getDefaultDriver());
		});

		$this->royalcms->bindShared('storage.cloud', function($royalcms)
		{
			return $royalcms['storage']->disk($this->getCloudDriver());
		});
	}

	/**
	 * Register the filesystem manager.
	 *
	 * @return void
	 */
	protected function registerManager()
	{
		$this->royalcms->bindShared('storage', function($royalcms)
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
