<?php  namespace Royalcms\Component\Package;

interface PackageInterface {

    public function loadClass($classname, $initialize = true);
    
    public function loadController($classname, $initialize = true);
    
    public function loadModel($classname, $initialize = true);
    
    public function loadModule($classname, $initialize = true);
    
    public function loadApi($apiname, $initialize = true);
    
    public function loadConfig($cfgname);
    
    public function loadLanguage($langname);
    
    public function loadFunction($filename);
    
    public function loadTemplate($templatename, $returnPath = false);
    
}
