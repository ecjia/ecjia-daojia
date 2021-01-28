<?php

namespace Royalcms\Component\Sms;

/**
 * 短信发送的响应处理类
 * @author royalwang
 *
 */
class SmsResponse
{
    /**
     * 请求成功时的CODE
     * @var integer
     */
    const SUCCESS = '0K';
    
    /**
     * 请求成功时的DESCRIPTION
     * @var string
     */
    const DESCRIPTION = 'OK';
    
    /**
     * 消息从接口返回的原生数据
     * @var string|array
     */
    protected $raw;
    
    /**
     * 消息返回的错误状态
     * @var integer | string
     */
    protected $code;
    
    /**
     * 消息返回的错误消息
     * @var string
     */
    protected $description;
    
    /**
     * 消息返回的数据
     * @var array
     */
    protected $data = array();
    
    
    public function setRaw($raw)
    {
        $this->raw = $raw;
        return $this;
    }
    
    
    public function getRaw()
    {
        return $this->raw;
    }
    
    
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }
    
    
    public function getCode()
    {
        return $this->code;
    }
    
    
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    
    
    public function getDescription()
    {
        return $this->description;
    }
    
    
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
    
    
    public function getData()
    {
        return $this->data;
    }
    
}