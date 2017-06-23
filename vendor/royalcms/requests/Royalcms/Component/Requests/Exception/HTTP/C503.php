<?php

namespace Royalcms\Component\Requests\Transport\HTTP;

use Royalcms\Component\Requests\Exception\HTTP;

/**
 * Exception for 503 Service Unavailable responses
 *
 * @package Requests
 */

/**
 * Exception for 503 Service Unavailable responses
 *
 * @package Requests
 */
class C503 extends HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer
	 */
	protected $code = 503;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = 'Service Unavailable';
}