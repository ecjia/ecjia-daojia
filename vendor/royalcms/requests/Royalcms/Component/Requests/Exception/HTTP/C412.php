<?php

namespace Royalcms\Component\Requests\Transport\HTTP;

use Royalcms\Component\Requests\Exception\HTTP;

/**
 * Exception for 412 Precondition Failed responses
 *
 * @package Requests
 */

/**
 * Exception for 412 Precondition Failed responses
 *
 * @package Requests
 */
class C412 extends HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer
	 */
	protected $code = 412;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = 'Precondition Failed';
}