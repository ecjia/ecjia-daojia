<?php

namespace Royalcms\Component\Support\Contracts;

interface MessageProvider
{
    /**
     * Get the messages for the instance.
     *
     * @return \Royalcms\Component\Contracts\Support\MessageBag
     */
    public function getMessageBag();
}
