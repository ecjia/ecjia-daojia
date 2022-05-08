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

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
<<<<<<< HEAD
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Validates that the headers and other information indicating the
 * client IP address of a request are consistent.
 *
 * @author Magnus Nordlander <magnus@fervo.se>
=======
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Validates Requests.
 *
 * @author Magnus Nordlander <magnus@fervo.se>
 *
 * @final
>>>>>>> v2-test
 */
class ValidateRequestListener implements EventSubscriberInterface
{
    /**
     * Performs the validation.
<<<<<<< HEAD
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
=======
     */
    public function onKernelRequest(RequestEvent $event)
>>>>>>> v2-test
    {
        if (!$event->isMasterRequest()) {
            return;
        }
        $request = $event->getRequest();

        if ($request::getTrustedProxies()) {
<<<<<<< HEAD
            // This will throw an exception if the headers are inconsistent.
            $request->getClientIps();
        }
=======
            $request->getClientIps();
        }

        $request->getHost();
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array(
                array('onKernelRequest', 256),
            ),
        );
=======
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [
                ['onKernelRequest', 256],
            ],
        ];
>>>>>>> v2-test
    }
}
