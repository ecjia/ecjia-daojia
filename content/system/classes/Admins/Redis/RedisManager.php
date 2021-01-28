<?php


namespace Ecjia\System\Admins\Redis;


class RedisManager
{
    /**
     * @var \Predis\Client|\Illuminate\Redis\Connections\PredisConnection
     */
    protected $connection;

    public function __construct()
    {
        $this->connection = $this->markConnection();
    }

    /**
     * @return \Predis\Client|null
     */
    protected function markConnection()
    {
        try {
            return royalcms('redis')->connection('session');
        }
        catch (\Predis\Connection\ConnectionException $e) {
            ecjia_log_warning($e->getMessage());
        }

        return null;
    }

    /**
     * 获取Redis Connection对象
     * @return \Predis\Client|\Illuminate\Redis\Connections\PredisConnection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * 测试Redis连接是否成功
     */
    public function testConnection()
    {
        try {
            $ping = optional($this->connection)->ping();
            return $ping;
        }
        catch (\Predis\Connection\ConnectionException $e) {
            ecjia_log_warning($e->getMessage());
        }

        return false;
    }

}