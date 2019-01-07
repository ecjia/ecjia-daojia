<?php

namespace Ecjia\App\Ucclient\Client;

use ecjia;
use RC_Config;

class UcClient
{

    protected $config;
    
    public function __construct()
    {

        $integrate_code = ecjia::config('integrate_code');

        if ($integrate_code == 'ecjiauc') {
            $this->config = ecjia::config('integrate_config');
        }

    }

    /**
     * @return mixed
     */
    public function getUcKey()
    {
        return array_get($this->config, 'uc_key');
    }

    /**
     * @return mixed
     */
    public function getUcUrl()
    {
        return array_get($this->config, 'uc_url');
    }

    /**
     * @return mixed
     */
    public function getUcCharset()
    {
        return array_get($this->config, 'uc_charset');
    }

    /**
     * @return mixed
     */
    public function getUcId()
    {
        return array_get($this->config, 'uc_id');
    }

    /**
     * @return mixed
     */
    public function getUcIp()
    {
        return array_get($this->config, 'uc_ip');
    }


}