<?php namespace Royalcms\Component\Support\Facades;

/**
 * @see \Royalcms\Component\Hook\Hooks
 */
class Hook extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'hook'; }

}
