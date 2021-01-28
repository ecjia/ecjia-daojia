<?php

namespace Royalcms\Component\App;

use Royalcms\Component\Support\Manager;
use RC_Hook;
use Royalcms\Component\Support\Facades\File as RC_File;
use Royalcms\Component\App\Bundles\AppBundle;

class AppManager extends Manager
{

    /**
     * @var ApplicationLoader
     */
    protected $loader;
    
    /**
     * Create a new manager instance.
     *
     * @param  \Royalcms\Component\Foundation\Royalcms  $royalcms
     * @return void
     */
    public function __construct($royalcms)
    {
        parent::__construct($royalcms);


        $app_roots = array(
            RC_APP_PATH,
            SITE_APP_PATH
        );
        $app_roots = array_unique($app_roots);

        $this->loader = new ApplicationLoader($app_roots);
        
        $this->loadDrivers();
    }
    
    /**
     * Get a filesystem instance.
     *
     * @param  string  $name
     * @return \Royalcms\Component\App\BundleAbstract
     */
    public function driver($name = null)
    {
        $bundle = parent::driver($name);
        
        /**
         * load the Route app to the applications bundle info.
         *
         * @since 3.1.0
         *
         * @param \Royalcms\Component\App\Bundles\AppBundle $bundle
         */
        $bundle = RC_Hook::apply_filters('app_load_bundle', $bundle);
        
        return $bundle;
    }

    public function hasAlias($alias)
    {
        if (isset($this->drivers[$alias])) {
            return true;
        }
        return false;
    }

    public function getAlias()
    {
        $creators = [];

        foreach ($this->customCreators as $key => $creator) {
            $creators[$key] = $creator();
        }

        return array_merge($this->drivers, $creators);
    }
    
    /**
     * 通过别名返回App的具体文件夹名称
     * 
     * @param string $name
     * @return string | NULL
     */
    public function getDirectory($name)
    {
        return array_get($this->alias, $name);
    }
    
    /**
     * 获取目录的绝对路径
     * 
     * @param string $name
     */
    public function getAbsolutePath($name)
    {
        return $this->driver($name)->getAbsolutePath();
    }
    
    /**
     * Get the default cache driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return config('route.default.'.config('route.module'));
    }

    /**
     * 扫描应用目录的可用应用模块
     *
     * @return \Illuminate\Support\Collection|\Royalcms\Component\Support\Collection
     */
    protected function scanAppbundles()
    {
        $apps = $this->loader->loadApps();

        return $apps;
    }

    /**
     * 装载应用驱动
     */
    protected function loadDrivers()
    {
        $apps = $this->loader->loadAppsWithAlias();

        $bundles = config('bundles');

        collect($bundles)->each(function ($app, $alias) use ($apps) {
            $bundle = $apps->get($app);
            if ($alias == $app) {
                $this->registerApplicationWithBundle($bundle);
            }
            else {
                $this->registerApplicationWithBundle($bundle, $alias);
            }
        });
    }

    /**
     * @param $app
     */
    public function registerApplication($app)
    {
        $apps = $this->loader->loadAppsWithAlias();

        $bundle = $apps->get($app);

        (new ApplicationRegister($this, $bundle))->register();
    }

    /**
     * @param $bundle
     */
    private function registerApplicationWithBundle($bundle, $alias = null)
    {
        if (!empty($bundle)) {
            if (!empty($alias)) {
                $this->drivers[$alias] = $bundle;
            }
            else {
                $this->drivers[$bundle->getAlias()] = $bundle;
            }

            if ($bundle->getAlias() != $bundle->getDirectory()) {
                $this->drivers[$bundle->getDirectory()] = $bundle;
            }
        }
    }

    /**
     * 生成应用包自动发现缓存
     */
    public function makeAppPackages()
    {
        royalcms(AppPackageManifest::class)->build();
    }

    public function getBundles()
    {
        $bundles = config('bundles');

        $bundles = RC_Hook::apply_filters('app_activation_bundles', $bundles);

        return $bundles;
    }

    /**
     * @return ApplicationLoader
     */
    public function getApplicationLoader()
    {
        return $this->loader;
    }

}
