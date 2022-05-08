<?php

namespace Ecjia\Kernel\Http\Controllers;


class HealthCheckController
{

    public function liveness()
    {
        return 'ok';
    }

    public function readiness()
    {
        return 'ok';
    }

}