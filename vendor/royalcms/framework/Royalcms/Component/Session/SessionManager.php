<?php

namespace Royalcms\Component\Session;

use Royalcms\Component\Support\Manager;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NullSessionHandler;

class SessionManager extends Manager
{
    /**
     * Call a custom driver creator.
     *
     * @param  string  $driver
     * @return mixed
     */
    protected function callCustomCreator($driver)
    {
        return $this->buildSession(parent::callCustomCreator($driver));
    }

    /**
     * Create an instance of the "array" session driver.
     *
     * @return \Royalcms\Component\Session\Store
     */
    protected function createArrayDriver()
    {
        return $this->buildSession(new NullSessionHandler);
    }

    /**
     * Create an instance of the "cookie" session driver.
     *
     * @return \Royalcms\Component\Session\Store
     */
    protected function createCookieDriver()
    {
        $lifetime = $this->royalcms['config']['session.lifetime'];

        return $this->buildSession(new CookieSessionHandler($this->royalcms['cookie'], $lifetime));
    }

    /**
     * Create an instance of the file session driver.
     *
     * @return \Royalcms\Component\Session\Store
     */
    protected function createFileDriver()
    {
        return $this->createNativeDriver();
    }

    /**
     * Create an instance of the file session driver.
     *
     * @return \Royalcms\Component\Session\Store
     */
    protected function createNativeDriver()
    {
        $path = $this->royalcms['config']['session.files'];

        $lifetime = $this->royalcms['config']['session.lifetime'];

        return $this->buildSession(new FileSessionHandler($this->royalcms['files'], $path, $lifetime));
    }

    /**
     * Create an instance of the database session driver.
     *
     * @return \Royalcms\Component\Session\Store
     */
    protected function createDatabaseDriver()
    {
        $connection = $this->getDatabaseConnection();

        $table = $this->royalcms['config']['session.table'];

        $lifetime = $this->royalcms['config']['session.lifetime'];

        return $this->buildSession(new DatabaseSessionHandler($connection, $table, $lifetime));
    }

    /**
     * Get the database connection for the database driver.
     *
     * @return \Royalcms\Component\Database\Connection
     */
    protected function getDatabaseConnection()
    {
        $connection = $this->royalcms['config']['session.connection'];

        return $this->royalcms['db']->connection($connection);
    }

    /**
     * Create an instance of the APC session driver.
     *
     * @return \Royalcms\Component\Session\Store
     */
    protected function createApcDriver()
    {
        return $this->createCacheBased('apc');
    }

    /**
     * Create an instance of the Memcached session driver.
     *
     * @return \Royalcms\Component\Session\Store
     */
    protected function createMemcachedDriver()
    {
        return $this->createCacheBased('memcached');
    }

    /**
     * Create an instance of the Wincache session driver.
     *
     * @return \Royalcms\Component\Session\Store
     */
    protected function createWincacheDriver()
    {
        return $this->createCacheBased('wincache');
    }

    /**
     * Create an instance of the Redis session driver.
     *
     * @return \Royalcms\Component\Session\Store
     */
    protected function createRedisDriver()
    {
        $handler = $this->createCacheHandler('redis');

        $handler->getCache()->getStore()->setConnection($this->royalcms['config']['session.connection']);

        return $this->buildSession($handler);
    }

    /**
     * Create an instance of a cache driven driver.
     *
     * @param  string  $driver
     * @return \Royalcms\Component\Session\Store
     */
    protected function createCacheBased($driver)
    {
        return $this->buildSession($this->createCacheHandler($driver));
    }

    /**
     * Create the cache based session handler instance.
     *
     * @param  string  $driver
     * @return \Royalcms\Component\Session\CacheBasedSessionHandler
     */
    protected function createCacheHandler($driver)
    {
        $minutes = $this->royalcms['config']['session.lifetime'];

        return new CacheBasedSessionHandler(clone $this->royalcms['cache']->driver($driver), $minutes);
    }

    /**
     * Build the session instance.
     *
     * @param  \SessionHandlerInterface  $handler
     * @return \Royalcms\Component\Session\Store
     */
    protected function buildSession($handler)
    {
        if ($this->royalcms['config']['session.encrypt']) {
            return new EncryptedStore(
                $this->royalcms['config']['session.cookie'], $handler, $this->royalcms['encrypter']
            );
        } else {
            return new Store($this->royalcms['config']['session.cookie'], $handler);
        }
    }

    /**
     * Get the session configuration.
     *
     * @return array
     */
    public function getSessionConfig()
    {
        return $this->royalcms['config']['session'];
    }

    /**
     * Get the default session driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->royalcms['config']['session.driver'];
    }

    /**
     * Set the default session driver name.
     *
     * @param  string  $name
     * @return void
     */
    public function setDefaultDriver($name)
    {
        $this->royalcms['config']['session.driver'] = $name;
    }
}
