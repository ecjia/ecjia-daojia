<?php


namespace Royalcms\Component\App;


class AppPackage
{
    protected $package = [];

    protected $bundle;

    /**
     * AppPackage constructor.
     * @param BundleAbstract $bundle
     */
    public function __construct(BundleAbstract $bundle)
    {
        $this->bundle = $bundle;
    }

    /**
     * 获取app/configs/package.php配置信息
     * @return NULL | array
     */
    public function loadPackageData()
    {
        $this->package = $this->bundle->getPackageConfig();

        if (empty($this->package)) {
            $this->package = [];
        }

        return $this;
    }

    /**
     * @param $package
     * @return $this
     */
    public function setPackage($package)
    {
        $this->package = $package;

        return $this;
    }

    /**
     * @return array
     */
    public function getPackage()
    {
        if (empty($this->package)) {
            return [];
        }

        $package = $this->package;

        $package['format_name'] = $package['name'];
        $package['format_description'] = $package['description'];

        return $package;
    }

    /**
     * @return array
     */
    public function getFormatPackage()
    {
        if (empty($this->package)) {
            return [];
        }

        $package = $this->package;

        $package['format_name']        = __($package['name'], $this->bundle->getContainerName());
        $package['format_description'] = __($package['description'], $this->bundle->getContainerName());

        return $package;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->getFormatPackage();
    }

    /**
     * @param BundleAbstract $bundle
     * @param $package
     * @return static
     */
    public static function make(BundleAbstract $bundle, $package)
    {
        $instance = new static($bundle);
        $instance->setPackage($package);
        return $instance;
    }
}