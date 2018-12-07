<?php
/**
 * Customize API: NavMenuSection class
 *
 * @package Ecjia Theme
 * @subpackage Customize
 * @since 4.4.0
 */

namespace Ecjia\App\Theme\Customize\Section;

use Ecjia\App\Theme\Customize\Section;

/**
 * Customize Menu Section Class
 *
 * Custom section only needed in JS.
 *
 * @since 4.3.0
 *
 * @see Section
 */
class NavMenuSection extends Section
{

	/**
	 * Control type.
	 *
	 * @since 4.3.0
	 * @var string
	 */
	public $type = 'nav_menu';

	/**
	 * Get section parameters for JS.
	 *
	 * @since 4.3.0
	 * @return array Exported parameters.
	 */
	public function json() {
		$exported = parent::json();
		$exported['menu_id'] = intval( preg_replace( '/^nav_menu\[(-?\d+)\]/', '$1', $this->id ) );

		return $exported;
	}
}
