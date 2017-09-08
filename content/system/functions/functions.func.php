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
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 加载ECJia项目主文件
 */
RC_Package::package('system')->loadClass('ecjia', false);
if ($_GET['m'] != 'installer') {
    RC_Hook::add_action('init', 'load_theme_function');
    RC_Hook::add_filter('app_scan_bundles', 'app_scan_bundles');
    RC_Hook::add_action('init', 'check_installed', 2);
    
    RC_Hook::add_action('ecjia_controller', function ($arg) {
        new ecjia_controller();
    });
}

/**
 * 检测是否安装
 */
function check_installed() {
    $install_lock = storage_path() . '/data/install.lock';
    if (!file_exists($install_lock) && !defined('NO_CHECK_INSTALL'))
    {
        $url = RC_Uri::url('installer/index/init');
        
        $cookies = royalcms('response')->headers->getCookies();
        $response = RC_Redirect::away($url, 302);
        foreach ($cookies as $cookie)
        {
            $response->withCookie($cookie);
        }
        
        $response->send();
        exit();
    }
}

/**
 * 加载主题扩展文件
 */
function load_theme_function() {
    
    RC_Loader::load_app_func('functions', 'api');
    $app = RC_Config::load_config('site', 'MAIN_APP');
    if ($app) {
        RC_Loader::load_app_func('functions', $app);
    }
    
    RC_Hook::add_filter('template', function () {
        $template_code = RC_Hook::apply_filters('ecjia_theme_template_code', 'template');
    	return ecjia::config($template_code);
    });
    $dir = RC_Theme::get_template_directory();
    if (file_exists($dir . DS . 'functions.php')) {
        include_once $dir . DS . 'functions.php';
    }
}

function app_scan_bundles() {
    $builtin_bundles = ecjia_app::builtin_bundles();
    $extend_bundles = ecjia_app::extend_bundles();
    return array_merge($builtin_bundles, $extend_bundles);
}

function ecjia_front_access_session() {
    if (ecjia_utility::is_spider()) {
        /* 如果是蜘蛛的访问，那么默认为访客方式，并且不记录到日志中 */
        $_SESSION = array();
        $_SESSION['user_id']     = 0;
        $_SESSION['user_name']   = '';
        $_SESSION['email']       = '';
        $_SESSION['user_rank']   = 0;
        $_SESSION['discount']    = 1.00;
    }
    
    //游客状态也需要设置一下session值
    if (empty($_SESSION['user_id'])) {
        $_SESSION['user_id']     = 0;
        $_SESSION['user_name']   = '';
        $_SESSION['email']       = '';
        $_SESSION['user_rank']   = 0;
        $_SESSION['discount']    = 1.00;
        if (!isset($_SESSION['login_fail'])) {
            $_SESSION['login_fail'] = 0;
        }
    }
}
RC_Hook::add_action('ecjia_front_access_session', 'ecjia_front_access_session');

/**
 * 自定义后台管理访问URL
 * @param string $url
 * @param string $path
 * @return string
 */
function custom_admin_url($url, $path) {
    if (RC_Config::has('site.custom_admin_url')) {
        $home_url = RC_Config::get('site.custom_admin_url');
    } else {
        $home_url = rtrim(ROOT_URL, '/');
    }
    
    $admin_url = $home_url . '/content/system';
    if ($path) {
        $admin_url .= '/' . $path;
    }
    return  $admin_url;
}
RC_Hook::add_filter('admin_url', 'custom_admin_url', 10, 2);


/**
 * 自定义系统静态资源访问URL
 * @param string $url
 * @param string $path
 * @return string
 */
function custom_system_static_url($url, $path) {
    if (RC_Config::has('site.custom_static_url')) {
        $static_url = RC_Config::get('site.custom_static_url');
    } else {
        $static_url = RC_Uri::admin_url('statics');
    }
    $url = $static_url . '/' . $path;
    return rtrim($url, '/');
}
RC_Hook::add_filter('system_static_url', 'custom_system_static_url', 10, 2);


/**
 * 自定义项目访问URL
 * @param string $url
 * @param string $path
 * @return string
 */
function custom_home_url($url, $path, $scheme) {
    if (RC_Config::has('site.custom_home_url')) {
        $home_url = RC_Config::get('site.custom_home_url');
        $url = $home_url . '/' . $path;
    }
    return rtrim($url, '/');
}
RC_Hook::add_filter('home_url', 'custom_home_url', 10, 3);

/**
 * 自定义项目访问URL
 * @param string $url
 * @param string $path
 * @return string
 */
function custom_site_url($url, $path, $scheme) {
    if (RC_Config::has('site.custom_site_url')) {
        $home_url = RC_Config::get('site.custom_site_url');
        $url = $home_url . '/' . $path;
    }
    return rtrim($url, '/');
}
RC_Hook::add_filter('site_url', 'custom_site_url', 10, 3);


/**
 * 自定义上传目录访问URL
 * @param string $url
 * @param string $path
 * @return string
 */
function custom_upload_url($url, $path) {
    if (RC_Config::has('site.custom_upload_url')) {
        $home_url = RC_Config::get('site.custom_upload_url');
        $url = $home_url . '/' . $path;
    }
    return rtrim($url, '/');
}
RC_Hook::add_filter('upload_url', 'custom_upload_url', 10, 2);


/**
 * 自定义上传目录路径
 * @param string $url
 * @param string $path
 * @return string
 */
function custom_upload_path($url, $path) {
    if (RC_Config::has('site.custom_upload_path')) {
        $upload_path = RC_Config::get('site.custom_upload_path');
    } else {
        $upload_path = SITE_UPLOAD_PATH;
    }
    $upload_path = $upload_path . ltrim($path, '/');
    return $upload_path;
}
RC_Hook::add_filter('upload_path', 'custom_upload_path', 10, 2);


/**
 * 自定义商店关闭后输出
 */
function custom_shop_closed() {
    header('Content-type: text/html; charset='.RC_CHARSET);
    die('<div style="margin: 150px; text-align: center; font-size: 14px"><p>' . __('本店盘点中，请您稍后再来...') . '</p><p>' . ecjia::config('close_comment') . '</p></div>');
}
RC_Hook::add_action('ecjia_shop_closed', 'custom_shop_closed');


function compatible_process_handle() {
    ecjia_front::$view_object->assign('ecs_charset', RC_CHARSET);
    
    if (ecjia::config(RC_Hook::apply_filters('ecjia_theme_stylename_code', 'stylename'), ecjia::CONFIG_EXISTS))
    {
        ecjia_front::$view_object->assign('ecs_css_path', RC_Theme::get_template_directory_uri() . '/style_' . ecjia::config(RC_Hook::apply_filters('ecjia_theme_stylename_code', 'stylename')) . '.css');
    }
    else
    {
        ecjia_front::$view_object->assign('ecs_css_path', RC_Theme::get_template_directory_uri() . '/style.css');
    }
}
RC_Hook::add_action('ecjia_compatible_process', 'compatible_process_handle');


function ecjia_set_header() {
    header('content-type: text/html; charset=' . RC_CHARSET);
    header('Expires: Fri, 14 Mar 1980 20:53:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: no-cache');
}
RC_Hook::add_action('ecjia_admin_finish_launching', 'ecjia_set_header');
RC_Hook::add_action('ecjia_front_finish_launching', 'ecjia_set_header');

function ecjia_mail_config($config) {    
    royalcms('config')->set('mail.host',        ecjia::config('smtp_host'));
    royalcms('config')->set('mail.port',        ecjia::config('smtp_port'));
    royalcms('config')->set('mail.from.address', ecjia::config('smtp_mail'));
    royalcms('config')->set('mail.from.name',   ecjia::config('shop_name'));
    royalcms('config')->set('mail.username',    ecjia::config('smtp_user'));
    royalcms('config')->set('mail.password',    ecjia::config('smtp_pass'));
    royalcms('config')->set('mail.charset',     ecjia::config('mail_charset'));

    if (intval(ecjia::config('smtp_ssl')) === 1) {
        royalcms('config')->set('mail.encryption', 'ssl');
    } else {
        royalcms('config')->set('mail.encryption', 'tcp');
    }
 
    if (intval(ecjia::config('mail_service')) === 1) {
        royalcms('config')->set('mail.driver', 'smtp');
    } else {
        royalcms('config')->set('mail.driver', 'mail');
    }
}
RC_Hook::add_action('reset_mail_config', 'ecjia_mail_config');

function set_ecjia_config_filter($arr) {
    /* 对数值型设置处理 */
    $arr['watermark_alpha']      = isset($arr['watermark_alpha']) ? intval($arr['watermark_alpha']) : 0;
    $arr['market_price_rate']    = isset($arr['market_price_rate']) ? floatval($arr['market_price_rate']) : 0;
    $arr['integral_scale']       = isset($arr['integral_scale']) ? floatval($arr['integral_scale']) : 0;
    $arr['integral_percent']     = isset($arr['integral_percent']) ? floatval($arr['integral_percent']) : 0;
    $arr['cache_time']           = isset($arr['cache_time']) ? intval($arr['cache_time']) : 0;
    $arr['thumb_width']          = isset($arr['thumb_width']) ? intval($arr['thumb_width']) : 0;
    $arr['thumb_height']         = isset($arr['thumb_height']) ? intval($arr['thumb_height']) : 0;
    $arr['image_width']          = isset($arr['image_width']) ? intval($arr['image_width']) : 0;
    $arr['image_height']         = isset($arr['image_height']) ? intval($arr['image_height']) : 0;
    $arr['best_number']          = !empty($arr['best_number']) && intval($arr['best_number']) > 0 ? intval($arr['best_number'])     : 3;
    $arr['new_number']           = !empty($arr['new_number']) && intval($arr['new_number']) > 0 ? intval($arr['new_number'])      : 3;
    $arr['hot_number']           = !empty($arr['hot_number']) && intval($arr['hot_number']) > 0 ? intval($arr['hot_number'])      : 3;
    $arr['promote_number']       = !empty($arr['promote_number']) && intval($arr['promote_number']) > 0 ? intval($arr['promote_number'])  : 3;
    $arr['top_number']           = (isset($arr['top_number']) && intval($arr['top_number']) > 0) ? intval($arr['top_number'])      : 10;
    $arr['history_number']       = (isset($arr['history_number']) && intval($arr['history_number']) > 0) ? intval($arr['history_number'])  : 5;
    $arr['comments_number']      = (isset($arr['comments_number']) && intval($arr['comments_number']) > 0) ? intval($arr['comments_number']) : 5;
    $arr['article_number']       = (isset($arr['article_number']) && intval($arr['article_number']) > 0) ? intval($arr['article_number'])  : 5;
    $arr['page_size']            = (isset($arr['page_size']) && intval($arr['page_size']) > 0) ? intval($arr['page_size'])       : 10;
    $arr['bought_goods']         = isset($arr['bought_goods']) ? intval($arr['bought_goods']) : 0;
    $arr['goods_name_length']    = isset($arr['goods_name_length']) ? intval($arr['goods_name_length']) : 0;
    $arr['top10_time']           = isset($arr['top10_time']) ? intval($arr['top10_time']) : 0;
    $arr['goods_gallery_number'] = (isset($arr['goods_gallery_number']) && intval($arr['goods_gallery_number'])) ? intval($arr['goods_gallery_number']) : 5;
    $arr['no_picture']           = !empty($arr['no_picture']) ? str_replace('../', './', $arr['no_picture']) : 'images/no_picture.gif'; // 修改默认商品图片的路径
    $arr['qq']                   = !empty($arr['qq']) ? $arr['qq'] : '';
    $arr['ww']                   = !empty($arr['ww']) ? $arr['ww'] : '';
    $arr['default_storage']      = isset($arr['default_storage']) ? intval($arr['default_storage']) : 1;
    $arr['min_goods_amount']     = isset($arr['min_goods_amount']) ? floatval($arr['min_goods_amount']) : 0;
    $arr['one_step_buy']         = empty($arr['one_step_buy']) ? 0 : 1;
    $arr['invoice_type']         = empty($arr['invoice_type']) ? array('type' => array(), 'rate' => array()) : unserialize($arr['invoice_type']);
    $arr['show_order_type']      = isset($arr['show_order_type']) ? $arr['show_order_type'] : 0;    // 显示方式默认为列表方式
    $arr['help_open']            = isset($arr['help_open']) ? $arr['help_open'] : 1;    // 显示方式默认为列表方式
    
    
    //限定语言项
    $lang_array = array('zh_cn', 'zh_tw', 'en_us');
    if (empty($arr['lang']) || !in_array($arr['lang'], $lang_array)) {
        $arr['lang'] = 'zh_cn'; // 默认语言为简体中文
    }
    
    if (empty($arr['integrate_code'])) {
        $arr['integrate_code'] = 'ecjia'; // 默认的会员整合插件为 ecjia
    }
    
    return $arr;
}
RC_Hook::add_filter('set_ecjia_config_filter', 'set_ecjia_config_filter');    

//移除$_ENV中的敏感信息
function remove_env_pretty_page_table_data($tables) {
    $env = collect($tables['Environment Variables']);
    $server = collect($tables['Server/Request Data']);
    
    $col = collect([
        'AUTH_KEY',
        'DB_HOST', 
        'DB_PORT', 
        'DB_DATABASE', 
        'DB_USERNAME', 
        'DB_PASSWORD', 
        'DB_PREFIX'
    ]);
    $col->map(function ($item) use ($env, $server) {
        $env->pull($item);
        $server->pull($item);
    });
    
    $tables['Environment Variables'] = $env->all();
    $tables['Server/Request Data'] = $server->all();
    return $tables;
}
RC_Hook::add_filter('pretty_page_table_data', 'remove_env_pretty_page_table_data');



// end