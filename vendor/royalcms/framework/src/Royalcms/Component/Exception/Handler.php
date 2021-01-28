<?php

namespace Royalcms\Component\Exception;

use Exception;
use Throwable;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Exceptions\WhoopsHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Exceptions\Handler as LaravelExceptionHandler;
use Psr\Log\LoggerInterface;
use Royalcms\Component\Http\Response;
use Royalcms\Component\Auth\Access\UnauthorizedException;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;
use Royalcms\Component\Contracts\Debug\ExceptionHandler as ExceptionHandlerContract;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use ReflectionFunction;
use Closure;
use Whoops\Handler\HandlerInterface;
use Whoops\Run as Whoops;

class Handler extends LaravelExceptionHandler implements ExceptionHandlerContract
{

    /**
     * A list of the internal exception types that should not be reported.
     *
     * @var array
     */
    protected $internalDontReport = [];


    /**
     * Render an exception into a response.
     *
     * @param  \Royalcms\Component\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Royalcms\Component\Http\Response
     */
    public function render($request, Throwable $e)
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
     * @param  \Throwable  $e
     * @return \Royalcms\Component\Http\Response
     */
    protected function toRoyalcmsResponse($response, Throwable $e)
    {
        $response = new Response($response->getContent(), $response->getStatusCode(), $response->headers->all());

        $response->exception = $e;

        return $response;
    }

    /**
     * Render an exception to the console.
     *
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @param  \Throwable  $e
     * @return void
     */
    public function renderForConsole($output, Throwable $e)
    {
        (new ConsoleApplication)->renderThrowable($e, $output);
    }

    /**
     * Render the given HttpException.
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderHttpException(HttpExceptionInterface $e)
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
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertExceptionToResponse(Throwable $e)
    {
        $royalcms = royalcms();

        // If one of the custom error handlers returned a response, we will send that
        // response back to the client after preparing it. This allows a specific
        // type of exceptions to handled by a Closure giving great flexibility.
        if ($royalcms->has('exception.handler')) {
            $response = $royalcms['exception.handler']->handleException($e);
            if ( ! is_null($response)) {
                return $response;
            }
        }

        return SymfonyResponse::create(
            $this->renderExceptionContent($e),
            $this->isHttpException($e) ? $e->getStatusCode() : 500,
            $this->isHttpException($e) ? $e->getHeaders() : []
        );
    }

    /**
     * Get the response content for the given exception.
     *
     * @param  \Throwable  $e
     * @return string
     */
    protected function renderExceptionContent(Throwable $e)
    {
        try {

            ob_end_clean();

            $royalcms = royalcms();
            
            // If one of the custom error handlers returned a response, we will send that
            // response back to the client after preparing it. This allows a specific
            // type of exceptions to handled by a Closure giving great flexibility.
            if ($royalcms->has('exception.display')) {
                return $royalcms['exception.display']->displayException($e);
            }

            return config('system.debug') && class_exists(Whoops::class)
                ? $this->renderExceptionWithWhoops($e)
                : $this->renderExceptionWithSymfony($e, config('system.debug'));
        } catch (Exception $e) {
            return $this->renderExceptionWithSymfony($e, config('system.debug'));
        }
    }

    /**
     * Render an exception to a string using "Whoops".
     *
     * @param  \Throwable  $e
     * @return string
     */
    protected function renderExceptionWithWhoops(Throwable $e)
    {
        return tap(new Whoops, function ($whoops) {
            $whoops->appendHandler($this->whoopsHandler());

            $whoops->writeToOutput(false);

            $whoops->allowQuit(false);
        })->handleException($e);
    }

    /**
     * Get the Whoops handler for the application.
     *
     * @return \Whoops\Handler\Handler
     */
    protected function whoopsHandler()
    {
        try {
            return royalcms(HandlerInterface::class);
        } catch (BindingResolutionException $e) {
            return (new WhoopsHandler)->forDebug();
        }
    }

    /**
     * Render an exception to a string using Symfony.
     *
     * @param  \Throwable  $e
     * @param  bool  $debug
     * @return string
     */
    protected function renderExceptionWithSymfony(Throwable $e, $debug)
    {
        return (new SymfonyExceptionHandler($debug))->getHtml(
            FlattenException::create($e)
        );
    }

    /**
     * Determine if the given exception is an access unauthorized exception.
     *
     * @param  \Throwable  $e
     * @return bool
     */
    protected function isUnauthorizedException(Throwable $e)
    {
        return $e instanceof UnauthorizedException;
    }

}
