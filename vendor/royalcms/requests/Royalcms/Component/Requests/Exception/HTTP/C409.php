<?php

namespace Royalcms\Component\Requests\Transport\HTTP;

use Royalcms\Component\Requests\Exception\HTTP;

/**
 * Exception for 409 Conflict responses
 *
 * @package Requests
 */

/**
 * Exception for 409 Conflict responses
 *
 * @package Requests
 */
class C409 extends HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer
	 */
	protected $code = 409;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = 'Conflict';
}