<?php

namespace Royalcms\Component\Foundation\Console;

use Royalcms\Component\Console\Command;

class OptimizeCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache the framework bootstrap files';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('config:cache');
        $this->call('route:cache');

        $this->info('Files cached successfully!');
    }
}
