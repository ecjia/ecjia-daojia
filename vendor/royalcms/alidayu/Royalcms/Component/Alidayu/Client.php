<?php

namespace Royalcms\Component\Alidayu;

use Exception;
use Royalcms\Component\Alidayu\Contracts\RequestCommand;

/**
 * 阿里大于客户端
 */
class Client
{   
    /**
     * API请求地址
     * @var string
     */
    protected $api_uri = 'http://gw.api.taobao.com/router/rest';

    /**
     * 沙箱请求地址
     * @var string
     */
    protected $api_sandbox_uri = 'http://gw.api.tbsandbox.com/router/rest'; 

    /**
     * 应用
     * @var \Royalcms\Component\Alidayu\App
     */
    protected $app;

    /**
     * 签名规则
     * @var string
     */
    protected $sign_method = 'md5';

    /**
     * 响应格式。可选值：xml，json。
     * @var string
     */
    protected $format = 'json';

    /**
     * 初始化
     * @param array $config 阿里大于配置App类
     */
    public function __construct(App $app)
    {
        $this->app = $app;

        // 判断配置
        if (!$this->app->getAppKey() || !$this->app->getAppSecret()) {
            throw new Exception("Aidayu configuration information: app_key or app_secret error");
        }
    }

    /**
     * 发起请求数据
     * @param  \Royalcms\Component\Alidayu\Contracts\RequestCommand $request 请求类
     * @return false|object
     */
    public function execute(RequestCommand $request)
    {
        $method        = $request->getMethod();
        $publicParams  = $this->getPublicParams();
        $serviceParams = $request->getParams();

        $params = array_merge(
            $publicParams,
            [
                'method' => $method
            ],
            $serviceParams
        );

        // 签名
        $params['sign'] = $this->generateSign($params);

        // 请求数据
        $resp = $this->curl(
            $this->app->getSandBox() ? $this->api_sandbox_uri : $this->api_uri,
            $params
        );

        // 解析返回
        return $this->parseRep($resp);
    }

    /**
     * 设置签名方式
     * @param string $value 签名方式，支持md5, hmac
     */
    public function setSignMethod($value = 'md5')
    {
        $this->sign_method = $value;

        return $this;
    }

    /**
     * 设置回传格式
     * @param string $value 响应格式，支持json/xml
     */
    public function setFormat($value = 'json')
    {
        $this->format = $value;

        return $this;
    }

    /**
     * 解析返回数据
     * @return array|false
     */
    protected function parseRep($response)
    {
        if ($this->format == 'json') {
            $resp = json_decode($response, true);

            if (false !== $resp) {
                $resp = current($resp);
            }
        }

        elseif ($this->format == 'xml') {
            $resp = @simplexml_load_string($response);
        }

        else {
            throw new Exception("format error...");
        }

        return $resp;
    }

    /**
     * 返回公共参数
     * @return array 
     */
    protected function getPublicParams()
    {
        return [
            'app_key'     => $this->app->getAppKey(),
            'timestamp'   => date('Y-m-d H:i:s'),
            'format'      => $this->format,
            'v'           => '2.0',
            'sign_method' => $this->sign_method
        ];
    }

    /**
     * 生成签名
     * @param  array  $params 待签参数
     * @return string         
     */
    protected function generateSign($params = [])
    {
        if ($this->sign_method == 'md5') {
            return $this->generateMd5Sign($params);
        } elseif ($this->sign_method == 'hmac') {
            return $this->generateHmacSign($params);
        } else {
            throw new Exception("sign_method error...");
        }
    }

    /**
     * 按Md5方式生成签名
     * @param  array  $params 待签的参数
     * @return string         
     */
    protected function generateMd5Sign($params = [])
    {
        static::sortParams($params);  // 排序

        $arr = [];
        foreach ($params as $k => $v) {
            $arr[] = $k . $v;
        }
        
        $str = $this->app->getAppSecret() . implode('', $arr) . $this->app->getAppSecret();

        return strtoupper(md5($str));
    }

    /**
     * 按hmac方式生成签名
     * @param  array  $params 待签的参数
     * @return string         
     */
    protected function generateHmacSign($params = [])
    {
        static::sortParams($params);  // 排序

        $arr = [];
        foreach ($params as $k => $v) {
            $arr[] = $k . $v;
        }
        
        $str = implode('', $arr);

        return strtoupper(hash_hmac('md5', $str, $this->app->getAppSecret()));
    }

    /**
     * 待签名参数排序
     * @param  array  &$params 参数
     * @return array         
     */
    protected static function sortParams(&$params = [])
    {
        ksort($params);
    }


    /**
     * curl请求
     * @param  string $url        string
     * @param  array|null $postFields 请求参数
     * @return [type]             [description]
     */
    protected function curl($url, $postFields = null)
    { 
        $data = [
            'body' => $postFields
        ];
        
        $response = \RC_Http::remote_post($url, $data);

        return $response['body'];
    }
}
