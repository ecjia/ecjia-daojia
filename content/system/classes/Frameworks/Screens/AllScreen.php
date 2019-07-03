<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-15
 * Time: 14:16
 */

namespace Ecjia\System\Frameworks\Screens;

use RC_Config;
use RC_Hook;
use RC_Upload;

class AllScreen
{

    public function __construct()
    {


    }


    public function loading()
    {

        RC_Hook::add_filter('pretty_page_table_data', [__CLASS__, 'remove_env_pretty_page_table_data']);

        RC_Hook::add_action('reset_mail_config', ['Ecjia\System\Frameworks\Component\Mailer', 'ecjia_mail_config']);
        RC_Hook::add_action('init', [__CLASS__, 'updateCustomStoragePath']);

        RC_Hook::add_filter('upload_path', [__CLASS__, 'custom_upload_path'], 10, 2);
        RC_Hook::add_filter('upload_url', [__CLASS__, 'custom_upload_url'], 10, 2);
        RC_Hook::add_filter('home_url', [__CLASS__, 'custom_home_url'], 10, 3);
        RC_Hook::add_filter('site_url', [__CLASS__, 'custom_site_url'], 10, 3);

        RC_Hook::add_action('ecjia_admin_finish_launching', [__CLASS__, 'ecjia_set_header']);
        RC_Hook::add_action('ecjia_front_finish_launching', [__CLASS__, 'ecjia_set_header']);


        RC_Hook::add_action('ecjia_admin_finish_launching', [__CLASS__, 'set_ecjia_filter_request_get']);
        RC_Hook::add_action('ecjia_front_finish_launching', [__CLASS__, 'set_ecjia_filter_request_get']);
        RC_Hook::add_action('ecjia_api_finish_launching', [__CLASS__, 'set_ecjia_filter_request_get']);
        RC_Hook::add_action('ecjia_merchant_finish_launching', [__CLASS__, 'set_ecjia_filter_request_get']);
        RC_Hook::add_action('ecjia_platform_finish_launching', [__CLASS__, 'set_ecjia_filter_request_get']);


    }


    /**
     * 移除$_ENV中的敏感信息
     * @param $tables
     * @return mixed
     */
    public static function remove_env_pretty_page_table_data($tables) {
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

    /**
     * 更新上传路径动态更新
     */
    public static function updateCustomStoragePath()
    {
        if (RC_Config::has('site.custom_upload_path')) {
            RC_Config::set('storage.disks.direct.root', RC_Upload::custom_upload_path());
            RC_Config::set('storage.disks.local.root', RC_Upload::custom_upload_path());
        }

        if (RC_Config::has('site.custom_upload_url')) {
            RC_Config::set('storage.disks.direct.url', RC_Upload::custom_upload_url());
            RC_Config::set('storage.disks.local.url', RC_Upload::custom_upload_url());
        }
    }

    /**
     * 自定义上传目录路径
     * @param string $url
     * @param string $path
     * @return string
     */
    public static function custom_upload_path($url, $path)
    {
        if (RC_Config::has('site.custom_upload_path')) {
            $upload_path = RC_Config::get('site.custom_upload_path');
        } else {
            $upload_path = SITE_UPLOAD_PATH;
        }

        $upload_path = $upload_path . ltrim($path, '/');

        return $upload_path;
    }

    /**
     * 自定义上传目录访问URL
     * @param string $url
     * @param string $path
     * @return string
     */
    public static function custom_upload_url($url, $path)
    {
        if (RC_Config::has('site.custom_upload_url')) {
            $home_url = RC_Config::get('site.custom_upload_url');
            $url = $home_url . '/' . $path;
        }

        $upload_url = rtrim($url, '/');

        return $upload_url;
    }

    /**
     * 自定义项目访问URL
     * @param string $url
     * @param string $path
     * @return string
     */
    public static function custom_home_url($url, $path, $scheme)
    {
        if (RC_Config::has('site.custom_home_url')) {
            $home_url = RC_Config::get('site.custom_home_url');
            $url = $home_url . '/' . $path;
        }
        return rtrim($url, '/');
    }

    /**
     * 自定义项目访问URL
     * @param string $url
     * @param string $path
     * @return string
     */
    public static function custom_site_url($url, $path, $scheme)
    {
        if (RC_Config::has('site.custom_site_url')) {
            $home_url = RC_Config::get('site.custom_site_url');
            $url = $home_url . '/' . $path;
        }
        return rtrim($url, '/');
    }

    public static function set_ecjia_filter_request_get()
    {
        ecjia_filter_request_input($_GET);
        ecjia_filter_request_input($_REQUEST);
    }


    public static function ecjia_set_header()
    {
        header('content-type: text/html; charset=' . RC_CHARSET);
        header('Expires: Fri, 14 Mar 1980 20:53:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-cache, must-revalidate');
        header('Pragma: no-cache');
    }

}