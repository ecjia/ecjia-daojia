<?php

namespace Royalcms\Component\Websocket\Console\Commands;

use Royalcms\Component\Console\Command;

class WebsocketWorker extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'websocket:work';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process websockets incoming requests actions';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {

       $queueHandle = $this->getQueueHandle();

       while (true) {
            usleep(10000);
            while($work = $queueHandle->popInQueue()) {
                $handle = royalcms($work['handle']);
                $this->info($work['connection_id'] .'  ' . $work['handle']);
                $handle->handle(
                    $work['connection_id'],
                    $work['user_id'],
                    $work['data'],
                    $work['meta']
                );
            }
       }

    }

    public function getQueueHandle()
    {
        $queueHandle =  royalcms('\Royalcms\Component\Websocket\QueueHandles\RedisQueueHandle');
        $queueHandle->setQueueName(config('websocket::websocket.queue_name'));
        return $queueHandle;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

}

// end