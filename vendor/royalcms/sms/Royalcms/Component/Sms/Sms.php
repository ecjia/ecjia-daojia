<?php

namespace Royalcms\Component\Sms;

use RC_Http;
use RC_Error;

class Sms
{
    /**
     * 模板签名
     * @var string
     */
    protected $signName;
    
    /**
     * 模板内容
     * @var string
     */
    protected $content;
    
    /**
     * 厂商模板ID
     * @var string
     */
    protected $templateId;
    
    /**
     * 厂商模板变量，数组格式
     * @var array
     */
    protected $templateVar = [];
    

    /**
     * @param array $templateVar
     */
    public function setContentByCustomVar(array $templateVar = [])
    {
        foreach ($templateVar as $key => $value) {
            $this->content = str_replace('${' . $key . '}', $value, $this->content);
        } 
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = is_string(trim($content)) ? $content : '';
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param array $templateVar
     * @param bool $hasKey
     */
    public function setTemplateVar(array $templateVar = [], $hasKey = true)
    {        
        foreach ($templateVar as $key => $value) 
        {
            if ($hasKey) 
            {
                $this->templateVar[$key] = "$value";
            } 
            else 
            {
                $this->templateVar[] = "'" . $value . "'";
            }
        }
    }

    /**
     * @return string
     */
    public function getTemplateVar()
    {
        return $this->templateVar;
    }

    /**
     * @param mixed $id
     */
    public function setTemplateId($id = null)
    {
        $this->templateId = $id ?: 1;
    }

    /**
     * @return string
     */
    public function getTemplateId()
    {
        return $this->templateId;
    }
    
    /**
     * @param string $signName
     */
    public function setSignName($signName = null)
    {
        $this->signName = trim($signName) ?: trim(config('sms::sms.signName'), '{}');
    }
    
    /**
     * @return string
     */
    public function getSignName()
    {
        return $this->signName;
    }
    
    protected function sendWithRetry($url, array $data, $retry_count = 3)
    {
        $retry = 0;
    
        do {

            $response = RC_Http::remote_post($url, $data);
    
            $retry++;
    
        } while (RC_Error::is_error($response) && $retry < $retry_count);
    
        return $response;
    }

}
