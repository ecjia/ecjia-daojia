<?php

namespace Royalcms\Component\App;

use Royalcms\Component\Error\Facades\Error as RC_Error;
use JsonSerializable;

abstract class BundleAbstract implements JsonSerializable
{
    /**
     * 应用唯一标识符
     * @var string
     */
    protected $identifier;
    
    /**
     * 应用所在文件夹名
     * @var string
     */
    protected $directory;
    
    /**
     * 应用路由访问别名
     * @var string
     */
    protected $alias;
    
    /**
     * 应用所属站点名
     * @var string
     */
    protected $site;
    
    
    protected $package;
    
    
    protected $namespace;

    protected $provider;

    
    protected $controllerPath;
    
    
    /**
     * 获取应用唯一标识符
     * @return string
     */
    public function getIdentifier() 
    {
        return $this->identifier;
    }
    
    /**
     * 获取应用所在文件夹名
     * @return string
     */
    public function getDirectory() 
    {
        return $this->directory;
    }
    
    /**
     * 获取应用所属站点名
     * @return string
     */
    public function getAlias() 
    {
        return $this->alias;
    }
    
    
    public function getNameSpace()
    {
        return $this->namespace;
    }


    public function getProvider()
    {
        return $this->provider;
    }
    
    
    /**
     * 获取应用的控制器路径位置
     * @return string
     */
    public function getControllerPath()
    {
        return $this->controllerPath;
    }
    
    
    public function getControllerClassName($controller)
    {
        if ( ! royalcms('app')->hasAlias($this->alias) ) {
            return RC_Error::make('not_register_route_app', '没有注册此路由名称');
        }
        
        $controller_classname = $this->namespace . '\Controllers\\' . $this->normalizeName($controller) . 'Controller';
        if (class_exists($controller_classname)) {
            return $controller_classname;
        }
        
        $app_controller = $this->controllerPath . $controller . '.php';
        if ( ! file_exists($app_controller) ) {
            return RC_Error::make('controller_does_not_exist', "Controller {$app_controller} does not exist.");
        }
        
        include_once $app_controller;
        
        $controller_classname = $controller;
        
        $my_controller = $this->controllerPath . 'MY_' . $controller . '.php';
        if ( file_exists($my_controller) ) {
            $controller_classname = 'MY_' . $controller;

            include_once $my_controller;
        }
        
        return $controller_classname;
    }
    
    
    /**
     * 获取应用包信息
     *
     * @param string $id
     * @return bool | array
     */
    protected function appPackage($markup = true, $translate = true)
    {
        $package = $this->getPackageData();
        
        if ( $package && $translate ) {
//            $lang_namespace = $this->getNamespace() . '::package.';
//            $package['format_name'] = RC_Lang::get($lang_namespace . $package['name']);
//            $package['format_description'] = RC_Lang::get($lang_namespace . $package['description']);
//            if (empty($package['format_name'])) {
//
//            }
//            if (empty($package['format_description'])) {
//
//            }

            $package['format_name'] = __($package['name'], $this->getContainerName());
            $package['format_description'] = __($package['description'], $this->getContainerName());

        } else {

            $package['format_name'] = $package['name'];
            $package['format_description'] = $package['description'];
        }
        
        return $package;
    }
    
    
    public function getPackage($key = null)
    {
        if (is_null($key)) {
            return $this->package;
        }
        return array_get($this->package, $key);
    }
    
    
    /**
     * 获取app/configs/package.php配置信息
     *
     * @return NULL | array
     */
    public function getPackageData()
    {
        return config($this->getContainerName().'::'.'package');
    }

    /**
     * Get installer class instance
     * @return \Royalcms\Component\Error\Error
     */
    public function getInstaller()
    {
        $namespace_class = $this->getNamespaceClassName('Installer');

        if (class_exists($namespace_class)) {
            return new $namespace_class;
        }

        $install_class = $this->directory . '_installer';

        if (class_exists($install_class)) {
            return new $install_class;
        }

        return RC_Error::make('class_not_found', sprintf(__("Class '%s' not found"), $install_class));
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray()
    {
        return [
            'identifier' => $this->identifier,
            'directory' => $this->directory,
            'alias' => $this->alias,
            'site' => $this->site,
            'package' => $this->package,
            'namespace' => $this->namespace,
            'provider' => $this->provider,
            'controllerPath' => $this->controllerPath,
        ];
    }
    
    protected function normalizeName($name)
    {
        // convert foo-bar to FooBar
        $name = implode('', array_map('ucfirst', explode('-', $name)));
        
        // convert foo_bar to FooBar
        $name = implode('', array_map('ucfirst', explode('_', $name)));
        
        // convert foot/bar to Foo\Bar
        $name = implode('\\', array_map('ucfirst', explode('/', $name)));
        
        return $name;
    }

    /**
     * 获取命名空间的完整类名
     * @param $class
     * @return string
     */
    protected function getNamespaceClassName($class)
    {
        return $this->getNameSpace() . '\\' . $class;
    }


    /**
     * Get application provider container name
     * @return string
     */
    abstract public function getContainerName();


}

// end