<?php

namespace Royalcms\Component\Sms\Contracts;

interface SmsAgent
{
    /**
     * @return void
     */
    public function transformConfig();
    

    /**
     * 发送信息
     * 
     * @param string $mobile
     * @return mixed
     */
    public function send($mobile);
    
    
    /**
     * 查询账户余额
     */
    public function balance();
    

    /**
     * 转换返回的信息处理
     * @param array $response
     * @return array $result
     * @return int $result[].code 返回0则成功，返回其它则错误
     * @return string $result[].msg 返回消息
     * @return string $result[].raw 接口返回的原生信息
     * @return array $result[].data 数据信息
     */
    public function transformerResponse($reponse);

}
