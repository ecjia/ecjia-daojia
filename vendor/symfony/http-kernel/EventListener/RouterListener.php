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

use Psr\Log\LoggerInterface;
<<<<<<< HEAD
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\Matcher\RequestMatcherInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RequestContextAwareInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
=======
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\NoConfigurationException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\RequestMatcherInterface;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RequestContextAwareInterface;
>>>>>>> v2-test

/**
 * Initializes the context from the request and sets request attributes based on a matching route.
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
 * @author Yonel Ceruto <yonelceruto@gmail.com>
 *
 * @final
>>>>>>> v2-test
 */
class RouterListener implements EventSubscriberInterface
{
    private $matcher;
    private $context;
    private $logger;
<<<<<<< HEAD
    private $request;
    private $requestStack;

    /**
     * Constructor.
     *
     * RequestStack will become required in 3.0.
     *
     * @param UrlMatcherInterface|RequestMatcherInterface $matcher      The Url or Request matcher
     * @param RequestContext|null                         $context      The RequestContext (can be null when $matcher implements RequestContextAwareInterface)
     * @param LoggerInterface|null                        $logger       The logger
     * @param RequestStack|null                           $requestStack A RequestStack instance
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($matcher, RequestContext $context = null, LoggerInterface $logger = null, RequestStack $requestStack = null)
=======
    private $requestStack;
    private $projectDir;
    private $debug;

    /**
     * @param UrlMatcherInterface|RequestMatcherInterface $matcher    The Url or Request matcher
     * @param RequestContext|null                         $context    The RequestContext (can be null when $matcher implements RequestContextAwareInterface)
     * @param string                                      $projectDir
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($matcher, RequestStack $requestStack, RequestContext $context = null, LoggerInterface $logger = null, string $projectDir = null, bool $debug = true)
>>>>>>> v2-test
    {
        if (!$matcher instanceof UrlMatcherInterface && !$matcher instanceof RequestMatcherInterface) {
            throw new \InvalidArgumentException('Matcher must either implement UrlMatcherInterface or RequestMatcherInterface.');
        }

        if (null === $context && !$matcher instanceof RequestContextAwareInterface) {
            throw new \InvalidArgumentException('You must either pass a RequestContext or the matcher must implement RequestContextAwareInterface.');
        }

<<<<<<< HEAD
        if (!$requestStack instanceof RequestStack) {
            @trigger_error('The '.__METHOD__.' method now requires a RequestStack instance as '.__CLASS__.'::setRequest method will not be supported anymore in 3.0.', E_USER_DEPRECATED);
        }

=======
>>>>>>> v2-test
        $this->matcher = $matcher;
        $this->context = $context ?: $matcher->getContext();
        $this->requestStack = $requestStack;
        $this->logger = $logger;
<<<<<<< HEAD
    }

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
        @trigger_error('The '.__METHOD__.' method is deprecated since version 2.4 and will be made private in 3.0.', E_USER_DEPRECATED);

        $this->setCurrentRequest($request);
=======
        $this->projectDir = $projectDir;
        $this->debug = $debug;
>>>>>>> v2-test
    }

    private function setCurrentRequest(Request $request = null)
    {
<<<<<<< HEAD
        if (null !== $request && $this->request !== $request) {
            $this->context->fromRequest($request);
        }

        $this->request = $request;
    }

    public function onKernelFinishRequest(FinishRequestEvent $event)
    {
        if (null === $this->requestStack) {
            return; // removed when requestStack is required
        }

        $this->setCurrentRequest($this->requestStack->getParentRequest());
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        // initialize the context that is also used by the generator (assuming matcher and generator share the same context instance)
        // we call setCurrentRequest even if most of the time, it has already been done to keep compatibility
        // with frameworks which do not use the Symfony service container
        // when we have a RequestStack, no need to do it
        if (null !== $this->requestStack) {
            $this->setCurrentRequest($request);
        }
=======
        if (null !== $request) {
            try {
                $this->context->fromRequest($request);
            } catch (\UnexpectedValueException $e) {
                throw new BadRequestHttpException($e->getMessage(), $e, $e->getCode());
            }
        }
    }

    /**
     * After a sub-request is done, we need to reset the routing context to the parent request so that the URL generator
     * operates on the correct context again.
     */
    public function onKernelFinishRequest(FinishRequestEvent $event)
    {
        $this->setCurrentRequest($this->requestStack->getParentRequest());
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        $this->setCurrentRequest($request);
>>>>>>> v2-test

        if ($request->attributes->has('_controller')) {
            // routing is already done
            return;
        }

        // add attributes based on the request (routing)
        try {
            // matching a request is more powerful than matching a URL path + context, so try that first
            if ($this->matcher instanceof RequestMatcherInterface) {
                $parameters = $this->matcher->matchRequest($request);
            } else {
                $parameters = $this->matcher->match($request->getPathInfo());
            }

            if (null !== $this->logger) {
<<<<<<< HEAD
                $this->logger->info(sprintf('Matched route "%s".', isset($parameters['_route']) ? $parameters['_route'] : 'n/a'), array(
                    'route_parameters' => $parameters,
                    'request_uri' => $request->getUri(),
                ));
=======
                $this->logger->info('Matched route "{route}".', [
                    'route' => $parameters['_route'] ?? 'n/a',
                    'route_parameters' => $parameters,
                    'request_uri' => $request->getUri(),
                    'method' => $request->getMethod(),
                ]);
>>>>>>> v2-test
            }

            $request->attributes->add($parameters);
            unset($parameters['_route'], $parameters['_controller']);
            $request->attributes->set('_route_params', $parameters);
        } catch (ResourceNotFoundException $e) {
            $message = sprintf('No route found for "%s %s"', $request->getMethod(), $request->getPathInfo());

            if ($referer = $request->headers->get('referer')) {
                $message .= sprintf(' (from "%s")', $referer);
            }

            throw new NotFoundHttpException($message, $e);
        } catch (MethodNotAllowedException $e) {
            $message = sprintf('No route found for "%s %s": Method Not Allowed (Allow: %s)', $request->getMethod(), $request->getPathInfo(), implode(', ', $e->getAllowedMethods()));

            throw new MethodNotAllowedHttpException($e->getAllowedMethods(), $message, $e);
        }
    }

<<<<<<< HEAD
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array(array('onKernelRequest', 32)),
            KernelEvents::FINISH_REQUEST => array(array('onKernelFinishRequest', 0)),
        );
=======
    public function onKernelException(ExceptionEvent $event)
    {
        if (!$this->debug || !($e = $event->getThrowable()) instanceof NotFoundHttpException) {
            return;
        }

        if ($e->getPrevious() instanceof NoConfigurationException) {
            $event->setResponse($this->createWelcomeResponse());
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 32]],
            KernelEvents::FINISH_REQUEST => [['onKernelFinishRequest', 0]],
            KernelEvents::EXCEPTION => ['onKernelException', -64],
        ];
    }

    private function createWelcomeResponse(): Response
    {
        $version = Kernel::VERSION;
        $projectDir = realpath($this->projectDir).\DIRECTORY_SEPARATOR;
        $docVersion = substr(Kernel::VERSION, 0, 3);

        ob_start();
        include \dirname(__DIR__).'/Resources/welcome.html.php';

        return new Response(ob_get_clean(), Response::HTTP_NOT_FOUND);
>>>>>>> v2-test
    }
}
