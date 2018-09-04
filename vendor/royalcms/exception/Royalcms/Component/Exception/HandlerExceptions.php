<?php

namespace Royalcms\Component\Exception;

use Exception;
use ErrorException;
use RC_Hook;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\Console\Output\ConsoleOutput;
use Royalcms\Component\Contracts\Foundation\Royalcms;
use Royalcms\Component\Exception\Exceptions\CompileErrorException;
use Royalcms\Component\Exception\Exceptions\CompileWarningException;
use Royalcms\Component\Exception\Exceptions\CoreErrorException;
use Royalcms\Component\Exception\Exceptions\CoreWarningException;
use Royalcms\Component\Exception\Exceptions\DeprecatedException;
use Royalcms\Component\Exception\Exceptions\NoticeException;
use Royalcms\Component\Exception\Exceptions\ParseException;
use Royalcms\Component\Exception\Exceptions\RecoverableErrorException;
use Royalcms\Component\Exception\Exceptions\StrictException;
use Royalcms\Component\Exception\Exceptions\UnknownException;
use Royalcms\Component\Exception\Exceptions\UserDeprecatedException;
use Royalcms\Component\Exception\Exceptions\UserErrorException;
use Royalcms\Component\Exception\Exceptions\UserNoticeException;
use Royalcms\Component\Exception\Exceptions\UserWarningException;
use Royalcms\Component\Exception\Exceptions\WarningException;

class HandlerExceptions
{
    /**
     * The application instance.
     *
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected $royalcms;

	/**
	 * Create a new error handler instance.
	 *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
	 * @return void
	 */
	public function __construct(Royalcms $royalcms)
	{
        $this->royalcms = $royalcms;
	}

	/**
	 * Register the exception / error handlers for the application.
	 *
	 * @param  string  $environment
	 * @return void
	 */
	public function register($environment)
	{
		$this->registerErrorHandler();

		$this->registerExceptionHandler();

		if ($environment != 'testing') {
            ini_set('display_errors', 'Off');

		    $this->registerShutdownHandler();
        }
	}

	/**
	 * Register the PHP error handler.
	 *
	 * @return void
	 */
	protected function registerErrorHandler()
	{
		set_error_handler(array($this, 'handleError'));
	}

	/**
	 * Register the PHP exception handler.
	 *
	 * @return void
	 */
	protected function registerExceptionHandler()
	{
		set_exception_handler(array($this, 'handleUncaughtException'));
	}

	/**
	 * Register the PHP shutdown handler.
	 *
	 * @return void
	 */
	protected function registerShutdownHandler()
	{
		register_shutdown_function(array($this, 'handleShutdown'));
	}

	/**
	 * Handle a PHP error for the application.
	 *
	 * @param  int     $level
	 * @param  string  $message
	 * @param  string  $file
	 * @param  int     $line
	 * @param  array   $context
	 *
	 * @throws \ErrorException
	 */
	public function handleError($level, $message, $file = '', $line = 0, $context = [])
	{
		if (error_reporting() & $level)
		{
		    $exception = null;
		    
		    switch ($level) {
		    	case E_ERROR:               throw new ErrorException($message, 0, $level, $file, $line); break;
		    	case E_USER_ERROR:          throw new UserErrorException($message, 0, $level, $file, $line); break;
		    	case E_PARSE:               throw new ParseException($message, 0, $level, $file, $line); break;
		    	case E_CORE_ERROR:          throw new CoreErrorException($message, 0, $level, $file, $line); break;
		    	case E_CORE_WARNING:        throw new CoreWarningException($message, 0, $level, $file, $line); break;
		    	case E_COMPILE_ERROR:       throw new CompileErrorException($message, 0, $level, $file, $line); break;
		    	case E_COMPILE_WARNING:     throw new CompileWarningException($message, 0, $level, $file, $line); break;
		    	case E_STRICT:              throw new StrictException($message, 0, $level, $file, $line); break;
		    	case E_RECOVERABLE_ERROR:   throw new RecoverableErrorException($message, 0, $level, $file, $line); break;
		    	
		    	case E_WARNING:             $exception = new WarningException($message, 0, $level, $file, $line); break;
		    	case E_USER_WARNING:        $exception = new UserWarningException($message, 0, $level, $file, $line); break;
		    	case E_NOTICE:              $exception = new NoticeException($message, 0, $level, $file, $line); break;
		    	case E_USER_NOTICE:         $exception = new UserNoticeException($message, 0, $level, $file, $line); break;
		    	case E_DEPRECATED:          $exception = new DeprecatedException($message, 0, $level, $file, $line); break;
		    	case E_USER_DEPRECATED:     $exception = new UserDeprecatedException($message, 0, $level, $file, $line); break;
		    	default:                    $exception = new UnknownException($message, 0, $level, $file, $line); break;
		    }
		    
		    if ($exception instanceof ErrorException) {
                royalcms('events')->fire('royalcms.warning.exception', array($exception));
		    }
		}
	}

	/**
	 * Handle an exception for the application.
	 *
	 * @param  \Exception  $exception
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function handleException($exception)
	{
        if (! $exception instanceof Exception) {
            $exception = new FatalThrowableError($exception);
        }

        $this->getExceptionHandler()->report($exception);

        if ($this->royalcms->runningInConsole()) {
            $this->renderForConsole($exception);
        } else {
            $this->renderHttpResponse($exception);
        }
	}

	/**
	 * Handle an uncaught exception.
	 *
	 * @param  \Exception  $exception
	 * @return void
	 */
	public function handleUncaughtException($exception)
	{
	    $this->handleException($exception)->send(); 
	}

	/**
	 * Handle the PHP shutdown event.
	 *
	 * @return void
	 */
	public function handleShutdown()
	{
		$error = error_get_last();

		// If an error has occurred that has not been displayed, we will create a fatal
		// error exception instance and pass it into the regular exception handling
		// code so it can be displayed back out to the developer for information.
        if ( ! is_null($error))
        {
            if ( ! $this->isFatal($error['type'])) {
                return;
            }

            $this->handleException($this->fatalExceptionFromError($error, 0));
        }

		/**
		 * Fires just before PHP shuts down execution.
		 *
		 * @since 1.2.0
		 */
        RC_Hook::do_action( 'shutdown' );
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
     * @param  int   $type
     * @return bool
     */
    protected function isFatal($type)
    {
        return in_array($type, array(E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE));
    }

    /**
     * Render an exception to the console.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function renderForConsole($e)
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
     * Get an instance of the exception handler.
     *
     * @return \Royalcms\Component\Contracts\Debug\ExceptionHandler
     */
    protected function getExceptionHandler()
    {
        return $this->royalcms->make('Royalcms\Component\Contracts\Debug\ExceptionHandler');
    }

}

