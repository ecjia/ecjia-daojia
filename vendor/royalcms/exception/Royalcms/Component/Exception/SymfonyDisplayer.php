<?php

namespace Royalcms\Component\Exception;

use Exception;
use Symfony\Component\Debug\ExceptionHandler;

class SymfonyDisplayer implements ExceptionDisplayerInterface
{

	/**
	 * The Symfony exception handler.
	 *
	 * @var \Symfony\Component\Debug\ExceptionHandler
	 */
	protected $symfony;

	/**
	 * Create a new Symfony exception displayer.
	 *
	 * @param  \Symfony\Component\Debug\ExceptionHandler  $symfony
	 * @return void
	 */
	public function __construct(ExceptionHandler $symfony)
	{
		$this->symfony = $symfony;
	}

	/**
	 * Display the given exception to the user.
	 *
	 * @param  \Throwable  $exception
	 */
	public function display($exception)
	{
		$this->symfony->handle($exception);
	}

}
