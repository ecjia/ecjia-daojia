<?php

namespace Royalcms\Component\Cache;

abstract class TaggableStore
{
    /**
     * Begin executing a new tags operation.
     *
     * @param  string  $name
     * @return \Royalcms\Component\Cache\TaggedCache
     *
     * @deprecated since version 5.1. Use tags instead.
     */
    public function section($name)
    {
        return $this->tags($name);
    }

    /**
     * Begin executing a new tags operation.
     *
     * @param  array|mixed  $names
     * @return \Royalcms\Component\Cache\TaggedCache
     */
    public function tags($names)
    {
        return new TaggedCache($this, new TagSet($this, is_array($names) ? $names : func_get_args()));
    }
}
