<?php

namespace Royalcms\Component\Image;

use Closure;

class ImageManager
{
    /**
     * Config
     *
     * @var array
     */
    public $config = array(
        'driver' => 'gd'
    );

    /**
     * Creates new instance of Image Manager
     *
     * @param array $config
     */
    public function __construct(array $config = array())
    {
        $this->checkRequirements();
        $this->configure($config);
    }

    /**
     * Overrides configuration settings
     *
     * @param array $config
     */
    public function configure(array $config = array())
    {
        $this->config = array_replace($this->config, $config);

        return $this;
    }

    /**
     * Initiates an Image instance from different input types
     *
     * @param  mixed $data
     *
     * @return \Royalcms\Component\Image\Image
     */
    public function make($data)
    {
        return $this->createDriver()->init($data);
    }

    /**
     * Creates an empty image canvas
     *
     * @param  integer $width
     * @param  integer $height
     * @param  mixed $background
     *
     * @return \Royalcms\Component\Image\Image
     */
    public function canvas($width, $height, $background = null)
    {
        return $this->createDriver()->newImage($width, $height, $background);
    }

    /**
     * Create new cached image and run callback
     * (requires additional package intervention/imagecache)
     *
     * @param Closure $callback
     * @param integer $lifetime
     * @param boolean $returnObj
     *
     * @return Image
     */
    public function cache(Closure $callback, $lifetime = null, $returnObj = false)
    {
        if (class_exists('Royalcms\Component\\Image\\ImageCache')) {
            // create imagecache
            $imagecache = new ImageCache($this);

            // run callback
            if (is_callable($callback)) {
                $callback($imagecache);
            }

            return $imagecache->get($lifetime, $returnObj);
        }

        throw new \Royalcms\Component\Image\Exception\MissingDependencyException(
            "Please install package intervention/imagecache before running this function."
        );
    }

    /**
     * Creates a driver instance according to config settings
     *
     * @return \Royalcms\Component\Image\AbstractDriver
     */
    private function createDriver()
    {
        if (is_string($this->config['driver'])) {
            $drivername = ucfirst($this->config['driver']);
            $driverclass = sprintf('Royalcms\Component\\Image\\%s\\Driver', $drivername);

            if (class_exists($driverclass)) {
                return new $driverclass;
            }

            throw new \Royalcms\Component\Image\Exception\NotSupportedException(
                "Driver ({$drivername}) could not be instantiated."
            );
        }

        if ($this->config['driver'] instanceof AbstractDriver) {
            return $this->config['driver'];
        }

        throw new \Royalcms\Component\Image\Exception\NotSupportedException(
            "Unknown driver type."
        );
    }

    /**
     * Check if all requirements are available
     *
     * @return void
     */
    private function checkRequirements()
    {
        if ( ! function_exists('finfo_buffer')) {
            throw new \Royalcms\Component\Image\Exception\MissingDependencyException(
                "PHP Fileinfo extension must be installed/enabled to use Royalcms Image."
            );
        }
    }
}
