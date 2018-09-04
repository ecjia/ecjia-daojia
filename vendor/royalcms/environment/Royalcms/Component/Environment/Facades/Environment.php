<?php

namespace Royalcms\Component\Environment\Facades;

use Royalcms\Component\Support\Facades\Facade;
use RC_Hook;

/**
 * @see \Royalcms\Component\Environment\Phpinfo
 */
class Environment extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'phpinfo';
    }

    /**
     * 获得服务器上的 GD 版本
     *
     * @access public
     * @return int 可能的值为0，1，2
     */
    public static function gd_version()
    {
        static $version = - 1;
        
        if ($version >= 0) {
            return $version;
        }
        
        if (! extension_loaded('gd')) {
            $version = 0;
        } else {
            /* 尝试使用gd_info函数 */ 
            if (PHP_VERSION >= '4.3') {
                if (function_exists('gd_info')) {
                    $ver_info = gd_info();
                    preg_match('/\d/', $ver_info['GD Version'], $match);
                    $version = $match[0];
                } else {
                    if (function_exists('imagecreatetruecolor')) {
                        $version = 2;
                    } elseif (function_exists('imagecreate')) {
                        $version = 1;
                    }
                }
            } else {
                if (preg_match('/phpinfo/', ini_get('disable_functions'))) {
                    /* 如果phpinfo被禁用，无法确定gd版本 */
                    $version = 1;
                } else {
                    /* 使用phpinfo函数 */ 
                    ob_start();
                    phpinfo(8);
                    $info = ob_get_contents();
                    ob_end_clean();
                    $info = stristr($info, 'gd version');
                    preg_match('/\d/', $info, $match);
                    $version = $match[0];
                }
            }
        }
        
        return $version;
    }

    /**
     * 获得客户端的操作系统
     *
     * @access private
     * @return void
     */
    public static function get_os()
    {
        if (empty($_SERVER['HTTP_USER_AGENT'])) {
            return 'Unknown';
        }
        
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        $os = '';
        
        if (strpos($agent, 'win') !== false) {
            if (strpos($agent, 'nt 5.1') !== false) {
                $os = 'Windows XP';
            } elseif (strpos($agent, 'nt 5.2') !== false) {
                $os = 'Windows 2003';
            } elseif (strpos($agent, 'nt 5.0') !== false) {
                $os = 'Windows 2000';
            } elseif (strpos($agent, 'nt 6.0') !== false) {
                $os = 'Windows Vista';
            } elseif (strpos($agent, 'nt') !== false) {
                $os = 'Windows NT';
            } elseif (strpos($agent, 'win 9x') !== false && strpos($agent, '4.90') !== false) {
                $os = 'Windows ME';
            } elseif (strpos($agent, '98') !== false) {
                $os = 'Windows 98';
            } elseif (strpos($agent, '95') !== false) {
                $os = 'Windows 95';
            } elseif (strpos($agent, '32') !== false) {
                $os = 'Windows 32';
            } elseif (strpos($agent, 'ce') !== false) {
                $os = 'Windows CE';
            }
        } elseif (strpos($agent, 'linux') !== false) {
            $os = 'Linux';
        } elseif (strpos($agent, 'unix') !== false) {
            $os = 'Unix';
        } elseif (strpos($agent, 'sun') !== false && strpos($agent, 'os') !== false) {
            $os = 'SunOS';
        } elseif (strpos($agent, 'ibm') !== false && strpos($agent, 'os') !== false) {
            $os = 'IBM OS/2';
        } elseif (strpos($agent, 'mac') !== false && strpos($agent, 'pc') !== false) {
            $os = 'Macintosh';
        } elseif (strpos($agent, 'powerpc') !== false) {
            $os = 'PowerPC';
        } elseif (strpos($agent, 'aix') !== false) {
            $os = 'AIX';
        } elseif (strpos($agent, 'hpux') !== false) {
            $os = 'HPUX';
        } elseif (strpos($agent, 'netbsd') !== false) {
            $os = 'NetBSD';
        } elseif (strpos($agent, 'bsd') !== false) {
            $os = 'BSD';
        } elseif (strpos($agent, 'osf1') !== false) {
            $os = 'OSF1';
        } elseif (strpos($agent, 'irix') !== false) {
            $os = 'IRIX';
        } elseif (strpos($agent, 'freebsd') !== false) {
            $os = 'FreeBSD';
        } elseif (strpos($agent, 'teleport') !== false) {
            $os = 'teleport';
        } elseif (strpos($agent, 'flashget') !== false) {
            $os = 'flashget';
        } elseif (strpos($agent, 'webzip') !== false) {
            $os = 'webzip';
        } elseif (strpos($agent, 'offline') !== false) {
            $os = 'offline';
        } else {
            $os = 'Unknown';
        }
        
        return $os;
    }

    /**
     * 获得系统是否启用了 gzip
     *
     * @access public
     *        
     * @return boolean
     */
    public static function gzip_enabled()
    {
        static $enabled_gzip = null;
        
        if ($enabled_gzip === null) {
            $enabled_gzip = function_exists('ob_gzhandler');
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
        return RC_Hook::apply_filters('gzip_enabled', $enabled_gzip);
    }
}

// end