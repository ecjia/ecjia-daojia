<?php namespace Royalcms\Component\QrCode\Facades;

/**
 * Simple QrCode Generator
 * A simple wrapper for the popular BaconQrCode made for Royalcms.
 *
 */

use Royalcms\Component\Support\Facades\Facade;

class QrCode extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'qrcode'; }

}
