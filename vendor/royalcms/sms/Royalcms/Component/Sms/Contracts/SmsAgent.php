<?php

namespace Royalcms\Component\Sms\Contracts;

use Royalcms\Component\Sms\SendResponse;

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
     * @return SendResponse | \ecjia_error
     */
    public function send($mobile);
    
    
    /**
     * 查询账户余额
     */
    public function balance();
    

}
