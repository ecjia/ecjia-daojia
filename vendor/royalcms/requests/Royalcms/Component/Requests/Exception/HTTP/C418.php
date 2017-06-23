<?php

namespace Royalcms\Component\Requests\Transport\HTTP;

use Royalcms\Component\Requests\Exception\HTTP;

/**
 * Exception for 418 I'm A Teapot responses
 *
 * @see https://tools.ietf.org/html/rfc2324
 * @package Requests
 */

/**
 * Exception for 418 I'm A Teapot responses
 *
 * @see https://tools.ietf.org/html/rfc2324
 * @package Requests
 */
class C418 extends HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer
	 */
	protected $code = 418;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = "I'm A Teapot";
}