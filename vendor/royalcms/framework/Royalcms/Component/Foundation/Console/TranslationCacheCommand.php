<?php

namespace Royalcms\Component\Foundation\Console;

use Royalcms\Component\Console\Command;
use Royalcms\Component\Filesystem\Filesystem;

class TranslationCacheCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'trans:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a cache file for faster translation loading';

    /**
     * The filesystem instance.
     *
     * @var \Royalcms\Component\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new config cache command instance.
     *
     * @param  \Royalcms\Component\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->call('trans:clear');

        $languages = $this->getFreshTranslation();

        $locale = config('system.locale');

        $this->files->put(
            $this->royalcms->getCachedTranslationPath($locale), '<?php return '.var_export($languages, true).';'.PHP_EOL
        );

        $this->info('Translation cached successfully!');
    }

    /**
     * Boot a fresh copy of the application configuration.
     *
     * @return array
     */
    protected function getFreshTranslation()
    {
        $royalcms = require $this->royalcms->bootstrapPath().'/royalcms.php';

        $royalcms->make('Royalcms\Component\Contracts\Console\Kernel')->bootstrap();

        return $royalcms['translator']->all();
    }
}
