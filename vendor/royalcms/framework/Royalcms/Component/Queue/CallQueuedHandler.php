<?php

namespace Royalcms\Component\Queue;

use Royalcms\Component\Contracts\Queue\Job;
use Royalcms\Component\Contracts\Bus\Dispatcher;

class CallQueuedHandler
{
    /**
     * The bus dispatcher implementation.
     *
     * @var \Royalcms\Component\Contracts\Bus\Dispatcher
     */
    protected $dispatcher;

    /**
     * Create a new handler instance.
     *
     * @param  \Royalcms\Component\Contracts\Bus\Dispatcher  $dispatcher
     * @return void
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Handle the queued job.
     *
     * @param  \Royalcms\Component\Contracts\Queue\Job  $job
     * @param  array  $data
     * @return void
     */
    public function call(Job $job, array $data)
    {
        $command = $this->setJobInstanceIfNecessary(
            $job, unserialize($data['command'])
        );

        $this->dispatcher->dispatchNow($command, function ($handler) use ($job) {
            $this->setJobInstanceIfNecessary($job, $handler);
        });

        if (! $job->isDeletedOrReleased()) {
            $job->delete();
        }
    }

    /**
     * Set the job instance of the given class if necessary.
     *
     * @param  \Royalcms\Component\Contracts\Queue\Job  $job
     * @param  mixed  $instance
     * @return mixed
     */
    protected function setJobInstanceIfNecessary(Job $job, $instance)
    {
        if (in_array('Royalcms\Component\Queue\InteractsWithQueue', class_uses_recursive(get_class($instance)))) {
            $instance->setJob($job);
        }

        return $instance;
    }

    /**
     * Call the failed method on the job instance.
     *
     * @param  array  $data
     * @return void
     */
    public function failed(array $data)
    {
        $handler = $this->dispatcher->resolveHandler($command = unserialize($data['command']));

        if (method_exists($handler, 'failed')) {
            call_user_func([$handler, 'failed'], $command);
        }
    }
}
