<?php

namespace Ecjia\App\Mobile;

use Ecjia\App\Mobile\Models\MobileOptionModel;
use Ecjia\App\Mobile\Models\MobileManageModel;

class ApplicationClient
{
    /**
     * 设备客户端类型
     * @var string
     */
    protected $device_client;
    
    /**
     * 设备名称
     * @var string
     */
    protected $device_name;
    
    /**
     * 客户端代号
     * @var string
     */
    protected $device_code;
    
    /**
     * 平台代号
     * @var string
     */
    protected $platform_code;
    
    
    /**
     * 平台对象
     * @var \Ecjia\App\Mobile\ApplicationPlatform
     */
    protected $platform;
    
    
    public function setDeviceClient($device_client)
    {
        $this->device_client = $device_client;
        
        return $this;
    }
    
    public function getDeviceClient()
    {
        return $this->device_client;
    }
    
    
    public function setDeviceName($device_name)
    {
        $this->device_name = $device_name;
        
        return $this;
    }
    
    
    public function getDeviceName()
    {
        return $this->device_name;
    }
    
    
    public function setDeviceCode($device_code)
    {
        $this->device_code = $device_code;
        
        return $this;
    }
    
    
    public function getDeviceCode()
    {
        return $this->device_code;
    }
    
    
    public function setPlatformCode($platform_code)
    {
        $this->platform_code = $platform_code;
        
        return $this;
    }
    
    
    public function getPlatformCode()
    {
        return $this->platform_code;
    }
    
    /**
     * 
     * @param ApplicationPlatform $platform
     * @return \Ecjia\App\Mobile\ApplicationClient
     */
    public function setPlatform(ApplicationPlatform $platform)
    {
        $this->platform = $platform;
        
        return $this;
    }
    
    /**
     * 
     * @return \Ecjia\App\Mobile\ApplicationPlatform
     */
    public function getPlatform()
    {
        return $this->platform;
    }
    
    /**
     * 获取当前客户端选项，没有就获取平台的选项
     * @param string $name
     * @return array
     */
    public function getOptions($name = null)
    {
        $model = new MobileManageModel();
        
        $data = $model->platform($this->platform_code)->app($this->device_code)->enabled()->first();
        if ($data) {
            $data = $data->options;
            $data = $this->getPlatform()->processOptionValue($data);
        }

        if (is_null($name))
        {
            return $data;
        }
        
        if (array_get($data, $name)) 
        {
            return array_get($data, $name);
        }

        $data = $this->getPlatform()->getOptions();
        if (array_get($data, $name)) {
            return array_get($data, $name);
        }
    }
    
}