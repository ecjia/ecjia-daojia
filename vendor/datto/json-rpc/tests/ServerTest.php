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

namespace Datto\JsonRpc\Tests;

use PHPUnit\Framework\TestCase;
use Datto\JsonRpc\Server;

class ServerTest extends TestCase
{
    public function testArgumentsPositionalA()
    {
        $input = '{"jsonrpc": "2.0", "id": 1, "method": "subtract", "params": [3, 2]}';

        $output = '{"jsonrpc": "2.0", "id": 1, "result": 1}';

        $this->compare($input, $output);
    }

    public function testArgumentsPositionalB()
    {
        $input = '{"jsonrpc": "2.0", "id": 1, "method": "subtract", "params": [2, 3]}';

        $output = '{"jsonrpc": "2.0", "id": 1, "result": -1}';

        $this->compare($input, $output);
    }

    public function testArgumentsNamedA()
    {
        $input = '{"jsonrpc": "2.0", "id": 1, "method": "subtract", "params": {"minuend": 3, "subtrahend": 2}}';

        $output = '{"jsonrpc": "2.0", "id": 1, "result": 1}';

        $this->compare($input, $output);
    }

    public function testArgumentsInvalid()
    {
        $input = '{"jsonrpc": "2.0", "id": 1, "method": "subtract", "params": []}';

        $output = '{"jsonrpc": "2.0", "id": 1, "error": {"code": -32602, "message": "Invalid params"}}';

        $this->compare($input, $output);
    }

    public function testArgumentsNamedB()
    {
        $input = '{"jsonrpc": "2.0", "id": 1, "method": "subtract", "params": {"subtrahend": 2, "minuend": 3}}';

        $output = '{"jsonrpc": "2.0", "id": 1, "result": 1}';

        $this->compare($input, $output);
    }

    public function testNotificationArguments()
    {
        $input = '{"jsonrpc": "2.0", "method": "subtract", "params": [3, 2]}';

        $output = 'null';

        $this->compare($input, $output);
    }

    public function testNotification()
    {
        $input = '{"jsonrpc": "2.0", "method": "subtract"}';

        $output = 'null';

        $this->compare($input, $output);
    }

    public function testUndefinedMethod()
    {
        $input ='{"jsonrpc": "2.0", "id": 1, "method": "undefined"}';

        $output = '{"jsonrpc": "2.0", "id": 1, "error": {"code": -32601, "message": "Method not found"}}';

        $this->compare($input, $output);
    }

    public function testInvalidJson()
    {
        $input = '{"jsonrpc": "2.0", "method": "foobar", "params": "bar", "baz]';

        $output = '{"jsonrpc": "2.0", "id": null, "error": {"code": -32700, "message": "Parse error"}}';

        $this->compare($input, $output);
    }

    public function testMissingJsonrpcVersion()
    {
        $input = '{"method": "subtract", "params": [3, 2], "id": 1}';

        $output = '{"jsonrpc": "2.0", "id": 1, "error": {"code": -32600, "message": "Invalid Request"}}';

        $this->compare($input, $output);
    }

    public function testInvalidJsonrpcVersion()
    {
        $input = '{"jsonrpc": "2.1", "id": 1, "method": "subtract", "params": [3, 2]}';

        $output = '{"jsonrpc": "2.0", "id": 1, "error": {"code": -32600, "message": "Invalid Request"}}';

        $this->compare($input, $output);
    }

    public function testInvalidMethod()
    {
        $input = '{"jsonrpc": "2.0", "method": 1, "params": [1, 2]}';

        $output = '{"jsonrpc": "2.0", "id": null, "error": {"code": -32600, "message": "Invalid Request"}}';

        $this->compare($input, $output);
    }

    public function testInvalidParams()
    {
        $input = '{"jsonrpc": "2.0", "method": "foobar", "params": "bar"}';

        $output = '{"jsonrpc": "2.0", "id": null, "error": {"code": -32600, "message": "Invalid Request"}}';

        $this->compare($input, $output);
    }

    public function testImplementationError()
    {
        $input = '{"jsonrpc": "2.0", "id": 1, "method": "implementation error"}';

        $output = '{"jsonrpc": "2.0", "id": 1, "error": {"code": -32099, "message": "Server error"}}';

        $this->compare($input, $output);
    }

    public function testImplementationErrorData()
    {
        $input = '{"jsonrpc": "2.0", "id": 1, "method": "implementation error", "params": ["details"]}';

        $output = '{"jsonrpc": "2.0", "id": 1, "error": {"code": -32099, "message": "Server error", "data": "details"}}';

        $this->compare($input, $output);
    }

    public function testImplementationErrorInvalid()
    {
        $input = '{"jsonrpc": "2.0", "id": 1, "method": "invalid implementation error"}';

        $output = '{"jsonrpc": "2.0", "id": 1, "error": {"code": -32099, "message": "Server error"}}';

        $this->compare($input, $output);
    }

    public function testApplicationError()
    {
        $input = '{"jsonrpc": "2.0", "id": 1, "method": "application error"}';

        $output = '{"jsonrpc": "2.0", "id": 1, "error": {"code": 1, "message": "Application error"}}';

        $this->compare($input, $output);
    }

    public function testApplicationErrorData()
    {
        $input = '{"jsonrpc": "2.0", "id": 1, "method": "application error", "params": ["details"]}';

        $output = '{"jsonrpc": "2.0", "id": 1, "error": {"code": 1, "message": "Application error", "data": "details"}}';

        $this->compare($input, $output);
    }

    public function testApplicationErrorInvalid()
    {
        $input = '{"jsonrpc": "2.0", "id": 1, "method": "invalid application error"}';

        $output = '{"jsonrpc": "2.0", "id": 1, "error": {"code": 1, "message": ""}}';

        $this->compare($input, $output);
    }

    public function testInvalidId()
    {
        $input = '{"jsonrpc": "2.0", "method": "foobar", "params": [1, 2], "id": [1]}';

        $output = '{"jsonrpc": "2.0", "id": null, "error": {"code": -32600, "message": "Invalid Request"}}';

        $this->compare($input, $output);
    }

    public function testBatchInvalidJson()
    {
        $input = ' [
            {"jsonrpc": "2.0", "method": "subtract", "params": [1, 2, 4], "id": "1"},
            {"jsonrpc": "2.0", "method"
        ]';

        $output = '{"jsonrpc": "2.0", "id": null, "error": {"code": -32700, "message": "Parse error"}}';

        $this->compare($input, $output);
    }

    public function testBatchEmpty()
    {
        $input = '[
        ]';

        $output = '{"jsonrpc": "2.0", "id": null, "error": {"code": -32600, "message": "Invalid Request"}}';

        $this->compare($input, $output);
    }

    public function testBatchInvalidElement()
    {
        $input = '[
            1
        ]';

        $output = '[
            {"jsonrpc": "2.0", "id": null, "error": {"code": -32600, "message": "Invalid Request"}}
        ]';

        $this->compare($input, $output);
    }

    public function testBatchInvalidElements()
    {
        $input = '[
            1,
            2,
            3
        ]';

        $output = '[
            {"jsonrpc": "2.0", "id": null, "error": {"code": -32600, "message": "Invalid Request"}},
            {"jsonrpc": "2.0", "id": null, "error": {"code": -32600, "message": "Invalid Request"}},
            {"jsonrpc": "2.0", "id": null, "error": {"code": -32600, "message": "Invalid Request"}}
        ]';

        $this->compare($input, $output);
    }

    public function testBatch()
    {
        $input = '[
            {"jsonrpc": "2.0", "method": "subtract", "params": [1, -1], "id": "1"},
            {"jsonrpc": "2.0", "method": "subtract", "params": [1, -1]},
            {"foo": "boo"},
            {"jsonrpc": "2.0", "method": "undefined", "params": {"name": "myself"}, "id": "5"}
        ]';

        $output = '[
            {"jsonrpc": "2.0", "id": "1", "result": 2},
            {"jsonrpc": "2.0", "id": null, "error": {"code": -32600, "message": "Invalid Request"}},
            {"jsonrpc": "2.0", "id": "5", "error": {"code": -32601, "message": "Method not found"}}
        ]';

        $this->compare($input, $output);
    }

    public function testBatchNotifications()
    {
        $input = '[
            {"jsonrpc": "2.0", "method": "subtract", "params": [4, 2]},
            {"jsonrpc": "2.0", "method": "subtract", "params": [3, 7]}
        ]';

        $output = 'null';

        $this->compare($input, $output);
    }

    private function compare($input, $expectedJsonOutput)
    {
        $server = new Server(new Api());
        $actualJsonOutput = $server->reply($input);

        $expectedOutput = json_decode($expectedJsonOutput, true);
        $actualOutput = json_decode($actualJsonOutput, true);

        $this->assertSame($expectedOutput, $actualOutput);
    }
}
