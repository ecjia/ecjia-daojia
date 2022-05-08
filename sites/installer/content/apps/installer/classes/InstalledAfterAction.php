<?php


namespace Ecjia\App\Installer;


use ecjia_cloud;
use ecjia_error;
use RC_Config;
use RC_DB;
use RC_File;
use RC_Ip;
use RC_Package;
use RC_Uri;
use Royalcms\Component\Database\QueryException;

class InstalledAfterAction
{

    /**
     * 更新PC内嵌的H5地址
     */
    public static function updateDemoApiUrl()
    {
        try {
            $url = RC_Uri::home_url() . '/sites/m/';

            return RC_DB::table('shop_config')->where('code', 'mobile_touch_url')->update(array('value' => $url));
        } catch (QueryException $e) {
            return new ecjia_error($e->getCode(), $e->getMessage());
        }
    }

    /**
     * 创建存储目录
     */
    public static function createStorageDirectory()
    {
        $dirs = RC_Package::package('app::installer')->loadConfig('checking_dirs');
        collect($dirs)->map(function ($dir) {
            if (!RC_File::isDirectory($dir)) {
                RC_File::makeDirectory($dir);
            }
        });
    }

    /**
     * 写入安装锁定文件
     */
    public static function saveInstallLock()
    {
        $path = storage_path() . '/data/install.lock';
        return RC_File::put($path, 'ECJIA INSTALLED');
    }

    /**
     * 判断安装锁文件是否存在
     */
    public static function checkInstallLock()
    {
        $path = storage_path() . '/data/install.lock';
        return RC_File::exists($path);
    }

    /**
     * 写入 hash_code，做为网站唯一性密钥
     * @return ecjia_error
     */
    public static function updateHashCode()
    {
        $dbhash = md5(SITE_ROOT . env('DB_HOST') . env('DB_USERNAME') . env('DB_PASSWORD') . env('DB_DATABASE'));
        $hash_code = md5(md5(time()) . md5($dbhash) . md5(time()));

        $data = array(
            'shop_url' => RC_Uri::home_url(),
            'hash_code' => $hash_code,
            'ip' => RC_Ip::server_ip(),
            'shop_type' => RC_Config::get('site.shop_type'),
            'version' => RC_Config::get('release.version'),
            'release' => RC_Config::get('release.build'),
            'language' => RC_Config::get('system.locale'),
            'charset' => 'utf-8',
            'php_ver' => PHP_VERSION,
            'mysql_ver' => self::getMysqlVersionByConnection(RC_DB::connection()),
            'ecjia_version' => VERSION,
            'ecjia_release' => RELEASE,
            'royalcms_version' => \Royalcms\Component\Foundation\Royalcms::VERSION,
            'royalcms_release' => \Royalcms\Component\Foundation\Royalcms::RELEASE,
        );
        ecjia_cloud::instance()->api('product/analysis/install')->data($data)->run();

        try {
            return RC_DB::table('shop_config')->where('code', 'hash_code')->update(array('value' => $hash_code));
        } catch (QueryException $e) {
            return new ecjia_error($e->getCode(), $e->getMessage());
        }
    }

    /**
     * 更新 ECJIA 版本
     * @return ecjia_error
     */
    public static function updateEcjiaVersion()
    {
        try {
            $version = RC_Config::get('release.version', '1.3.0');
            RC_DB::table('shop_config')->where('code', 'mobile_app_version')->update(array('value' => $version));
            return RC_DB::table('shop_config')->where('code', 'ecjia_version')->update(array('value' => $version));
        } catch (QueryException $e) {
            return new ecjia_error($e->getCode(), $e->getMessage());
        }
    }

}