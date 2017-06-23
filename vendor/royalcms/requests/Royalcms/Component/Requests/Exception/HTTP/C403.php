<?php

namespace Royalcms\Component\Requests\Transport\HTTP;

use Royalcms\Component\Requests\Exception\HTTP;

/**
 * Exception for 403 Forbidden responses
 *
 * @package Requests
 */

/**
 * Exception for 403 Forbidden responses
 *
 * @package Requests
 */
class C403 extends HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer
	 */
	protected $code = 403;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = 'Forbidden';
}