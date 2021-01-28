<?php

declare(strict_types=1);

namespace Royalcms\Laravel\JsonRpcServer\Events;

use Throwable;
use Royalcms\Laravel\JsonRpcServer\Requests\RequestInterface;

class RequestHandledExceptionEvent
{
    /**
     * @var RequestInterface
     */
    public $request;

    /**
     * @var Throwable
     */
    public $error;

    /**
     * @param RequestInterface $request
     * @param Throwable        $error
     */
    public function __construct(RequestInterface $request, Throwable $error)
    {
        $this->request = $request;
        $this->error   = $error;
    }
}
