<?php


namespace Ecjia\Kernel\Exceptions\Renders;


use ErrorException;
use RC_Logger;
use RC_Request;
use Royalcms\Component\Exception\ExceptionRenderInterface;

class ErrorExceptionRender implements ExceptionRenderInterface
{

    public function __invoke(ErrorException $exception, $code, $fromConsole)
    {

        $err = array(
            'file'      => $exception->getFile(),
            'line'      => $exception->getLine(),
            'code'      => $exception->getCode(),
            'url'       => RC_Request::fullUrl(),
        );

        RC_Logger::getLogger(RC_Logger::LOG_ERROR)->error($exception->getMessage(), $err);
        royalcms('sentry')->captureException($exception);

    }

}