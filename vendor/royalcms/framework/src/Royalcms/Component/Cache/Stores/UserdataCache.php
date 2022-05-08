<?php

namespace Royalcms\Component\Cache\Stores;

use RC_Config;
use RC_Cache;

class UserdataCache extends AbstractCache
{

    protected $name = 'userdata_cache';

    protected $user_id;
    protected $user_type;

    /**
     * 获取默认config
     * @return array
     */
    protected function getDefaultConfig()
    {
        $config = [
            'driver' => 'file',
            'path'   => storage_path().'/temp/userdata',
            'expire' => 60 //分钟
        ];

        RC_Config::set('cache.stores.'.$this->name, $config);

        return $config;
    }

    protected function buildCacheKey($name)
    {
        return $this->name . ':' . $name . $this->user_type . $this->user_id;
    }

    /**
     * @return null
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param null $user_id
     * @return UserdataCache
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return null
     */
    public function getUserType()
    {
        return $this->user_type;
    }

    /**
     * @param null $user_type
     * @return UserdataCache
     */
    public function setUserType($user_type)
    {
        $this->user_type = $user_type;
        return $this;
    }


}