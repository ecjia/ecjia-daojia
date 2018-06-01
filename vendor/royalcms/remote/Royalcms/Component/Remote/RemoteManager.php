<?php

namespace Royalcms\Component\Remote;

use Royalcms\Component\Foundation\Royalcms;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\NullOutput;

class RemoteManager
{
    /**
     * The application instance.
     *
     * @var \Royalcms\Component\Foundation\Royalcms
     */
    protected $royalcms;

    /**
     * Create a new remote manager instance.
     *
     * @param \Royalcms\Component\Foundation\Royalcms $royalcms
     */
    public function __construct(Royalcms $royalcms)
    {
        $this->royalcms = $royalcms;
    }

    /**
     * Get a remote connection instance.
     *
     * @param string|array|mixed $name
     *
     * @return \Royalcms\Component\Remote\ConnectionInterface
     */
    public function into($name)
    {
        if (is_string($name) || is_array($name)) {
            return $this->connection($name);
        } else {
            return $this->connection(func_get_args());
        }
    }

    /**
     * Get a remote connection instance.
     *
     * @param string|array $name
     *
     * @return \Royalcms\Component\Remote\ConnectionInterface
     */
    public function connection($name = null)
    {
        if (is_array($name)) {
            return $this->multiple($name);
        }

        return $this->resolve($name ?: $this->getDefaultConnection());
    }

    /**
     * Make a new connection instance based on passed params.
     *
     * @param array $config
     *
     * @return \Royalcms\Component\Remote\Connection
     */
    public function connect($config)
    {
        return $this->makeConnection($config['host'], $config);
    }

    /**
     * Resolve a multiple connection instance.
     *
     * @param array $names
     *
     * @return \Royalcms\Component\Remote\MultiConnection
     */
    public function multiple(array $names)
    {
        return new MultiConnection(array_map([$this, 'resolve'], $names));
    }

    /**
     * Resolve a remote connection instance.
     *
     * @param string $name
     *
     * @return \Royalcms\Component\Remote\Connection
     */
    public function resolve($name)
    {
        return $this->makeConnection($name, $this->getConfig($name));
    }

    /**
     * Make a new connection instance.
     *
     * @param string $name
     * @param array  $config
     *
     * @return \Royalcms\Component\Remote\Connection
     */
    protected function makeConnection($name, array $config)
    {
        $timeout = isset($config['timeout']) ? $config['timeout'] : 10;

        $this->setOutput($connection = new Connection(

            $name, $config['host'], $config['username'], $this->getAuth($config), null, $timeout

        ));

        return $connection;
    }

    /**
     * Set the output implementation on the connection.
     *
     * @param \Royalcms\Component\Remote\Connection $connection
     *
     * @return void
     */
    protected function setOutput(Connection $connection)
    {
        $output = php_sapi_name() == 'cli' ? new ConsoleOutput() : new NullOutput();

        $connection->setOutput($output);
    }

    /**
     * Format the appropriate authentication array payload.
     *
     * @param array $config
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    protected function getAuth(array $config)
    {
        if (isset($config['agent']) && $config['agent'] === true) {
            return ['agent' => true];
        } elseif (isset($config['key']) && trim($config['key']) != '') {
            return ['key' => $config['key'], 'keyphrase' => $config['keyphrase']];
        } elseif (isset($config['keytext']) && trim($config['keytext']) != '') {
            return ['keytext' => $config['keytext']];
        } elseif (isset($config['password'])) {
            return ['password' => $config['password']];
        }

        throw new \InvalidArgumentException('Password / key is required.');
    }

    /**
     * Get the configuration for a remote server.
     *
     * @param string $name
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    protected function getConfig($name)
    {
        $config = $this->royalcms['config']['remote::remote.connections.'.$name];

        if (!is_null($config)) {
            return $config;
        }

        throw new \InvalidArgumentException("Remote connection [$name] not defined.");
    }

    /**
     * Get the default connection name.
     *
     * @return string
     */
    public function getDefaultConnection()
    {
        return $this->royalcms['config']['remote::remote.default'];
    }

    /**
     * Get a connection group instance by name.
     *
     * @param string $name
     *
     * @return \Royalcms\Component\Remote\ConnectionInterface
     */
    public function group($name)
    {
        return $this->connection($this->royalcms['config']['remote::remote.groups.'.$name]);
    }

    /**
     * Set the default connection name.
     *
     * @param string $name
     *
     * @return void
     */
    public function setDefaultConnection($name)
    {
        $this->royalcms['config']['remote::remote.default'] = $name;
    }

    /**
     * Dynamically pass methods to the default connection.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->connection(), $method], $parameters);
    }
}
