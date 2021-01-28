<?php

namespace Royalcms\Component\Storage;

use Royalcms\Component\Storage\Adapter\Local;
use Royalcms\Component\Storage\Adapter\Direct;
use Royalcms\Component\Storage\Adapter\Aliyunoss;
use League\Flysystem\FilesystemInterface;
use League\Flysystem\Adapter\AbstractAdapter;
use Royalcms\Component\Support\Arr;
use Royalcms\Component\Filesystem\FilesystemManager as BaseFilesystemManager;

class FilesystemManager extends BaseFilesystemManager
{

	/**
	 * Create an instance of the local driver.
	 *
	 * @param  array  $config
	 * @return \Royalcms\Component\Contracts\Filesystem\Filesystem
	 */
	public function createDirectDriver(array $config)
	{
        $links = Arr::get($config, 'links') === 'skip'
            ? Direct::SKIP_LINKS
            : Direct::DISALLOW_LINKS;

        $permissions = isset($config['permissions']) ? $config['permissions'] : [];

		return $this->adapt($this->createFilesystem(new Direct($config['root'], LOCK_EX, $links, $permissions
        ), $config));
	}

    /**
     * Create an instance of the local driver.
     *
     * @param  array  $config
     * @return \Royalcms\Component\Contracts\Filesystem\Filesystem
     */
    public function createLocalDriver(array $config)
    {
        $links = Arr::get($config, 'links') === 'skip'
            ? Local::SKIP_LINKS
            : Local::DISALLOW_LINKS;

        $permissions = isset($config['permissions']) ? $config['permissions'] : [];

        return $this->adapt($this->createFilesystem(new Local($config['root'], LOCK_EX, $links, $permissions
        ), $config));
    }

    /**
     * Create a Storage instance with the given adapter.
     *
     * @param  \League\Flysystem\Adapter\AbstractAdapter  $adapter
     * @param  array  $config
     * @return \Royalcms\Component\Storage\Filesystem
     */
    public function createFilesystem(AbstractAdapter $adapter, array $config)
    {
        return new Filesystem($adapter, count($config) > 0 ? $config : null);
    }

	/**
	 * Adapt the filesystem implementation.
	 *
	 * @param  \League\Flysystem\FilesystemInterface  $filesystem
	 * @return \Royalcms\Component\Contracts\Filesystem\Filesystem
	 */
    public function adapt(FilesystemInterface $filesystem)
	{
		return new FilesystemAdapter($filesystem);
	}

    /**
     * Get the filesystem connection configuration.
     *
     * @param  string  $name
     * @return array
     */
    protected function getConfig($name)
    {
        return $this->app['config']["storage.disks.{$name}"];
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['storage.default'];
    }
}
