<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\DataCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
<<<<<<< HEAD

/**
 * TimeDataCollector.
 *
 * @author Fabien Potencier <fabien@symfony.com>
=======
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\Stopwatch\StopwatchEvent;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @final
>>>>>>> v2-test
 */
class TimeDataCollector extends DataCollector implements LateDataCollectorInterface
{
    protected $kernel;
    protected $stopwatch;

<<<<<<< HEAD
    public function __construct(KernelInterface $kernel = null, $stopwatch = null)
=======
    public function __construct(KernelInterface $kernel = null, Stopwatch $stopwatch = null)
>>>>>>> v2-test
    {
        $this->kernel = $kernel;
        $this->stopwatch = $stopwatch;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function collect(Request $request, Response $response, \Exception $exception = null)
=======
    public function collect(Request $request, Response $response, \Throwable $exception = null)
>>>>>>> v2-test
    {
        if (null !== $this->kernel) {
            $startTime = $this->kernel->getStartTime();
        } else {
<<<<<<< HEAD
            $startTime = $request->server->get('REQUEST_TIME_FLOAT', $request->server->get('REQUEST_TIME'));
        }

        $this->data = array(
            'token' => $response->headers->get('X-Debug-Token'),
            'start_time' => $startTime * 1000,
            'events' => array(),
        );
=======
            $startTime = $request->server->get('REQUEST_TIME_FLOAT');
        }

        $this->data = [
            'token' => $response->headers->get('X-Debug-Token'),
            'start_time' => $startTime * 1000,
            'events' => [],
            'stopwatch_installed' => class_exists(Stopwatch::class, false),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function reset()
    {
        $this->data = [];

        if (null !== $this->stopwatch) {
            $this->stopwatch->reset();
        }
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
    public function lateCollect()
    {
        if (null !== $this->stopwatch && isset($this->data['token'])) {
            $this->setEvents($this->stopwatch->getSectionEvents($this->data['token']));
        }
        unset($this->data['token']);
    }

    /**
     * Sets the request events.
     *
<<<<<<< HEAD
     * @param array $events The request events
=======
     * @param StopwatchEvent[] $events The request events
>>>>>>> v2-test
     */
    public function setEvents(array $events)
    {
        foreach ($events as $event) {
            $event->ensureStopped();
        }

        $this->data['events'] = $events;
    }

    /**
     * Gets the request events.
     *
<<<<<<< HEAD
     * @return array The request events
=======
     * @return StopwatchEvent[] The request events
>>>>>>> v2-test
     */
    public function getEvents()
    {
        return $this->data['events'];
    }

    /**
     * Gets the request elapsed time.
     *
     * @return float The elapsed time
     */
    public function getDuration()
    {
        if (!isset($this->data['events']['__section__'])) {
            return 0;
        }

        $lastEvent = $this->data['events']['__section__'];

        return $lastEvent->getOrigin() + $lastEvent->getDuration() - $this->getStartTime();
    }

    /**
     * Gets the initialization time.
     *
     * This is the time spent until the beginning of the request handling.
     *
     * @return float The elapsed time
     */
    public function getInitTime()
    {
        if (!isset($this->data['events']['__section__'])) {
            return 0;
        }

        return $this->data['events']['__section__']->getOrigin() - $this->getStartTime();
    }

    /**
     * Gets the request time.
     *
<<<<<<< HEAD
     * @return int The time
=======
     * @return float
>>>>>>> v2-test
     */
    public function getStartTime()
    {
        return $this->data['start_time'];
    }

    /**
<<<<<<< HEAD
=======
     * @return bool whether or not the stopwatch component is installed
     */
    public function isStopwatchInstalled()
    {
        return $this->data['stopwatch_installed'];
    }

    /**
>>>>>>> v2-test
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'time';
    }
}
