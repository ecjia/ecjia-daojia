<?php

namespace Royalcms\Component\Notifications\Messages;

class DatabaseMessage
{
    /**
     * The data that should be stored with the notification.
     *
     * @var array
     */
    public $data = array();

    /**
     * Create a new database message.
     *
     * @param  array  $data
     * @return void
     */
    public function __construct(array $data = array())
    {
        $this->data = $data;
    }
}
