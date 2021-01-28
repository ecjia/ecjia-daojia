<?php

declare(strict_types=1);

namespace Royalcms\Laravel\JsonRpcServer\Traits;

use InvalidArgumentException;

trait ValidateNonStrictValuesTrait
{
    /**
     * Assert that ID has valid type.
     *
     * @param int|mixed|string|null $val
     * @param bool                  $throw Throw an exception when validation failed?
     * @param string                $name  Parameter name
     *
     * @throws InvalidArgumentException
     *
     * @return bool True if validation successful
     */
    protected function validateIdValue($val, bool $throw = false, string $name = 'id'): bool
    {
        if ((\is_int($val) === true || \is_string($val) === true || $val === null) && $val !== '') {
            return true;
        }

        if ($throw === true) {
            throw new InvalidArgumentException("Wrong [{$name}] value passed");
        }

        return false;
    }

    /**
     * Assert that Result has valid type.
     *
     * @param array|bool|float|int|mixed|object|string|null $val
     * @param bool                                          $throw
     * @param string                                        $name
     *
     * @throws InvalidArgumentException
     *
     * @return bool True if validation successful
     */
    protected function validateResultValue($val, bool $throw = false, string $name = 'result'): bool
    {
        if (\is_scalar($val) === true || \is_array($val) === true || \is_object($val) === true || $val === null) {
            return true;
        }

        if ($throw === true) {
            throw new InvalidArgumentException("Wrong [{$name}] value passed");
        }

        return false;
    }

    /**
     * Assert that Error data has valid type.
     *
     * @param array|bool|float|int|mixed|object|string|null $val
     * @param bool                                          $throw
     * @param string                                        $name
     *
     * @throws InvalidArgumentException
     *
     * @return bool True if validation successful
     */
    protected function validateErrorDataValue($val, bool $throw = false, string $name = 'data'): bool
    {
        if (\is_scalar($val) === true || \is_array($val) === true || \is_object($val) === true || $val === null) {
            return true;
        }

        if ($throw === true) {
            throw new InvalidArgumentException("Wrong [{$name}] value passed");
        }

        return false;
    }

    /**
     * Assert that params data has valid type.
     *
     * @param array|mixed|object|null $val
     * @param bool                    $throw
     * @param string                  $name
     *
     * @throws InvalidArgumentException
     *
     * @return bool True if validation successful
     */
    protected function validateParamsValue($val, bool $throw = false, string $name = 'params'): bool
    {
        if (\is_array($val) === true || \is_object($val) === true || $val === null) {
            return true;
        }

        if ($throw === true) {
            throw new InvalidArgumentException("Wrong [{$name}] value passed");
        }

        return false;
    }
}
