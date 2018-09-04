<?php

namespace Royalcms\Component\Database;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Database\Migrations\Migrator;
use Royalcms\Component\Database\Migrations\MigrationCreator;
use Royalcms\Component\Database\Console\Migrations\ResetCommand;
use Royalcms\Component\Database\Console\Migrations\RefreshCommand;
use Royalcms\Component\Database\Console\Migrations\InstallCommand;
use Royalcms\Component\Database\Console\Migrations\MigrateCommand;
use Royalcms\Component\Database\Console\Migrations\RollbackCommand;
use Royalcms\Component\Database\Console\Migrations\MigrateMakeCommand;
use Royalcms\Component\Database\Console\Migrations\StatusCommand;
use Royalcms\Component\Database\Migrations\DatabaseMigrationRepository;

class MigrationServiceProvider extends ServiceProvider
{
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
        $this->registerRepository();

        // Once we have registered the migrator instance we will go ahead and register
        // all of the migration related commands that are used by the "Artisan" CLI
        // so that they may be easily accessed for registering with the consoles.
        $this->registerMigrator();

        $this->registerCommands();
    }

    /**
     * Register the migration repository service.
     *
     * @return void
     */
    protected function registerRepository()
    {
        $this->royalcms->singleton('migration.repository', function ($royalcms) {
            $table = $royalcms['config']['database.migrations'];

            return new DatabaseMigrationRepository($royalcms['db'], $table);
        });
    }

    /**
     * Register the migrator service.
     *
     * @return void
     */
    protected function registerMigrator()
    {
        // The migrator is responsible for actually running and rollback the migration
        // files in the application. We'll pass in our database connection resolver
        // so the migrator can resolve any of these connections when it needs to.
        $this->royalcms->singleton('migrator', function ($royalcms) {
            $repository = $royalcms['migration.repository'];

            return new Migrator($repository, $royalcms['db'], $royalcms['files']);
        });
    }

    /**
     * Register all of the migration commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        $commands = ['Migrate', 'Rollback', 'Reset', 'Refresh', 'Install', 'Make', 'Status'];

        // We'll simply spin through the list of commands that are migration related
        // and register each one of them with an application container. They will
        // be resolved in the Artisan start file and registered on the console.
        foreach ($commands as $command) {
            $this->{'register'.$command.'Command'}();
        }

        // Once the commands are registered in the application IoC container we will
        // register them with the Artisan start event so that these are available
        // when the Artisan application actually starts up and is getting used.
        $this->commands(
            'command.migrate', 'command.migrate.make',
            'command.migrate.install', 'command.migrate.rollback',
            'command.migrate.reset', 'command.migrate.refresh',
            'command.migrate.status'
        );
    }

    /**
     * Register the "migrate" migration command.
     *
     * @return void
     */
    protected function registerMigrateCommand()
    {
        $this->royalcms->singleton('command.migrate', function ($royalcms) {
            return new MigrateCommand($royalcms['migrator']);
        });
    }

    /**
     * Register the "rollback" migration command.
     *
     * @return void
     */
    protected function registerRollbackCommand()
    {
        $this->royalcms->singleton('command.migrate.rollback', function ($royalcms) {
            return new RollbackCommand($royalcms['migrator']);
        });
    }

    /**
     * Register the "reset" migration command.
     *
     * @return void
     */
    protected function registerResetCommand()
    {
        $this->royalcms->singleton('command.migrate.reset', function ($royalcms) {
            return new ResetCommand($royalcms['migrator']);
        });
    }

    /**
     * Register the "refresh" migration command.
     *
     * @return void
     */
    protected function registerRefreshCommand()
    {
        $this->royalcms->singleton('command.migrate.refresh', function () {
            return new RefreshCommand;
        });
    }

    /**
     * Register the "status" migration command.
     *
     * @return void
     */
    protected function registerStatusCommand()
    {
        $this->royalcms->singleton('command.migrate.status', function ($royalcms) {
            return new StatusCommand($royalcms['migrator']);
        });
    }

    /**
     * Register the "install" migration command.
     *
     * @return void
     */
    protected function registerInstallCommand()
    {
        $this->royalcms->singleton('command.migrate.install', function ($royalcms) {
            return new InstallCommand($royalcms['migration.repository']);
        });
    }

    /**
     * Register the "make" migration command.
     *
     * @return void
     */
    protected function registerMakeCommand()
    {
        $this->registerCreator();

        $this->royalcms->singleton('command.migrate.make', function ($royalcms) {
            // Once we have the migration creator registered, we will create the command
            // and inject the creator. The creator is responsible for the actual file
            // creation of the migrations, and may be extended by these developers.
            $creator = $royalcms['migration.creator'];

            $composer = $royalcms['composer'];

            return new MigrateMakeCommand($creator, $composer);
        });
    }

    /**
     * Register the migration creator.
     *
     * @return void
     */
    protected function registerCreator()
    {
        $this->royalcms->singleton('migration.creator', function ($royalcms) {
            return new MigrationCreator($royalcms['files']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'migrator', 'migration.repository', 'command.migrate',
            'command.migrate.rollback', 'command.migrate.reset',
            'command.migrate.refresh', 'command.migrate.install',
            'command.migrate.status', 'migration.creator',
            'command.migrate.make',
        ];
    }
}
