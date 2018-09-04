<?php

namespace Royalcms\Component\Queue\Connectors;

use IronMQ\IronMQ;
use Royalcms\Component\Http\Request;
use Royalcms\Component\Queue\IronQueue;
use Royalcms\Component\Contracts\Encryption\Encrypter as EncrypterContract;

class IronConnector implements ConnectorInterface
{
    /**
     * The encrypter instance.
     *
     * @var \Royalcms\Component\Encryption\Encrypter
     */
    protected $crypt;

    /**
     * The current request instance.
     *
     * @var \Royalcms\Component\Http\Request
     */
    protected $request;

    /**
     * Create a new Iron connector instance.
     *
     * @param  \Royalcms\Component\Contracts\Encryption\Encrypter  $crypt
     * @param  \Royalcms\Component\Http\Request  $request
     * @return void
     */
    public function __construct(EncrypterContract $crypt, Request $request)
    {
        $this->crypt = $crypt;
        $this->request = $request;
    }

    /**
     * Establish a queue connection.
     *
     * @param  array  $config
     * @return \Royalcms\Component\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        $ironConfig = ['token' => $config['token'], 'project_id' => $config['project']];

        if (isset($config['host'])) {
            $ironConfig['host'] = $config['host'];
        }

        $iron = new IronMQ($ironConfig);

        if (isset($config['ssl_verifypeer'])) {
            $iron->ssl_verifypeer = $config['ssl_verifypeer'];
        }

        return new IronQueue($iron, $this->request, $config['queue'], $config['encrypt']);
    }
}
