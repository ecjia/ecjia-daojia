<?php

namespace Royalcms\Component\Contracts\Queue;

interface Factory
{
    /**
     * Resolve a queue connection instance.
     *
     * @param  string  $name
     * @return \Royalcms\Component\Contracts\Queue\Queue
     */
    public function connection($name = null);
}
