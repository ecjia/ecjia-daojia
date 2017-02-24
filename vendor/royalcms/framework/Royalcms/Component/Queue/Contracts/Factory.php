<?php

namespace Royalcms\Component\Queue\Contracts;

interface Factory
{
    /**
     * Resolve a queue connection instance.
     *
     * @param  string  $name
     * @return \Royalcms\Component\Queue\Contracts\Queue
     */
    public function connection($name = null);
}
