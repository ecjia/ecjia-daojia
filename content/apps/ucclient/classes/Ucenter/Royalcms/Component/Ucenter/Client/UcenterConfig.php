<?php

namespace Royalcms\Component\Ucenter\Client;


class UcenterConfig
{
    
    protected $config;
    
    public function __construct()
    {
        $this->config = config('ucenter::ucenter');
    }

    /**
     * @return mixed
     */
    public function UC_CONNECT()
    {
        return $this->config['connect'];
    }

    /**
     * @return mixed
     */
    public function UC_KEY()
    {
        return trim($this->config['key']);
    }

    /**
     * @return mixed
     */
    public function UC_URL()
    {
        return $this->config['url'];
    }

    /**
     * @return mixed
     */
    public function UC_API()
    {
        return rtrim($this->config['api'], '/');
    }

    /**
     * @return mixed
     */
    public function UC_CHARSET()
    {
        return $this->config['charset'];
    }

    /**
     * @return mixed
     */
    public function UC_IP()
    {
        return $this->config['ip'];
    }

    /**
     * @return mixed
     */
    public function UC_APPID()
    {
        return $this->config['appid'];
    }

    /**
     * @return mixed
     */
    public function UC_PPP()
    {
        return $this->config['ppp'];
    }

    public function setUcConnect($connect)
    {
        $this->config['connect'] = $connect;

        return $this;
    }

    public function setUcKey($key)
    {
        $this->config['key'] = $key;

        return $this;
    }

    public function setUcUrl($url)
    {
        $this->config['url'] = $url;

        return $this;
    }

    public function setUcApi($api)
    {
        $this->config['api'] = $api;

        return $this;
    }

    public function setUcCharset($charset)
    {
        $this->config['charset'] = $charset;

        return $this;
    }

    public function setUcIp($ip)
    {
        $this->config['ip'] = $ip;

        return $this;
    }

    public function setUcAppid($appid)
    {
        $this->config['appid'] = $appid;

        return $this;
    }

}

// end