<?php


namespace Ecjia\Component\ApiServer\Route;


use Ecjia\Component\ApiServer\Contracts\ApiParserInterface;
use RC_Loader;
use ecjia_error;

class ApiModuleParser implements ApiParserInterface
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

    /**
     * API类所在的路径
     * @var string
     */
    protected $classPath;

    /**
     * API类所在的位置文件名
     * @var string
     */
    protected $fileName;

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
        $path = dirname($apiPath);
        $name = basename($apiPath);

        if ($path == '.') {
            $controller = null;
        } else {
            $controller = $path;
        }

        $this->classPath = $controller;

        $this->className = $name . '_module';

        $this->fileName = $name;
    }

    /**
     * 获取完整的类名
     * @return string
     */
    public function getFullClassName()
    {
        $class = $this->classPath . '/' . $this->className;
        $className = str_replace('/', '_', $class);
        return $className;
    }

    /**
     * 获取完整的文件名
     * @return string
     */
    public function getFullFileName()
    {
        return $this->fileName . '.class.php';
    }

    /**
     * @return ecjia_error|mixed
     */
    public function getApihandler()
    {
        if ($this->appModule == 'system') {
            $handle = $this->handlerSystemHttpApi();
        } else {
            $handle = $this->handlerAppHttpApi();
        }

        if (! is_a($handle, $this->getFullClassName()) && ! is_a($handle, $this->className) ) {
            return new ecjia_error('api_not_instanceof', sprintf(__('Api Error:%s does not exist.', 'ecjia'), $this->getFullClassName()));
        }

        return $handle;
    }

    /**
     * @param ApiRouter $router
     */
    protected function handlerSystemHttpApi()
    {
        $handle = RC_Loader::load_module($this->classPath.'.'.$this->className, false);

        $fullClassName = $this->getFullClassName();
        if (class_exists($fullClassName)) {
            return new $fullClassName;
        }

        return new $this->className;
    }

    /**
     * @param ApiRouter $router
     * @param $app
     */
    protected function handlerAppHttpApi()
    {
        RC_Loader::load_app_module($this->classPath.'.'.$this->className, $this->appModule, false);

        $fullClassName = $this->getFullClassName();
        if (class_exists($fullClassName)) {
            return new $fullClassName;
        }

        return new $this->className;
    }

}