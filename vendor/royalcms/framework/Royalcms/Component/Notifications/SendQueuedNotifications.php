<?php

namespace Royalcms\Component\Notifications;

use Royalcms\Component\Bus\Queueable;
use Royalcms\Component\Queue\SerializesModels;
use Royalcms\Component\Contracts\Queue\ShouldQueue;

class SendQueuedNotifications implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The notifiable entities that should receive the notification.
     *
     * @var \Royalcms\Component\Support\Collection
     */
    protected $notifiables;

    /**
     * The notification to be sent.
     *
     * @var \Royalcms\Component\Notifications\Notification
     */
    protected $notification;

    /**
     * All of the channels to send the notification too.
     *
     * @var array
     */
    protected $channels = null;

    /**
     * Create a new job instance.
     *
     * @param  \Royalcms\Component\Support\Collection  $notifiables
     * @param  \Royalcms\Component\Notifications\Notification  $notification
     * @param  array  $channels
     * @return void
     */
    public function __construct($notifiables, $notification, array $channels = null)
    {
        $this->channels = $channels;
        $this->notifiables = $notifiables;
        $this->notification = $notification;
    }

    /**
     * Send the notifications.
     *
     * @param  \Royalcms\Component\Notifications\ChannelManager  $manager
     * @return void
     */
    public function handle(ChannelManager $manager)
    {
        $manager->sendNow($this->notifiables, $this->notification, $this->channels);
    }
}
