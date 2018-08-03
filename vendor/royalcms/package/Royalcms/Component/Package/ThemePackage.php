<?php namespace Royalcms\Component\Package;

class ThemePackage extends Package implements PackageInterface {

    public function __construct($alias)
    {
        $this->alias = $alias;
    }
    
    public function loadController($classname, $initialize = true)
    {
        
    }
    
    public function loadModel($classname, $initialize = true)
    {
        
    }
    
    public function loadModule($classname, $initialize = true)
    {
        
    }
    
    public function loadApi($apiname, $initialize = true)
    {
    
    }
    
    public function loadClass($classname, $initialize = true)
    {
    
    }
    
    public function loadConfig($cfgname)
    {
        
    }
    
    public function loadLanguage($langname)
    {
        
    }
    
    public function loadFunction($filename)
    {
        
    }
    
    public function loadTemplate($templatename, $returnPath = false)
    {
        
    }
    
}