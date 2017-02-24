<?php

namespace Royalcms\Component\Queue\Contracts;

interface QueueableCollection
{
    /**
     * Get the type of the entities being queued.
     *
     * @return string|null
     */
    public function getQueueableClass();

    /**
     * Get the identifiers for all of the entities.
     *
     * @return array
     */
    public function getQueueableIds();
}
