<?php

namespace Royalcms\Component\Requests\Transport\HTTP;

use Royalcms\Component\Requests\Exception\HTTP;
use Royalcms\Component\Requests\Response;

/**
 * Exception for unknown status responses
 *
 * @package Requests
 */

/**
 * Exception for unknown status responses
 *
 * @package Requests
 */
class Unknown extends HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer|bool Code if available, false if an error occurred
	 */
	protected $code = 0;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = 'Unknown';

	/**
	 * Create a new exception
	 *
	 * If `$data` is an instance of {@see Requests_Response}, uses the status
	 * code from it. Otherwise, sets as 0
	 *
	 * @param string|null $reason Reason phrase
	 * @param mixed $data Associated data
	 */
	public function __construct($reason = null, $data = null) {
		if ($data instanceof Response) {
			$this->code = $data->status_code;
		}

		parent::__construct($reason, $data);
	}
}