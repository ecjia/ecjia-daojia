<?php

namespace Royalcms\Component\Notifications;

use Royalcms\Component\Database\Eloquent\Model;

class DatabaseNotification extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notifications';

    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = array();

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = array(
        'data' => 'array',
        'read_at' => 'datetime',
    );

    /**
     * Get the notifiable entity that the notification belongs to.
     */
    public function notifiable()
    {
        return $this->morphTo();
    }

    /**
     * Mark the notification as read.
     *
     * @return void
     */
    public function markAsRead()
    {
        if (is_null($this->read_at)) {
            $this->forceFill(array('read_at' => $this->freshTimestamp()))->save();
        }
    }

    /**
     * Create a new database notification collection instance.
     *
     * @param  array  $models
     * @return \Royalcms\Component\Notifications\DatabaseNotificationCollection
     */
    public function newCollection(array $models = array())
    {
        return new DatabaseNotificationCollection($models);
    }
}
