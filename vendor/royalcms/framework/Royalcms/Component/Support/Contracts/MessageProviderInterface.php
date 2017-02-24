<?php namespace Royalcms\Component\Support\Contracts;

interface MessageProviderInterface {

	/**
	 * Get the messages for the instance.
	 *
	 * @return \Royalcms\Component\Support\MessageBag
	 */
	public function getMessageBag();

}
