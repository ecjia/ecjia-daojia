<?php

namespace Royalcms\Component\Redis\Contracts;

interface Factory
{
    /**
     * Get a Redis connection by name.
     *
     * @param  string  $name
     * @return \Royalcms\Component\Redis\Connections\Connection
     */
    public function connection($name = null);
}
