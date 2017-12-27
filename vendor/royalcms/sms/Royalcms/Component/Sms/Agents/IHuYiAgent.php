<?php

namespace Royalcms\Component\Sms\Agents;

use Royalcms\Component\Support\Arr;
use Royalcms\Component\Sms\Sms;
use Royalcms\Component\Sms\Contracts\SmsAgent;
use RC_Xml;
use RC_Error;
use Royalcms\Component\Sms\SendResponse;
use Royalcms\Component\Sms\BalanceResponse;

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
     * @return SendResponse | BalanceResponse
     */
    public function send($mobile)
    {
        $url = self::HOST . self::SEND;
    
        $requestParams = array(
            'content' => $this->content,
            'mobile' => $mobile,
        );

        $requestParams = array_merge($this->authParams(), $requestParams);
 
        return $this->httpRequest(self::SEND, $url, $requestParams);
    }
    
    /**
     * 查询余额
     * 
     * @see \Royalcms\Component\Sms\Contracts\SmsAgent::balance()
     * @return SendResponse | BalanceResponse
     */
    public function balance()
    {
        $url = self::HOST . self::BALANCE;
        
        $requestParams = $this->authParams();
        
        return $this->httpRequest(self::BALANCE, $url, $requestParams);
    }
    
    /**
     * @param $type
     * @param $url
     * @param array $body
     * @return SendResponse | BalanceResponse
     */
    public function httpRequest($type, $url, array $body)
    {
        $data = [
        	'body' => $body
        ];
        
        $response = $this->sendWithRetry($url, $data, 1);

        $result = $this->transformerResponse($type, $response);
    
        return $result;
    }
    
    /**
     * 转换返回的信息处理
     * @param array $response
     * @return SendResponse | BalanceResponse
     */
    public function transformerResponse($type, $data)
    {
        if (RC_Error::is_error($data)) {
            return $data;
        }
        
        $body = $data['body'];
        $result = RC_Xml::to_array($body);
        
        if ($type == self::SEND) {
            $response = new SendResponse();
            if (isset($result['smsid'])) {
                $response->setMsgid($result['smsid'][0]);
            }
            $response->setCode(SendResponse::SUCCESS);
            $response->setDescription(SendResponse::DESCRIPTION);
        }
        else {
            $response = new BalanceResponse();
            if (isset($result['num'])) {
                $response->setBalance($result['num'][0]);
            }
            $response->setCode(BalanceResponse::SUCCESS);
            $response->setDescription(BalanceResponse::DESCRIPTION);
        }
        
        if (intval($result['code'][0]) !== 2) {
            $response->setCode($result['code'][0]);
            $response->setDescription($result['msg'][0]);
            return RC_Error::make('ihuyi_sms_send_error', $response->getDescription(), $response);
        }
        
        return $response;
    }
    
}