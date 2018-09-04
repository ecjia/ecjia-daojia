<?php namespace Royalcms\Component\DbExporter;

use Royalcms\Component\Support\ServiceProvider;

class DbExportHandlerServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * @var DbMigrations $migrator
     */
    protected $migrator;

    /**
     * @var DbSeeding $seeder
     */
    protected $seeder;
    /**
     * @var DbExportHandler $handler
     */
    protected $handler;

    public function boot()
    {
        //
    }

    public function register()
    {
        // Load the classes
        $this->loadClasses();

        // Register the base export handler class
        $this->registerDbExportHandler();

        // Handle the artisan commands
        $this->registerCommands();

        // Load the alias
        $this->loadAlias();

        // Default config
        $this->royalcms['config']->package('royalcms/db-exporter', __DIR__ . '/Config');
    }

    /**
     * Load to classes
     */
    protected function loadClasses()
    {
        // Instatiate a new DbMigrations class to send to the handler
        $this->migrator = new DbMigrations($this->getDatabaseName());

        // Instatiate a new DbSeeding class to send to the handler
        $this->seeder = new DbSeeding($this->getDatabaseName());

        // Instantiate the handler
        $this->handler = new DbExportHandler($this->migrator, $this->seeder);
    }

    /**
     * Get the database name from the app/config/database.php file
     * @return String
     */
    private function getDatabaseName()
    {
        $connType = $this->royalcms['config']->get('database.default');
        $database = $this->royalcms['config']->get('database.connections.' .$connType );

        return $database['database'];
    }

    public function provides()
    {
        return array('DbExportHandler');
    }

    /**
     * Register the needed commands
     */
    public function registerCommands()
    {
        $this->registerMigrationsCommand();
        $this->registerSeedsCommand();
        $this->registerRemoteCommand();
        $this->commands(
            'dbe::migrations',
            'dbe::seeds',
            'dbe::remote'
        );
    }

    /**
     * Register the migrations command
     */
    protected function registerMigrationsCommand()
    {
        $handler = $this->handler;
        
        $this->royalcms['dbe::migrations'] = $this->royalcms->share(function() use ($handler)
        {
            return new Commands\MigrationsGeneratorCommand($handler);
        });
    }

    /**
     * Register the seeds command
     */
    protected function registerSeedsCommand()
    {
        $handler = $this->handler;
        
        $this->royalcms['dbe::seeds'] = $this->royalcms->share(function() use ($handler)
        {
            return new Commands\SeedGeneratorCommand($handler);
        });
    }

    protected function registerRemoteCommand()
    {
        $this->royalcms['dbe::remote'] = $this->royalcms->share(function()
        {
            return new Commands\CopyToRemoteCommand(new Server);
        });
    }

    /**
     * Register the Export handler class
     */
    protected function registerDbExportHandler()
    {
        $handler = $this->handler;
        
        $this->royalcms['DbExportHandler'] = $this->royalcms->share(function() use ($handler)
        {
            return $this->handler;
        });
    }

    /**
     * Load the alias = One less install step for the user
     */
    protected function loadAlias()
    {
        $this->royalcms->booting(function()
        {
            $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();
            $loader->alias('DbExportHandler', 'Royalcms\Component\DbExporter\Facades\DbExportHandler');
        });
    }

}
