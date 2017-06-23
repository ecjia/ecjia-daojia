<?php

namespace Royalcms\Component\Requests\Transport\HTTP;

use Royalcms\Component\Requests\Exception\HTTP;

/**
 * Exception for 305 Use Proxy responses
 *
 * @package Requests
 */

/**
 * Exception for 305 Use Proxy responses
 *
 * @package Requests
 */
class C305 extends HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer
	 */
	protected $code = 305;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = 'Use Proxy';
}
