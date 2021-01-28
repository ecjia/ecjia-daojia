<?php

namespace Royalcms\Laravel\JsonRpcServer\Factories;

use InvalidArgumentException;
use Royalcms\Laravel\JsonRpcServer\Errors\ParseError;
use Royalcms\Laravel\JsonRpcServer\Errors\InvalidRequestError;
use Royalcms\Laravel\JsonRpcServer\Responses\ResponseInterface;
use Royalcms\Laravel\JsonRpcServer\Requests\RequestsStackInterface;
use Royalcms\Laravel\JsonRpcServer\Responses\ErrorResponseInterface;
use Royalcms\Laravel\JsonRpcServer\Responses\ResponsesStackInterface;
use Royalcms\Laravel\JsonRpcServer\Responses\SuccessResponseInterface;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * @see RequestFactory
 */
interface FactoryInterface
{
    /**
     * Convert Json-RPC request (v2.0) in string interpretation into requests stack object.
     *
     * @see <https://www.jsonrpc.org/specification>
     *
     * @example
     *
     * Single call
     * {
     *      "jsonrpc": "2.0",
     *      "method": "METHOD_NAME",
     *      "params": [42, 23],
     *      "id": 1
     * }
     * @example
     *
     * Notification
     * {
     *      "jsonrpc": "2.0",
     *      "method": "METHOD_NAME",
     *      "params": [42, 23]
     * }
     * @example
     *
     * Multiple calls
     * [
     *  {
     *      "jsonrpc": "2.0",
     *      "method": "subtract",
     *      "params": [42, 23],
     *      "id": 1
     *  },
     *  {
     *      "jsonrpc": "2.0",
     *      "method": "update",
     *      "params": [1,2],
     *      "id": 2
     *  }
     * ]
     *
     * @param string $json_string
     * @param int    $options
     *
     * @throws ParseError
     * @throws InvalidRequestError
     *
     * @return RequestsStackInterface
     */
    public function jsonStringToRequestsStack(string $json_string, int $options = 0): RequestsStackInterface;

    /**
     * Convert error response into HTTP response with required content.
     *
     * @param ErrorResponseInterface $error
     * @param int                    $options Json encode options
     *
     * @return HttpResponse
     */
    public function errorToHttpResponse(ErrorResponseInterface $error, int $options = 0): HttpResponse;

    /**
     * Convert responses stack into HTTP response with required content. Response can be empty.
     *
     * @param ResponsesStackInterface $responses
     * @param int                     $options
     *
     * @return HttpResponse
     */
    public function responsesToHttpResponse(ResponsesStackInterface $responses, int $options = 0): HttpResponse;

    /**
     * Convert error response into json interpretation.
     *
     * @example
     *
     * {
     *      "jsonrpc": "2.0",
     *      "error": {
     *          "code": "ERROR_CODE",
     *          "message": "ERROR_MESSAGE"
     *      },
     *      "id": "REQUEST_ID"
     * }
     *
     * @param ErrorResponseInterface $response
     * @param int                    $options  Json encode options
     *
     * @return string
     */
    public function errorResponseToJsonString(ErrorResponseInterface $response, int $options = 0): string;

    /**
     * Convert success response into json interpretation.
     *
     * @example
     *
     * {
     *      "jsonrpc": "2.0",
     *      "result": {
     *          "success": true,
     *          "message": "SUCCESS_MESSAGE"
     *      },
     *      "id": "REQUEST_ID_2"
     * }
     *
     * @param SuccessResponseInterface $response
     * @param int                      $options  Json encode options
     *
     * @return string
     */
    public function successResponseToJsonString(SuccessResponseInterface $response, int $options = 0): string;

    /**
     * Convert responses stack into Json-RPC interpretation.
     *
     * @example
     *
     * [
     *  {
     *      "jsonrpc": "2.0",
     *      "result": {
     *          "success": true,
     *          "message": "SUCCESS_MESSAGE"
     *      },
     *      "id": "REQUEST_ID_1"
     *  },
     *  {
     *      "jsonrpc": "2.0",
     *      "result": {
     *          "success": true,
     *          "message": "SUCCESS_MESSAGE"
     *      },
     *      "id": "REQUEST_ID_2"
     *  }
     * ]
     *
     * @param ResponsesStackInterface $stack
     * @param int                     $options Json encode options
     *
     * @throws InvalidArgumentException If responses has invalid type
     *
     * @return string|null Null if stack in empty
     */
    public function responsesStackToJsonString(ResponsesStackInterface $stack, int $options = 0): ?string;

    /**
     * Convert response to the JSON string.
     *
     * @param ResponseInterface $response
     * @param int               $options
     *
     * @throws InvalidArgumentException
     *
     * @return string
     */
    public function responseToJsonString(ResponseInterface $response, int $options = 0): string;
}
