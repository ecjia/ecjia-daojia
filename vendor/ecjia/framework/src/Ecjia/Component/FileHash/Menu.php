<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/29
 * Time: 15:18
 */

namespace Ecjia\Component\FileHash;


class Menu
{

    protected $menus = [

        [
            'name' => 'ecjia.system',
            'type' => 'system',
            'title' => '系统',
            'dir' => '/content/system',
            'sort' => 1,
        ],

        [
            'name' => 'vendor',
            'type' => 'vendor',
            'title' => 'VENDOR',
            'dir' => '/vendor',
            'sort' => 2,
        ],

        [
            'name' => 'bootstrap',
            'type' => 'system',
            'title' => 'BOOTSTRAP',
            'dir' => '/content/bootstrap',
            'sort' => 3,
        ],

        [
            'name' => 'database',
            'type' => 'system',
            'title' => 'DATABASE',
            'dir' => '/content/database',
            'sort' => 4,
        ],

    ];

    public function __construct()
    {

    }

    /**
     * 获取后台模块菜单
     */
    public function getMenus()
    {
        $app_menus = $this->getAppsMenus();

        $plugin_menus = $this->getPluginsMenus();

        $theme_menus = $this->getRootThemesMenus();

        $site_menus = $this->getSitesMenus();

        return collect($this->menus)->merge($app_menus)
            ->merge($plugin_menus)
            ->merge($theme_menus)
            ->merge($site_menus)->sortBy('sort');

    }

    /**
     * 获取所有应用的菜单
     */
    protected function getAppsMenus()
    {
        $apps = royalcms('app')->getDrivers();

        $menus = [];
        $sort = 100;
        foreach($apps as $app) {
            $package = $app->getPackage();
            if ($package['identifier'] == 'ecjia.system') {
                continue;
            }

            $sort++;

            $menus[] = [
                'name' => $package['identifier'],
                'type' => 'app',
                'title' => $package['format_name'],
                'dir' => str_replace(base_path(), '', $app->getControllerPath()),
                'sort' => $sort,
            ];
        }

        $menus[] = [
            'name' => 'ecjia.apps',
            'type' => 'nav-header',
            'title' => __('应用', 'ecjia'),
            'dir' => '',
            'sort' => 100,
        ];

        return $menus;
    }

    /**
     * 获取所有插件的菜单
     */
    protected function getPluginsMenus()
    {
        $all_plugins = \RC_Plugin::get_plugins();

        $menus = [];
        $sort = 200;
        foreach($all_plugins as $key => $plugin) {

            $sort++;

            $menus[] = [
                'name' => dirname($key),
                'type' => 'app',
                'title' => $plugin['Name'],
                'dir' => 'content/plugins/'.dirname($key),
                'sort' => $sort,
            ];
        }

        $menus[] = [
            'name' => 'ecjia.plugins',
            'type' => 'nav-header',
            'title' => __('插件', 'ecjia'),
            'dir' => '',
            'sort' => 200,
        ];

        return $menus;
    }

    /**
     * 获取所有根站点的主题的菜单
     */
    protected function getRootThemesMenus()
    {

        $themes = \Ecjia_ThemeManager::getAvailableThemes();

        $menus = [];
        $sort = 300;
        foreach($themes as $key => $theme) {

            $sort++;

            $styles = $theme->getThemeStyles();
            $menus[] = [
                'name' => $theme->getThemeCode(),
                'type' => 'app',
                'title' => $styles[0]['name'],
                'dir' => str_replace(base_path(), '', $theme->getThemeDir()),
                'sort' => $sort,
            ];
        }

        $menus[] = [
            'name' => 'ecjia.themes',
            'type' => 'nav-header',
            'title' => __('主题', 'ecjia'),
            'dir' => '',
            'sort' => 300,
        ];

        return $menus;
    }

    /**
     * 获取所有站点的菜单
     */
    protected function getSitesMenus()
    {
        $sites = \RC_File::directories(base_path('sites'));

        $menus = [];
        $sort = 400;
        foreach($sites as $key => $site) {

            $sort++;

            $dir = str_replace(base_path(), '', $site);
            $name = str_replace(['/', '\\'], '_', trim($dir, '/\\'));

            $menus[] = [
                'name' => $name,
                'type' => 'site',
                'title' => basename($dir),
                'dir' => $dir,
                'sort' => $sort,
            ];
        }

        $menus[] = [
            'name' => 'ecjia.sites',
            'type' => 'nav-header',
            'title' => __('站点', 'ecjia'),
            'dir' => '',
            'sort' => 400,
        ];

        return $menus;
    }

    /**
     * 获取某个菜单的数组
     *
     * @param $name
     * @return mixed
     */
    public function getMenu($name)
    {
        return collect($this->menus)->where('name', $name)->first();
    }


}