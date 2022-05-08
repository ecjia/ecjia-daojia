<?php


namespace Royalcms\Component\Model\Traits;

/**
 * 触发器
 * Trait TriggerTrait
 * @package Royalcms\Component\Model\Traits
 */
trait TriggerTrait
{

    /**
     * 触发器，是否执行__after_delete等魔术方法
     */
    public function trigger($stat = false)
    {
        $this->trigger = $stat;
        return $this;
    }

    /**
     * 模型实例化时自动执行的方法
     */
    public function __init()
    {
    }

    /**
     * 添加数据前执行的方法
     *
     * @param unknown $data
     */
    public function __before_insert(& $data)
    {
    }

    /**
     * 添加数据后执行的方法
     *
     * @param unknown $data
     */
    public function __after_insert(& $data)
    {
    }

    /**
     * 删除数据前执行的方法
     *
     * @param unknown $data
     */
    public function __before_delete(& $data)
    {
    }

    /**
     * 删除数据后执行的方法
     *
     * @param unknown $data
     */
    public function __after_delete(& $data)
    {
    }

    /**
     * 更新数据后前执行的方法
     *
     * @param unknown $data
     */
    public function __before_update(& $data)
    {
    }

    /**
     * 更新数据后执行的方法
     *
     * @param unknown $data
     */
    public function __after_update(& $data)
    {
    }

    /**
     * 查询数据前前执行的方法
     *
     * @param unknown $data
     */
    public function __before_select(& $data)
    {
    }

    /**
     * 查询数据后执行的方法
     *
     * @param unknown $data
     */
    public function __after_select(& $data)
    {
    }

}