<?php

namespace Royalcms\Component\Foundation\Console;

use Royalcms\Component\Console\Command;

class OptimizeClearCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'optimize:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove the cached bootstrap files';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('view:clear');
        $this->call('cache:clear');
        $this->call('route:clear');
        $this->call('config:clear');
        $this->call('clear-compiled');

        $this->info('Caches cleared successfully!');
    }
}
