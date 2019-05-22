<?php


namespace Ecjia\System\Admins\AdminLog;


class AdminLogAction
{

    protected $items;


    public function __construct()
    {
        $this->items = [
            'add'               => __('添加'),
            'edit'              => __('编辑'),
            'use'            	=> __('启用'),
            'stop'            	=> __('停用'),
            'remove'            => __('删除'),
            'install'           => __('安装'),
            'uninstall'         => __('卸载'),
            'setup'             => __('设置'),
            'trash'             => __('回收'),
            'restore'           => __('还原'),
            'merge'             => __('合并'),
            'batch_remove'      => __('批量删除'),
            'batch_trash'       => __('批量回收'),
            'batch_restore'     => __('批量还原'),
            'batch_upload'      => __('批量上传'),
            'batch_edit'        => __('批量编辑'),
            'batch_stop'        => __('批量停用'),
        ];
    }

    /**
     * 添加日志动作
     *
     * @param string $code
     * @param string $name
     *
     * @return $this
     */
    public function addAction($code, $name)
    {
        if ($code && $name) {
            $this->items[$code] = $name;
        }

        return $this;
    }

    /**
     * 批量添加日志动作
     *
     * @param array $actions
     *
     * @return $this
     */
    public function addActions(array $actions)
    {
        foreach ($actions as $code => $name) {
            $this->items[$code] = $name;
        }

        return $this;
    }

    /**
     * 判断是否有这个日志动作
     *
     * @param string $code
     *
     * @return boolean
     */
    public function hasAction($code)
    {
        return array_has($this->items, $code);
    }


    /**
     * 获取指定日志动作
     *
     * @param $code
     * @param null $default
     *
     * @return string
     */
    public function getAction($code, $default = null)
    {
        return array_get($this->items, $code, $default);
    }


}