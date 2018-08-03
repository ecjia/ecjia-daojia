<?php

namespace Royalcms\Component\Swoole\Socket;

use Swoole\Http\Request;
use Swoole\Http\Response;

interface HttpInterface
{
    public function onRequest(Request $request, Response $response);
}