<?php
/**
 * royalcms.php ROYALCMS framework entry file
 *
 * Defines initial RoyalCMS constants
 * 
 * @package Royalcms
 *
 * @since 3.0.0
 */

if (! defined('IN_ROYALCMS')) {
    define('IN_ROYALCMS', true);
}

if (! defined('ROYALCMS_START')) {
    define('ROYALCMS_START', microtime(true));
}

if (! defined('ROYALCMS_PATH')) {
    // ROYALCMS框架路径
    define('ROYALCMS_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
}

if (! defined('VENDOR_PATH')) {
    // 第三方库路径
    define('VENDOR_PATH', VENDOR_DIR . DIRECTORY_SEPARATOR);
}

if (! defined('SITE_ROOT')) {
    // 站点根路径
    define('SITE_ROOT', VENDOR_PATH . '..' . DIRECTORY_SEPARATOR);
}

if (! defined('VENDOR_TINYMCE')) {
    define('VENDOR_TINYMCE', 'tinymce');
}

// Add define('RC_DEBUG', true); enable display of notices during development.
if (! defined('RC_DEBUG')) {
    define('RC_DEBUG', false);
}

if (! defined('MAGIC_QUOTES_GPC')) {
    define('MAGIC_QUOTES_GPC', false);
}

if (! defined('RC_CHARSET')) {
    /* 定义字符集常量 */
    define('RC_CHARSET', 'utf-8');
}

/* 路径定义废弃于3.6 Start */
if (! defined('SITE_PROTOCOL')) {
    /* 主机协议 */
    define('SITE_PROTOCOL', isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://');
}

if (! defined('SITE_HOST')) {
    /* 当前访问的主机名 */
    define('SITE_HOST', (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ''));
}

if (!defined('WEB_PATH')) {
    /* 定义网站根路径 */
    define('WEB_PATH', str_replace(SITE_PROTOCOL . SITE_HOST, '', dirname(SITE_PROTOCOL . SITE_HOST . $_SERVER['SCRIPT_NAME'])) . '/');
}

if (!defined('SITE_URL')) {
    /* 获取站点根URL */
    if (defined('RC_SITE')) {
        if (strpos(WEB_PATH, 'sites')) {
            /* 当前访问的网址根 */
            define('SITE_URL', SITE_PROTOCOL . SITE_HOST . rtrim(WEB_PATH, '/'));
        } else {
            /* 当前访问的网址根 */
            if (defined('USE_SUB_DOMAIN') && USE_SUB_DOMAIN == true) {
                define('SITE_URL', SITE_PROTOCOL . SITE_HOST . rtrim(WEB_PATH, '/'));
            } else {
                define('SITE_URL', SITE_PROTOCOL . SITE_HOST . rtrim(WEB_PATH, '/') . '/sites/' . RC_SITE);
            }
        }
    } else {
        /* 当前访问的网址根 */
        define('SITE_URL', SITE_PROTOCOL . SITE_HOST . rtrim(WEB_PATH, '/'));
    }
}

if (!defined('ROOT_URL')) {
    /* 获取站点根URL */
    if (defined('RC_SITE')) {
        define('ROOT_URL', str_replace('sites/' . RC_SITE, '', SITE_URL));
    } else {
        define('ROOT_URL', SITE_URL);
    }
}
/* 路径定义废弃于3.6 End */

if (! defined('SITE_PATH')) {

    if (defined('RC_SITE')) {
        define('SITE_PATH', SITE_ROOT . 'sites' . DIRECTORY_SEPARATOR . RC_SITE . DIRECTORY_SEPARATOR);
    } else {
        define('SITE_PATH', SITE_ROOT);
    }

}

if (! defined('VENDOR_URL')) {
    define('VENDOR_URL', ROOT_URL . 'vendor');
}

if (! defined('SYS_TIME')) {
    /* 定义系统时间常量 */
    define('SYS_TIME', time());
}

if (! defined('SYS_TIME')) {
    /* 来源 */
    define('HTTP_REFERER', isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');
}


if (! defined('RC_DEBUG_DISPLAY')) {
    // Add define('RC_DEBUG_DISPLAY', null); use the globally configured setting for
    // display_errors and not force errors to be displayed. Use false to force display_errors off.
    define('RC_DEBUG_DISPLAY', true);
}

if (! defined('RC_DEBUG_LOG')) {
    // Add define('RC_DEBUG_LOG', true); to enable error logging to content/debug.log.
    define('RC_DEBUG_LOG', false);
}


if (! defined('RC_CONTENT_PATH')) {
    /* no trailing slash, full paths only - RC_CONTENT_URL is defined further down*/
    define('RC_CONTENT_PATH', SITE_ROOT . 'content' . DIRECTORY_SEPARATOR);
}

if (! defined('RC_CONTENT_URL')) {
    define('RC_CONTENT_URL', rtrim(ROOT_URL, '/') . '/content');
}


if (! defined('SITE_CONTENT_PATH')) {
    /* no trailing slash, full paths only - SITE_CONTENT_URL is defined further down */
    define('SITE_CONTENT_PATH', SITE_PATH . 'content' . DIRECTORY_SEPARATOR);
}


if (! defined('SITE_CONTENT_URL')) {
    /* full url - SITE_CONTENT_PATH is defined further up */
    define('SITE_CONTENT_URL', rtrim(SITE_URL, '/') . '/content');
}


if (! defined('RC_CACHE_PATH')) {
    /* 缓存文件夹路径 */
    define('RC_CACHE_PATH', RC_CONTENT_PATH . 'caches' . DIRECTORY_SEPARATOR);
}

if (! defined('SITE_CACHE_PATH')) {
    if (defined('USE_SUB_CACHE') && USE_SUB_CACHE == true) {
        define('SITE_CACHE_PATH', SITE_CONTENT_PATH . 'storages' . DIRECTORY_SEPARATOR);
    } else {
        define('SITE_CACHE_PATH', RC_CONTENT_PATH . 'storages' . DIRECTORY_SEPARATOR);
    }
}

if (! defined('RC_SYSTEM_PATH')) {
    /* 系统System路径 */
    define('RC_SYSTEM_PATH', RC_CONTENT_PATH . 'system' . DIRECTORY_SEPARATOR);
}

if (! defined('SITE_SYSTEM_PATH')) {
    if (file_exists(SITE_CONTENT_PATH . 'system')) {
        define('SITE_SYSTEM_PATH', SITE_CONTENT_PATH . 'system' . DIRECTORY_SEPARATOR);
    } else {
        define('SITE_SYSTEM_PATH', RC_SYSTEM_PATH);
    }
}

if (! defined('SITE_API_PATH')) {
    /* API文件夹地址 */
    define('SITE_API_PATH', SITE_CONTENT_PATH . 'apis' . DIRECTORY_SEPARATOR);
}

if (! defined('SITE_LOG_PATH')) {
    /* 日志文件夹地址 */
    define('SITE_LOG_PATH', SITE_CACHE_PATH . 'logs' . DIRECTORY_SEPARATOR);
}

if (! defined('SITE_UPLOAD_PATH')) {
    /* 定义上传根路径 */
    if (defined('USE_SUB_UPLOAD') && USE_SUB_UPLOAD == true) {
        define('SITE_UPLOAD_PATH', SITE_CONTENT_PATH . 'uploads' . DIRECTORY_SEPARATOR);
    } else {
        define('SITE_UPLOAD_PATH', RC_CONTENT_PATH . 'uploads' . DIRECTORY_SEPARATOR);
    }
}

if (! defined('SITE_UPLOAD_URL')) {
    if (defined('USE_SUB_UPLOAD') && USE_SUB_UPLOAD == true) {
        define('SITE_UPLOAD_URL', SITE_CONTENT_URL . '/uploads');
    } else {
        define('SITE_UPLOAD_URL', RC_CONTENT_URL . '/uploads');
    }
}

if (! defined('TEMPLATE_COMPILE_PATH')) {
    /* 定义模板编译路径 */
    define('TEMPLATE_COMPILE_PATH', SITE_CACHE_PATH . 'template' . DIRECTORY_SEPARATOR . 'compiled' . DIRECTORY_SEPARATOR);
}


if (! defined('TEMPLATE_CACHE_PATH')) {
    /* 定义模板缓存路径 */
    define('TEMPLATE_CACHE_PATH', SITE_CACHE_PATH . 'template' . DIRECTORY_SEPARATOR . 'caches' . DIRECTORY_SEPARATOR);
}


if (! defined('RC_PLUGIN_PATH')) {
    /**
     * Defines plugin directory Royalcms constants
     *
     * Defines must-use plugin directory constants, which may be overridden
     *
     * @since 3.0.0
     */
    /**
     * Allows for the plugins directory to be moved from the default location.
     *
     * full path, has trailing slash
     *
     * @since 3.0.0
     */
    define('RC_PLUGIN_PATH', RC_CONTENT_PATH . 'plugins' . DIRECTORY_SEPARATOR);
}


if (! defined('RC_PLUGIN_URL')) {
    /**
     * Allows for the plugins directory to be moved from the default location.
     *
     * full url, no trailing slash
     *
     * @since 3.0.0
     */
    define('RC_PLUGIN_URL', RC_CONTENT_URL . '/plugins');
}


if (! defined('SITE_PLUGIN_PATH')) {
    /**
     * Allows for the mu-plugins directory to be moved from the default location.
     *
     * full path, has trailing slash
     *
     * @since 3.0.0
     */
    define('SITE_PLUGIN_PATH', SITE_CONTENT_PATH . 'plugins' . DIRECTORY_SEPARATOR);
}


if (! defined('SITE_PLUGIN_URL')) {
    /**
     * Allows for the mu-plugins directory to be moved from the default location.
     *
     * full url, no trailing slash
     *
     * @since 3.0.0
     */
    define('SITE_PLUGIN_URL', SITE_CONTENT_URL . '/plugins');
}


if (! defined('RC_APP_PATH')) {
    /**
     * Defines plugin directory Royalcms constants
     *
     * Defines must-use plugin directory constants, which may be overridden
     *
     * @since 3.0.0
     */
    /**
     * Allows for the plugins directory to be moved from the default location.
     *
     * full path, has trailing slash
     *
     * @since 3.0.0
     */
    define('RC_APP_PATH', RC_CONTENT_PATH . 'apps' . DIRECTORY_SEPARATOR);
}

if (! defined('RC_LANG_PATH')) {
    define('RC_LANG_PATH', RC_CONTENT_PATH . 'languages' . DIRECTORY_SEPARATOR);
}


if (! defined('RC_APP_URL')) {
    /**
     * Allows for the plugins directory to be moved from the default location.
     *
     * full url, no trailing slash
     *
     * @since 3.0.0
     */
    define('RC_APP_URL', RC_CONTENT_URL . '/apps');
}


if (! defined('SITE_APP_PATH')) {
    /**
     * Allows for the mu-plugins directory to be moved from the default location.
     *
     * full path, has trailing slash
     *
     * @since 3.0.0
     */
    define('SITE_APP_PATH', SITE_CONTENT_PATH . 'apps' . DIRECTORY_SEPARATOR);
}

if (! defined('SITE_LANG_PATH')) {
    define('SITE_LANG_PATH', SITE_CONTENT_PATH . 'languages' . DIRECTORY_SEPARATOR);
}


if (! defined('SITE_APP_URL')) {
    /**
     * Allows for the mu-plugins directory to be moved from the default location.
     *
     * full url, no trailing slash
     *
     * @since 3.0.0
     */
    define('SITE_APP_URL', SITE_CONTENT_URL . '/apps');
}


if (! defined('RC_THEME_PATH')) {
    /**
     * Defines plugin directory Royalcms constants
     *
     * Defines must-use plugin directory constants, which may be overridden
     *
     * @since 3.0.0
     */
    /**
     * Allows for the themes directory to be moved from the default location.
     *
     * full path, has trailing slash
     *
     * @since 3.0.0
     */
    define('RC_THEME_PATH', RC_CONTENT_PATH . 'themes' . DIRECTORY_SEPARATOR);
}


if (! defined('RC_THEME_URL')) {
    /**
     * Allows for the themes directory to be moved from the default location.
     *
     * full url, no trailing slash
     *
     * @since 3.0.0
     */
    define('RC_THEME_URL', RC_CONTENT_URL . '/themes');
}


if (! defined('SITE_THEME_PATH')) {
    /**
     * Allows for the site themes directory to be moved from the default location.
     *
     * full path, has trailing slash
     *
     * @since 3.0.0
     */
    define('SITE_THEME_PATH', SITE_CONTENT_PATH . 'themes' . DIRECTORY_SEPARATOR);
}


if (! defined('SITE_THEME_URL')) {
    /**
     * Allows for the site themes directory to be moved from the default location.
     *
     * full url, no trailing slash
     *
     * @since 3.0.0
     */
    define('SITE_THEME_URL', SITE_CONTENT_URL . '/themes');
}


/**
 * 常用常量定义
 */

if (! defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR); // 目录分隔符
}

if (! defined('IS_CGI')) {
    define('IS_CGI', substr(PHP_SAPI, 0, 3) == 'cgi' ? true : false);
}

if (! defined('IS_WIN')) {
    define('IS_WIN', strstr(PHP_OS, 'WIN') ? true : false);
}

if (! defined('IS_CLI')) {
    define('IS_CLI', PHP_SAPI == 'cli' ? true : false);
}

if (! defined('REQUEST_METHOD')) {
    define('REQUEST_METHOD', isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : false);
}

if (! defined('IS_GET')) {
    define('IS_GET', REQUEST_METHOD == 'GET' ? true : false);
}

if (! defined('IS_POST')) {
    define('IS_POST', REQUEST_METHOD == 'POST' ? true : false);
}

if (! defined('IS_PUT')) {
    define('IS_PUT', REQUEST_METHOD == 'PUT' ? true : false);
}

if (! defined('IS_DELETE')) {
    define('IS_DELETE', REQUEST_METHOD == 'DELETE' ? true : false);
}

if (! defined('IS_AJAX')) {
    define('IS_AJAX', (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ? true : false);
}

/**#@+
 * Constants for expressing human-readable intervals
 * in their respective number of seconds.
 *
 * Please note that these values are approximate and are provided for convenience.
 * For example, MONTH_IN_SECONDS wrongly assumes every month has 30 days and
 * YEAR_IN_SECONDS does not take leap years into account.
 *
 * If you need more accuracy please consider using the DateTime class (https://secure.php.net/manual/en/class.datetime.php).
 *
 * @since 3.5.0
 * @since 4.4.0 Introduced `MONTH_IN_SECONDS`.
 */
if (! defined('MINUTE_IN_SECONDS')) {
    define( 'MINUTE_IN_SECONDS', 60 );
}

if (! defined('HOUR_IN_SECONDS')) {
    define( 'HOUR_IN_SECONDS',   60 * MINUTE_IN_SECONDS );
}

if (! defined('DAY_IN_SECONDS')) {
    define( 'DAY_IN_SECONDS',    24 * HOUR_IN_SECONDS   );
}

if (! defined('WEEK_IN_SECONDS')) {
    define( 'WEEK_IN_SECONDS',    7 * DAY_IN_SECONDS    );
}

if (! defined('MONTH_IN_SECONDS')) {
    define( 'MONTH_IN_SECONDS',  30 * DAY_IN_SECONDS    );
}

if (! defined('YEAR_IN_SECONDS')) {
    define( 'YEAR_IN_SECONDS',  365 * DAY_IN_SECONDS    );
}
/**#@-*/


if (! isset($_SERVER['HTTP_REFERER'])) {
    $_SERVER['HTTP_REFERER'] = '';
}
if (! isset($_SERVER['SERVER_PROTOCOL']) || ($_SERVER['SERVER_PROTOCOL'] != 'HTTP/1.0' && $_SERVER['SERVER_PROTOCOL'] != 'HTTP/1.1')) {
    $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.0';
}
if (isset($_SERVER['HTTP_HOST'])) {
    $_SERVER['HTTP_HOST'] = strtolower($_SERVER['HTTP_HOST']);
} else {
    $_SERVER['HTTP_HOST'] = '';
}

if (DIRECTORY_SEPARATOR == '\\') {
    ini_set('include_path', '.;' . SITE_ROOT);
} else {
    ini_set('include_path', '.:' . SITE_ROOT);
}

// end