<?php

namespace Royalcms\Component\Requests\Transport\HTTP;

use Royalcms\Component\Requests\Exception\HTTP;

/**
 * Exception for 400 Bad Request responses
 *
 * @package Requests
 */

/**
 * Exception for 400 Bad Request responses
 *
 * @package Requests
 */
class C400 extends HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer
	 */
	protected $code = 400;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = 'Bad Request';
}