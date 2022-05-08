<?php

namespace Royalcms\Component\Url;

use RC_Config;
use RC_Hook;
use Royalcms\Component\Url\Facades\Uri;

/**
 * Uri获取，RC_Uri实现类
 * Class UriGenerate
 * @package Royalcms\Component\Url
 */
class UriGenerate
{

    private $siteFolder;

    public static function create()
    {
        return new static();
    }

    public function __construct($siteFolder = null)
    {
        $this->siteFolder = $siteFolder;
    }

    public function setSiteFolder($siteFolder)
    {
        $this->siteFolder = $siteFolder;

        return $this;
    }

    /**
     * 获取站点目录
     * @return string|null
     */
    public function getSiteFolder()
    {
        if (! empty($this->siteFolder)) {
            return $this->siteFolder;
        }

        if (! empty($folder = $this->getSiteFolderWithConfig())) {
            return $folder;
        }

        if (! empty($folder = $this->getSiteFolderWithDefined())) {
            return $folder;
        }

        if (! empty($folder = $this->getSiteolderWithScriptName())) {
            return $folder;
        }
    }

    /**
     * 通过RC_SITE的宏定义获取site folder名字
     * @return string
     */
    protected function getSiteFolderWithDefined()
    {
        if (defined('RC_SITE') && constant('RC_SITE')) {
            $site = constant('RC_SITE');
        }
        else {
            $site = '';
        }

        return $site;
    }

    /**
     * 通过config(site.site_folder)的配置定义获取site folder名字
     * @return string
     */
    protected function getSiteFolderWithConfig()
    {
        if (RC_Config::get('site.site_folder')) {
            $site_folder = RC_Config::get('site.site_folder');
        }
        else {
            $site_folder = '';
        }

        return $site_folder;
    }

    /**
     * 通过SCRIPT NAME地址获取site folder名字
     * @return string
     */
    protected function getSiteolderWithScriptName()
    {
        $script_name = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '';
        if (strpos($script_name, '/sites/') === 0) {
            $site_folder = str_replace('/sites/', '', dirname($script_name));
        } else {
            $site_folder = '';
        }

        return $site_folder;
    }

    /**
     * 站点子目录名
     */
    public function getWebPath()
    {
        $script_name = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '';

        if (RC_Config::get('site.web_path')) {
            $web_path = RC_Config::get('site.web_path');
        } else {
            $web_path = dirname($script_name) . '/';
        }

        return $web_path;
    }

    /**
     * 获取原生的home_url
     * @return string
     */
    public function originalHomeUrl()
    {
        /* 主机协议 */
        $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
        /* 当前访问的主机名 */
        $site_host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';

        $home_url = $sys_protocal . $site_host;

        /**
         * Filter the home URL.
         *
         * @since 3.0.0
         *
         * @param string $url The complete home URL including scheme and path.
         */
        return RC_Hook::apply_filters('original_home_url', $home_url);
    }

    /**
     * 获取原生的site_url
     * @return string
     */
    public function originalSiteUrl()
    {
        $site_folder = $this->getSiteFolder();
        $web_path = $this->getWebPath();
        $web_path = rtrim($web_path, '/');

        if ($site_folder) {
            if (strpos($web_path, 'sites')) {
                $site_url = $this->originalHomeUrl() . $web_path;
            }
            else {
                if (RC_Config::get('site.use_sub_domain', false)) {
                    $site_url = $this->originalHomeUrl();
                } else {
                    $site_url = $this->originalHomeUrl() . '/sites/' . $site_folder;
                }
            }
        }
        else {
            $site_url = $this->originalHomeUrl() . $web_path;
        }

        /**
         * Filter the home URL.
         *
         * @since 3.0.0
         *
         * @param string $url The complete home URL including scheme and path.
         */
        return RC_Hook::apply_filters('original_site_url', $site_url);
    }

    /**
     * 获取支持的Schemes
     * @return array
     */
    public function supportSchemes()
    {
        $support_schemes = array(
            'http',
            'https',
            'relative'
        );

        return RC_Hook::apply_filters('support_schemes', $support_schemes);;
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
     * @param string $path (optional) Path relative to the home url.
     * @param string $scheme (optional) Scheme to give the home url context. Currently 'http', 'https', or 'relative'.
     * @return string Home url link with optional path appended.
     */
    public function homeUrl($path = '', $scheme = null)
    {
        $orig_scheme = $scheme;
        $url = $this->originalHomeUrl();

        if (empty($scheme)) {
            $scheme = $this->getUrlScheme($url);
        }

        $url = $this->setUrlScheme($url, $scheme);
        $url = rtrim($url, '/');

        if ($path && is_string($path)) {
            $url .= '/' . ltrim($path, '/');
        }

        /**
         * Filter the home URL.
         *
         * @since 3.0.0
         *
         * @param string $url The complete home URL including scheme and path.
         * @param string $path Path relative to the home URL. Blank string if no path is specified.
         * @param string|null $orig_scheme Scheme to give the home URL context. Accepts 'http', 'https', 'relative' or null.
         */
        return RC_Hook::apply_filters('home_url', $url, $path, $orig_scheme);
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
     * @param string $path Optional. Path relative to the site url.
     * @param string $scheme Optional. Scheme to give the site url context. See set_url_scheme().
     * @return string Site url link with optional path appended.
     */
    public function siteUrl($path = '', $scheme = null)
    {
        $site_folder = $this->getSiteFolder();
        if ($site_folder) {
            $site_url = $this->originalSiteUrl();
        } else {
            $site_url = $this->originalHomeUrl();
        }

        $url = $this->setUrlScheme($site_url, $scheme);
        $url = rtrim($url, '/');

        if ($path && is_string($path)) {
            $url .= '/' . ltrim($path, '/');
        }

        /**
         * Filter the site URL.
         *
         * @since 3.0.0
         *
         * @param string $url The complete site URL including scheme and path.
         * @param string $path Path relative to the site URL. Blank string if no path is specified.
         * @param string|null $scheme Scheme to give the site URL context. Accepts 'http', 'https', 'login',
         *            'login_post', 'admin', 'relative' or null.
         */
        return RC_Hook::apply_filters('site_url', $url, $path, $scheme);
    }


    /**
     * @param $url
     * @return string
     */
    public function getUrlScheme($url)
    {
        if (is_ssl()) {
            $scheme = 'https';
        } else {
            $scheme = parse_url($url, PHP_URL_SCHEME);
        }

        return $scheme;
    }

    /**
     * Set the scheme for a URL
     *
     * @since 3.0.0
     *
     * @param string $url Absolute url that includes a scheme
     * @param string $scheme Optional. Scheme to give $url. Currently 'http', 'https', or 'relative'.
     * @return string $url URL with chosen scheme.
     */
    public function setUrlScheme($url, $scheme = null)
    {
        $orig_scheme = $scheme;
        if (! in_array($scheme, $this->supportSchemes())) {
            $scheme = $this->getUrlScheme($url);
        }

        $url = trim($url);
        if (substr($url, 0, 2) === '//') {
            $url = $scheme. ':' . $url;
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
         * @param string $url The complete URL including scheme and path.
         * @param string $scheme Scheme applied to the URL. One of 'http', 'https', or 'relative'.
         * @param string $orig_scheme Scheme requested for the URL. One of 'http', 'https' or 'relative'.
         */
        return RC_Hook::apply_filters('set_url_scheme', $url, $scheme, $orig_scheme);
    }

    /**
     * Retrieve the url to the content directory.
     *
     * @since 3.0.0
     *
     * @param string $path Optional. Path relative to the vendor url.
     * @return string Vendor url link with optional path appended.
     */
    public function vendorUrl($path = '', $scheme = null)
    {
        $url = $this->homeUrl('', $scheme) . '/vendor';
        $url = rtrim($url, '/');

        if ($path && is_string($path)) {
            $url .= '/' . ltrim($path, '/');
        }

        /**
         * Filter the URL to the content directory.
         *
         * @since 3.0.0
         *
         * @param string $url The complete URL to the content directory including scheme and path.
         * @param string $path Path relative to the URL to the content directory. Blank string
         *            if no path is specified.
         */
        return RC_Hook::apply_filters('vendor_url', $url, $path);
    }

    /**
     * Retrieve the url to the content directory.
     *
     * @since 3.0.0
     *
     * @param string $path Optional. Path relative to the content url.
     * @return string Content url link with optional path appended.
     */
    public function contentUrl($path = '', $scheme = null)
    {
        $url = $this->siteUrl('', $scheme) . '/content';

        if ($path && is_string($path)) {
            $url .= '/' . ltrim($path, '/');
        }

        /**
         * Filter the URL to the content directory.
         *
         * @since 3.0.0
         *
         * @param string $url The complete URL to the content directory including scheme and path.
         * @param string $path Path relative to the URL to the content directory. Blank string
         *            if no path is specified.
         */
        return RC_Hook::apply_filters('content_url', $url, $path);
    }

    /**
     * Retrieve the url to the content directory.
     *
     * @since 3.0.0
     *
     * @param string $path Optional. Path relative to the content url.
     * @return string Content url link with optional path appended.
     */
    public function homeContentUrl($path = '', $scheme = null)
    {
        $url = $this->homeUrl('', $scheme) . '/content';

        if ($path && is_string($path)) {
            $url .= '/' . ltrim($path, '/');
        }

        /**
         * Filter the URL to the content directory.
         *
         * @since 3.0.0
         *
         * @param string $url The complete URL to the content directory including scheme and path.
         * @param string $path Path relative to the URL to the content directory. Blank string
         *            if no path is specified.
         */
        return RC_Hook::apply_filters('home_content_url', $url, $path);
    }

    /**
     * Retrieve the url to the admin static area for the current site.
     *
     * @since 3.4.0
     *
     * @param string $path Optional path relative to the admin url.
     * @param string $scheme The scheme to use. Default is 'admin', which obeys force_ssl_admin() and is_ssl(). 'http' or 'https' can be passed to force those schemes.
     * @return string Admin url link with optional path appended.
     */
    public function assetUrl($path = '', $scheme = 'asset')
    {
        $url = $this->contentUrl('assets/', $scheme);

        $url = rtrim($url, '/');

        if ($path && is_string($path)) {
            $url .= '/' . ltrim($path, '/');
        }

        /**
         * Filter the admin area URL.
         *
         * @since 3.0.0
         *
         * @param string $url The complete admin area URL including scheme and path.
         * @param string $path Path relative to the admin area URL. Blank string if no path is specified.
         */
        return RC_Hook::apply_filters('asset_url', $url, $path);
    }

    /**
     * Retrieve the url to the admin static area for the current site.
     *
     * @since 3.4.0
     *
     * @param string $path Optional path relative to the admin url.
     * @param string $scheme The scheme to use. Default is 'admin', which obeys force_ssl_admin() and is_ssl(). 'http' or 'https' can be passed to force those schemes.
     * @return string Admin url link with optional path appended.
     */
    public function homeAssetUrl($path = '', $scheme = 'asset')
    {
        $url = $this->homeContentUrl('assets/', $scheme);

        $url = rtrim($url, '/');

        if ($path && is_string($path)) {
            $url .= '/' . ltrim($path, '/');
        }

        /**
         * Filter the admin area URL.
         *
         * @since 3.0.0
         *
         * @param string $url The complete admin area URL including scheme and path.
         * @param string $path Path relative to the admin area URL. Blank string if no path is specified.
         */
        return RC_Hook::apply_filters('asset_url', $url, $path);
    }


    /**
     * Retrieve the url to the admin area for the current site.
     *
     * @since 3.0.0
     *
     * @param string $path Optional path relative to the admin url.
     * @param string $scheme The scheme to use. Default is 'admin', which obeys force_ssl_admin() and is_ssl(). 'http' or 'https' can be passed to force those schemes.
     * @return string Admin url link with optional path appended.
     */
    public function adminUrl($path = '', $scheme = 'admin')
    {
        $url = $this->homeContentUrl('system/', $scheme);

        $url = rtrim($url, '/');

        if ($path && is_string($path)) {
            $url .= '/' . ltrim($path, '/');
        }

        /**
         * Filter the admin area URL.
         *
         * @since 3.0.0
         *
         * @param string $url The complete admin area URL including scheme and path.
         * @param string $path Path relative to the admin area URL. Blank string if no path is specified.
         */
        return RC_Hook::apply_filters('admin_url', $url, $path);
    }

    /**
     * Retrieve the url to the upload area for the current site.
     *
     * @since 3.0.0
     *
     * @param string $path Optional path relative to the admin url.
     * @param string $scheme The scheme to use. Default is '', which obeys is_ssl(). 'http' or 'https' can be passed to force those schemes.
     * @return string Upload url link with optional path appended.
     */
    public function originalUploadUrl($path = '', $scheme = null)
    {
        $url = $this->homeContentUrl('uploads/', $scheme);

        $url = rtrim($url, '/');

        if ($path && is_string($path)) {
            $url .= '/' . ltrim($path, '/');
        }

        /**
         * Filter the admin area URL.
         *
         * @since 3.0.0
         *
         * @param string $url The complete admin area URL including scheme and path.
         * @param string $path Path relative to the admin area URL. Blank string if no path is specified.
         */
        return RC_Hook::apply_filters('original_upload_url', $url, $path);
    }

}