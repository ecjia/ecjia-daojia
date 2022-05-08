<?php

/**
 * Copyright (C) 2015 Datto, Inc.
 *
 * This file is part of PHP JSON-RPC.
 *
 * PHP JSON-RPC is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * PHP JSON-RPC is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with PHP JSON-RPC. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Spencer Mortensen <smortensen@datto.com>
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL-3.0
 * @copyright 2015 Datto, Inc.
 */

namespace Datto\JsonRpc;

use Datto\JsonRpc\Exceptions\Exception;
use Datto\JsonRpc\Responses\ErrorResponse;

/**
 * @link http://www.jsonrpc.org/specification JSON-RPC 2.0 Specifications
 */
class Server
{
    /** @var string */
    const VERSION = '2.0';

    /** @var Evaluator */
    private $evaluator;

    /**
     * @param Evaluator $evaluator
     */
    public function __construct(Evaluator $evaluator)
    {
        $this->evaluator = $evaluator;
    }

    /**
     * Processes a JSON-RPC 2.0 client request string and prepares a valid
     * response.
     *
     * @param string $json
     * Single request object, or an array of request objects, as a JSON string.
     *
     * @return null|string
     * Returns null when no response is necessary.
     * Returns a response/error object, as a JSON string, when a query is made.
     * Returns an array of response/error objects, as a JSON string, when multiple queries are made.
     * @see Responses\ResultResponse
     * @see Responses\ErrorResponse
     */
    public function reply($json)
    {
        if (is_string($json)) {
            $input = json_decode($json, true);
        } else {
            $input = null;
        }

        $reply = $this->rawReply($input);

        if (is_array($reply)) {
            $output = json_encode($reply);
        } else {
            $output = null;
        }

        return $output;
    }

    /**
     * Processes a JSON-RPC 2.0 client request array and prepares a valid
     * response. This method skips the JSON encoding and decoding steps,
     * so you can use your own alternative encoding algorithm, or extend
     * the JSON-RPC 2.0 format.
     *
     * When you use this method, you are taking responsibility for
     * performing the necessary JSON encoding and decoding steps yourself.
     * @see self::reply()
     *
     * @param mixed $input
     * An array containing the JSON-decoded client request.
     *
     * @return null|array
     * Returns null if no reply is necessary
     * Returns the JSON-RPC 2.0 server reply as an array
     */
    public function rawReply($input)
    {
        if (is_array($input)) {
            $reply = $this->processInput($input);
        } else {
            $reply = $this->parseError();
        }

        return $reply;
    }

    /**
     * Processes the user input, and prepares a response (if necessary).
     *
     * @param array $input
     * Single request object, or an array of request objects.
     *
     * @return array|null
     * Returns a response object (or an error object) when a query is made.
     * Returns an array of response/error objects when multiple queries are made.
     * Returns null when no response is necessary.
     */
    private function processInput(array $input)
    {
        if (count($input) === 0) {
            return $this->requestError();
        }

        if (isset($input[0])) {
            return $this->processBatchRequests($input);
        }

        return $this->processRequest($input);
    }

    /**
     * Processes a batch of user requests, and prepares the response.
     *
     * @param array $input
     * Array of request objects.
     *
     * @return array|null
     * Returns a response/error object when a query is made.
     * Returns an array of response/error objects when multiple queries are made.
     * Returns null when no response is necessary.
     */
    private function processBatchRequests($input)
    {
        $replies = array();

        foreach ($input as $request) {
            $reply = $this->processRequest($request);

            if ($reply !== null) {
                $replies[] = $reply;
            }
        }

        if (count($replies) === 0) {
            return null;
        }

        return $replies;
    }

    /**
     * Processes an individual request, and prepares the response.
     *
     * @param array $request
     * Single request object to be processed.
     *
     * @return array|null
     * Returns a response object or an error object.
     * Returns null when no response is necessary.
     */
    private function processRequest($request)
    {
        if (!is_array($request)) {
            return $this->requestError();
        }

        // The presence of the 'id' key indicates that a response is expected
        $isQuery = array_key_exists('id', $request);

        $id = &$request['id'];

        if (($id !== null) && !is_int($id) && !is_float($id) && !is_string($id)) {
            return $this->requestError();
        }

        $version = &$request['jsonrpc'];

        if ($version !== self::VERSION) {
            return $this->requestError($id);
        }

        $method = &$request['method'];

        if (!is_string($method)) {
            return $this->requestError($id);
        }

        // The 'params' key is optional, but must be non-null when provided
        if (array_key_exists('params', $request)) {
            $arguments = $request['params'];

            if (!is_array($arguments)) {
                return $this->requestError($id);
            }
        } else {
            $arguments = array();
        }

        if ($isQuery) {
            return $this->processQuery($id, $method, $arguments);
        }

        $this->processNotification($method, $arguments);
        return null;
    }

    /**
     * Processes a query request and prepares the response.
     *
     * @param mixed $id
     * Client-supplied value that allows the client to associate the server response
     * with the original query.
     *
     * @param string $method
     * String value representing a method to invoke on the server.
     *
     * @param array $arguments
     * Array of arguments that will be passed to the method.
     *
     * @return array
     * Returns a response object or an error object.
     */
    private function processQuery($id, $method, $arguments)
    {
        try {
            $result = $this->evaluator->evaluate($method, $arguments);
            return $this->response($id, $result);
        } catch (Exception $exception) {
            $code = $exception->getCode();
            $message = $exception->getMessage();
            $data = $exception->getData();

            return $this->error($id, $code, $message, $data);
        }
    }

    /**
     * Processes a notification. No response is necessary.
     *
     * @param string $method
     * String value representing a method to invoke on the server.
     *
     * @param array $arguments
     * Array of arguments that will be passed to the method.
     */
    private function processNotification($method, $arguments)
    {
        try {
            $this->evaluator->evaluate($method, $arguments);
        } catch (Exception $exception) {
        }
    }

    /**
     * Returns an error object explaining that an error occurred while parsing
     * the JSON text input.
     *
     * @return array
     * Returns an error object.
     */
    private function parseError()
    {
        return $this->error(null, ErrorResponse::PARSE_ERROR, 'Parse error');
    }

    /**
     * Returns an error object explaining that the JSON input is not a valid
     * request object.
     *
     * @param mixed $id
     * Client-supplied value that allows the client to associate the server response
     * with the original query.
     *
     * @return array
     * Returns an error object.
     */
    private function requestError($id = null)
    {
        return $this->error($id, ErrorResponse::INVALID_REQUEST, 'Invalid Request');
    }

    /**
     * Returns a properly-formatted error object.
     *
     * @param mixed $id
     * Client-supplied value that allows the client to associate the server response
     * with the original query.
     *
     * @param int $code
     * Integer value representing the general type of error encountered.
     *
     * @param string $message
     * Concise description of the error (ideally a single sentence).
     *
     * @param null|boolean|integer|float|string|array $data
     * An optional primitive value that contains additional information about
     * the error.
     *
     * @return array
     * Returns an error object.
     */
    private function error($id, $code, $message, $data = null)
    {
        $error = array(
            'code' => $code,
            'message' => $message
        );

        if ($data !== null) {
            $error['data'] = $data;
        }

        return array(
            'jsonrpc' => self::VERSION,
            'id' => $id,
            'error' => $error
        );
    }

    /**
     * Returns a properly-formatted response object.
     *
     * @param mixed $id
     * Client-supplied value that allows the client to associate the server response
     * with the original query.
     *
     * @param mixed $result
     * Return value from the server method, which will now be delivered to the user.
     *
     * @return array
     * Returns a response object.
     */
    private function response($id, $result)
    {
        return array(
            'jsonrpc' => self::VERSION,
            'id' => $id,
            'result' => $result
        );
    }
}
