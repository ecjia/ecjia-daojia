<?php 

namespace Royalcms\Component\Gearman\Connectors;

use \GearmanClient;
use \GearmanWorker;
use Royalcms\Component\Gearman\GearmanQueue;
use Royalcms\Component\Queue\Connectors\ConnectorInterface;

class GearmanConnector implements ConnectorInterface {

	/**
	 * @param array $config
	 *
	 * @return GearmanQueue
	 */
    public function connect(array $config)
    {
        $client = new GearmanClient;
        $worker = new GearmanWorker;

        if (isset($config['hosts'])) {
            foreach ($config['hosts'] as $server) {
                $client->addServer($server['host'], $server['port']);
                $worker->addServer($server['host'], $server['port']);
            }
        } else {
            $client->addServer($config['host'], $config['port']);
            $worker->addServer($config['host'], $config['port']);
        }

        $this->setTimeout($client, $config);

        return new GearmanQueue ($client, $worker, $config['queue']);
    }

	/**
	 * @param GearmanClient $client
	 * @param array $config
	 */
    private function setTimeout(GearmanClient $client, array $config)
    {
        if(isset ($config['timeout']) && is_numeric($config['timeout'])) {
            $client->setTimeout($config['timeout']);
        }
    }
}
