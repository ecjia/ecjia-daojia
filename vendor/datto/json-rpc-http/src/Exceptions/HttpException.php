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

namespace Datto\JsonRpc\Http\Exceptions;

use Datto\JsonRpc\Http\HttpResponse;
use Exception;

class HttpException extends Exception
{
    /** @var HttpResponse */
    private $response;

    public function __construct(HttpResponse $response)
    {
        $status = $this->getStatus($response);

        parent::__construct($status);

        $this->response = $response;
    }

    public function getResponse(): HttpResponse
    {
        return $this->response;
    }

    private function getStatus(HttpResponse $response)
    {
        $code = $response->getCode();
        $message = $response->getMessage();

        if (strlen($message) === 0) {
            return $code;
        }

        return "{$code} {$message}";
    }
}
