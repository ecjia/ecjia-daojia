<?php

namespace Royalcms\Component\Sms;

/**
 * 短信发送的响应处理类
 * @author royalwang
 *
 */
class BalanceResponse extends SmsResponse
{
    public function setBalance($balance)
    {
        $this->data = array_add($this->data, 'balance', $balance);
        return $this;
    }
    
    public function getBalance()
    {
        return array_get($this->data, 'balance', 0);
    }
    
}