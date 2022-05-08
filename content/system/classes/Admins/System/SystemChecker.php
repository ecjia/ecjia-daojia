<?php


namespace Ecjia\System\Admins\System;


use ecjia;
use Illuminate\Support\Traits\Macroable;
use RC_ENV;
use RC_Model;

class SystemChecker
{
    use Macroable;

    protected $system = [];

    public function __construct()
    {
        $this->system['os'] = PHP_OS;
        $this->system['php_ver'] = PHP_VERSION;
    }

    protected function checkServer()
    {
        $this->system['ip']                 = $_SERVER['SERVER_ADDR'];
        $this->system['web_server']         = $_SERVER['SERVER_SOFTWARE'];
    }


    protected function checkDatabase()
    {
        $this->system['mysql_ver']          = RC_Model::make()->database_version();
    }


    protected function checkPHPINI()
    {
        $this->system['safe_mode']          = (boolean) ini_get('safe_mode') ?  __('是'):__('否');
        $this->system['safe_mode_gid']      = (boolean) ini_get('safe_mode_gid') ? __('是'):__('否');
        /* 允许上传的最大文件大小 */
        $this->system['max_filesize']       = ini_get('upload_max_filesize');
    }

    protected function checkFunction()
    {
        $this->system['zlib']               = function_exists('gzclose') ? __('是'):__('否');
        $this->system['timezone']           = function_exists("date_default_timezone_get") ? date_default_timezone_get() : __('无需设置');
        $this->system['socket']             = function_exists('fsockopen') ? __('是'):__('否');
        $this->system['gd']                 = $this->formatGDVersionDisplay();
    }

    protected function checkRoyalcmsVersion()
    {
        $this->system['royalcms_version']   = royalcms()->royalcmsVersion();
        $this->system['royalcms_release']   = royalcms()->release();
    }

    protected function checkLaravelVersion()
    {
        $this->system['laravel_version']   = royalcms()->laravelVersion();
    }

    protected function checkEcjiaVersion()
    {
        $this->system['ecjia_version'] = VERSION;
        $this->system['ecjia_release'] = RELEASE;
    }

    protected function checkEcjiaFrameworkVersion()
    {
        $this->system['ecjia_framework_version'] = \Ecjia\Component\Framework\Ecjia::VERSION;
        $this->system['ecjia_framework_release'] = \Ecjia\Component\Framework\Ecjia::RELEASE;
    }

    protected function checkInstallDate()
    {
        $this->system['install_date'] = date(ecjia::config('date_format'), ecjia::config('install_date'));
    }

    public function getSystem()
    {
        $this->checkServer();
        $this->checkDatabase();
        $this->checkPHPINI();
        $this->checkFunction();
        $this->checkRoyalcmsVersion();
        $this->checkLaravelVersion();
        $this->checkEcjiaVersion();
        $this->checkEcjiaFrameworkVersion();
        $this->checkInstallDate();

        return $this->system;
    }


    /**
     * 格式化GD版本显示
     */
    private function formatGDVersionDisplay()
    {
        $gd = RC_ENV::gd_version();
        if ($gd == 0) {
            return 'N/A';
        }

        if ($gd == 1) {
            $label = 'GD1';
        } else {
            $label = 'GD2';
        }

        $support = [];
        /* 检查系统支持的图片类型 */
        if ((imagetypes() & IMG_JPG) > 0) {
            $support[] = 'JPEG';
        }

        if ((imagetypes() & IMG_GIF) > 0) {
            $support[] = 'GIF';
        }

        if ((imagetypes() & IMG_PNG) > 0) {
            $support[] = 'PNG';
        }

        $display = sprintf("%s (%s)", $label, implode(' ', $support));

        return $display;
    }

}