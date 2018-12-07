<?php
/**
 * Customize API: BackgroundImageSetting class
 *
 * @package Ecjia Theme
 * @subpackage Customize
 * @since 4.4.0
 */

namespace Ecjia\App\Theme\Customize\Setting;

use Ecjia\App\Theme\Customize\Setting;

/**
 * Customizer Background Image Setting class.
 *
 * @since 3.4.0
 *
 * @see Setting
 */
final class BackgroundImageSetting extends Setting
{
	public $id = 'background_image_thumb';

	/**
	 * @since 3.4.0
	 *
	 * @param $value
	 */
	public function update( $value ) {
		remove_theme_mod( 'background_image_thumb' );
	}
}
