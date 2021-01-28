<?php

namespace Royalcms\Component\SmartyView\Cache;

use Smarty;
use Royalcms\Component\Contracts\Config\Repository as ConfigContract;

/**
 * Class Storage
 *
 */
class Storage
{
    /** @var Smarty */
    protected $smarty;

    /** @var ConfigContract */
    protected $repository;

    /**
     * @param Smarty         $smarty
     * @param ConfigContract $repository
     */
    public function __construct(Smarty $smarty, ConfigContract $repository)
    {
        $this->smarty = $smarty;
        $this->repository = $repository;
    }

    /**
     * @return void
     */
    public function cacheStorageManaged()
    {
        $driver = $this->repository->get('smarty-view::smarty.cache_driver', 'file');
        if ($driver !== 'file') {
            $storage = $driver . "Storage";
            $this->smarty->registerCacheResource($driver, $this->$storage());
        }
        $this->smarty->caching_type = $driver;
    }

    /**
     * @return Redis
     */
    protected function redisStorage()
    {
        return new Redis($this->repository->get('smarty-view::smarty.redis'));
    }

    /**
     * @return Memcached
     */
    protected function memcachedStorage()
    {
        return new Memcached(
            new \Memcached(),
            $this->repository->get('smarty-view::smarty.memcached')
        );
    }
}
