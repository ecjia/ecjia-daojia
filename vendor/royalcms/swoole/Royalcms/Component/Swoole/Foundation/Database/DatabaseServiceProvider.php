<?php

namespace Royalcms\Component\Swoole\Foundation\Database;

use Royalcms\Component\Database\Eloquent\Model;
use Royalcms\Component\Database\DatabaseServiceProvider as RoyalcmsDatabaseServiceProvider;

class DatabaseServiceProvider extends RoyalcmsDatabaseServiceProvider
{
    public function register()
    {
        Model::clearBootedModels();

        $this->registerEloquentFactory();

        $this->registerQueueableEntityResolver();


        $this->royalcms->singleton('db.factory', function ($app) {
            return new ConnectionFactory($app);
        });

        $this->royalcms->singleton('db', function ($app) {
            return new DatabaseManager($app, $app['db.factory']);
        });

        $this->royalcms->bind('db.connection', function ($app) {
            return $app['db']->connection();
        });
    }
}