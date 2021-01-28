<?php

namespace Royalcms\Component\Package;

use Royalcms\Component\Package\Contracts\LoaderInterface;

class Package
{

    /**
     * The environment loader implementation.
     *
     * @var LoaderInterface $loader
     */
    protected $loader;

    protected $packageId;

    protected $packageName;

    protected $directory;

    protected $alias;

    /**
     * The server environment instance.
     *
     * @param LoaderInterface $loader
     * @return void
     */
    public function __construct(LoaderInterface $loader)
    {
        $this->loader = $loader;
    }


    public function getPackageId()
    {
        return $this->packageId;
    }

    public function getPackageName()
    {
        return $this->packageName;
    }

    public function getDirectory()
    {
        return $this->directory;
    }

    public function getAlias()
    {
        return $this->alias;
    }

}

// end