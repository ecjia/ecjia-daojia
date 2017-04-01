<?php

namespace Royalcms\Component\Notifications;

trait HasDatabaseNotifications
{
    /**
     * Get the entity's notifications.
     */
    public function notifications()
    {
        return $this->morphMany('\Royalcms\Component\Notifications\DatabaseNotification', 'notifiable')
                            ->orderBy('created_at', 'desc');
    }

    /**
     * Get the entity's unread notifications.
     */
    public function unreadNotifications()
    {
        return $this->morphMany('\Royalcms\Component\Notifications\DatabaseNotification', 'notifiable')
                            ->whereNull('read_at')
                            ->orderBy('created_at', 'desc');
    }
}
