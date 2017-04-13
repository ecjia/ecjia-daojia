<?php namespace Royalcms\Component\Timer\Facades;

use Royalcms\Component\Support\Facades\Facade;

class Timer extends Facade {

	/**
	 * Get the registered component.
	 *
	 * @return object
	 */
	protected static function getFacadeAccessor() { return 'timer'; }

}