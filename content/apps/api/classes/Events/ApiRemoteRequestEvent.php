<?php

namespace Ecjia\App\Api\Events;

use Ecjia\App\Api\BaseControllers\EcjiaApi;

class ApiRemoteRequestEvent
{

    /**
     * @var EcjiaApi
     */
    public $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;
    }

}