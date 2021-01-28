<?php

declare(strict_types=1);

namespace Royalcms\Laravel\JsonRpcServer\Responses;

use InvalidArgumentException;
use Royalcms\Laravel\JsonRpcServer\Errors\ErrorInterface;
use Royalcms\Laravel\JsonRpcServer\Traits\ValidateNonStrictValuesTrait;

class ErrorResponse implements ErrorResponseInterface
{
    use ValidateNonStrictValuesTrait;

    /**
     * @var int|string|null
     */
    protected $id;

    /**
     * @var ErrorInterface
     */
    protected $error;

    /**
     * ErrorResponse constructor.
     *
     * @param int|string|null $id
     * @param ErrorInterface  $error
     *
     * @throws InvalidArgumentException If passed not valid arguments
     */
    public function __construct($id, ErrorInterface $error)
    {
        $this->validateIdValue($id, true);

        $this->id    = $id;
        $this->error = $error;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getError(): ErrorInterface
    {
        return $this->error;
    }
}
