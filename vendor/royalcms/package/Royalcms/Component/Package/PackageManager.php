<?php namespace Royalcms\Component\Package;

use Closure;
use Royalcms\Component\Support\NamespacedItemResolver;
use Royalcms\Component\Package\FileLoader;

class PackageManager extends NamespacedItemResolver {
    
    /**
     * The application instance.
     *
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected $royalcms;
    
    /**
     * Create a new filesystem manager instance.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @return void
     */
    public function __construct($royalcms)
    {
        $this->royalcms = $royalcms;
    }
    
    /**
     * The array of resolved filesystem drivers.
     *
     * @var array
     */
    protected $packages = array();
    
    /**
     * Get a filesystem instance.
     *
     * @param  string  $name
     * @return 
     */
    public function package($name = null)
    {
        $name = $name ?: $this->getDefaultDriver();
    
        return $this->packages[$name] = $this->get($name);
    }
    
    /**
     * Parse a key into namespace, group, and item.
     *
     * @param  string  $key
     * @return array
     */
    public function parseKey($key)
    {
        $segments = parent::parseKey($key);
    
        if (is_null($segments[0])) $segments[0] = '*';
    
        if (isset($segments[2])) unset($segments[2]);
        
        return $segments;
    }
    
    /**
     * Attempt to get the disk from the local cache.
     *
     * @param  string  $name
     * @return \Royalcms\Component\Storage\FilesystemBase
     */
    protected function get($name)
    {
        list($namespace, $group) = $this->parseKey($name);
        
        if ($namespace == '*' && $group == 'system') 
        {
            $namespace = 'system';
        } 
        elseif ($namespace == 'app' && $group == 'system') 
        {
            $namespace = 'system';
        }
        
        return isset($this->packages[$namespace]) ? $this->packages[$namespace] : $this->resolve($namespace, $group);
    }
    
    /**
     * Resolve the given disk.
     *
     * @param  string  $name
     * @return \Royalcms\Component\Storage\FilesystemBase
     */
    protected function resolve($name, $alias)
    {
        if (isset($this->customCreators[$name]))
        {
            return $this->callCustomCreator($name);
        }
        
        return $this->{"create".ucfirst($name)."Package"}($alias);
    }
    
    /**
     * Create an instance of the local driver.
     *
     * @param  array  $config
     * @return \Royalcms\Component\Storage\Direct
     */
    public function createAppPackage($alias)
    {
        /**
         * @todo 别名判断支持，暂时注释，未考虑安装的情况下，如果获取App类文件
        if (\RC_App::has_alias($alias)) 
        {
            $path = '/'.\RC_App::app_dir_name($alias);
        }
        else 
        {
            $path = '';
            \RC_Logger::getLogger('error')->info('Not found Alias ('.$alias.').');
        }*/
        
        $path = '/'.$alias;
        
        $loader = new FileLoader($this->royalcms['files'], $this->royalcms['path.app'].$path, $this->royalcms['path.content'].'/apps'.$path);
        
        return new ApplicationPackage($loader, $alias);
    }
    
    public function createPluginPackage($alias)
    {
        return new PluginPackage($alias);
    }
    
    public function createSystemPackage($alias)
    {
        $loader = new FileLoader($this->royalcms['files'], $this->royalcms['path.system']);
        return new SystemPackage($loader, $alias);
    }
    
    public function createThemePackage($alias)
    {
        return new ThemePackage($alias);
    }
    
    /**
     * Call a custom driver creator.
     *
     * @param  array  $config
     * @return \Royalcms\Component\Storage\FilesystemBase
     */
    protected function callCustomCreator($alias)
    {
//         $driver = $this->customCreators[$config['driver']]($this->royalcms, $config);
    
//         if ($driver instanceof FilesystemBase)
//         {
//             return $this->adapt($driver);
//         }
    
//         return $driver;
    }
    
    /**
     * Get the default cache driver name.
     *
     * @return string
     */
    public function getDefaultPackage()
    {
//         return $this->royalcms['config']['cache.default'];
    }
    
    /**
     * Dynamically call the default driver instance.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array(array($this->package(), $method), $parameters);
    }
}
