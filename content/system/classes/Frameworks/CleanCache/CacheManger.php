<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-22
 * Time: 13:47
 */

namespace Ecjia\System\Frameworks\CleanCache;

use ecjia_app;
use RC_Api;
use RC_App;

class CacheManger
{

    protected $factory;

    public function __construct()
    {
        $this->factory = new CacheFactory();
    }

    /**
     * Return instance
     *
     * @return  $this
     */
    public function make()
    {
        return $this;
    }

    public function clean($handle)
    {
        return $this->factory->clean($handle);
    }

    /**
     * 加载各应用缓存
     * @return array
     */
    public function loadGroupCache()
    {
        $apps = ecjia_app::installed_app_floders();
        $caches = array();
        foreach ($apps as $app) {
            $res = $this->loadAppCache($app);
            if ($res) {
                $caches[] = $res;
            }
        }
        return $caches;
    }

    /**
     * 加载应用缓存
     * @param string $app_dir
     */
    protected function loadAppCache($app_dir)
    {
        $res = RC_Api::api($app_dir, 'update_cache');
        if ($res) {
            $appinfo = RC_App::driver($app_dir);
            $app_name = $appinfo->getPackage('format_name') ?: $appinfo->getPackage('name');
            return $this->buildGroupData($app_dir, $app_name, $res);
        }
        return false;
    }

    protected function buildGroupData($code, $name, $resources)
    {
        $group_data = array(
            'group_name'        => $name,
            'group_code'        => $code,
            'group_resources'   => $resources,
        );

        return $group_data;
    }

}