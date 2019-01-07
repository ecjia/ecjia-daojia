<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/10/31
 * Time: 1:50 PM
 */

namespace Royalcms\Component\Shouqianba\PayVendor\Shouqianba\Orders;

use Royalcms\Component\Pay\Contracts\PayloadInterface;

class TerminalCheckin implements PayloadInterface
{

    /**
     * 第三方终端号，必须保证在app id下唯一
     * @var string
     */
    protected $terminal_sn;

    /**
     * 设备唯一身份ID
     * @var string
     */
    protected $device_id;

    /**
     * 当前系统信息，如: Android5.0
     * @var string
     */
    protected $os_info;

    /**
     * SDK版本
     * @var string
     */
    protected $sdk_version;

    /**
     * @return string
     */
    public function getTerminalSn()
    {
        return $this->terminal_sn;
    }

    /**
     * @param string $terminal_sn
     */
    public function setTerminalSn($terminal_sn)
    {
        $this->terminal_sn = $terminal_sn;
    }

    /**
     * @return string
     */
    public function getDeviceId()
    {
        return $this->device_id;
    }

    /**
     * @param string $device_id
     */
    public function setDeviceId($device_id)
    {
        $this->device_id = $device_id;
    }

    /**
     * @return string
     */
    public function getOsInfo()
    {
        return $this->os_info;
    }

    /**
     * @param string $os_info
     */
    public function setOsInfo($os_info)
    {
        $this->os_info = $os_info;
    }

    /**
     * @return string
     */
    public function getSdkVersion()
    {
        return $this->sdk_version;
    }

    /**
     * @param string $sdk_version
     */
    public function setSdkVersion($sdk_version)
    {
        $this->sdk_version = $sdk_version;
    }


    /**
     * 对象转换成数组输出
     *
     * @return array
     */
    public function toArray()
    {
        $result = [
            'terminal_sn'   => $this->getTerminalSn(),
            'device_id'     => $this->getDeviceId(),
            'os_info'       => $this->getOsInfo(),
            'sdk_version'   => $this->getSdkVersion(),
        ];

        $result = array_filter($result, function ($value) {
            return ($value == '' || is_null($value)) ? false : true;
        });

        return $result;
    }

}