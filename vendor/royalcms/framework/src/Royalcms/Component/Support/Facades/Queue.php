<?php

namespace Royalcms\Component\Support\Facades;

/**
 * @method static int size(string $queue = null)
 * @method static mixed push(string|object $job, mixed $data = '', $queue = null)
 * @method static mixed pushOn(string $queue, string|object $job, mixed $data = '')
 * @method static mixed pushRaw(string $payload, string $queue = null, array $options = [])
 * @method static mixed later(\DateTimeInterface|\DateInterval|int $delay, string|object $job, mixed $data = '', string $queue = null)
 * @method static mixed laterOn(string $queue, \DateTimeInterface|\DateInterval|int $delay, string|object $job, mixed $data = '')
 * @method static mixed bulk(array $jobs, mixed $data = '', string $queue = null)
 * @method static \Illuminate\Contracts\Queue\Job|null pop(string $queue = null)
 * @method static string getConnectionName()
 * @method static \Illuminate\Contracts\Queue\Queue setConnectionName(string $name)
 * @method static void assertNothingPushed()
 * @method static void assertNotPushed(string $job, callable $callback = null)
 * @method static void assertPushed(string $job, callable|int $callback = null)
 * @method static void assertPushedOn(string $queue, string $job, callable|int $callback = null)
 * @method static void assertPushedWithChain(string $job, array $expectedChain = [], callable $callback = null)
 * 
 * @see \Royalcms\Component\Queue\QueueManager
 * @see \Royalcms\Component\Queue\Queue
 */
class Queue extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'queue';
    }
}
