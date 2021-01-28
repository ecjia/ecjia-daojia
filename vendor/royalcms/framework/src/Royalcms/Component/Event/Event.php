<?php

namespace Royalcms\Component\Event;

/**
 * 事件基类
 *
 * @subpackage core
 */
abstract class Event
{
    // 事件参数
    protected $options = array();
    
    // 构造函数
    public function __construct()
    {
        if (! empty($this->options)) {

        }
    }

    public abstract function run(& $param);
}

// end