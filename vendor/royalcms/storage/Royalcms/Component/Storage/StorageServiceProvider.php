<?php

namespace Royalcms\Component\Storage;

use Illuminate\Contracts\Support\DeferrableProvider;
use Royalcms\Component\Support\ServiceProvider;

class StorageServiceProvider extends ServiceProvider implements DeferrableProvider
{

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->mergeConfigFrom($this->guessPackagePath('royalcms/storage') . '/config/storage.php', 'storage');

		$this->registerManager();

		$this->royalcms->singleton('storage.disk', function($royalcms)
		{
			return $royalcms['storage']->disk($this->getDefaultDriver());
		});

		$this->royalcms->singleton('storage.cloud', function($royalcms)
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
		$this->royalcms->singleton('storage', function($royalcms)
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
		return $this->royalcms['config']['storage.default'];
	}

	/**
	 * Get the default cloud based file driver.
	 *
	 * @return string
	 */
	protected function getCloudDriver()
	{
		return $this->royalcms['config']['storage.cloud'];
	}

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['storage'];
    }

    /**
     * Get a list of files that should be compiled for the package.
     *
     * @return array
     */
    public static function compiles()
    {
        $dir = static::guessPackageClassPath('royalcms/storage');

        return [
            $dir . "/Contracts/StorageInterface.php",
            $dir . "/Adapter/Direct.php",
            $dir . "/Adapter/Local.php",
            $dir . "/Filesystem.php",
            $dir . "/FilesystemAdapter.php",
            $dir . "/FilesystemBaseTrait.php",
            $dir . "/FilesystemManager.php",
            $dir . "/Facades/Storage.php",
            $dir . "/StorageServiceProvider.php",
        ];
    }

}
