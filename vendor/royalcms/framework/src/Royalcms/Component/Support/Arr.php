<?php

namespace Royalcms\Component\Support;


class Arr extends \Illuminate\Support\Arr
{
    use ArrayHelperTrait;

    /**
     * Build a new array using a callback.
     *
     * @royalcms 5.5.0
     *
     * @param  array  $array
     * @param  callable  $callback
     * @return array
     */
    public static function build($array, callable $callback)
    {
        $results = [];

        foreach ($array as $key => $value) {
            list($innerKey, $innerValue) = call_user_func($callback, $key, $value);

            $results[$innerKey] = $innerValue;
        }

        return $results;
    }

    /**
     * Fetch a flattened array of a nested array element.
     *
     * @royalcms 5.1.0
     * @param  array   $array
     * @param  string  $key
     * @return array
     *
     * @deprecated since version 5.1. Use pluck instead.
     */
    public static function fetch($array, $key)
    {
        foreach (explode('.', $key) as $segment) {
            $results = [];

            foreach ($array as $value) {
                if (array_key_exists($segment, $value = (array) $value)) {
                    $results[] = $value[$segment];
                }
            }

            $array = array_values($results);
        }

        return $array;
    }

}
