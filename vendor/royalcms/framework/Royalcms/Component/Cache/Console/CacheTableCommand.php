<?php

namespace Royalcms\Component\Cache\Console;

use Royalcms\Component\Console\Command;
use Royalcms\Component\Foundation\Composer;
use Royalcms\Component\Filesystem\Filesystem;

class CacheTableCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'cache:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a migration for the cache database table';

    /**
     * The filesystem instance.
     *
     * @var \Royalcms\Component\Filesystem\Filesystem
     */
    protected $files;

    /**
     * @var \Royalcms\Component\Foundation\Composer
     */
    protected $composer;

    /**
     * Create a new cache table command instance.
     *
     * @param  \Royalcms\Component\Filesystem\Filesystem  $files
     * @param  \Royalcms\Component\Foundation\Composer  $composer
     * @return void
     */
    public function __construct(Filesystem $files, Composer $composer)
    {
        parent::__construct();

        $this->files = $files;
        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $fullPath = $this->createBaseMigration();

        $this->files->put($fullPath, $this->files->get(__DIR__.'/stubs/cache.stub'));

        $this->info('Migration created successfully!');

        $this->composer->dumpAutoloads();
    }

    /**
     * Create a base migration file for the table.
     *
     * @return string
     */
    protected function createBaseMigration()
    {
        $name = 'create_cache_table';

        $path = $this->royalcms->databasePath().'/migrations';

        return $this->royalcms['migration.creator']->create($name, $path);
    }
}
