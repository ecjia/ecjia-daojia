<?php

namespace Royalcms\Component\Sms;

/**
 * 短信发送的响应处理类
 * @author royalwang
 *
 */
class SendResponse extends SmsResponse
{
    
    public function setMsgid($msgid)
    {
        $this->data = array_add($this->data, 'msgid', $msgid);
        return $this;
    }
    
    public function getMsgid()
    {
        return array_get($this->data, 'msgid', 0);
    }
    
}