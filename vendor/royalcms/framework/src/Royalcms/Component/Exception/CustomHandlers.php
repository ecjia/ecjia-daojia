<?php


namespace Royalcms\Component\Exception;

use Closure;
use Exception;
use Throwable;
use ReflectionFunction;
use ReflectionMethod;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class CustomHandlers
{

    /**
     * All of the register exception handlers.
     *
     * @var array
     */
    protected $handlers = [];

    /**
     * Get the response content for the given exception.
     *
     * @param  \Throwable  $e
     * @return string
     */
    public function handleException(Throwable $e)
    {
        return $this->callCustomHandlers($e);
    }

    /**
     * Handle a console exception.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function handleConsole(Throwable $exception)
    {
        return $this->callCustomHandlers($exception, true);
    }

    /**
     * Handle the given exception.
     *
     * @param  \Throwable  $exception
     * @param  bool  $fromConsole
     * @return void
     */
    protected function callCustomHandlers(Throwable $exception, $fromConsole = false)
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
     * @param  \Throwable  $exception
     * @return bool
     */
    protected function handlesException($handler, Throwable $exception)
    {
        if ($handler instanceof Closure) {
            $reflection = new ReflectionFunction($handler);
        }
        elseif ($handler instanceof ExceptionRenderInterface) {
            $reflection = new ReflectionMethod($handler, '__invoke');
        }

        return $reflection->getNumberOfParameters() == 0 || $this->hints($reflection, $exception);
    }

    /**
     * Determine if the given handler type hints the exception.
     *
     * @param  ReflectionFunction  $reflection
     * @param  \Throwable  $exception
     * @return bool
     */
    protected function hints($reflection, Throwable $exception)
    {
        if ($reflection instanceof ReflectionFunction) {
            $parameters = $reflection->getParameters();
        }
        elseif ($reflection instanceof ReflectionMethod) {
            $parameters = $reflection->getParameters();
        }

        $expected = $parameters[0];

        return ! $expected->getClass() || $expected->getClass()->isInstance($exception);
    }

    /**
     * Format an exception thrown by a handler.
     *
     * @param  \Throwable  $e
     * @return string
     */
    protected function formatException(Throwable $e)
    {
        if (config('system.debug'))
        {
            $location = $e->getMessage().' in '.$e->getFile().':'.$e->getLine();

            return 'Error in exception handler: '.$location;
        }

        return 'Error in exception handler.';
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
     * Register an application error handler.
     *
     * @todo royalcms
     * @param  Closure  $callback
     * @return void
     */
    public function errorRender(ExceptionRenderInterface $callback)
    {
        array_unshift($this->handlers, $callback);
    }

}