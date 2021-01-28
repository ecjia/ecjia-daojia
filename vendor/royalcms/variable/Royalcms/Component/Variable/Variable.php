<?php namespace Royalcms\Component\Variable;

use RC_Hook;

/**
 * @file
 *
 * 应用配置类
 */

class Variable {

    /**
     * 配置
     *
     * @var array
     */
    protected $data = array();

    /**
     * 是否已加载
     *
     * @var bool
     */
    protected $isLoaded = false;

    /**
     * 析构函数
     */
    public function __construct() {
        $this->load();
    }

    /**
     * 读配置
     *
     * @param string $key
     */
    public function get($key = '', $default = null) {
        if (empty($key)) {
            return $this->data;
        } else {
            return isset($this->data[$key]) ? $this->data[$key] : $default;
        }
    }

    /**
     * 写配置
     */
    public function set($key, $value) {
        $this->data[$key] = $value;
        RC_Hook::do_action('rc_variable_set', $key, $value);
        return $this;
    }

    /**
     * 删除
     */
    public function delete($key) {
        unset($this->data[$key]);
        RC_Hook::do_action('rc_variable_delete', $key);
        return $this;
    }

    /**
     * 存储多个
     */
    public function setMulti(array $items) {
        foreach ($items as $key => $value) {
            $this->set($key, $value);
        }
        
        return $this;
    }
    
    /**
     * 检索多个
     *
     * return array|null
     */
    public function getMulti(array $keys) {
        foreach ($keys as $key) {
            $return[$key] = $this->get($key);
        }
        
        return $return;
    }
    
    /**
     * 删除多个
     */
    public function deleteMulti(array $keys) {
        foreach ($keys as $key) {
            $this->delete($key);
        }
        
        return $this;
    }
    
    /**
     * 是否有这个元素
     */
    public function hasKey($key) {
        return isset($this->data[$key]) ? true : false;
    }

    /**
     * 装载配置
     */
    public function load() {
        if (!$this->isLoaded) {
            try {
                $this->data = RC_Hook::apply_filters('rc_variable_load', array());
                foreach ($this->data as $k => $v) {
                    $this->data[$k] = unserialize($v);
                }
                $this->isLoaded = true;
            } catch (\Exception $e) {
                throw new \Exception('Struct {variables} is not exists.');
            }
        }
        return $this;
    }

}
