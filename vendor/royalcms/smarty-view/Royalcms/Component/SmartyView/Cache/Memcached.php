<?php

namespace Royalcms\Component\SmartyView\Cache;

use Memcached as MemcachedExtension;

/**
 * Class Memcached
 *
 */
class Memcached extends KeyValueStorage
{
    /** @var MemcachedExtension */
    protected $memcached;

    /**
     * @param MemcachedExtension $memcached
     */
    public function __construct(MemcachedExtension $memcached, array $servers)
    {
        $this->memcached = $this->connection($memcached, $servers);
    }

    /**
     * @param array $servers
     *
     * @return \Memcached
     */
    protected function connection(MemcachedExtension $memcached, array $servers)
    {
        foreach ($servers as $server) {
            $memcached->addServer($server['host'], $server['port'], $server['weight']);
        }
        return $memcached;
    }


    /**
     * Read values for a set of keys from cache
     *
     * @param  array $keys list of keys to fetch
     *
     * @return array   list of values with the given keys used as indexes
     * @return boolean true on success, false on failure
     */
    protected function read(array $keys)
    {
        $_keys = $lookup = [];
        list($_keys, $lookup) = $this->eachKeys($keys, $_keys, $lookup);
        $_res = [];
        $res = $this->memcached->getMulti($_keys);
        foreach ($res as $k => $v) {
            $_res[$lookup[$k]] = $v;
        }
        return $_res;
    }

    /**
     * Save values for a set of keys to cache
     *
     * @param  array $keys list of values to save
     * @param  int   $expire expiration time
     *
     * @return boolean true on success, false on failure
     */
    protected function write(array $keys, $expire = null)
    {
        foreach ($keys as $k => $v) {
            $k = sha1($k);
            $this->memcached->set($k, $v, $expire);
        }
        return true;
    }

    /**
     * Remove values from cache
     *
     * @param  array $keys list of keys to delete
     *
     * @return boolean true on success, false on failure
     */
    protected function delete(array $keys)
    {
        foreach ($keys as $k) {
            $k = sha1($k);
            $this->memcached->delete($k);
        }
        return true;
    }

    /**
     * Remove *all* values from cache
     *
     * @return boolean true on success, false on failure
     */
    protected function purge()
    {
        $this->memcached->flush();
        return true;
    }
}
