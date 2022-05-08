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
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContextAwareInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
=======
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RequestContextAwareInterface;
>>>>>>> v2-test

/**
 * Initializes the locale based on the current request.
 *
<<<<<<< HEAD
 * This listener works in 2 modes:
 *
 *  * 2.3 compatibility mode where you must call setRequest whenever the Request changes.
 *  * 2.4+ mode where you must pass a RequestStack instance in the constructor.
 *
 * @author Fabien Potencier <fabien@symfony.com>
=======
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @final
>>>>>>> v2-test
 */
class LocaleListener implements EventSubscriberInterface
{
    private $router;
    private $defaultLocale;
    private $requestStack;

<<<<<<< HEAD
    /**
     * RequestStack will become required in 3.0.
     */
    public function __construct($defaultLocale = 'en', RequestContextAwareInterface $router = null, RequestStack $requestStack = null)
=======
    public function __construct(RequestStack $requestStack, string $defaultLocale = 'en', RequestContextAwareInterface $router = null)
>>>>>>> v2-test
    {
        $this->defaultLocale = $defaultLocale;
        $this->requestStack = $requestStack;
        $this->router = $router;
    }

<<<<<<< HEAD
    /**
     * Sets the current Request.
     *
     * This method was used to synchronize the Request, but as the HttpKernel
     * is doing that automatically now, you should never call it directly.
     * It is kept public for BC with the 2.3 version.
     *
     * @param Request|null $request A Request instance
     *
     * @deprecated since version 2.4, to be removed in 3.0.
     */
    public function setRequest(Request $request = null)
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 2.4 and will be removed in 3.0.', E_USER_DEPRECATED);

        if (null === $request) {
            return;
        }

        $this->setLocale($request);
        $this->setRouterContext($request);
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $request->setDefaultLocale($this->defaultLocale);
=======
    public function setDefaultLocale(KernelEvent $event)
    {
        $event->getRequest()->setDefaultLocale($this->defaultLocale);
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
>>>>>>> v2-test

        $this->setLocale($request);
        $this->setRouterContext($request);
    }

    public function onKernelFinishRequest(FinishRequestEvent $event)
    {
<<<<<<< HEAD
        if (null === $this->requestStack) {
            return; // removed when requestStack is required
        }

=======
>>>>>>> v2-test
        if (null !== $parentRequest = $this->requestStack->getParentRequest()) {
            $this->setRouterContext($parentRequest);
        }
    }

    private function setLocale(Request $request)
    {
        if ($locale = $request->attributes->get('_locale')) {
            $request->setLocale($locale);
        }
    }

    private function setRouterContext(Request $request)
    {
        if (null !== $this->router) {
            $this->router->getContext()->setParameter('_locale', $request->getLocale());
        }
    }

<<<<<<< HEAD
    public static function getSubscribedEvents()
    {
        return array(
            // must be registered after the Router to have access to the _locale
            KernelEvents::REQUEST => array(array('onKernelRequest', 16)),
            KernelEvents::FINISH_REQUEST => array(array('onKernelFinishRequest', 0)),
        );
=======
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [
                ['setDefaultLocale', 100],
                // must be registered after the Router to have access to the _locale
                ['onKernelRequest', 16],
            ],
            KernelEvents::FINISH_REQUEST => [['onKernelFinishRequest', 0]],
        ];
>>>>>>> v2-test
    }
}
