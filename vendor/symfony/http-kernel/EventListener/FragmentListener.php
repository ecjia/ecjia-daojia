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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\UriSigner;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
=======
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\UriSigner;
>>>>>>> v2-test

/**
 * Handles content fragments represented by special URIs.
 *
 * All URL paths starting with /_fragment are handled as
 * content fragments by this listener.
 *
<<<<<<< HEAD
 * If throws an AccessDeniedHttpException exception if the request
 * is not signed or if it is not an internal sub-request.
 *
 * @author Fabien Potencier <fabien@symfony.com>
=======
 * Throws an AccessDeniedHttpException exception if the request
 * is not signed or if it is not an internal sub-request.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @final
>>>>>>> v2-test
 */
class FragmentListener implements EventSubscriberInterface
{
    private $signer;
    private $fragmentPath;

    /**
<<<<<<< HEAD
     * Constructor.
     *
     * @param UriSigner $signer       A UriSigner instance
     * @param string    $fragmentPath The path that triggers this listener
     */
    public function __construct(UriSigner $signer, $fragmentPath = '/_fragment')
=======
     * @param string $fragmentPath The path that triggers this listener
     */
    public function __construct(UriSigner $signer, string $fragmentPath = '/_fragment')
>>>>>>> v2-test
    {
        $this->signer = $signer;
        $this->fragmentPath = $fragmentPath;
    }

    /**
     * Fixes request attributes when the path is '/_fragment'.
     *
<<<<<<< HEAD
     * @param GetResponseEvent $event A GetResponseEvent instance
     *
     * @throws AccessDeniedHttpException if the request does not come from a trusted IP.
     */
    public function onKernelRequest(GetResponseEvent $event)
=======
     * @throws AccessDeniedHttpException if the request does not come from a trusted IP
     */
    public function onKernelRequest(RequestEvent $event)
>>>>>>> v2-test
    {
        $request = $event->getRequest();

        if ($this->fragmentPath !== rawurldecode($request->getPathInfo())) {
            return;
        }

        if ($request->attributes->has('_controller')) {
            // Is a sub-request: no need to parse _path but it should still be removed from query parameters as below.
            $request->query->remove('_path');

            return;
        }

        if ($event->isMasterRequest()) {
            $this->validateRequest($request);
        }

        parse_str($request->query->get('_path', ''), $attributes);
        $request->attributes->add($attributes);
<<<<<<< HEAD
        $request->attributes->set('_route_params', array_replace($request->attributes->get('_route_params', array()), $attributes));
=======
        $request->attributes->set('_route_params', array_replace($request->attributes->get('_route_params', []), $attributes));
>>>>>>> v2-test
        $request->query->remove('_path');
    }

    protected function validateRequest(Request $request)
    {
        // is the Request safe?
        if (!$request->isMethodSafe()) {
            throw new AccessDeniedHttpException();
        }

        // is the Request signed?
<<<<<<< HEAD
        // we cannot use $request->getUri() here as we want to work with the original URI (no query string reordering)
        if ($this->signer->check($request->getSchemeAndHttpHost().$request->getBaseUrl().$request->getPathInfo().(null !== ($qs = $request->server->get('QUERY_STRING')) ? '?'.$qs : ''))) {
=======
        if ($this->signer->checkRequest($request)) {
>>>>>>> v2-test
            return;
        }

        throw new AccessDeniedHttpException();
    }

<<<<<<< HEAD
    /**
     * @deprecated since version 2.3.19, to be removed in 3.0.
     *
     * @return string[]
     */
    protected function getLocalIpAddresses()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 2.3.19 and will be removed in 3.0.', E_USER_DEPRECATED);

        return array('127.0.0.1', 'fe80::1', '::1');
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array(array('onKernelRequest', 48)),
        );
=======
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 48]],
        ];
>>>>>>> v2-test
    }
}
