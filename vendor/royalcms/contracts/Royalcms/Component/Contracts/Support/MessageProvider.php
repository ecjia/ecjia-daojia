<?php

namespace Royalcms\Component\Contracts\Support;

interface MessageProvider
{
    /**
     * Get the messages for the instance.
     *
     * @return \Royalcms\Component\Contracts\Support\MessageBag
     */
    public function getMessageBag();
}
