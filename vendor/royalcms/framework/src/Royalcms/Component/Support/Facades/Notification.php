<?php namespace Royalcms\Component\Support\Facades;

/**
 * @method static void send(\Illuminate\Support\Collection|array|mixed $notifiables, $notification)
 * @method static void sendNow(\Illuminate\Support\Collection|array|mixed $notifiables, $notification)
 * @method static mixed channel(string|null $name = null)
 * @method static \Illuminate\Notifications\ChannelManager locale(string|null $locale)
 * @method static void assertSentTo(mixed $notifiable, string $notification, callable $callback = null)
 * @method static void assertSentToTimes(mixed $notifiable, string $notification, int $times = 1)
 * @method static void assertNotSentTo(mixed $notifiable, string $notification, callable $callback = null)
 * @method static void assertNothingSent()
 * @method static void assertTimesSent(int $expectedCount, string $notification)
 * @method static \Illuminate\Support\Collection sent(mixed $notifiable, string $notification, callable $callback = null)
 * @method static bool hasSent(mixed $notifiable, string $notification)
 *
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
