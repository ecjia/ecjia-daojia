<?php

namespace Royalcms\Component\Cache;

class CacheServiceProvider extends \Illuminate\Cache\CacheServiceProvider
{
    /**
     * The application instance.
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected $royalcms;

    /**
     * Create a new service provider instance.
     * @param \Royalcms\Component\Contracts\Foundation\Royalcms $royalcms
     * @return void
     */
    public function __construct($royalcms)
    {
        parent::__construct($royalcms);

        $this->royalcms = $royalcms;
    }

    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->loadAlias();

        parent::register();
    }

    /**
     * Load the alias = One less install step for the user
     */
    protected function loadAlias()
    {
        $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();

        foreach (self::aliases() as $class => $alias) {
            $loader->alias($class, $alias);
        }
    }

    /**
     * Load the alias = One less install step for the user
     */
    public static function aliases()
    {

        return [
            'Royalcms\Component\Cache\ApcStore'                  => 'Illuminate\Cache\ApcStore',
            'Royalcms\Component\Cache\ApcWrapper'                => 'Illuminate\Cache\ApcWrapper',
            'Royalcms\Component\Cache\ArrayStore'                => 'Illuminate\Cache\ArrayStore',
            'Royalcms\Component\Cache\CacheManager'              => 'Illuminate\Cache\CacheManager',
            'Royalcms\Component\Cache\Console\CacheTableCommand' => 'Illuminate\Cache\Console\CacheTableCommand',
            'Royalcms\Component\Cache\Console\ClearCommand'      => 'Illuminate\Cache\Console\ClearCommand',
            'Royalcms\Component\Cache\DatabaseStore'             => 'Illuminate\Cache\DatabaseStore',
            'Royalcms\Component\Cache\FileStore'                 => 'Illuminate\Cache\FileStore',
            'Royalcms\Component\Cache\MemcachedConnector'        => 'Illuminate\Cache\MemcachedConnector',
            'Royalcms\Component\Cache\MemcachedStore'            => 'Illuminate\Cache\MemcachedStore',
            'Royalcms\Component\Cache\NullStore'                 => 'Illuminate\Cache\NullStore',
            'Royalcms\Component\Cache\RateLimiter'               => 'Illuminate\Cache\RateLimiter',
            'Royalcms\Component\Cache\RedisStore'                => 'Illuminate\Cache\RedisStore',
            'Royalcms\Component\Cache\RedisTaggedCache'          => 'Illuminate\Cache\RedisTaggedCache',
            'Royalcms\Component\Cache\Repository'                => 'Illuminate\Cache\Repository',
            'Royalcms\Component\Cache\TagSet'                    => 'Illuminate\Cache\TagSet',
            'Royalcms\Component\Cache\TaggableStore'             => 'Illuminate\Cache\TaggableStore',
            'Royalcms\Component\Cache\TaggedCache'               => 'Illuminate\Cache\TaggedCache',
            'Royalcms\Component\Cache\WinCacheStore'             => 'Illuminate\Cache\WinCacheStore',
            'Royalcms\Component\Cache\XCacheStore'               => 'Illuminate\Cache\XCacheStore'
        ];
    }

}
