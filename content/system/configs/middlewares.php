<?php

return [
    \Ecjia\System\Middleware\DebugDisplayQueryMiddleware::class,
//    \Ecjia\System\Middleware\XFrameOptionsMiddleware::class,
    \Ecjia\System\Middleware\XXSSProtectionMiddleware::class,
    \Ecjia\System\Middleware\AdminCheckLoginRequest::class,
];