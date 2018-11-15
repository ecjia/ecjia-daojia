<?php

namespace Royalcms\Component\Notifications;

use Royalcms\Component\Uuid\Uuid;
use InvalidArgumentException;
use Royalcms\Component\Support\Manager;
use Nexmo\Client as NexmoClient;
use Royalcms\Component\Support\Collection;
use Guzzle\Http\Client as HttpClient;
use Royalcms\Component\Database\Eloquent\Model;
use Royalcms\Component\Contracts\Queue\ShouldQueue;
use Royalcms\Component\Contracts\Bus\Dispatcher as Bus;
use Nexmo\Client\Credentials\Basic as NexmoCredentials;
use Royalcms\Component\Database\Eloquent\Collection as ModelCollection;
use Royalcms\Component\Contracts\Notifications\Factory as FactoryContract;
use Royalcms\Component\Contracts\Notifications\Dispatcher as DispatcherContract;

class ChannelManager extends Manager implements DispatcherContract, FactoryContract
{
    /**
     * The default channel used to deliver messages.
     *
     * @var string
     */
    protected $defaultChannel = 'mail';

    /**
     * Send the given notification to the given notifiable entities.
     *
     * @param  \Royalcms\Component\Support\Collection|array|mixed  $notifiables
     * @param  mixed  $notification
     * @return void
     */
    public function send($notifiables, $notification)
    {
        $notifiables = $this->formatNotifiables($notifiables);

        // 队列通知发送
         if ($notification instanceof ShouldQueue) {
             return $this->queueNotification($notifiables, $notification);
         }

        return $this->sendNow($notifiables, $notification);
    }

    /**
     * Send the given notification immediately.
     *
     * @param  \Royalcms\Component\Support\Collection|array|mixed  $notifiables
     * @param  mixed  $notification
     * @return void
     */
    public function sendNow($notifiables, $notification, array $channels = null)
    {
        $notifiables = $this->formatNotifiables($notifiables);

        $original = clone $notification;

        foreach ($notifiables as $notifiable) {
            $notificationId = (string) Uuid::generate();

            $channels = $channels ?: $notification->via($notifiable);

            if (empty($channels)) {
                continue;
            }

            foreach ($channels as $channel) {
                $notification = clone $original;

                $notification->id = $notificationId;

                if (! $this->shouldSendNotification($notifiable, $notification, $channel)) {
                    continue;
                }

                $response = $this->driver($channel)->send($notifiable, $notification);

                $this->royalcms->make('events')->fire(
                    new Events\NotificationSent($notifiable, $notification, $channel, $response)
                );
            }
        }
    }

    /**
     * Determines if the notification can be sent.
     *
     * @param  mixed  $notifiable
     * @param  mixed  $notification
     * @param  string  $channel
     * @return bool
     */
    protected function shouldSendNotification($notifiable, $notification, $channel)
    {
        return $this->royalcms->make('events')->until(
            new Events\NotificationSending($notifiable, $notification, $channel)
        ) !== false;
    }

     /**
      * Queue the given notification instances.
      *
      * @param  mixed  $notifiables
      * @param  array[\Royalcms\Component\Notifcations\Channels\Notification]  $notification
      * @return void
      */
     protected function queueNotification($notifiables, $notification)
     {
         $notifiables = $this->formatNotifiables($notifiables);

         $bus = $this->royalcms->make(Bus::class);

         foreach ($notifiables as $notifiable) {
             foreach ($notification->via($notifiable) as $channel) {
                 $bus->dispatch(
                     (new SendQueuedNotifications($this->formatNotifiables($notifiable), $notification, [$channel]))
                             ->onConnection($notification->connection)
                             ->onQueue($notification->queue)
                             ->delay($notification->delay)
                 );
             }
         }
     }

    /**
     * Format the notifiables into a Collection / array if necessary.
     *
     * @param  mixed  $notifiables
     * @return ModelCollection|array
     */
    protected function formatNotifiables($notifiables)
    {
        if (! $notifiables instanceof Collection && ! is_array($notifiables)) {
            return $notifiables instanceof Model
                            ? new ModelCollection(array($notifiables)) : array($notifiables);
        }

        return $notifiables;
    }

    /**
     * Get a channel instance.
     *
     * @param  string|null  $name
     * @return mixed
     */
    public function channel($name = null)
    {
        return $this->driver($name);
    }

    /**
     * Create an instance of the database driver.
     *
     * @return \Royalcms\Component\Notifications\Channels\DatabaseChannel
     */
    protected function createDatabaseDriver()
    {
        return new Channels\DatabaseChannel;
    }

    /**
     * Create an instance of the broadcast driver.
     *
     * @return \Royalcms\Component\Notifications\Channels\BroadcastChannel
     */
    protected function createBroadcastDriver()
    {
        return new Channels\BroadcastChannel;
    }

    /**
     * Create an instance of the mail driver.
     *
     * @return \Royalcms\Component\Notifications\Channels\MailChannel
     */
    protected function createMailDriver()
    {
        return new Channels\MailChannel;
    }

     /**
      * Create an instance of the Nexmo driver.
      *
      * @return \Royalcms\Component\Notifications\Channels\NexmoSmsChannel
      */
     protected function createNexmoDriver()
     {
         return new Channels\NexmoSmsChannel(
             new NexmoClient(new NexmoCredentials(
                 $this->royalcms['config']['services.nexmo.key'],
                 $this->royalcms['config']['services.nexmo.secret']
             )),
             $this->royalcms['config']['services.nexmo.sms_from']
         );
     }

    /**
     * Create an instance of the Slack driver.
     *
     * @return \Royalcms\Component\Notifications\Channels\SlackWebhookChannel
     */
    protected function createSlackDriver()
    {
        return new Channels\SlackWebhookChannel(new HttpClient);
    }

    /**
     * Create a new driver instance.
     *
     * @param  string  $driver
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    protected function createDriver($driver)
    {
        try {
            return parent::createDriver($driver);
        } catch (InvalidArgumentException $e) {
            if (class_exists($driver)) {
                return $this->royalcms->make($driver);
            }

            throw $e;
        }
    }

    /**
     * Get the default channel driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->defaultChannel;
    }

    /**
     * Get the default channel driver name.
     *
     * @return string
     */
    public function deliversVia()
    {
        return $this->getDefaultDriver();
    }

    /**
     * Set the default channel driver name.
     *
     * @param  string  $channel
     * @return void
     */
    public function deliverVia($channel)
    {
        $this->defaultChannel = $channel;
    }
}
