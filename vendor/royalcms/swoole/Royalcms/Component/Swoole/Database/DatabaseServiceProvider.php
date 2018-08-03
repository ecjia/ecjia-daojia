<?php

namespace Royalcms\Component\Database;

use Royalcms\Component\Database\Eloquent\Model;
use Royalcms\Component\Database\DatabaseServiceProvider as RoyalcmsDatabaseServiceProvider;

class DatabaseServiceProvider extends RoyalcmsDatabaseServiceProvider
{
    public function register()
    {
        Model::clearBootedModels();

        $this->registerEloquentFactory();

        $this->registerQueueableEntityResolver();


        $this->royalcms->singleton('db.factory', function ($royalcms) {
            return new ConnectionFactory($royalcms);
        });

        $this->royalcms->singleton('db', function ($royalcms) {
            return new DatabaseManager($royalcms, $royalcms['db.factory']);
        });

        $this->royalcms->bind('db.connection', function ($royalcms) {
            return $royalcms['db']->connection();
        });
    }
}