<?php 

namespace Royalcms\Component\Validation\Contracts;

use RuntimeException;
use Royalcms\Component\Support\Contracts\MessageProvider;

class ValidationException extends RuntimeException {

	/**
	 * The message provider implementation.
	 *
	 * @var \Royalcms\Component\Support\Contracts\MessageProvider
	 */
	protected $provider;

	/**
	 * Create a new validation exception instance.
	 *
	 * @param  \Royalcms\Component\Support\Contracts\MessageProvider  $provider
	 * @return void
	 */
	public function __construct(MessageProvider $provider)
	{
		$this->provider = $provider;
	}

	/**
	 * Get the validation error message provider.
	 *
	 * @return \Royalcms\Component\Support\Contracts\MessageProvider
	 */
	public function errors()
	{
		return $this->provider->getMessageBag();
	}

	/**
	 * Get the validation error message provider.
	 *
	 * @return \Royalcms\Component\Support\Contracts\MessageProvider
	 */
	public function getMessageProvider()
	{
		return $this->provider;
	}

}
