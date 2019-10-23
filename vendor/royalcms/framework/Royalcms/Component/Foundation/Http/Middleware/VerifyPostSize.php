<?php

namespace Royalcms\Component\Foundation\Http\Middleware;

use Closure;
use Royalcms\Component\Http\Exception\PostTooLargeException;

class VerifyPostSize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Royalcms\Component\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Royalcms\Component\Http\Exception\PostTooLargeException
     */
    public function handle($request, Closure $next)
    {
        if ($request->server('CONTENT_LENGTH') > $this->getPostMaxSize()) {
            throw new PostTooLargeException;
        }

        return $next($request);
    }

    /**
     * Determine the server 'post_max_size' as bytes.
     *
     * @return int
     */
    protected function getPostMaxSize()
    {
        $postMaxSize = ini_get('post_max_size');

        switch (substr($postMaxSize, -1)) {
            case 'M':
            case 'm':
                return (int) $postMaxSize * 1048576;
            case 'K':
            case 'k':
                return (int) $postMaxSize * 1024;
            case 'G':
            case 'g':
                return (int) $postMaxSize * 1073741824;
        }

        return (int) $postMaxSize;
    }
}
