<?php namespace Royalcms\Component\IpAddress;

/**
 * @file
 *
 * qqwry.dat from internat
 */
class IpAddress
{

    /**
     * 指针
     *
     * @var resource
     */
    private $fp;

    /**
     * 第一条IP记录的偏移地址
     *
     * @var int
     */
    private $firstip;

    /**
     * 最后一条IP记录的偏移地址
     *
     * @var int
     */
    private $lastip;

    /**
     * IP记录的总条数
     *
     * @var int
     */
    private $totalip = 0;

    /**
     * 析构函数
     */
    public function __construct($filename = '')
    {
        if (! $filename) {
            $filename = dirname(__FILE__) . DS . 'ipdata' . DS . 'qqwry.dat';
        }
        if (FALSE !== $this->fp = fopen($filename, 'rb')) {
            $this->firstip = $this->getLong();
            $this->lastip = $this->getLong();
            $this->totalip = ($this->lastip - $this->firstip) / 7;
        }
    }

    /**
     * little-endian编码的4个字节转化为长整型
     */
    public function getLong()
    {
        $result = unpack('Vlong', fread($this->fp, 4));
        return $result['long'];
    }

    /**
     * little-endian编码的3个字节转化为长整型
     */
    public function getLong3()
    {
        $result = unpack('Vlong', fread($this->fp, 3) . chr(0));
        return $result['long'];
    }

    /**
     * 将IP转化为长整型,再压缩成big-endian编码的字符串
     */
    public function packIp($ip)
    {
        return pack('N', intval(ip2long($ip)));
    }

    /**
     * 返回读取的字符串
     */
    public function getString($data = "")
    {
        $char = fread($this->fp, 1);
        while (ord($char) > 0) {
            $data .= $char;
            $char = fread($this->fp, 1);
        }
        
        return mb_convert_encoding($data, 'UTF-8', 'GB2312');
    }

    /**
     * 返回地区信息
     */
    public function getArea()
    {
        // 标志字节
        $byte = fread($this->fp, 1);
        switch (ord($byte)) {
            // 没有区域信息
            case 0:
                $area = '';
                break;
            // 标志字节为1或2，表示区域信息被重定向
            case 1:
            case 2:
                fseek($this->fp, $this->getLong3());
                $area = $this->getString();
                break;
            // 默认表示区域信息没有被重定向
            default:
                $area = $this->getString($byte);
                break;
        }
        
        return $area;
    }

    /**
     * 根据所给 IP 地址或域名返回所在地区信息
     *
     * @access public
     * @param string $ip            
     * @return array
     */
    function getLocation($ip)
    {
        // 如果数据文件没有被正确打开，则直接返回空
        if (! $this->fp) {
            return NULL;
        }
        // 将输入的域名转化为IP地址
        $location['ip'] = gethostbyname($ip);
        // 将输入的IP地址转化为可比较的IP地址
        $ip = $this->packIp($location['ip']);
        // 不合法的IP地址会被转化为255.255.255.255
        // 二分搜索
        $l = 0; // 搜索的下边界
        $u = $this->totalip; // 搜索的上边界
        $findip = $this->lastip; // 如果没有找到就返回最后一条IP记录
        while ($l <= $u) { // 当上边界小于下边界时，查找失败
            $i = floor(($l + $u) / 2); // 计算近似中间记录
            fseek($this->fp, $this->firstip + $i * 7);
            $beginip = strrev(fread($this->fp, 4)); // 获取中间记录的开始IP地址
                                                          // strrev函数在这里的作用是将little-endian的压缩IP地址转化为big-endian的格式
                                                          // 以便用于比较，后面相同。
            if ($ip < $beginip) { // 用户的IP小于中间记录的开始IP地址时
                $u = $i - 1; // 将搜索的上边界修改为中间记录减一
            } else {
                fseek($this->fp, $this->getLong3());
                $endip = strrev(fread($this->fp, 4)); // 获取中间记录的结束IP地址
                if ($ip > $endip) { // 用户的IP大于中间记录的结束IP地址时
                    $l = $i + 1; // 将搜索的下边界修改为中间记录加一
                } else { // 用户的IP在中间记录的IP范围内时
                    $findip = $this->firstip + $i * 7;
                    break; // 则表示找到结果，退出循环
                }
            }
        }
        
        // 获取查找到的IP地理位置信息
        fseek($this->fp, $findip);
        $location['beginip'] = long2ip($this->getLong()); // 用户IP所在范围的开始地址
        $offset = $this->getlong3();
        fseek($this->fp, $offset);
        $location['endip'] = long2ip($this->getLong()); // 用户IP所在范围的结束地址
                                                             // 标志字节
        $byte = fread($this->fp, 1);
        switch (ord($byte)) {
            // 1 表示国家和区域信息都被同时重定向
            case 1:
                $countryOffset = $this->getLong3(); // 重定向地址
                fseek($this->fp, $countryOffset);
                $byte = fread($this->fp, 1); // 标志字节
                switch (ord($byte)) {
                    case 2: // 标志字节为2，表示国家信息又被重定向
                        fseek($this->fp, $this->getLong3());
                        $location['country'] = $this->getString();
                        fseek($this->fp, $countryOffset + 4);
                        $location['area'] = $this->getArea();
                        break;
                    default: // 否则，表示国家信息没有被重定向
                        $location['country'] = $this->getString($byte);
                        $location['area'] = $this->getArea();
                        break;
                }
                break;
            // 2 表示国家信息被重定向
            case 2:
                fseek($this->fp, $this->getLong3());
                $location['country'] = $this->getString();
                fseek($this->fp, $offset + 8);
                $location['area'] = $this->getArea();
                break;
            // 默认表示国家信息没有被重定向
            default:
                $location['country'] = $this->getString($byte);
                $location['area'] = $this->getArea();
                break;
        }
        if ($location['country'] == ' CZ88.NET') {
            $location['country'] = '未知';
        }
        if ($location['area'] == ' CZ88.NET') {
            $location['area'] = '';
        }
        
        return $location;
    }

    /**
     * 析构函数
     */
    function __destruct()
    {
        $this->fp && fclose($this->fp);
    }
}

// end