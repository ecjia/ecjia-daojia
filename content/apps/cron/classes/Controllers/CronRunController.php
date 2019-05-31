<?php


namespace Ecjia\App\Cron\Controllers;


use Ecjia\System\BaseController\BasicController;
use Ecjia\App\Cron\CronRun;

class CronRunController extends BasicController
{

    public function init()
    {
        (new CronRun())->run();
    }

}