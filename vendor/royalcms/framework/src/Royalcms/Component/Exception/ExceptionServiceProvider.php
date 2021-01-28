<?php

namespace Royalcms\Component\Exception;

use Royalcms\Component\Exception\Displayers\DefaultDisplayer;
use Royalcms\Component\Exception\Displayers\PlainDisplayer;
use Royalcms\Component\Exception\Displayers\WhoopsDisplayer;
use Whoops\Run;
use Whoops\Handler\JsonResponseHandler;
use Royalcms\Component\Support\ServiceProvider;

class ExceptionServiceProvider extends ServiceProvider
{

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerDisplayers();

		$this->registerHandler();
	}

	/**
	 * Register the exception displayers.
	 *
	 * @return void
	 */
	protected function registerDisplayers()
	{
		$this->registerPlainDisplayer();

		$this->registerDebugDisplayer();

		$this->registerDefaultDisplayer();
	}

	/**
	 * Register the exception handler instance.
	 *
	 * @return void
	 */
	protected function registerHandler()
	{
		$this->royalcms->singleton('exception', function($royalcms) {
			return new HandlerExceptions($royalcms);
		});

        $this->royalcms->singleton('exception.handler', function($royalcms) {
            return new CustomHandlers();
        });

        $this->royalcms->singleton('exception.display', function($royalcms) {
            return new HandleDisplayExceptions($royalcms['exception.plain'], $royalcms['exception.debug']);
        });

        $this->royalcms->alias('Royalcms\Component\Contracts\Debug\ExceptionHandler', 'Illuminate\Contracts\Debug\ExceptionHandler');

	}

    /**
     * Register the plain exception displayer.
     *
     * @return void
     */
    protected function registerDefaultDisplayer()
    {
        $this->royalcms->singleton('exception.default', function($royalcms) {
            return new DefaultDisplayer();
        });
    }

	/**
	 * Register the plain exception displayer.
	 *
	 * @return void
	 */
	protected function registerPlainDisplayer()
	{
		$this->royalcms->singleton('exception.plain', function($royalcms) {
			// If the application is running in a console environment, we will just always
			// use the debug handler as there is no point in the console ever returning
			// out HTML. This debug handler always returns JSON from the console env.
			if ($royalcms->runningInConsole())
			{
				return $royalcms['exception.debug'];
			}
			else
			{
				return new PlainDisplayer();
			}
		});
	}

	/**
	 * Register the Whoops exception displayer.
	 *
	 * @return void
	 */
	protected function registerDebugDisplayer()
	{
		$this->royalcms->singleton('exception.debug', function($royalcms) {
			return new WhoopsDisplayer($royalcms, $royalcms->runningInConsole());
		});
	}

    /**
     * Get a list of files that should be compiled for the package.
     *
     * @return array
     */
    public static function compiles()
    {
        $dir = __DIR__;

        return [
            $dir . '/Exceptions/CompileErrorException.php',
            $dir . '/Exceptions/CompileWarningException.php',
            $dir . '/Exceptions/CoreErrorException.php',
            $dir . '/Exceptions/CoreWarningException.php',
            $dir . '/Exceptions/DeprecatedException.php',
            $dir . '/Exceptions/NoticeException.php',
            $dir . '/Exceptions/ParseException.php',
            $dir . '/Exceptions/RecoverableErrorException.php',
            $dir . '/Exceptions/StrictException.php',
            $dir . '/Exceptions/UnknownException.php',
            $dir . '/Exceptions/UserDeprecatedException.php',
            $dir . '/Exceptions/UserErrorException.php',
            $dir . '/Exceptions/UserNoticeException.php',
            $dir . '/Exceptions/WarningException.php',
            $dir . '/Handler.php',
            $dir . '/PrettyPageHandler.php',
            $dir . '/ExceptionDisplayerInterface.php',
            $dir . '/Displayers/SymfonyDisplayer.php',
            $dir . '/Displayers/PlainDisplayer.php',
            $dir . '/Displayers/WhoopsDisplayer.php',
            $dir . '/Displayers/DefaultDisplayer.php',
            $dir . '/HandleDisplayExceptions.php',
            $dir . '/HandlerExceptions.php',
        ];
    }

}
