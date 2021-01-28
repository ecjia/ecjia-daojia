<?php


namespace Ecjia\App\Installer;


class DatabaseConfig
{
    /**
     * @var string
     */
    protected $connection;

    public function __construct($connection = null)
    {
        $this->connection = $connection ?: 'default';
    }

    /**
     * 动态修改数据库连接配置
     *
     * @param $db_host
     * @param $db_port
     * @param $db_user
     * @param $db_pass
     * @param $db_database
     * @param null $db_prefix
     */
    public function resetConfig($db_host, $db_port, $db_user, $db_pass, $db_database, $db_prefix = null)
    {
        $db = royalcms('config')->get('database.connections.'.$this->connection);

        $db['host']     = $db_host;
        $db['port']     = $db_port;
        $db['username'] = $db_user;
        $db['password'] = $db_pass;
        $db['database'] = $db_database;
        $db['prefix']   = $db_prefix;

        royalcms('config')->set('database.connections.'.$this->connection, $db);
    }


}