<?php

namespace Royalcms\Component\DefaultRoute;

use Royalcms\Component\Routing\Controller;

class DefaultRouteController extends Controller
{
    use DefaultRouteTrait;
    
    public function init()
    {
        return "Hello Default Route.";
    }
    
    public function defaultAction()
    {
        return "Hello Default Route.";
    }
    
}
