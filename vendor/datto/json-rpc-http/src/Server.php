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

use Datto\JsonRpc;
use Datto\JsonRpc\Evaluator;

/**
 * Class Server
 *
 * @link http://www.simple-is-better.org/json-rpc/transport_http.html Proposed specifications
 *
 * @package Datto\JsonRpc\Http
 */
class Server
{
    private static $CONTENT_TYPE = 'application/json';

    /** @var Evaluator */
    private $evaluator;

    /**
     * @param Evaluator $evaluator
     */
    public function __construct($evaluator)
    {
        $this->evaluator = $evaluator;
    }

    public function reply()
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

        if (strncmp($contentType, self::$CONTENT_TYPE, strlen(self::$CONTENT_TYPE)) !== 0) {
            self::errorInvalidContentType();
            return;
        }

        $message = @file_get_contents('php://input');

        if ($message === false) {
            self::errorInvalidBody();
            return;
        }

        $server = new JsonRpc\Server($this->evaluator);

        $reply = $server->reply($message);

        if ($reply === null) {
            self::successNoContent();
            return;
        }

        self::successContent($reply);
    }

    private static function errorInvalidContentType()
    {
        self::error(415, 'Unsupported Media Type', "Please submit your request with the HTTP header:<br>\r\n&ldquo;Content-Type: " . self::$CONTENT_TYPE . "&rdquo;");
    }

    private static function errorInvalidBody()
    {
        self::error(400, 'Bad Request', "Unable to read the HTTP body.");
    }

    private static function successNoContent()
    {
        header('HTTP/1.1 204 No Content');
    }

    /**
     * Sends a text value as the body of an HTTP/1.1 "200 OK" response.
     *
     * @param string $content
     * String value that will be sent as the body of the HTTP request.
     */
    private static function successContent($content)
    {
        header('HTTP/1.1 200 OK');
        header('Content-Type: ' . self::$CONTENT_TYPE);
        header('Content-Length: ' . strlen($content));

        echo $content;
    }

    /**
     * Sends an error response.
     *
     * @param int $code
     * Integer representing the HTTP/1.1 error code.
     *
     * @param string $title
     * String representing the HTTP/1.1 error name.
     *
     * @param string $description
     * Detailed explanation of the error.
     */
    private static function error($code, $title, $description)
    {
        header("HTTP/1.1 {$code} {$title}");

        echo <<<EOS
<!DOCTYPE html>

<html lang="en">

<head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 <title>Error {$code}: {$title}</title>
 <style type='text/css'>
* { margin:0; padding:0; }
body {
    margin: 12.5%;
    font-family: Georgia,serif;
    line-height: 1.5em;
    color: #333;
}

header {
    margin: 0 0 1.5em 0;
}

h1 {
    font-size: 2em;
    padding: 0 0 .25em 0;
}

header p {
    font-size: 1.2599em;
    color: #666;
    font-style: italic;
    text-transform: lowercase;
}
 </style>
</head>

<body>

<header>
    <h1>Error {$code}</h1>
    <p>{$title}</p>
</header>

<p>{$description}</p>

</body>

</html>
EOS;
    }
}
