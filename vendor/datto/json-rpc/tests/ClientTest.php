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
use Datto\JsonRpc\Client;
use Datto\JsonRpc\Responses\ResultResponse;
use Datto\JsonRpc\Responses\ErrorResponse;

class ClientTest extends TestCase
{
    public function testNotification()
    {
        $client = new Client();
        $client->notify('subtract', array(3, 2));

        $this->compare($client, '{"jsonrpc":"2.0","method":"subtract","params":[3,2]}');
    }

    public function testQuery()
    {
        $client = new Client();
        $client->query(1, 'subtract', array(3, 2));

        $this->compare($client, '{"jsonrpc":"2.0","id":1,"method":"subtract","params":[3,2]}');
    }

    public function testBatch()
    {
        $client = new Client();
        $client->query(1, 'subtract', array(3, 2));
        $client->notify('subtract', array(4, 3));

        $this->compare($client, '[{"jsonrpc":"2.0","id":1,"method":"subtract","params":[3,2]},{"jsonrpc":"2.0","method":"subtract","params":[4,3]}]');
    }

    public function testEmpty()
    {
        $client = new Client();

        $this->compare($client, null);
    }

    public function testReset()
    {
        $client = new Client();
        $client->notify('subtract', array(3, 2));
        $client->encode();

        $this->compare($client, null);
    }

    public function testDecodeResult()
    {
        $reply = '{"jsonrpc":"2.0","result":2,"id":1}';

        $client = new Client();
        $actualOutput = $client->decode($reply);
        $expectedOutput = [new ResultResponse(1, 2)];

        $this->assertSameValues($expectedOutput, $actualOutput);
    }

    public function testDecodeError()
    {
        $reply = '{"jsonrpc":"2.0","id":1,"error":{"code":-32601,"message":"Method not found"}}';

        $client = new Client();
        $actualOutput = $client->decode($reply);
        $expectedOutput = [new ErrorResponse(1, 'Method not found', -32601)];

        $this->assertSameValues($expectedOutput, $actualOutput);
    }

    private function assertSameValues($expected, $actual)
    {
        $expectedPhp = var_export($expected, true);
        $actualPhp = var_export($actual, true);

        $this->assertSame($expectedPhp, $actualPhp);
    }

    private function compare(Client $client, $expectedJsonOutput)
    {
        $actualJsonOutput = $client->encode();

        $expectedOutput = @json_decode($expectedJsonOutput, true);
        $actualOutput = @json_decode($actualJsonOutput, true);

        $this->assertEquals($expectedOutput, $actualOutput);
    }
}
