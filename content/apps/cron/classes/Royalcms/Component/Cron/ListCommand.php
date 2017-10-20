<?php

namespace Royalcms\Component\Cron;

use Royalcms\Component\Console\Command;

class ListCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'cron:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List Cron jobs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire() {
        // Get the current timestamp and fire the collect event
        $runDate = new \DateTime();
        \RC_Event::fire('cron.collectJobs', array($runDate->getTimestamp()));
        // Get all registered Cron jobs
        $jobs = Cron::getCronJobs();

        // Create the table helper with headers.
        $table = $this->getHelperSet()->get('table');
        $table->setHeaders(array('Jobname', 'Expression', 'Activated'));

        // Run through all registered jobs
        for ($i = 0; $i < count($jobs); $i++) {

            // Get current job entry
            $job = $jobs[$i];

            // If job is enabled or disable use the defined string instead of 1 or 0
            $enabled = $job['enabled'] ? 'Enabled' : 'Disabled';

            // Add this job to the table.
            $table->addRow(array($job['name'], $job['expression']->getExpression(), $enabled));
        }

        // Render and output the table.
        $table->render($this->getOutput());
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments() {
        return array();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions() {
        return array();
    }

}
