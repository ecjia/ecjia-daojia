<?php


namespace Ecjia\Component\CleanCache;


class RedisManager
{

    protected $redis;

    /**
     * RedisManager constructor.
     * @param null $redis
     */
    public function __construct($redis = null)
    {
        if (empty($redis)) {
            $this->redis = royalcms('redis');
        }
        else {
            $this->redis = $redis;
        }
    }

    /**
     * @param $connection
     * @return $this
     */
    public function connection($connection)
    {
        $this->redis->connection($connection);

        return $this;
    }

    public function flushdb()
    {
        $result = $this->withRedisFlushDB();

        if (is_ecjia_error($result)) {
            $this->withRedisKeys();
        }
    }

    protected function withRedisFlushDB()
    {
        try {
            //flushdb 清空当前库
            $this->redis->flushdb();
            return true;
        }
        catch (\Predis\Response\ServerException $e) {
            ecjia_log_notice($e->getMessage());
            return new \ecjia_error($e->getCode(), $e->getMessage(), $e);
        }
    }

    protected function withRedisKeys()
    {
        try {
            $keys = $this->redis->keys('*');
            collect($keys)->each(function ($key) {
                $this->redis->del($key);
            });
            return true;
        }
        catch (\Predis\Response\ServerException $e) {
            ecjia_log_notice($e->getMessage());
            return new \ecjia_error($e->getCode(), $e->getMessage(), $e);
        }
    }

}