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

<<<<<<< HEAD
	/**
	 * Create an instance of the Aliyun oss driver.
	 *
	 * @param  array  $config
	 * @return \Royalcms\Component\Contracts\Filesystem\Filesystem
	 */
	public function createAliyunossDriver(array $config)
	{
		$ossConfig = array_only($config, array('key', 'secret', 'bucket', 'server', 'server_internal', 'is_internal', 'url'));

		return $this->adapt($this->createFilesystem(new Aliyunoss($ossConfig), $ossConfig));
	}

=======
>>>>>>> v2-test
    /**
     * Create a Storage instance with the given adapter.
     *
     * @param  \League\Flysystem\Adapter\AbstractAdapter  $adapter
     * @param  array  $config
     * @return \Royalcms\Component\Storage\Filesystem
     */
<<<<<<< HEAD
    protected function createFilesystem(AbstractAdapter $adapter, array $config)
=======
    public function createFilesystem(AbstractAdapter $adapter, array $config)
>>>>>>> v2-test
    {
        return new Filesystem($adapter, count($config) > 0 ? $config : null);
    }

	/**
	 * Adapt the filesystem implementation.
	 *
	 * @param  \League\Flysystem\FilesystemInterface  $filesystem
	 * @return \Royalcms\Component\Contracts\Filesystem\Filesystem
	 */
<<<<<<< HEAD
	protected function adapt(FilesystemInterface $filesystem)
=======
    public function adapt(FilesystemInterface $filesystem)
>>>>>>> v2-test
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
<<<<<<< HEAD
        return $this->royalcms['config']["storage.disks.{$name}"];
=======
        return $this->app['config']["storage.disks.{$name}"];
>>>>>>> v2-test
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
<<<<<<< HEAD
        return $this->royalcms['config']['storage.default'];
=======
        return $this->app['config']['storage.default'];
>>>>>>> v2-test
    }
}
