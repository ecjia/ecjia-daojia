<?php

namespace Royalcms\Component\App;

use Royalcms\Component\Support\Manager;
use RC_Hook;
use Royalcms\Component\Support\Facades\File as RC_File;
use Royalcms\Component\App\Bundles\AppBundle;

class AppManager extends Manager
{
<<<<<<< HEAD
    
    /**
     * 别名映射
     * key(别名) => value(应用目录)
     * @var array
     */
    protected $alias = array();
=======

    /**
     * @var ApplicationLoader
     */
    protected $loader;
>>>>>>> v2-test
    
    /**
     * Create a new manager instance.
     *
     * @param  \Royalcms\Component\Foundation\Royalcms  $royalcms
     * @return void
     */
    public function __construct($royalcms)
    {
        parent::__construct($royalcms);
<<<<<<< HEAD
        
        $this->loadSiteApps();
=======


        $app_roots = array(
            RC_APP_PATH,
            SITE_APP_PATH
        );
        $app_roots = array_unique($app_roots);

        $this->loader = new ApplicationLoader($app_roots);
        
        $this->loadDrivers();
>>>>>>> v2-test
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
<<<<<<< HEAD

        if (empty($this->alias)) {
            $this->loadAppBundles();
        }
=======
>>>>>>> v2-test
        
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
<<<<<<< HEAD
        if (isset($this->alias[$alias])) {
=======
        if (isset($this->drivers[$alias])) {
>>>>>>> v2-test
            return true;
        }
        return false;
    }
<<<<<<< HEAD
=======

    public function getAlias()
    {
        $creators = [];

        foreach ($this->customCreators as $key => $creator) {
            $creators[$key] = $creator();
        }

        return array_merge($this->drivers, $creators);
    }
>>>>>>> v2-test
    
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

<<<<<<< HEAD
    protected function loadAppBundles()
    {
        $bundles = array();
        $alias = array();

        if (RC_Hook::has_filter('app_scan_bundles')) {
            /**
             * load the Route app to the applications bundle info.
             *
             * @since 3.1.0
             *
             * @param array $bundles
             *                  多维数组，示例如下：
             *                  array(
             *                      array('alias' => '', 'identifier' => '', 'directory' => ''),
             *                      array('alias' => '', 'identifier' => '', 'directory' => ''),
             *                  )
             */
            $bundles = RC_Hook::apply_filters('app_scan_bundles', $bundles);
            if ( !empty($bundles) ) {
                foreach ($bundles as $bundle) {
                    $alias[$bundle['alias']] = $bundle['directory'];
                    if ($bundle['alias'] != $bundle['directory']) {
                        $alias[$bundle['directory']] = $bundle['directory'];
                    }
                }
            }

        }
        else {
            $alias = config('app');
        }

        $this->alias = RC_Hook::apply_filters('app_alias_directory_handle', $alias);
    }

    protected function loadSiteApps()
    {

//        $bundles = (new SiteApplications(royalcms()))->load();
//
//        dd($bundles);


        $app_roots = array(
            RC_APP_PATH,
            SITE_APP_PATH
        );
        $app_roots = array_unique($app_roots);
        
        foreach ($app_roots as $app_root) {
            if (file_exists($app_root)) {
                $apps_dir = RC_File::directories($app_root);
                foreach ($apps_dir as $path) {
                    $dir = basename($path);
                    $bundle = new AppBundle($dir);
                    if (!$bundle->getIdentifier()) continue;
                    
                    $this->drivers[$bundle->getAlias()] = $bundle;
                    if ($bundle->getAlias() != $bundle->getDirectory()) {
                        $this->drivers[$bundle->getDirectory()] = $bundle;
                    }
                }
            }
        }
        
        //ksort($this->drivers);
        //uasort( $this->drivers, array('\Royalcms\Component\App\Helper', 'sort_uname_callback') );
    }
    
=======
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

>>>>>>> v2-test
}
