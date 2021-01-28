<?php

namespace Datto\JsonRpc\Http\Examples;

class Math
{
    /**
     * Returns the value $a + $b.
     *
     * @param int $a
     * @param int $b
     *
     * @return int
     * Returns the value $a + $b.
     */
    public static function add($a, $b)
    {
        return $a + $b;
    }
}
