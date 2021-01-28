<?php namespace Royalcms\Component\Rewrite\Facades;

use Royalcms\Component\Support\Facades\Facade;

/**
 * @see \Royalcms\Component\Rewrite\RewriteQuery
 */
class Rewrite extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'rewrite'; }

}
