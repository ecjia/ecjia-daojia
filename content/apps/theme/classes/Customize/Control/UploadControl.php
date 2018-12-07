<?php
/**
 * Customize API: UploadControl class
 *
 * @package Ecjia Theme
 * @subpackage Customize
 * @since 4.4.0
 */

namespace Ecjia\App\Theme\Customize\Control;

use Ecjia\App\Theme\Customize\Control;

/**
 * Customize Upload Control Class.
 *
 * @since 3.4.0
 *
 * @see MediaControl
 */
class UploadControl extends MediaControl
{
	public $type          = 'upload';
	public $mime_type     = '';
	public $button_labels = array();
	public $removed = ''; // unused
	public $context; // unused
	public $extensions = array(); // unused

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @since 3.4.0
	 *
	 * @uses WP_Customize_Media_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();

		$value = $this->value();
		if ( $value ) {
			// Get the attachment model for the existing file.
			$attachment_id = attachment_url_to_postid( $value );
			if ( $attachment_id ) {
				$this->json['attachment'] = wp_prepare_attachment_for_js( $attachment_id );
			}
		}
	}
}
