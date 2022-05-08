<?php


namespace Royalcms\Component\Support\Mixins;


use Royalcms\Component\Support\Arr;

class CollectionMixin
{

    /**
     * @return \Closure
     */
    public function set()
    {
        /**
         * Set an item from the collection by key.
         *
         * @royalcms 5.0.0
         *
         * @param  mixed  $key
         * @param  mixed  $default
         *
         * @return void
         */
        return function($key, $value) {
            Arr::set($this->items, $key, $value);
        };
    }

}