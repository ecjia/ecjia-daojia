<?php

<<<<<<< HEAD
namespace Royalcms\Component\Requests\Transport\HTTP;
=======
namespace Royalcms\Component\Requests\Exception\HTTP;
>>>>>>> v2-test

use Royalcms\Component\Requests\Exception\HTTP;

/**
 * Exception for 304 Not Modified responses
 *
 * @package Requests
 */

/**
 * Exception for 304 Not Modified responses
 *
 * @package Requests
 */
class C304 extends HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer
	 */
	protected $code = 304;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = 'Not Modified';
}