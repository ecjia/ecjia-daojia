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
     * @return void
     */
    public function __construct(LoaderInterface $loader)
    {
        $this->loader = $loader;
    }
    
    
    
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
    
}

// end