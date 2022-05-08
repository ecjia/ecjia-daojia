<?php

<<<<<<< HEAD
namespace Royalcms\Component\Requests\Transport\HTTP;
=======
namespace Royalcms\Component\Requests\Exception\HTTP;
>>>>>>> v2-test

use Royalcms\Component\Requests\Exception\HTTP;

/**
 * Exception for 511 Network Authentication Required responses
 *
 * @see https://tools.ietf.org/html/rfc6585
 * @package Requests
 */

/**
 * Exception for 511 Network Authentication Required responses
 *
 * @see https://tools.ietf.org/html/rfc6585
 * @package Requests
 */
class C511 extends HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer
	 */
	protected $code = 511;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = 'Network Authentication Required';
}