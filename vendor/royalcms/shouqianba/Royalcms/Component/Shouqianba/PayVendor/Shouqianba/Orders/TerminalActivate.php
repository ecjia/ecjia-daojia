<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/10/31
 * Time: 1:50 PM
 */

namespace Royalcms\Component\Shouqianba\PayVendor\Shouqianba\Orders;

use Royalcms\Component\Pay\Contracts\PayloadInterface;

class TerminalActivate implements PayloadInterface
{

    /**
     * app id，从服务商平台获取
     * @var string
     */
    protected $app_id;

    /**
     * 激活码内容
     * @var string
     */
    protected $code;

    /**
     * 设备唯一身份ID
     * @var string
     */
    protected $device_id;

    /**
     * 第三方终端号，必须保证在app id下唯一
     * @var string
     */
    protected $client_sn;

    /**
     * 终端名
     * @var string
     */
    protected $name;

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
    public function getAppId()
    {
        return $this->app_id;
    }

    /**
     * @param string $app_id
     */
    public function setAppId($app_id)
    {
        $this->app_id = $app_id;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
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
    public function getClientSn()
    {
        return $this->client_sn;
    }

    /**
     * @param string $client_sn
     */
    public function setClientSn($client_sn)
    {
        $this->client_sn = $client_sn;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
            'app_id'        => $this->getAppId(),
            'code'          => $this->getCode(),
            'device_id'     => $this->getDeviceId(),
            'client_sn'     => $this->getClientSn(),
            'name'          => $this->getName(),
            'os_info'       => $this->getOsInfo(),
            'sdk_version'   => $this->getSdkVersion(),
        ];

        $result = array_filter($result, function ($value) {
            return ($value == '' || is_null($value)) ? false : true;
        });

        return $result;
    }

}