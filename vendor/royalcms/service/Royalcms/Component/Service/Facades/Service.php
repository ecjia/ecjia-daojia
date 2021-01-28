<?php

namespace Royalcms\Component\Service\Facades;

use Royalcms\Component\Support\Facades\Facade;

/**
 * @see \Royalcms\Component\Service\ServiceManager
 * @method static addService($tag, $app, $handle)
 * @method static getHandles()
 * @method static getHandleWithTag($tag)
 * @method static getHandleWithTagApp($tag, $app)
 * @method static hasHandleWithTag($tag, $app = null)
 * @method static fire($tag, $app, $params = array()) 指定一个tag和一个app调用服务
 * @method static fires($tag, $params = array()) 指定一个tag调用一组服务
 * @method static handle($handle, $params = array())
 */
class Service extends Facade
{

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() {
	    return 'service';
	}

}
