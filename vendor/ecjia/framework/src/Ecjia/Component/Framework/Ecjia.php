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

namespace Ecjia\Component\Framework;


use ArrayObject;
use Ecjia\Component\CharCode\CharCode;
use Ecjia\Component\Menu\AdminMenu;
use Ecjia\Component\Plugin\GlobalPluginStorage;
use Illuminate\Support\Traits\Macroable;
use RC_Hook;
use RC_Plugin;
use Royalcms\Component\Container\Container;

class Ecjia extends Container
{
    use Macroable;

    const VERSION = '2.17.0';

    const RELEASE = '20210122';
    
    /**
     * Config read or wirte
     * @var int
     */
    const CONFIG_READ   = 1;
    const CONFIG_CHECK  = 2;
    const CONFIG_EXISTS = 3;


    /**
     * MSG types
     */
    const MSGTYPE_HTML  = 0x00;
    const MSGTYPE_ALERT = 0x10;
    const MSGTYPE_JSON  = 0x20;
    const MSGTYPE_XML   = 0x30;

    /**
     * DATA types
     */
    const DATATYPE_HTML = 1;
    const DATATYPE_TEXT = 2;
    const DATATYPE_JSON = 3;
    const DATATYPE_XML  = 4;


    /**
     * MSG stats
     */
    const MSGSTAT_ERROR   = 0x00;
    const MSGSTAT_SUCCESS = 0x01;
    const MSGSTAT_INFO    = 0x02;
    const MSGSTAT_CONFIRM = 0x03;


    /**
     * Addon types
     */
    const TYPE_APP    = 'app';
    const TYPE_PLUGIN = 'plugin';
    const TYPE_WIDGET = 'widget';
    const TYPE_THEME  = 'theme';


    /**
     * Platform types
     */
    const PLATFORM_WEB    = 'web';
    const PLATFORM_MOBILE = 'mobile';
    const PLATFORM_WAP    = 'wap';
    const PLATFORM_WEIXIN = 'weixin';
    const PLATFORM_WEIBO  = 'weibo';

    /**
     * Debug modes
     * @var int
     */
    const DM_DISABLED       = 0x0;
    const DM_OUTPUT_ERROR   = 0x1;
    const DM_DISABLED_CACHE = 0x10;
    const DM_SHOW_DEBUG     = 0x100;
    const DM_LOGGING_SQL    = 0x1000;
    const DM_DISPLAY_SQL    = 0x10000;


    public static function current_platform()
    {
        if (defined('USE_PLATFORM_MOBILE') && USE_PLATFORM_MOBILE === true) {
            $platform = self::PLATFORM_MOBILE;
        } elseif (defined('USE_PLATFORM_WAP') && USE_PLATFORM_WAP === true) {
            $platform = self::PLATFORM_WAP;
        } elseif (defined('USE_PLATFORM_WEB') && USE_PLATFORM_WEB === true) {
            $platform = self::PLATFORM_WEB;
        } elseif (defined('USE_PLATFORM_WEIXIN') && USE_PLATFORM_WEIXIN === true) {
            $platform = self::PLATFORM_WEIXIN;
        } elseif (defined('USE_PLATFORM_WEIBO') && USE_PLATFORM_WEIBO === true) {
            $platform = self::PLATFORM_WEIBO;
        } else {
            $platform = self::PLATFORM_WEB;
        }
        return $platform;
    }

    /**
     * 生成admin_menu对象
     */
    public static function make_admin_menu($action, $name, $link, $sort = 99, $target = '_self')
    {
        return new AdminMenu($action, $name, $link, $sort, $target);
    }

    /**
     * 获取ECJia版本号
     */
    public static function version()
    {
        return RC_Hook::apply_filters('ecjia_build_version', VERSION);
    }

    /**
     * 获取ECJia发布日期
     */
    public static function release()
    {
        return RC_Hook::apply_filters('ecjia_build_release', RELEASE);
    }

    /**
     * Powered By
     */
    public static function powerByLink()
    {
        return (new CharCode)->byLink();
    }

    public static function powerByText()
    {
        return (new CharCode())->byText();
    }

    public static function loadGlobalPlugins()
    {
        $global_plugins = (new GlobalPluginStorage())->getPlugins();
        if (is_array($global_plugins)) {
            foreach ($global_plugins as $plugin_file) {
                RC_Plugin::load_files($plugin_file);
            }
        }
    }

    /**
     * @return bool
     */
    public static function is_debug_display()
    {
        return (config('system.debug') === true && config('system.debug_display') === true);
    }

}