<?php


namespace Ecjia\System\Admins\AdminLog;

/**
 * Trait CompatibleTrait
 * @package Ecjia\System\Admins\AdminLog
 *
 * @property AdminLogAction $log_action
 * @property AdminLogObject $log_object
 */
trait CompatibleTrait
{

    /**
     * 返回当前终级类对象的实例
     *
     * @return object
     */
    public static function instance()
    {
        return royalcms('ecjia.admin.log');
    }


    /**
     * 添加日志动作
     * @param string $code
     * @param string $name
     */
    public function add_action($code, $name)
    {
        return $this->log_action->addAction($code, $name);
    }

    /**
     * 判断是否有这个日志动作
     * @param string $code
     * @return bool
     */
    public function has_action($code)
    {
        return $this->log_action->hasAction($code);
    }

    /**
     * 添加日志对象
     * @param string $code
     * @param string $name
     */
    public function add_object($code, $name)
    {
        return $this->log_object->addObject($code, $name);
    }

    /**
     * 判断是否有这个日志对象
     * @param string $code
     * @return bool
     */
    public function has_object($code)
    {
        return $this->log_object->hasObject($code);
    }

    /**
     * 记录管理员的操作内容
     * @param   string      $sn         数据的唯一值
     * @param   string      $action     操作的类型
     * @param   string      $content    操作的内容
     * @return  string
     */
    public function get_message($sn, $action, $content)
    {
        return $this->getMessage($sn, $action, $content);
    }

}