<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\EventDispatcher\Debug;

<<<<<<< HEAD
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Stopwatch\Stopwatch;
use Psr\Log\LoggerInterface;
=======
use Psr\EventDispatcher\StoppableEventInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Contracts\Service\ResetInterface;
>>>>>>> v2-test

/**
 * Collects some data about event listeners.
 *
 * This event dispatcher delegates the dispatching to another one.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
<<<<<<< HEAD
class TraceableEventDispatcher implements TraceableEventDispatcherInterface
=======
class TraceableEventDispatcher implements EventDispatcherInterface, ResetInterface
>>>>>>> v2-test
{
    protected $logger;
    protected $stopwatch;

<<<<<<< HEAD
    private $called;
    private $dispatcher;
    private $wrappedListeners;

    /**
     * Constructor.
     *
     * @param EventDispatcherInterface $dispatcher An EventDispatcherInterface instance
     * @param Stopwatch                $stopwatch  A Stopwatch instance
     * @param LoggerInterface          $logger     A LoggerInterface instance
     */
    public function __construct(EventDispatcherInterface $dispatcher, Stopwatch $stopwatch, LoggerInterface $logger = null)
=======
    private $callStack;
    private $dispatcher;
    private $wrappedListeners;
    private $orphanedEvents;
    private $requestStack;
    private $currentRequestHash = '';

    public function __construct(EventDispatcherInterface $dispatcher, Stopwatch $stopwatch, LoggerInterface $logger = null, RequestStack $requestStack = null)
>>>>>>> v2-test
    {
        $this->dispatcher = $dispatcher;
        $this->stopwatch = $stopwatch;
        $this->logger = $logger;
<<<<<<< HEAD
        $this->called = array();
        $this->wrappedListeners = array();
=======
        $this->wrappedListeners = [];
        $this->orphanedEvents = [];
        $this->requestStack = $requestStack;
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function addListener($eventName, $listener, $priority = 0)
=======
    public function addListener(string $eventName, $listener, int $priority = 0)
>>>>>>> v2-test
    {
        $this->dispatcher->addListener($eventName, $listener, $priority);
    }

    /**
     * {@inheritdoc}
     */
    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->dispatcher->addSubscriber($subscriber);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function removeListener($eventName, $listener)
=======
    public function removeListener(string $eventName, $listener)
>>>>>>> v2-test
    {
        if (isset($this->wrappedListeners[$eventName])) {
            foreach ($this->wrappedListeners[$eventName] as $index => $wrappedListener) {
                if ($wrappedListener->getWrappedListener() === $listener) {
                    $listener = $wrappedListener;
                    unset($this->wrappedListeners[$eventName][$index]);
                    break;
                }
            }
        }

        return $this->dispatcher->removeListener($eventName, $listener);
    }

    /**
     * {@inheritdoc}
     */
    public function removeSubscriber(EventSubscriberInterface $subscriber)
    {
        return $this->dispatcher->removeSubscriber($subscriber);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getListeners($eventName = null)
=======
    public function getListeners(string $eventName = null)
>>>>>>> v2-test
    {
        return $this->dispatcher->getListeners($eventName);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getListenerPriority($eventName, $listener)
    {
        if (!method_exists($this->dispatcher, 'getListenerPriority')) {
            return 0;
=======
    public function getListenerPriority(string $eventName, $listener)
    {
        // we might have wrapped listeners for the event (if called while dispatching)
        // in that case get the priority by wrapper
        if (isset($this->wrappedListeners[$eventName])) {
            foreach ($this->wrappedListeners[$eventName] as $index => $wrappedListener) {
                if ($wrappedListener->getWrappedListener() === $listener) {
                    return $this->dispatcher->getListenerPriority($eventName, $wrappedListener);
                }
            }
>>>>>>> v2-test
        }

        return $this->dispatcher->getListenerPriority($eventName, $listener);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function hasListeners($eventName = null)
=======
    public function hasListeners(string $eventName = null)
>>>>>>> v2-test
    {
        return $this->dispatcher->hasListeners($eventName);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function dispatch($eventName, Event $event = null)
    {
        if (null === $event) {
            $event = new Event();
        }

        if (null !== $this->logger && $event->isPropagationStopped()) {
=======
    public function dispatch(object $event, string $eventName = null): object
    {
        $eventName = $eventName ?? \get_class($event);

        if (null === $this->callStack) {
            $this->callStack = new \SplObjectStorage();
        }

        $currentRequestHash = $this->currentRequestHash = $this->requestStack && ($request = $this->requestStack->getCurrentRequest()) ? spl_object_hash($request) : '';

        if (null !== $this->logger && $event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
>>>>>>> v2-test
            $this->logger->debug(sprintf('The "%s" event is already stopped. No listeners have been called.', $eventName));
        }

        $this->preProcess($eventName);
<<<<<<< HEAD
        $this->preDispatch($eventName, $event);

        $e = $this->stopwatch->start($eventName, 'section');

        $this->dispatcher->dispatch($eventName, $event);

        if ($e->isStarted()) {
            $e->stop();
        }

        $this->postDispatch($eventName, $event);
        $this->postProcess($eventName);

=======
        try {
            $this->beforeDispatch($eventName, $event);
            try {
                $e = $this->stopwatch->start($eventName, 'section');
                try {
                    $this->dispatcher->dispatch($event, $eventName);
                } finally {
                    if ($e->isStarted()) {
                        $e->stop();
                    }
                }
            } finally {
                $this->afterDispatch($eventName, $event);
            }
        } finally {
            $this->currentRequestHash = $currentRequestHash;
            $this->postProcess($eventName);
        }

>>>>>>> v2-test
        return $event;
    }

    /**
<<<<<<< HEAD
     * {@inheritdoc}
     */
    public function getCalledListeners()
    {
        $called = array();
        foreach ($this->called as $eventName => $listeners) {
            foreach ($listeners as $listener) {
                $info = $this->getListenerInfo($listener->getWrappedListener(), $eventName);
                $called[$eventName.'.'.$info['pretty']] = $info;
=======
     * @return array
     */
    public function getCalledListeners(Request $request = null)
    {
        if (null === $this->callStack) {
            return [];
        }

        $hash = $request ? spl_object_hash($request) : null;
        $called = [];
        foreach ($this->callStack as $listener) {
            [$eventName, $requestHash] = $this->callStack->getInfo();
            if (null === $hash || $hash === $requestHash) {
                $called[] = $listener->getInfo($eventName);
>>>>>>> v2-test
            }
        }

        return $called;
    }

    /**
<<<<<<< HEAD
     * {@inheritdoc}
     */
    public function getNotCalledListeners()
=======
     * @return array
     */
    public function getNotCalledListeners(Request $request = null)
>>>>>>> v2-test
    {
        try {
            $allListeners = $this->getListeners();
        } catch (\Exception $e) {
            if (null !== $this->logger) {
<<<<<<< HEAD
                $this->logger->info('An exception was thrown while getting the uncalled listeners.', array('exception' => $e));
            }

            // unable to retrieve the uncalled listeners
            return array();
        }

        $notCalled = array();
        foreach ($allListeners as $eventName => $listeners) {
            foreach ($listeners as $listener) {
                $called = false;
                if (isset($this->called[$eventName])) {
                    foreach ($this->called[$eventName] as $l) {
                        if ($l->getWrappedListener() === $listener) {
                            $called = true;

                            break;
                        }
                    }
                }

                if (!$called) {
                    $info = $this->getListenerInfo($listener, $eventName);
                    $notCalled[$eventName.'.'.$info['pretty']] = $info;
=======
                $this->logger->info('An exception was thrown while getting the uncalled listeners.', ['exception' => $e]);
            }

            // unable to retrieve the uncalled listeners
            return [];
        }

        $hash = $request ? spl_object_hash($request) : null;
        $calledListeners = [];

        if (null !== $this->callStack) {
            foreach ($this->callStack as $calledListener) {
                [, $requestHash] = $this->callStack->getInfo();

                if (null === $hash || $hash === $requestHash) {
                    $calledListeners[] = $calledListener->getWrappedListener();
                }
            }
        }

        $notCalled = [];
        foreach ($allListeners as $eventName => $listeners) {
            foreach ($listeners as $listener) {
                if (!\in_array($listener, $calledListeners, true)) {
                    if (!$listener instanceof WrappedListener) {
                        $listener = new WrappedListener($listener, null, $this->stopwatch, $this);
                    }
                    $notCalled[] = $listener->getInfo($eventName);
>>>>>>> v2-test
                }
            }
        }

<<<<<<< HEAD
        uasort($notCalled, array($this, 'sortListenersByPriority'));
=======
        uasort($notCalled, [$this, 'sortNotCalledListeners']);
>>>>>>> v2-test

        return $notCalled;
    }

<<<<<<< HEAD
=======
    public function getOrphanedEvents(Request $request = null): array
    {
        if ($request) {
            return $this->orphanedEvents[spl_object_hash($request)] ?? [];
        }

        if (!$this->orphanedEvents) {
            return [];
        }

        return array_merge(...array_values($this->orphanedEvents));
    }

    public function reset()
    {
        $this->callStack = null;
        $this->orphanedEvents = [];
        $this->currentRequestHash = '';
    }

>>>>>>> v2-test
    /**
     * Proxies all method calls to the original event dispatcher.
     *
     * @param string $method    The method name
     * @param array  $arguments The method arguments
     *
     * @return mixed
     */
<<<<<<< HEAD
    public function __call($method, $arguments)
    {
        return call_user_func_array(array($this->dispatcher, $method), $arguments);
=======
    public function __call(string $method, array $arguments)
    {
        return $this->dispatcher->{$method}(...$arguments);
>>>>>>> v2-test
    }

    /**
     * Called before dispatching the event.
<<<<<<< HEAD
     *
     * @param string $eventName The event name
     * @param Event  $event     The event
     */
    protected function preDispatch($eventName, Event $event)
=======
     */
    protected function beforeDispatch(string $eventName, object $event)
>>>>>>> v2-test
    {
    }

    /**
     * Called after dispatching the event.
<<<<<<< HEAD
     *
     * @param string $eventName The event name
     * @param Event  $event     The event
     */
    protected function postDispatch($eventName, Event $event)
    {
    }

    private function preProcess($eventName)
    {
        foreach ($this->dispatcher->getListeners($eventName) as $listener) {
            $info = $this->getListenerInfo($listener, $eventName);
            $name = isset($info['class']) ? $info['class'] : $info['type'];
            $wrappedListener = new WrappedListener($listener, $name, $this->stopwatch, $this);
            $this->wrappedListeners[$eventName][] = $wrappedListener;
            $this->dispatcher->removeListener($eventName, $listener);
            $this->dispatcher->addListener($eventName, $wrappedListener, $info['priority']);
        }
    }

    private function postProcess($eventName)
=======
     */
    protected function afterDispatch(string $eventName, object $event)
    {
    }

    private function preProcess(string $eventName): void
    {
        if (!$this->dispatcher->hasListeners($eventName)) {
            $this->orphanedEvents[$this->currentRequestHash][] = $eventName;

            return;
        }

        foreach ($this->dispatcher->getListeners($eventName) as $listener) {
            $priority = $this->getListenerPriority($eventName, $listener);
            $wrappedListener = new WrappedListener($listener instanceof WrappedListener ? $listener->getWrappedListener() : $listener, null, $this->stopwatch, $this);
            $this->wrappedListeners[$eventName][] = $wrappedListener;
            $this->dispatcher->removeListener($eventName, $listener);
            $this->dispatcher->addListener($eventName, $wrappedListener, $priority);
            $this->callStack->attach($wrappedListener, [$eventName, $this->currentRequestHash]);
        }
    }

    private function postProcess(string $eventName): void
>>>>>>> v2-test
    {
        unset($this->wrappedListeners[$eventName]);
        $skipped = false;
        foreach ($this->dispatcher->getListeners($eventName) as $listener) {
            if (!$listener instanceof WrappedListener) { // #12845: a new listener was added during dispatch.
                continue;
            }
            // Unwrap listener
            $priority = $this->getListenerPriority($eventName, $listener);
            $this->dispatcher->removeListener($eventName, $listener);
            $this->dispatcher->addListener($eventName, $listener->getWrappedListener(), $priority);

<<<<<<< HEAD
            $info = $this->getListenerInfo($listener->getWrappedListener(), $eventName);
            if ($listener->wasCalled()) {
                if (null !== $this->logger) {
                    $this->logger->debug(sprintf('Notified event "%s" to listener "%s".', $eventName, $info['pretty']));
                }

                if (!isset($this->called[$eventName])) {
                    $this->called[$eventName] = new \SplObjectStorage();
                }

                $this->called[$eventName]->attach($listener);
            }

            if (null !== $this->logger && $skipped) {
                $this->logger->debug(sprintf('Listener "%s" was not called for event "%s".', $info['pretty'], $eventName));
=======
            if (null !== $this->logger) {
                $context = ['event' => $eventName, 'listener' => $listener->getPretty()];
            }

            if ($listener->wasCalled()) {
                if (null !== $this->logger) {
                    $this->logger->debug('Notified event "{event}" to listener "{listener}".', $context);
                }
            } else {
                $this->callStack->detach($listener);
            }

            if (null !== $this->logger && $skipped) {
                $this->logger->debug('Listener "{listener}" was not called for event "{event}".', $context);
>>>>>>> v2-test
            }

            if ($listener->stoppedPropagation()) {
                if (null !== $this->logger) {
<<<<<<< HEAD
                    $this->logger->debug(sprintf('Listener "%s" stopped propagation of the event "%s".', $info['pretty'], $eventName));
=======
                    $this->logger->debug('Listener "{listener}" stopped propagation of the event "{event}".', $context);
>>>>>>> v2-test
                }

                $skipped = true;
            }
        }
    }

<<<<<<< HEAD
    /**
     * Returns information about the listener.
     *
     * @param object $listener  The listener
     * @param string $eventName The event name
     *
     * @return array Information about the listener
     */
    private function getListenerInfo($listener, $eventName)
    {
        $info = array(
            'event' => $eventName,
            'priority' => $this->getListenerPriority($eventName, $listener),
        );
        if ($listener instanceof \Closure) {
            $info += array(
                'type' => 'Closure',
                'pretty' => 'closure',
            );
        } elseif (is_string($listener)) {
            try {
                $r = new \ReflectionFunction($listener);
                $file = $r->getFileName();
                $line = $r->getStartLine();
            } catch (\ReflectionException $e) {
                $file = null;
                $line = null;
            }
            $info += array(
                'type' => 'Function',
                'function' => $listener,
                'file' => $file,
                'line' => $line,
                'pretty' => $listener,
            );
        } elseif (is_array($listener) || (is_object($listener) && is_callable($listener))) {
            if (!is_array($listener)) {
                $listener = array($listener, '__invoke');
            }
            $class = is_object($listener[0]) ? get_class($listener[0]) : $listener[0];
            try {
                $r = new \ReflectionMethod($class, $listener[1]);
                $file = $r->getFileName();
                $line = $r->getStartLine();
            } catch (\ReflectionException $e) {
                $file = null;
                $line = null;
            }
            $info += array(
                'type' => 'Method',
                'class' => $class,
                'method' => $listener[1],
                'file' => $file,
                'line' => $line,
                'pretty' => $class.'::'.$listener[1],
            );
        }

        return $info;
    }

    private function sortListenersByPriority($a, $b)
    {
        if (is_int($a['priority']) && !is_int($b['priority'])) {
            return 1;
        }

        if (!is_int($a['priority']) && is_int($b['priority'])) {
=======
    private function sortNotCalledListeners(array $a, array $b)
    {
        if (0 !== $cmp = strcmp($a['event'], $b['event'])) {
            return $cmp;
        }

        if (\is_int($a['priority']) && !\is_int($b['priority'])) {
            return 1;
        }

        if (!\is_int($a['priority']) && \is_int($b['priority'])) {
>>>>>>> v2-test
            return -1;
        }

        if ($a['priority'] === $b['priority']) {
            return 0;
        }

        if ($a['priority'] > $b['priority']) {
            return -1;
        }

        return 1;
    }
}
