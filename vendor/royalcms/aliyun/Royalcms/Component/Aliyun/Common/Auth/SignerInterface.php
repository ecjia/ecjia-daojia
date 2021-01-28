<?php

namespace Royalcms\Component\Aliyun\Common\Auth;

use Royalcms\Component\Aliyun\Common\Communication\HttpRequest;

interface SignerInterface {
    public function sign(HttpRequest $request, array $credentials);
}
