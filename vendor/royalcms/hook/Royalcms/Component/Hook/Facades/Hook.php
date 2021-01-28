<?php

namespace Royalcms\Component\Hook\Facades;

use Royalcms\Component\Support\Facades\Facade;

/**
 * @see \Royalcms\Component\Hook\Hooks
 */
class Hook extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() {
	    return 'hook';
	}

}
