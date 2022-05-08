<?php


namespace Ecjia\System\Admins\Sessions;


use Ecjia\System\Admins\Redis\RedisManager;
use Royalcms\Component\NativeSession\Serialize;

class SessionManager
{
    protected $prefix;

    /**
     * @var \Predis\Client
     */
    protected $connection;

    public function __construct($connection = null)
    {
        $this->prefix = $this->markPrefix();
        if (is_null($connection)) {
            $this->connection = (new RedisManager())->getConnection();
        }
        else {
            $this->connection = $connection;
        }
    }

    protected function markPrefix()
    {
        $defaultconnection = config('database.default');
        $connection = array_get(config('database.connections'), $defaultconnection);
        if (array_get($connection, 'database')) {
            $prefix = $connection['database'] . ':';
        }
        else {
            $prefix = 'ecjia_session:';
        }

        $prefix .= 'session:';

        return $prefix;
    }

    public function getPrefix()
    {
        return $this->prefix;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * 获取所有的Session Keys
     * @return mixed
     */
    public function getKeys()
    {
        return $this->connection->keys('*');
    }

    /**
     * 根据条件搜索keys
     * @param $search
     */
    public function getSearchKeys($search)
    {
        $key = $this->prefix . $search . '*';
        return $this->connection->keys($key);
    }

    /**
     * 获取所有的Session Keys，并携带Values
     * @return array|mixed
     */
    public function getKeysWithValue()
    {
        $keys = $this->getKeys();

        return collect($keys)->mapWithKeys(function ($item) {
            return [$item => $this->connection->get($item)];
        })->all();
    }

    /**
     * 获取所有的Session Keys，并携带PHPSession反序列化的值
     * @return array|mixed
     */
    public function getKeysWithValueUnSerialize()
    {
        $keys = $this->getKeys();

        return $this->valueUnSerializeForKeys($keys)->all();
    }

    /**
     * 根据输入的keys，获取keys数据，并反序列化解析
     * @param $keys
     *
     * @return
     */
    public function valueUnSerializeForKeys($keys)
    {
        return collect($keys)->mapWithKeys(function ($item) {
            $data = $this->connection->get($item);
            $sessionData = Serialize::unserialize($data);
            $sessionData['ttl'] = $this->connection->ttl($item);
            $sessionData['ttl_formatted'] = \RC_Format::seconds2days($sessionData['ttl']);
            $sessionKey = $this->sessionValueExtract($item);
            return [$sessionKey => $sessionData];
        });
    }

    /**
     * 提取真正的Session Key
     * ecjia-b2b2c:session:c3cc14a29cd87ac4f1e7ec741f3957ebad9f0462
     * @param $key
     * @return string|string
     */
    protected function sessionValueExtract($key)
    {
        return str_replace($this->prefix, '', $key);
    }

    /**
     * 获取某个Session Key的值
     * @param $key
     * @return array
     * @throws \Exception
     */
    public function getSessionKey($key)
    {
        $key = $this->prefix . $key;

        $value = $this->connection->get($key);
        $value = Serialize::unserialize($value);

        return $value;
    }

    /**
     * 删除某个Session Key
     * @param $key
     */
    public function deleteSessionKey($key)
    {
        $key = $this->prefix . $key;

        $this->connection->del($key);
    }

    /**
     * 获取Session会话全部数量
     */
    public function count()
    {
        return $this->connection->dbsize();
    }

}