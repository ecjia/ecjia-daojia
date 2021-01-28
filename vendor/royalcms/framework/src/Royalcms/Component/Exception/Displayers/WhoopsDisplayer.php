<?php

namespace Royalcms\Component\Exception\Displayers;

use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Royalcms\Component\Exception\ExceptionDisplayerInterface;
use Royalcms\Component\Exception\PrettyPageHandler;
use Royalcms\Component\Support\ServiceProvider;
use Whoops\Handler\HandlerInterface;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Run as Whoops;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Royalcms\Component\Contracts\Foundation\Royalcms;

class WhoopsDisplayer implements ExceptionDisplayerInterface
{

    /**
     * The application instance.
     *
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected $royalcms;

	/**
	 * Indicates if the application is in a console environment.
	 *
	 * @var bool
	 */
	protected $runningInConsole;

	/**
	 * Create a new Whoops exception displayer.
	 *
	 * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
	 * @param  bool  $runningInConsole
	 * @return void
	 */
	public function __construct(Royalcms $royalcms, $runningInConsole)
	{
		$this->royalcms = $royalcms;
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
		$whoops = $this->registerWhoops();

		return $whoops->handleException($exception);
	}

    /**
     * Register the Whoops error display service.
     *
     * @return void
     */
    protected function registerWhoops()
    {
        return tap(new Whoops, function ($whoops) {
            // We will instruct Whoops to not exit after it displays the exception as it
            // will otherwise run out before we can do anything else. We just want to
            // let the framework go ahead and finish a request on this end instead.
            $whoops->allowQuit(false);

            $whoops->writeToOutput(false);

            return $whoops->pushHandler($this->whoopsHandler());
        });
    }

    /**
     * Register the Whoops handler for the request.
     *
     * @return void
     */
    protected function registerWhoopsHandler()
    {
        if ($this->shouldReturnJson())
        {
            return new JsonResponseHandler;
        }
        else
        {
            return $this->registerPrettyWhoopsHandler();
        }
    }

    /**
     * Register the "pretty" Whoops handler.
     *
     * @return void
     */
    protected function registerPrettyWhoopsHandler()
    {
        ($handler = new PrettyPageHandler)->setEditor('sublime');

        // If the resource path exists, we will register the resource path with Whoops
        // so our custom Laravel branded exception pages will be used when they are
        // displayed back to the developer. Otherwise, the default pages are run.
        if ( ! is_null($path = $this->resourcePath()))
        {
            $handler->setResourcesPath($path);
        }

        return $handler;
    }

    /**
     * Determine if the error provider should return JSON.
     *
     * @return bool
     */
    protected function shouldReturnJson()
    {
        return $this->royalcms->runningInConsole() || $this->requestWantsJson();
    }

    /**
     * Determine if the request warrants a JSON response.
     *
     * @return bool
     */
    protected function requestWantsJson()
    {
        return $this->royalcms['request']->ajax() || $this->royalcms['request']->wantsJson();
    }

    /**
     * Get the resource path for Whoops.
     *
     * @return string
     */
    public function resourcePath()
    {
        if (is_dir($path = $this->getResourcePath())) return $path;
    }

    /**
     * Get the Whoops custom resource path.
     *
     * @return string
     */
    protected function getResourcePath()
    {
        $dir = __DIR__ . '/../';

        return $dir . '/resources';
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
            return $this->registerWhoopsHandler();
        }
    }

}
