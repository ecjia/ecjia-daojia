<<<<<<< HEAD
<?php namespace Royalcms\Component\Package;

class Package {
    
    /**
     * The environment loader implementation.
     *
     * @var \Royalcms\Component\Package\LoaderInterface  $loader
     */
    protected $loader;
    
    protected $packageId;
    
    protected $packageName;
    
    protected $directory;
    
    protected $alias;
    
    /**
     * The server environment instance.
     *
     * @param  \Royalcms\Component\Package\LoaderInterface  $loader
=======
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
>>>>>>> v2-test
     * @return void
     */
    public function __construct(LoaderInterface $loader)
    {
        $this->loader = $loader;
    }
<<<<<<< HEAD
    
    
    
    public function getPackageId() {
        return $this->packageId;
    }
    
    public function getPackageName() {
        return $this->packageName;
    }

    public function getDirectory() {
        return $this->directory;
    }
    
    public function getAlias() {
        return $this->alias;
    }
    
=======


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

>>>>>>> v2-test
}

// end