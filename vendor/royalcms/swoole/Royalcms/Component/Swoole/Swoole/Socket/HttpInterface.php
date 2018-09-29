<?php

namespace Royalcms\Component\Swoole\Swoole\Socket;

interface HttpInterface
{
    public function onRequest(\swoole_http_request $request, \swoole_http_response $response);
}