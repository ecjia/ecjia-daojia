<?php


namespace Ecjia\Kernel\Exceptions\Renders;


use RC_Logger;
use RC_Request;
use Royalcms\Component\Exception\ExceptionRenderInterface;

class NotFoundHttpExceptionRender implements ExceptionRenderInterface
{

    public function __invoke(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $exception, $code, $fromConsole)
    {
        $err = array(
            'file'      => $exception->getFile(),
            'line'      => $exception->getLine(),
            'code'      => $exception->getCode(),
            'url'       => RC_Request::fullUrl(),
        );

        RC_Logger::getLogger(RC_Logger::LOG_ERROR)->error($exception->getMessage(), $err);
        royalcms('sentry')->captureException($exception);
        //404 tips
        _404($exception->getMessage());
    }

}