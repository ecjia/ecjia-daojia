<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Debug;

use Symfony\Component\EventDispatcher\Debug\TraceableEventDispatcher as BaseTraceableEventDispatcher;
<<<<<<< HEAD
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\Event;
=======
use Symfony\Component\HttpKernel\KernelEvents;
>>>>>>> v2-test

/**
 * Collects some data about event listeners.
 *
 * This event dispatcher delegates the dispatching to another one.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class TraceableEventDispatcher extends BaseTraceableEventDispatcher
{
    /**
<<<<<<< HEAD
     * Sets the profiler.
     *
     * The traceable event dispatcher does not use the profiler anymore.
     * The job is now done directly by the Profiler listener and the
     * data collectors themselves.
     *
     * @param Profiler|null $profiler A Profiler instance
     *
     * @deprecated since version 2.4, to be removed in 3.0.
     */
    public function setProfiler(Profiler $profiler = null)
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 2.4 and will be removed in 3.0.', E_USER_DEPRECATED);
    }

    /**
     * {@inheritdoc}
     */
    protected function preDispatch($eventName, Event $event)
=======
     * {@inheritdoc}
     */
    protected function beforeDispatch(string $eventName, object $event)
>>>>>>> v2-test
    {
        switch ($eventName) {
            case KernelEvents::REQUEST:
                $this->stopwatch->openSection();
                break;
            case KernelEvents::VIEW:
            case KernelEvents::RESPONSE:
                // stop only if a controller has been executed
                if ($this->stopwatch->isStarted('controller')) {
                    $this->stopwatch->stop('controller');
                }
                break;
            case KernelEvents::TERMINATE:
                $token = $event->getResponse()->headers->get('X-Debug-Token');
<<<<<<< HEAD
=======
                if (null === $token) {
                    break;
                }
>>>>>>> v2-test
                // There is a very special case when using built-in AppCache class as kernel wrapper, in the case
                // of an ESI request leading to a `stale` response [B]  inside a `fresh` cached response [A].
                // In this case, `$token` contains the [B] debug token, but the  open `stopwatch` section ID
                // is equal to the [A] debug token. Trying to reopen section with the [B] token throws an exception
                // which must be caught.
                try {
                    $this->stopwatch->openSection($token);
                } catch (\LogicException $e) {
                }
                break;
        }
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    protected function postDispatch($eventName, Event $event)
    {
        switch ($eventName) {
            case KernelEvents::CONTROLLER:
=======
    protected function afterDispatch(string $eventName, object $event)
    {
        switch ($eventName) {
            case KernelEvents::CONTROLLER_ARGUMENTS:
>>>>>>> v2-test
                $this->stopwatch->start('controller', 'section');
                break;
            case KernelEvents::RESPONSE:
                $token = $event->getResponse()->headers->get('X-Debug-Token');
<<<<<<< HEAD
=======
                if (null === $token) {
                    break;
                }
>>>>>>> v2-test
                $this->stopwatch->stopSection($token);
                break;
            case KernelEvents::TERMINATE:
                // In the special case described in the `preDispatch` method above, the `$token` section
                // does not exist, then closing it throws an exception which must be caught.
                $token = $event->getResponse()->headers->get('X-Debug-Token');
<<<<<<< HEAD
=======
                if (null === $token) {
                    break;
                }
>>>>>>> v2-test
                try {
                    $this->stopwatch->stopSection($token);
                } catch (\LogicException $e) {
                }
                break;
        }
    }
}
