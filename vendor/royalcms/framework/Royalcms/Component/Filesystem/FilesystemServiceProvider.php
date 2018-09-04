<?php

namespace Royalcms\Component\Filesystem;

use Royalcms\Component\Support\ServiceProvider;

class FilesystemServiceProvider extends ServiceProvider
{
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
        $this->royalcms->singleton('files', function () {
            return new Filesystem;
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

        $this->royalcms->singleton('filesystem.disk', function () {
            return $this->royalcms['filesystem']->disk($this->getDefaultDriver());
        });

        $this->royalcms->singleton('filesystem.cloud', function () {
            return $this->royalcms['filesystem']->disk($this->getCloudDriver());
        });
    }

    /**
     * Register the filesystem manager.
     *
     * @return void
     */
    protected function registerManager()
    {
        $this->royalcms->singleton('filesystem', function () {
            return new FilesystemManager($this->royalcms);
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
