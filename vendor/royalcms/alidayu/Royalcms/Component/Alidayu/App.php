<?php

namespace Royalcms\Component\Alidayu;

/**
 * 阿里大于 - APP配置信息
 */
class App
{
    /**
     * App Key
     * @var string
     */
    protected $app_key;

    /**
     * App Secret
     * @var string
     */
    protected $app_secret;

    /**
     * 是否沙箱地址
     * @var boolean
     */
    protected $sandbox = false;

    /**
     * 初始化
     * @param array $config 阿里大于配置
     */
    public function __construct($config = [])
    {
        if (array_key_exists('app_key', $config))
            $this->app_key = $config['app_key'];

        if (array_key_exists('app_secret', $config))
            $this->app_secret = $config['app_secret'];

        if (array_key_exists('sandbox', $config))
            $this->sandbox = $config['sandbox'];
    }

    /**
     * 设置app_key
     * @param string $value app_key
     */
    public function setAppKey($value)
    {
        $this->app_key = $value;

        return $this;
    }
    
    public function getAppKey()
    {
        return $this->app_key;
    }

    /**
     * 设置app_secret
     * @param string $value app_key
     */
    public function setAppSecret($value)
    {
        $this->app_secret = $value;

        return $this;
    }
    
    public function getAppSecret()
    {
        return $this->app_secret;
    }

    /**
     * 设置是否为沙箱环境
     * @param boolean $value [description]
     */
    public function setSandBox($value = false)
    {
        $this->sandbox = $value;

        return $this;
    }
    
    public function getSandBox()
    {
        return $this->sandbox;
    }
}
