<?php


namespace Ecjia\System\BaseController;

use ecjia;
use Ecjia\System\Frameworks\Contracts\EcjiaTemplateFileLoader;
use ecjia_app;
use Ecjia_ThemeManager;
use ecjia_view;
use InvalidArgumentException;
use RC_File;
use RC_Hook;
use RC_Session;
use RC_Theme;
use RC_Uri;
use Smarty;

abstract class SmartyController extends EcjiaController implements EcjiaTemplateFileLoader
{

    /**
     * 模板视图对象静态属性
     *
     * @var \ecjia_view
     */
    public static $view_object;

    /**
     * 控制器对象静态属性
     * @var \ecjia_front
     */
    public static $controller;


    public function __construct()
    {
        parent::__construct();

        self::$controller = static::$controller;
        self::$view_object = static::$view_object;


        if (config('system.debug')) {
            error_reporting(E_ALL);
        } else {
            error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        }


        RC_Hook::do_action('ecjia_smarty_finish_launching');
    }

    protected function session_start()
    {
        RC_Hook::add_filter('royalcms_session_name', function ($sessin_name) {
            return config('session.session_name');
        });

        RC_Hook::add_filter('royalcms_session_id', function ($sessin_id) {
            return RC_Hook::apply_filters('ecjia_front_session_id', $sessin_id);
        });

        RC_Session::start();
    }

    public function create_view()
    {
        $view = new ecjia_view($this);

        // 模板目录
        $view->setTemplateDir(SITE_THEME_PATH . RC_Theme::get_template() . DIRECTORY_SEPARATOR);
        // 添加主题插件目录
        $view->addPluginsDir(SITE_THEME_PATH . RC_Theme::get_template() . DIRECTORY_SEPARATOR . 'smarty' . DIRECTORY_SEPARATOR);
        // 编译目录
        $view->setCompileDir(TEMPLATE_COMPILE_PATH . 'front' . DIRECTORY_SEPARATOR);

        if (config('system.debug')) {
            $view->caching = Smarty::CACHING_OFF;
            $view->cache_lifetime = 0;
            $view->debugging = true;
            $view->force_compile = true;
        } else {
            $view->caching = Smarty::CACHING_LIFETIME_CURRENT;
            $view->cache_lifetime = ecjia::config('cache_time');
            $view->debugging = false;
            $view->force_compile = false;
        }

        $view->assign('ecjia_charset', RC_CHARSET);
        $view->assign('theme_url', RC_Theme::get_template_directory_uri() . '/');
        $view->assign('system_static_url', RC_Uri::system_static_url() . '/');

        try
        {
            $css_path = Ecjia_ThemeManager::driver(Ecjia_ThemeManager::getTemplateName())->loadSpecifyStyle(Ecjia_ThemeManager::getStyleName())->getStyle();
            $view->assign('theme_css_path', $css_path);
        }
        catch (InvalidArgumentException $e)
        {
            //
        }

        return $view;
    }

    /**
     * 获得前台模板目录
     * @return string
     */
    public function get_template_dir()
    {
        $style = RC_Theme::get_template();

        $dir = SITE_THEME_PATH . $style . DIRECTORY_SEPARATOR;

        return $dir;
    }

    /**
     * 获得前台模版文件
     */
    public function get_template_file($file)
    {
        $style = RC_Theme::get_template();

        if (is_null($file)) {
            $file = SITE_THEME_PATH . $style . DIRECTORY_SEPARATOR . ROUTE_M . DIRECTORY_SEPARATOR . ROUTE_C . '_' . ROUTE_A;
        } elseif (! RC_File::is_absolute_path($file)) {
            $file = SITE_THEME_PATH . $style . DIRECTORY_SEPARATOR . $file;
        }

        // 添加模板后缀
        if (! preg_match('@\.[a-z]+$@', $file)) {
            $file .= config('system.tpl_fix');
        }

        // 将目录全部转为小写
        if (is_file($file)) {
            return $file;
        }

        // 模版文件不存在
        if (config('system.debug')) {
            // TODO:
            rc_die("Template does not exist.:$file");
        }

        return str_replace($this->get_template_dir(), '', $file);
    }

    public function display($tpl_file = null, $cache_id = null, $show = true, $options = array())
    {
        if (strpos($tpl_file, 'string:') !== 0) {
            if (RC_File::file_suffix($tpl_file) !== 'php') {
                $tpl_file = $tpl_file . '.php';
            }
            if (config('system.tpl_usedfront') && ! RC_File::is_absolute_path($tpl_file)) {
                $tpl_file = ecjia_app::get_app_template($tpl_file, ROUTE_M, false);
            }
        }
        return parent::display($tpl_file, $cache_id, $show, $options);
    }


    public function fetch($tpl_file = null, $cache_id = null, $options = array())
    {
        if (strpos($tpl_file, 'string:') !== 0) {
            if (RC_File::file_suffix($tpl_file) !== 'php') {
                $tpl_file = $tpl_file . '.php';
            }
            if (config('system.tpl_usedfront') && ! RC_File::is_absolute_path($tpl_file)) {
                $tpl_file = ecjia_app::get_app_template($tpl_file, ROUTE_M, false);
            }
        }
        return parent::fetch($tpl_file, $cache_id, $options);
    }

    /**
     * 判断是否缓存
     *
     * @param   string     $tpl_file
     * @param   string      $cache_id
     *
     * @return  bool
     */
    public final function is_cached($tpl_file, $cache_id = null, $options = array())
    {
        if (strpos($tpl_file, 'string:') !== 0) {
            if (RC_File::file_suffix($tpl_file) !== 'php') {
                $tpl_file = $tpl_file . '.php';
            }
            if (config('system.tpl_usedfront') && ! RC_File::is_absolute_path($tpl_file)) {
                $tpl_file = ecjia_app::get_app_template($tpl_file, ROUTE_M, false);
            }
        }

        $is_cached = parent::is_cached($tpl_file, $cache_id, $options);

        $purge = royalcms('request')->query('purge', 0);
        $purge = intval($purge);
        if ($is_cached && $purge === 1) {
            $this->clear_cache($tpl_file, $cache_id, $options);
            return false;
        }
        return $is_cached;
    }


    /**
     * 清除单个模板缓存
     *
     * @param   string     $tpl_file
     * @param   string     $cache_id
     *
     * @return  bool
     */
    public function clear_cache($tpl_file, $cache_id = null, $options = array())
    {
        if (strpos($tpl_file, 'string:') !== 0) {
            if (RC_File::file_suffix($tpl_file) !== 'php') {
                $tpl_file = $tpl_file . '.php';
            }
            if (config('system.tpl_usedfront')) {
                $tpl_file = ecjia_app::get_app_template($tpl_file, ROUTE_M, false);
            }
        }

        return parent::clear_cache($tpl_file, $cache_id, $options);
    }

}