<?php namespace Royalcms\Component\Notifications;

use Royalcms\Component\Support\Str;
use Royalcms\Component\Database\Eloquent\Model;

abstract class Notifiable extends Model
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
    
    /**
     * Send the given notification.
     *
     * @param  mixed  $instance
     * @return void
     */
    public function notify($instance)
    {
        royalcms('dispatcher')->send($this, $instance);
    }
    
    /**
     * Get the notification routing information for the given driver.
     *
     * @param  string  $driver
     * @return mixed
     */
    public function routeNotificationFor($driver)
    {
        if (method_exists($this, $method = 'routeNotificationFor'.Str::studly($driver))) {
            return $this->{$method}();
        }
    
        switch ($driver) {
        	case 'database':
        	    return $this->notifications();
        	case 'mail':
        	    return $this->email;
        	case 'nexmo':
        	    return $this->phone_number;
        }
    }
    
}
