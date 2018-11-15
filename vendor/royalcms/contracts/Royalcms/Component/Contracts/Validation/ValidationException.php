<?php

namespace Royalcms\Component\Contracts\Validation;

use RuntimeException;
use Royalcms\Component\Contracts\Support\MessageProvider;

class ValidationException extends RuntimeException
{
    /**
     * The message provider implementation.
     *
     * @var \Royalcms\Component\Contracts\Support\MessageProvider
     */
    protected $provider;

    /**
     * Create a new validation exception instance.
     *
     * @param  \Royalcms\Component\Contracts\Support\MessageProvider  $provider
     * @return void
     */
    public function __construct(MessageProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Get the validation error message provider.
     *
     * @return \Royalcms\Component\Contracts\Support\MessageBag
     */
    public function errors()
    {
        return $this->provider->getMessageBag();
    }

    /**
     * Get the validation error message provider.
     *
     * @return \Royalcms\Component\Contracts\Support\MessageProvider
     */
    public function getMessageProvider()
    {
        return $this->provider;
    }
}
