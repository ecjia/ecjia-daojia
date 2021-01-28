<?php

/**
 * Copyright (C) 2015 Datto, Inc.
 *
 * This file is part of PHP JSON-RPC HTTP.
 *
 * PHP JSON-RPC HTTP is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * PHP JSON-RPC HTTP is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with PHP JSON-RPC HTTP. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Spencer Mortensen <smortensen@datto.com>
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL-3.0
 * @copyright 2015 Datto, Inc.
 */

namespace Datto\JsonRpc\Http;

use Datto\JsonRpc\Client as JsonRpcClient;
use Datto\JsonRpc\Http\Exceptions\HttpException;
use Datto\JsonRpc\Responses\ResultResponse;
use ErrorException;

/**
 * Class Client
 * @package Datto\JsonRpc\Http
 */
class Client
{
    /** @var string */
    private static $METHOD = 'POST';

    /** @var string */
    private static $CONTENT_TYPE = 'application/json';

    /** @var string */
    private static $CONNECTION_TYPE = 'close';

    /** @var array */
    private $requiredHttpHeaders;

    /** @var string */
    private $uri;

    /** @var array */
    private $headers;

    /** @var resource */
    private $context;

    /** @var JsonRpcClient */
    private $client;

    /** @var array */
    private $responses;

    /**
     * Construct a JSON-RPC 2.0 client. This will allow you to send queries
     * to a remote server.
     *
     * @param string $uri
     * Address of your JSON-RPC 2.0 endpoint.
     *
     * Example:
     * $uri = "https://api.example.com";
     *
     * @param null|array $headers
     * An associative array of the raw HTTP headers that you'd like to send
     * with your request.
     * 
     * Note that the CONTENT_TYPE, CONNECTION_TYPE, and METHOD headers are
     * automatically applied, since they are required for every request,
     * so you don't need to add them.
     * 
     * You might need to add headers if you're using an authenticated API:
     *
     * Example 1. Add the header for basic access authentication:
     * $authentication = base64_encode("{$username}:{$password}");
     * $headers = array(
     *   'Authorization' => "Basic {$authentication}"
     * );
     *
     * @param null|array $options
     * An associative array of the PHP stream context options that you'd like to use.
     * This can be useful if you'd like to customize the details of your connection.
     *
     * Example 1. Disable SSL verification (this might be useful for a development
     * environment without a valid SSL certificate):
     * 
     * $options = array(
     *   'ssl' => array(
     *       'verify_peer' => false,
     *       'verify_peer_name' => false
     *   )
     * );
     * 
     * @see http://php.net/manual/en/context.ssl.php SSL options
     * 
     * Example 2. Add an HTTP timeout limit (so queries won't hang forever):
     * 
     * $options = array(
     *   'http' => array(
     *       'timeout' => 5
     *   )
     * );
     *
     * @see http://php.net/manual/en/context.http.php HTTP options
     */
    public function __construct($uri, array $headers = null, array $options = null)
    {
        $this->requiredHttpHeaders = array(
            'Accept' => self::$CONTENT_TYPE,
            'Content-Type' => self::$CONTENT_TYPE,
            'Connection' => self::$CONNECTION_TYPE
        );

        $headers = array_merge(self::validHeaders($headers), $this->requiredHttpHeaders);
        $options = self::validOptions($options);
        $context = self::getContext($options);
        $client = new JsonRpcClient();

        $this->uri = $uri;
        $this->headers = $headers;
        $this->context = $context;
        $this->client = $client;
        $this->responses = [];
    }

    /**
     * Queue up a message! You can queue up any number of messages here.
     * Then, when you're ready, call the "send" method to send all of the messages
     * in a single HTTP(S) request.
     * 
     * Other APIs involve a long series of back-to-back roundtrips, but JSON-RPC
     * allows you to get everything done in just one trip! This is wonderful for
     * your latency.
     * 
     * @param string $method
     * The method that you're calling on the remote server
     * 
     * @param array $arguments
     * The arguments that you're supplying to the method
     * 
     * @param mixed $response
     * After you've called this "query" method to queue up your message, call the
     * "send" method to send your message. You'll see a value appear here,
     * in this "$response" object (through the magic of pass by reference).
     * 
     * More than likely, you'll receive the raw value that you were expecting
     * from the server. But, if the server was unable to successfully process
     * your request, you could wind up with an "ErrorResponse" object instead:
     * @see https://github.com/datto/php-json-rpc/tree/master/src/Responses/ErrorResponse ErrorResponse
     * 
     * But be sure to check the type of the "$response" before you use it!
     * 
     * @return self
     * Returns the object handle (so you can chain method calls if you're into
     * that kinky stuff)
     */
    public function query($method, $arguments, &$response)
    {
        $id = count($this->responses);
        $this->responses[$id] = &$response;
        $this->client->query($id, $method, $arguments);

        return $this;
    }

    /**
     * Queue up a message! You can queue up any number of messages here.
     * Then, when you're ready, call the "send" method to send all of the messages
     * in a single HTTP(S) request.
     * 
     * Other APIs involve a long series of back-to-back roundtrips, but JSON-RPC
     * allows you to get everything done in just one trip! This is wonderful for
     * your latency.
     * 
     * This "notify" method sends a message to the server that does NOT need any
     * response. When you don't need a response, this is more efficient than
     * using the "query" method, since the server doesn't have to generate
     * a response, and you don't have to wait for one.
     * 
     * @param string $method
     * The method that you're calling on the remote server
     * 
     * @param array $arguments
     * The arguments that you're supplying to the method
     *  
     * @return self
     * Returns the object handle (so you can chain method calls if you're into
     * that kinky stuff)
     */
    public function notify($method, array $arguments)
    {
        $this->client->notify($method, $arguments);

        return $this;
    }

    /**
     * This method sends your requests over HTTP(S) to the remote server.
     *
     * @throws ErrorException
     * Throws an "ErrorException" if an error occurred before an HTTP response could be received.
     *
     * @throws HttpException
     * Throws an "HttpException" if the server responded with a failure HTTP status code.
     */
    public function send()
    {
        set_error_handler([__CLASS__, 'onError']);

        try {
            $options = $this->getStreamOptions();
            stream_context_set_option($this->context, $options);
            $message = file_get_contents($this->uri, false, $this->context);

            $this->throwHttpExceptionOnHttpError($http_response_header);
            $this->deliverResponses($message);
        } catch (ErrorException $exception) {
            $this->throwHttpExceptionOnHttpError($http_response_header);
            throw $exception;
        } finally {
            restore_error_handler();
        }
    }

    private function throwHttpExceptionOnHttpError($header)
    {
        if (!is_array($header) || (count($header) === 0)) {
            return;
        }

        $response = HttpResponse::fromHttpResponseHeader($header);
        $code = $response->getCode();

        if ($code === 200) {
            return;
        }

        throw new HttpException($response);
    }

    /**
     * Cancel any queries or notifications that you had previously queued:
     * They will not be sent.
     */
    public function reset()
    {
        $this->client->reset();
        $this->responses = [];
    }

    /**
     * View the HTTP headers that will be sent on each request.
     *
     * @return array
     * An associative array containing the raw HTTP headers that will be sent
     * with each request.
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Set add an additional HTTP header. This additional header will be sent
     * on each future HTTP request.
     *
     * @param string $name
     * The name of the HTTP header (e.g. "Authorization").
     *
     * @param string $value
     * The value of this HTTP header (e.g. "Basic dXNlcm5hbWU6cGFzc3dvcmQ=").
     *
     * @return boolean
     * True iff the header has been set successfully (or has had the desired
     * value all along). Note that the CONTENT_TYPE, CONNECTION_TYPE, and
     * METHOD headers cannot be changed (because those headers are required).
     */
    public function setHeader($name, $value)
    {
        if (!self::isValidHeader($name, $value)) {
            return false;
        }

        if (isset($this->requiredHttpHeaders[$name])) {
            return $this->requiredHttpHeaders[$name] === $value;
        }

        $this->headers[$name] = $value;
        return true;
    }

    /**
     * Unset an existing HTTP header. This HTTP header will no longer be sent
     * on future requests.
     *
     * @param string $name
     * The name of the HTTP header (e.g. "Authorization").
     *
     * @return boolean
     * True iff the header was successfully removed (or was never set in the
     * first place). Note that the CONTENT_TYPE, CONNECTION_TYPE, and METHOD
     * headers are required, so those headers cannot be unset.
     */
    public function unsetHeader($name)
    {
        if (!self::isValidHeaderName($name)) {
            return true;
        }

        if (isset($this->requiredHttpHeaders[$name])) {
            return false;
        }

        unset($this->headers[$name]);
        return true;
    }

    private static function validHeaders($headers)
    {
        if (!self::isValidHeaders($headers)) {
            $headers = array();
        }

        return $headers;
    }

    private static function isValidHeaders($input)
    {
        if (!is_array($input)) {
            return false;
        }

        foreach ($input as $name => $value) {
            if (!self::isValidHeader($name, $value)) {
                return false;
            }
        }

        return true;
    }

    private static function isValidHeader($name, $value)
    {
        return self::isValidHeaderName($name) && self::isValidHeaderValue($value);
    }

    private static function isValidHeaderName($name)
    {
        return is_string($name) && (0 < strlen($name));
    }

    private static function isValidHeaderValue($value)
    {
        return is_string($value) && (0 < strlen($value));
    }

    private static function validOptions($options)
    {
        if (!is_array($options)) {
            return array();
        }

        $supportedOptions = array(
            'http' => true,
            'ssl' => true
        );

        return array_intersect_key($options, $supportedOptions);
    }

    private static function getContext($options)
    {
        set_error_handler([__CLASS__, 'onError']);

        try {
            return stream_context_create($options);
        } finally {
            restore_error_handler();
        }
    }

    private function getStreamOptions()
    {
        $content = $this->client->encode();

        $headers = $this->headers;
        $headers['Content-Length'] = strlen($content);
        $header = $this->getHeaderText($headers);

        return array(
            'http' => array(
                'method' => self::$METHOD,
                'header' => $header,
                'content' => $content
            )
        );        
    }

    private function getHeaderText($headers)
    {
        $header = '';

        foreach ($headers as $name => $value) {
            $header .= "{$name}: {$value}\r\n";
        }

        return $header;
    }

    private function deliverResponses(string $message)
    {
        $responses = $this->client->decode($message);

        foreach ($responses as $response) {
            $id = $response->getId();

            if (!array_key_exists($id, $this->responses)) {
                $idText = json_encode($id);
                throw new ErrorException("Received a surprise response from the server with id {$idText}");
            }

            if ($response instanceof ResultResponse) {
                $value = $response->getValue();
            } else {
                $value = $response;
            }

            $this->responses[$id] = $value;
            unset($this->responses[$id]);
        }

        foreach ($this->responses as $id => $response) {
            $idText = json_encode($id);
            throw new ErrorException("Expected a response from the server with id {$idText}, but received nothing! Disappointed!");
        }
    }

    public static function onError($level, $message, $file, $line)
    {
        $message = trim($message);
        $code = null;

        throw new ErrorException($message, $code, $level, $file, $line);
    }
}
