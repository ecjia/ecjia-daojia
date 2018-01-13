<?php namespace Royalcms\Component\Package;

use Royalcms\Component\Filesystem\Filesystem;

class FileLoader implements LoaderInterface {

    /**
     * The filesystem instance.
     *
     * @var \Royalcms\Component\Filesystem\Filesystem
     */
    protected $files;
    
    /**
     * The file's full path.
     * @var string
     */
    protected $filePath;
    
    /**
     * The default path for the loader.
     *
     * @var string 
     */
    protected $sitePath;
    
    /**
     * The default configuration path.
     *
     * @var string
     */
    protected $defaultPath;
    
    /**
     * All of the namespace hints.
     *
     * @var array
     */
    protected $hints = array();
    
    /**
     * Create a new file loader instance.
     *
     * @param  \Royalcms\Component\Filesystem\Filesystem  $files
     * @param  string  $path
     * @return void
    */
    public function __construct(Filesystem $files, $sitePath, $defaultPath = null)
    {
        $this->sitePath = $sitePath;
        $this->files = $files;
        
        if ($sitePath == $defaultPath)
        {
            $this->defaultPath = null;
        }
        else
        {
            $this->defaultPath = $defaultPath;
        }
        
        if (! $this->existsSite() && $defaultPath)
        {
            $this->sitePath = $defaultPath;
        }
    }
    
    /**
     * Load the messages for the given locale.
     *
     * @param  string  $locale
     * @param  string  $group
     * @param  string  $namespace
     * @return \Royalcms\Component\Package\FileLoader
     */
    public function load($group, $namespace = null)
    {
        if (is_null($namespace) || $namespace == '*')
        {
            return $this->loadPath($this->sitePath, $group);
        }
        else
        {
            return $this->loadNamespaced($group, $namespace);
        }
    }
    
    /**
     * Load a namespaced translation group.
     *
     * @param  string  $locale
     * @param  string  $group
     * @param  string  $namespace
     * @return array
     */
    protected function loadNamespaced($group, $namespace)
    {
        if (isset($this->hints[$namespace]))
        {
            return $this->loadPath($this->hints[$namespace], $group);
        }
    
        return $this;
    }
    
    
    /**
     * Load a locale from a given path.
     *
     * @param  string  $path
     * @param  string  $locale
     * @param  string  $group
     * @return array
     */
    protected function loadPath($path, $group)
    {
        $this->filePath = "{$path}/{$group}";
        
        return $this;
    }
    
    public function fileContent()
    {
        if ($this->files->exists($this->filePath))
        {
            return $this->files->getRequire($this->filePath);
        }
        
        return false;
    }
    
    /**
     * Add a new namespace to the loader.
     *
     * @param  string  $namespace
     * @param  string  $hint
     * @return void
     */
    public function addNamespace($namespace, $hint)
    {
        $this->hints[$namespace] = $hint;
    }
    
    public function loadClass($class) 
    {
        $path = "classes/{$class}.class.php";
        return $this->load($path)->fileContent();
    }
    
    public function loadModel($class)
    {
        $path = "model/{$class}.class.php";
        return $this->load($path)->fileContent();
    }
    
    public function loadModule($class)
    {
        $path = "modules/{$class}.class.php";
        return $this->load($path)->fileContent();
    }
    
    public function loadController($class)
    {
        $path = "{$class}.php";
        return $this->load($path)->fileContent();
    }
    
    public function loadApi($class)
    {
        $path = "apis/{$class}.class.php";
        return $this->load($path)->fileContent();
    }
    
    public function loadConfig($cfgname)
    {
        $path = "configs/{$cfgname}.php";
        $content = $this->load($path)->fileContent();
        if ($content === false) {
            $path = "configs/{$cfgname}.cfg.php";
            $content = $this->load($path)->fileContent();
        }
        return $content;
    }
    
    public function loadLanguage($langname)
    {
        $locale = royalcms('config')->get('system.locale'); 
        $path = "languages/{$locale}/{$langname}.lang.php";
        return $this->load($path)->fileContent();
    }
    
    public function loadFunction($filename)
    {
        $path = "functions/{$filename}.func.php";
        return $this->load($path)->fileContent();
    }
    
    public function loadTemplate($templatename)
    {
        $path = "templates/{$templatename}.php";
        return $this->load($path)->fileContent();
    }
    
    public function loadTemplatePath($templatename)
    {
        $path = "templates/{$templatename}.php";
        return $this->load($path)->filePath();
    }
    
    public function existsSite()
    {
        if ($this->files->isDirectory($this->sitePath)) {
             return true;
        } else {
            return false;
        }
    }
    
    public function sitePath()
    {
        return $this->sitePath;
    }
    
    /**
     * return file's full path.
     * @return string
     */
    public function filePath()
    {
        return $this->filePath;
    }
    
}

