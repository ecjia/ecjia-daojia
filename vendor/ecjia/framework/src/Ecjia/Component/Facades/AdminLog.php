<?php


namespace Ecjia\Component\Facades;

use Royalcms\Component\Support\Facades\Facade;

/**
 * Class AdminLog
 * @package Ecjia\Component\Facades
 *
 * @method static static instance()
 * @method static bool add_action($code, $name) 添加日志动作
 * @method static bool has_action($code) 判断是否有这个日志动作
 * @method static bool add_object($code, $name) 添加日志对象
 * @method static bool has_object($code) 判断是否有这个日志对象
 * @method static bool get_message($sn, $action, $content) 记录管理员的操作内容
 * @method static getLogAction()
 * @method static getLogObject()
 * @method static getMessage($sn, $action, $object, $callback = null)
 */
class AdminLog extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'ecjia.admin.log';
    }

}