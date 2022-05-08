<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\EventListener;

<<<<<<< HEAD
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\HttpCache\SurrogateInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
=======
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\HttpCache\HttpCache;
use Symfony\Component\HttpKernel\HttpCache\SurrogateInterface;
use Symfony\Component\HttpKernel\KernelEvents;
>>>>>>> v2-test

/**
 * SurrogateListener adds a Surrogate-Control HTTP header when the Response needs to be parsed for Surrogates.
 *
 * @author Fabien Potencier <fabien@symfony.com>
<<<<<<< HEAD
=======
 *
 * @final
>>>>>>> v2-test
 */
class SurrogateListener implements EventSubscriberInterface
{
    private $surrogate;

<<<<<<< HEAD
    /**
     * Constructor.
     *
     * @param SurrogateInterface $surrogate An SurrogateInterface instance
     */
=======
>>>>>>> v2-test
    public function __construct(SurrogateInterface $surrogate = null)
    {
        $this->surrogate = $surrogate;
    }

    /**
     * Filters the Response.
<<<<<<< HEAD
     *
     * @param FilterResponseEvent $event A FilterResponseEvent instance
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (!$event->isMasterRequest() || null === $this->surrogate) {
            return;
        }

        $this->surrogate->addSurrogateControl($event->getResponse());
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::RESPONSE => 'onKernelResponse',
        );
=======
     */
    public function onKernelResponse(ResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $kernel = $event->getKernel();
        $surrogate = $this->surrogate;
        if ($kernel instanceof HttpCache) {
            $surrogate = $kernel->getSurrogate();
            if (null !== $this->surrogate && $this->surrogate->getName() !== $surrogate->getName()) {
                $surrogate = $this->surrogate;
            }
        }

        if (null === $surrogate) {
            return;
        }

        $surrogate->addSurrogateControl($event->getResponse());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
>>>>>>> v2-test
    }
}
