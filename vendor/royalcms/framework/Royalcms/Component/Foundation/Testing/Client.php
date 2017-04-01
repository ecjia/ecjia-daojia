<?php namespace Royalcms\Component\Foundation\Testing;

use Royalcms\Component\Foundation\Royalcms;
use Symfony\Component\HttpKernel\Client as BaseClient;
use Symfony\Component\BrowserKit\Request as DomRequest;

class Client extends BaseClient {

	/**
	 * Convert a BrowserKit request into a Royalcms request.
	 *
	 * @param  \Symfony\Component\BrowserKit\Request  $request
	 * @return \Royalcms\Component\HttpKernel\Request
	 */
	protected function filterRequest(DomRequest $request)
	{
		$httpRequest = Royalcms::onRequest('create', $this->getRequestParameters($request));

		$httpRequest->files->replace($this->filterFiles($httpRequest->files->all()));

		return $httpRequest;
	}

	/**
	 * Get the request parameters from a BrowserKit request.
	 *
	 * @param  \Symfony\Component\BrowserKit\Request  $request
	 * @return array
	 */
	protected function getRequestParameters(DomRequest $request)
	{
		return array(
			$request->getUri(), $request->getMethod(), $request->getParameters(), $request->getCookies(),
			$request->getFiles(), $request->getServer(), $request->getContent()
		);
	}

}
