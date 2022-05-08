<<<<<<< HEAD
<?php namespace Royalcms\Component\Package;

use Royalcms\Component\Filesystem\Filesystem;

class FileLoader implements LoaderInterface {
=======
<?php

namespace Royalcms\Component\Package;

use Royalcms\Component\Filesystem\Filesystem;
use Royalcms\Component\Package\Contracts\LoaderInterface;

class FileLoader implements LoaderInterface
{
>>>>>>> v2-test

    /**
     * The filesystem instance.
     *
     * @var \Royalcms\Component\Filesystem\Filesystem
     */
    protected $files;
<<<<<<< HEAD
    
=======

>>>>>>> v2-test
    /**
     * The file's full path.
     * @var string
     */
    protected $filePath;
<<<<<<< HEAD
    
    /**
     * The default path for the loader.
     *
     * @var string 
     */
    protected $sitePath;
    
=======

    /**
     * The default path for the loader.
     *
     * @var string
     */
    protected $sitePath;

>>>>>>> v2-test
    /**
     * The default configuration path.
     *
     * @var string
     */
    protected $defaultPath;
<<<<<<< HEAD
    
=======

>>>>>>> v2-test
    /**
     * All of the namespace hints.
     *
     * @var array
     */
    protected $hints = array();
<<<<<<< HEAD
    
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
=======

    /**
     * Create a new file loader instance.
     *
     * @param \Royalcms\Component\Filesystem\Filesystem $files
     * @param string $path
     * @return void
     */
    public function __construct(Filesystem $files, $sitePath, $defaultPath = null)
    {
        $this->sitePath = $sitePath;
        $this->files    = $files;

        if ($sitePath == $defaultPath) {
            $this->defaultPath = null;
        } else {
            $this->defaultPath = $defaultPath;
        }

        if (!$this->existsSite() && $defaultPath) {
            $this->sitePath = $defaultPath;
        }
    }

    /**
     * Load the messages for the given locale.
     *
     * @param string $locale
     * @param string $group
     * @param string $namespace
>>>>>>> v2-test
     * @return \Royalcms\Component\Package\FileLoader
     */
    public function load($group, $namespace = null)
    {
<<<<<<< HEAD
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
=======
        if (is_null($namespace) || $namespace == '*') {
            return $this->loadPath($this->sitePath, $group);
        } else {
            return $this->loadNamespaced($group, $namespace);
        }
    }

    /**
     * Load a namespaced translation group.
     *
     * @param string $locale
     * @param string $group
     * @param string $namespace
>>>>>>> v2-test
     * @return array
     */
    protected function loadNamespaced($group, $namespace)
    {
<<<<<<< HEAD
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
=======
        if (isset($this->hints[$namespace])) {
            return $this->loadPath($this->hints[$namespace], $group);
        }

        return $this;
    }


    /**
     * Load a locale from a given path.
     *
     * @param string $path
     * @param string $locale
     * @param string $group
     * @return
>>>>>>> v2-test
     */
    protected function loadPath($path, $group)
    {
        $this->filePath = "{$path}/{$group}";
<<<<<<< HEAD
        
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
=======

        return $this;
    }

    public function fileContent()
    {
        if ($this->files->exists($this->filePath)) {
            return $this->files->getRequire($this->filePath);
        }

        return false;
    }

    /**
     * Add a new namespace to the loader.
     *
     * @param string $namespace
     * @param string $hint
>>>>>>> v2-test
     * @return void
     */
    public function addNamespace($namespace, $hint)
    {
        $this->hints[$namespace] = $hint;
    }
<<<<<<< HEAD
    
    public function loadClass($class) 
=======

    public function loadClass($class)
>>>>>>> v2-test
    {
        $path = "classes/{$class}.class.php";
        return $this->load($path)->fileContent();
    }
<<<<<<< HEAD
    
=======

>>>>>>> v2-test
    public function loadModel($class)
    {
        $path = "model/{$class}.class.php";
        return $this->load($path)->fileContent();
    }
<<<<<<< HEAD
    
=======

>>>>>>> v2-test
    public function loadModule($class)
    {
        $path = "modules/{$class}.class.php";
        return $this->load($path)->fileContent();
    }
<<<<<<< HEAD
    
=======

>>>>>>> v2-test
    public function loadController($class)
    {
        $path = "{$class}.php";
        return $this->load($path)->fileContent();
    }
<<<<<<< HEAD
    
=======

>>>>>>> v2-test
    public function loadApi($class)
    {
        $path = "apis/{$class}.class.php";
        return $this->load($path)->fileContent();
    }
<<<<<<< HEAD
    
    public function loadConfig($cfgname)
    {
        $path = "configs/{$cfgname}.php";
        $content = $this->load($path)->fileContent();
        if ($content === false) {
            $path = "configs/{$cfgname}.cfg.php";
=======

    public function loadConfig($cfgname)
    {
        $path    = "configs/{$cfgname}.php";
        $content = $this->load($path)->fileContent();
        if ($content === false) {
            $path    = "configs/{$cfgname}.cfg.php";
>>>>>>> v2-test
            $content = $this->load($path)->fileContent();
        }
        return $content;
    }
<<<<<<< HEAD
    
    public function loadLanguage($langname)
    {
        $locale = royalcms('config')->get('system.locale'); 
        $path = "languages/{$locale}/{$langname}.lang.php";
        return $this->load($path)->fileContent();
    }
    
=======

    public function loadLanguage($langname)
    {
        $locale = royalcms('config')->get('system.locale');
        $path   = "languages/{$locale}/{$langname}.lang.php";
        return $this->load($path)->fileContent();
    }

>>>>>>> v2-test
    public function loadFunction($filename)
    {
        $path = "functions/{$filename}.func.php";
        return $this->load($path)->fileContent();
    }
<<<<<<< HEAD
    
=======

>>>>>>> v2-test
    public function loadTemplate($templatename)
    {
        $path = "templates/{$templatename}.php";
        return $this->load($path)->fileContent();
    }
<<<<<<< HEAD
    
=======

>>>>>>> v2-test
    public function loadTemplatePath($templatename)
    {
        $path = "templates/{$templatename}.php";
        return $this->load($path)->filePath();
    }
<<<<<<< HEAD
    
    public function existsSite()
    {
        if ($this->files->isDirectory($this->sitePath)) {
             return true;
=======

    public function existsSite()
    {
        if ($this->files->isDirectory($this->sitePath)) {
            return true;
>>>>>>> v2-test
        } else {
            return false;
        }
    }
<<<<<<< HEAD
    
=======

>>>>>>> v2-test
    public function sitePath()
    {
        return $this->sitePath;
    }
<<<<<<< HEAD
    
=======

>>>>>>> v2-test
    /**
     * return file's full path.
     * @return string
     */
    public function filePath()
    {
        return $this->filePath;
    }
<<<<<<< HEAD
    
=======

>>>>>>> v2-test
}

