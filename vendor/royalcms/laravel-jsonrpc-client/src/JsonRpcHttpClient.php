<?php

namespace Royalcms\Laravel\JsonRpcClient;

use Datto\JsonRpc\Http\Client;
use Royalcms\Laravel\JsonRpcClient\Exception\HTTPException;
use Royalcms\Laravel\JsonRpcClient\Exception\RPCException;

abstract class JsonRpcHttpClient
{
    /**
     * The service name of the target service.
     *
     * @var string
     */
    protected $serviceName = '';

    /**
     * The protocol of the target service, this protocol name
     *
     * @var string
     */
    protected $protocol = 'jsonrpc-http';

    /**
     * @param string $method
     * @param array $params
     * @param string|null $id
     * @return mixed
     * @throws \Datto\JsonRpc\Http\Exceptions\HttpException
     * @throws \ErrorException
     */
    protected function __request(string $method, array $params, string $id = null)
    {
        try {
            $headers = $this->getHeaders();
            $client  = new BasicClient($this->getUri(), $headers);
            $method = $this->filterMethod($method);
            $client->query($method, $params, $response);
            $client->send();
            //如果返回异常，会提示message和code
            if (method_exists($response, 'getMessage') && method_exists($response, 'getCode')) {
                $message = $response->getMessage();
                $code    = $response->getCode();
                throw new RPCException($message, $code);
            }
            return $response;
        } catch (\Exception $exception) {
            $message = $exception->getMessage();
            $code    = $exception->getCode() ?: -1;
            throw new HTTPException($message, $code, $exception);
        }
    }

    protected function filterMethod($method)
    {
        $service = $this->parserServiceName();
        if ($service != 'default') {
            $method = "{$service}/{$method}";
        }
        return $method;
    }

    /**
     * @return string
     */
    protected function getUri()
    {
        $services = $this->getServices();
        $nodes    = $services[strtoupper($this->serviceName)];
        $node = $this->randNode($nodes);
        return $this->nodeToUrl($node);
    }

    /**
     * 从节点池中随机取出一个节点
     * @param $nodes
     * @return mixed
     */
    private function randNode($nodes)
    {
        $max      = count($nodes);
        $r        = rand(1, $max);
        $node     = $nodes[$r - 1];
        return $node;
    }

    /**
     * 将节点配置转换为url
     * @param $node
     * @return string
     */
    private function nodeToUrl($node)
    {
        if (is_array($node)) {
            $node['path']  = isset($node['path']) ? $node['path'] : null;
            $node['query'] = isset($node['query']) ? $node['query'] : null;
            $url           = (new Node($node['host'], $node['port'], $node['path'], $node['query']))->getUrl();
        } else {
            $node = parse_url($node);
            if ($node['scheme'] == 'https' && empty($node['port'])) {
                $node['port'] = 443;
            } elseif ($node['scheme'] == 'http' && empty($node['port'])) {
                $node['port'] = 80;
            }
            $node['path']  = isset($node['path']) ? $node['path'] : null;
            $node['query'] = isset($node['query']) ? $node['query'] : null;
            $url           = (new Node($node['host'], $node['port'], $node['path'], $node['query']))->getUrl();
        }

        return $url;
    }

    /**
     * 自定义请求Header信息
     * @return string[]
     */
    protected function getHeaders()
    {
        $auth_user = config('rpc-services.auth_user');
        $auth_password = config('rpc-services.auth_password');
        return (new BasicAuthentication($auth_user, $auth_password))->getAuthorizationHeaders();
    }

    /**
     * '获取services'
     * @return array
     */
    protected function getServices(): array
    {
        $array    = config('rpc-services.services');
        $services = [];
        foreach ($array as $key => $val) {
            foreach ($val['services'] as $k => $v) {
                $serviceName            = strtoupper($v);
                $services[$serviceName] = $val['nodes'];
            }
        }
        return $services;
    }

    /**
     * @return string
     */
    private function parserServiceName(): string
    {
        $service = explode("Service", $this->serviceName)[0];
        return strtolower($service);
    }

}

