<?php

namespace Royalcms\Component\App\Bundles;

use Royalcms\Component\App\Contracts\BundlePackage;
use Royalcms\Component\App\BundleAbstract;

class SystemBundle extends BundleAbstract implements BundlePackage
{
<<<<<<< HEAD
    
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
=======
    public function __construct()
    {
        parent::__construct();

        $this->packageInit('system', config('system.admin_entrance'));
    }

    public function packageInit($app_floder, $app_alias = null)
    {
        $this->directory = $app_floder;

        if (is_null($app_alias)) {
            $this->alias = $app_floder;
        } else {
            $this->alias = $app_alias;
        }
        
        $this->makeControllerPath();

        $this->makeAppPackage();

        if (! empty($this->package)) {
            $this->identifier = $this->getPackage('identifier');

            $this->namespace = $this->getPackage('namespace');
            $this->provider = $this->namespace . '\\' . $this->getPackage('provider');
        }
>>>>>>> v2-test
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

<<<<<<< HEAD
=======
    public function getPackageConfig()
    {
        $path = $this->getAbsolutePath() . 'configs/package.php';

        if (file_exists($path)) {
            return include $path;
        }

        return null;
    }

>>>>>>> v2-test
    /**
     * Get application provider container name
     * @return string
     */
    public function getContainerName()
    {
        return 'system';
    }
    
}