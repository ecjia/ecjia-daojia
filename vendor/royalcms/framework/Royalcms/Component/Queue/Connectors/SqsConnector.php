<?php namespace Royalcms\Component\Queue\Connectors;

use Aws\Sqs\SqsClient;
use Royalcms\Component\Queue\SqsQueue;

class SqsConnector implements ConnectorInterface {

	/**
	 * Establish a queue connection.
	 *
	 * @param  array  $config
	 * @return \Royalcms\Component\Queue\QueueInterface
	 */
	public function connect(array $config)
	{
		$sqs = SqsClient::factory($config);

		return new SqsQueue($sqs, $config['queue']);
	}

}
