<?php 

namespace Royalcms\Component\Websocket\Console\Commands;

use Royalcms\Component\Console\Command;
use Royalcms\Component\Websocket\Interfaces\WebsocketHandleInterface;
use Royalcms\Component\Websocket\Websocket;

class StartServer extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'websocket:serve';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Starts websocket server';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		
		$host = config('websocket::websocket.host');
		$port = config('websocket::websocket.port');
		$ssl = config('websocket::websocket.ssl');
		$handler = config('websocket::websocket.handler');
        $handler = royalcms($handler);

        if (!($handler instanceof WebsocketHandleInterface)) {
            $this->error("Websocket handle should implement WebsocketHandleInterface");
            exit;
        }

        if ($ssl) {
            $this->info("Starting Websocket server AT: wss://$host:$port");
        } else {
            $this->info("Starting Websocket server AT: ws://$host:$port");
        }

		$socket = new Websocket($host, $port, $ssl);
		$socket->setHooks($handler, config('websocket::websocket.actions'), $this->getQueueHandle());
		$socket->serve();
		
	}

	public function getQueueHandle()
    {
        $queueHandle = royalcms('\Royalcms\Component\Websocket\QueueHandles\RedisQueueHandle');
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