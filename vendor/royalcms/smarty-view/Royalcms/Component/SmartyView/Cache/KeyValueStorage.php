<?php

namespace Royalcms\Component\SmartyView\Cache;

/**
 * Class KeyValueStorage
 * 
 */
abstract class KeyValueStorage extends \Smarty_CacheResource_KeyValueStore
{
    /**
     * @param array $keys
     * @param       $_keys
     * @param       $lookup
     *
     * @return array
     */
    protected function eachKeys(array $keys, $_keys, $lookup)
    {
        foreach ($keys as $k) {
            $_k = sha1($k);
            $_keys[] = $_k;
            $lookup[$_k] = $k;
        }
        return array($_keys, $lookup);
    }
}
