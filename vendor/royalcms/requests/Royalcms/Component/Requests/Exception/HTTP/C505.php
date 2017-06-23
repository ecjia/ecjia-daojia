<?php

namespace Royalcms\Component\Requests\Transport\HTTP;

use Royalcms\Component\Requests\Exception\HTTP;

/**
 * Exception for 505 HTTP Version Not Supported responses
 *
 * @package Requests
 */

/**
 * Exception for 505 HTTP Version Not Supported responses
 *
 * @package Requests
 */
class C505 extends HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer
	 */
	protected $code = 505;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = 'HTTP Version Not Supported';
}