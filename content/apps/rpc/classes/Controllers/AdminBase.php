<?php


namespace Ecjia\App\Rpc\Controllers;


use Ecjia\System\BaseController\EcjiaAdminController;

class AdminBase extends EcjiaAdminController
{
    protected $__FILE__;

    public function __construct()
    {
        parent::__construct();

        $this->__FILE__ = dirname(dirname(__FILE__));

    }
}