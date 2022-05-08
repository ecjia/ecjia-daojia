<?php
require_once "../vendor/autoload.php";

use Royalcms\Laravel\JsonRpcClient\JsonRpcHttpClient;

class a extends JsonRpcHttpClient {
    /**
     * The service name of the target service.
     *
     * @var string
     */
    protected $serviceName = 'ProductService';

    /**
     * The protocol of the target service, this protocol name
     *
     * @var string
     */
    protected $protocol = 'jsonrpc-http';


    // 实现一个加法方法，这里简单的认为参数都是 int 类型
    public function list($where,$select,$page,$perPage)
    {
        return $this->__request(__FUNCTION__,compact('where','select','page','perPage'));
    }

}

$a = new a();

$resp = $a->list(" id > 10001 and status > 0 ",['id'],1,10);

var_dump($resp);die;