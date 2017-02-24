<?php namespace Royalcms\Component\Foundation\Bootstrap;

use ErrorException;
use Royalcms\Component\Foundation\Contracts\Royalcms;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Debug\Exception\FatalErrorException;

class HandleExceptions {

	/**
	 * The royalcms instance.
	 *
	 * @var \Royalcms\Component\Foundation\Contracts\Royalcms
	 */
	protected $royalcms;

	/**
	 * Bootstrap the given royalcms.
	 *
	 * @param  \Royalcms\Component\Foundation\Contracts\Royalcms  $royalcms
	 * @return void
	 */
	public function bootstrap(Royalcms $royalcms)
	{
		$this->royalcms = $royalcms;

		error_reporting(-1);

		set_error_handler(array($this, 'handleError'));

		set_exception_handler(array($this, 'handleException'));

		register_shutdown_function(array($this, 'handleShutdown'));

		if ( ! $royalcms->environment('testing'))
		{
			ini_set('display_errors', 'Off');
		}
	}

	/**
	 * Convert a PHP error to an ErrorException.
	 *
	 * @param  int  $level
	 * @param  string  $message
	 * @param  string  $file
	 * @param  int  $line
	 * @param  array  $context
	 * @return void
	 *
	 * @throws \ErrorException
	 */
	public function handleError($level, $message, $file = '', $line = 0, $context = array())
	{
		if (error_reporting() & $level)
		{
			throw new ErrorException($message, 0, $level, $file, $line);
		}
	}

	/**
	 * Handle an uncaught exception from the application.
	 *
	 * Note: Most exceptions can be handled via the try / catch block in
	 * the HTTP and Console kernels. But, fatal error exceptions must
	 * be handled differently since they are not normal exceptions.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function handleException($e)
	{
		$this->getExceptionHandler()->report($e);

		if ($this->royalcms->runningInConsole())
		{
			$this->renderForConsole($e);
		}
		else
		{
			$this->renderHttpResponse($e);
		}
	}

	/**
	 * Render an exception to the console.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	protected function renderForConsole($e)
	{
		$this->getExceptionHandler()->renderForConsole(new ConsoleOutput, $e);
	}

	/**
	 * Render an exception as an HTTP response and send it.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	protected function renderHttpResponse($e)
	{
		$this->getExceptionHandler()->render($this->royalcms['request'], $e)->send();
	}

	/**
	 * Handle the PHP shutdown event.
	 *
	 * @return void
	 */
	public function handleShutdown()
	{
		if ( ! is_null($error = error_get_last()) && $this->isFatal($error['type']))
		{
			$this->handleException($this->fatalExceptionFromError($error, 0));
		}
	}

	/**
	 * Create a new fatal exception instance from an error array.
	 *
	 * @param  array  $error
	 * @param  int|null  $traceOffset
	 * @return \Symfony\Component\Debug\Exception\FatalErrorException
	 */
	protected function fatalExceptionFromError(array $error, $traceOffset = null)
	{
		return new FatalErrorException(
			$error['message'], $error['type'], 0, $error['file'], $error['line'], $traceOffset
		);
	}

	/**
	 * Determine if the error type is fatal.
	 *
	 * @param  int  $type
	 * @return bool
	 */
	protected function isFatal($type)
	{
		return in_array($type, [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE]);
	}

	/**
	 * Get an instance of the exception handler.
	 *
	 * @return \Royalcms\Component\Exception\Contracts\ExceptionHandler
	 */
	protected function getExceptionHandler()
	{
		return $this->royalcms->make('Royalcms\Component\Exception\Contracts\ExceptionHandler');
	}

}
