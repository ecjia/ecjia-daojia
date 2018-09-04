<?php namespace Royalcms\Component\Debugbar\Middleware;

use Royalcms\Component\Foundation\Royalcms;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class Stack implements HttpKernelInterface
{
    /** @var \Symfony\Component\HttpKernel\HttpKernelInterface $kernel */
    protected $kernel;
    /** @var \Royalcms\Component\Foundation\Royalcms $royalcms */
    protected $royalcms;

    /**
     * Create a new debugbar middleware instance
     * @param \Symfony\Component\HttpKernel\HttpKernelInterface $kernel
     * @param \Royalcms\Component\Foundation\Royalcms $royalcms
     */
    public function __construct(HttpKernelInterface $kernel, Royalcms $royalcms)
    {
        $this->kernel = $kernel;
        $this->royalcms = $royalcms;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        /** 
         * @var \Barryvdh\Debugbar\RoyalcmsDebugbar $debugbar 
         */
        $debugbar = $this->royalcms['debugbar'];

        /** 
         * @var \Royalcms\Component\Http\Response $response
         */
        $response = $this->kernel->handle($request, $type, $catch);
        
        return $debugbar->modifyResponse($request, $response);
    }
}
