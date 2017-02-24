<?php namespace Royalcms\Component\Foundation\Providers;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Foundation\Publisher\ViewPublisher;
use Royalcms\Component\Foundation\Publisher\AssetPublisher;
use Royalcms\Component\Foundation\Publisher\ConfigPublisher;
use Royalcms\Component\Foundation\Publisher\MigrationPublisher;
use Royalcms\Component\Foundation\Console\ViewPublishCommand;
use Royalcms\Component\Foundation\Console\AssetPublishCommand;
use Royalcms\Component\Foundation\Console\ConfigPublishCommand;
use Royalcms\Component\Foundation\Console\MigratePublishCommand;

class PublisherServiceProvider extends ServiceProvider {

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
		$this->registerAssetPublisher();

		$this->registerConfigPublisher();

		$this->registerViewPublisher();

		$this->registerMigrationPublisher();

		$this->commands(
			'command.asset.publish', 'command.config.publish',
			'command.view.publish', 'command.migrate.publish'
		);
	}

	/**
	 * Register the asset publisher service and command.
	 *
	 * @return void
	 */
	protected function registerAssetPublisher()
	{
		$this->registerAssetPublishCommand();

		$this->royalcms->bindShared('asset.publisher', function($royalcms)
		{
			$publicPath = $royalcms['path.base'];

			// The asset "publisher" is responsible for moving package's assets into the
			// web accessible public directory of an application so they can actually
			// be served to the browser. Otherwise, they would be locked in vendor.
			$publisher = new AssetPublisher($royalcms['files'], $publicPath);

			$publisher->setPackagePath($royalcms['path.base'].'/vendor');

			return $publisher;
		});
	}

	/**
	 * Register the asset publish console command.
	 *
	 * @return void
	 */
	protected function registerAssetPublishCommand()
	{
		$this->royalcms->bindShared('command.asset.publish', function($royalcms)
		{
			return new AssetPublishCommand($royalcms['asset.publisher']);
		});
	}

	/**
	 * Register the configuration publisher class and command.
	 *
	 * @return void
	 */
	protected function registerConfigPublisher()
	{
		$this->registerConfigPublishCommand();

		$this->royalcms->bindShared('config.publisher', function($royalcms)
		{
			$path = $royalcms['path'].'/config';

			// Once we have created the configuration publisher, we will set the default
			// package path on the object so that it knows where to find the packages
			// that are installed for the application and can move them to the app.
			$publisher = new ConfigPublisher($royalcms['files'], $path);

			$publisher->setPackagePath($royalcms['path.base'].'/vendor');

			return $publisher;
		});
	}

	/**
	 * Register the configuration publish console command.
	 *
	 * @return void
	 */
	protected function registerConfigPublishCommand()
	{
		$this->royalcms->bindShared('command.config.publish', function($royalcms)
		{
			return new ConfigPublishCommand($royalcms['config.publisher']);
		});
	}

	/**
	 * Register the view publisher class and command.
	 *
	 * @return void
	 */
	protected function registerViewPublisher()
	{
		$this->registerViewPublishCommand();

		$this->royalcms->bindShared('view.publisher', function($royalcms)
		{
			$viewPath = $royalcms['path'].'/views';

			// Once we have created the view publisher, we will set the default packages
			// path on this object so that it knows where to find all of the packages
			// that are installed for the application and can move them to the app.
			$publisher = new ViewPublisher($royalcms['files'], $viewPath);

			$publisher->setPackagePath($royalcms['path.base'].'/vendor');

			return $publisher;
		});
	}

	/**
	 * Register the view publish console command.
	 *
	 * @return void
	 */
	protected function registerViewPublishCommand()
	{
		$this->royalcms->bindShared('command.view.publish', function($royalcms)
		{
			return new ViewPublishCommand($royalcms['view.publisher']);
		});
	}

	/**
	 * Register the migration publisher class and command.
	 *
	 * @return void
	 */
	protected function registerMigrationPublisher()
	{
		$this->registerMigratePublishCommand();

		$this->royalcms->bindShared('migration.publisher', function($royalcms)
		{
			return new MigrationPublisher($royalcms['files']);
		});
	}

	/**
	 * Register the migration publisher command.
	 *
	 * @return void
	 */
	protected function registerMigratePublishCommand()
	{
		$this->royalcms->bindShared('command.migrate.publish', function($royalcms)
		{
			return new MigratePublishCommand; 
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array(
			'asset.publisher',
			'command.asset.publish',
			'config.publisher',
			'command.config.publish',
			'view.publisher',
			'command.view.publish',
			'migration.publisher',
			'command.migrate.publish',
		);
	}

}
