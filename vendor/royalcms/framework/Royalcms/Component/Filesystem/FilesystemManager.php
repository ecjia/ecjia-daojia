<?php namespace Royalcms\Component\Filesystem;

use Closure;
use Aws\S3\S3Client;
use OpenCloud\Rackspace;
use Royalcms\Component\Flysystem\FilesystemInterface;
use Royalcms\Component\Flysystem\Filesystem as Flysystem;
use Royalcms\Component\Flysystem\Rackspace\RackspaceAdapter;
use Royalcms\Component\Flysystem\Adapter\Local as LocalAdapter;
use Royalcms\Component\Flysystem\AwsS3v2\AwsS3Adapter as S3Adapter;
use Royalcms\Component\Support\Contracts\Filesystem\Factory as FactoryContract;

class FilesystemManager implements FactoryContract {

	/**
	 * The application instance.
	 *
	 * @var \Royalcms\Component\Support\Contracts\Foundation\Royalcms
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
	 * @param  \Royalcms\Component\Support\Contracts\Foundation\Royalcms  $royalcms
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
	 * @return \Royalcms\Component\Support\Contracts\Filesystem\Filesystem
	 */
	public function drive($name = null)
	{
		return $this->disk($name);
	}

	/**
	 * Get a filesystem instance.
	 *
	 * @param  string  $name
	 * @return \Royalcms\Component\Support\Contracts\Filesystem\Filesystem
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
	 * @return \Royalcms\Component\Support\Contracts\Filesystem\Filesystem
	 */
	protected function get($name)
	{
		return isset($this->disks[$name]) ? $this->disks[$name] : $this->resolve($name);
	}

	/**
	 * Resolve the given disk.
	 *
	 * @param  string  $name
	 * @return \Royalcms\Component\Support\Contracts\Filesystem\Filesystem
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
	 * @return \Royalcms\Component\Support\Contracts\Filesystem\Filesystem
	 */
	protected function callCustomCreator(array $config)
	{
		$driver = $this->customCreators[$config['driver']]($this->royalcms, $config);

		if ($driver instanceof FilesystemInterface)
		{
			return $this->adapt($driver);
		}

		return $driver;
	}

	/**
	 * Create an instance of the local driver.
	 *
	 * @param  array  $config
	 * @return \Royalcms\Component\Support\Contracts\Filesystem\Filesystem
	 */
	public function createLocalDriver(array $config)
	{
		return $this->adapt(new Flysystem(new LocalAdapter($config['root'])));
	}

	/**
	 * Create an instance of the Amazon S3 driver.
	 *
	 * @param  array  $config
	 * @return \Royalcms\Component\Support\Contracts\Filesystem\Cloud
	 */
	public function createS3Driver(array $config)
	{
		$s3Config = array_only($config, array('key', 'region', 'secret', 'signature', 'base_url'));

		return $this->adapt(
			new Flysystem(new S3Adapter(S3Client::factory($s3Config), $config['bucket']))
		);
	}

	/**
	 * Create an instance of the Rackspace driver.
	 *
	 * @param  array  $config
	 * @return \Royalcms\Component\Support\Contracts\Filesystem\Cloud
	 */
	public function createRackspaceDriver(array $config)
	{
		$client = new Rackspace($config['endpoint'], array(
			'username' => $config['username'], 'apiKey' => $config['key'],
		));

		return $this->adapt(new Flysystem(
			new RackspaceAdapter($this->getRackspaceContainer($client, $config))
		));
	}

	/**
	 * Get the Rackspace Cloud Files container.
	 *
	 * @param  Rackspace  $client
	 * @param  array  $config
	 * @return \OpenCloud\ObjectStore\Resource\Container
	 */
	protected function getRackspaceContainer(Rackspace $client, array $config)
	{
		$urlType = array_get($config, 'url_type');

		$store = $client->objectStoreService('cloudFiles', $config['region'], $urlType);

		return $store->getContainer($config['container']);
	}

	/**
	 * Adapt the filesystem implementation.
	 *
	 * @param  \Royalcms\Component\Flysystem\FilesystemInterface  $filesystem
	 * @return \Royalcms\Component\Support\Contracts\Filesystem\Filesystem
	 */
	protected function adapt(FilesystemInterface $filesystem)
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
