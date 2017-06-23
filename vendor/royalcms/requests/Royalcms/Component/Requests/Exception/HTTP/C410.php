<?php

namespace Royalcms\Component\Requests\Transport\HTTP;

use Royalcms\Component\Requests\Exception\HTTP;

/**
 * Exception for 410 Gone responses
 *
 * @package Requests
 */

/**
 * Exception for 410 Gone responses
 *
 * @package Requests
 */
class C410 extends HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer
	 */
	protected $code = 410;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = 'Gone';
}