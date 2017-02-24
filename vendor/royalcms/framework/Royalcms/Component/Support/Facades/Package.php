<?php namespace Royalcms\Component\Support\Facades;

/**
 * @see \Royalcms\Component\Package\PackageManager
 */
class Package extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'package'; }

}
