<?php

namespace Royalcms\Component\Requests\Transport\HTTP;

use Royalcms\Component\Requests\Exception\HTTP;

/**
 * Exception for 502 Bad Gateway responses
 *
 * @package Requests
 */

/**
 * Exception for 502 Bad Gateway responses
 *
 * @package Requests
 */
class C502 extends HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer
	 */
	protected $code = 502;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = 'Bad Gateway';
}