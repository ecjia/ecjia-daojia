<?php

namespace Royalcms\Component\Requests\Transport\HTTP;

use Royalcms\Component\Requests\Exception\HTTP;

/**
 * Exception for 406 Not Acceptable responses
 *
 * @package Requests
 */

/**
 * Exception for 406 Not Acceptable responses
 *
 * @package Requests
 */
class C406 extends HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer
	 */
	protected $code = 406;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = 'Not Acceptable';
}