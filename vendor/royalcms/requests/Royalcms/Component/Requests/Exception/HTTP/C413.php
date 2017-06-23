<?php

namespace Royalcms\Component\Requests\Transport\HTTP;

use Royalcms\Component\Requests\Exception\HTTP;

/**
 * Exception for 413 Request Entity Too Large responses
 *
 * @package Requests
 */

/**
 * Exception for 413 Request Entity Too Large responses
 *
 * @package Requests
 */
class C413 extends HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer
	 */
	protected $code = 413;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = 'Request Entity Too Large';
}