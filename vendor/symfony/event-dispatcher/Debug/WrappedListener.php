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
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
=======
use Psr\EventDispatcher\StoppableEventInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\VarDumper\Caster\ClassStub;
>>>>>>> v2-test

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
<<<<<<< HEAD
class WrappedListener
{
    private $listener;
=======
final class WrappedListener
{
    private $listener;
    private $optimizedListener;
>>>>>>> v2-test
    private $name;
    private $called;
    private $stoppedPropagation;
    private $stopwatch;
    private $dispatcher;
<<<<<<< HEAD

    public function __construct($listener, $name, Stopwatch $stopwatch, EventDispatcherInterface $dispatcher = null)
    {
        $this->listener = $listener;
        $this->name = $name;
=======
    private $pretty;
    private $stub;
    private $priority;
    private static $hasClassStub;

    public function __construct($listener, ?string $name, Stopwatch $stopwatch, EventDispatcherInterface $dispatcher = null)
    {
        $this->listener = $listener;
        $this->optimizedListener = $listener instanceof \Closure ? $listener : (\is_callable($listener) ? \Closure::fromCallable($listener) : null);
>>>>>>> v2-test
        $this->stopwatch = $stopwatch;
        $this->dispatcher = $dispatcher;
        $this->called = false;
        $this->stoppedPropagation = false;
<<<<<<< HEAD
=======

        if (\is_array($listener)) {
            $this->name = \is_object($listener[0]) ? get_debug_type($listener[0]) : $listener[0];
            $this->pretty = $this->name.'::'.$listener[1];
        } elseif ($listener instanceof \Closure) {
            $r = new \ReflectionFunction($listener);
            if (false !== strpos($r->name, '{closure}')) {
                $this->pretty = $this->name = 'closure';
            } elseif ($class = $r->getClosureScopeClass()) {
                $this->name = $class->name;
                $this->pretty = $this->name.'::'.$r->name;
            } else {
                $this->pretty = $this->name = $r->name;
            }
        } elseif (\is_string($listener)) {
            $this->pretty = $this->name = $listener;
        } else {
            $this->name = get_debug_type($listener);
            $this->pretty = $this->name.'::__invoke';
        }

        if (null !== $name) {
            $this->name = $name;
        }

        if (null === self::$hasClassStub) {
            self::$hasClassStub = class_exists(ClassStub::class);
        }
>>>>>>> v2-test
    }

    public function getWrappedListener()
    {
        return $this->listener;
    }

<<<<<<< HEAD
    public function wasCalled()
=======
    public function wasCalled(): bool
>>>>>>> v2-test
    {
        return $this->called;
    }

<<<<<<< HEAD
    public function stoppedPropagation()
=======
    public function stoppedPropagation(): bool
>>>>>>> v2-test
    {
        return $this->stoppedPropagation;
    }

<<<<<<< HEAD
    public function __invoke(Event $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $this->called = true;

        $e = $this->stopwatch->start($this->name, 'event_listener');

        call_user_func($this->listener, $event, $eventName, $this->dispatcher ?: $dispatcher);
=======
    public function getPretty(): string
    {
        return $this->pretty;
    }

    public function getInfo(string $eventName): array
    {
        if (null === $this->stub) {
            $this->stub = self::$hasClassStub ? new ClassStub($this->pretty.'()', $this->listener) : $this->pretty.'()';
        }

        return [
            'event' => $eventName,
            'priority' => null !== $this->priority ? $this->priority : (null !== $this->dispatcher ? $this->dispatcher->getListenerPriority($eventName, $this->listener) : null),
            'pretty' => $this->pretty,
            'stub' => $this->stub,
        ];
    }

    public function __invoke(object $event, string $eventName, EventDispatcherInterface $dispatcher): void
    {
        $dispatcher = $this->dispatcher ?: $dispatcher;

        $this->called = true;
        $this->priority = $dispatcher->getListenerPriority($eventName, $this->listener);

        $e = $this->stopwatch->start($this->name, 'event_listener');

        ($this->optimizedListener ?? $this->listener)($event, $eventName, $dispatcher);
>>>>>>> v2-test

        if ($e->isStarted()) {
            $e->stop();
        }

<<<<<<< HEAD
        if ($event->isPropagationStopped()) {
=======
        if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
>>>>>>> v2-test
            $this->stoppedPropagation = true;
        }
    }
}
