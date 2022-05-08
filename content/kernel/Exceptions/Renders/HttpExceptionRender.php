<?php


namespace Ecjia\Kernel\Exceptions\Renders;


use RC_Hook;
use RC_Logger;
use RC_Request;
use Royalcms\Component\Exception\ExceptionRenderInterface;

class HttpExceptionRender implements ExceptionRenderInterface
{

    public function __invoke(\Symfony\Component\HttpKernel\Exception\HttpException $exception, $code, $fromConsole)
    {
        $err = array(
            'file'      => $exception->getFile(),
            'line'      => $exception->getLine(),
            'code'      => $exception->getCode(),
            'url'       => RC_Request::fullUrl(),
        );

        RC_Logger::getLogger(RC_Logger::LOG_ERROR)->error($exception->getMessage(), $err);
        royalcms('sentry')->captureException($exception);

        $handle = sprintf("handle_%d_error", $code);
        if (RC_Hook::has_action($handle)) {
            RC_Hook::do_action($handle, $exception);
        }
        else {
            //4xx tips
            rc_die($exception->getMessage());
        }
    }
}