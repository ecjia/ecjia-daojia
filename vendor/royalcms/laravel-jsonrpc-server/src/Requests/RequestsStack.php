<?php

declare(strict_types = 1);

namespace Royalcms\Laravel\JsonRpcServer\Requests;

use ArrayIterator;
use LogicException;

class RequestsStack implements RequestsStackInterface
{
    /**
     * @var bool
     */
    protected $is_batch;

    /**
     * @var array<ErroredRequestInterface|RequestInterface>
     */
    protected $requests = [];

    /**
     * RequestsStack constructor.
     *
     * @param bool                                            $is_batch
     * @param array<ErroredRequestInterface|RequestInterface> $requests
     */
    public function __construct(bool $is_batch, array $requests = [])
    {
        $this->is_batch = $is_batch;
        $this->requests = $requests;
    }

    /**
     * @param bool                                            $is_batch
     * @param array<ErroredRequestInterface|RequestInterface> $requests
     *
     * @return self<ErroredRequestInterface|RequestInterface>
     */
    public static function make(bool $is_batch, array $requests = []): self
    {
        return new self($is_batch, $requests);
    }

    /**
     * {@inheritdoc}
     */
    public function push($request): void
    {
        if ($request instanceof RequestInterface) {
            $this->requests[] = $request;
        } elseif ($request instanceof ErroredRequestInterface) {
            $this->requests[] = $request;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isBatch(): bool
    {
        return $this->is_batch;
    }

    /**
     * {@inheritdoc}
     */
    public function all(): array
    {
        return $this->requests;
    }

    /**
     * @return ArrayIterator<int, ErroredRequestInterface|RequestInterface>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->requests);
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return count($this->requests);
    }

    /**
     * Determine if stack is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->requests);
    }

    /**
     * Determine if stack is not empty.
     *
     * @return bool
     */
    public function isNotEmpty(): bool
    {
        return ! $this->isEmpty();
    }

    /**
     * {@inheritdoc}
     */
    public function first()
    {
        if (\count($this->requests) === 0) {
            throw new LogicException('Stack is empty');
        }

        return \reset($this->requests);
    }
}
