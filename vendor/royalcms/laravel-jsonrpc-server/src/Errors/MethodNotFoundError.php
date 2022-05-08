<?php

declare(strict_types=1);

namespace Royalcms\Laravel\JsonRpcServer\Errors;

use Throwable;

class MethodNotFoundError extends AbstractError
{
    /**
     * {@inheritdoc}
     *
     * @param string|null $message Error message
     */
    public function __construct(?string $message = null, int $code = 0, $data = null, ?Throwable $exception = null)
    {
        parent::__construct($message ?? 'Method not found', $code, $data, $exception);
    }
}
