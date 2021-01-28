<?php

namespace Royalcms\Laravel\JsonRpcServer\Responses;

use Countable;
use LogicException;
use IteratorAggregate;

/**
 * @see     ResponsesStack
 *
 * @extends IteratorAggregate<ResponseInterface>
 */
interface ResponsesStackInterface extends Countable, IteratorAggregate
{
    /**
     * Push response into stack.
     *
     * @param ResponseInterface $response
     */
    public function push($response): void;

    /**
     * @throws LogicException
     *
     * @return ResponseInterface
     */
    public function first(): ResponseInterface;

    /**
     * @return array<ResponseInterface>
     */
    public function all(): array;

    /**
     * Is batch response?
     *
     * @return bool
     */
    public function isBatch(): bool;

    /**
     * Determine if stack is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Determine if stack is not empty.
     *
     * @return bool
     */
    public function isNotEmpty(): bool;
}
