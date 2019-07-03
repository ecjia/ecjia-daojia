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
if (is_installed_ecjia()) {
    (new \Ecjia\System\Frameworks\Screens\NotInstallScreen())->loading();
} else {
    (new \Ecjia\System\Frameworks\Screens\InstallScreen())->loading();
}

/**
 * 检测是否安装ecjia
 */
function is_installed_ecjia()
{
    $install_lock = storage_path() . '/data/install.lock';

    if (!file_exists($install_lock) && !defined('NO_CHECK_INSTALL')) {

        if (royalcms('request')->query('m') != 'installer')
        {
            $url = RC_Uri::url('installer/index/init');
            rc_redirect($url);
            exit();
        }

        return false;
    }

    return true;
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


// end