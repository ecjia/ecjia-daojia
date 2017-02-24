<?php namespace Royalcms\Component\Support\Facades;

/**
 * @see \Royalcms\Component\Notifications\ChannelManager
 */
class Notification extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'notification';
    }
}
