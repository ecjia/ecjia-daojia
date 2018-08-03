<?php

namespace Ecjia\System\Frameworks\Component;

use RC_Object;

/**
 * 
 * @author royalwang
 * @abstract \Royalcms\Component\Foundation\RoyalcmsObject
 */
class Cache extends RC_Object
{
    /**
     * A string that should be prepended to keys.
     *
     * @var string
     */
    protected $app;
    
    /**
     * 
     * @var string
     */
    protected $driver;
    
    /**
     * A string that should be prepended to keys.
     *
     * @var string
     */
    protected $prefix;
    
    /**
     * 
     * @var \Royalcms\Component\Cache\Repository
     */
    protected $cacheRepository;
    
    public function __construct()
    {
        $this->app = 'system';
        
        $this->cacheRepository = royalcms('cache')->driver($this->driver);
        
        $this->prefix = $this->app . ':';
    }
    
    public function app($app, $driver = null)
    {
        if (! is_null($driver)) {
            $this->driver = $driver;
            $this->cacheRepository = royalcms('cache')->driver($this->driver);
        }
        
        $this->app = $app ? $app . ':' : '';
        $this->prefix = $this->app;
        return $this;
    }
    
    /**
     * Store an item in the cache for a given number of minutes.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @param  int     $minutes
     * @return void
     */
    public function put($key, $value, $minutes)
    {
        return $this->cacheRepository->put($this->prefix.$key, $value, $minutes);
    }
    
    /**
	 * Retrieve an item from the cache and delete it.
	 *
	 * @param  string  $key
	 * @param  mixed   $default
	 * @return mixed
	 */
	public function pull($key, $default = null)
    {
        return $this->cacheRepository->pull($this->prefix.$key, $default);
    }
    
    /**
     * Retrieve an item from the cache by key.
     *
     * @param  string  $key
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->cacheRepository->get($this->prefix.$key, $default);
    }
    
    /**
     * Increment the value of an item in the cache.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function increment($key, $value = 1)
    {
        return $this->cacheRepository->increment($this->prefix.$key, $value);
    }
    
    /**
     * Decrement the value of an item in the cache.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function decrement($key, $value = 1)
    {
        return $this->cacheRepository->decrement($this->prefix.$key, $value);
    }
    
    /**
     * Store an item in the cache indefinitely.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function forever($key, $value)
    {
        return $this->cacheRepository->forever($this->prefix.$key, $value);
    }
    
    /**
     * Determine if an item exists in the cache.
     *
     * @param  string  $key
     * @return bool
     */
    public function has($key)
    {
        return $this->cacheRepository->has($this->prefix.$key);
    }
    
    /**
     * Remove an item from the cache.
     *
     * @param  string  $key
     * @return void
     */
    public function forget($key)
    {
        return $this->cacheRepository->forget($this->prefix.$key);
    }
    
    /**
     * Remove all items from the cache.
     *
     * @return void
     */
    public function flush()
    {
        return $this->cacheRepository->flush();
    }
    
}

// end