<?php

namespace Royalcms\Component\Requests\Transport\HTTP;

use Royalcms\Component\Requests\Exception\HTTP;

/**
 * Exception for 431 Request Header Fields Too Large responses
 *
 * @see https://tools.ietf.org/html/rfc6585
 * @package Requests
 */

/**
 * Exception for 431 Request Header Fields Too Large responses
 *
 * @see https://tools.ietf.org/html/rfc6585
 * @package Requests
 */
class C431 extends HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer
	 */
	protected $code = 431;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = 'Request Header Fields Too Large';
}