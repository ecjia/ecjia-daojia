<?php

namespace Royalcms\Component\Exception;

use Exception;
use Royalcms\Component\Whoops\Run;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class WhoopsDisplayer implements ExceptionDisplayerInterface
{
 
	/**
	 * The Whoops run instance.
	 *
	 * @var \Royalcms\Component\Whoops\Run
	 */
	protected $whoops;

	/**
	 * Indicates if the application is in a console environment.
	 *
	 * @var bool
	 */
	protected $runningInConsole;

	/**
	 * Create a new Whoops exception displayer.
	 *
	 * @param  \Royalcms\Component\Whoops\Run  $whoops
	 * @param  bool  $runningInConsole
	 * @return void
	 */
	public function __construct(Run $whoops, $runningInConsole)
	{
		$this->whoops = $whoops;
		$this->runningInConsole = $runningInConsole;
	}

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

		return new Response($this->whoops->handleException($exception), $status, $headers);
	}

}
