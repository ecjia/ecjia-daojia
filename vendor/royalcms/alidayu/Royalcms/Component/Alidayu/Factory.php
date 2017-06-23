<?php

namespace Royalcms\Component\Alidayu;

use Exception;

class Factory
{
    protected $royalcms;
    
    /**
     * 配置
     * @var array
     */
    protected $config = [];

    public function __construct($royalcms)
    {
        $this->royalcms = $royalcms;
    }

    /**
     * 动态配置（全局）
     * @param  array $config 配置项
     * @return [type]         [description]
     */
    public function configure($config)
    {
        $this->config = $config;
    }
    
    /**
     * 通过接口名称获取对应的类名称
     * @param  string $method 接口名称
     * @return string
     */
    protected function getMethodClassName($method)
    {
        $methods = explode('.', $method);
    
        if (!is_array($methods)) {
            return false;
        }
    
        $tmp = array();
    
        foreach ($methods as $value) {
            $tmp[] = ucwords($value);
        }
    
        $className = implode('', $tmp);
    
        return $className;
    }
    
    /**
     * 请求API
     * @param  string   $method   接口名称
     * @param  callable $callable 执行函数
     * @return [type]             [description]
     */
    public function request($method, callable $callable)
    {
        // A. 校验
        if (empty($method) ||
            ! $classname = $this->getMethodClassName($method)
        ) {
            throw new Exception("request method error");
        }
    
        // B. 获取带命名空间的类
        $classNameSpace = __NAMESPACE__ . '\\Commands\\' . $classname;
    
        if (! class_exists($classNameSpace)) {
            throw new Exception("request method does not exist");
        }
    
        // C. 创建对象
        $request = new $classNameSpace;
    
        // D. 执行匿名函数
        if (is_callable($callable)) {
            call_user_func($callable, $request);
        }
    
        // E. 创建CLIENT对象
        $client = new Client(new App($this->config));
    
        return call_user_func_array([$client, 'execute'], [$request]);
    }
}
