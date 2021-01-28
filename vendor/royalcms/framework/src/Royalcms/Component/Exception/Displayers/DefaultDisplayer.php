<?php


namespace Royalcms\Component\Exception\Displayers;

use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Exceptions\WhoopsHandler;
use Royalcms\Component\Exception\ExceptionDisplayerInterface;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Whoops\Handler\HandlerInterface;
use Whoops\Run as Whoops;

class DefaultDisplayer implements ExceptionDisplayerInterface
{

    /**
     * Display the given exception to the user.
     *
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function display($exception)
    {
        return $this->renderExceptionContent($exception);
    }

    /**
     * Get the response content for the given exception.
     *
     * @param  \Exception  $e
     * @return string
     */
    protected function renderExceptionContent(Exception $e)
    {
        return config('system.debug') && class_exists(Whoops::class)
            ? $this->renderExceptionWithWhoops($e)
            : $this->renderExceptionWithSymfony($e, config('system.debug'));
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
     * Render an exception to a string using "Whoops".
     *
     * @param  \Exception  $e
     * @return string
     */
    protected function renderExceptionWithWhoops(Exception $e)
    {
        return tap(new Whoops, function ($whoops) {
            $whoops->appendHandler($this->whoopsHandler());

            $whoops->writeToOutput(false);

            $whoops->allowQuit(false);
        })->handleException($e);
    }

    /**
     * Render an exception to a string using Symfony.
     *
     * @param  \Exception  $e
     * @param  bool  $debug
     * @return string
     */
    protected function renderExceptionWithSymfony(Exception $e, $debug)
    {
        return (new SymfonyExceptionHandler($debug))->getHtml(
            FlattenException::create($e)
        );
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
    
}