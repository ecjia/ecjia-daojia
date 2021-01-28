<?php

namespace Royalcms\Component\Foundation\Console;

use Royalcms\Component\Console\Command;

class ClearCompiledCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'clear-compiled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove the compiled class file';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $compiledPath = $this->royalcms->getCachedCompilePath();
        $servicesPath = $this->royalcms->getCachedServicesPath();
        $packagePath = $this->royalcms->getCachedPackagesPath();
        $appPackagePath = $this->royalcms->getCachedAppPackagesPath();

        if (file_exists($compiledPath)) {
            @unlink($compiledPath);
        }

        if (file_exists($servicesPath)) {
            @unlink($servicesPath);
        }

        if (file_exists($packagePath)) {
            @unlink($packagePath);
        }

        if (file_exists($appPackagePath)) {
            @unlink($appPackagePath);
        }
    }
}
