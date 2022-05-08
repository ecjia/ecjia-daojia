<?php

<<<<<<< HEAD
namespace Royalcms\Component\Requests\Transport\HTTP;
=======
namespace Royalcms\Component\Requests\Exception\HTTP;
>>>>>>> v2-test

use Royalcms\Component\Requests\Exception\HTTP;

/**
 * Exception for 504 Gateway Timeout responses
 *
 * @package Requests
 */

/**
 * Exception for 504 Gateway Timeout responses
 *
 * @package Requests
 */
class C504 extends HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer
	 */
	protected $code = 504;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = 'Gateway Timeout';
}