<?php namespace Royalcms\Component\Queue\Connectors;

use Royalcms\Component\Queue\BeanstalkdQueue;
use Pheanstalk_Pheanstalk as Pheanstalk;

class BeanstalkdConnector implements ConnectorInterface {

	/**
	 * Establish a queue connection.
	 *
	 * @param  array  $config
	 * @return \Royalcms\Component\Queue\QueueInterface
	 */
	public function connect(array $config)
	{
		$pheanstalk = new Pheanstalk($config['host']);

		return new BeanstalkdQueue(
			$pheanstalk, $config['queue'], array_get($config, 'ttr', Pheanstalk::DEFAULT_TTR)
		);
	}

}
