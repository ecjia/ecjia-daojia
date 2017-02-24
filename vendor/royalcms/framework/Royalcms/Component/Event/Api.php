<?php
defined('IN_ROYALCMS') or exit('No permission resources.');

/**
 * API事件基类
 *
 * @subpackage core
 */

abstract class Component_Event_Api extends Component_Event_Event
{

    /**
     * API参数
     *
     * @var array $options
     */
    protected $options = array();

    /**
     * 构造函数
     */
    public function __construct()
    {
        if (! empty($this->options)) {
            // TODO:
        }
    }

    /**
     * 兼容event抽象方法
     *
     * @param unknown $param            
     */
    public function run(&$param)
    {
        return $this->call($param);
    }

    /**
     * API调用抽象方法
     *
     * @param array $param            
     */
    public abstract function call(&$param);
}

// end