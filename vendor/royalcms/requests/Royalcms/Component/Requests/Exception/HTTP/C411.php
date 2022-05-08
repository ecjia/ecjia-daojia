<?php

<<<<<<< HEAD
namespace Royalcms\Component\Requests\Transport\HTTP;
=======
namespace Royalcms\Component\Requests\Exception\HTTP;
>>>>>>> v2-test

use Royalcms\Component\Requests\Exception\HTTP;

/**
 * Exception for 411 Length Required responses
 *
 * @package Requests
 */

/**
 * Exception for 411 Length Required responses
 *
 * @package Requests
 */
class C411 extends HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer
	 */
	protected $code = 411;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = 'Length Required';
}