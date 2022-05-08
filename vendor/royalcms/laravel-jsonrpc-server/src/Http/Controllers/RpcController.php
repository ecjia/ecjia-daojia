<?php

declare(strict_types=1);

namespace Royalcms\Laravel\JsonRpcServer\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Royalcms\Laravel\JsonRpcServer\KernelInterface;
use Royalcms\Laravel\JsonRpcServer\Errors\ServerError;
use Royalcms\Laravel\JsonRpcServer\Errors\ErrorInterface;
use Royalcms\Laravel\JsonRpcServer\Responses\ErrorResponse;
use Symfony\Component\HttpFoundation\Response;
use Royalcms\Laravel\JsonRpcServer\Factories\FactoryInterface;

class RpcController extends Controller
{
    /**
     * @param Request          $request
     * @param FactoryInterface $factory
     * @param KernelInterface  $rpc
     *
     * @throws \Royalcms\Laravel\JsonRpcServer\Errors\InvalidRequestError
     * @throws \Royalcms\Laravel\JsonRpcServer\Errors\ParseError
     *
     * @return Response
     */
    public function __invoke(Request $request,
                             FactoryInterface $factory,
                             KernelInterface $rpc): Response
    {
        try {
            // Convert JSON string to RequestsStack
            $requests = $factory->jsonStringToRequestsStack((string) $request->getContent());

            // Handle an incoming RPC request
            $responses = $rpc->handle($requests);

            // Convert responses stack into HTTP response with required content
            return $factory->responsesToHttpResponse($responses);
        } catch (ErrorInterface $error) {
            return $factory->errorToHttpResponse(new ErrorResponse(null, $error));
        } catch (Throwable $e) {
            return $factory->errorToHttpResponse(new ErrorResponse(null, new ServerError(
                "Server error: {$e->getMessage()}", 0, $e, $e
            )));
        }
    }
}
