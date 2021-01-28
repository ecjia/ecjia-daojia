<?php

namespace Royalcms\Component\Database;

use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\DatabaseServiceProvider as LaravelDatabaseServiceProvider;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Queue\EntityResolver;
use Illuminate\Database\Eloquent\QueueEntityResolver;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Royalcms\Component\Database\Connectors\ConnectionFactory;

class DatabaseServiceProvider extends LaravelDatabaseServiceProvider
{
    /**
     * The application instance.
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected $royalcms;

    /**
     * Create a new service provider instance.
     * @param \Royalcms\Component\Contracts\Foundation\Royalcms $royalcms
     * @return void
     */
    public function __construct($royalcms)
    {
        parent::__construct($royalcms);

        $this->royalcms = $royalcms;
    }

    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->loadAlias();

        parent::register();
    }

    /**
     * Register the primary database bindings.
     * @return void
     */
    protected function registerConnectionServices()
    {
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
     * Load the alias = One less install step for the user
     */
    protected function loadAlias()
    {
        $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();

        foreach (self::aliases() as $class => $alias) {
            $loader->alias($class, $alias);
        }
    }

    /**
     * Load the alias = One less install step for the user
     */
    public static function aliases()
    {

        return [
            'Royalcms\Component\Database\Capsule\Manager'                         => 'Illuminate\Database\Capsule\Manager',
            'Royalcms\Component\Database\Connection'                              => 'Illuminate\Database\Connection',
            'Royalcms\Component\Database\ConnectionInterface'                     => 'Illuminate\Database\ConnectionInterface',
            'Royalcms\Component\Database\ConnectionResolver'                      => 'Illuminate\Database\ConnectionResolver',
            'Royalcms\Component\Database\ConnectionResolverInterface'             => 'Illuminate\Database\ConnectionResolverInterface',
            'Royalcms\Component\Database\Connectors\Connector'                    => 'Illuminate\Database\Connectors\Connector',
            'Royalcms\Component\Database\Connectors\ConnectorInterface'           => 'Illuminate\Database\Connectors\ConnectorInterface',
            'Royalcms\Component\Database\Connectors\MySqlConnector'               => 'Illuminate\Database\Connectors\MySqlConnector',
            'Royalcms\Component\Database\Connectors\PostgresConnector'            => 'Illuminate\Database\Connectors\PostgresConnector',
            'Royalcms\Component\Database\Connectors\SQLiteConnector'              => 'Illuminate\Database\Connectors\SQLiteConnector',
            'Royalcms\Component\Database\Connectors\SqlServerConnector'           => 'Illuminate\Database\Connectors\SqlServerConnector',
            'Royalcms\Component\Database\Console\Migrations\BaseCommand'          => 'Illuminate\Database\Console\Migrations\BaseCommand',
            'Royalcms\Component\Database\Console\Migrations\InstallCommand'       => 'Illuminate\Database\Console\Migrations\InstallCommand',
            'Royalcms\Component\Database\Console\Migrations\MigrateCommand'       => 'Illuminate\Database\Console\Migrations\MigrateCommand',
            'Royalcms\Component\Database\Console\Migrations\MigrateMakeCommand'   => 'Illuminate\Database\Console\Migrations\MigrateMakeCommand',
            'Royalcms\Component\Database\Console\Migrations\RefreshCommand'       => 'Illuminate\Database\Console\Migrations\RefreshCommand',
            'Royalcms\Component\Database\Console\Migrations\ResetCommand'         => 'Illuminate\Database\Console\Migrations\ResetCommand',
            'Royalcms\Component\Database\Console\Migrations\RollbackCommand'      => 'Illuminate\Database\Console\Migrations\RollbackCommand',
            'Royalcms\Component\Database\Console\Migrations\StatusCommand'        => 'Illuminate\Database\Console\Migrations\StatusCommand',
            'Royalcms\Component\Database\Console\Seeds\SeedCommand'               => 'Illuminate\Database\Console\Seeds\SeedCommand',
            'Royalcms\Component\Database\Console\Seeds\StatusCommand'             => 'Illuminate\Database\Console\Seeds\SeederMakeCommand',
            'Royalcms\Component\Database\DatabaseManager'                         => 'Illuminate\Database\DatabaseManager',
            'Royalcms\Component\Database\DetectsLostConnections'                  => 'Illuminate\Database\DetectsLostConnections',
            'Royalcms\Component\Database\Eloquent\Factory'                        => 'Illuminate\Database\Eloquent\Factory',
            'Royalcms\Component\Database\Eloquent\FactoryBuilder'                 => 'Illuminate\Database\Eloquent\FactoryBuilder',
            'Royalcms\Component\Database\Eloquent\MassAssignmentException'        => 'Illuminate\Database\Eloquent\MassAssignmentException',
            'Royalcms\Component\Database\Eloquent\ModelNotFoundException'         => 'Illuminate\Database\Eloquent\ModelNotFoundException',
            'Royalcms\Component\Database\Eloquent\QueueEntityResolver'            => 'Illuminate\Database\Eloquent\QueueEntityResolver',
            'Royalcms\Component\Database\Eloquent\Relations\BelongsTo'            => 'Illuminate\Database\Eloquent\Relations\BelongsTo',
            'Royalcms\Component\Database\Eloquent\Relations\BelongsToMany'        => 'Illuminate\Database\Eloquent\Relations\BelongsToMany',
            'Royalcms\Component\Database\Eloquent\Relations\HasMany'              => 'Illuminate\Database\Eloquent\Relations\HasMany',
            'Royalcms\Component\Database\Eloquent\Relations\HasManyThrough'       => 'Illuminate\Database\Eloquent\Relations\HasManyThrough',
            'Royalcms\Component\Database\Eloquent\Relations\HasOne'               => 'Illuminate\Database\Eloquent\Relations\HasOne',
            'Royalcms\Component\Database\Eloquent\Relations\HasOneOrMany'         => 'Illuminate\Database\Eloquent\Relations\HasOneOrMany',
            'Royalcms\Component\Database\Eloquent\Relations\MorphMany'            => 'Illuminate\Database\Eloquent\Relations\MorphMany',
            'Royalcms\Component\Database\Eloquent\Relations\MorphOne'             => 'Illuminate\Database\Eloquent\Relations\MorphOne',
            'Royalcms\Component\Database\Eloquent\Relations\MorphOneOrMany'       => 'Illuminate\Database\Eloquent\Relations\MorphOneOrMany',
            'Royalcms\Component\Database\Eloquent\Relations\MorphPivot'           => 'Illuminate\Database\Eloquent\Relations\MorphPivot',
            'Royalcms\Component\Database\Eloquent\Relations\MorphTo'              => 'Illuminate\Database\Eloquent\Relations\MorphTo',
            'Royalcms\Component\Database\Eloquent\Relations\MorphToMany'          => 'Illuminate\Database\Eloquent\Relations\MorphToMany',
            'Royalcms\Component\Database\Eloquent\Relations\Pivot'                => 'Illuminate\Database\Eloquent\Relations\Pivot',
            'Royalcms\Component\Database\Eloquent\Relations\Relation'             => 'Illuminate\Database\Eloquent\Relations\Relation',
            'Royalcms\Component\Database\Eloquent\SoftDeletes'                    => 'Illuminate\Database\Eloquent\SoftDeletes',
            'Royalcms\Component\Database\Eloquent\SoftDeletingScope'              => 'Illuminate\Database\Eloquent\SoftDeletingScope',
            'Royalcms\Component\Database\MigrationServiceProvider'                => 'Illuminate\Database\MigrationServiceProvider',
            'Royalcms\Component\Database\Migrations\DatabaseMigrationRepository'  => 'Illuminate\Database\Migrations\DatabaseMigrationRepository',
            'Royalcms\Component\Database\Migrations\Migration'                    => 'Illuminate\Database\Migrations\Migration',
            'Royalcms\Component\Database\Migrations\MigrationCreator'             => 'Illuminate\Database\Migrations\MigrationCreator',
            'Royalcms\Component\Database\Migrations\MigrationRepositoryInterface' => 'Illuminate\Database\Migrations\MigrationRepositoryInterface',
            'Royalcms\Component\Database\Migrations\Migrator'                     => 'Illuminate\Database\Migrations\Migrator',
            'Royalcms\Component\Database\PostgresConnection'                      => 'Illuminate\Database\PostgresConnection',
            'Royalcms\Component\Database\QueryException'                          => 'Illuminate\Database\QueryException',
            'Royalcms\Component\Database\Query\Expression'                        => 'Illuminate\Database\Query\Expression',
            'Royalcms\Component\Database\Query\Grammars\Grammar'                  => 'Illuminate\Database\Query\Grammars\Grammar',
            'Royalcms\Component\Database\Query\Grammars\PostgresGrammar'          => 'Illuminate\Database\Query\Grammars\PostgresGrammar',
            'Royalcms\Component\Database\Query\Grammars\SQLiteGrammar'            => 'Illuminate\Database\Query\Grammars\SQLiteGrammar',
            'Royalcms\Component\Database\Query\Grammars\SqlServerGrammar'         => 'Illuminate\Database\Query\Grammars\SqlServerGrammar',
            'Royalcms\Component\Database\Query\JoinClause'                        => 'Illuminate\Database\Query\JoinClause',
            'Royalcms\Component\Database\Query\Processors\MySqlProcessor'         => 'Illuminate\Database\Query\Processors\MySqlProcessor',
            'Royalcms\Component\Database\Query\Processors\PostgresProcessor'      => 'Illuminate\Database\Query\Processors\PostgresProcessor',
            'Royalcms\Component\Database\Query\Processors\Processor'              => 'Illuminate\Database\Query\Processors\Processor',
            'Royalcms\Component\Database\Query\Processors\SQLiteProcessor'        => 'Illuminate\Database\Query\Processors\SQLiteProcessor',
            'Royalcms\Component\Database\Query\Processors\SqlServerProcessor'     => 'Illuminate\Database\Query\Processors\SqlServerProcessor',
            'Royalcms\Component\Database\SQLiteConnection'                        => 'Illuminate\Database\SQLiteConnection',
//            'Royalcms\Component\Database\Schema\Blueprint'                        => 'Illuminate\Database\Schema\Blueprint',
            'Royalcms\Component\Database\Schema\Builder'                          => 'Illuminate\Database\Schema\Builder',
            'Royalcms\Component\Database\Schema\Grammars\Grammar'                 => 'Illuminate\Database\Schema\Grammars\Grammar',
//            'Royalcms\Component\Database\Schema\Grammars\MySqlGrammar'            => 'Illuminate\Database\Schema\Grammars\MySqlGrammar',
            'Royalcms\Component\Database\Schema\Grammars\PostgresGrammar'         => 'Illuminate\Database\Schema\Grammars\PostgresGrammar',
            'Royalcms\Component\Database\Schema\Grammars\SQLiteGrammar'           => 'Illuminate\Database\Schema\Grammars\SQLiteGrammar',
            'Royalcms\Component\Database\Schema\Grammars\SqlServerGrammar'        => 'Illuminate\Database\Schema\Grammars\SqlServerGrammar',
//            'Royalcms\Component\Database\Schema\MySqlBuilder'                     => 'Illuminate\Database\Schema\MySqlBuilder',
            'Royalcms\Component\Database\Schema\PostgresBuilder'                  => 'Illuminate\Database\Schema\PostgresBuilder',
            'Royalcms\Component\Database\Seeder'                                  => 'Illuminate\Database\Seeder',
            'Royalcms\Component\Database\SqlServerConnection'                     => 'Illuminate\Database\SqlServerConnection',


        ];
    }

}
