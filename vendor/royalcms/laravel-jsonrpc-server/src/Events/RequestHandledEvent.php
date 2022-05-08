<?php

declare(strict_types=1);

namespace Royalcms\Laravel\JsonRpcServer\Events;

use Royalcms\Laravel\JsonRpcServer\Requests\RequestInterface;

class RequestHandledEvent
{
    /**
     * @var RequestInterface
     */
    public $request;

    /**
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }
}
