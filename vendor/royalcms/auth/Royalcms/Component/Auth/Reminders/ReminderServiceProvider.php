<?php namespace Royalcms\Component\Auth\Reminders;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Auth\Console\RemindersTableCommand;
use Royalcms\Component\Auth\Console\ClearRemindersCommand;
use Royalcms\Component\Auth\Console\RemindersControllerCommand;
use Royalcms\Component\Auth\Reminders\DatabaseReminderRepository as DbRepository;

class ReminderServiceProvider extends ServiceProvider {

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
		$this->registerPasswordBroker();

		$this->registerReminderRepository();

		$this->registerCommands();
	}

	/**
	 * Register the password broker instance.
	 *
	 * @return void
	 */
	protected function registerPasswordBroker()
	{
		$this->royalcms->bindShared('auth.reminder', function($royalcms)
		{
			// The reminder repository is responsible for storing the user e-mail addresses
			// and password reset tokens. It will be used to verify the tokens are valid
			// for the given e-mail addresses. We will resolve an implementation here.
			$reminders = $royalcms['auth.reminder.repository'];

			$users = $royalcms['auth']->driver()->getProvider();

			$view = $royalcms['config']['auth.reminder.email'];

			// The password broker uses the reminder repository to validate tokens and send
			// reminder e-mails, as well as validating that password reset process as an
			// aggregate service of sorts providing a convenient interface for resets.
			return new PasswordBroker(

				$reminders, $users, $royalcms['mailer'], $view

			);
		});
	}

	/**
	 * Register the reminder repository implementation.
	 *
	 * @return void
	 */
	protected function registerReminderRepository()
	{
		$this->royalcms->bindShared('auth.reminder.repository', function($royalcms)
		{
			$connection = $royalcms['db']->connection();

			// The database reminder repository is an implementation of the reminder repo
			// interface, and is responsible for the actual storing of auth tokens and
			// their e-mail addresses. We will inject this table and hash key to it.
			$table = $royalcms['config']['auth.reminder.table'];

			$key = $royalcms['config']['system.auth_key'];

			$expire = $royalcms['config']->get('auth.reminder.expire', 60);

			return new DbRepository($connection, $table, $key, $expire);
		});
	}

	/**
	 * Register the auth related console commands.
	 *
	 * @return void
	 */
	protected function registerCommands()
	{
		$this->royalcms->bindShared('command.auth.reminders', function($royalcms)
		{
			return new RemindersTableCommand($royalcms['files']);
		});

		$this->royalcms->bindShared('command.auth.reminders.clear', function($royalcms)
		{
			return new ClearRemindersCommand;
		});

		$this->royalcms->bindShared('command.auth.reminders.controller', function($royalcms)
		{
			return new RemindersControllerCommand($royalcms['files']);
		});

		$this->commands(
			'command.auth.reminders', 'command.auth.reminders.clear', 'command.auth.reminders.controller'
		);
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('auth.reminder', 'auth.reminder.repository', 'command.auth.reminders');
	}

}
