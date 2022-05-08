<?php

declare(strict_types = 1);

namespace Royalcms\Laravel\JsonRpcServer\Responses;

use ArrayIterator;
use LogicException;

class ResponsesStack implements ResponsesStackInterface
{
    /**
     * @var bool
     */
    protected $is_batch;

    /**
     * @var array<ResponseInterface>
     */
    protected $responses = [];

    /**
     * Create a new ResponsesStack instance.
     *
     * @param bool                     $is_batch
     * @param array<ResponseInterface> $responses
     */
    public function __construct(bool $is_batch, array $responses = [])
    {
        $this->is_batch  = $is_batch;
        $this->responses = $responses;
    }

    /**
     * @param bool                     $is_batch
     * @param array<ResponseInterface> $responses
     *
     * @return self<ResponseInterface>
     */
    public static function make(bool $is_batch, array $responses = []): self
    {
        return new self($is_batch, $responses);
    }

    /**
     * Push response into stack.
     *
     * @param ResponseInterface $response
     */
    public function push($response): void
    {
        if ($response instanceof ResponseInterface) {
            $this->responses[] = $response;
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
        return $this->responses;
    }

    /**
     * @return ArrayIterator<int, ResponseInterface>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->responses);
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return count($this->responses);
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty(): bool
    {
        return empty($this->responses);
    }

    /**
     * {@inheritdoc}
     */
    public function isNotEmpty(): bool
    {
        return ! $this->isEmpty();
    }

    /**
     * {@inheritdoc}
     */
    public function first(): ResponseInterface
    {
        if (\count($this->responses) === 0) {
            throw new LogicException('Stack is empty');
        }

        return \reset($this->responses);
    }
}
