<?php

use Royalcms\Component\Support\Arr;
use Royalcms\Component\Sms\Sms;
use Royalcms\Component\Sms\Contracts\SmsAgent;
use Royalcms\Component\Sms\SendResponse;
use Royalcms\Component\Sms\BalanceResponse;

class EcjiaSmsAgent extends Sms implements SmsAgent
{
    
    const SEND      = 'sms/send';
    const BALANCE   = 'sms/balance';
    
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
            'app_key'   => $this->appKey,
            'app_secret'  => $this->appSecret,
        ];
    }
    
    /**
     * 发送信息
     * 
     * @see \Royalcms\Component\Sms\Contracts\SmsAgent::send()
     * 
     * @return SendResponse | \ecjia_error
     */
    public function send($mobile)
    {
        $requestParams = array(
            'content' => $this->content,
            'mobile' => $mobile,
        );

        $requestParams = array_merge($this->authParams(), $requestParams);

        $cloud = ecjia_cloud::instance()->api(self::SEND)->data($requestParams)->run();

        $result = $this->transformerResponse($cloud);

        return $result;
    }
    
    /**
     * 查询账户余额
     * @return BalanceResponse | \ecjia_error
     */
    public function balance()
    {
        $requestParams = $this->authParams();
        
        $cloud = ecjia_cloud::instance()->api(self::BALANCE)->data($requestParams)->run();

        if (is_ecjia_error($cloud->getError())) {
            return $cloud->getError();
        }
        
        $result = $cloud->getReturnData();
        
        $response = new BalanceResponse();
        $response->setCode(SendResponse::SUCCESS);
        $response->setDescription(SendResponse::DESCRIPTION);
        $response->setRaw(array_get($cloud->getResponse(), 'body'));
        $response->setBalance($result['balance']);
        
        return $response;
    }
    
    /**
     * 转换返回的信息处理
     * @param ecjia_cloud $cloud
     * @return SendResponse | \ecjia_error
     */
    public function transformerResponse($cloud)
    {
        $response = new SendResponse();
        
        if (is_ecjia_error($cloud->getError())) {
            $response->setCode($cloud->getError()->get_error_code());
            $response->setDescription($cloud->getError()->get_error_message());
            $response->setMsgid(0);
        }
        else {
            $response->setCode(SendResponse::SUCCESS);
            $response->setDescription(SendResponse::DESCRIPTION);
            $response->setRaw(array_get($cloud->getResponse(), 'body'));
            $response->setMsgid(array_get($cloud->getReturnData(), 'msgid'));
        }
        
        if ($response->getCode() !== SendResponse::SUCCESS) {
            return new ecjia_error('ecjia_sms_send_error', $response->getDescription(), $response);
        }
        
        return $response;
    }
    
}