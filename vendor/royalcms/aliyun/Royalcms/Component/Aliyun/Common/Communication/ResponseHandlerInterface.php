<?php

namespace Royalcms\Component\Aliyun\Common\Communication;

interface ResponseHandlerInterface {
    public function handle(HttpResponse $response);
}
