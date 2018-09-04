<?php

namespace Royalcms\Component\Storage;

use Closure;

class FilesystemManager {

	/**
	 * The application instance.
	 *
	 * @var \Royalcms\Component\Foundation\Royalcms
	 */
	protected $royalcms;

	/**
	 * The array of resolved filesystem drivers.
	 *
	 * @var array
	 */
	protected $disks = array();

	/**
	 * The registered custom driver creators.
	 *
	 * @var array
	 */
	protected $customCreators = array();

	/**
	 * Create a new filesystem manager instance.
	 *
	 * @param  \Royalcms\Component\Foundation\Royalcms  $royalcms
	 * @return void
	 */
	public function __construct($royalcms)
	{
		$this->royalcms = $royalcms;
	}

	/**
	 * Get a filesystem instance.
	 *
	 * @param  string  $name
	 * @return \Royalcms\Component\Storage\FilesystemBase
	 */
	public function drive($name = null)
	{
		return $this->disk($name);
	}

	/**
	 * Get a filesystem instance.
	 *
	 * @param  string  $name
	 * @return \Royalcms\Component\Storage\FilesystemBase
	 */
	public function disk($name = null)
	{
		$name = $name ?: $this->getDefaultDriver();

		return $this->disks[$name] = $this->get($name);
	}

	/**
	 * Attempt to get the disk from the local cache.
	 *
	 * @param  string  $name
	 * @return \Royalcms\Component\Storage\FilesystemBase
	 */
	protected function get($name)
	{
		return isset($this->disks[$name]) ? $this->disks[$name] : $this->resolve($name);
	}

	/**
	 * Resolve the given disk.
	 *
	 * @param  string  $name
	 * @return \Royalcms\Component\Storage\FilesystemBase
	 */
	protected function resolve($name)
	{
		$config = $this->getConfig($name);

		if (isset($this->customCreators[$config['driver']]))
		{
			return $this->callCustomCreator($config);
		}

		return $this->{"create".ucfirst($config['driver'])."Driver"}($config);
	}

	/**
	 * Call a custom driver creator.
	 *
	 * @param  array  $config
	 * @return \Royalcms\Component\Storage\FilesystemBase
	 */
	protected function callCustomCreator(array $config)
	{
		$driver = $this->customCreators[$config['driver']]($this->royalcms, $config);

		if ($driver instanceof FilesystemBase)
		{
			return $this->adapt($driver);
		}

		return $driver;
	}

	/**
	 * Create an instance of the local driver.
	 *
	 * @param  array  $config
	 * @return \Royalcms\Component\Storage\Direct
	 */
	public function createDirectDriver(array $config)
	{
		return $this->adapt(new Direct($config['root']));
	}

	/**
	 * Create an instance of the Aliyun oss driver.
	 *
	 * @param  array  $config
	 * @return \Royalcms\Component\Storage\Aliyunoss
	 */
	public function createAliyunossDriver(array $config)
	{
		$ossConfig = array_only($config, array('key', 'secret', 'bucket', 'server', 'server_internal', 'is_internal'));

		return $this->adapt(
			new Aliyunoss($ossConfig)
		);
	}

	/**
	 * Adapt the filesystem implementation.
	 *
	 * @param  \Royalcms\Component\Storage\FilesystemBase  $filesystem
	 * @return \Royalcms\Component\Storage\FilesystemAdapter
	 */
	protected function adapt(FilesystemBase $filesystem)
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
		return $this->royalcms['config']["filesystems.disks.{$name}"];
	}

	/**
	 * Get the default driver name.
	 *
	 * @return string
	 */
	public function getDefaultDriver()
	{
		return $this->royalcms['config']['filesystems.default'];
	}

	/**
	 * Register a custom driver creator Closure.
	 *
	 * @param  string    $driver
	 * @param  \Closure  $callback
	 * @return $this
	 */
	public function extend($driver, Closure $callback)
	{
		$this->customCreators[$driver] = $callback;

		return $this;
	}

	/**
	 * Dynamically call the default driver instance.
	 *
	 * @param  string  $method
	 * @param  array   $parameters
	 * @return mixed
	 */
	public function __call($method, $parameters)
	{
		return call_user_func_array(array($this->disk(), $method), $parameters);
	}

}
