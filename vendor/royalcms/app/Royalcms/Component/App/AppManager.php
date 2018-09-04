<?php

namespace Royalcms\Component\App;

use Royalcms\Component\Support\Manager;
use RC_Hook;
use Royalcms\Component\Support\Facades\File as RC_File;
use Royalcms\Component\App\Bundles\AppBundle;

class AppManager extends Manager
{
    
    /**
     * 别名映射
     * key(别名) => value(应用目录)
     * @var array
     */
    protected $alias = array();
    
    /**
     * Create a new manager instance.
     *
     * @param  \Royalcms\Component\Foundation\Royalcms  $royalcms
     * @return void
     */
    public function __construct($royalcms)
    {
        parent::__construct($royalcms);
        
        $this->loadSiteApps();
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

        if (empty($this->alias)) {
            $this->loadAppBundles();
        }
        
        /**
         * load the Route app to the applications bundle info.
         *
         * @since 3.1.0
         *
         * @param \Royalcms\Component\App\AppBundle $bundle
         */
        $bundle = RC_Hook::apply_filters('app_load_bundle', $bundle);
        
        return $bundle;
    }

    public function hasAlias($alias)
    {
        if (isset($this->alias[$alias])) {
            return true;
        }
        return false;
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
    
}
