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
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
=======
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
>>>>>>> v2-test

/**
 * StreamedResponseListener is responsible for sending the Response
 * to the client.
 *
 * @author Fabien Potencier <fabien@symfony.com>
<<<<<<< HEAD
=======
 *
 * @final
>>>>>>> v2-test
 */
class StreamedResponseListener implements EventSubscriberInterface
{
    /**
     * Filters the Response.
<<<<<<< HEAD
     *
     * @param FilterResponseEvent $event A FilterResponseEvent instance
     */
    public function onKernelResponse(FilterResponseEvent $event)
=======
     */
    public function onKernelResponse(ResponseEvent $event)
>>>>>>> v2-test
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $response = $event->getResponse();

        if ($response instanceof StreamedResponse) {
            $response->send();
        }
    }

<<<<<<< HEAD
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::RESPONSE => array('onKernelResponse', -1024),
        );
=======
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => ['onKernelResponse', -1024],
        ];
>>>>>>> v2-test
    }
}
