<?php namespace Royalcms\Component\Notifications;


class Notification extends Queueable
{
//     use SerializesModels;

    /**
     * The unique identifier for the notification.
     *
     * @var string
     */
    public $id;

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return array();
    }
}
