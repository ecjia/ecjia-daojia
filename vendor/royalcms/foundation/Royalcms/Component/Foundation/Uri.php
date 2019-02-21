<?php

namespace Royalcms\Component\Foundation;

use RC_Config;
use Royalcms\Component\Support\Format;
use RC_Hook;
use RC_Route;

class Uri extends RoyalcmsObject
{

    /**
     * 根据配置文件的URL参数重新生成URL地址
     *
     * @param String $pathinfo
     *            访问url
     * @param array $args
     *            GET参数
     *            <code>
     *            $args = "nid=2&cid=1"
     *            $args=array("nid"=>2,"cid"=>1)
     *            </code>
     * @return string
     */
    public static function url($pathinfo, $args = array())
    {
        if (preg_match("/^https?:\/\//i", $pathinfo))
            return $pathinfo;
        
        if (strpos($pathinfo, '@') === 0) {
            $pathinfo = str_replace('@', RC_Config::get('system.admin_entrance') . '/', $pathinfo);
        } elseif (strpos($pathinfo, '#') === 0) {
            $pathinfo = str_replace('#', ROUTE_M . '/', $pathinfo);
        }
        
        $gets = self::build_params($pathinfo, $args);
        /* 入口文件类型 */
        /* normal pathinfo */ 
        $urlType = RC_Config::get('system.url_mode');
        $url = '';
        switch ($urlType) {
            case 'pathinfo':
                foreach ($gets as $value) {
                    $url .= RC_Config::get('system.url_pathinfo_dli') . $value;
                }
                $url = str_replace(array(
                    "/" . RC_Config::get('route.module') . "/",
                    "/" . RC_Config::get('route.controller') . "/",
                    "/" . RC_Config::get('route.action') . "/"
                ), "/", $url);
                $url = substr($url, 1);
                break;
            case 'normal':
                /*
                foreach ($gets as $k => $value) {
                    if ($k % 2) {
                        $url .= '=' . $value;
                    } else {
                        $url .= '&' . $value;
                    }
                }
                $url = substr($url, 1);
                */

                foreach ($gets as $k => $value) {
                    if ($k % 2) {

                        if (is_array($value)) {
                            $url .= '=' . implode('', $value);
                        } else {
                            $url .= '=' . $value;
                        }

                    } else {
                        $url .= '&' . $value;
                    }
                }
                $url = substr($url, 1);

                break;
        }
        
        /* 伪表态后缀如.html */ 
        if ($urlType == 'pathinfo' && RC_Config::get('system.url_pathinfo_suf')) {
            $pathinfo_suf = '.' . trim(RC_Config::get('system.url_pathinfo_suf'), '.');
        } else {
            $pathinfo_suf = '';
        }
        
        return self::build_root_url($pathinfo) . self::resolve_url($url) . $pathinfo_suf;
    }

    private static function build_params($pathinfo, $args = array())
    {
        $parseUrl = parse_url(trim($pathinfo, '/'));
        $path = trim($parseUrl['path'], '/');
        $vars = explode("/", $path);
        
        /* 组合出PATH内容 */ 
        $data = array();
        switch (count($vars)) {
            /* 应用 */ 
            case 3: 
                $data[] = RC_Config::get('route.module');
                $data[] = array_shift($vars);
                $data[] = RC_Config::get('route.controller');
                $data[] = array_shift($vars);
                $data[] = RC_Config::get('route.action');
                $data[] = array_shift($vars);
                break;
            /* 控制器 */ 
            case 2: 
                $data[] = RC_Config::get('route.module');
                $data[] = ROUTE_M;
                $data[] = RC_Config::get('route.controller');
                $data[] = array_shift($vars);
                $data[] = RC_Config::get('route.action');
                $data[] = array_shift($vars);
                break;
            /* 方法 */ 
            case 1: 
                $data[] = RC_Config::get('route.module');
                $data[] = ROUTE_M;
                $data[] = RC_Config::get('route.controller');
                $data[] = ROUTE_C;
                $data[] = RC_Config::get('route.action');
                $data[] = array_shift($vars);
                break;
            /* 应用组及其他情况 */ 
            default: 
                $data[] = RC_Config::get('route.module');
                $data[] = array_shift($vars);
                $data[] = RC_Config::get('route.controller');
                $data[] = array_shift($vars);
                $data[] = RC_Config::get('route.action');
                $data[] = array_shift($vars);
                if (is_array($vars)) {
                    foreach ($vars as $v) {
                        $data[] = $v;
                    }
                }
        }
        
        /* 合并GET参数 */ 
        $gets = array_merge($data, self::build_gets($pathinfo, $args));

        return $gets;
    }

    private static function build_gets($pathinfo, $args = array())
    {
        /* 参数$args为字符串时转数组 */ 
        if (is_string($args)) {
            $args = urldecode($args);
            parse_str($args, $args);
        }

        $parseUrl = parse_url(trim($pathinfo, '/'));
        
        /* 解析字符串的?后参数 并与$args合并 */ 
        if (isset($parseUrl['query'])) {
            parse_str($parseUrl['query'], $query);
            $args = array_merge($query, $args);
        }
        
        /* 组合出索引数组 将?后参数与$args传参 */ 
        $gets = array();
        if (is_array($args)) {
            foreach ($args as $n => $q) {
                array_push($gets, $n);
                array_push($gets, $q);
            }
        }

        return $gets;
    }

    private static function build_root_url($pathinfo)
    {
        /* 是否指定单入口 */ 
        $end = strpos($pathinfo, '.php');
        if ($end) {
            $web = self::site_url() . '/' . substr($pathinfo, 0, $end + 4);
            $pathinfo = substr($pathinfo, $end + 4);
        } else {
            $web = self::site_url();
        }
        /* 入口文件类型 */ 
        $urlType = RC_Config::get('system.url_mode'); // normal pathinfo
        switch ($urlType) {
            case 'pathinfo':
                /* 入口位置 */ 
                if (RC_Config::get('system.url_rewrite')) {
                    $root = $web . '/';
                } else {
                    $root = $web . '/index.php' . '/';
                }
                break;
            case 'normal':
                $root = $web . '/index.php' . '?';
                break;
        }
        
        if (RC_Config::get('system.url_rewrite')) {
            $root = preg_replace('/\w+?\.php\/?/i', '', $root);
        }
        
        return $root;
    }

    /**
     * 将URL按路由规则进行处理
     * Uri::url()函数等使用
     *
     * @access public
     * @param string $url url字符串不含.'?|/'
     * @return string
     */
    private static function resolve_url($url)
    {
        $route = royalcms('default-router');
        $rules = $route->getRule();
        /* 未定义路由规则 */ 
        if (! $rules) {
            return $url;
        }
        
        foreach ($rules as $routeKey => $routeVal) {
            $routeKey = trim($routeKey);
            /* 正则路由 */ 
            if (substr($routeKey, 0, 1) === '/') {
                /* 识别正则路由中的原子组 */ 
                $regGroup = array(); 
                preg_match_all('@\(.*?\)@i', $routeKey, $regGroup, PREG_PATTERN_ORDER);
                /* 匹配URL的正则 */ 
                $searchRegExp = $routeVal; 
                /* 将正则路由的$v中的值#1换成$r中的(\d+)形式 */ 
                for ($i = 0, $total = count($regGroup[0]); $i < $total; $i ++) {
                    $searchRegExp = str_replace('#' . ($i + 1), $regGroup[0][$i], $searchRegExp);
                }
                /* URL参数 */ 
                $urlArgs = array(); 
                preg_match_all("@" . $searchRegExp . "@i", $url, $urlArgs, PREG_SET_ORDER);
                /* 满足路由规则 */ 
                if ($urlArgs) {
                    /* 清除路由中的/$与/正则边界 */ 
                    $routeUrl = trim(str_replace(array(
                        '/^',
                        '$/'
                    ), '', $routeKey), '/');
                    foreach ($regGroup[0] as $k => $v) {
                        $v = preg_replace('@([\*\$\(\)\+\?\[\]\{\}\\\])@', '\\\$1', $v);
                        $routeUrl = preg_replace('@' . $v . '@', $urlArgs[0][$k + 1], $routeUrl, $count = 1);
                    }
                    
                    return trim($routeUrl, '/');
                }
            } else {
                /* 获得如 "info/:city_:row" 中的:city与:row */ 
                $routeGetVars = array();
                /* 普通路由处理 */ 
                /* 获得路由规则中以:开始的变量 */ 
                preg_match_all('/:([a-z]*)/i', $routeKey, $routeGetVars, PREG_PATTERN_ORDER); 
                $getRouteUrl = $routeVal;
                switch (RC_Config::get('system.url_mode')) {
                    case 'pathinfo':
                        $getRouteUrl .= '/';
                        foreach ($routeGetVars[1] as $getK => $getV) {
                            $getRouteUrl .= $getV . '/(.*)/';
                        }
                        $getRouteUrl = '@' . trim($getRouteUrl, '/') . '@i';
                        break;
                    case 'normal':
                        $getRouteUrl .= '&';
                        foreach ($routeGetVars[1] as $getK => $getV) {
                            $getRouteUrl .= $getV . '=(.*)' . '&';
                        }
                        $getRouteUrl = '@' . trim($getRouteUrl, '&') . '@i';
                        break;
                }
                $getArgs = array();
                preg_match_all($getRouteUrl, $url, $getArgs, PREG_SET_ORDER);
                if ($getArgs) {
                    /* 去除路由中的传参数如:uid */ 
                    $newUrl = $routeKey;
                    foreach ($routeGetVars[0] as $rk => $getName) {
                        $newUrl = str_replace($getName, $getArgs[0][$rk + 1], $newUrl);
                    }
                    return $newUrl;
                }
            }
        }
        return $url;
    }

    /**
     * 获取当前页面完整URL地址
     */
    public static function current_url()
    {
        $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
        $php_self = $_SERVER['PHP_SELF'] ? safe_replace($_SERVER['PHP_SELF']) : safe_replace($_SERVER['SCRIPT_NAME']);
        $path_info = isset($_SERVER['PATH_INFO']) ? safe_replace($_SERVER['PATH_INFO']) : '';
        $relate_url = isset($_SERVER['REQUEST_URI']) ? safe_replace($_SERVER['REQUEST_URI']) : $php_self . (isset($_SERVER['QUERY_STRING']) ? '?' . safe_replace($_SERVER['QUERY_STRING']) : $path_info);
        $current_url = $sys_protocal . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '') . $relate_url;
        
        /**
         * Filter the resulting URL after setting the scheme.
         *
         * @since 3.0.0
         *       
         * @param string $url
         *            The complete URL including scheme and path.
         * @param string $scheme
         *            Scheme applied to the URL. One of 'http', 'https', or 'relative'.
         * @param string $orig_scheme
         *            Scheme requested for the URL. One of 'http', 'https' or 'relative'.
         */
        return RC_Hook::apply_filters('set_current_url', $current_url);
    }
    
    /**
     * 站点文件夹名
     */
    public static function site_folder() {
        $php_self = $_SERVER['PHP_SELF'] ? safe_replace($_SERVER['PHP_SELF']) : safe_replace($_SERVER['SCRIPT_NAME']);
    
        if (RC_Config::has('site.site_folder')) {
            $site_folder = RC_Config::get('site.site_folder');
        } else {
            if (strpos($php_self, '/sites/') === 0) {
                $site_folder = str_replace('/sites/', '', dirname($php_self));
            } else {
                $site_folder = '';
            }
        }
    
        return $site_folder;
    }
    
    /**
     * 站点子目录名
     */
    public static function web_path() {
        /* 主机协议 */
        $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
        /* 当前访问的主机名 */
        $site_host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
        $php_self = $_SERVER['PHP_SELF'] ? safe_replace($_SERVER['PHP_SELF']) : safe_replace($_SERVER['SCRIPT_NAME']);
    
        if (RC_Config::has('site.web_path')) {
            $web_path = RC_Config::get('site.web_path');
        } else {
            $web_path = str_replace($sys_protocal . $site_host, '', dirname($sys_protocal . $site_host . $php_self)) . '/';
        }
    
        return $web_path;
    }
    
    /**
     * 获取原生的home_url
     * @return string
     */
    public static function original_home_url() {
        /* 主机协议 */
        $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
        /* 当前访问的主机名 */
        $site_host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
        
        $site_folder = self::site_folder();
        $site_url = self::original_site_url();
        
        if ($site_folder) {
            $home_url = str_replace('/sites/' . $site_folder, '', $site_url);
        } else {
            $home_url = $site_url;
        }
        
        return $home_url;
    }
    
    /**
     * 获取原生的site_url
     * @return string
     */
    public static function original_site_url() {
        /* 主机协议 */
        $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
        /* 当前访问的主机名 */
        $site_host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
        
        $site_folder = self::site_folder();
        $web_path = self::web_path();

        if ($site_folder) {
            if (strpos($web_path, 'sites')) {
                $site_url = $sys_protocal . $site_host . rtrim($web_path, '/');
            } else {
                if (RC_Config::get('site.use_sub_domain', false)) {
                    $site_url = $sys_protocal . $site_host . rtrim($web_path, '/');
                } else {
                    $site_url = $sys_protocal . $site_host . rtrim($web_path, '/') . '/sites/' . $site_folder;
                }
            }
        } else {
            $site_url = $sys_protocal . $site_host . rtrim($web_path, '/');
        }
        
        return $site_url;
    }

    /**
     * Retrieve the home url for the current site.
     *
     * Returns the 'home' option with the appropriate protocol, 'https' if
     * is_ssl() and 'http' otherwise. If $scheme is 'http' or 'https', is_ssl() is
     * overridden.
     *
     * @since 3.0.0
     *       
     * @param string $path
     *            (optional) Path relative to the home url.
     * @param string $scheme
     *            (optional) Scheme to give the home url context. Currently 'http', 'https', or 'relative'.
     * @return string Home url link with optional path appended.
     */
    public static function home_url($path = '', $scheme = null)
    {
        $orig_scheme = $scheme;
        $url = self::original_home_url();
        
        if (! in_array($scheme, array(
            'http',
            'https',
            'relative'
        ))) {
            if (is_ssl()) {
                $scheme = 'https';
            } else {
                $scheme = parse_url($url, PHP_URL_SCHEME);
            }   
        }
        
        $url = self::set_url_scheme($url, $scheme);
        $url = rtrim($url, '/');
        
        if ($path && is_string($path)) {
            $url .= '/' . ltrim($path, '/');
        }  

        /**
         * Filter the home URL.
         *
         * @since 3.0.0
         *       
         * @param string $url
         *            The complete home URL including scheme and path.
         * @param string $path
         *            Path relative to the home URL. Blank string if no path is specified.
         * @param string|null $orig_scheme
         *            Scheme to give the home URL context. Accepts 'http', 'https', 'relative' or null.
         */
        return RC_Hook::apply_filters('home_url', $url, $path, $orig_scheme);
    }
    
    

    /**
     * Set the scheme for a URL
     *
     * @since 3.0.0
     *       
     * @param string $url
     *            Absolute url that includes a scheme
     * @param string $scheme
     *            Optional. Scheme to give $url. Currently 'http', 'https', or 'relative'.
     * @return string $url URL with chosen scheme.
     */
    public static function set_url_scheme($url, $scheme = null)
    {
        $orig_scheme = $scheme;
        if (! in_array($scheme, array(
            'http',
            'https',
            'relative'
        ))) {
            $scheme = (is_ssl() ? 'https' : 'http');
        }
        
        $url = trim($url);
        if (substr($url, 0, 2) === '//') {
            $url = 'http:' . $url;
        } 
        
        if ('relative' == $scheme) {
            $url = ltrim(preg_replace('#^\w+://[^/]*#', '', $url));
            if ($url !== '' && $url[0] === '/') {
                $url = '/' . ltrim($url, "/ \t\n\r\0\x0B");
            }  
        } else {
            $url = preg_replace('#^\w+://#', $scheme . '://', $url);
        }
        
        /**
         * Filter the resulting URL after setting the scheme.
         *
         * @since 3.0.0
         *       
         * @param string $url
         *            The complete URL including scheme and path.
         * @param string $scheme
         *            Scheme applied to the URL. One of 'http', 'https', or 'relative'.
         * @param string $orig_scheme
         *            Scheme requested for the URL. One of 'http', 'https' or 'relative'.
         */
        return RC_Hook::apply_filters('set_url_scheme', $url, $scheme, $orig_scheme);
    }

    /**
     * Retrieve the site url for the current site.
     *
     * Returns the 'site_url' option with the appropriate protocol, 'https' if
     * is_ssl() and 'http' otherwise. If $scheme is 'http' or 'https', is_ssl() is
     * overridden.
     *
     * @since 3.0.0
     *       
     * @param string $path
     *            Optional. Path relative to the site url.
     * @param string $scheme
     *            Optional. Scheme to give the site url context. See set_url_scheme().
     * @return string Site url link with optional path appended.
     */
    public static function site_url($path = '', $scheme = null)
    {
        $site_folder = self::site_folder();
        if ($site_folder) {
            $site_url = self::original_site_url();
        } else {
            $site_url = self::original_home_url();
        }
        
        $url = self::set_url_scheme($site_url, $scheme);
        $url = rtrim($url, '/');
        
        if ($path && is_string($path)) {
            $url .= '/' . ltrim($path, '/');
        } 
        
        /**
         * Filter the site URL.
         *
         * @since 3.0.0
         *       
         * @param string $url
         *            The complete site URL including scheme and path.
         * @param string $path
         *            Path relative to the site URL. Blank string if no path is specified.
         * @param string|null $scheme
         *            Scheme to give the site URL context. Accepts 'http', 'https', 'login',
         *            'login_post', 'admin', 'relative' or null.
         */
        return RC_Hook::apply_filters('site_url', $url, $path, $scheme);
    }

    /**
     * Retrieve the url to the admin area for the current site.
     *
     * @since 3.0.0
     *       
     * @param string $path
     *            Optional path relative to the admin url.
     * @param string $scheme
     *            The scheme to use. Default is 'admin', which obeys force_ssl_admin() and is_ssl(). 'http' or 'https' can be passed to force those schemes.
     * @return string Admin url link with optional path appended.
     */
    public static function admin_url($path = '', $scheme = 'admin')
    {
        if (self::site_folder() && Loader::exists_site_system()) {
            $url = self::site_url('content/system/', $scheme);
        } else {
            $url = self::home_url('content/system/', $scheme);
        }
        
        $url = rtrim($url, '/');
        
        if ($path && is_string($path)) {
            $url .= '/' . ltrim($path, '/');
        } 
        
        /**
         * Filter the admin area URL.
         *
         * @since 3.0.0
         *       
         * @param string $url
         *            The complete admin area URL including scheme and path.
         * @param string $path
         *            Path relative to the admin area URL. Blank string if no path is specified.
         */
        return RC_Hook::apply_filters('admin_url', $url, $path);
    }
    
    /**
     * Retrieve the url to the admin static area for the current site.
     *
     * @since 3.4.0
     *
     * @param string $path
     *            Optional path relative to the admin url.
     * @param string $scheme
     *            The scheme to use. Default is 'admin', which obeys force_ssl_admin() and is_ssl(). 'http' or 'https' can be passed to force those schemes.
     * @return string Admin url link with optional path appended.
     */
    public static function system_static_url($path = '', $scheme = 'admin') {
        if (self::site_folder() && Loader::exists_site_system()) {
            $url = self::site_url('content/system/statics/', $scheme);
        } else {
            $url = self::home_url('content/system/statics/', $scheme);
        }
        
        $url = rtrim($url, '/');
        
        if ($path && is_string($path)) {
            $url .= '/' . ltrim($path, '/');
        }
        
        /**
         * Filter the admin area URL.
         *
         * @since 3.0.0
         *
         * @param string $url
         *            The complete admin area URL including scheme and path.
         * @param string $path
         *            Path relative to the admin area URL. Blank string if no path is specified.
         */
        return RC_Hook::apply_filters('system_static_url', $url, $path);
    }
    
    
    /**
     * Retrieve the url to the content directory.
     *
     * @since 3.0.0
     *
     * @param string $path
     *            Optional. Path relative to the content url.
     * @return string Content url link with optional path appended.
     */
    public static function home_content_url($path = '')
    {
        $url = self::set_url_scheme(Uri::home_url() . '/content');

        if ($path && is_string($path)) {
            $url .= '/' . ltrim($path, '/');
        }
    
        /**
         * Filter the URL to the content directory.
         *
         * @since 3.0.0
         *
         * @param string $url
         *            The complete URL to the content directory including scheme and path.
         * @param string $path
         *            Path relative to the URL to the content directory. Blank string
         *            if no path is specified.
        */
        return RC_Hook::apply_filters('home_content_url', $url, $path);
    }

    /**
     * Retrieve the url to the content directory.
     *
     * @since 3.0.0
     *       
     * @param string $path
     *            Optional. Path relative to the content url.
     * @return string Content url link with optional path appended.
     */
    public static function content_url($path = '')
    {
        $url = self::set_url_scheme(SITE_CONTENT_URL);
        
        if ($path && is_string($path)) {
            $url .= '/' . ltrim($path, '/');
        }  
        
        /**
         * Filter the URL to the content directory.
         *
         * @since 3.0.0
         *       
         * @param string $url
         *            The complete URL to the content directory including scheme and path.
         * @param string $path
         *            Path relative to the URL to the content directory. Blank string
         *            if no path is specified.
         */
        return RC_Hook::apply_filters('content_url', $url, $path);
    }

    /**
     * Retrieve the url to the content directory.
     *
     * @since 3.0.0
     *       
     * @param string $path
     *            Optional. Path relative to the vendor url.
     * @return string Vendor url link with optional path appended.
     */
    public static function vendor_url($path = '')
    {
        $url = self::set_url_scheme(self::home_url() . '/vendor');
        $url = rtrim($url, '/');
        
        if ($path && is_string($path)) {
            $url .= '/' . ltrim($path, '/');
        } 
        
        /**
         * Filter the URL to the content directory.
         *
         * @since 3.0.0
         *       
         * @param string $url
         *            The complete URL to the content directory including scheme and path.
         * @param string $path
         *            Path relative to the URL to the content directory. Blank string
         *            if no path is specified.
         */
        return RC_Hook::apply_filters('vendor_url', $url, $path);
    }

    /**
     * Retrieve the url to the admin area for the current site.
     *
     * @since 3.0.0
     *       
     * @param string $path
     *            Optional path relative to the admin url.
     * @return string Admin url link with optional path appended.
     */
    public static function admin_path($path = '')
    {
        $system_root = SITE_SYSTEM_PATH;
        
        if ($path && is_string($path)) {
            $system_root = rtrim($system_root, DIRECTORY_SEPARATOR);
            $system_root .= DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR);
        }   
        
        /**
         * Filter the admin area URL.
         *
         * @since 3.0.0
         *       
         * @param string $url
         *            The complete admin area URL including scheme and path.
         * @param string $path
         *            Path relative to the admin area URL. Blank string if no path is specified.
         */
        return RC_Hook::apply_filters('admin_path', $system_root, $path);
    }

    /**
     * Retrieve a modified URL query string.
     *
     * You can rebuild the URL and append a new query variable to the URL query by
     * using this function. You can also retrieve the full URL with query data.
     *
     * Adding a single key & value or an associative array. Setting a key value to
     * an empty string removes the key. Omitting oldquery_or_uri uses the $_SERVER
     * value. Additional values provided are expected to be encoded appropriately
     * with urlencode() or rawurlencode().
     *
     * @since 3.0.0
     *       
     * @param mixed $param1
     *            Either newkey or an associative_array
     * @param mixed $param2
     *            Either newvalue or oldquery or uri
     * @param mixed $param3
     *            Optional. Old query or uri
     * @return string New URL query string.
     */
    public static function add_query_arg()
    {
        $ret = '';
        $args = func_get_args();
        if (is_array($args[0])) {
            if (count($args) < 2 || false === $args[1]) {
                $uri = $_SERVER['REQUEST_URI'];
            } else {
                $uri = $args[1];
            }   
        } else {
            if (count($args) < 3 || false === $args[2]) {
                $uri = $_SERVER['REQUEST_URI'];
            } else {
                $uri = $args[2];
            }   
        }
        
        $frag = strstr($uri, '#');
        if ($frag) {
            $uri = substr($uri, 0, - strlen($frag));
        } else {
            $frag = '';
        } 
        
        if (0 === stripos($uri, 'http://')) {
            $protocol = 'http://';
            $uri = substr($uri, 7);
        } elseif (0 === stripos($uri, 'https://')) {
            $protocol = 'https://';
            $uri = substr($uri, 8);
        } else {
            $protocol = '';
        }
        
        if (strpos($uri, '?') !== false) {
            list ($base, $query) = explode('?', $uri, 2);
            $base .= '?';
        } elseif ($protocol || strpos($uri, '=') === false) {
            $base = $uri . '?';
            $query = '';
        } else {
            $base = '';
            $query = $uri;
        }
        
        rc_parse_str($query, $qs);
        $qs = Format::urlencode_deep($qs); // this re-URL-encodes things that were already in the query string
        if (is_array($args[0])) {
            $kayvees = $args[0];
            $qs = array_merge($qs, $kayvees);
        } else {
            $qs[$args[0]] = $args[1];
        }
        
        foreach ($qs as $k => $v) {
            if ($v === false) {
                unset($qs[$k]);
            }    
        }
        
        $ret = self::build_query($qs);
        $ret = trim($ret, '?');
        $ret = preg_replace('#=(&|$)#', '$1', $ret);
        $ret = $protocol . $base . $ret . $frag;
        $ret = rtrim($ret, '?');
        return $ret;
    }

    /**
     * Build URL query based on an associative and, or indexed array.
     *
     * This is a convenient function for easily building url queries. It sets the
     * separator to '&' and uses _http_build_query() function.
     *
     * @see _http_build_query() Used to build the query
     * @link http://us2.php.net/manual/en/function.http-build-query.php more on what
     *       http_build_query() does.
     *      
     * @since 3.0.0
     *       
     * @param array $data
     *            URL-encode key/value pairs.
     * @return string URL encoded string
     */
    public static function build_query($data)
    {
        return self::_http_build_query($data, null, '&', '', false);
    }
    
    /**
     * from php.net (modified by Mark Jaquith to behave like the native PHP5 function)
     * @param array $data
     * @param string $prefix
     * @param string $sep
     * @param string $key
     * @param string $urlencode
     * @return string
     */
    public static function _http_build_query($data, $prefix = null, $sep = null, $key = '', $urlencode = true)
    {
        $ret = array();
        
        foreach ((array) $data as $k => $v) {
            if ($urlencode) {
                $k = urlencode($k);
            }
                
            if (is_int($k) && $prefix != null) {
                $k = $prefix . $k;
            }
                
            if (! empty($key)) {
                $k = $key . '%5B' . $k . '%5D';
            }
                
            if ($v === null) {
                continue;
            } elseif ($v === FALSE) {
                $v = '0';
            }
            
            if (is_array($v) || is_object($v)) {
                array_push($ret, self::_http_build_query($v, '', $sep, $k, $urlencode));
            } elseif ($urlencode) {
                array_push($ret, $k . '=' . urlencode($v));
            } else {
                array_push($ret, $k . '=' . $v);
            }    
        }
        
        if (null === $sep) {
            $sep = ini_get('arg_separator.output');
        }  
        
        return implode($sep, $ret);
    }
}

// end