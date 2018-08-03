<?php 

namespace Royalcms\Component\Validation\Contracts;

interface ValidatesWhenResolved {

	/**
	 * Validate the given class instance.
	 *
	 * @return void
	 */
	public function validate();

}
