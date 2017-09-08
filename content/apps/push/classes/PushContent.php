<?php

namespace Ecjia\App\Push;

class PushContent
{
    /**
     * 模板标题
     * @var string
     */
    protected $subject;
    
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
        
        return $this;
    }
    
    public function setSubject($subject)
    {
        $this->subject = $subject;
        
        return $this;
    }
    
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = is_string(trim($content)) ? $content : '';
        
        return $this;
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
        
        return $this;
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
        
        return $this;
    }

    /**
     * @return string
     */
    public function getTemplateId()
    {
        return $this->templateId;
    }

}
