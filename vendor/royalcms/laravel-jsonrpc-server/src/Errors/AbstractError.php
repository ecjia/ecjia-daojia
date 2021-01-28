<?php

declare(strict_types=1);

namespace Royalcms\Laravel\JsonRpcServer\Errors;

use Exception;
use Throwable;
use InvalidArgumentException;
use Royalcms\Laravel\JsonRpcServer\Traits\ValidateNonStrictValuesTrait;

abstract class AbstractError extends Exception implements ErrorInterface
{
    use ValidateNonStrictValuesTrait;

    /**
     * @var array|bool|float|int|mixed|object|string|null
     */
    protected $data;

    /**
     * Error constructor.
     *
     * @param string                                        $message   Error message
     * @param int                                           $code      Error code
     * @param array|bool|float|int|mixed|object|string|null $data      Some data, that contains additional information
     *                                                                 about the error
     * @param Throwable|null                                $exception Exception, associated with this error
     *
     * @throws InvalidArgumentException If passed wrong data
     */
    public function __construct(string $message, int $code = 0, $data = null, ?Throwable $exception = null)
    {
        $this->validateErrorDataValue($data, true);
        $this->data = $data;

        parent::__construct($message, $code, $exception);
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->data;
    }
}
