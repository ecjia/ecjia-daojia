<?php

namespace Royalcms\Laravel\JsonRpcServer\Requests;

use Countable;
use LogicException;
use IteratorAggregate;

/**
 * @see     RequestsStack
 *
 * @extends IteratorAggregate<ErroredRequestInterface|RequestInterface>
 */
interface RequestsStackInterface extends Countable, IteratorAggregate
{
    /**
     * Push request into stack.
     *
     * @param ErroredRequestInterface|RequestInterface $request
     */
    public function push($request): void;

    /**
     * @throws LogicException
     *
     * @return ErroredRequestInterface|RequestInterface
     */
    public function first();

    /**
     * @return array<mixed>
     */
    public function all(): array;

    /**
     * Is batch response?
     *
     * @return bool
     */
    public function isBatch(): bool;
}
