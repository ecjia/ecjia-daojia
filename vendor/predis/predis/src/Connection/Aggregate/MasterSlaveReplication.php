<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Connection\Aggregate;

<<<<<<< HEAD
use Predis\Command\CommandInterface;
use Predis\Connection\NodeConnectionInterface;
use Predis\Replication\ReplicationStrategy;
=======
use Predis\ClientException;
use Predis\Command\CommandInterface;
use Predis\Command\RawCommand;
use Predis\Connection\ConnectionException;
use Predis\Connection\FactoryInterface;
use Predis\Connection\NodeConnectionInterface;
use Predis\Replication\MissingMasterException;
use Predis\Replication\ReplicationStrategy;
use Predis\Response\ErrorInterface as ResponseErrorInterface;
>>>>>>> v2-test

/**
 * Aggregate connection handling replication of Redis nodes configured in a
 * single master / multiple slaves setup.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class MasterSlaveReplication implements ReplicationInterface
{
    /**
     * @var ReplicationStrategy
     */
    protected $strategy;

    /**
     * @var NodeConnectionInterface
     */
    protected $master;

    /**
     * @var NodeConnectionInterface[]
     */
    protected $slaves = array();

    /**
     * @var NodeConnectionInterface
     */
    protected $current;

    /**
<<<<<<< HEAD
=======
     * @var bool
     */
    protected $autoDiscovery = false;

    /**
     * @var FactoryInterface
     */
    protected $connectionFactory;

    /**
>>>>>>> v2-test
     * {@inheritdoc}
     */
    public function __construct(ReplicationStrategy $strategy = null)
    {
        $this->strategy = $strategy ?: new ReplicationStrategy();
    }

    /**
<<<<<<< HEAD
     * Checks if one master and at least one slave have been defined.
     */
    protected function check()
    {
        if (!isset($this->master) || !$this->slaves) {
            throw new \RuntimeException('Replication needs one master and at least one slave.');
        }
=======
     * Configures the automatic discovery of the replication configuration on failure.
     *
     * @param bool $value Enable or disable auto discovery.
     */
    public function setAutoDiscovery($value)
    {
        if (!$this->connectionFactory) {
            throw new ClientException('Automatic discovery requires a connection factory');
        }

        $this->autoDiscovery = (bool) $value;
    }

    /**
     * Sets the connection factory used to create the connections by the auto
     * discovery procedure.
     *
     * @param FactoryInterface $connectionFactory Connection factory instance.
     */
    public function setConnectionFactory(FactoryInterface $connectionFactory)
    {
        $this->connectionFactory = $connectionFactory;
>>>>>>> v2-test
    }

    /**
     * Resets the connection state.
     */
    protected function reset()
    {
        $this->current = null;
    }

    /**
     * {@inheritdoc}
     */
    public function add(NodeConnectionInterface $connection)
    {
        $alias = $connection->getParameters()->alias;

        if ($alias === 'master') {
            $this->master = $connection;
        } else {
<<<<<<< HEAD
            $this->slaves[$alias ?: count($this->slaves)] = $connection;
=======
            $this->slaves[$alias ?: "slave-$connection"] = $connection;
>>>>>>> v2-test
        }

        $this->reset();
    }

    /**
     * {@inheritdoc}
     */
    public function remove(NodeConnectionInterface $connection)
    {
        if ($connection->getParameters()->alias === 'master') {
            $this->master = null;
            $this->reset();

            return true;
        } else {
            if (($id = array_search($connection, $this->slaves, true)) !== false) {
                unset($this->slaves[$id]);
                $this->reset();

                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getConnection(CommandInterface $command)
    {
<<<<<<< HEAD
        if ($this->current === null) {
            $this->check();
            $this->current = $this->strategy->isReadOperation($command)
                ? $this->pickSlave()
                : $this->master;
=======
        if (!$this->current) {
            if ($this->strategy->isReadOperation($command) && $slave = $this->pickSlave()) {
                $this->current = $slave;
            } else {
                $this->current = $this->getMasterOrDie();
            }
>>>>>>> v2-test

            return $this->current;
        }

<<<<<<< HEAD
        if ($this->current === $this->master) {
            return $this->current;
        }

        if (!$this->strategy->isReadOperation($command)) {
            $this->current = $this->master;
=======
        if ($this->current === $master = $this->getMasterOrDie()) {
            return $master;
        }

        if (!$this->strategy->isReadOperation($command) || !$this->slaves) {
            $this->current = $master;
>>>>>>> v2-test
        }

        return $this->current;
    }

    /**
     * {@inheritdoc}
     */
    public function getConnectionById($connectionId)
    {
        if ($connectionId === 'master') {
            return $this->master;
        }

        if (isset($this->slaves[$connectionId])) {
            return $this->slaves[$connectionId];
        }

        return;
    }

    /**
     * {@inheritdoc}
     */
    public function switchTo($connection)
    {
<<<<<<< HEAD
        $this->check();

=======
>>>>>>> v2-test
        if (!$connection instanceof NodeConnectionInterface) {
            $connection = $this->getConnectionById($connection);
        }

<<<<<<< HEAD
=======
        if (!$connection) {
            throw new \InvalidArgumentException('Invalid connection or connection not found.');
        }

>>>>>>> v2-test
        if ($connection !== $this->master && !in_array($connection, $this->slaves, true)) {
            throw new \InvalidArgumentException('Invalid connection or connection not found.');
        }

        $this->current = $connection;
    }

    /**
<<<<<<< HEAD
=======
     * Switches to the master server.
     */
    public function switchToMaster()
    {
        $this->switchTo('master');
    }

    /**
     * Switches to a random slave server.
     */
    public function switchToSlave()
    {
        $connection = $this->pickSlave();
        $this->switchTo($connection);
    }

    /**
>>>>>>> v2-test
     * {@inheritdoc}
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * {@inheritdoc}
     */
    public function getMaster()
    {
        return $this->master;
    }

    /**
<<<<<<< HEAD
=======
     * Returns the connection associated to the master server.
     *
     * @return NodeConnectionInterface
     */
    private function getMasterOrDie()
    {
        if (!$connection = $this->getMaster()) {
            throw new MissingMasterException('No master server available for replication');
        }

        return $connection;
    }

    /**
>>>>>>> v2-test
     * {@inheritdoc}
     */
    public function getSlaves()
    {
        return array_values($this->slaves);
    }

    /**
     * Returns the underlying replication strategy.
     *
     * @return ReplicationStrategy
     */
    public function getReplicationStrategy()
    {
        return $this->strategy;
    }

    /**
     * Returns a random slave.
     *
     * @return NodeConnectionInterface
     */
    protected function pickSlave()
    {
        if ($this->slaves) {
            return $this->slaves[array_rand($this->slaves)];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isConnected()
    {
        return $this->current ? $this->current->isConnected() : false;
    }

    /**
     * {@inheritdoc}
     */
    public function connect()
    {
<<<<<<< HEAD
        if ($this->current === null) {
            $this->check();
            $this->current = $this->pickSlave();
=======
        if (!$this->current) {
            if (!$this->current = $this->pickSlave()) {
                if (!$this->current = $this->getMaster()) {
                    throw new ClientException('No available connection for replication');
                }
            }
>>>>>>> v2-test
        }

        $this->current->connect();
    }

    /**
     * {@inheritdoc}
     */
    public function disconnect()
    {
        if ($this->master) {
            $this->master->disconnect();
        }

        foreach ($this->slaves as $connection) {
            $connection->disconnect();
        }
    }

    /**
<<<<<<< HEAD
=======
     * Handles response from INFO.
     *
     * @param string $response
     *
     * @return array
     */
    private function handleInfoResponse($response)
    {
        $info = array();

        foreach (preg_split('/\r?\n/', $response) as $row) {
            if (strpos($row, ':') === false) {
                continue;
            }

            list($k, $v) = explode(':', $row, 2);
            $info[$k] = $v;
        }

        return $info;
    }

    /**
     * Fetches the replication configuration from one of the servers.
     */
    public function discover()
    {
        if (!$this->connectionFactory) {
            throw new ClientException('Discovery requires a connection factory');
        }

        RETRY_FETCH: {
            try {
                if ($connection = $this->getMaster()) {
                    $this->discoverFromMaster($connection, $this->connectionFactory);
                } elseif ($connection = $this->pickSlave()) {
                    $this->discoverFromSlave($connection, $this->connectionFactory);
                } else {
                    throw new ClientException('No connection available for discovery');
                }
            } catch (ConnectionException $exception) {
                $this->remove($connection);
                goto RETRY_FETCH;
            }
        }
    }

    /**
     * Discovers the replication configuration by contacting the master node.
     *
     * @param NodeConnectionInterface $connection        Connection to the master node.
     * @param FactoryInterface        $connectionFactory Connection factory instance.
     */
    protected function discoverFromMaster(NodeConnectionInterface $connection, FactoryInterface $connectionFactory)
    {
        $response = $connection->executeCommand(RawCommand::create('INFO', 'REPLICATION'));
        $replication = $this->handleInfoResponse($response);

        if ($replication['role'] !== 'master') {
            throw new ClientException("Role mismatch (expected master, got slave) [$connection]");
        }

        $this->slaves = array();

        foreach ($replication as $k => $v) {
            $parameters = null;

            if (strpos($k, 'slave') === 0 && preg_match('/ip=(?P<host>.*),port=(?P<port>\d+)/', $v, $parameters)) {
                $slaveConnection = $connectionFactory->create(array(
                    'host' => $parameters['host'],
                    'port' => $parameters['port'],
                ));

                $this->add($slaveConnection);
            }
        }
    }

    /**
     * Discovers the replication configuration by contacting one of the slaves.
     *
     * @param NodeConnectionInterface $connection        Connection to one of the slaves.
     * @param FactoryInterface        $connectionFactory Connection factory instance.
     */
    protected function discoverFromSlave(NodeConnectionInterface $connection, FactoryInterface $connectionFactory)
    {
        $response = $connection->executeCommand(RawCommand::create('INFO', 'REPLICATION'));
        $replication = $this->handleInfoResponse($response);

        if ($replication['role'] !== 'slave') {
            throw new ClientException("Role mismatch (expected slave, got master) [$connection]");
        }

        $masterConnection = $connectionFactory->create(array(
            'host' => $replication['master_host'],
            'port' => $replication['master_port'],
            'alias' => 'master',
        ));

        $this->add($masterConnection);

        $this->discoverFromMaster($masterConnection, $connectionFactory);
    }

    /**
     * Retries the execution of a command upon slave failure.
     *
     * @param CommandInterface $command Command instance.
     * @param string           $method  Actual method.
     *
     * @return mixed
     */
    private function retryCommandOnFailure(CommandInterface $command, $method)
    {
        RETRY_COMMAND: {
            try {
                $connection = $this->getConnection($command);
                $response = $connection->$method($command);

                if ($response instanceof ResponseErrorInterface && $response->getErrorType() === 'LOADING') {
                    throw new ConnectionException($connection, "Redis is loading the dataset in memory [$connection]");
                }
            } catch (ConnectionException $exception) {
                $connection = $exception->getConnection();
                $connection->disconnect();

                if ($connection === $this->master && !$this->autoDiscovery) {
                    // Throw immediately when master connection is failing, even
                    // when the command represents a read-only operation, unless
                    // automatic discovery has been enabled.
                    throw $exception;
                } else {
                    // Otherwise remove the failing slave and attempt to execute
                    // the command again on one of the remaining slaves...
                    $this->remove($connection);
                }

                // ... that is, unless we have no more connections to use.
                if (!$this->slaves && !$this->master) {
                    throw $exception;
                } elseif ($this->autoDiscovery) {
                    $this->discover();
                }

                goto RETRY_COMMAND;
            } catch (MissingMasterException $exception) {
                if ($this->autoDiscovery) {
                    $this->discover();
                } else {
                    throw $exception;
                }

                goto RETRY_COMMAND;
            }
        }

        return $response;
    }

    /**
>>>>>>> v2-test
     * {@inheritdoc}
     */
    public function writeRequest(CommandInterface $command)
    {
<<<<<<< HEAD
        $this->getConnection($command)->writeRequest($command);
=======
        $this->retryCommandOnFailure($command, __FUNCTION__);
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
    public function readResponse(CommandInterface $command)
    {
<<<<<<< HEAD
        return $this->getConnection($command)->readResponse($command);
=======
        return $this->retryCommandOnFailure($command, __FUNCTION__);
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
    public function executeCommand(CommandInterface $command)
    {
<<<<<<< HEAD
        return $this->getConnection($command)->executeCommand($command);
=======
        return $this->retryCommandOnFailure($command, __FUNCTION__);
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
    public function __sleep()
    {
        return array('master', 'slaves', 'strategy');
    }
}
