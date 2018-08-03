<?php

namespace Royalcms\Component\Cache\SpecialStores;

use Royalcms\Component\Cache\Memory;

trait MemoryCache
{
    
    private static $memory_object_cache;
    
    /**
     * Sets up Object Cache Global and assigns it.
     *
     * @since 2.0.0
     * @global WP_Object_Cache $wp_object_cache WordPress Object Cache
     */
    public static function memory_cache_init() {
        self::$memory_object_cache = new Memory();
    }
    
    /**
     * Adds data to the cache, if the cache key doesn't already exist.
     *
     * @since 2.0.0
     * @uses $wp_object_cache Object Cache Class
     * @see WP_Object_Cache::add()
     *
     * @param int|string $key The cache key to use for retrieval later
     * @param mixed $data The data to add to the cache store
     * @param string $group The group to add the cache to
     * @param int $expire When the cache data should be expired
     * @return bool False if cache key and group already exist, true on success
     */
    public static function memory_cache_add( $key, $data, $group = '', $expire = 0 ) {
        return self::$memory_object_cache->add( $key, $data, $group, (int) $expire );
    }
    
    /**
     * Closes the cache.
     *
     * This function has ceased to do anything since WordPress 2.5. The
     * functionality was removed along with the rest of the persistent cache. This
     * does not mean that plugins can't implement this function when they need to
     * make sure that the cache is cleaned up after WordPress no longer needs it.
     *
     * @since 2.0.0
     *
     * @return bool Always returns True
     */
    public static function memory_cache_close() {
        return true;
    }
    
    /**
     * Decrement numeric cache item's value
     *
     * @since 3.3.0
     * @uses $wp_object_cache Object Cache Class
     * @see WP_Object_Cache::decr()
     *
     * @param int|string $key The cache key to increment
     * @param int $offset The amount by which to decrement the item's value. Default is 1.
     * @param string $group The group the key is in.
     * @return false|int False on failure, the item's new value on success.
     */
    public static function memory_cache_decr( $key, $offset = 1, $group = '' ) {
        return self::$memory_object_cache->decr( $key, $offset, $group );
    }
    
    /**
     * Removes the cache contents matching key and group.
     *
     * @since 2.0.0
     * @uses $wp_object_cache Object Cache Class
     * @see WP_Object_Cache::delete()
     *
     * @param int|string $key What the contents in the cache are called
     * @param string $group Where the cache contents are grouped
     * @return bool True on successful removal, false on failure
     */
    public static function memory_cache_delete($key, $group = '') {
        return self::$memory_object_cache->delete($key, $group);
    }
    
    /**
     * Removes all cache items.
     *
     * @since 2.0.0
     * @uses $wp_object_cache Object Cache Class
     * @see WP_Object_Cache::flush()
     *
     * @return bool False on failure, true on success
     */
    public static function memory_cache_flush() {
        return self::$memory_object_cache->flush();
    }
    
    /**
     * Retrieves the cache contents from the cache by key and group.
     *
     * @since 2.0.0
     * @uses $wp_object_cache Object Cache Class
     * @see WP_Object_Cache::get()
     *
     * @param int|string $key What the contents in the cache are called
     * @param string $group Where the cache contents are grouped
     * @param bool $force Whether to force an update of the local cache from the persistent cache (default is false)
     * @param &bool $found Whether key was found in the cache. Disambiguates a return of false, a storable value.
     * @return bool|mixed False on failure to retrieve contents or the cache
     *		contents on success
     */
    public static function memory_cache_get( $key, $group = '', $force = false, &$found = null ) {
        return self::$memory_object_cache->get( $key, $group, $force, $found );
    }
    
    /**
     * Increment numeric cache item's value
     *
     * @since 3.3.0
     * @uses $wp_object_cache Object Cache Class
     * @see WP_Object_Cache::incr()
     *
     * @param int|string $key The cache key to increment
     * @param int $offset The amount by which to increment the item's value. Default is 1.
     * @param string $group The group the key is in.
     * @return false|int False on failure, the item's new value on success.
     */
    public static function memory_cache_incr( $key, $offset = 1, $group = '' ) {
        return self::$memory_object_cache->incr( $key, $offset, $group );
    }
    
    /**
     * Replaces the contents of the cache with new data.
     *
     * @since 2.0.0
     * @uses $wp_object_cache Object Cache Class
     * @see WP_Object_Cache::replace()
     *
     * @param int|string $key What to call the contents in the cache
     * @param mixed $data The contents to store in the cache
     * @param string $group Where to group the cache contents
     * @param int $expire When to expire the cache contents
     * @return bool False if not exists, true if contents were replaced
     */
    public static function memory_cache_replace( $key, $data, $group = '', $expire = 0 ) {
        return self::$memory_object_cache->replace( $key, $data, $group, (int) $expire );
    }
    
    /**
     * Saves the data to the cache.
     *
     * @since 2.0.0
     *
     * @uses $wp_object_cache Object Cache Class
     * @see WP_Object_Cache::set()
     *
     * @param int|string $key What to call the contents in the cache
     * @param mixed $data The contents to store in the cache
     * @param string $group Where to group the cache contents
     * @param int $expire When to expire the cache contents
     * @return bool False on failure, true on success
     */
    public static function memory_cache_set( $key, $data, $group = '', $expire = 0 ) {
        return self::$memory_object_cache->set( $key, $data, $group, (int) $expire );
    }
    
    /**
     * Switch the interal blog id.
     *
     * This changes the blog id used to create keys in blog specific groups.
     *
     * @since 3.5.0
     *
     * @param int $site_name Site name
     */
    public static function memory_cache_switch_to_site( $site_name ) {
        return self::$memory_object_cache->switch_to_site( $site_name );
    }
    
    /**
     * Adds a group or set of groups to the list of global groups.
     *
     * @since 2.6.0
     *
     * @param string|array $groups A group or an array of groups to add
     */
    public static function memory_cache_add_global_groups( $groups ) {
        return self::$memory_object_cache->add_global_groups( $groups );
    }
    
    /**
     * Adds a group or set of groups to the list of non-persistent groups.
     *
     * @since 2.6.0
     *
     * @param string|array $groups A group or an array of groups to add
     */
    public static function memory_cache_add_non_persistent_groups( $groups ) {
        // Default cache doesn't persist so nothing to do here.
        return;
    }
    
    /**
     * Reset internal cache keys and structures. If the cache backend uses global
     * blog or site IDs as part of its cache keys, this function instructs the
     * backend to reset those keys and perform any cleanup since blog or site IDs
     * have changed since cache init.
     *
     * This function is deprecated. Use wp_cache_switch_to_blog() instead of this
     * function when preparing the cache for a blog switch. For clearing the cache
     * during unit tests, consider using wp_cache_init(). wp_cache_init() is not
     * recommended outside of unit tests as the performance penality for using it is
     * high.
     *
     * @since 2.6.0
     * @deprecated 3.5.0
     */
    public static function memory_cache_reset() {
        return self::$memory_object_cache->reset();
    }
}