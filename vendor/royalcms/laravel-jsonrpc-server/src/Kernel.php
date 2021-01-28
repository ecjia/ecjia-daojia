<?php

declare(strict_types=1);

namespace Royalcms\Laravel\JsonRpcServer;

use Throwable;
use Royalcms\Laravel\JsonRpcServer\Errors\InternalError;
use Royalcms\Laravel\JsonRpcServer\Errors\ErrorInterface;
use Royalcms\Laravel\JsonRpcServer\Router\RouterInterface;
use Royalcms\Laravel\JsonRpcServer\Responses\ErrorResponse;
use Royalcms\Laravel\JsonRpcServer\Responses\ResponsesStack;
use Illuminate\Contracts\Container\Container;
use Royalcms\Laravel\JsonRpcServer\Requests\RequestInterface;
use Royalcms\Laravel\JsonRpcServer\Responses\SuccessResponse;
use Royalcms\Laravel\JsonRpcServer\Errors\MethodNotFoundError;
use Royalcms\Laravel\JsonRpcServer\Events\RequestHandledEvent;
use Royalcms\Laravel\JsonRpcServer\Requests\RequestsStackInterface;
use Royalcms\Laravel\JsonRpcServer\Requests\ErroredRequestInterface;
use Royalcms\Laravel\JsonRpcServer\Responses\ResponsesStackInterface;
use Royalcms\Laravel\JsonRpcServer\Events\ErroredRequestDetectedEvent;
use Royalcms\Laravel\JsonRpcServer\Events\RequestHandledExceptionEvent;
use Royalcms\Laravel\JsonRpcServer\Requests\RequestInterface as RPCRequest;
use Royalcms\Laravel\JsonRpcServer\MethodParameters\MethodParametersInterface;
use Illuminate\Contracts\Events\Dispatcher as EventsDispatcher;

class Kernel implements KernelInterface
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var EventsDispatcher
     */
    protected $events;

    /**
     * Kernel constructor.
     *
     * @param Container        $container
     * @param RouterInterface  $router
     * @param EventsDispatcher $events
     */
    public function __construct(Container $container, RouterInterface $router, EventsDispatcher $events)
    {
        $this->container = $container;
        $this->router    = $router;
        $this->events    = $events;

        $this->bindParametersParser($container);
    }

    /**
     * {@inheritdoc}
     */
    public function handle(RequestsStackInterface $requests): ResponsesStackInterface
    {
        $responses = new ResponsesStack($requests->isBatch());

        foreach ($requests->all() as $request) {
            if ($request instanceof ErroredRequestInterface) {
                // Process any requests that have errors
                $this->processErroredRequest($request, $responses);
            } elseif ($request instanceof RequestInterface) {
                if ($this->router->methodExists($request->getMethod())) {
                    try {
                        // Bind request instance into container
                        $this->bindRpcRequest($request);

                        // Handle current request and push it in Responses Stack
                        $this->handleRequest($request, $responses);
                    } catch (Throwable $e) {
                        // Catch any error that occurred while executing the request
                        $this->catchErrorOnHandle($request, $responses, $e);
                    }
                } else {
                    $this->pushErrorIfNotNotification($request, $responses);
                }
            }
        }

        return $responses;
    }

    /**
     * @param Container $container
     */
    protected function bindParametersParser(Container $container): void
    {
        $container->resolving(
            MethodParametersInterface::class,
            function (MethodParametersInterface $parameters) use ($container): void {
                $request = $container->make(RPCRequest::class);

                if ($request instanceof RPCRequest) {// @todo: Make test for this condition
                    $parameters->parse($request->getParams());
                }
            }
        );
    }

    /**
     * @param ErroredRequestInterface $request
     * @param ResponsesStackInterface $responses
     */
    protected function processErroredRequest(ErroredRequestInterface $request, ResponsesStackInterface $responses): void
    {
        $this->events->dispatch(new ErroredRequestDetectedEvent($request));

        $responses->push(new ErrorResponse($request->getId(), $request->getError()));
    }

    /**
     * @param RPCRequest              $request
     * @param ResponsesStackInterface $responses
     *
     * @throws Throwable
     */
    protected function handleRequest(RequestInterface $request, ResponsesStackInterface $responses): void
    {
        $result = $this->router->call($request->getMethod());

        if ($request->isNotification() === false) {
            $responses->push(new SuccessResponse($request->getId(), $result));
        }

        $this->events->dispatch(new RequestHandledEvent($request));
    }

    /**
     * @param RPCRequest              $request
     * @param ResponsesStackInterface $responses
     * @param Throwable               $e
     */
    protected function catchErrorOnHandle(RequestInterface $request,
                                          ResponsesStackInterface $responses,
                                          Throwable $e): void
    {
        $this->events->dispatch(new RequestHandledExceptionEvent($request, $e));

        if ($request->isNotification() === false) {
            $responses->push(
                new ErrorResponse(
                    $request->getId(),
                    $e instanceof ErrorInterface
                        ? $e
                        : new InternalError(null, (int) $e->getCode(), $e, $e)
                )
            );
        }
    }

    /**
     * @param RPCRequest              $request
     * @param ResponsesStackInterface $responses
     */
    protected function pushErrorIfNotNotification(RequestInterface $request, ResponsesStackInterface $responses): void
    {
        if ($request->isNotification() === false) {
            $responses->push(new ErrorResponse($request->getId(), new MethodNotFoundError));
        }
    }

    /**
     * @param RPCRequest $request
     */
    protected function bindRpcRequest(RequestInterface $request): void
    {
        $this->container->bind(RPCRequest::class, static function () use ($request): RPCRequest {
            return $request;
        });
    }
}
