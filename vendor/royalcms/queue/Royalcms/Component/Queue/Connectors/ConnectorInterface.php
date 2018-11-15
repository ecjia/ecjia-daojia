<?php

namespace Royalcms\Component\Queue\Connectors;

interface ConnectorInterface
{
    /**
     * Establish a queue connection.
     *
     * @param  array  $config
     * @return \Royalcms\Component\Contracts\Queue\Queue
     */
    public function connect(array $config);
}
