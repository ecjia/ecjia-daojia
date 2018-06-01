<?php 

namespace Royalcms\Component\Remote\Facades;

use Royalcms\Component\Support\Facades\Facade;

/**
 * @see \Royalcms\Component\Remote\RemoteManager
 * @see \Royalcms\Component\Remote\Connection
 */
class SSH extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'remote'; }

}
