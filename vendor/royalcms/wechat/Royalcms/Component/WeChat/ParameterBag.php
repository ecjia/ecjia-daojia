<?php namespace Royalcms\Component\WeChat;

use ArrayIterator;

/*
 * @file
 *
 * ParameterBag
 */

class ParameterBag {
    
    /**
     * Parameters数据
     *
     * @var array
     */
    protected $params = array();
    
    /**
     * 析构函数
     *
     * @param array   $params
     */
    public function __construct($params = array()) {
        $this->params = $params;
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
        } elseif (!isset($names)) {
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
     * 重置parameters
     *
     * @api
     */
    public function replace(array $params = array()) {
        $this->params = $params;
    }
    
    /**
     * 清空parameters
     *
     * @api
     */
    public function flush() {
        $this->params = array();
    }

    /**
     * 读取所有的keys
     *
     * @api
     */
    public function keys() {
        return array_keys($this->params);
    }
    
    /**
     * 元素数量
     *
     * @api
     */
    public function count() {
        return count($this->params);
    }
    
    //返回迭代器
    public function getIterator() {
        return new ArrayIterator($this->params);
    }

    /**
     * 魔术方法
     */
    public function __toString() {
        return var_export($this->params, true);
    }

    //自身迭代
    public static function create($params = array()) {
        return new static($params);
    }

}