<?php


namespace Ecjia\App\Cron\Controllers;


use Ecjia\System\BaseController\BasicController;
use Ecjia\App\Cron\CronRun;

class IndexController extends BasicController
{

    public function init()
    {
        try {
            CronRun::run();
            return response('ECJia cron job running...');
        } catch (\Exception $exception) {
            return response($exception->getMessage(), 500);
        }
    }

}