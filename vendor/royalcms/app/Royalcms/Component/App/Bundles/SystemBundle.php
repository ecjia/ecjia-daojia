<?php

namespace Royalcms\Component\App\Bundles;

use Royalcms\Component\App\Contracts\BundlePackage;
use Royalcms\Component\App\BundleAbstract;

class SystemBundle extends BundleAbstract implements BundlePackage
{
    
    public function __construct()
    {
        $this->directory = 'system';
        
        $this->alias = config('system.admin_entrance');
        
        $this->package = $this->appPackage();
        
        $this->identifier = array_get($this->package, 'identifier');
        
        $this->namespace = array_get($this->package, 'namespace');
        $this->provider = $this->namespace . '\\' . array_get($this->package, 'provider');

        $this->site = defined('RC_SITE') ? RC_SITE : 'default';
        
        $this->makeControllerPath();
    }
    
    protected function makeControllerPath()
    {
        $this->controllerPath = $this->getAbsolutePath();
    }
    
    /**
     * 获取目录的绝对路径
     *
     * @param string $name
     */
    public function getAbsolutePath()
    {
        $path = RC_SYSTEM_PATH;
        
        return $path;
    }
    
    
    public function getNamespace()
    {
        return 'system';
    }
    
}