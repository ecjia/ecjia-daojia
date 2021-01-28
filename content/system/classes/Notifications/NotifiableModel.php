<?php


namespace Ecjia\System\Notifications;


use Royalcms\Component\Notifications\Notifiable;
use Royalcms\Component\Database\Eloquent\Model;

class NotifiableModel extends Model
{
    use Notifiable;

    /**
     * Get the entity's notifications.
     *
     * @return \Royalcms\Component\Database\Eloquent\Relations\MorphMany
     */
    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')->orderBy('created_at', 'desc');
    }

}