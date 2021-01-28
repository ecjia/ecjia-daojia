<?php

namespace Datto\JsonRpc\Http\Examples;

use Datto\JsonRpc\Evaluator as JsonRpcEvaluator;
use Datto\JsonRpc\Exceptions\ArgumentException;
use Datto\JsonRpc\Exceptions\MethodException;

class Evaluator implements JsonRpcEvaluator
{
    public function evaluate($method, $arguments)
    {
        if ($method === 'add') {
            return self::add($arguments);
        }

        throw new MethodException();
    }

    private static function add($arguments)
    {
        list($a, $b) = $arguments;

        if (!is_int($a) || !is_int($b)) {
            throw new ArgumentException();
        }

        return Math::add($a, $b);
    }
}
