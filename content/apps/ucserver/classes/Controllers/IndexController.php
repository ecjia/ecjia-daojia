<?php

namespace Ecjia\App\Ucserver\Controllers;

use Ecjia\App\Ucserver\Server\ApiManager;
use Royalcms\Component\Routing\Controller as RoyalcmsController;

class IndexController extends RoyalcmsController
{

    public function __construct()
    {

    }

    
    public function init()
    {
        $request = royalcms('request');
        $response = with(new ApiManager($request))->handleRequest();

        royalcms()->instance('response', $response);
        return $response;
    }
    

}
