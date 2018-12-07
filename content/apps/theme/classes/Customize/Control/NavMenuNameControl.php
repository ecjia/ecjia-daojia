<?php
/**
 * Customize API: NavMenuNameControl class
 *
 * @package Ecjia Theme
 * @subpackage Customize
 * @since 4.4.0
 */

namespace Ecjia\App\Theme\Customize\Control;

use Ecjia\App\Theme\Customize\Control;

/**
 * Customize control to represent the name field for a given menu.
 *
 * @since 4.3.0
 *
 * @see Control
 */
class NavMenuNameControl extends Control
{

	/**
	 * Type of control, used by JS.
	 *
	 * @since 4.3.0
	 * @var string
	 */
	public $type = 'nav_menu_name';

	/**
	 * No-op since we're using JS template.
	 *
	 * @since 4.3.0
	 */
	protected function render_content() {}

	/**
	 * Render the Underscore template for this control.
	 *
	 * @since 4.3.0
	 */
	protected function content_template() {
		?>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{ data.label }}</span>
			<# } #>
			<input type="text" class="menu-name-field live-update-section-title"
				<# if ( data.description ) { #>
					aria-describedby="{{ data.section }}-description"
				<# } #>
				/>
		</label>
		<# if ( data.description ) { #>
			<p id="{{ data.section }}-description">{{ data.description }}</p>
		<# } #>
		<?php
	}
}
