<?php

namespace Royalcms\Component\Sms\Agents;

use Royalcms\Component\Support\Arr;
use Royalcms\Component\Sms\Sms;
use Royalcms\Component\Sms\Contracts\SmsAgent;
use RC_Xml;
use ErrorException;

class IHuYiAgent extends Sms implements SmsAgent
{
    
    const HOST      = 'http://106.ihuyi.com/webservice/sms.php?';
    const SEND      = 'method=Submit';
    const BALANCE   = 'method=GetNum';
    const PASSWORD  = 'method=ChangePassword';
    
    private $appKey;
    private $appSecret;
    
    public function __construct($config)
    {
        $this->config = $config;
        $this->transformConfig();
    }
    
    public function transformConfig()
    {
        $credentials = Arr::pull($this->config, 'credentials');
        $this->appKey = Arr::pull($credentials, 'appKey');
        $this->appSecret = Arr::pull($credentials, 'appSecret');
    }
    
    protected function authParams()
    {
        return [
            'account'   => $this->appKey,
            'password'  => $this->appSecret,
        ];
    }
    
    /**
     * 发送信息
     * 
     * @see \Royalcms\Component\Sms\Contracts\SmsAgent::send()
     */
    public function send($mobile)
    {
        $url = self::HOST . self::SEND;
    
        $requestParams = array(
            'content' => $this->content,
            'mobile' => $mobile,
        );

        $requestParams = array_merge($this->authParams(), $requestParams);
 
        return $this->httpRequest($url, $requestParams);
    }
    
    public function balance()
    {
        $url = self::HOST . self::BALANCE;
        
        $requestParams = $this->authParams();
        
        return $this->httpRequest($url, $requestParams);
    }
    
    /**
     * @param $url
     * @param array $body
     * @return array $result
     * @return int $result[].code 返回0则成功，返回其它则错误
     * @return string $result[].msg 返回消息
     * @return string $result[].raw 接口返回的原生信息
     * @return array $result[].data 数据信息
     */
    public function httpRequest($url, array $body)
    {
        $data = [
        	'body' => $body
        ];
        
        $response = $this->sendWithRetry($url, $data);

        $result = $this->transformerResponse($response);
    
        return $result;
    }
    
    /**
     * 转换返回的信息处理
     * @param array $response
     * @return array $result
     * @return int $result[].code 返回0则成功，返回其它则错误
     * @return string $result[].msg 返回消息
     * @return string $result[].raw 接口返回的原生信息
     * @return array $result[].data 数据信息
     */
    public function transformerResponse($response)
    {
        $body = $response['body'];
        $result_arr = RC_Xml::to_array($body);

        $data = array();
        
        if (isset($result_arr['smsid'])) {
            $data['smsid'] = $result_arr['smsid'][0];
        }
        
        if (isset($result_arr['num'])) {
            $data['num']   = $result_arr['num'][0];
        }
         
        $result = [
        	'raw' => $body,
            'data' => $data,
            'code' => $result_arr['code'][0],
            'description' => $result_arr['msg'][0],
        ];
        
        if ($result['code'] != '2') {
            throw new ErrorException($result['description'], 'ihuyi_error_'.$result['code']);
        }
        
        return $result;
    }
    
}