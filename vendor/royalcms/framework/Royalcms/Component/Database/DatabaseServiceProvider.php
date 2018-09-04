<?php

namespace Royalcms\Component\Database;

use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;
use Royalcms\Component\Database\Eloquent\Model;
use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Database\Eloquent\QueueEntityResolver;
use Royalcms\Component\Database\Connectors\ConnectionFactory;
use Royalcms\Component\Database\Eloquent\Factory as EloquentFactory;

class DatabaseServiceProvider extends ServiceProvider
{
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
        Model::clearBootedModels();

        $this->registerEloquentFactory();

        $this->registerQueueableEntityResolver();

        // The connection factory is used to create the actual connection instances on
        // the database. We will inject the factory into the manager so that it may
        // make the connections while they are actually needed and not of before.
        $this->royalcms->singleton('db.factory', function ($royalcms) {
            return new ConnectionFactory($royalcms);
        });

        // The database manager is used to resolve various connections, since multiple
        // connections might be managed. It also implements the connection resolver
        // interface which may be used by other components requiring connections.
        $this->royalcms->singleton('db', function ($royalcms) {
            return new DatabaseManager($royalcms, $royalcms['db.factory']);
        });

        $this->royalcms->bind('db.connection', function ($royalcms) {
            return $royalcms['db']->connection();
        });
    }

    /**
     * Register the Eloquent factory instance in the container.
     *
     * @return void
     */
    protected function registerEloquentFactory()
    {
        $this->royalcms->singleton(FakerGenerator::class, function () {
            return FakerFactory::create();
        });

        $this->royalcms->singleton(EloquentFactory::class, function ($royalcms) {
            $faker = $royalcms->make(FakerGenerator::class);

            return EloquentFactory::construct($faker, database_path('factories'));
        });
    }

    /**
     * Register the queueable entity resolver implementation.
     *
     * @return void
     */
    protected function registerQueueableEntityResolver()
    {
        $this->royalcms->singleton('Royalcms\Component\Contracts\Queue\EntityResolver', function () {
            return new QueueEntityResolver;
        });
    }

    /**
     * Get a list of files that should be compiled for the package.
     *
     * @return array
     */
    public static function compiles()
    {
        return [
            __DIR__ . "/DatabaseServiceProvider.php",
            __DIR__ . "/Eloquent/Model.php",
            __DIR__ . "/DatabaseManager.php",
            __DIR__ . "/ConnectionResolverInterface.php",
            __DIR__ . "/Connectors/Connector.php",
            __DIR__ . "/Connectors/ConnectionFactory.php",
            __DIR__ . "/Connectors/ConnectorInterface.php",
            __DIR__ . "/DetectsLostConnections.php",
            __DIR__ . "/Connection.php",
            __DIR__ . "/ConnectionInterface.php",
            __DIR__ . "/Grammar.php",
            __DIR__ . "/Query/Processors/MySqlProcessor.php",
            __DIR__ . "/Query/Processors/Processor.php",
            __DIR__ . "/Connectors/MySqlConnector.php",
            __DIR__ . "/MySqlConnection.php",
            __DIR__ . "/Query/Grammars/MySqlGrammar.php",
            __DIR__ . "/Query/Grammars/Grammar.php",
        ];
    }
}
