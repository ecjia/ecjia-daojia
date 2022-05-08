<?php


namespace Ecjia\Component\Password;


class PasswordManager
{

    protected $driver = []; // hash

    public function driver($name = null)
    {
        $name = $name ?: $this->getDefaultDriver();

        return $this->driver[$name] = $this->get($name);
    }

    /**
     * Attempt to get the store from the local cache.
     *
     * @param  string  $name
     * @return \Illuminate\Contracts\Cache\Repository
     */
    protected function get($name)
    {
        return $this->driver[$name] ?? $this->resolve($name);
    }

    /**
     * Resolve the given store.
     *
     * @param  string  $name
     * @return \Illuminate\Contracts\Cache\Repository
     *
     * @throws \InvalidArgumentException
     */
    protected function resolve($name)
    {
        if (isset($this->customCreators[$name])) {
            return $this->callCustomCreator();
        } else {
            $driverMethod = 'create'.ucfirst($name).'PasswordDriver';

            if (method_exists($this, $driverMethod)) {
                return $this->{$driverMethod}();
            } else {
                throw new InvalidArgumentException("Driver [{$name}] is not supported.");
            }
        }
    }

    /**
     * 获取MD5的密码管理器
     * @return PasswordMd5
     */
    public function createMd5PasswordDriver()
    {
        return new PasswordMd5();
    }

    /**
     * 获取Hash格式的密码管理器
     * @return PasswordHash
     */
    public function createHashPasswordDriver()
    {
        return new PasswordHash();
    }

    /**
     * 获取默认驱动，md5
     * @return string
     */
    public function getDefaultDriver()
    {
        return 'md5';
    }


    /**
     * 自动兼容驱动
     * @param $password
     * @return PasswordInterface
     */
    public function autoCompatibleDriver($password)
    {
        if (strlen($password) == 32) {
            return $this->driver('md5');
        }

        return $this->driver('hash');
    }

    /**
     * 判断这个密码器是不是Hash密码
     * @param $password
     * @return bool
     */
    public function isHashPassword($password)
    {
        return $password instanceof PasswordHash;
    }

    /**
     * @return $this
     */
    public static function make()
    {
        static $instance;
        if (empty($instance)) {
            $instance = new static();
        }
        return $instance;
    }
}