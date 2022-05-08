<?php

return [
    //前置
    \Ecjia\App\Api\Middleware\ApiSignatureCheckMiddleware::class, //API签名校验
    \Ecjia\App\Api\Middleware\ApiHasFilterHookMiddleware::class, //API hook拦截器

    //后置
//    \Ecjia\App\Api\Middleware\ApiErrorTextDisplayMiddleware::class, //错误直接输入
    \Ecjia\App\Api\Middleware\TestDumpJobMiddleware::class,

];