<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Profiler;

<<<<<<< HEAD
=======
use Psr\Log\LoggerInterface;
>>>>>>> v2-test
use Symfony\Component\HttpFoundation\Exception\ConflictingHeadersException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface;
use Symfony\Component\HttpKernel\DataCollector\LateDataCollectorInterface;
<<<<<<< HEAD
use Psr\Log\LoggerInterface;
=======
use Symfony\Contracts\Service\ResetInterface;
>>>>>>> v2-test

/**
 * Profiler.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
<<<<<<< HEAD
class Profiler
{
    /**
     * @var ProfilerStorageInterface
     */
=======
class Profiler implements ResetInterface
{
>>>>>>> v2-test
    private $storage;

    /**
     * @var DataCollectorInterface[]
     */
<<<<<<< HEAD
    private $collectors = array();

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var bool
     */
    private $enabled = true;

    /**
     * Constructor.
     *
     * @param ProfilerStorageInterface $storage A ProfilerStorageInterface instance
     * @param LoggerInterface          $logger  A LoggerInterface instance
     */
    public function __construct(ProfilerStorageInterface $storage, LoggerInterface $logger = null)
    {
        $this->storage = $storage;
        $this->logger = $logger;
=======
    private $collectors = [];

    private $logger;
    private $initiallyEnabled = true;
    private $enabled = true;

    public function __construct(ProfilerStorageInterface $storage, LoggerInterface $logger = null, bool $enable = true)
    {
        $this->storage = $storage;
        $this->logger = $logger;
        $this->initiallyEnabled = $this->enabled = $enable;
>>>>>>> v2-test
    }

    /**
     * Disables the profiler.
     */
    public function disable()
    {
        $this->enabled = false;
    }

    /**
     * Enables the profiler.
     */
    public function enable()
    {
        $this->enabled = true;
    }

    /**
     * Loads the Profile for the given Response.
     *
<<<<<<< HEAD
     * @param Response $response A Response instance
     *
     * @return Profile|false A Profile instance
=======
     * @return Profile|null A Profile instance
>>>>>>> v2-test
     */
    public function loadProfileFromResponse(Response $response)
    {
        if (!$token = $response->headers->get('X-Debug-Token')) {
<<<<<<< HEAD
            return false;
=======
            return null;
>>>>>>> v2-test
        }

        return $this->loadProfile($token);
    }

    /**
     * Loads the Profile for the given token.
     *
<<<<<<< HEAD
     * @param string $token A token
     *
     * @return Profile A Profile instance
     */
    public function loadProfile($token)
=======
     * @return Profile|null A Profile instance
     */
    public function loadProfile(string $token)
>>>>>>> v2-test
    {
        return $this->storage->read($token);
    }

    /**
     * Saves a Profile.
     *
<<<<<<< HEAD
     * @param Profile $profile A Profile instance
     *
=======
>>>>>>> v2-test
     * @return bool
     */
    public function saveProfile(Profile $profile)
    {
        // late collect
        foreach ($profile->getCollectors() as $collector) {
            if ($collector instanceof LateDataCollectorInterface) {
                $collector->lateCollect();
            }
        }

        if (!($ret = $this->storage->write($profile)) && null !== $this->logger) {
<<<<<<< HEAD
            $this->logger->warning('Unable to store the profiler information.', array('configured_storage' => get_class($this->storage)));
=======
            $this->logger->warning('Unable to store the profiler information.', ['configured_storage' => \get_class($this->storage)]);
>>>>>>> v2-test
        }

        return $ret;
    }

    /**
     * Purges all data from the storage.
     */
    public function purge()
    {
        $this->storage->purge();
    }

    /**
<<<<<<< HEAD
     * Exports the current profiler data.
     *
     * @param Profile $profile A Profile instance
     *
     * @return string The exported data
     */
    public function export(Profile $profile)
    {
        return base64_encode(serialize($profile));
    }

    /**
     * Imports data into the profiler storage.
     *
     * @param string $data A data string as exported by the export() method
     *
     * @return Profile|false A Profile instance
     */
    public function import($data)
    {
        $profile = unserialize(base64_decode($data));

        if ($this->storage->read($profile->getToken())) {
            return false;
        }

        $this->saveProfile($profile);

        return $profile;
    }

    /**
     * Finds profiler tokens for the given criteria.
     *
     * @param string $ip     The IP
     * @param string $url    The URL
     * @param string $limit  The maximum number of tokens to return
     * @param string $method The request method
     * @param string $start  The start date to search from
     * @param string $end    The end date to search to
     *
     * @return array An array of tokens
     *
     * @see http://php.net/manual/en/datetime.formats.php for the supported date/time formats
     */
    public function find($ip, $url, $limit, $method, $start, $end)
    {
        return $this->storage->find($ip, $url, $limit, $method, $this->getTimestamp($start), $this->getTimestamp($end));
=======
     * Finds profiler tokens for the given criteria.
     *
     * @param string|null $limit The maximum number of tokens to return
     * @param string|null $start The start date to search from
     * @param string|null $end   The end date to search to
     *
     * @return array An array of tokens
     *
     * @see https://php.net/datetime.formats for the supported date/time formats
     */
    public function find(?string $ip, ?string $url, ?string $limit, ?string $method, ?string $start, ?string $end, string $statusCode = null)
    {
        return $this->storage->find($ip, $url, $limit, $method, $this->getTimestamp($start), $this->getTimestamp($end), $statusCode);
>>>>>>> v2-test
    }

    /**
     * Collects data for the given Response.
     *
<<<<<<< HEAD
     * @param Request    $request   A Request instance
     * @param Response   $response  A Response instance
     * @param \Exception $exception An exception instance if the request threw one
     *
     * @return Profile|null A Profile instance or null if the profiler is disabled
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        if (false === $this->enabled) {
            return;
=======
     * @return Profile|null A Profile instance or null if the profiler is disabled
     */
    public function collect(Request $request, Response $response, \Throwable $exception = null)
    {
        if (false === $this->enabled) {
            return null;
>>>>>>> v2-test
        }

        $profile = new Profile(substr(hash('sha256', uniqid(mt_rand(), true)), 0, 6));
        $profile->setTime(time());
        $profile->setUrl($request->getUri());
        $profile->setMethod($request->getMethod());
        $profile->setStatusCode($response->getStatusCode());
        try {
            $profile->setIp($request->getClientIp());
        } catch (ConflictingHeadersException $e) {
            $profile->setIp('Unknown');
        }

<<<<<<< HEAD
=======
        if ($prevToken = $response->headers->get('X-Debug-Token')) {
            $response->headers->set('X-Previous-Debug-Token', $prevToken);
        }

>>>>>>> v2-test
        $response->headers->set('X-Debug-Token', $profile->getToken());

        foreach ($this->collectors as $collector) {
            $collector->collect($request, $response, $exception);

            // we need to clone for sub-requests
            $profile->addCollector(clone $collector);
        }

        return $profile;
    }

<<<<<<< HEAD
=======
    public function reset()
    {
        foreach ($this->collectors as $collector) {
            $collector->reset();
        }
        $this->enabled = $this->initiallyEnabled;
    }

>>>>>>> v2-test
    /**
     * Gets the Collectors associated with this profiler.
     *
     * @return array An array of collectors
     */
    public function all()
    {
        return $this->collectors;
    }

    /**
     * Sets the Collectors associated with this profiler.
     *
     * @param DataCollectorInterface[] $collectors An array of collectors
     */
<<<<<<< HEAD
    public function set(array $collectors = array())
    {
        $this->collectors = array();
=======
    public function set(array $collectors = [])
    {
        $this->collectors = [];
>>>>>>> v2-test
        foreach ($collectors as $collector) {
            $this->add($collector);
        }
    }

    /**
     * Adds a Collector.
<<<<<<< HEAD
     *
     * @param DataCollectorInterface $collector A DataCollectorInterface instance
=======
>>>>>>> v2-test
     */
    public function add(DataCollectorInterface $collector)
    {
        $this->collectors[$collector->getName()] = $collector;
    }

    /**
     * Returns true if a Collector for the given name exists.
     *
     * @param string $name A collector name
     *
     * @return bool
     */
<<<<<<< HEAD
    public function has($name)
=======
    public function has(string $name)
>>>>>>> v2-test
    {
        return isset($this->collectors[$name]);
    }

    /**
     * Gets a Collector by name.
     *
     * @param string $name A collector name
     *
     * @return DataCollectorInterface A DataCollectorInterface instance
     *
     * @throws \InvalidArgumentException if the collector does not exist
     */
<<<<<<< HEAD
    public function get($name)
=======
    public function get(string $name)
>>>>>>> v2-test
    {
        if (!isset($this->collectors[$name])) {
            throw new \InvalidArgumentException(sprintf('Collector "%s" does not exist.', $name));
        }

        return $this->collectors[$name];
    }

<<<<<<< HEAD
    private function getTimestamp($value)
    {
        if (null === $value || '' == $value) {
            return;
=======
    private function getTimestamp(?string $value): ?int
    {
        if (null === $value || '' === $value) {
            return null;
>>>>>>> v2-test
        }

        try {
            $value = new \DateTime(is_numeric($value) ? '@'.$value : $value);
        } catch (\Exception $e) {
<<<<<<< HEAD
            return;
=======
            return null;
>>>>>>> v2-test
        }

        return $value->getTimestamp();
    }
}
