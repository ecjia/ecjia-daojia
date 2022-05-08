<?php

namespace Royalcms\Component\App\Commands;

use Royalcms\Component\Console\Command;

class AppPackageScanerCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'package:app-scaner';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scanning the cached app package manifest';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $app = $this->getRoyalcms()->make('app');

        $loader = $app->getApplicationLoader();
        $loader->scanningAppsToCache();

        $this->info('App Package scanning generated successfully.');
    }
}
