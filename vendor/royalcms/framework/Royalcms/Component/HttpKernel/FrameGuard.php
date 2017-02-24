<?php namespace Royalcms\Component\HttpKernel;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class FrameGuard implements HttpKernelInterface {

	/**
	 * The wrapped kernel implementation.
	 *
	 * @var \Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	protected $royalcms;

	/**
	 * Create a new FrameGuard instance.
	 *
	 * @param  \Symfony\Component\HttpKernel\HttpKernelInterface  $royalcms
	 * @return void
	 */
	public function __construct(HttpKernelInterface $royalcms)
	{
		$this->royalcms = $royalcms;
	}

	/**
	 * Handle the given request and get the response.
	 *
	 * @implements HttpKernelInterface::handle
	 *
	 * @param  \Symfony\Component\HttpFoundation\Request  $request
	 * @param  int   $type
	 * @param  bool  $catch
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function handle(SymfonyRequest $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
	{
		$response = $this->royalcms->handle($request, $type, $catch);

		$response->headers->set('X-Frame-Options', 'SAMEORIGIN', false);

		return $response;
	}

}
