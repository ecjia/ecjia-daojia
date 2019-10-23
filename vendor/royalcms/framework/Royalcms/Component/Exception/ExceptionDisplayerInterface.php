<?php

namespace Royalcms\Component\Exception;

use Exception;

interface ExceptionDisplayerInterface
{

	/**
	 * Display the given exception to the user.
	 *
	 * @param  \Throwable  $exception
	 */
	public function display($exception);

}
