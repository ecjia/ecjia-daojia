<?php

namespace Royalcms\Component\Cron\Commands;

use Royalcms\Component\Console\Command;
use Royalcms\Component\Cron\Cron;
use Royalcms\Component\Cron\Events\CronCollectJobsEvent;
use RC_Event;

class RunCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'cron:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Cron jobs';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        // Fire event before the Cron jobs will be executed
        $runDate = new \DateTime();
        RC_Event::dispatch(new CronCollectJobsEvent($runDate->getTimestamp()));

        $report = Cron::run();

        if ($report['inTime'] === -1) {
            $inTime = -1;
        } else if ($report['inTime']) {
            $inTime = 'true';
        } else {
            $inTime = 'false';
        }

        // Create table.
        $table = new \Symfony\Component\Console\Helper\Table($this->getOutput());
        $table
            ->setHeaders(array('Run date', 'In time', 'Run time', 'Errors', 'Jobs'))
            ->setRows(array(
                array(
                    $report['rundate'], $inTime, round($report['runtime'], 4),
                    $report['errors'],
                    count($report['crons'])
                )
            ));

        // Output table.
        $table->render($this->getOutput());
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array();
    }

}
