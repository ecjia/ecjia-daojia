<?php namespace Royalcms\Component\Support\Facades;

/**
 * @see \Royalcms\Component\Cache\CacheManager
 * @see \Royalcms\Component\Cache\Repository 
 */
class Cache extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'cache'; }

}
