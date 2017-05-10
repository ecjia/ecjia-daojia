<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
namespace Ecjia\System\BaseController;

use \ecjia_view;
use \RC_File;
use \RC_Config;
use \RC_Loader;
use \Smarty;
use \RC_Uri;
use \RC_Response;
use \RC_Hook;
use \RC_Theme;
use \ecjia_app;
use \ecjia_template_fileloader;

class SimpleController extends EcjiaController implements ecjia_template_fileloader
{
    
    public function __construct() {
        parent::__construct();
    
        self::$controller = static::$controller;
        self::$view_object = static::$view_object;

    
        RC_Response::header('Cache-control', 'private');
    
        //title信息
        $this->assign_title();
        
        if (RC_Config::get('system.debug')) {
            error_reporting(E_ALL);
        } else {
            error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        }
    
        RC_Hook::do_action('ecjia_simple_finish_launching');
    }
    
    protected function session_start() {}
    
    public function create_view()
    {
        $view = new ecjia_view($this);
         
        // 模板目录
        $view->setTemplateDir($this->get_template_dir());
        // 编译目录
        $view->setCompileDir(TEMPLATE_COMPILE_PATH . 'front' . DIRECTORY_SEPARATOR);
        // 插件目录
//         $view->setPluginsDir(dirname(dirname($this->get_template_dir())) . '/smarty/');
         
        if (RC_Config::get('system.debug')) {
            $view->caching = Smarty::CACHING_OFF;
            $view->cache_lifetime = 0;
            $view->debugging = true;
            $view->force_compile = true;
        } else {
            $view->caching = Smarty::CACHING_LIFETIME_CURRENT;
            $view->cache_lifetime = 1800;
            $view->debugging = false;
            $view->force_compile = false;
        }
         
        $view->assign('ecjia_charset', RC_CHARSET);
        $view->assign('system_static_url', RC_Uri::system_static_url() . '/');
         
        return $view;
    }
    
        /**
        * 获得前台模板目录
        * @return string
        */
        public function get_template_dir()
        {
            if (RC_Loader::exists_site_app(ROUTE_M)) {
                $dir = SITE_APP_PATH . ROUTE_M . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'front' . DIRECTORY_SEPARATOR;
            } else {
                $dir = RC_APP_PATH . ROUTE_M . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'front' . DIRECTORY_SEPARATOR;
            }
    
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
            if (! preg_match('@\.[a-z]+$@', $file))
                $file .= RC_Config::get('system.tpl_fix');
    
            // 将目录全部转为小写
            if (is_file($file)) {
                return $file;
            } else {
                // 模版文件不存在
                if (RC_Config::get('system.debug'))
                    // TODO:
                    rc_die("Template does not exist.:$file");
                else
                    return null;
            }
        }
    
        public final function display($tpl_file = null, $cache_id = null, $show = true, $options = array()) {
            if (strpos($tpl_file, 'string:') !== 0) {
                if (RC_File::file_suffix($tpl_file) !== 'php') {
                    $tpl_file = $tpl_file . '.php';
                }
                if (RC_Config::get('system.tpl_usedfront') && ! RC_File::is_absolute_path($tpl_file)) {
                    $tpl_file = ecjia_app::get_app_template($tpl_file, ROUTE_M, false);
                }
            }
            return parent::display($tpl_file, $cache_id, $show, $options);
        }
    
        public final function fetch($tpl_file = null, $cache_id = null, $options = array()) {
            if (strpos($tpl_file, 'string:') !== 0) {
                if (RC_File::file_suffix($tpl_file) !== 'php') {
                    $tpl_file = $tpl_file . '.php';
                }
                if (RC_Config::get('system.tpl_usedfront') && ! RC_File::is_absolute_path($tpl_file)) {
                    $tpl_file = ecjia_app::get_app_template($tpl_file, ROUTE_M, false);
                }
            }
            return parent::fetch($tpl_file, $cache_id, $options);
        }
    
        /**
         * 判断是否缓存
         *
         * @access  public
         * @param   string     $tpl_file
         * @param   sting      $cache_id
         *
         * @return  bool
         */
        public final function is_cached($tpl_file, $cache_id = null, $options = array()) {
            if (strpos($tpl_file, 'string:') !== 0) {
                if (RC_File::file_suffix($tpl_file) !== 'php') {
                    $tpl_file = $tpl_file . '.php';
                }
                if (RC_Config::get('system.tpl_usedfront')) {
                    $tpl_file = ecjia_app::get_app_template($tpl_file, ROUTE_M, false);
                }
            }
             
            $is_cached = parent::is_cached($tpl_file, $cache_id, $options);
             
            $purge = royalcms('request')->query('purge', 0);
            $purge = intval($purge);
            if ($is_cached && $purge === 1) {
                parent::clear_cache($tpl_file, $cache_id, $options);
                return false;
            }
            return $is_cached;
        }
    
        /**
         * 直接跳转
         *
         * @param string $url
         * @param int $code
         */
        public function redirect($url, $code = 302) {
            return parent::redirect($url, $code);
        }
    
        /**
         * 信息提示
         *
         * @param string    $msg    提示内容
         * @param string    $url    跳转URL
         * @param int       $time   跳转时间
         * @param null      $tpl    模板文件
         */
        protected function message($msg = '操作成功', $url = null, $time = 2, $tpl = null)
        {
            $revise_url = $url ? "window.location.href='" . $url . "'" : "window.history.back(-1);";
            $front_tpl = SITE_THEME_PATH . RC_Config::get('system.tpl_style') . DIRECTORY_SEPARATOR . RC_Config::get('system.tpl_message');
    
            if ($tpl) {
                $this->assign(array(
                    'msg' => $msg,
                    'url' => $revise_url,
                    'time' => $time
                ));
                $tpl = SITE_THEME_PATH . RC_Config::get('system.tpl_style') . DIRECTORY_SEPARATOR . $tpl;
                $this->display($tpl);
            } elseif (file_exists($front_tpl)) {
                $this->assign(array(
                    'msg' => $msg,
                    'url' => $revise_url,
                    'time' => $time
                ));
                $this->display($front_tpl);
            } else {
                return parent::message($msg, $url, $time, $tpl);
            }
        }
    
    
        /**
         * 向模版注册title
         */
        public function assign_title($title = '') {
            $title_suffix = RC_Hook::apply_filters('page_title_suffix', ' - Powered by ECJia');
            $this->assign('page_title', $title . $title_suffix);
        }
    
    
        protected function load_hooks() {}
}