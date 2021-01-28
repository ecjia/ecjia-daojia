<?php


namespace Ecjia\Component\ApiServer\Route;


use Ecjia\Component\ApiServer\Contracts\ApiParserInterface;
use ecjia_error;

class ApiControllerParser implements ApiParserInterface
{

    /**
     * API所在的APP
     * @var string
     */
    protected $appModule;

    protected $apiPath;

    /**
     * API具体类
     * @var string
     */
    protected $className;

    public function __construct($appModule, $apiPath)
    {
        $this->appModule = $appModule;
        $this->apiPath = $apiPath;

        $this->parse($apiPath);
    }

    /**
     * 解析
     * @return mixed
     */
    protected function parse($apiPath)
    {
        $paths = explode('/', $apiPath);
        $paths = array_map('ucfirst', $paths);
        $path = implode('/', $paths);

        $this->className = $path . 'Controller';
    }

    /**
     * 获取完整的类名
     * @return string
     */
    public function getFullClassName()
    {
        return $this->getNamespaceClassName($this->className);
    }

    /**
     * 获取完整的文件名
     * @return string
     */
    public function getFullFileName()
    {
        $bundle = royalcms('app')->driver($this->appModule);

        $path = $bundle->getAbsolutePath();

        $path .= 'ApiControllers\\'.$this->className.'.php';

        return $path;
    }

    protected function getNamespaceClassName($class = null)
    {
        $bundle = royalcms('app')->driver($this->appModule);

        if (is_null($class)) {
            $namespace = $bundle->getNameSpace();
        }
        else {
            $class = str_replace('/', '\\', $class);
            $namespace = $bundle->getNamespaceClassName('ApiControllers\\'.$class);
        }

        return $namespace;
    }

    /**
     * @return ecjia_error|mixed
     */
    public function getApihandler()
    {
        $class = $this->getFullClassName();

        if (class_exists($class)) {
            return new $class;
        }

        return new ecjia_error('api_not_instanceof', sprintf(__('Api Error:%s does not exist.', 'ecjia'), $this->getFullClassName()));
    }

}