<?php namespace Royalcms\Component\Queue;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Queue\Console\RetryCommand;
use Royalcms\Component\Queue\Console\ListFailedCommand;
use Royalcms\Component\Queue\Console\FlushFailedCommand;
use Royalcms\Component\Queue\Console\FailedTableCommand;
use Royalcms\Component\Queue\Console\ForgetFailedCommand;

class FailConsoleServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bindShared('command.queue.failed', function($app)
		{
			return new ListFailedCommand;
		});

		$this->app->bindShared('command.queue.retry', function($app)
		{
			return new RetryCommand;
		});

		$this->app->bindShared('command.queue.forget', function($app)
		{
			return new ForgetFailedCommand;
		});

		$this->app->bindShared('command.queue.flush', function($app)
		{
			return new FlushFailedCommand;
		});

		$this->app->bindShared('command.queue.failed-table', function($app)
		{
			return new FailedTableCommand($app['files']);
		});

		$this->commands(
			'command.queue.failed', 'command.queue.retry', 'command.queue.forget',
			'command.queue.flush', 'command.queue.failed-table'
		);
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array(
			'command.queue.failed', 'command.queue.retry', 'command.queue.forget', 'command.queue.flush', 'command.queue.failed-table',
		);
	}

}
