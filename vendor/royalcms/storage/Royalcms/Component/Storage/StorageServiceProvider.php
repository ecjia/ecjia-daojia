<?php

namespace Royalcms\Component\Storage;

<<<<<<< HEAD
use Royalcms\Component\Support\ServiceProvider;

class StorageServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

=======
use Illuminate\Contracts\Support\DeferrableProvider;
use Royalcms\Component\Support\ServiceProvider;

class StorageServiceProvider extends ServiceProvider implements DeferrableProvider
{

>>>>>>> v2-test
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->mergeConfigFrom($this->guessPackagePath('royalcms/storage') . '/config/storage.php', 'storage');

		$this->registerManager();

<<<<<<< HEAD
		$this->royalcms->bindShared('storage.disk', function($royalcms)
=======
		$this->royalcms->singleton('storage.disk', function($royalcms)
>>>>>>> v2-test
		{
			return $royalcms['storage']->disk($this->getDefaultDriver());
		});

<<<<<<< HEAD
		$this->royalcms->bindShared('storage.cloud', function($royalcms)
=======
		$this->royalcms->singleton('storage.cloud', function($royalcms)
>>>>>>> v2-test
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
<<<<<<< HEAD
		$this->royalcms->bindShared('storage', function($royalcms)
=======
		$this->royalcms->singleton('storage', function($royalcms)
>>>>>>> v2-test
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
<<<<<<< HEAD
		return $this->royalcms['config']['filesystems.default'];
=======
		return $this->royalcms['config']['storage.default'];
>>>>>>> v2-test
	}

	/**
	 * Get the default cloud based file driver.
	 *
	 * @return string
	 */
	protected function getCloudDriver()
	{
<<<<<<< HEAD
		return $this->royalcms['config']['filesystems.cloud'];
=======
		return $this->royalcms['config']['storage.cloud'];
>>>>>>> v2-test
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
<<<<<<< HEAD
            $dir . "/Adapter/Aliyunoss.php",
=======
>>>>>>> v2-test
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
