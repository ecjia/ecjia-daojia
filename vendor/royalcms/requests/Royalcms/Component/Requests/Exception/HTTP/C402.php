<?php

<<<<<<< HEAD
namespace Royalcms\Component\Requests\Transport\HTTP;
=======
namespace Royalcms\Component\Requests\Exception\HTTP;
>>>>>>> v2-test

use Royalcms\Component\Requests\Exception\HTTP;

/**
 * Exception for 402 Payment Required responses
 *
 * @package Requests
 */

/**
 * Exception for 402 Payment Required responses
 *
 * @package Requests
 */
class C402 extends HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer
	 */
	protected $code = 402;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = 'Payment Required';
}