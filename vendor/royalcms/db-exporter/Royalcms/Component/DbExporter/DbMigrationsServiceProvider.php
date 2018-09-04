<?php namespace Royalcms\Component\DbExporter;

use Royalcms\Component\Support\ServiceProvider;

class DbMigrationsServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->royalcms['DbMigrations'] = $this->royalcms->share(function()
        {
            $connType = $this->royalcms['config']->get('database.default');
            $database = $this->royalcms['config']->get('database.connections.' .$connType );
            return new DbMigrations($database);
        });

        $this->royalcms->booting(function()
            {
                $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();
                $loader->alias('DbMigrations', 'Royalcms\Component\DbExporter\Facades\DbMigrations');
            });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('DbMigrations');
    }

}
