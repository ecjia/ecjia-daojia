<?php

namespace Royalcms\Component\Exception;

use Exception;
use Psr\Log\LoggerInterface;
use Royalcms\Component\Http\Response;
use Royalcms\Component\Auth\Access\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;
use Royalcms\Component\Contracts\Debug\ExceptionHandler as ExceptionHandlerContract;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use ReflectionFunction;
use Closure;

class Handler implements ExceptionHandlerContract
{
    /**
     * The log implementation.
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $log;

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [];

    /**
     * All of the register exception handlers.
     *
     * @var array
     */
    protected $handlers = [];

    /**
     * Create a new exception handler instance.
     *
     * @param  \Psr\Log\LoggerInterface  $log
     * @return void
     */
    public function __construct(LoggerInterface $log)
    {
        $this->log = $log;
    }

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        if ($this->shouldReport($e)) {
            $this->log->error($e);
        }
    }

    /**
     * Determine if the exception should be reported.
     *
     * @param  \Exception  $e
     * @return bool
     */
    public function shouldReport(Exception $e)
    {
        return ! $this->shouldntReport($e);
    }

    /**
     * Determine if the exception is in the "do not report" list.
     *
     * @param  \Exception  $e
     * @return bool
     */
    protected function shouldntReport(Exception $e)
    {
        foreach ($this->dontReport as $type) {
            if ($e instanceof $type) {
                return true;
            }
        }

        return false;
    }

    /**
     * Render an exception into a response.
     *
     * @param  \Royalcms\Component\Http\Request  $request
     * @param  \Exception  $e
     * @return \Royalcms\Component\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($this->isUnauthorizedException($e)) {
            $e = new HttpException(403, $e->getMessage());
        }

        if ($this->isHttpException($e)) {
            return $this->toRoyalcmsResponse($this->renderHttpException($e), $e);
        } else {
            return $this->toRoyalcmsResponse($this->convertExceptionToResponse($e), $e);
        }
    }

    /**
     * Map exception into an Royalcms response.
     *
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     * @param  \Exception  $e
     * @return \Royalcms\Component\Http\Response
     */
    protected function toRoyalcmsResponse($response, Exception $e)
    {
        $response = new Response($response->getContent(), $response->getStatusCode(), $response->headers->all());

        $response->exception = $e;

        return $response;
    }

    /**
     * Render an exception to the console.
     *
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @param  \Exception  $e
     * @return void
     */
    public function renderForConsole($output, Exception $e)
    {
        (new ConsoleApplication)->renderException($e, $output);
    }

    /**
     * Render the given HttpException.
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpException  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderHttpException(HttpException $e)
    {
        $status = $e->getStatusCode();

        if (view()->exists("errors.{$status}")) {
            return response()->view("errors.{$status}", ['exception' => $e], $status);
        }
        else {
            return $this->convertExceptionToResponse($e);
        }
    }

    /**
     * Convert the given exception into a Response instance.
     *
     * @param  \Exception  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertExceptionToResponse(Exception $e)
    {
        $royalcms = royalcms();

        $response = $this->callCustomHandlers($e);

        // If one of the custom error handlers returned a response, we will send that
        // response back to the client after preparing it. This allows a specific
        // type of exceptions to handled by a Closure giving great flexibility.
        if ( ! is_null($response))
        {
            return $response;
        }

        if (isset($royalcms['exception.display'])) {
            return $royalcms['exception.display']->displayException($e);
        } else {
            return (new SymfonyExceptionHandler(config('system.debug')))->createResponse($e);
        }
    }

    /**
     * Determine if the given exception is an access unauthorized exception.
     *
     * @param  \Exception  $e
     * @return bool
     */
    protected function isUnauthorizedException(Exception $e)
    {
        return $e instanceof UnauthorizedException;
    }

    /**
     * Determine if the given exception is an HTTP exception.
     *
     * @param  \Exception  $e
     * @return bool
     */
    protected function isHttpException(Exception $e)
    {
        return $e instanceof HttpException;
    }

    /**
     * Register an application error handler.
     *
     * @todo royalcms
     * @param  Closure  $callback
     * @return void
     */
    public function error(Closure $callback)
    {
        array_unshift($this->handlers, $callback);
    }

    /**
     * Register an application error handler at the bottom of the stack.
     *
     * @todo royalcms
     * @param  Closure  $callback
     * @return void
     */
    public function pushError(Closure $callback)
    {
        $this->handlers[] = $callback;
    }

    /**
     * Handle the given exception.
     *
     * @param  \Exception  $exception
     * @param  bool  $fromConsole
     * @return void
     */
    protected function callCustomHandlers($exception, $fromConsole = false)
    {
        foreach ($this->handlers as $handler)
        {
            // If this exception handler does not handle the given exception, we will just
            // go the next one. A handler may type-hint an exception that it handles so
            //  we can have more granularity on the error handling for the developer.
            if ( ! $this->handlesException($handler, $exception))
            {
                continue;
            }
            elseif ($exception instanceof HttpExceptionInterface)
            {
                $code = $exception->getStatusCode();
            }

            // If the exception doesn't implement the HttpExceptionInterface, we will just
            // use the generic 500 error code for a server side error. If it implements
            // the HttpException interfaces we'll grab the error code from the class.
            else
            {
                $code = 500;
            }

            // We will wrap this handler in a try / catch and avoid white screens of death
            // if any exceptions are thrown from a handler itself. This way we will get
            // at least some errors, and avoid errors with no data or not log writes.
            try
            {
                $response = $handler($exception, $code, $fromConsole);

            }
            catch (\Exception $e)
            {
                $response = $this->formatException($e);
            }

            // If this handler returns a "non-null" response, we will return it so it will
            // get sent back to the browsers. Once the handler returns a valid response
            // we will cease iterating through them and calling these other handlers.
            if (isset($response) && ! is_null($response))
            {
                return $response;
            }
        }
    }

    /**
     * Determine if the given handler handles this exception.
     *
     * @param  Closure    $handler
     * @param  \Exception  $exception
     * @return bool
     */
    protected function handlesException(Closure $handler, $exception)
    {
        $reflection = new ReflectionFunction($handler);

        return $reflection->getNumberOfParameters() == 0 || $this->hints($reflection, $exception);
    }

    /**
     * Determine if the given handler type hints the exception.
     *
     * @param  ReflectionFunction  $reflection
     * @param  \Exception  $exception
     * @return bool
     */
    protected function hints(ReflectionFunction $reflection, $exception)
    {
        $parameters = $reflection->getParameters();

        $expected = $parameters[0];

        return ! $expected->getClass() || $expected->getClass()->isInstance($exception);
    }

    /**
     * Format an exception thrown by a handler.
     *
     * @param  \Exception  $e
     * @return string
     */
    protected function formatException(\Exception $e)
    {
        if (config('system.debug'))
        {
            $location = $e->getMessage().' in '.$e->getFile().':'.$e->getLine();

            return 'Error in exception handler: '.$location;
        }

        return 'Error in exception handler.';
    }

    /**
     * Handle a console exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function handleConsole($exception)
    {
        return $this->callCustomHandlers($exception, true);
    }
}
