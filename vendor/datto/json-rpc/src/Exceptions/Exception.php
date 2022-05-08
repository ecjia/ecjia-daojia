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

namespace Datto\JsonRpc\Exceptions;

use Exception as BaseException;

/**
 * If a method cannot be called (e.g. if the method doesn't exist, or is a
 * private method), then you should throw a "MethodException".
 *
 * If the method is callable, but the user-supplied arguments are incompatible
 * with the method's type signature, or an argument is invalid, then you should
 * throw an "ArgumentException".
 *
 * If the method is callable, and the user-supplied arguments are valid, but an
 * issue arose when the server-side application was evaluating the method, then
 * you should throw an "ApplicationException".
 *
 * If you've extended this JSON-RPC 2.0 library, and an issue arose in your
 * implementation of the JSON-RPC 2.0 specifications, then you should throw an
 * "ImplementationException".
 *
 * @link http://www.jsonrpc.org/specification#error_object
 */
abstract class Exception extends BaseException
{
    /** @var null|boolean|integer|float|string|array */
    private $data;

    /**
     * @param string $message
     * Short description of the error that occurred. This message SHOULD
     * be limited to a single, concise sentence.
     *
     * @param int $code
     * Integer identifying the type of error that occurred. This code MUST
     * follow the JSON-RPC 2.0 requirements for error codes:
     *
     * @param null|boolean|integer|float|string|array $data
     * An optional primitive value that contains additional information about
     * the error.You're free to define the format of this data (e.g. you could
     * supply an array with detailed error information). Alternatively, you may
     * omit this field by supplying a null value.
     *
     * @link http://www.jsonrpc.org/specification#error_object
     *
     */
    public function __construct($message, $code, $data = null)
    {
        parent::__construct($message, $code);

        $this->data = $data;
    }

    /**
     * @return null|boolean|integer|float|string|array
     * Returns the (optional) data property of the error object.
     */
    public function getData()
    {
        return $this->data;
    }
}
