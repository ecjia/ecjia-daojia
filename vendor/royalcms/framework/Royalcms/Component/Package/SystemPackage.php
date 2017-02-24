<?php namespace Royalcms\Component\Package;

class SystemPackage extends Package implements PackageInterface {

    public function __construct(LoaderInterface $loader, $alias)
    {
        parent::__construct($loader);
        
        $this->alias = $alias;
    }
    
    /**
     * 加载控制器
     * @see \Royalcms\Component\Package\PackageInterface::loadController()
     */
    public function loadController($classname, $initialize = true)
    {
        static $classes = array();
        
        $classname = str_replace(".", DIRECTORY_SEPARATOR, $classname);
        $class = basename($classname);
        
        $key = md5($classname . $initialize);
        if (isset($classes[$key]))
        {
            return $classes[$key];
        }
        
        if ($this->loader->loadController($classname))
        {
            if ($initialize)
            {
                $classes[$key] = new $class();
            }
            else
            {
                $classes[$key] = true;
            }
        
            return $classes[$key];
        }
        else
        {
            return false;
        }
    }
    
    /**
     * 加载数据模型
     * @see \Royalcms\Component\Package\PackageInterface::loadModel()
     */
    public function loadModel($classname, $initialize = true)
    {
        static $classes = array();
        
        $classname = str_replace(".", DIRECTORY_SEPARATOR, $classname);
        $class = basename($classname);
        
        $key = md5($classname . $initialize);
        if (isset($classes[$key]))
        {
            return $classes[$key];
        }
        
        if ($this->loader->loadModel($classname))
        {
            if ($initialize)
            {
                $classes[$key] = new $class();
            }
            else
            {
                $classes[$key] = true;
            }
        
            return $classes[$key];
        }
        else
        {
            return false;
        }
    }
    
    /**
     * 加载模块
     * @see \Royalcms\Component\Package\PackageInterface::loadModule()
     */
    public function loadModule($classname, $initialize = true)
    {
        static $classes = array();
        
        $classname = str_replace(".", DIRECTORY_SEPARATOR, $classname);
        $class = basename($classname);
        
        $key = md5($classname . $initialize);
        if (isset($classes[$key]))
        {
            return $classes[$key];
        }
        
        if ($this->loader->loadModule($classname))
        {
            if ($initialize)
            {
                $classes[$key] = new $class();
            }
            else
            {
                $classes[$key] = true;
            }
        
            return $classes[$key];
        }
        else
        {
            return false;
        }
    }
    
    /**
     * 加载类库
     * @see \Royalcms\Component\Package\PackageInterface::loadClass()
     */
    public function loadClass($classname, $initialize = true)
    {
        static $classes = array();
        
        $classname = str_replace(".", DIRECTORY_SEPARATOR, $classname);
        $class = basename($classname);
        
        $key = md5($classname . $initialize);
        if (isset($classes[$key])) 
        {
            return $classes[$key];
        }
        
        if ($this->loader->loadClass($classname))
        {
            if ($initialize) 
            {
                $classes[$key] = new $class();
            } 
            else 
            {
                $classes[$key] = true;
            }
            
            return $classes[$key];
        }
        else 
        {
            return false;
        }
    }
    
    /**
     * 加载API
     * @see \Royalcms\Component\Package\PackageInterface::loadApi()
     */
    public function loadApi($apiname, $initialize = true)
    {
        static $classes = array();
        
        $classname = str_replace(".", DIRECTORY_SEPARATOR, $apiname);
        $apikey = basename($classname);
        $new_classname = 'system_' . $apikey . '_api';
        $classname = str_replace($apikey, $new_classname, $classname);

        $key = md5($classname . $initialize);
        if (isset($classes[$key]))
        {
            return $classes[$key];
        }
        
        if ($this->loader->loadApi($classname))
        {
            if ($initialize)
            {
                $classes[$key] = new $new_classname();
            }
            else
            {
                $classes[$key] = true;
            }
        
            return $classes[$key];
        }
        else
        {
            return false;
        }
    }
    
    /**
     * 加载配置文件
     * @see \Royalcms\Component\Package\PackageInterface::loadConfig()
     */
    public function loadConfig($cfgname)
    {
        static $configs = array();
        
        $cfgname = str_replace(".", DIRECTORY_SEPARATOR, $cfgname);
        
        $key = md5($cfgname);
        if (isset($configs[$key]))
        {
            return $configs[$key];
        }
        
        $configs[$key] = $this->loader->loadConfig($cfgname);
        
        return $configs[$key];
    }
    
    /**
     * 加载语言文件
     * @see \Royalcms\Component\Package\PackageInterface::loadLanguage()
     */
    public function loadLanguage($langname)
    {
        static $languages = array();
        
        $langname = str_replace(".", DIRECTORY_SEPARATOR, $langname);
        
        $key = md5($langname);
        if (isset($languages[$key]))
        {
            return $languages[$key];
        }
        
        $languages[$key] = $this->loader->loadLanguage($langname);
        
        return $languages[$key];
    }
    
    /**
     * 加载函数库
     * @see \Royalcms\Component\Package\PackageInterface::loadFunction()
     */
    public function loadFunction($filename)
    {
        static $files = array();
        
        $filename = str_replace(".", DIRECTORY_SEPARATOR, $filename);
        
        $key = md5($filename);
        if (isset($files[$key]))
        {
            return $files[$key];
        }
        
        $files[$key] = $this->loader->loadFunction($filename);
        
        return $files[$key];
    }
    
    /**
     * 加载模板文件
     * @see \Royalcms\Component\Package\PackageInterface::loadTemplate()
     */
    public function loadTemplate($templatename, $returnPath = false)
    {
        static $templates = array();

        $key = md5($templatename);
        if (isset($templates[$key]))
        {
            return $templates[$key];
        }
        
        $templates[$key] = $this->loader->loadTemplate($templatename);
        
        if ($returnPath) 
        {
            return $this->loader->filePath();
        }
        else 
        {
            return $templates[$key];
        }
    }
    
}