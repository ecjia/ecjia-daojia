<?php namespace Royalcms\Component\Queue\Connectors;

use IronMQ;
use Royalcms\Component\Http\Request;
use Royalcms\Component\Queue\IronQueue;
use Royalcms\Component\Encryption\Encrypter;

class IronConnector implements ConnectorInterface {

	/**
	 * The encrypter instance.
	 *
	 * @var \Royalcms\Component\Encryption\Encrypter
	 */
	protected $crypt;

	/**
	 * The current request instance.
	 *
	 * @var \Royalcms\Component\HttpKernel\Request;
	 */
	protected $request;

	/**
	 * Create a new Iron connector instance.
	 *
	 * @param  \Royalcms\Component\Encryption\Encrypter  $crypt
	 * @param  \Royalcms\Component\HttpKernel\Request  $request
	 * @return void
	 */
	public function __construct(Encrypter $crypt, Request $request)
	{
		$this->crypt = $crypt;
		$this->request = $request;
	}

	/**
	 * Establish a queue connection.
	 *
	 * @param  array  $config
	 * @return \Royalcms\Component\Queue\QueueInterface
	 */
	public function connect(array $config)
	{
		$ironConfig = array('token' => $config['token'], 'project_id' => $config['project']);

		if (isset($config['host'])) $ironConfig['host'] = $config['host'];

		$iron = new IronMQ($ironConfig);

		if (isset($config['ssl_verifypeer']))
		{
			$iron->ssl_verifypeer = $config['ssl_verifypeer'];
		}

		return new IronQueue($iron, $this->crypt, $this->request, $config['queue']);
	}

}
