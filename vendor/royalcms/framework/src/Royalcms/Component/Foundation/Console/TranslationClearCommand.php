<?php

namespace Royalcms\Component\Foundation\Console;

use Royalcms\Component\Console\Command;
use Royalcms\Component\Filesystem\Filesystem;

class TranslationClearCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'trans:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove the Translation cache file';

    /**
     * The filesystem instance.
     *
     * @var \Royalcms\Component\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new config clear command instance.
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
        $this->files->delete($this->royalcms->getCachedTranslationPath());

        $this->info('Translation cache cleared!');
    }
}
