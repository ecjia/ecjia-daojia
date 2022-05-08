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
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
=======
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
>>>>>>> v2-test

/**
 * ResponseListener fixes the Response headers based on the Request.
 *
 * @author Fabien Potencier <fabien@symfony.com>
<<<<<<< HEAD
=======
 *
 * @final
>>>>>>> v2-test
 */
class ResponseListener implements EventSubscriberInterface
{
    private $charset;

<<<<<<< HEAD
    public function __construct($charset)
=======
    public function __construct(string $charset)
>>>>>>> v2-test
    {
        $this->charset = $charset;
    }

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

        if (null === $response->getCharset()) {
            $response->setCharset($this->charset);
        }

        $response->prepare($event->getRequest());
    }

<<<<<<< HEAD
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::RESPONSE => 'onKernelResponse',
        );
=======
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
>>>>>>> v2-test
    }
}
