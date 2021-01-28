<?php

declare(strict_types=1);

namespace Royalcms\Laravel\JsonRpcServer\Events;

use Royalcms\Laravel\JsonRpcServer\Requests\ErroredRequestInterface;

class ErroredRequestDetectedEvent
{
    /**
     * @var ErroredRequestInterface
     */
    public $error;

    /**
     * Create a new event instance.
     *
     * @param ErroredRequestInterface $error
     */
    public function __construct(ErroredRequestInterface $error)
    {
        $this->error = $error;
    }
}
