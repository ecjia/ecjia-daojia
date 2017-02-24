<?php namespace Royalcms\Component\Foundation\Bootstrap;

use Royalcms\Component\Log\Writer;
use Monolog\Logger as Monolog;
use Royalcms\Component\Foundation\Contracts\Royalcms;

class ConfigureLogging {

	/**
	 * Bootstrap the given application.
	 *
	 * @param  \Royalcms\Component\Foundation\Contracts\Royalcms  $royalcms
	 * @return void
	 */
	public function bootstrap(Royalcms $royalcms)
	{
		$this->configureHandlers($royalcms, $this->registerLogger($royalcms));

		// Next, we will bind a Closure that resolves the PSR logger implementation
		// as this will grant us the ability to be interoperable with many other
		// libraries which are able to utilize the PSR standardized interface.
		$royalcms->bind('Psr\Log\LoggerInterface', function($royalcms)
		{
			return $royalcms['log']->getMonolog();
		});
	}

	/**
	 * Register the logger instance in the container.
	 *
	 * @param  \Royalcms\Component\Foundation\Contracts\Royalcms  $royalcms
	 * @return \Royalcms\Component\Log\Writer
	 */
	protected function registerLogger(Royalcms $royalcms)
	{
		$royalcms->instance('log', $log = new Writer(
			new Monolog($royalcms->environment()), $royalcms['events'])
		);

		return $log;
	}

	/**
	 * Configure the Monolog handlers for the application.
	 *
	 * @param  \Royalcms\Component\Foundation\Contracts\Royalcms  $royalcms
	 * @param  \Royalcms\Component\Log\Writer  $log
	 * @return void
	 */
	protected function configureHandlers(Royalcms $royalcms, Writer $log)
	{
		$method = "configure".ucfirst($royalcms['config']['system.log'])."Handler";

		$this->{$method}($royalcms, $log);
	}

	/**
	 * Configure the Monolog handlers for the application.
	 *
	 * @param  \Royalcms\Component\Foundation\Contracts\Royalcms  $royalcms
	 * @param  \Royalcms\Component\Log\Writer  $log
	 * @return void
	 */
	protected function configureSingleHandler(Royalcms $royalcms, Writer $log)
	{
		$log->useFiles($royalcms->storagePath().'/logs/royalcms.log');
	}

	/**
	 * Configure the Monolog handlers for the application.
	 *
	 * @param  \Royalcms\Component\Foundation\Contracts\Royalcms  $royalcms
	 * @param  \Royalcms\Component\Log\Writer  $log
	 * @return void
	 */
	protected function configureDailyHandler(Royalcms $royalcms, Writer $log)
	{
		$log->useDailyFiles(
			$royalcms->storagePath().'/logs/royalcms.log',
			$royalcms->make('config')->get('system.log_max_files', 5)
		);
	}

	/**
	 * Configure the Monolog handlers for the application.
	 *
	 * @param  \Royalcms\Component\Foundation\Contracts\Royalcms  $royalcms
	 * @param  \Royalcms\Component\Log\Writer  $log
	 * @return void
	 */
	protected function configureSyslogHandler(Royalcms $royalcms, Writer $log)
	{
		$log->useSyslog('laravel');
	}

	/**
	 * Configure the Monolog handlers for the application.
	 *
	 * @param  \Royalcms\Component\Foundation\Contracts\Royalcms  $royalcms
	 * @param  \Royalcms\Component\Log\Writer  $log
	 * @return void
	 */
	protected function configureErrorlogHandler(Royalcms $royalcms, Writer $log)
	{
		$log->useErrorLog();
	}

}
