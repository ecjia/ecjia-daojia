<?php namespace Royalcms\Component\Foundation;
defined('IN_ROYALCMS') or exit('No permission resources.');

class Event extends Object
{

    /**
     * 执行单一事件处理程序
     *
     * @param string $name
     *            事件名称
     * @param null $params
     *            事件参数
     */
    public static function do_action($name, &$params = null)
    {
        $class = $name . "_event";
        $event = new $class();
        $event->run($params);
    }

    /**
     * 执行事件中的所有处理程序
     *
     * @param $name 事件名称            
     * @param array $param
     *            参数
     * @return void
     */
    public static function all($name, &$param = array())
    {
        // TODO:
        // 应用事件
        // $event = ?;
        
        // if (is_array($group)) {
        // if ($core) {
        // $group = array_merge($core, $group);
        // }
        // } else {
        // $group = $core;
        // }
        // if (is_array($group)) {
        // if ($event) {
        // $event = array_merge($group, $event);
        // } else {
        // $event = $group;
        // }
        // }
        // if (is_array($event) && !empty($event)) {
        // foreach ($event as $e) {
        // self::run($e, $param);
        // }
        // }
    }
    
    /**
     * 添加事件
     */
    public static function add_event() {
        
    }
}

// end