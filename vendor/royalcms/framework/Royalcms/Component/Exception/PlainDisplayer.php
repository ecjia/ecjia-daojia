<?php

namespace Royalcms\Component\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class PlainDisplayer implements ExceptionDisplayerInterface
{

	/**
	 * Display the given exception to the user.
	 *
	 * @param  \Throwable  $exception
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function display($exception)
	{
		$status = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : 500;

		$headers = $exception instanceof HttpExceptionInterface ? $exception->getHeaders() : array();

		//$content = file_get_contents(__DIR__.'/resources/plain.php');
		include __DIR__.'/resources/plain.php'; 

		return new Response(null, $status, $headers);
	}

}
