<?php

namespace Royalcms\Component\Requests\Transport\HTTP;

use Royalcms\Component\Requests\Exception\HTTP;

/**
 * Exception for 407 Proxy Authentication Required responses
 *
 * @package Requests
 */

/**
 * Exception for 407 Proxy Authentication Required responses
 *
 * @package Requests
 */
class C407 extends HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer
	 */
	protected $code = 407;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = 'Proxy Authentication Required';
}