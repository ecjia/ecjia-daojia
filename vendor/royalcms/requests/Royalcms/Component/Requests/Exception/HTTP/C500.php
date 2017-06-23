<?php

namespace Royalcms\Component\Requests\Transport\HTTP;

use Royalcms\Component\Requests\Exception\HTTP;

/**
 * Exception for 500 Internal Server Error responses
 *
 * @package Requests
 */

/**
 * Exception for 500 Internal Server Error responses
 *
 * @package Requests
 */
class C500 extends HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer
	 */
	protected $code = 500;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = 'Internal Server Error';
}