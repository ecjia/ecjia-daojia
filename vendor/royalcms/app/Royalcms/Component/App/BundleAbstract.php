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

    public function __construct()
    {
        $this->site = defined('RC_SITE') ? RC_SITE : 'default';
    }

    /**
     * 获取应用唯一标识符
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     * @return BundleAbstract
     */
    public function setIdentifier(string $identifier): BundleAbstract
    {
        $this->identifier = $identifier;
        return $this;
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
     * @param string $directory
     * @return BundleAbstract
     */
    public function setDirectory(string $directory): BundleAbstract
    {
        $this->directory = $directory;
        return $this;
    }

    /**
     * 获取应用所属站点名
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     * @return BundleAbstract
     */
    public function setAlias(string $alias): BundleAbstract
    {
        $this->alias = $alias;
        return $this;
    }


    public function getNameSpace()
    {
        return $this->namespace;
    }

    /**
     * @param mixed $namespace
     * @return BundleAbstract
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }


    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param mixed $provider
     * @return BundleAbstract
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
        return $this;
    }

    /**
     * @param string $site
     * @return BundleAbstract
     */
    public function setSite(string $site): BundleAbstract
    {
        $this->site = $site;
        return $this;
    }

    /**
     * @param mixed $package
     * @return BundleAbstract
     */
    public function setPackage($package)
    {
        $this->package = $package;
        return $this;
    }

    /**
     * @param mixed $controllerPath
     * @return BundleAbstract
     */
    public function setControllerPath($controllerPath)
    {
        $this->controllerPath = $controllerPath;
        return $this;
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
        if (!royalcms('app')->hasAlias($this->alias)) {
            return RC_Error::make('not_register_route_app', '没有注册此路由名称');
        }

        $controller_classname = $this->namespace . '\Controllers\\' . $this->normalizeName($controller) . 'Controller';
        if (class_exists($controller_classname)) {
            return $controller_classname;
        }

        $app_controller = $this->controllerPath . $controller . '.php';
        if (!file_exists($app_controller)) {
            return RC_Error::make('controller_does_not_exist', "Controller {$app_controller} does not exist.");
        }

        include_once $app_controller;

        $controller_classname = $controller;

        $my_controller = $this->controllerPath . 'MY_' . $controller . '.php';
        if (file_exists($my_controller)) {
            $controller_classname = 'MY_' . $controller;

            include_once $my_controller;
        }

        if (class_exists($controller_classname)) {
            return $controller_classname;
        }

        return RC_Error::make('controller_does_not_exist', "Controller class {$controller_classname} does not exist.");;
    }


    /**
     * 获取应用包信息
     *
     * @param string $id
     * @return bool | array
     */
    protected function makeAppPackage($markup = true, $translate = true)
    {
        $package = new AppPackage($this);

        $package->loadPackageData();

        if ($package && $translate) {
            $this->package = $package->getFormatPackage();
        } else {
            $this->package = $package->getPackage();
        }
    }


    public function getPackage($key = null)
    {
        if (is_null($key)) {
            return $this->package;
        }
        return array_get($this->package, $key);
    }


    /**
     * Get app/configs/package.php configuration.
     *
     * @return NULL | array
     */
    public function getPackageData()
    {
        return config($this->getContainerName() . '::' . 'package');
    }

    /**
     * Get application provider container name
     *
     * @return string
     */
    abstract public function getContainerName();

    /**
     * Get the app/configs/package.php path.
     *
     * @return mixed
     */
    abstract public function getPackageConfig();


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
            'identifier'     => $this->identifier,
            'directory'      => $this->directory,
            'alias'          => $this->alias,
            'site'           => $this->site,
            'package'        => $this->package,
            'namespace'      => $this->namespace,
            'provider'       => $this->provider,
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
    public function getNamespaceClassName($class)
    {
        return $this->getNameSpace() . '\\' . $class;
    }

}

// end