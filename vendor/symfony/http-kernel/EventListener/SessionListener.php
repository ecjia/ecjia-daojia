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
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
=======
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
>>>>>>> v2-test

/**
 * Sets the session in the request.
 *
<<<<<<< HEAD
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
abstract class SessionListener implements EventSubscriberInterface
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();
        $session = $this->getSession();
        if (null === $session || $request->hasSession()) {
            return;
        }

        $request->setSession($session);
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array('onKernelRequest', 128),
        );
    }

    /**
     * Gets the session object.
     *
     * @return SessionInterface|null A SessionInterface instance or null if no session is available
     */
    abstract protected function getSession();
=======
 * When the passed container contains a "session_storage" entry which
 * holds a NativeSessionStorage instance, the "cookie_secure" option
 * will be set to true whenever the current master request is secure.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @final
 */
class SessionListener extends AbstractSessionListener
{
    public function __construct(ContainerInterface $container, bool $debug = false)
    {
        parent::__construct($container, $debug);
    }

    protected function getSession(): ?SessionInterface
    {
        if (!$this->container->has('session')) {
            return null;
        }

        if ($this->container->has('session_storage')
            && ($storage = $this->container->get('session_storage')) instanceof NativeSessionStorage
            && ($masterRequest = $this->container->get('request_stack')->getMasterRequest())
            && $masterRequest->isSecure()
        ) {
            $storage->setOptions(['cookie_secure' => true]);
        }

        return $this->container->get('session');
    }
>>>>>>> v2-test
}
