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

class HttpResponse
{
    /** @var string */
    private $version;

    /** @var integer */
    private $code;

    /** @var string */
    private $message;

    /** @var array */
    private $headers;

    public static function fromHttpResponseHeader(array $http_response_header)
    {
        $statusLine = array_shift($http_response_header);
        self::readVersionCodeMessage($statusLine, $version, $code, $message);
        self::readHeaders($http_response_header, $headers);

        return new self($version, $code, $message, $headers);
    }

    public function __construct(string $version, int $code, string $message, array $headers)
    {
        $this->version = $version;
        $this->code = $code;
        $this->message = $message;
        $this->headers = $headers;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    private static function readVersionCodeMessage($input, &$version, &$code, &$message)
    {
        if (preg_match("~HTTP/(?<version>[0-9.]+) (?<code>[0-9]+) ?(?<message>.*)~XDs", $input, $match) === 1) {
            $version = $match['version'];
            $code = (integer)$match['code'];
            $message = $match['message'];
        }
    }

    private static function readHeaders(array $http_response_header, &$headers)
    {
        $headers = array();

        foreach ($http_response_header as $header) {
            list($name, $value) = explode(':', $header, 2);

            $headers[$name] = trim($value);
        }

        return $headers;
    }
}
