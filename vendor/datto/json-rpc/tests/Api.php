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

use Datto\JsonRpc\Evaluator;
use Datto\JsonRpc\Exceptions;

class Api implements Evaluator
{
    public function evaluate($method, $arguments)
    {
        switch ($method) {
            case 'subtract':
                return self::subtract($arguments);

            case 'implementation error':
                return self::implementationError($arguments);

            case 'invalid implementation error':
                return self::invalidImplementationError();

            case 'application error':
                return self::applicationError($arguments);

            case 'invalid application error':
                return self::invalidApplicationError();

            default:
                throw new Exceptions\MethodException();
        }
    }

    private static function subtract($arguments)
    {
        if (isset($arguments[0])) {
            @list($a, $b) = $arguments;
        } else {
            $a = @$arguments['minuend'];
            $b = @$arguments['subtrahend'];
        }

        if (!is_int($a) || !is_int($b) || (count($arguments) !== 2)) {
            throw new Exceptions\ArgumentException();
        }

        return $a - $b;
    }

    private static function implementationError($arguments)
    {
        throw new Exceptions\ImplementationException(-32099, @$arguments[0]);
    }

    private static function invalidImplementationError()
    {
        $invalid = new \StdClass();

        throw new Exceptions\ImplementationException($invalid, $invalid);
    }

    private static function applicationError($arguments)
    {
        throw new Exceptions\ApplicationException("Application error", 1, @$arguments[0]);
    }

    private static function invalidApplicationError()
    {
        $invalid = new \StdClass();

        throw new Exceptions\ApplicationException($invalid, $invalid, $invalid);
    }
}
