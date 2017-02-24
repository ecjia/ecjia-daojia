<?php namespace Royalcms\Component\Database;

use Royalcms\Component\Database\Eloquent\Model;
use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Database\Connectors\ConnectionFactory;

class DatabaseServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		Model::setConnectionResolver($this->royalcms['db']);

		Model::setEventDispatcher($this->royalcms['events']);
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// The connection factory is used to create the actual connection instances on
		// the database. We will inject the factory into the manager so that it may
		// make the connections while they are actually needed and not of before.
		$this->royalcms->bindShared('db.factory', function($royalcms)
		{
			return new ConnectionFactory($royalcms);
		});

		// The database manager is used to resolve various connections, since multiple
		// connections might be managed. It also implements the connection resolver
		// interface which may be used by other components requiring connections.
		$this->royalcms->bindShared('db', function($royalcms)
		{
			return new DatabaseManager($royalcms, $royalcms['db.factory']);
		});
	}

}
