<?php


namespace Ecjia\App\Installer\Hookers;


use Ecjia\App\Installer\DatabaseConfig;

/**
 * 重设数据库连接池
 *
 * Class ResetDatabaseConfigAction
 * @package Ecjia\App\Installer\Hookers
 */
class ResetDatabaseConfigAction
{

    /**
     * Handle the event.
     * @return void
     */
    public function handle()
    {
        $db_host     = env('DB_HOST', '127.0.0.1');
        $db_port     = env('DB_PORT', 3306);
        $db_user     = env('DB_USERNAME', 'root');
        $db_pass     = env('DB_PASSWORD');
        $db_database = env('DB_DATABASE');
        $db_prefix   = env('DB_PREFIX', 'ecjia_');

        //重设数据库连接
        (new DatabaseConfig('default'))->resetConfig($db_host, $db_port, $db_user, $db_pass, $db_database, $db_prefix);
    }

}