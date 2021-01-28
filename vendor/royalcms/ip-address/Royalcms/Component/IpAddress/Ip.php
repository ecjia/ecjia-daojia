<?php namespace Royalcms\Component\IpAddress;

/**
 * IP处理类
 */
class Ip
{

    /**
     * 从ip文件得到ip所属地区
     *
     * 过滤掉了具体的位置（如 网通/电信/**网吧） 基本到市
     * *
     */
    private static function _convert_ip_tiny($ip, $ipdatafile)
    {
        $ip_addres = new IpAddress($ipdatafile);
        
        $area = $ip_addres->getLocation($ip);
        
        return $area['country'] . ' ' . $area['area'];
    }

    private static function _change_simply_area($area)
    {
        $tmp = explode(' ', $area); // 过滤掉一些具体信息
        return $tmp[0];
    }

    public static function area($ip = '', $isSimple = true, $ip_file = '')
    {
        if (! $ip) {
            $ip = self::client_ip();
        }

        if (preg_match("/^\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}$/", $ip)) {
            $iparray = explode('.', $ip);
            if ($iparray[0] == 10 || $iparray[0] == 127 || ($iparray[0] == 192 && $iparray[1] == 168) || ($iparray[0] == 172 && ($iparray[1] >= 16 && $iparray[1] <= 31))) {
                return '局域网';
            } elseif ($iparray[0] > 255 || $iparray[1] > 255 || $iparray[2] > 255 || $iparray[3] > 255) {
                return 'ERROR';
            } elseif ($isSimple) {
                return self::_change_simply_area(self::_convert_ip_tiny($ip, $ip_file));
            } else {
                return self::_convert_ip_tiny($ip, $ip_file);
            }
        }
    }

    /**
     * 获得客户端IP
     *
     * @param int $type
     *            1 返回IP地址 2返回ipv4的ip数字
     * @return type
     */
    public static function client_ip($type = 0)
    {
        static $client_ip = null;
        if ($client_ip !== null) {
            return $type == 0 ? $client_ip[0] : $client_ip[1];
        }
        /* 保存客户端IP地址 */ 
        $ip = ''; 
        // TODO: 获取的IP地址是ipv6的，非ipv4
        if (isset($_SERVER)) {
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else 
                if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                    $ip = $_SERVER["HTTP_CLIENT_IP"];
                } else {
                    $ip = $_SERVER["REMOTE_ADDR"];
                }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")) {
                $ip = getenv("HTTP_X_FORWARDED_FOR");
            } else 
                if (getenv("HTTP_CLIENT_IP")) {
                    $ip = getenv("HTTP_CLIENT_IP");
                } else {
                    $ip = getenv("REMOTE_ADDR");
                }
        }
        $long = ip2long($ip);
        $client_ip = $long ? array(
            $ip,
            $long
        ) : array(
            "0.0.0.0",
            0
        );
        return $client_ip[$type];
    }

    /**
     * 获取服务器的IP
     *
     * @access public
     * @return string
     */
    public static function server_ip()
    {
        static $serverip = null;
        
        if ($serverip !== null) {
            return $serverip;
        }
        
        if (isset($_SERVER)) {
            if (isset($_SERVER['SERVER_ADDR'])) {
                $serverip = $_SERVER['SERVER_ADDR'];
            } else {
                $serverip = '0.0.0.0';
            }
        } else {
            $serverip = getenv('SERVER_ADDR');
        }
        
        return $serverip;
    }
}

// end