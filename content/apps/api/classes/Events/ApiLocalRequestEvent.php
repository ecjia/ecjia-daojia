<?php

namespace Ecjia\App\Api\Events;

class ApiLocalRequestEvent
{

    public $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;
    }

}