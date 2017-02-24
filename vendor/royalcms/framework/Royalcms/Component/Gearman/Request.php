<?php

/**
 * @file
 *
 * 基于GrearMan的请求格式化类
 *
 * 前端请求的格式类似
 * array(
 *   header  : array
 *   request
 *     p     : mixed  参数
 *     c     : class  类名
 *     m     : method 函数方法
 * )
 *
 * 转换后的格式类似
 * params : array (如果只有一个参数,为[0])
 * class  : 对应上面的c
 * method : 对应上面的m
 * headers :
 *   ******  : 对应上面header中元素
 */

namespace Gearman\Component\Gearman;

/**
 * @usage
 *
 * $request = new Request($info);
 * $uid = $request->getParameter('uid');
 * $method = $request->getHeader('method');
 */
class Request {
    
    /**
     * Parameters数据
     *
     * @var array
     */
    public $params = array();
    
    /**
     * Headers数据
     *
     * @var array
     */
    public $headers = array();
    
    /**
     * 文件
     */
    public $files;
    
    /**
     * 类名
     */
    public $class = '';
    
    /**
     * 类方法
     */
    public $method = '';
    
    /**
     * OutputParameters
     *
     * @var array
     */
    public $outparams = array();
    
    /**
     * raw request data
     *
     * @var mixed
     */
    public $rawdata = null;
    
    /**
     * 析构函数
     *
     * @param mixed   $content
     * @param integer $status
     * @param array   $headers
     *
     * @api
     */
    public function __construct($input = null) {
        $this->rawdata = $input;
        $this->initGearmanInput($input);
    }
    
    /**
     * 是否有指定名称的元素
     *
     * @return bool
     *
     * @api
     */
    public function hasParameter($name) {
        return isset($this->params[$name]);
    }
    
    /**
     * 获取指定名称的元素
     *
     * @return mixed|null
     *
     * @api
     */
    public function getParameter($name, $default = null) {
        return isset($this->params[$name]) ? $this->params[$name] : $default;
    }
    
    /**
     * 获取指定名称的多个元素
     *
     * @return mixed|null
     *
     * @api
     */
    public function getParameters($names = null) {
        if (is_array($names)) {
            foreach ($names as $name) {
                $return[$name] = $this->getParameter($name);
            }
            return $return;
        }
        elseif (!isset($names)) {
            return $this->params;
        }
    }
    
    /**
     * 设置指定名称的元素
     *
     * @api
     */
    public function setParameter($name, $value = null) {
        if (is_null($value)) {
            unset($this->params[$name]);
        } else {
            $this->params[$name] = $value;
        }
        
        return $this;
    }
    
    /**
     * 设置指定名称的一批元素
     *
     * @api
     */
    public function setParameters(array $values) {
        $this->params = $values + $this->params;
        
        return $this;
    }
    
    /**
     * 获取输出字段指定名称的元素
     *
     * @return mixed|null
     *
     * @api
     */
    public function getOutputParameter($name, $default = null) {
        return isset($this->outparams[$name]) ? $this->outparams[$name] : $default;
    }

    /**
     * 获取输出字段指定名称的多个元素
     *
     * @return mixed|null
     *
     * @api
     */
    public function getOutputParameters($names = null) {
        if (is_array($names)) {
            foreach ($names as $name) {
                $return[$name] = $this->getOutputParameter($name);
            }
            return $return;
        }
        elseif (!isset($names)) {
            return $this->outparams;
        }
    }
    
    /**
     * 设置输出字段指定名称的元素
     *
     * @api
     */
    public function setOutputParameter($name, $value) {
        $this->outparams[$name] = $value;
        
        return $this;
    }
    
    /**
     * 设置输出字段指定名称的一批元素
     *
     * @api
     */
    public function setOutputParameters(array $values) {
        $this->outparams = $values + $this->outparams;
        
        return $this;
    }
    
    /**
     * 设置头信息
     *
     * @api
     */
    public function setHeaders(array $headers) {
        $this->headers = $headers + $this->headers;

        return $this;
    }
    
    /**
     * 设置头信息
     *
     * @api
     */
    public function setHeader($key, $value) {
        if ($value === null) {
            unset($this->headers[$key]);
        } else {
            $this->headers[$key] = $value;
        }
        return $this;
    }

    /**
     * 获取头信息
     *
     * @api
     */
    public function getHeaders() {
        return $this->headers;
    }
    
    /**
     * 获取头信息某个元素
     *
     * @api
     */
    public function getHeader($key, $default = null) {
        return isset($this->headers[$key]) ? $this->headers[$key] : $default;
    }

    /**
     * 获取原始请求信息
     *
     * @api
     */
    public function getRawData() {
        return $this->rawdata;
    }

    /**
     * 转换Gearman输入的参数
     *
     * @api
     */
    public function initGearmanInput($input = null) {
        if (is_string($input)) {
            $input = unserialize($input);
        }
        if (isset($input['header']) && is_array($input['header'])) {
            $this->setHeaders($input['header']);
        }
        if (isset($input['request']['p'])) {
            $this->setParameters((array) $input['request']['p']); 
        }
        if (isset($input['request']['o'])) {
            $this->setOutputParameters((array) $input['request']['o']); 
        }
        if (isset($input['request']['c'])) {
            $this->class = (string) $input['request']['c'];
        }
        if (isset($input['request']['m'])) {
            $this->method = (string) $input['request']['m'];
        }
        
        return $this;
    }
    
    /**
     * 拼装结果
     *
     * @api
     */
    public function process() {
        return array(
            'request' => array(
                'p' => $this->params,
                'm' => $this->method,
                'c' => $this->class,
            ),
            'header'  => $this->headers,
            'files'   => $this->files,
        );
    }
    
    /**
     * 魔术方法
     *
     * @api
     */
    public function __toString() {
        return var_export($this->process(), true);
    }
    
    //自身迭代
    public static function create($input = null) {
        return new static($input);
    }
    
}
