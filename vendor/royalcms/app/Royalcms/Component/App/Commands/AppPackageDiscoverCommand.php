<?php

namespace Royalcms\Component\App\Commands;

use Royalcms\Component\App\AppPackageManifest;
use Royalcms\Component\Console\Command;

class AppPackageDiscoverCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'package:app-discover';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rebuild the cached app package manifest';

    /**
     * Execute the console command.
     *
     * @param  \Royalcms\Component\App\AppPackageManifest  $manifest
     * @return void
     */
    public function handle(AppPackageManifest $manifest)
    {
        $this->call('package:app-scaner');

        $manifest->build();

        foreach (array_keys($manifest->manifest) as $package) {
            $this->line("Discovered App Package: <info>{$package}</info>");
        }

        $this->info('App Package manifest generated successfully.');
    }
}
