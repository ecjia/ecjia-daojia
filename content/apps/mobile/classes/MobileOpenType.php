<?php

namespace Ecjia\App\Mobile;

class MobileOpenType
{
    
    protected $name;
    
    
    protected $opentype;
    
    
    protected $args = array();
    
    protected $args_filled = array();
    
    
    protected $schema = 'ecjiaopen://app?';
    
    protected $openurl;
    
    
    public function __construct($name, $opentype, array $args = array())
    {
        $this->name = $name;
        $this->opentype = $opentype;
        $this->args = $args;
        
        $this->buildEcjiaOpen();
    }
    
    
    public function getName()
    {
        return $this->name;
    }
    
    
    public function getOpenType()
    {
        return $this->opentype;
    }
    
    
    public function getArguments($code = null)
    {
        static $data = array();
        $result = array_get($data, $this->opentype);
        if (empty($result)) {
            $result = collect($this->args)->mapWithKeys(function ($item, $key) {
                if (is_array($item)) {
                    list($name, $desc) = $item;
                } else {
                    $name = $item;
                    $desc = null;
                }
                
                return [$key => with(new MobileOpenTypeParamerter($key, $name, $desc))];
            });
            $data = array_add($data, $this->opentype, $result);
        }
        
        if (is_null($code)) {
            return $result->all();
        }

        return $result->get($code);
    }
    
    public function getArgumentsFilled()
    {
        return $this->args_filled;
    }
    
    public function getOpenUrl()
    {
        return $this->openurl;
    }
    
    protected function buildEcjiaOpen()
    {
        $data = array('open_type' => $this->opentype);
        $data = array_merge($data, $this->args_filled);
     
        $this->openurl = $this->schema . http_build_query($data);
        
        return $this;
    }
    
    
    public function setQueryParams($name, $value)
    {
        if (in_array($name, array_keys($this->args))) {
            $this->args_filled[$name] = $value;
            
            $this->buildEcjiaOpen();
        }

        return $this;
    }
    
    
}