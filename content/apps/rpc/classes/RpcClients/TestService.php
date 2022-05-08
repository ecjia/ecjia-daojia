<?php

namespace Ecjia\App\Rpc\RpcClients;


use Ecjia\App\Rpc\JsonRpcHttpClient\JsonRpcHttpClient;

class TestService extends JsonRpcHttpClient
{
    /**
     * The service name of the target service.
     *
     * @var string
     */
    protected $serviceName = 'TestService';

    /**
     * 实现一个test/connect方法，正确返回OK
     * @return string
     */
    public function connect()
    {
        return $this->__request(__FUNCTION__, []);
    }

}