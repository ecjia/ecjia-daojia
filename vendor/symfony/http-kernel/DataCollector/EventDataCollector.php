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

<<<<<<< HEAD
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\Debug\TraceableEventDispatcherInterface;
=======
use Symfony\Component\EventDispatcher\Debug\TraceableEventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Service\ResetInterface;
>>>>>>> v2-test

/**
 * EventDataCollector.
 *
 * @author Fabien Potencier <fabien@symfony.com>
<<<<<<< HEAD
=======
 *
 * @final
>>>>>>> v2-test
 */
class EventDataCollector extends DataCollector implements LateDataCollectorInterface
{
    protected $dispatcher;
<<<<<<< HEAD

    public function __construct(EventDispatcherInterface $dispatcher = null)
    {
        $this->dispatcher = $dispatcher;
=======
    private $requestStack;
    private $currentRequest;

    public function __construct(EventDispatcherInterface $dispatcher = null, RequestStack $requestStack = null)
    {
        $this->dispatcher = $dispatcher;
        $this->requestStack = $requestStack;
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = array(
            'called_listeners' => array(),
            'not_called_listeners' => array(),
        );
=======
    public function collect(Request $request, Response $response, \Throwable $exception = null)
    {
        $this->currentRequest = $this->requestStack && $this->requestStack->getMasterRequest() !== $request ? $request : null;
        $this->data = [
            'called_listeners' => [],
            'not_called_listeners' => [],
            'orphaned_events' => [],
        ];
    }

    public function reset()
    {
        $this->data = [];

        if ($this->dispatcher instanceof ResetInterface) {
            $this->dispatcher->reset();
        }
>>>>>>> v2-test
    }

    public function lateCollect()
    {
<<<<<<< HEAD
        if ($this->dispatcher instanceof TraceableEventDispatcherInterface) {
            $this->setCalledListeners($this->dispatcher->getCalledListeners());
            $this->setNotCalledListeners($this->dispatcher->getNotCalledListeners());
        }
=======
        if ($this->dispatcher instanceof TraceableEventDispatcher) {
            $this->setCalledListeners($this->dispatcher->getCalledListeners($this->currentRequest));
            $this->setNotCalledListeners($this->dispatcher->getNotCalledListeners($this->currentRequest));
            $this->setOrphanedEvents($this->dispatcher->getOrphanedEvents($this->currentRequest));
        }

        $this->data = $this->cloneVar($this->data);
>>>>>>> v2-test
    }

    /**
     * Sets the called listeners.
     *
     * @param array $listeners An array of called listeners
     *
<<<<<<< HEAD
     * @see TraceableEventDispatcherInterface
=======
     * @see TraceableEventDispatcher
>>>>>>> v2-test
     */
    public function setCalledListeners(array $listeners)
    {
        $this->data['called_listeners'] = $listeners;
    }

    /**
     * Gets the called listeners.
     *
     * @return array An array of called listeners
     *
<<<<<<< HEAD
     * @see TraceableEventDispatcherInterface
=======
     * @see TraceableEventDispatcher
>>>>>>> v2-test
     */
    public function getCalledListeners()
    {
        return $this->data['called_listeners'];
    }

    /**
     * Sets the not called listeners.
     *
<<<<<<< HEAD
     * @param array $listeners An array of not called listeners
     *
     * @see TraceableEventDispatcherInterface
=======
     * @see TraceableEventDispatcher
>>>>>>> v2-test
     */
    public function setNotCalledListeners(array $listeners)
    {
        $this->data['not_called_listeners'] = $listeners;
    }

    /**
     * Gets the not called listeners.
     *
<<<<<<< HEAD
     * @return array An array of not called listeners
     *
     * @see TraceableEventDispatcherInterface
=======
     * @return array
     *
     * @see TraceableEventDispatcher
>>>>>>> v2-test
     */
    public function getNotCalledListeners()
    {
        return $this->data['not_called_listeners'];
    }

    /**
<<<<<<< HEAD
=======
     * Sets the orphaned events.
     *
     * @param array $events An array of orphaned events
     *
     * @see TraceableEventDispatcher
     */
    public function setOrphanedEvents(array $events)
    {
        $this->data['orphaned_events'] = $events;
    }

    /**
     * Gets the orphaned events.
     *
     * @return array An array of orphaned events
     *
     * @see TraceableEventDispatcher
     */
    public function getOrphanedEvents()
    {
        return $this->data['orphaned_events'];
    }

    /**
>>>>>>> v2-test
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'events';
    }
}
