<?php

namespace Ecjia\App\Mobile;

class MobileOpenTypeParamerter
{
    
    protected $code;
    
    protected $name;
    
    protected $description;
    
    
    public function __construct($code, $name, $desc = null)
    {
        $this->code = $code;
        $this->name = $name;
        $this->description = $desc;
    }
    
    
    public function getCode()
    {
        return $this->code;
    }
    
    public function getNmae()
    {
        return $this->name;
    }

    
    public function getDescription()
    {
        return $this->description;
    }
    
    
    
}