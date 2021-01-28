<?php

namespace Royalcms\Component\Notifications;


class NotificationServiceProvider extends \Illuminate\Notifications\NotificationServiceProvider
{

    /**
     * The application instance.
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected $royalcms;

    /**
     * Create a new service provider instance.
     * @param \Royalcms\Component\Contracts\Foundation\Royalcms $royalcms
     * @return void
     */
    public function __construct($royalcms)
    {
        parent::__construct($royalcms);

        $this->royalcms = $royalcms;
    }

    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->loadAlias();

        parent::register();

        $this->royalcms->alias(
            ChannelManager::class, 'notification'
        );
    }

    /**
     * Load the alias = One less install step for the user
     */
    protected function loadAlias()
    {
        $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();

        foreach (self::aliases() as $class => $alias) {
            $loader->alias($class, $alias);
        }
    }

    /**
     * Load the alias = One less install step for the user
     */
    public static function aliases()
    {

        return [
            'Royalcms\Component\Notifications\SendQueuedNotifications'             => 'Illuminate\Notifications\SendQueuedNotifications',
            'Royalcms\Component\Notifications\RoutesNotifications'                 => 'Illuminate\Notifications\RoutesNotifications',
            'Royalcms\Component\Notifications\Notification'                        => 'Illuminate\Notifications\Notification',
            'Royalcms\Component\Notifications\Notifiable'                          => 'Illuminate\Notifications\Notifiable',
            'Royalcms\Component\Notifications\HasDatabaseNotifications'            => 'Illuminate\Notifications\HasDatabaseNotifications',
            'Royalcms\Component\Notifications\DatabaseNotificationCollection'      => 'Illuminate\Notifications\DatabaseNotificationCollection',
            'Royalcms\Component\Notifications\DatabaseNotification'                => 'Illuminate\Notifications\DatabaseNotification',
            'Royalcms\Component\Notifications\ChannelManager'                      => 'Illuminate\Notifications\ChannelManager',
            'Royalcms\Component\Notifications\Action'                              => 'Illuminate\Notifications\Action',
            'Royalcms\Component\Notifications\Channels\BroadcastChannel'           => 'Illuminate\Notifications\Channels\BroadcastChannel',
            'Royalcms\Component\Notifications\Channels\DatabaseChannel'            => 'Illuminate\Notifications\Channels\DatabaseChannel',
            'Royalcms\Component\Notifications\Channels\MailChannel'                => 'Illuminate\Notifications\Channels\MailChannel',
            'Royalcms\Component\Notifications\Events\BroadcastNotificationCreated' => 'Illuminate\Notifications\Events\BroadcastNotificationCreated',
            'Royalcms\Component\Notifications\Events\NotificationFailed'           => 'Illuminate\Notifications\Events\NotificationFailed',
            'Royalcms\Component\Notifications\Events\NotificationSending'          => 'Illuminate\Notifications\Events\NotificationSending',
            'Royalcms\Component\Notifications\Events\NotificationSent'             => 'Illuminate\Notifications\Events\NotificationSent',
            'Royalcms\Component\Notifications\Messages\BroadcastMessage'           => 'Illuminate\Notifications\Messages\BroadcastMessage',
            'Royalcms\Component\Notifications\Messages\DatabaseMessage'            => 'Illuminate\Notifications\Messages\DatabaseMessage',
            'Royalcms\Component\Notifications\Messages\MailMessage'                => 'Illuminate\Notifications\Messages\MailMessage',
            'Royalcms\Component\Notifications\Messages\SimpleMessage'              => 'Illuminate\Notifications\Messages\SimpleMessage'
        ];
    }

    /**
     * Get the services provided by the provider.
     * @return array
     */
    public function provides()
    {
        return array(
            'notification',
            \Illuminate\Contracts\Notifications\Dispatcher::class,
            \Illuminate\Contracts\Notifications\Factory::class
        );
    }
}
