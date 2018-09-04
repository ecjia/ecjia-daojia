<?php

namespace Royalcms\Component\Variable\Facades;

use Royalcms\Component\Support\Facades\Facade;

/**
 * @usage
 *
 * 存储一个配置
 *   RC_Variable::set($key, $value);
 *
 * 检索一个配置
 *   RC_Variable::get($key);
 *
 * 删除一个配置
 *   RC_Variable::delete($key);
 *
 * 存储多个配置
 *   RC_Variable::setMulti($items);
 *
 * 检索多个配置
 *   RC_Variable::getMulti($keys);
 *
 * 删除多个配置
 *   RC_Variable::deleteMulti($keys);
 *
 * 是否有这个元素
 *   RC_Variable::hasKey($key);
 *
 * @see \Royalcms\Component\Variable\Variable
 */
class Variable extends Facade
{

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
    {
        return 'variable';
    }

}
