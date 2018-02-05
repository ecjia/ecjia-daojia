<?php 

namespace Royalcms\Component\Gearman;

use Royalcms\Component\Queue\Queue;
use Royalcms\Component\Contracts\Queue\Queue as QueueInterface;
use Royalcms\Component\Gearman\Jobs\GearmanJob;
use GearmanException;
use GearmanWorker;
use GearmanClient;
use Exception;

class GearmanQueue extends Queue implements QueueInterface
{

	/**
	 * The gearmand worker object
	 *
	 * @var GearmanWorker
	 */
    protected $worker;

	/**
	 * The gearmand client object
	 *
	 * @var GearmanClient
	 */
    protected $client;

	/**
	 * The name of the queue to which the jobs will be written or pulled for processing
	 *
	 * @var string
	 */
    protected $queue;

	/**
	 * @param GearmanClient $client
	 * @param GearmanWorker $worker
	 * @param $queue
	 */
    public function __construct(GearmanClient $client, GearmanWorker $worker, $queue)
    {
        $this->client = $client;
        $this->worker = $worker;
        $this->queue = $queue;
    }

    /**
     * Push job to the queue
     *
     * @param string $job
     * @param string $data
     * @param string|null $queue
     * @return int|mixed Return gearman code
     */
    public function push($job, $data = '', $queue = null)
    {
        if(!$queue) {
            $queue = $this->queue;
        }
        $payload = $this->createPayload($job, $data);

        $this->doBackgroundAndHandleException($queue, $payload);

        return $this->client->returnCode();
    }

	/**
	 * Do the actual handling from the gearmand worker. On error it throws an exception
	 *
	 * @param $queue
	 * @param $payload
	 *
	 * @throws GearmanException
	 */
    private function doBackgroundAndHandleException($queue, $payload)
    {
        try {
            $this->client->doBackground($queue, $payload);
        } catch (Exception $e) {
            throw new GearmanException($e);
        }
    }

	/**
	 * It is not supported from the gearmand driver
	 *
	 * @param $delay
	 * @param $job
	 * @param string $data
	 * @param null $queue
	 *
	 * @throws Exception
	 */
    public function later($delay, $job, $data = '', $queue = null)
    {
        throw new Exception('Gearman driver do not support the method later');
    }

    /**
     * take a job from the queue
     *
     * @param null $queue
     * @return \Royalcms\Component\Queue\Jobs\Job|\Royalcms\Component\Queue\null|GearmanJob
     */
    public function pop($queue = null)
    {
        if(!$queue) {
            $queue = $this->queue;
        }

        return new GearmanJob($this->container, $this->worker, $queue);
    }

    /**
     * It is not supported from the gearmand driver
     *
     * @param  string $payload
     * @param  string $queue
     * @param  array $options
     * @throws \Exception
     * @return mixed
     */
    public function pushRaw($payload, $queue = null, array $options = array())
    {
        throw new Exception('Gearman driver do not support the method pushRaw');
    }

    /**
     * Get the size of the queue.
     *
     * @param  string  $queue
     * @return int
     */
    public function size($queue = null)
    {
        return 0;
    }
}
