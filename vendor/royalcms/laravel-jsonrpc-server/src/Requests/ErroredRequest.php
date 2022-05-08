<?php

declare(strict_types=1);

namespace Royalcms\Laravel\JsonRpcServer\Requests;

use Royalcms\Laravel\JsonRpcServer\Errors\ErrorInterface;
use Royalcms\Laravel\JsonRpcServer\Traits\ValidateNonStrictValuesTrait;

class ErroredRequest implements ErroredRequestInterface
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
     * ErroredRequest constructor.
     *
     * @param ErrorInterface  $error
     * @param int|string|null $id
     */
    public function __construct(ErrorInterface $error, $id = null)
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
