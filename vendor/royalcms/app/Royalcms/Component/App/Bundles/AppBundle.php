<?php

namespace Royalcms\Component\App\Bundles;

use Royalcms\Component\App\Contracts\BundlePackage;
use Royalcms\Component\App\BundleAbstract;

class AppBundle extends BundleAbstract implements BundlePackage
{
    
<<<<<<< HEAD
    public function __construct($app_floder, $app_alias = null)
    {
        $this->directory = $app_floder;
        
=======
    public function packageInit($app_floder, $app_alias = null)
    {
        $this->directory = $app_floder;

>>>>>>> v2-test
        if (is_null($app_alias)) {
            $this->alias = $app_floder;
        } else {
            $this->alias = $app_alias;
        }
<<<<<<< HEAD
        
        $this->package = $this->appPackage();

        if (! empty($this->package)) {
            $this->identifier = $this->package['identifier'];

            $this->namespace = $this->package['namespace'];
            $this->provider = $this->namespace . '\\' . $this->package['provider'];
        }

        $this->site = defined('RC_SITE') ? RC_SITE : 'default';

        $this->makeControllerPath();
    }
    
    
=======

        $this->makeControllerPath();

        $this->makeAppPackage();

        if (! empty($this->package)) {
            $this->identifier = $this->getPackage('identifier');

            $this->namespace = $this->getPackage('namespace');
            $this->provider = $this->namespace . '\\' . $this->getPackage('provider');
        }
    }

>>>>>>> v2-test
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
        if ($this->site == 'default') {
            $path = RC_APP_PATH . $this->directory . DIRECTORY_SEPARATOR;
        }
        else {
            $path = SITE_APP_PATH . $this->directory . DIRECTORY_SEPARATOR;
            if (! file_exists($path)) {
                $path = RC_APP_PATH . $this->directory . DIRECTORY_SEPARATOR;
            }
        }
        
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
        return 'app-'.$this->directory;
    }

<<<<<<< HEAD
//    /**
//     * 获取应用安装器对象
//     */
//    public function getInstaller()
//    {
//        $className = $this->getNamespaceClassName('Installer');
//
//        if (class_exists($className)) {
//            return new $className;
//        } else {
//            return null;
//        }
//    }


=======
    /**
     * @param array $properties
     * @return BundleAbstract
     */
    public static function __set_state(array $properties)
    {
        $bundle = new static($properties['directory'], $properties['alias']);

        foreach ($properties as $key => $value) {
            if ($key == 'identifier') {
                $bundle->setIdentifier($value);
            }
            elseif ($key == 'directory') {
                $bundle->setDirectory($value);
            }
            elseif ($key == 'alias') {
                $bundle->setAlias($value);
            }
            elseif ($key == 'site') {
                $bundle->setSite($value);
            }
            elseif ($key == 'package') {
                $bundle->setPackage($value);
            }
            elseif ($key == 'namespace') {
                $bundle->setNamespace($value);
            }
            elseif ($key == 'provider') {
                $bundle->setProvider($value);
            }
            elseif ($key == 'controllerPath') {
                $bundle->setControllerPath($value);
            }
        }

        return $bundle;
    }
>>>>>>> v2-test
    
}

// end