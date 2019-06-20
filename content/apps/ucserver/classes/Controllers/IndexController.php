<?php

namespace Ecjia\App\Ucserver\Controllers;

use Ecjia\App\Ucserver\Server\ApiManager;
use Ecjia\System\BaseController\BasicController;

class IndexController extends BasicController
{

    public function __construct()
    {
        parent::__construct();
    }

    
    public function init()
    {
        $request = royalcms('request');
        $response = with(new ApiManager($request))->handleRequest();

        royalcms()->instance('response', $response);
        return $response;
    }
    

}
