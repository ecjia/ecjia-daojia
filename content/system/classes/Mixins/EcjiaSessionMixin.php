<?php


namespace Ecjia\System\Mixins;


use Ecjia\System\Frameworks\Sessions\Handler\MemcacheSessionHandler;
use Ecjia\System\Frameworks\Sessions\Handler\MysqlSessionHandler;
use Ecjia\System\Frameworks\Sessions\Handler\RedisSessionHandler;

class EcjiaSessionMixin
{

    /**
     * @return \Closure
     */
    public function mysql()
    {
        /**
         * 注册Session驱动
         *
         * @royalcms 6.0.0
         *
         * @return \SessionHandlerInterface
         */
        return function ($royalcms) {
            $getDatabaseConnection = function ($royalcms)
            {
                $connection = $royalcms['config']['session.connection'];

                return $royalcms['db']->connection($connection);
            };

            $getDatabaseOptions = function ($table, $royalcms)
            {
                return array(
                    'db_table' => $table,
                    'db_id_col' => 'id',
                    'db_data_col' => 'payload',
                    'db_time_col' => 'last_activity',
                    'db_userid_col' => 'user_id',
                    'db_usertype_col' => 'user_type',
                );
            };

            $connection = $getDatabaseConnection($royalcms);

            $table = $connection->getTablePrefix().$royalcms['config']['session.table'];

            return new MysqlSessionHandler($connection->getPdo(), $getDatabaseOptions($table, $royalcms));
        };
    }


    /**
     * @return \Closure
     */
    public function ecjiaredis()
    {
        /**
         * 注册Session驱动
         *
         * @royalcms 6.0.0
         *
         * @return \SessionHandlerInterface
         */
        return function ($royalcms) {
            $getPrefix = function () {
                $defaultconnection = config('database.default');
                $connection = array_get(config('database.connections'), $defaultconnection);
                if (array_get($connection, 'database')) {
                    $prefix = $connection['database'] . ':';
                }
                else {
                    $prefix = 'ecjia_session:';
                }

                return $prefix;
            };

            $options = [
                'prefix' => $getPrefix(),
                'expiretime' => config('session.lifetime', 1440) * 60,
            ];

            return new RedisSessionHandler(royalcms('redis')->connection('session'), $options);
        };
    }


    /**
     * @return \Closure
     */
    public function memcache()
    {
        /**
         * 注册Session驱动
         *
         * @royalcms 6.0.0
         *
         * @return \SessionHandlerInterface
         */
        return function ($royalcms) {
            $getPrefix = function () {
                $defaultconnection = config('database.default');
                $connection = array_get(config('database.connections'), $defaultconnection);
                if (array_get($connection, 'database')) {
                    $prefix = $connection['database'] . ':';
                }
                else {
                    $prefix = 'ecjia_session:';
                }

                return $prefix;
            };

            $options = [
                'prefix' => $getPrefix(),
                'expiretime' => config('session.lifetime', 1440) * 60
            ];

            return new MemcacheSessionHandler(royalcms('memcache'), $options);
        };
    }

}
