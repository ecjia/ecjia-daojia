<?php

namespace Ecjia\Kernel\Exceptions;

use Throwable;
use Royalcms\Component\Exception\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Throwable  $e
	 * @return void
     *
     * @throws \Throwable
	 */
	public function report(Throwable $e)
	{
		parent::report($e);
	}

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Royalcms\Component\Http\Request $request
     * @param \Throwable $e
     * @return \Royalcms\Component\Http\Response
     *
     * @throws Throwable
     */
	public function render($request, Throwable $e)
	{
		return parent::render($request, $e);
	}



}
