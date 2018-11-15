<?php

namespace Royalcms\Component\Queue\Jobs;

use Royalcms\Component\Support\Arr;
use Royalcms\Component\Queue\RedisQueue;
use Royalcms\Component\Container\Container;
use Royalcms\Component\Contracts\Queue\Job as JobContract;

class RedisJob extends Job implements JobContract
{
    /**
     * The Redis queue instance.
     *
     * @var \Royalcms\Component\Queue\RedisQueue
     */
    protected $redis;

    /**
     * The Redis job payload.
     *
     * @var string
     */
    protected $job;

    /**
     * Create a new job instance.
     *
     * @param  \Royalcms\Component\Container\Container  $container
     * @param  \Royalcms\Component\Queue\RedisQueue  $redis
     * @param  string  $job
     * @param  string  $queue
     * @return void
     */
    public function __construct(Container $container, RedisQueue $redis, $job, $queue)
    {
        $this->job = $job;
        $this->redis = $redis;
        $this->queue = $queue;
        $this->container = $container;
    }

    /**
     * Fire the job.
     *
     * @return void
     */
    public function fire()
    {
        $this->resolveAndFire(json_decode($this->getRawBody(), true));
    }

    /**
     * Get the raw body string for the job.
     *
     * @return string
     */
    public function getRawBody()
    {
        return $this->job;
    }

    /**
     * Delete the job from the queue.
     *
     * @return void
     */
    public function delete()
    {
        parent::delete();

        $this->redis->deleteReserved($this->queue, $this->job);
    }

    /**
     * Release the job back into the queue.
     *
     * @param  int   $delay
     * @return void
     */
    public function release($delay = 0)
    {
        parent::release($delay);

        $this->delete();

        $this->redis->release($this->queue, $this->job, $delay, $this->attempts() + 1);
    }

    /**
     * Get the number of times the job has been attempted.
     *
     * @return int
     */
    public function attempts()
    {
        return Arr::get(json_decode($this->job, true), 'attempts');
    }

    /**
     * Get the job identifier.
     *
     * @return string
     */
    public function getJobId()
    {
        return Arr::get(json_decode($this->job, true), 'id');
    }

    /**
     * Get the IoC container instance.
     *
     * @return \Royalcms\Component\Container\Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Get the underlying queue driver instance.
     *
     * @return \Royalcms\Component\Redis\Database
     */
    public function getRedisQueue()
    {
        return $this->redis;
    }

    /**
     * Get the underlying Redis job.
     *
     * @return string
     */
    public function getRedisJob()
    {
        return $this->job;
    }
}
