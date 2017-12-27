<?php

namespace Royalcms\Component\Printer;

use Exception;
use InvalidArgumentException;
use RC_Cache;
use RC_Hook;
use RC_Error;

class Factory
{
    
    /**
     * 配置
     * @var array
     */
    protected $config = [];
    
    protected $cacheKey = 'printer_command_factories';
    
    protected static $factories;
    
    public function __construct()
    {
        self::$factories = $this->getFactories();
    }

    public function getFactories()
    {
    
        $factories = RC_Cache::app_cache_get($this->cacheKey, 'printer');
    
        if (empty($factories)) {
    
            $dir = __DIR__ . '/Commands';
    
            $platforms = royalcms('files')->files($dir);
    
            $factories = [];
    
            foreach ($platforms as $key => $value) {
                $value = str_replace($dir . '/', '', $value);
                $value = str_replace('.php', '', $value);
                $className = __NAMESPACE__ . '\Commands\\' . $value;
    
                $key = with(new $className)->getMethod();
                $factories[$key] = $className;
            }
    
            RC_Cache::app_cache_set($this->cacheKey, $factories, 'printer', 10080);
        }
    
        return RC_Hook::apply_filters('royalcms_printer_command_filter', $factories);
    }
    
    /**
     * 获取所有支持接口
     * @return array
     */
    public function getCommands()
    {
        $platforms = [];
    
        foreach (self::$factories as $key => $value) {
            $platforms[$key] = new $value;
        }
    
        return $platforms;
    }
    
    /**
     * 获取某个接口操作对象
     * @param string $method  接口名称
     * @throws InvalidArgumentException
     * @return \Royalcms\Component\Printer\Contract\Command
     */
    public function command($method)
    {
        if (!array_key_exists($method, self::$factories)) {
            throw new InvalidArgumentException("Printer command '$method' is not supported.");
        }
    
        $className = self::$factories[$method];
    
        return new $className();
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
        if (!array_key_exists($method, self::$factories)) {
            throw new InvalidArgumentException("Printer command '$method' is not supported.");
        }
    
        $className = self::$factories[$method];
    
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
        $classNameSpace = $classname;
    
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
        return $client->execute($request);
    }
}
