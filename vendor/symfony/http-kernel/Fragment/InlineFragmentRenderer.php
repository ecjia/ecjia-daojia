<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Fragment;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
<<<<<<< HEAD
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Controller\ControllerReference;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
=======
use Symfony\Component\HttpKernel\Controller\ControllerReference;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpCache\SubRequestHandler;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
>>>>>>> v2-test

/**
 * Implements the inline rendering strategy where the Request is rendered by the current HTTP kernel.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class InlineFragmentRenderer extends RoutableFragmentRenderer
{
    private $kernel;
    private $dispatcher;

<<<<<<< HEAD
    /**
     * Constructor.
     *
     * @param HttpKernelInterface      $kernel     A HttpKernelInterface instance
     * @param EventDispatcherInterface $dispatcher A EventDispatcherInterface instance
     */
=======
>>>>>>> v2-test
    public function __construct(HttpKernelInterface $kernel, EventDispatcherInterface $dispatcher = null)
    {
        $this->kernel = $kernel;
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritdoc}
     *
     * Additional available options:
     *
     *  * alt: an alternative URI to render in case of an error
     */
<<<<<<< HEAD
    public function render($uri, Request $request, array $options = array())
=======
    public function render($uri, Request $request, array $options = [])
>>>>>>> v2-test
    {
        $reference = null;
        if ($uri instanceof ControllerReference) {
            $reference = $uri;

            // Remove attributes from the generated URI because if not, the Symfony
            // routing system will use them to populate the Request attributes. We don't
            // want that as we want to preserve objects (so we manually set Request attributes
            // below instead)
            $attributes = $reference->attributes;
<<<<<<< HEAD
            $reference->attributes = array();

            // The request format and locale might have been overridden by the user
            foreach (array('_format', '_locale') as $key) {
=======
            $reference->attributes = [];

            // The request format and locale might have been overridden by the user
            foreach (['_format', '_locale'] as $key) {
>>>>>>> v2-test
                if (isset($attributes[$key])) {
                    $reference->attributes[$key] = $attributes[$key];
                }
            }

            $uri = $this->generateFragmentUri($uri, $request, false, false);

            $reference->attributes = array_merge($attributes, $reference->attributes);
        }

        $subRequest = $this->createSubRequest($uri, $request);

        // override Request attributes as they can be objects (which are not supported by the generated URI)
        if (null !== $reference) {
            $subRequest->attributes->add($reference->attributes);
        }

        $level = ob_get_level();
        try {
<<<<<<< HEAD
            return $this->kernel->handle($subRequest, HttpKernelInterface::SUB_REQUEST, false);
        } catch (\Exception $e) {
            // we dispatch the exception event to trigger the logging
            // the response that comes back is simply ignored
            if (isset($options['ignore_errors']) && $options['ignore_errors'] && $this->dispatcher) {
                $event = new GetResponseForExceptionEvent($this->kernel, $request, HttpKernelInterface::SUB_REQUEST, $e);

                $this->dispatcher->dispatch(KernelEvents::EXCEPTION, $event);
=======
            return SubRequestHandler::handle($this->kernel, $subRequest, HttpKernelInterface::SUB_REQUEST, false);
        } catch (\Exception $e) {
            // we dispatch the exception event to trigger the logging
            // the response that comes back is ignored
            if (isset($options['ignore_errors']) && $options['ignore_errors'] && $this->dispatcher) {
                $event = new ExceptionEvent($this->kernel, $request, HttpKernelInterface::SUB_REQUEST, $e);

                $this->dispatcher->dispatch($event, KernelEvents::EXCEPTION);
>>>>>>> v2-test
            }

            // let's clean up the output buffers that were created by the sub-request
            Response::closeOutputBuffers($level, false);

            if (isset($options['alt'])) {
                $alt = $options['alt'];
                unset($options['alt']);

                return $this->render($alt, $request, $options);
            }

            if (!isset($options['ignore_errors']) || !$options['ignore_errors']) {
                throw $e;
            }

            return new Response();
        }
    }

    protected function createSubRequest($uri, Request $request)
    {
        $cookies = $request->cookies->all();
        $server = $request->server->all();

<<<<<<< HEAD
        // Override the arguments to emulate a sub-request.
        // Sub-request object will point to localhost as client ip and real client ip
        // will be included into trusted header for client ip
        try {
            if ($trustedHeaderName = Request::getTrustedHeaderName(Request::HEADER_CLIENT_IP)) {
                $currentXForwardedFor = $request->headers->get($trustedHeaderName, '');

                $server['HTTP_'.$trustedHeaderName] = ($currentXForwardedFor ? $currentXForwardedFor.', ' : '').$request->getClientIp();
            }
        } catch (\InvalidArgumentException $e) {
            // Do nothing
        }

        $server['REMOTE_ADDR'] = '127.0.0.1';
        unset($server['HTTP_IF_MODIFIED_SINCE']);
        unset($server['HTTP_IF_NONE_MATCH']);

        $subRequest = Request::create($uri, 'get', array(), $cookies, array(), $server);
=======
        unset($server['HTTP_IF_MODIFIED_SINCE']);
        unset($server['HTTP_IF_NONE_MATCH']);

        $subRequest = Request::create($uri, 'get', [], $cookies, [], $server);
>>>>>>> v2-test
        if ($request->headers->has('Surrogate-Capability')) {
            $subRequest->headers->set('Surrogate-Capability', $request->headers->get('Surrogate-Capability'));
        }

<<<<<<< HEAD
        if ($session = $request->getSession()) {
            $subRequest->setSession($session);
=======
        static $setSession;

        if (null === $setSession) {
            $setSession = \Closure::bind(static function ($subRequest, $request) { $subRequest->session = $request->session; }, null, Request::class);
        }
        $setSession($subRequest, $request);

        if ($request->get('_format')) {
            $subRequest->attributes->set('_format', $request->get('_format'));
        }
        if ($request->getDefaultLocale() !== $request->getLocale()) {
            $subRequest->setLocale($request->getLocale());
>>>>>>> v2-test
        }

        return $subRequest;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'inline';
    }
}
