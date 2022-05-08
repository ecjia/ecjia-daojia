<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel;

<<<<<<< HEAD
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Symfony\Component\HttpFoundation\Exception\ConflictingHeadersException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
=======
use Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\Event\TerminateEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ControllerDoesNotReturnResponseException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

// Help opcache.preload discover always-needed symbols
class_exists(LegacyEventDispatcherProxy::class);
class_exists(ControllerArgumentsEvent::class);
class_exists(ControllerEvent::class);
class_exists(ExceptionEvent::class);
class_exists(FinishRequestEvent::class);
class_exists(RequestEvent::class);
class_exists(ResponseEvent::class);
class_exists(TerminateEvent::class);
class_exists(ViewEvent::class);
class_exists(KernelEvents::class);
>>>>>>> v2-test

/**
 * HttpKernel notifies events to convert a Request object to a Response one.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class HttpKernel implements HttpKernelInterface, TerminableInterface
{
    protected $dispatcher;
    protected $resolver;
    protected $requestStack;
<<<<<<< HEAD

    /**
     * Constructor.
     *
     * @param EventDispatcherInterface    $dispatcher   An EventDispatcherInterface instance
     * @param ControllerResolverInterface $resolver     A ControllerResolverInterface instance
     * @param RequestStack                $requestStack A stack for master/sub requests
     */
    public function __construct(EventDispatcherInterface $dispatcher, ControllerResolverInterface $resolver, RequestStack $requestStack = null)
=======
    private $argumentResolver;

    public function __construct(EventDispatcherInterface $dispatcher, ControllerResolverInterface $resolver, RequestStack $requestStack = null, ArgumentResolverInterface $argumentResolver = null)
>>>>>>> v2-test
    {
        $this->dispatcher = $dispatcher;
        $this->resolver = $resolver;
        $this->requestStack = $requestStack ?: new RequestStack();
<<<<<<< HEAD
=======
        $this->argumentResolver = $argumentResolver;

        if (null === $this->argumentResolver) {
            $this->argumentResolver = new ArgumentResolver();
        }
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        $request->headers->set('X-Php-Ob-Level', ob_get_level());
=======
    public function handle(Request $request, int $type = HttpKernelInterface::MASTER_REQUEST, bool $catch = true)
    {
        $request->headers->set('X-Php-Ob-Level', (string) ob_get_level());
>>>>>>> v2-test

        try {
            return $this->handleRaw($request, $type);
        } catch (\Exception $e) {
<<<<<<< HEAD
            if ($e instanceof ConflictingHeadersException) {
                $e = new BadRequestHttpException('The request headers contain conflicting information regarding the origin of this request.', $e);
=======
            if ($e instanceof RequestExceptionInterface) {
                $e = new BadRequestHttpException($e->getMessage(), $e);
>>>>>>> v2-test
            }
            if (false === $catch) {
                $this->finishRequest($request, $type);

                throw $e;
            }

<<<<<<< HEAD
            return $this->handleException($e, $request, $type);
=======
            return $this->handleThrowable($e, $request, $type);
>>>>>>> v2-test
        }
    }

    /**
     * {@inheritdoc}
     */
    public function terminate(Request $request, Response $response)
    {
<<<<<<< HEAD
        $this->dispatcher->dispatch(KernelEvents::TERMINATE, new PostResponseEvent($this, $request, $response));
    }

    /**
     * @throws \LogicException If the request stack is empty
     *
     * @internal
     */
    public function terminateWithException(\Exception $exception)
    {
        if (!$request = $this->requestStack->getMasterRequest()) {
            throw new \LogicException('Request stack is empty', 0, $exception);
        }

        $response = $this->handleException($exception, $request, self::MASTER_REQUEST);
=======
        $this->dispatcher->dispatch(new TerminateEvent($this, $request, $response), KernelEvents::TERMINATE);
    }

    /**
     * @internal
     */
    public function terminateWithException(\Throwable $exception, Request $request = null)
    {
        if (!$request = $request ?: $this->requestStack->getMasterRequest()) {
            throw $exception;
        }

        $response = $this->handleThrowable($exception, $request, self::MASTER_REQUEST);
>>>>>>> v2-test

        $response->sendHeaders();
        $response->sendContent();

        $this->terminate($request, $response);
    }

    /**
     * Handles a request to convert it to a response.
     *
     * Exceptions are not caught.
     *
<<<<<<< HEAD
     * @param Request $request A Request instance
     * @param int     $type    The type of the request (one of HttpKernelInterface::MASTER_REQUEST or HttpKernelInterface::SUB_REQUEST)
     *
     * @return Response A Response instance
     *
     * @throws \LogicException       If one of the listener does not behave as expected
     * @throws NotFoundHttpException When controller cannot be found
     */
    private function handleRaw(Request $request, $type = self::MASTER_REQUEST)
=======
     * @throws \LogicException       If one of the listener does not behave as expected
     * @throws NotFoundHttpException When controller cannot be found
     */
    private function handleRaw(Request $request, int $type = self::MASTER_REQUEST): Response
>>>>>>> v2-test
    {
        $this->requestStack->push($request);

        // request
<<<<<<< HEAD
        $event = new GetResponseEvent($this, $request, $type);
        $this->dispatcher->dispatch(KernelEvents::REQUEST, $event);
=======
        $event = new RequestEvent($this, $request, $type);
        $this->dispatcher->dispatch($event, KernelEvents::REQUEST);
>>>>>>> v2-test

        if ($event->hasResponse()) {
            return $this->filterResponse($event->getResponse(), $request, $type);
        }

        // load controller
        if (false === $controller = $this->resolver->getController($request)) {
            throw new NotFoundHttpException(sprintf('Unable to find the controller for path "%s". The route is wrongly configured.', $request->getPathInfo()));
        }

<<<<<<< HEAD
        $event = new FilterControllerEvent($this, $controller, $request, $type);
        $this->dispatcher->dispatch(KernelEvents::CONTROLLER, $event);
        $controller = $event->getController();

        // controller arguments
        $arguments = $this->resolver->getArguments($request, $controller);

        // call controller
        $response = call_user_func_array($controller, $arguments);

        // view
        if (!$response instanceof Response) {
            $event = new GetResponseForControllerResultEvent($this, $request, $type, $response);
            $this->dispatcher->dispatch(KernelEvents::VIEW, $event);

            if ($event->hasResponse()) {
                $response = $event->getResponse();
            }

            if (!$response instanceof Response) {
                $msg = sprintf('The controller must return a response (%s given).', $this->varToString($response));
=======
        $event = new ControllerEvent($this, $controller, $request, $type);
        $this->dispatcher->dispatch($event, KernelEvents::CONTROLLER);
        $controller = $event->getController();

        // controller arguments
        $arguments = $this->argumentResolver->getArguments($request, $controller);

        $event = new ControllerArgumentsEvent($this, $controller, $arguments, $request, $type);
        $this->dispatcher->dispatch($event, KernelEvents::CONTROLLER_ARGUMENTS);
        $controller = $event->getController();
        $arguments = $event->getArguments();

        // call controller
        $response = $controller(...$arguments);

        // view
        if (!$response instanceof Response) {
            $event = new ViewEvent($this, $request, $type, $response);
            $this->dispatcher->dispatch($event, KernelEvents::VIEW);

            if ($event->hasResponse()) {
                $response = $event->getResponse();
            } else {
                $msg = sprintf('The controller must return a "Symfony\Component\HttpFoundation\Response" object but it returned %s.', $this->varToString($response));
>>>>>>> v2-test

                // the user may have forgotten to return something
                if (null === $response) {
                    $msg .= ' Did you forget to add a return statement somewhere in your controller?';
                }
<<<<<<< HEAD
                throw new \LogicException($msg);
=======

                throw new ControllerDoesNotReturnResponseException($msg, $controller, __FILE__, __LINE__ - 17);
>>>>>>> v2-test
            }
        }

        return $this->filterResponse($response, $request, $type);
    }

    /**
     * Filters a response object.
     *
<<<<<<< HEAD
     * @param Response $response A Response instance
     * @param Request  $request  An error message in case the response is not a Response object
     * @param int      $type     The type of the request (one of HttpKernelInterface::MASTER_REQUEST or HttpKernelInterface::SUB_REQUEST)
     *
     * @return Response The filtered Response instance
     *
     * @throws \RuntimeException if the passed object is not a Response instance
     */
    private function filterResponse(Response $response, Request $request, $type)
    {
        $event = new FilterResponseEvent($this, $request, $type, $response);

        $this->dispatcher->dispatch(KernelEvents::RESPONSE, $event);
=======
     * @throws \RuntimeException if the passed object is not a Response instance
     */
    private function filterResponse(Response $response, Request $request, int $type): Response
    {
        $event = new ResponseEvent($this, $request, $type, $response);

        $this->dispatcher->dispatch($event, KernelEvents::RESPONSE);
>>>>>>> v2-test

        $this->finishRequest($request, $type);

        return $event->getResponse();
    }

    /**
     * Publishes the finish request event, then pop the request from the stack.
     *
     * Note that the order of the operations is important here, otherwise
     * operations such as {@link RequestStack::getParentRequest()} can lead to
     * weird results.
<<<<<<< HEAD
     *
     * @param Request $request
     * @param int     $type
     */
    private function finishRequest(Request $request, $type)
    {
        $this->dispatcher->dispatch(KernelEvents::FINISH_REQUEST, new FinishRequestEvent($this, $request, $type));
=======
     */
    private function finishRequest(Request $request, int $type)
    {
        $this->dispatcher->dispatch(new FinishRequestEvent($this, $request, $type), KernelEvents::FINISH_REQUEST);
>>>>>>> v2-test
        $this->requestStack->pop();
    }

    /**
<<<<<<< HEAD
     * Handles an exception by trying to convert it to a Response.
     *
     * @param \Exception $e       An \Exception instance
     * @param Request    $request A Request instance
     * @param int        $type    The type of the request
     *
     * @return Response A Response instance
     *
     * @throws \Exception
     */
    private function handleException(\Exception $e, $request, $type)
    {
        $event = new GetResponseForExceptionEvent($this, $request, $type, $e);
        $this->dispatcher->dispatch(KernelEvents::EXCEPTION, $event);

        // a listener might have replaced the exception
        $e = $event->getException();
=======
     * Handles a throwable by trying to convert it to a Response.
     *
     * @throws \Exception
     */
    private function handleThrowable(\Throwable $e, Request $request, int $type): Response
    {
        $event = new ExceptionEvent($this, $request, $type, $e);
        $this->dispatcher->dispatch($event, KernelEvents::EXCEPTION);

        // a listener might have replaced the exception
        $e = $event->getThrowable();
>>>>>>> v2-test

        if (!$event->hasResponse()) {
            $this->finishRequest($request, $type);

            throw $e;
        }

        $response = $event->getResponse();

        // the developer asked for a specific status code
<<<<<<< HEAD
        if ($response->headers->has('X-Status-Code')) {
            $response->setStatusCode($response->headers->get('X-Status-Code'));

            $response->headers->remove('X-Status-Code');
        } elseif (!$response->isClientError() && !$response->isServerError() && !$response->isRedirect()) {
=======
        if (!$event->isAllowingCustomResponseCode() && !$response->isClientError() && !$response->isServerError() && !$response->isRedirect()) {
>>>>>>> v2-test
            // ensure that we actually have an error response
            if ($e instanceof HttpExceptionInterface) {
                // keep the HTTP status code and headers
                $response->setStatusCode($e->getStatusCode());
                $response->headers->add($e->getHeaders());
            } else {
                $response->setStatusCode(500);
            }
        }

        try {
            return $this->filterResponse($response, $request, $type);
        } catch (\Exception $e) {
            return $response;
        }
    }

<<<<<<< HEAD
    private function varToString($var)
    {
        if (is_object($var)) {
            return sprintf('Object(%s)', get_class($var));
        }

        if (is_array($var)) {
            $a = array();
            foreach ($var as $k => $v) {
                $a[] = sprintf('%s => %s', $k, $this->varToString($v));
            }

            return sprintf('Array(%s)', implode(', ', $a));
        }

        if (is_resource($var)) {
            return sprintf('Resource(%s)', get_resource_type($var));
=======
    /**
     * Returns a human-readable string for the specified variable.
     */
    private function varToString($var): string
    {
        if (\is_object($var)) {
            return sprintf('an object of type %s', \get_class($var));
        }

        if (\is_array($var)) {
            $a = [];
            foreach ($var as $k => $v) {
                $a[] = sprintf('%s => ...', $k);
            }

            return sprintf('an array ([%s])', mb_substr(implode(', ', $a), 0, 255));
        }

        if (\is_resource($var)) {
            return sprintf('a resource (%s)', get_resource_type($var));
>>>>>>> v2-test
        }

        if (null === $var) {
            return 'null';
        }

        if (false === $var) {
<<<<<<< HEAD
            return 'false';
        }

        if (true === $var) {
            return 'true';
=======
            return 'a boolean value (false)';
        }

        if (true === $var) {
            return 'a boolean value (true)';
        }

        if (\is_string($var)) {
            return sprintf('a string ("%s%s")', mb_substr($var, 0, 255), mb_strlen($var) > 255 ? '...' : '');
        }

        if (is_numeric($var)) {
            return sprintf('a number (%s)', (string) $var);
>>>>>>> v2-test
        }

        return (string) $var;
    }
}
