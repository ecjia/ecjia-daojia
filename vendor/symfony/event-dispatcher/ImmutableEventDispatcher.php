<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\EventDispatcher;

/**
 * A read-only proxy for an event dispatcher.
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class ImmutableEventDispatcher implements EventDispatcherInterface
{
<<<<<<< HEAD
    /**
     * The proxied dispatcher.
     *
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * Creates an unmodifiable proxy for an event dispatcher.
     *
     * @param EventDispatcherInterface $dispatcher The proxied event dispatcher
     */
=======
    private $dispatcher;

>>>>>>> v2-test
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function dispatch($eventName, Event $event = null)
    {
        return $this->dispatcher->dispatch($eventName, $event);
=======
    public function dispatch(object $event, string $eventName = null): object
    {
        return $this->dispatcher->dispatch($event, $eventName);
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
        throw new \BadMethodCallException('Unmodifiable event dispatchers must not be modified.');
    }

    /**
     * {@inheritdoc}
     */
    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        throw new \BadMethodCallException('Unmodifiable event dispatchers must not be modified.');
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
        throw new \BadMethodCallException('Unmodifiable event dispatchers must not be modified.');
    }

    /**
     * {@inheritdoc}
     */
    public function removeSubscriber(EventSubscriberInterface $subscriber)
    {
        throw new \BadMethodCallException('Unmodifiable event dispatchers must not be modified.');
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
=======
    public function getListenerPriority(string $eventName, $listener)
>>>>>>> v2-test
    {
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
}
