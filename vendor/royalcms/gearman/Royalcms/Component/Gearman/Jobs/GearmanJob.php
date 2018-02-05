<?php 

namespace Royalcms\Component\Gearman\Jobs;

use Royalcms\Component\Container\Container;
use Royalcms\Component\Contracts\Queue\Job as QueueJobInterface;
use Royalcms\Component\Queue\Jobs\Job;
use Royalcms\Component\Queue\Jobs\JobName;
use GearmanWorker;
use Exception;

class GearmanJob extends Job implements QueueJobInterface {

    protected $worker;

    protected $job;

    protected $rawPayload = '';

    private $maxRunTime = 1;

    private $single = false;

    public function __construct(Container $container, GearmanWorker $worker, $queue)
    {
        $this->container = $container;
        $this->worker = $worker;
        $this->worker->addFunction($queue, array($this, 'onGearmanJob'));
    }

    public function fire(){

        $startTime = time();

        while($this->worker->work() || $this->worker->returnCode() == GEARMAN_TIMEOUT) {
            // Check for expiry.
            if((time() - $startTime) >= 60 * $this->maxRunTime) {
                echo sprintf('%s minutes have elapsed, expiring.', $this->maxRunTime) . PHP_EOL;
                break;
            }
        }
    }

    public function delete(){
	    parent::delete();
    }

    public function release($delay = 0) {
	    if ($delay > 0) {
		    throw new Exception('No delay is suported');
	    }
    }

    public function attempts() {
        return 1;
    }

    public function getJobId() {
        return base64_encode($this->job);
    }

    public function getContainer() {
        return $this->container;
    }

    public function getGearmanWorker() {
        return $this->worker;
    }

    public function onGearmanJob(\GearmanJob $job) {
        $this->rawPayload = $job->workload();
        
        $payload = json_decode($this->rawPayload, true);

        if (method_exists($this, 'resolveAndFire')) {
            $this->resolveAndFire($payload);
            return;
        }

        // compatibility with Laravel 5.4+
        if (class_exists(JobName::class)) {
            list($class, $method) = JobName::parse($payload['job']);
        } else {
            list($class, $method) = $this->parseJob($payload['job']);
        }

        $this->instance = $this->resolve($class);
        $this->instance->{$method}($this, $payload['data']);
    }

    /**
     * Get the raw body string for the job.
     *
     * @return string
     */
    public function getRawBody() {
        return $this->rawPayload;
    }
}
